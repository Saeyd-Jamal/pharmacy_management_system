<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 pt-4">
                <h1 class="card-title h3">{{ isset($btn_label) ? 'تعديل مصروفات ' : 'إضافة مصروفات جديدة' }}</h1>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-3">
                        <x-form.select label="نوع المصروف" :value="$expense->type" name="type" :options="['يومية', 'شهرية']" required/>
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.select label="فئة المصروف" :value="$expense->category" name="category" :options="['راتب', 'مستلزمات','إيجار','فواتير']" required/>
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.select label="حالة الدفع" :value="$expense->payment_status ?? 'مدفوع'" name="payment_status" :options="['غير مدفوع', 'مدفوع']" required/>
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.select label="طريقة الدفع" :value="$expense->payment_method" name="payment_method" :options="['نقدا', 'تحويل بنكي','بطاقة ائتمان']" required/>
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.input label="تاريخ الإنتاج" type="date" :value="$expense->date" name="date" required />
                    </div>
                    <div class="mb-4 col-md-3">
                        <x-form.input label="المبلغ المدفوع" type="number" min="0" step="any" :value="$expense->amount" name="amount" required />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.textarea label="وصف" :value="$expense->notes" rows="1" name="notes" />
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
        $('#type').on('change', function () {
            if($(this).val() == 'يومية'){

            }
            if($(this).val() == 'شهرية'){
                
            }
        });
    });
</script>
@endpush
