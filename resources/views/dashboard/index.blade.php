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
                <div class="row">
                  
                    
  <!-- بوكس فواتير الشراء -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100" style="background-color: #f0f8ff; border-radius: 10px;">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="mb-0">فواتير الشراء</h4>
                                        <span> {{ $sI}}</span>
                                    </div>
                                    <div class="badge bg-label-secondary text-body p-2 rounded">
                                        <i class="fa-solid fa-layer-group fs-6 text-primary"></i>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <p class="mb-0" style="font-size: 24px; font-weight: bold;"> {{ $totalsale }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    

            <!-- بوكس فواتير البيع -->
            <div class="col-md-6 mb-3">
                        <div class="card h-100" style="background-color: #f0fff0; border-radius: 10px;">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="mb-0">فواتير البيع</h4>
                                        <span> {{ $pI}}</span>
                                    </div>
                                    <div class="badge bg-label-secondary text-body p-2 rounded">
                                        <i class="fa-solid fa-layer-group fs-6 text-primary"></i>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <p class="mb-0" style="font-size: 24px; font-weight: bold;">{{ $totalpurchase }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                {!! $chartjs->render() !!}
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
