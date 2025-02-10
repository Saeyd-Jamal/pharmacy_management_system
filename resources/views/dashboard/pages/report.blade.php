<x-front-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
        <style>
            label {
                font-size: 16px !important;
                color: #000 !important;
                font-weight: bold;
            }
        </style>
    @endpush
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="">إنتاج التقارير</h2>
        </div>
    </div>
    <div class="row justify-content-between">
        <form action="{{route('dashboard.report.export')}}" method="post" class="col-12" target="_blank">
            @csrf
            <div class="row">
                <div class="form-group col-md-3 my-2">
                    <x-form.input type="month" :value="$month" name="month" label="الشهر المطلوب (الشهر الاول)" />
                </div>
                <div class="form-group col-md-3 my-2">
                    <x-form.input type="month"  name="to_month" label="الى شهر" />
                </div>
            </div>
            <h3 class="h5">التخصيصات</h3>
            <div class="row">
                <div class="mb-4 col-md-3">
                    <x-form.selectr multiple label="الموردين" class="select2-multi" name="supplier_id[]" :optionsId="$suppliers" />
                </div>
                <div class="mb-4 col-md-3">
                    <x-form.selectr multiple label="الأصناف" class="select2-multi" name="category_id[]" :optionsId="$categories" />
                </div>
                <div class="mb-4 col-md-3">
                    <x-form.selectr multiple label="الزبون" class="select2-multi" name="customer_name[]" :options="$customer_names" />
                </div>
            </div>
            <h3 class="h5">أومر التصدير</h3>
            <div class="row align-items-center mb-2">
                <div class="form-group col-md-3 my-2">
                    <label for="report_type">نوع الكشف</label>
                    <select class="form-select" name="report_type" id="report_type" required>
                        <option  value="" disabled selected>حدد نوع الكشف</option>
                        <optgroup label="الكشوفات الأساسية">
                            <option value="current_inventory">تقرير المخزون الحالي</option>
                            <option value="supplier_report">تقرير الموردين</option>
                            <option value="day_sale_report">تقرير المبيعات اليومية</option>
                        </optgroup>
                    </select>
                    <span id="report_warning"></span>
                </div>
                <div class="form-group col-md-3 my-2">
                    <label for="export_type">طريقة التصدير</label>
                    <select class="form-select" name="export_type" id="export_type">
                        <option selected="" value="view">معاينة</option>
                        <option value="export_pdf">PDF</option>
                        {{-- <option value="export_excel">Excel</option> --}}
                    </select>
                </div>
                <div class="form-group col-md-3 my-2">
                    <label for="type_print">نوع الورق</label>
                    <select class="form-select" name="type_print" id="type_print">
                        <option selected="" value="a4">A4</option>
                        <option value="a4-l">A4 افقي</option>
                        <option value="a5">A5</option>
                        <option value="a5-l">A5 افقي</option>
                    </select>
                </div>
            </div>

            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h5 page-title"></h2>
                </div>
                <div class="col-auto">
                    <button type="reset"  class="btn btn-danger">
                        مسح
                    </button>
                    <button type="submit"  class="btn btn-primary">
                        <i class="fa fa-print"></i> طباعة
                    </button>
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}/";
    </script>
    <script src="{{asset('js/custom/report.js')}}"></script>
    <script src='{{ asset('js/plugins/select2.min.js') }}'></script>
    <script>
        $('.select2-multi').select2(
        {
            multiple: true,
        });
    </script>
    @endpush

</x-front-layout>
