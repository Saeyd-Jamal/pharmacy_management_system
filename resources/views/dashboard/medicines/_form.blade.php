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
                    <div class="mb-4 col-md-4">
                        <x-form.input label="الاسم" :value="$medicine->name" name="name" required autofocus />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.select label="الصنف" :value="$medicine->category_id" name="category_id" :optionsId="$categories" required />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.select label="المورد" :value="$medicine->supplier_id" name="supplier_id" :optionsId="$suppliers" required />
                    </div>
                   
                   
                   
                    <div class="mb-4 col-md-4">
                        <x-form.input label="تاريخ الإنتاج" type="date" :value="$medicine->production_date" name="production_date" required />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input label="تاريخ الإنتهاء" type="date" :value="$medicine->explry_date" name="explry_date" required />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.select label="الحالة" :value="$medicine->status ?? 'نشط'" name="status" :options="['نشط', 'موقوف']"/>
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="file" label="الصورة" name="imageFile" />
                        @if ($medicine->image)
                            <img src="{{ asset('storage/' . $medicine->image) }}" alt="Current Image" height="60">
                        @endif
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input label="الوصف" :value="$medicine->description" name="description" />
                    </div>
                    <div class="mb-4 col-md-4">
                        <label for="qr_code" class="form-label mb-2">مسح qr</label>
                        <div class="input-group">
                            <button class="btn btn-outline-primary waves-effect" type="button" id="scan-btn">
                                <i class="fa fa-qrcode"></i>
                            </button>
                            <x-form.input :value="$medicine->qr_code" name="qr_code" readonly  aria-label="Example text with button addon" aria-describedby="scan-btn" />
                        </div>
                    </div>



                    <!-- قسم أحجام الأدوية -->
                    <div class="mb-4 col-md-12">
                        <h4>أحجام الأدوية</h4>
                        <div id="sizes-container">
                            @if (isset($medicine->sizes) && count($medicine->sizes) > 0)
                                @foreach ($medicine->sizes as $index => $size)
                                    <div class="size-row mb-3">
                                        <input type="text" name="sizes[{{ $index }}][size]" placeholder="الحجم (شريط، كرتونة، إلخ)" value="{{ $size->size }}" required>
                                        <input type="number" step="0.01" name="sizes[{{ $index }}][price]" placeholder="السعر" value="{{ $size->price }}" required>
                                        <input type="number" name="sizes[{{ $index }}][quantity]" placeholder="الكمية" value="{{ $size->quantity }}" required>
                                        <button type="button" class="btn btn-danger remove-size">حذف</button>
                                    </div>
                                @endforeach
                            @else
                                <div class="size-row mb-3">
                                    <input type="text" name="sizes[0][size]" placeholder="الحجم (شريط، كرتونة، إلخ)" required>
                                    <input type="number" step="0.01" name="sizes[0][price]" placeholder="السعر" required>
                                    <input type="number" name="sizes[0][quantity]" placeholder="الكمية" required>
                                    <button type="button" class="btn btn-danger remove-size">حذف</button>
                                </div>
                            @endif
                        </div>
                        <button type="button" id="add-size" class="btn btn-primary">إضافة حجم</button>
                    </div>
                </div>



                </div>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-3">
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
            $('#production_date').on('change', function () {
                // تحديد ان تاريخ الإنتهاء لا يمكن ان يكون اقل من تاريخ الإنتاج
                $('#explry_date').attr('min', $(this).val());

                // حساب تاريخ الانتهاء بزيادة سنيتن من تاريخ الانتاج
                let productionDate = new Date($(this).val());
                let expiryDate = new Date(productionDate.setFullYear(productionDate.getFullYear() + 2));
                $('#explry_date').val(expiryDate.toISOString().split('T')[0]).attr('min', $(this).val());
            });
            $('#scan-btn').click(function() {
                // هنا ستستخدم كاميرا الهاتف لمسح QR Code
                // يتم إدخال القيمة الممسوحة في الحقل

                // هذه المحاكاة لمسح QR بواسطة الهاتف أو جهاز ماسح QR يدوي
                var scannedQrCode = prompt("Scan the QR code value");  // محاكاة المسح

                if (scannedQrCode) {
                    $('#qr_code').val(scannedQrCode);  // إدخال القيمة الممسوحة في الحقل
                }
            });
        })
    </script>

<script>
        $(document).ready(function () {
            // إضافة حجم جديد
            $('#add-size').click(function () {
                const container = $('#sizes-container');
                const index = container.children().length;
                const newRow = `
                    <div class="size-row mb-3">
                        <input type="text" name="sizes[${index}][size]" placeholder="الحجم (شريط، كرتونة، إلخ)" required>
                        <input type="number" step="0.01" name="sizes[${index}][price]" placeholder="السعر" required>
                        <input type="number" name="sizes[${index}][quantity]" placeholder="الكمية" required>
                        <button type="button" class="btn btn-danger remove-size">حذف</button>
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
                var scannedQrCode = prompt("Scan the QR code value");
                if (scannedQrCode) {
                    $('#qr_code').val(scannedQrCode);
                }
            });
        });
    </script>
@endpush
