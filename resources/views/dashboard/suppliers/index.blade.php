<x-front-layout>
    <x-slot:extra_nav_right>
        <h5 class="card-title mb-0 col-2"> - جدول الموردين</h5>
    </x-slot:extra_nav_right>
    <x-slot:extra_nav>
        @can('create', 'App\\Models\Supplier')
        <div class="nav-item mx-2">
            <a href="{{ route('dashboard.suppliers.create') }}" class="btn btn-success text-white m-0">
                <i class="fa-solid fa-plus fe-16"></i> إضافة
            </a>
        </div>
        @endcan
    </x-slot:extra_nav>
    <div class="card">
        <style>
            td{
                color: #000 !important;
            }
        </style>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>اسم المورد</th>
                            <th>المدعو الشخصي</th>
                            <th>الإيميل</th>
                            <th>العنوان</th>
                            <th>رقم الهاتف</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                        <tr id="supplier-{{$supplier->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$supplier->name}}</td>
                            <td>{{$supplier->contact_person}}</td>
                            <td>{{$supplier->email}}</td>
                            <td>{{$supplier->address}}</td>
                            <td>{{$supplier->phone_number}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('update', 'App\\Models\Supplier')
                                        <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;" href="{{route('dashboard.suppliers.edit',$supplier->id)}}">
                                            <i class="ti ti-pencil me-1"></i>تعديل
                                        </a>
                                        @endcan
                                        @can('delete', 'App\\Models\Supplier')
                                        <button data-id="{{ $supplier->id }}" class="dropdown-item delete-btn" style="margin: 0.5rem -0.75rem; text-align: right;">
                                            <i class="ti ti-trash me-1"></i>حذف
                                        </button>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function () {
                $(document).on('click', '.delete-btn', function (e) {
                    if(confirm('هل توافق حذف العنصر هذا؟')){
                        let id = $(this).data('id');
                        $.ajax({
                            url: "{{ route('dashboard.suppliers.destroy', ':id') }}".replace(':id', id),
                            type: 'DELETE',
                            success: function (response) {
                                alert('تم حذف العنصر بنجاح');
                                $('#supplier-' + id).remove();
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX error:', status, error);
                                alert('هنالك خطاء في عملية الحذف.');
                            }
                        });
                    }
                })
            });
        </script>
    @endpush
</x-front-layout>
