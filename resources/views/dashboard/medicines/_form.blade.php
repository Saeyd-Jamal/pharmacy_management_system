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
                        <x-form.input type="number" min="0" label="الكمية" :value="$medicine->quantity" name="quantity" required/>
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" step="0.01" min="0" label="سعر الوحدة" :value="$medicine->unit_price" name="unit_price" required />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" step="0.01" min="0" label="السعر النهائي" :value="$medicine->price" name="price" required />
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
@endpush
