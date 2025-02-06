@if ($errors->any())
<div class="alert alert-danger">
    <h3> Ooops Error</h3>
    <ul>
        @foreach ($errors->all() as $error )
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- Account -->
            <div class="card-body pt-4">
                <div class="row">
                    <!-- <h3>{{ isset($btn_label) ? "تعديل منتج " . $medicines->name : "اضافة منتج" }}</h3> -->
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Name" :value="$medicines->name" name="name" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control" />
                        @if ($medicines->image) <!-- تأكد من أن المتغير صحيح -->
                        <img src="{{ asset('storage/' . $medicines->image) }}" alt="Current Image" height="60">
                        @endif
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="Description" :value="$medicines->description" name="description" required autofocus />
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="Price" :value="$medicines->price" name="price" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="Unit Price" :value="$medicines->unit_price" name="unit_price" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="Stock Quantity" :value="$medicines->stock_quantity" name="stock_quantity" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="Explry Date" :value="$medicines->explry_date" name="explry_date" required autofocus />
                    </div>
                   
                   

                    <div class="mb-4 col-md-6">
    <x-form.select 
        label="Category" 
        :value="$medicines->category_id" 
        name="category_id" 
        :options="$categories->pluck('id', 'id')" 
    />
</div>


                    <!-- <div class="mb-4 col-md-6">
                        <x-form.select label="Supplier" :value="$medicines->supplier_id" name="supplier_id" :options="$suppliers" />
                    </div> -->

                    <div class="mb-4 col-md-6">
    <x-form.select 
        label="Supplier" 
        :value="$medicines->supplier_id" 
        name="supplier_id" 
        :options="$suppliers->pluck('id', 'id')" 
    />
</div>





                    <div class="mb-4 col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-active" value="1" @checked(old('status', $medicines->status) == 'active' || old('status', $medicines->status) == null)>
                                <label class="form-check-label" for="status-active">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-inactive" value="0" @checked(old('status', $medicines->status) == 'archived')>
                                <label class="form-check-label" for="status-inactive">Archived</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
               

                

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-3">
                        {{ $btn_label ?? 'Add' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


