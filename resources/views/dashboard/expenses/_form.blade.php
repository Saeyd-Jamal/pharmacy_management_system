<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 pt-4">
                <h1 class="card-title h3">{{ isset($btn_label) ? 'تعديل الصنف : ' . $expense->name : 'إضافة مصروفات جديدة' }}</h1>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.input label="تاريخ الإنتاج" type="date" :value="$expense->date" name="date" required />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="المبلغ المدفوع" type="number" :value="$expense->amount" name="amount" required />
                    </div>
                </div>
                
                <div class="row">
                    <div class="mb-4 col-md-12">
                        <x-form.textarea label="وصف" :value="$expense->notes" name="notes" />
                    </div>
                </div>
                
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.select label="نوع المصروف" :value="$expense->type" name="type" :options="['يومية', 'شهرية']"/>
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.select label="فئة المصروف" :value="$expense->category" name="category" :options="['راتب', 'مستلزمات','إيجار','فواتير']"/>
                    </div>
                </div>
                
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.select label="حالة الدفع" :value="$expense->payment_status" name="payment_status" :options="['غير مدفوع', 'مدفوع']"/>
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.select label="طريقة الدفع" :value="$expense->payment_method" name="payment_method" :options="['نقدا', 'تحويل بنكي','بطاقة ائتمان']"/>
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
