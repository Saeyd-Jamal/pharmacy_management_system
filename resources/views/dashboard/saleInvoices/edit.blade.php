<x-front-layout>
    <form action="{{route('dashboard.saleInvoices.update',$saleInvoice->id)}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include("dashboard.saleInvoices._form")
    </form>
</x-front-layout>