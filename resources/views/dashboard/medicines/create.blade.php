<x-front-layout>
    <form action="{{route('dashboard.medicines.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.medicines._form")
    </form>
</x-front-layout>