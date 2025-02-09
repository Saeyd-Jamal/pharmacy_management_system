<x-front-layout>
    <form action="{{route('dashboard.purchaseInvoices.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.purchaseInvoices._form")
    </form>
</x-front-layout>