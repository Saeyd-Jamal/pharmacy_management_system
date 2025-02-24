<x-front-layout>
    <x-slot:extra_nav_right>
        <h4 class="card-title mb-0 col-2"> - جدول المصروفات</h4>
    </x-slot:extra_nav_right>
    <x-slot:extra_nav>
        @can('create', 'App\\Models\Expense')
        <div class="nav-item mx-2">
            <a href="{{ route('dashboard.expenses.create') }}" class="btn btn-success text-white m-0">
                <i class="fa-solid fa-plus fe-16"></i> إضافة
            </a>
        </div>
        @endcan
    </x-slot:extra_nav>
    <div class="card">
        @push('styles')
            {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
            <style>
                td {
                    color: #000 !important;
                }
                /* إخفاء مربع البحث */
                #expenses-table_filter {
                    display: none;
                }
            </style>
        @endpush

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="expenses-table" class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>المبلغ المدفوع</th>
                            <th>التاريخ</th>
                            <th>نوع المصروف</th>
                            <th>فئة المصروف</th>
                            <th>حالة الدفع</th>
                            <th>طريقة الدفع</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                        <tr id="expense-{{$expense->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$expense->amount}}</td>
                            <td>{{$expense->date}}</td>
                            <td>{{$expense->type}}</td>
                            <td>{{$expense->category}}</td>
                            <td>{{$expense->payment_status}}</td>
                            <td>{{$expense->payment_method}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('update', 'App\\Models\Expense')
                                        <a class="dropdown-item" href="{{route('dashboard.expenses.edit',$expense->id)}}">
                                            <i class="ti ti-pencil me-1"></i>تعديل
                                        </a>
                                        @endcan
                                        @can('delete', 'App\\Models\Expense')
                                        <form action="{{route('dashboard.expenses.destroy',$expense->id)}}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">
                                                <i class="ti ti-trash me-1"></i>حذف
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- إضافة الـ Pagination هنا -->
                <div class="mt-3">
                    {{ $expenses->links() }} <!-- روابط التصفح -->
                </div>
            </div>
        </div>
    </div>

</x-front-layout>
