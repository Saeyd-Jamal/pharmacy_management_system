<x-front-layout>
    @push('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="{{asset('css/plugins/datatable/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/plugins/datatable/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('css/plugins/datatable/dataTables.dataTables.css')}}">
        <link rel="stylesheet" href="{{asset('css/plugins/datatable/buttons.dataTables.css')}}">

        <link id="stickyTableLight" rel="stylesheet" href="{{ asset('css/custom/stickyTable.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom/datatableIndex.css') }}">

        <style>
            thead th{
                font-size: 14px !important;
            }
            td .btn-icon{
                padding: 7px !important;
                width: auto !important;
                height: auto !important;
            }
            .dt-info{
                display: none !important;
            }
            .container-p-y:not([class^=pb-]):not([class*=" pb-"]){
                padding-bottom: 0 !important;
            }
            .dt-search{
                display: none !important;
            }
            @media (min-width: 767px) {
                table{
                    display: table !important;
                    height: auto !important;
                }
            }
        </style>
    @endpush
    <x-slot:extra_nav>
        <div class="nav-item form-group my-0 mx-2">
            <select name="year" id="year" class="form-control">
                @for ($year = date('Y'); $year >= 2025; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        @can('export-excel', 'App\\Models\PurchaseInvoice')
        <div class="nav-item">
            <button type="button" class="btn btn-icon btn-success text-white" id="excel-export" title="تصدير excel">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16">
                    <path d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z"/>
                </svg>
            </button>
        </div>
        @endcan
        @can('create', 'App\\Models\PurchaseInvoice')
        <div class="nav-item mx-2">
            <a href="{{ route('dashboard.purchaseInvoices.create') }}" class="btn btn-primary text-white m-0" id="createNew">
                <i class="fa-solid fa-plus fe-16"></i> اضافة
            </a>
        </div>
        @endcan
        <div class="nav-item mx-2">
            <div class="dropdown">
                <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1 waves-effect waves-light" type="button" id="earningReportsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa-solid fa-filter fe-16"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(4px, 38px);">
                    <a class="dropdown-item waves-effect" id="filterBtn" href="javascript:void(0);">تصفية</a>
                    <a class="dropdown-item waves-effect" id="filterBtnClear" href="javascript:void(0);">إزالة التصفية</a>
                </div>
            </div>
        </div>
        <div class="nav-item d-flex align-items-center justify-content-center mx-2">
            <button type="button" class="btn" id="refreshData">
                <i class="fa-solid fa-arrows-rotate"></i>
            </button>
        </div>
    </x-slot:extra_nav>


    <div class="row">
        <div class="col-md-12" style="padding: 0 2px;">
            <div class="card">
                <div class="card-body table-container p-0">
                    <table id="purchaseInvoices-table" class="table table-striped table-bordered table-hover sticky" style="width:100%; height: calc(100vh - 155px);">
                        <thead>
                            <tr>
                                <th class="sticky" id="nth0"></th>
                                <th class="text-white opacity-7 text-center sticky"  id="nth1">#</th>
                                <th class="sticky" style="right: 36.5px;"  id="nth2">
                                    <div class='d-flex align-items-center justify-content-between'>
                                        <span>تاريخ الفاتورة</span>
                                        <div class='filter-dropdown ml-4'>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-2" type="button" id="date_filter" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa-brands fa-get-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="date_filter">
                                                    <div>
                                                        <input type="date" id="from_date" name="from_date" class="form-control mr-2" style="width: 200px"/>
                                                        <input type="date" id="to_date" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" name="to_date" class="form-control mr-2 mt-2" style="width: 200px"/>
                                                    </div>
                                                    <div>
                                                        <button id="filter-date-btn" class='btn btn-success text-white filter-apply-btn-data' data-target="2" data-field="date_name">
                                                            <i class='fa-solid fa-check'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>المورد</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-3" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa-brands fa-get-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="supplier_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="3" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="3" data-field="supplier_name">
                                                                <i class="fa-solid fa-check"></i>
                                                            </button>
                                                        </div>
                                                        <div class="checkbox-list-box">
                                                            <label style="display: block;">
                                                                <input type="checkbox" value="all" class="all-checkbox" data-index="3"> الكل
                                                            </label>
                                                            <div class="checkbox-list checkbox-list-3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>المبلغ الإجمالي</th>
                                <th>عدد الأدوية</th>
                                <th>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span>منشئ من</span>
                                        <div class="filter-dropdown ml-4">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-filter" id="btn-filter-6" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa-brands fa-get-pocket text-white"></i>
                                                </button>
                                                <div class="filterDropdownMenu dropdown-menu dropdown-menu-right p-2" aria-labelledby="created_by_filter">
                                                    <!-- إضافة checkboxes بدلاً من select -->
                                                    <div class="searchable-checkbox">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <input type="search" class="form-control search-checkbox" data-index="6" placeholder="ابحث...">
                                                            <button class="btn btn-success text-white filter-apply-btn-checkbox" data-target="6" data-field="created_by_name">
                                                                <i class="fa-solid fa-check"></i>
                                                            </button>
                                                        </div>
                                                        <div class="checkbox-list-box">
                                                            <label style="display: block;">
                                                                <input type="checkbox" value="all" class="all-checkbox" data-index="6"> الكل
                                                            </label>
                                                            <div class="checkbox-list checkbox-list-6">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <i class="fa-solid fa-print text-white fe-16"></i>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td class="sticky"></td>
                                <td class="sticky text-white text-center" id="count_purchaseInvoices"></td>
                                <td class='text-white sticky text-left'>المجموع</td>
                                <td></td>
                                <td class='text-white text-center' id="total_amount"></td>
                                <td class='text-white text-center' id="total_count_medicines"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Fullscreen modal -->
    <div class="modal fade modal-full" id="editPurchaseInvoice" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <button aria-label="" type="button" class="close px-2" data-bs-dismiss="modal" aria-hidden="true">
            <span aria-hidden="true">×</span>
        </button>
        <div class="modal-dialog modal-dialog-centered w-100" role="document" style="max-width: 95%;">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <form id="editForm">
                        {{-- @include('dashboard.purchaseInvoices.editModal') --}}
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- small modal -->

    @push('scripts')
        <!-- DataTables JS -->
        <script src="{{asset('js/plugins/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/plugins/datatable/dataTables.js')}}"></script>
        <script src="{{asset('js/plugins/datatable/dataTables.buttons.js')}}"></script>
        <script src="{{asset('js/plugins/datatable/buttons.dataTables.js')}}"></script>
        <script src="{{asset('js/plugins/datatable/jszip.min.js')}}"></script>
        <script src="{{asset('js/plugins/datatable/pdfmake.min.js')}}"></script>
        <script src="{{asset('js/plugins/datatable/vfs_fonts.js')}}"></script>
        <script src="{{asset('js/plugins/datatable/buttons.html5.min.js')}}"></script>
        <script src="{{asset('js/plugins/datatable/buttons.print.min.js')}}"></script>
        <script src="{{asset('js/plugins/jquery.validate.min.js')}}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $.validator.messages.required = "هذا الحقل مطلوب";
                $("#editForm").validate({
                    rules: {
                        name: {
                            required: true,
                            maxlength: 255,
                        }
                    },
                    messages: {
                        name: "يرجى إدخال اسم المستخدم",
                    }
                });
                let formatNumber = (number,min = 0) => {
                    // التحقق إذا كانت القيمة فارغة أو غير صالحة كرقم
                    if (number === null || number === undefined || isNaN(number)) {
                        return ''; // إرجاع قيمة فارغة إذا كان الرقم غير صالح
                    }
                    return new Intl.NumberFormat('en-US', { minimumFractionDigits: min, maximumFractionDigits: 2 }).format(number);
                };
                let width0 = $('#nth0').outerWidth(true);
                let width1 = $('#nth1').outerWidth(true);
                let width2 = $('#nth2').outerWidth(true);
                let table = $('#purchaseInvoices-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    paging: false,              // تعطيل الترقيم
                    searching: true,            // الإبقاء على البحث إذا كنت تريده
                    info: false,                // تعطيل النص السفلي الذي يوضح عدد السجلات
                    lengthChange: false,        // تعطيل قائمة تغيير عدد المدخلات
                    layout: {
                        topStart: {
                            buttons: [
                                {
                                    extend: 'excelHtml5',
                                    text: 'تصدير Excel',
                                    title: 'التخصيصات', // تخصيص العنوان عند التصدير
                                    className: 'd-none', // إخفاء الزر الأصلي
                                    exportOptions: {
                                        columns: [1, 2, 3, 4, 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21], // تحديد الأعمدة التي سيتم تصديرها (يمكن تعديلها حسب الحاجة)
                                        modifier: {
                                            search: 'applied', // تصدير البيانات المفلترة فقط
                                            order: 'applied',  // تصدير البيانات مع الترتيب الحالي
                                            page: 'all'        // تصدير جميع الصفحات المفلترة
                                        }
                                    }
                                },
                            ]
                        }
                    },
                    "language": {
                        "url": "{{ asset('files/Arabic.json')}}"
                    },
                    ajax: {
                        url: '{{ route("dashboard.purchaseInvoices.index") }}',
                        data: function (d) {
                            // إضافة تواريخ التصفية إلى الطلب المرسل
                            d.from_date = $('#from_date').val();
                            d.to_date = $('#to_date').val();
                            d.year = $('#year').val();
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                        }
                    },
                    columns: [
                        { data: 'edit', name: 'edit', orderable: false, class: 'sticky text-center', searchable: false, render: function(data, type, row) {
                            @can('update','App\\Models\PurchaseInvoice')
                            let link = `<a href="{{ route('dashboard.purchaseInvoices.edit', ':purchaseInvoice') }}" class="btn btn-icon btn-icon text-primary edit_row"><i class="fa-solid fa-edit"></i></a>`.replace(':purchaseInvoice', data);
                            return link ;
                            @else
                            return '';
                            @endcan
                        }},
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, class: 'sticky text-center'}, // عمود الترقيم التلقائي
                        { data: 'date', name: 'date'  , orderable: false, class: 'sticky text-center'},
                        { data: 'supplier_name', name: 'supplier_name'  , orderable: false, class: 'text-center'},
                        { data: 'total_amount', name: 'total_amount'  , orderable: false, class: 'text-center', render: function (data, type, row) {
                            return formatNumber(data,2);
                        }},
                        { data: 'count_items', name: 'count_items'  , orderable: false, class: 'text-center'},
                        { data: 'created_by', name: 'created_by'  , orderable: false},
                        { data: 'print', name: 'print', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('print','App\\Models\PurchaseInvoice')
                            return `
                                <form method="post" action="{{ route('dashboard.purchaseInvoices.print', ':purchaseInvoice') }}" target="_blank">
                                    @csrf
                                    <button
                                        class="btn btn-icon text-info">
                                        <i class="fa-solid fa-print"></i>
                                    </button>
                                </form>
                                `.replace(':purchaseInvoice', data);
                            @else
                            return '';
                            @endcan
                        }},
                        { data: 'delete', name: 'delete', orderable: false, searchable: false, render: function (data, type, row) {
                            @can('delete','App\\Models\PurchaseInvoice')
                            return `
                                <button
                                    class="btn btn-icon text-danger delete_row"
                                    data-id="${data}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>`;
                            @else
                            return '';
                            @endcan
                        }},
                    ],
                    columnDefs: [
                        { targets: 1, searchable: false, orderable: false } // تعطيل الفرز والبحث على عمود الترقيم
                    ],
                    drawCallback: function(settings) {
                        // تطبيق التنسيق على خلايا العمود المحدد
                        $('#purchaseInvoices-table tbody tr').each(function() {
                            // $(this).find('td').eq(0).css('right', (0) + 'px');
                            // $(this).find('td').eq(1).css('right', (width0) + 'px');
                            // $(this).find('td').eq(2).css('right', (width0 + width1) + 'px');
                            // $(this).find('td').eq(3).css('right', (width0 + width1 + width2 - 5) + 'px');
                            // $(this).find('td').eq(4).css('right', (width0 + width1 + width2 + width3 - 10) + 'px');
                        });
                    },
                    footerCallback: function(row, data, start, end, display) {
                        var api = this.api();
                        // تحويل القيم النصية إلى أرقام
                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                parseFloat(i.replace(/[\$,]/g, '')) :
                                typeof i === 'number' ? i : 0;
                        };
                        // 1. حساب عدد الأسطر في الصفحة الحالية
                        // count_purchaseInvoices 1
                        var rowCount = display.length;
                        var total_amount_sum = api
                            .column(4, { page: 'current' }) // العمود الرابع
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                        var total_count_medicines_sum = api
                            .column(5, { page: 'current' }) // العمود الرابع
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // 4. عرض النتائج في `tfoot`
                        $('#count_purchaseInvoices').html(formatNumber(rowCount));
                        $('#total_amount').html(formatNumber(total_amount_sum));
                        $('#total_count_medicines').html(formatNumber(total_count_medicines_sum));
                    }
                });
                // عندما يتم رسم الجدول (بعد تحميل البيانات أو تحديثها)
                table.on('draw', function() {
                    // التمرير إلى آخر سطر في الجدول
                    let tableContainer = $('#purchaseInvoices-table');
                    tableContainer.scrollTop(tableContainer[0].scrollHeight);

                    // $('#purchaseInvoices-table thead tr').each(function() {
                    //     $(this).find('th.sticky').eq(0).css('right', (0) + 'px');
                    //     $(this).find('th.sticky').eq(1).css('right', (width0) + 'px');
                    //     $(this).find('th.sticky').eq(2).css('right', (width0 + width1) + 'px');
                    //     $(this).find('th.sticky').eq(3).css('right', (width0 + width1 + width2 - 5) + 'px');
                    //     $(this).find('th.sticky').eq(4).css('right', (width0 + width1 + width2 + width3 - 10) + 'px');
                    // });

                    // $('#purchaseInvoices-table tfoot tr').each(function() {
                    //     $(this).find('td.sticky').eq(0).css('right', (0) + 'px');
                    //     $(this).find('td.sticky').eq(1).css('right', (width0) + 'px');
                    //     $(this).find('td.sticky').eq(2).css('right', (width0 + width1) + 'px');
                    // });
                });
                // نسخ وظيفة الزر إلى الزر المخصص
                $('#excel-export').on('click', function () {
                    table.button('.buttons-excel').trigger(); // استدعاء وظيفة الزر الأصلي
                });
                $('#purchaseInvoices-table_filter').addClass('d-none');
                // جلب الداتا في checkbox
                function populateFilterOptions(columnIndex, container,name) {
                    const uniqueValues = [];
                    table.column(columnIndex, { search: 'applied' }).data().each(function (value) {
                        const stringValue = value ? String(value).trim() : ''; // تحويل القيمة إلى نص وإزالة الفراغات
                        if (stringValue && uniqueValues.indexOf(stringValue) === -1) {
                            uniqueValues.push(stringValue);
                        }
                    });
                    // ترتيب القيم أبجديًا
                    uniqueValues.sort();
                    // إضافة الخيارات إلى div
                    const checkboxList = $(container);
                    checkboxList.empty();
                    uniqueValues.forEach(value => {
                        checkboxList.append(`
                            <label style="display: block;">
                                <input type="checkbox" value="${value}" class="${name}-checkbox"> ${value}
                            </label>
                        `);
                    });
                }
                function isColumnFiltered(columnIndex) {
                    const filterValue = table.column(columnIndex).search();
                    return filterValue !== ""; // إذا لم يكن فارغًا، الفلترة مفعلة
                }
                // دالة لإعادة بناء الفلاتر بناءً على البيانات الحالية
                function rebuildFilters() {
                    isColumnFiltered(3) ? '' : populateFilterOptions(3, '.checkbox-list-3','supplier_name');
                    isColumnFiltered(6) ? '' : populateFilterOptions(6, '.checkbox-list-6','created_by_name');

                    for (let i = 1; i <= 7; i++) {
                        if (isColumnFiltered(i)) {
                            $('#btn-filter-' + i).removeClass('btn-secondary');
                            $('#btn-filter-' + i + ' i').removeClass('fa-brands fa-get-pocket');
                            $('#btn-filter-' + i + ' i').addClass('fa-solid fa-filter');
                            $('#btn-filter-' + i).addClass('btn-success');
                        }else{
                            $('#btn-filter-' + i + ' i').removeClass('fa-solid fa-filter');
                            $('#btn-filter-' + i).removeClass('btn-success');
                            $('#btn-filter-' + i).addClass('btn-secondary');
                            $('#btn-filter-' + i + ' i').addClass('fa-brands fa-get-pocket');
                        }
                    }
                }
                table.on('draw', function() {
                    rebuildFilters();
                });
                // // تطبيق الفلترة عند الضغط على زر "check"
                $('.filter-apply-btn').on('click', function() {
                    let target = $(this).data('target');
                    let field = $(this).data('field');
                    var filterValue = $("input[name="+ field + "]").val();
                    table.column(target).search(filterValue).draw();
                });
                // منع إغلاق dropdown عند النقر على input أو label
                $('th  .dropdown-menu .checkbox-list-box').on('click', function (e) {
                    e.stopPropagation(); // منع انتشار الحدث
                });
                // البحث داخل الـ checkboxes
                $('.search-checkbox').on('input', function() {
                    let searchValue = $(this).val().toLowerCase();
                    let tdIndex = $(this).data('index');
                    $('.checkbox-list-' + tdIndex + ' label').each(function() {
                        let labelText = $(this).text().toLowerCase();  // النص داخل الـ label
                        let checkbox = $(this).find('input');  // الـ checkbox داخل الـ label

                        if (labelText.indexOf(searchValue) !== -1) {
                            $(this).show();
                        } else {
                            $(this).hide();
                            if (checkbox.prop('checked')) {
                                checkbox.prop('checked', false);  // إذا كان الـ checkbox محددًا، قم بإلغاء تحديده
                            }
                        }
                    });
                });
                $('.all-checkbox').on('change', function() {
                    let index = $(this).data('index'); // الحصول على الـ index من الـ data-index

                    // التحقق من حالة الـ checkbox "الكل"
                    if ($(this).prop('checked')) {
                        // إذا كانت الـ checkbox "الكل" محددة، تحديد جميع الـ checkboxes الظاهرة فقط
                        $('.checkbox-list-' + index + ' input[type="checkbox"]:visible').prop('checked', true);
                    } else {
                        // إذا كانت الـ checkbox "الكل" غير محددة، إلغاء تحديد جميع الـ checkboxes الظاهرة فقط
                        $('.checkbox-list-' + index + ' input[type="checkbox"]:visible').prop('checked', false);
                    }
                });
                $('.filter-apply-btn-checkbox').on('click', function() {
                    let target = $(this).data('target'); // استرجاع الهدف (العمود)
                    let field = $(this).data('field'); // استرجاع الحقل (اسم المشروع أو أي حقل آخر)

                    // الحصول على القيم المحددة من الـ checkboxes
                    var filterValues = [];
                    // نستخدم الكلاس المناسب بناءً على الحقل (هنا مشروع)
                    $('.' + field + '-checkbox:checked').each(function() {
                        filterValues.push($(this).val()); // إضافة القيمة المحددة
                    });
                    // إذا كانت هناك قيم محددة، نستخدمها في الفلترة
                    if (filterValues.length > 0) {
                        // دمج القيم باستخدام OR (|) كما هو متوقع في البحث
                        var searchExpression = filterValues.join('|');
                        // تطبيق الفلترة على العمود باستخدام القيم المحددة
                        table.column(target).search(searchExpression, true, false).draw(); // Use regex search
                    } else {
                        // إذا لم تكن هناك قيم محددة، نعرض جميع البيانات
                        table.column(target).search('').draw();
                    }
                });
                // تطبيق التصفية عند النقر على زر "Apply"
                $('#filter-date-btn , #filter-date-implementation-btn').on('click', function () {
                    const fromDate = $('#from_date').val();
                    const toDate = $('#to_date').val();
                    const fromDateImplementation = $('#from_date_implementation').val();
                    const toDateImplementation = $('#to_date_implementation').val();
                    table.ajax.reload(); // إعادة تحميل الجدول مع التواريخ المحدثة
                });
                $('#year').on('change', function () {
                    const year = $('#year').val();
                    table.ajax.reload();
                })
                // تفويض حدث الحذف على الأزرار الديناميكية
                $(document).on('click', '.delete_row', function () {
                    const id = $(this).data('id'); // الحصول على ID الصف
                    if (confirm('هل أنت متأكد من حذف العنصر؟')) {
                        deleteRow(id); // استدعاء وظيفة الحذف
                    }
                });
                // وظيفة الحذف
                function deleteRow(id) {
                    $.ajax({
                        url: '{{ route("dashboard.purchaseInvoices.destroy", ":id") }}'.replace(':id', id),
                        method: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            alert('تم حذف العنصر بنجاح');
                            table.ajax.reload(); // إعادة تحميل الجدول بعد الحذف
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            alert('هنالك خطاء في عملية الحذف.');
                        },
                    });
                }
                $(document).on('click', '#refreshData', function() {
                    table.ajax.reload();
                });
                $(document).on('click', '#filterBtnClear', function() {
                    $('.filter-dropdown').slideUp();
                    $('#filterBtn').text('تصفية');
                    $('.filterDropdownMenu input').val('');
                    $('th input[type="checkbox"]').prop('checked', false);
                    table.columns().search('').draw(); // إعادة رسم الجدول بدون فلاتر
                });
                $('.calculation').on('blur keypress', function (event) {
                    // تحقق إذا كان الحدث هو الضغط على مفتاح
                    if (event.type == 'keypress' && event.key != "Enter") {
                        return;
                    }
                    // استرجاع القيمة المدخلة
                    var input = $(this).val();
                    try {
                        // استخدام eval لحساب الناتج (مع الاحتياطات الأمنية)
                        var result = eval(input);
                        // عرض الناتج في الحقل
                        $(this).val(result);
                    } catch (e) {
                        // في حالة وجود خطأ (مثل إدخال غير صحيح)
                        alert('يرجى إدخال معادلة صحيحة!');
                    }
                });
                // التعديلات الحاصلة على النموذج
                $('#quantity, #price').on('input blur', function () {
                    // جلب القيم من الحقول
                    let quantity = $('#quantity').val();
                    let price = $('#price').val();

                    if(quantity != '' && price != ''){
                        quantity = parseFloat(quantity);
                        price = parseFloat(price);
                        let totalDollar = quantity * price;
                        let currencyPurchaseInvoice = $('#currency_purchaseInvoice_value').val() || 0; //إذا كان الحقل فارغًا، اعتبر القيمة 0
                        $('#total_dollar').val(totalDollar);
                        $('#purchaseInvoice').val(totalDollar);
                        $('#amount').val(parseFloat(totalDollar) / currencyPurchaseInvoice);
                    }
                });
                $('#currency_purchaseInvoice').on('input blur', function () {
                    var currencyPurchaseInvoice = parseFloat($('#currency_purchaseInvoice option:selected').data('val')) || 0; //إذا كان الحقل فارغًا، اعتبر القيمة 0
                    $('#currency_purchaseInvoice_value').val(1 / currencyPurchaseInvoice)
                    $('#currency_purchaseInvoice_value').trigger('input');
                });
                $('#purchaseInvoice,#currency_purchaseInvoice_value').on('input blur', function () {
                    // جلب القيم من الحقول
                    var purchaseInvoice = parseFloat($('#purchaseInvoice').val()) || 0; // إذا كان الحقل فارغًا، اعتبر القيمة 0
                    var amount = purchaseInvoice / $('#currency_purchaseInvoice_value').val();
                    $('#amount').val(amount);
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '#filterBtn', function() {
                    let text = $(this).text();
                    if (text != 'تصفية') {
                        $(this).text('تصفية');
                        $('.filter-dropdown').slideUp();
                    }else{
                        $(this).text('إخفاء التصفية');
                        $('.filter-dropdown').slideDown();
                    }
                });
            });
        </script>
    @endpush
</x-front-layout>
