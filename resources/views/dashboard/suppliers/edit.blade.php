<x-front-layout>
    <form action="{{route('dashboard.suppliers.update',$suppliers->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.suppliers._form")
    </form>
</x-front-layout>