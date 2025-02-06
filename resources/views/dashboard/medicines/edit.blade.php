<x-front-layout>
    <form action="{{route('dashboard.medicines.update',$medicines->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.medicines._form")
    </form>
</x-front-layout>