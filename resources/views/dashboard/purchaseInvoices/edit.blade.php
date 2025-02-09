<x-front-layout>
    <form action="{{route('dashboard.purchaseInvoices.update',$purchaseInvoice->id)}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include("dashboard.purchaseInvoices._form")
    </form>
</x-front-layout>