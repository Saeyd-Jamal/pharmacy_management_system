<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- Account -->
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Name" :value="$suppliers->name" name="name" required autofocus />
                    </div>
                    
                    <div class="mb-4 col-md-6">
                        <x-form.input type="email" label="Email" :value="$suppliers->email" name="email"
                            placeholder="example@gmail.com" />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="Phone" :value="$suppliers->phone_number" name="phone_number" required autofocus />
                    </div> 
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Address" :value="$suppliers->address" name="address" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="Contact Person" :value="$suppliers->contact_person" name="contact_person" required autofocus />
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
