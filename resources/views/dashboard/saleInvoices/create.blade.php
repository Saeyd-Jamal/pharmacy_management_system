<x-front-layout>
    <form action="{{route('dashboard.saleInvoices.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.saleInvoices._form")
    </form>
</x-front-layout>