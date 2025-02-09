<x-front-layout>
    <form action="{{route('dashboard.categories.update',$category->slug)}}" method="post" class="col-12"  enctype="multipart/form-data">
        @csrf
        @method('put')
        @include("dashboard.categories._form")
    </form>
</x-front-layout>