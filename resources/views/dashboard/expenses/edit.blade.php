<x-front-layout>
    <form action="{{route('dashboard.expenses.update',$expense->id)}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include("dashboard.expenses._form")
    </form>
</x-front-layout>
