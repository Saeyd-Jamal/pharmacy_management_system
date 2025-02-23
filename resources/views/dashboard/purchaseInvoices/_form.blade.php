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
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body invoice-preview-header rounded">
                <div class="d-flex flex-wrap flex-column flex-sm-row justify-content-between text-heading">
                    <div class="mb-md-0 mb-6">
                    <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
                        <div class="">
                            <img src="{{ asset('imgs/logo.png') }}" alt="" width="50">
                        </div>
                        <span class="app-brand-text fw-bold fs-4 ms-50">{{ isset($btn_label) ? 'تعديل فاتورة شراء': 'إضافة فاتورة شراء جديدة' }}</span>
                    </div>
                    </div>
                    <div class="col-md-5 col-8 pe-0 ps-0 ps-md-2">
                        <dl class="row mb-0">
                            <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                                <span class="h5 text-capitalize mb-0 text-nowrap">فاتورة</span>
                            </dt>
                            <dd class="col-sm-7">
                                <div class="input-group input-group-merge disabled">
                                    <span class="input-group-text">#</span>
                                    <x-form.input name="invoice_id" :value="$purchaseInvoice->id"  disabled />
                                </div>
                            </dd>
                            <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                                <span class="fw-normal">التاريخ:</span>
                            </dt>
                            <dd class="col-sm-7">
                                <x-form.input class="invoice-date flatpickr-input" type="date" placeholder="YYYY-MM-DD" :value="$purchaseInvoice->date" name="date" required />
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="card-header pb-0 pt-4">
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h4>الأدوية</h4>
                </div>
                <div class="row">
                    @foreach ($purchaseInvoice->medicines as $index => $item)
                        <div class="repeater-wrapper py-4" data-repeater-item=""  id="item-{{ $index }}">
                            <div class="d-flex  border border-primary rounded position-relative pe-0">
                                <div class="row w-100 p-6">
                                    <div class="col-md-4 col-12">
                                        <p class="h6 repeater-title">الدواء</p>
                                        <div class="input-group search-medicine" data-index="{{ $index }}">
                                            <span class="input-group-text" id="basic-addon11">
                                                <i class="ti ti-search"></i>
                                            </span>
                                            <x-form.input name="name[{{ $index }}]" id="name-{{ $index }}" :value="$item->name" placeholder="ابحث ...." required readonly/>
                                        </div>
                                    </div>
                                    <input type="hidden" name="medicine_id[{{ $index }}]" value="{{ $item->items->medicine_id }}" id="medicine_id-{{ $index }}" value="">
                                    <div class="col-md-3 col-12">
                                        <p class="h6 repeater-title">الكمية</p>
                                        <x-form.input type="number" min="0" class="quantity  invoice-item-qty" :value="$item->items->quantity" data-index="{{ $index }}" name="quantity[{{ $index }}]" id="quantity-{{ $index }}" required/>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <p class="h6 repeater-title">سعر الوحدة</p>
                                        <x-form.input type="number" min="0" class="unit_price invoice-item-price" :value="$item->items->unit_price" data-index="{{ $index }}" name="unit_price[{{ $index }}]" id="unit_price-{{ $index }}" required/>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <p class="h6 repeater-title">الاجمالي</p>
                                        <x-form.input type="number" min="0" class="total_price" name="total_price[{{ $index }}]" :value="$item->items->total_price" id="total_price-{{ $index }}" readonly/>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                    <i class="ti ti-x ti-lg cursor-pointer remove-item" data-repeater-delete="" data-index="{{ $index }}"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="item_count" id="item_count" value="{{ $purchaseInvoice->medicines->count() }}">
                <div class="row" id="items">

                </div>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="button" class="btn btn-success text-white" id="add-item">
                        <i class="fa-solid fa-plus"></i> اضافة
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-4">
                    <x-form.select label="المورد" :value="$purchaseInvoice->supplier_id" name="supplier_id" :optionsId="$suppliers" required />
                </div>
                <div class="mb-4">
                    <x-form.input type="number" min="0" label="الإجمالي" :value="$purchaseInvoice->total_amount" name="total_amount" readonly/>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary d-grid w-100 mb-4 waves-effect waves-light">
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-send ti-xs me-2"></i>{{ $btn_label ?? 'إضافة' }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="search-medicine-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">البحث على الدواء</h4>
                    <p>قم باختيار الدواء من القائمة</p>
                </div>
                <div class="row">
                    <div class="mb-4 col-md-12">
                        <label for="qr_code" class="form-label mb-2">اسم الدواء او المسح</label>
                        <x-form.input type="hidden" class="search_field" name="qr_code_search" readonly  aria-label="Example text with button addon" aria-describedby="scan-btn" />
                        <div class="input-group">
                            <x-form.input  name="name_search" class="search_field" data-field="name" placeholder="ابحث ...." />
                            <button class="btn btn-outline-primary waves-effect" type="button" id="scan-btn">
                                <i class="fa fa-qrcode"></i>
                            </button>
                            <button class="btn btn-outline-primary waves-effect" type="button" id="reset_search">
                                <i class="fa-solid fa-text-slash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.select label="الصنف" name="category_id_search" class="search_field" data-field="category_id" :optionsId="$categories" />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.select label="المورد" name="supplier_id_search" class="search_field" data-field="supplier_id" :optionsId="$suppliers" />
                    </div>
                </div>
                <hr>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-striped table-bordered">
                        <style>
                            th{
                                font-size: 18px !important;
                                font-weight: 600 !important;
                            }
                        </style>
                        <thead>
                            <tr>
                                <th class="d-flex align-items-center gap-2">
                                    <div class="avatar me-4">
                                        <i class="fa-solid fa-capsules fa-2x text-primary"></i>
                                    </div>
                                    <div class="me-2">
                                        <p class="mb-0 text-heading">اسم الدواء</p>
                                        <p class="small mb-0">اسم المورد</p>
                                    </div>
                                </th>
                                <th class="text-center">الكمية</th>
                                <th class="text-center">المبلغ</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="search-medicine-list">
                            @foreach ($medicines->take(5) as $medicine)
                            <tr class="cursor-pointer search-medicine-item" data-id="{{ $medicine->id }}" data-name="{{ $medicine->name }}" data-price="{{ $medicine->price }}" data-quantity="{{ $medicine->quantity }}">
                                <td class="d-flex align-items-center  flex-grow-1">
                                    <div class="avatar me-4">
                                        <i class="fa-solid fa-capsules fa-2x text-primary"></i>
                                    </div>
                                    <div class="me-2">
                                        <p class="mb-0 text-heading">{{ $medicine->name }}</p>
                                        <p class="small mb-0">{{ $medicine->supplier->name }}</p>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span id="quantity_search_0" class="btn btn-info me-2">{{ $medicine->quantity }}</span>
                                </td>
                                <td class="text-center">
                                    <span id="price_search_0" class="btn btn-primary">{{ $medicine->price }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

    <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
    <script>
        $(document).ready(function () {
            // المعادلات
            $(document).on('input', '.quantity, .unit_price', function () {
                let index = $(this).data('index');
                let quantity = parseFloat($('#quantity-' + index).val()) || 0;
                let unit_price = parseFloat($('#unit_price-' + index).val()) || 0;
                let total_price = quantity * unit_price;
                $('#total_price-' + index).val(total_price);
                let total_amount = 0;
                $('.total_price').each(function () {
                    total_amount += parseFloat($(this).val()) || 0;
                });
                $('#total_amount').val(total_amount);
            });

            let indexMedicine = 0;
            $(document).on('click', '.search-medicine', function () {
                let index = $(this).data('index');
                indexMedicine = index;
                $('#search-medicine-modal').modal('show');
            })

            $(document).on('input', '.search_field', function () {
                $.ajax({
                    url : '{{ route("dashboard.medicines.search") }}',
                    method : 'get',
                    data :{
                        name : $('#name_search').val(),
                        category_id : $('#category_id_search').val(),
                        supplier_id : $('#supplier_id_search').val(),
                        qr_code : $('#qr_code_search').val(),
                    },
                    success : function (response) {
                        console.log(response,$('#qr_code_search').val());
                        $('#search-medicine-list').empty();
                        $.each(response, function (index, value) {
                            $('#search-medicine-list').append(`
                                <tr class="cursor-pointer search-medicine-item" data-id="${value.id}" data-name="${value.name}" data-price="${value.price}" data-quantity="${value.quantity}">
                                    <td class="d-flex align-items-center  flex-grow-1">
                                        <div class="avatar me-4">
                                            <i class="fa-solid fa-capsules fa-2x text-primary"></i>
                                        </div>
                                        <div class="me-2">
                                            <p class="mb-0 text-heading">${value.name}</p>
                                            <p class="small mb-0">${value.supplier.name}</p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span id="quantity_search_${value.id}" class="btn btn-info me-2">${value.quantity}</span>
                                    </td>
                                    <td class="text-center">
                                        <span id="price_search_${value.id}" class="btn btn-primary">${value.price}</span>
                                    </td>
                                </tr>
                            `);
                        });
                    },
                    error : function (error) {
                        console.log(error);
                    }
                });
            });

            $(document).on('click', '.search-medicine-item', function () {
                let index = indexMedicine;
                console.log(index,$(this).data('id'));
                $('#medicine_id-' + index).val($(this).data('id'));
                $('#name-' + index).val($(this).data('name'));
                $('#quantity-' + index).attr('max', $(this).data('quantity'));
                $('#unit_price-' + index).val($(this).data('price'));
                $('#search-medicine-modal').modal('hide');
            });

            let item_count = $('#item_count').val();
            $('#add-item').on('click', function () {
                let index = $('#items').children().length;
                let item =
                    `<div class="repeater-wrapper py-4" data-repeater-item=""  id="item-${index}">
                        <div class="d-flex  border border-primary rounded position-relative pe-0">
                            <div class="row w-100 p-6">
                                <div class="col-md-4 col-12">
                                    <p class="h6 repeater-title">الدواء</p>
                                    <div class="input-group search-medicine" data-index="${index}">
                                        <span class="input-group-text" id="basic-addon11">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <x-form.input name="name[${index}]" id="name-${index}" placeholder="ابحث ...." required readonly/>
                                    </div>
                                </div>
                                <input type="hidden" name="medicine_id[${index}]" id="medicine_id-${index}" value="">
                                <div class="col-md-3 col-12">
                                    <p class="h6 repeater-title">الكمية</p>
                                    <x-form.input type="number" min="0" class="quantity  invoice-item-qty" data-index="${index}" name="quantity[${index}]" id="quantity-${index}" required/>
                                </div>
                                <div class="col-md-3 col-12">
                                    <p class="h6 repeater-title">سعر الوحدة</p>
                                    <x-form.input type="number" min="0" class="unit_price invoice-item-price" data-index="${index}" name="unit_price[${index}]" id="unit_price-${index}" required/>
                                </div>
                                <div class="col-md-2 col-12">
                                    <p class="h6 repeater-title">الاجمالي</p>
                                    <x-form.input type="number" min="0" class="total_price" name="total_price[${index}]" id="total_price-${index}" readonly/>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                <i class="ti ti-x ti-lg cursor-pointer remove-item" data-repeater-delete="" data-index="${index}"></i>
                            </div>
                        </div>
                    </div>`;
                $('#items').append(item);
                $('#item_count').val(index + 1);
                item_count = index + 1;
            });

            $(document).on('click', '.remove-item', function () {
                let index = $(this).data('index');
                $('#item-' + index).remove();
                $('#item_count').val(item_count - 1);
                item_count -= 1;
            });


            $('#scan-btn').click(function() {
                // هنا ستستخدم كاميرا الهاتف لمسح QR Code
                // يتم إدخال القيمة الممسوحة في الحقل

                // هذه المحاكاة لمسح QR بواسطة الهاتف أو جهاز ماسح QR يدوي
                var scannedQrCode = prompt("Scan the QR code value");  // محاكاة المسح

                if (scannedQrCode) {
                    $('#qr_code_search').val(scannedQrCode);  // إدخال القيمة الممسوحة في الحقل
                    $('.search_field').trigger('input');
                }
            });

            $('#reset_search').click(function() {
                $('.search_field').val('');
                $('.search_field').trigger('input');
            });

            // Select2
            $('#supplier_id').select2();


        })
    </script>
@endpush
