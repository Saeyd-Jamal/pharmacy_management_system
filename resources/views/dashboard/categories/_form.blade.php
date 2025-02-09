<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0 pt-4">
                <h1 class="card-title h3">{{ isset($btn_label) ? 'تعديل الصنف : ' . $category->name : 'إضافة صنف جديد' }}</h1>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.input label="اسم الصنف" :value="$category->name" name="name" required autofocus />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input type="file" label="الصورة" :value="$category->image" name="imageFile" />
                        @if ($category->image) <!-- تأكد من أن المتغير صحيح -->
                            <img src="{{ asset('storage/' . $category->image) }}" alt="Current Image" height="60">
                        @endif
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.textarea label="وصف المنتج" :value="$category->description" name="description" />
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
