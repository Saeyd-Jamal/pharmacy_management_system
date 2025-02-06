<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- Account -->
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Name" :value="$categories->name" name="name" required autofocus />
                    </div>
                    
                    <div class="mb-4 col-md-6">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control" />
                        @if ($categories->image) <!-- تأكد من أن المتغير صحيح -->
                        <img src="{{ asset('storage/' . $categories->image) }}" alt="Current Image" height="60">
                        @endif
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="Description" :value="$categories->description" name="description" required autofocus />
                    </div> 
                   

                   
                    
                    
                    
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-3">
                        {{ $btn_label ?? 'Add' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
