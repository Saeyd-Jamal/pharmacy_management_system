<x-front-layout>
    <form action="{{route('dashboard.medicines.update',$medicine->slug)}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include("dashboard.medicines._form")
    </form>
</x-front-layout>