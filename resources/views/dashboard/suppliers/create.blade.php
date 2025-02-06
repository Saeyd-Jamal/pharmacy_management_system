<x-front-layout>
    <form action="{{route('dashboard.suppliers.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.suppliers._form")
    </form>
</x-front-layout>