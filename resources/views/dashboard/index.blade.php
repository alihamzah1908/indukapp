@extends('layout.master')
@section('content')
<div class="row page-title align-items-center">
    <div class="col-sm-4 col-xl-6">
        <h4 class="mb-1 mt-0">Dashboard</h4>
    </div>
</div>

<!-- content -->
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Jumlah Penduduk</span>
                        <h2 class="mb-0">{{ \App\Models\Penduduk::count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <div id="today-revenue-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Meninggal</span>
                        <h2 class="mb-0">{{ \App\Models\Penduduk::where('status','meninggal')->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <div id="today-product-sold-chart" class="apex-charts"></div>
                        <span class="text-danger font-weight-bold font-size-13">
                            <!-- <i class='uil uil-arrow-down'></i> 5.05% -->
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Lahir</span>
                        <h2 class="mb-0">{{ \App\Models\Penduduk::where('status','lahir')->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <div id="today-new-customer-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Pindah</span>
                        <h2 class="mb-0">{{ \App\Models\Penduduk::where('status','pindah')->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <div id="today-new-visitors-chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- stats + charts -->
<div class="row">

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body pb-0">
                <ul class="nav card-nav float-right">
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#">Today</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#">7d</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">15d</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#">1m</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#">1y</a>
                    </li>
                </ul>
                <h5 class="card-title mb-0 header-title">Angka Kelahiran</h5>

                <div id="revenue-chart" class="apex-charts mt-3" dir="ltr"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body pb-0">
                <h5 class="card-title mt-0 mb-0 header-title">Jenis Kelamin</h5>
                <div id="sales-by-category-chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- end row -->