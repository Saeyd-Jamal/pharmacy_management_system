<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 pt-4">
                <h1 class="card-title h3">{{ isset($btn_label) ? 'تعديل المورد : ' . $suppliers->name : 'إضافة مورد جديد' }}</h1>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.input label="اسم المورد *" :value="$suppliers->name" name="name" required autofocus />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input type="email" label="الإيميل (إختياري)" :value="$suppliers->email" name="email" placeholder="example@gmail.com" />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="رقم الهاتف (إختياري)" :value="$suppliers->phone_number" name="phone_number" />
                    </div> 
                    <div class="mb-4 col-md-6">
                        <x-form.input label="العنوان (إختياري)" :value="$suppliers->address" name="address" />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="مندوب التواصل (إختياري)" :value="$suppliers->contact_person" name="contact_person" />
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
