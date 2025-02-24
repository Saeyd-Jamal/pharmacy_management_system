<x-front-layout>
    <form action="{{route('dashboard.expenses.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.expenses._form")
    </form>
</x-front-layout>
