<x-front-layout>
    @push('styles')
   

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
        @can('create', 'App\\Models\Category')
        <div class="nav-item mx-2">
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-icon text-success m-0">
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

                    <table id="categories-table" class="table table-striped table-bordered table-hover sticky" style="width:100%;">

                        <thead>
                            <tr>
                                <th></th>

                                <th>Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->image}}</td>
                                <td>{{$category->description}}</td>
                               

                                <td class="action-buttons">
                                    <a href="{{ route('dashboard.categories.edit',$category->id) }}" class="btn btn-primary">
                                        <i class="ti ti-edit text-xl leading-none"></i>
                                    </a>
                                    <form action="{{ route('dashboard.categories.destroy',$category->id) }}" method="post">
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