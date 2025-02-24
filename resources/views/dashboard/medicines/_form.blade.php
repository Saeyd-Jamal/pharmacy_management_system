@if ($errors->any())
    <div class="alert alert-danger">
        <h3> Ooops Error</h3>
        <ul>
            @foreach ($errors->all() as $key => $error)
                <li>{{ $key + 1 }} - {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 pt-4">
                <h1 class="card-title h3">{{ isset($btn_label) ? 'تعديل الدواء : ' . $medicine->name : 'إضافة دواء جديد' }}</h1>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-3">
                        <x-form.input label="الاسم" :value="$medicine->name" name="name" required autofocus />
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.select label="الصنف" :value="$medicine->category_id" name="category_id" :optionsId="$categories" required />
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.select label="المورد" :value="$medicine->supplier_id" name="supplier_id" :optionsId="$suppliers" required />
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.select label="الحالة" :value="$medicine->status ?? 'نشط'" name="status" :options="['نشط', 'موقوف']"/>
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.input label="تاريخ الإنتاج" type="date" :value="$medicine->production_date" name="production_date" required />
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.input label="تاريخ الإنتهاء" type="date" :value="$medicine->explry_date" name="explry_date" required />
                    </div>
                    <div class="mb-4 col-md-3">
                        <label for="qr_code" class="form-label mb-2">مسح qr</label>
                        <div class="input-group">
                            <button class="btn btn-outline-primary waves-effect" type="button" id="scan-btn">
                                <i class="fa fa-qrcode"></i>
                            </button>
                            <x-form.input :value="$medicine->qr_code" name="qr_code"  aria-label="Example text with button addon" aria-describedby="scan-btn" />
                        </div>
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.input label="الوصف" :value="$medicine->description" name="description" />
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.input type="file" label="الصورة" name="imageFile" />
                        @if ($medicine->image)
                            <img src="{{ asset('storage/' . $medicine->image) }}" alt="Current Image" height="60">
                        @endif
                    </div>
                    <!-- قسم أحجام الأدوية -->
                    <div class="mb-4 col-md-12">
                        <h4>أحجام الأدوية</h4>
                        <div id="sizes-container">
                            @if (isset($medicine->sizes) && count($medicine->sizes) > 0)
                                @foreach ($medicine->sizes as $index => $size)
                                    <div class="size-row row mb-4 align-items-center">
                                        <div class="row col-11">
                                            <div class="mb-4 col-md-3">
                                                <x-form.select label="الحجم" :value="$size->size" name="sizes[{{ $index }}][size]" :options="['كرتونة','شريط','حبة']" required />
                                            </div>
                                            <div class="mb-4 col-md-3">
                                                <x-form.input type="number" min='0' label="الكمية" :value="$size->quantity" name="sizes[{{ $index }}][quantity]" required />
                                            </div>
                                            <div class="mb-4 col-md-3">
                                                <x-form.input type="number" min='0' step="0.01" label="السعر الأساسي" :value="$size->basic_price" name="sizes[{{ $index }}][basic_price]" required />
                                            </div>
                                            <div class="mb-4 col-md-3">
                                                <x-form.input type="number" min='0' step="0.01" label="سعر بيع" :value="$size->sale_price" name="sizes[{{ $index }}][sale_price]" required />
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-size ms-2 col-1 p-2">حذف</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="size-row row  mb-4 align-items-center">
                                    <div class="row col-11">
                                        <div class="mb-4 col-md-3">
                                            <x-form.select label="الحجم" value="كرتونة" name="sizes[0][size]" :options="['كرتونة','شريط','حبة']" required />
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <x-form.input type="number" min='0' label="الكمية" name="sizes[0][quantity]" required />
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <x-form.input type="number" min='0' step="0.01" label="السعر الأساسي" name="sizes[0][basic_price]" required />
                                        </div>
                                        <div class="mb-4 col-md-3">
                                            <x-form.input type="number" min='0' step="0.01" label="سعر بيع" name="sizes[0][sale_price]" required />
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger remove-size ms-2 col-1 p-2">حذف</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-size" class="btn btn-primary">إضافة حجم</button>
                    </div>
                </div>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary m-2">
                        {{ $btn_label ?? 'إضافة' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function () {
        // إضافة حجم جديد
        $('#add-size').click(function () {
            let container = $('#sizes-container');
            let index = container.children().length;
            let newRow = `
                <div class="size-row row mb-4 align-items-center">
                    <div class="row col-11">
                        <div class="mb-4 col-md-3">
                            <x-form.select label="الحجم" name="sizes[${index}][size]" :options="['كرتونة','شريط','حبة']" required />
                        </div>
                        <div class="mb-4 col-md-3">
                            <x-form.input type="number" min='0' label="الكمية" name="sizes[${index}][quantity]" required />
                        </div>
                        <div class="mb-4 col-md-3">
                            <x-form.input type="number" min='0' step="0.01" label="السعر الأساسي" name="sizes[${index}][basic_price]" required />
                        </div>
                        <div class="mb-4 col-md-3">
                            <x-form.input type="number" min='0' step="0.01" label="سعر بيع" name="sizes[${index}][sale_price]" required />
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-size ms-2 col-1 p-2">حذف</button>
                </div>
            `;
            container.append(newRow);
        });

        // حذف حجم
        $(document).on('click', '.remove-size', function () {
            $(this).closest('.size-row').remove();
        });

        // باقي الكود الحالي
        $('#production_date').on('change', function () {
            $('#explry_date').attr('min', $(this).val());
            let productionDate = new Date($(this).val());
            let expiryDate = new Date(productionDate.setFullYear(productionDate.getFullYear() + 2));
            $('#explry_date').val(expiryDate.toISOString().split('T')[0]).attr('min', $(this).val());
        });

        $('#scan-btn').click(function() {
            $('#qr_code').focus();
        });
    });
</script>
@endpush
