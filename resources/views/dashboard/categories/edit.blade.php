<x-front-layout>
    <form action="{{route('dashboard.categories.update',$categories->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.categories._form")
    </form>
</x-front-layout>