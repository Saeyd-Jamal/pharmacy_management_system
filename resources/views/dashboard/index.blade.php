<x-front-layout>
    <x-row />
    <div class="col-xxl-4 col-xl-6 col-lg-12">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">إحصائيات الصيدلية</h5>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-6 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                <i class="fa-solid fa-prescription-bottle-alt me-2 fs-6 text-primary"></i>
                            </div>
                            <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                <div class="me-2">
                                    <h4 class="mb-0">الأدوية</h4>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 " style="font-size: 20px;">{{ $medicines }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="mb-6 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                <i class="fa-solid fa-truck me-2 fs-6 text-primary"></i>
                            </div>
                            <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                <div class="me-2">
                                    <h4 class="mb-0">الموردين</h4>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 " style="font-size: 20px;">{{ $suppliers }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex align-items-center">
                            <div class="badge bg-label-secondary text-body p-2 me-4 rounded">
                                <i class="fa-solid fa-layer-group me-2 fs-6 text-primary"></i>
                            </div>
                            <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                <div class="me-2">
                                    <h4 class="mb-0">الأصناف</h4>
                                </div>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 " style="font-size: 20px;">{{ $categories }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-front-layout>
