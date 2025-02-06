<x-front-layout>
    @push('styles')
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" href="{{asset('css/datatable/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/dataTables.dataTables.css')}}">
        <link rel="stylesheet" href="{{asset('css/datatable/buttons.dataTables.css')}}">

        <link id="stickyTableLight" rel="stylesheet" href="{{ asset('css/custom/stickyTable.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom/datatableIndex.css') }}"> -->

    <style>
        thead th,
        tbody td {
            font-size: 14px !important;
            padding: 5px !important;
            margin: 0 !important;
        }

        .table {
            border-collapse: collapse !important;
        }

        .table-container {
            padding: 0 !important;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
            /* مسافة صغيرة بين الأزرار */
            align-items: center;
            justify-content: center;
        }

        .action-buttons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            /* عرض ثابت للأزرار */
            height: 30px;
        }
    </style>

    @endpush

    <x-slot:extra_nav>
        @can('create', 'App\\Models\Supplier')
        <div class="nav-item mx-2">
            <a href="{{ route('dashboard.suppliers.create') }}" class="btn btn-icon text-success m-0">
                <i class="fa-solid fa-plus fe-16"></i>
            </a>
        </div>
        @endcan

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

                    <table id="suppliers-table" class="table table-striped table-bordered table-hover sticky" style="width:100%;">

                        <thead>
                            <tr>
                                <th></th>

                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Person</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$supplier->name}}</td>
                                <td>{{$supplier->email}}</td>
                                <td>{{$supplier->contact_person}}</td>
                                <td>{{$supplier->address}}</td>
                                <td>{{$supplier->phone_number}}</td>

                                <td class="action-buttons">
                                    <a href="{{ route('dashboard.suppliers.edit',$supplier->id) }}" class="btn btn-primary">
                                        <i class="ti ti-edit text-xl leading-none"></i>
                                    </a>
                                    <form action="{{ route('dashboard.suppliers.destroy',$supplier->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="ti ti-trash text-xl leading-none"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-front-layout>