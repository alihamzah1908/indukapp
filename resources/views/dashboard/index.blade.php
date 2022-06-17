@extends('layout.master')
@section('content')
<style>
    #container {
        max-width: 100%;
    }
</style>
<div class="row page-title align-items-center">
    <div class="col-sm-4 col-xl-6">
        <h4 class="mb-1 mt-0">DASHBOARD ANALYTICS DATA KEPENDUDUKAN KABUPATEN CIAMIS</h4>
    </div>
</div>

<!-- content -->
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Jumlah Penduduk</span>
                        <h2 class="mb-0" id="jumlah-penduduk"></h2>
                    </div>
                    <div class="align-self-center">
                        <!-- <div id="today-revenue-chart" class="apex-charts"></div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3" style="background-color: #d5e1f6ff">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Laki - Laki</span>
                        <h2 class="mb-0" id="laki-laki"></h2>
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

    <!-- <div class="col-md-6 col-xl-3">
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
    </div> -->

    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3" style="background-color: #fbc4ebff">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Perempuan</span>
                        <h2 class="mb-0" id="perempuan"></h2>
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
    <div class="col-md-8">
        <div id="loading"></div>
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body p-0" style="height: 400px;">
                <div class="table-responsive">
                    <table class="table" id="agama">
                        <thead>
                            <tr>
                                <th>Agama</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-xl-6">
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
    </div> -->
    <!-- <div class="col-xl-6">
        <div class="card">
            <div class="card-body pb-0">
                <h5 class="card-title mt-0 mb-0 header-title">Jenis Kelamin</h5>
                <div id="sales-by-category-chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
            </div>
        </div>
    </div> -->
</div>
@endsection
<!-- end row -->
@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    $(document).ready(function() {

        // GET DATA JENIS KELAMIN
        $.ajax({
            url: '{{ route("data.jenis_kelamin") }}',
            dataType: 'json',
            method: 'get'
        }).done(function(response) {
            var laki = response.length == '0' ? 0 : response[0].jumlah
            $("#laki-laki").html(laki)
            var perempuan = response.length == '0' ? 0 : response[1].jumlah
            $("#perempuan").html(perempuan)
        })

        // GET DATA AGAMA
        $.ajax({
            url: '{{ route("data.agama") }}',
            dataType: 'json',
            method: 'get'
        }).done(function(response) {
            var session = '{{ Auth::user()->role }}'
            if (session == 'super admin') {
                var body = '<tr>'
                body += '<td>Islam</td>'
                body += '<td>' + response[0].n_islam + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Kristen</td>'
                body += '<td>' + response[1].n_kristen + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Katholik</td>'
                body += '<td>' + response[2].n_katholik + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Lainya</td>'
                body += '<td>' + response[3].n_lainya + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Kong Huchu</td>'
                body += '<td>' + response[4].n_konghucu + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Budha</td>'
                body += '<td>' + response[5].n_budha + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Hindu</td>'
                body += '<td>' + response[6].n_hindu + '</td>'
                body += '</tr>'
                $("#agama").append(body)
            } else {
                var body = '<tr>'
                body += '<td>Islam</td>'
                body += '<td>' + response[0].n_islam + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Kristen</td>'
                body += '<td>' + response[0].n_kristen + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Katholik</td>'
                body += '<td>' + response[0].n_katholik + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Lainya</td>'
                body += '<td>' + response[0].n_lainya + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Kong Huchu</td>'
                body += '<td>' + response[0].n_konghucu + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Budha</td>'
                body += '<td>' + response[0].n_budha + '</td>'
                body += '</tr>'
                body += '<tr>'
                body += '<td>Hindu</td>'
                body += '<td>' + response[0].n_hindu + '</td>'
                body += '</tr>'
                $("#agama").append(body)
            }
        })

        // GET DATA JUMLAH PENDUDUK
        $.ajax({
            url: '{{ route("data.jumlah_penduduk") }}',
            dataType: 'json',
            method: 'get'
        }).done(function(response) {
            $("#jumlah-penduduk").html(response.jumlah)
        })

        //  DASHBOARD
        $.ajax({
            url: '{{ route("data.umur") }}',
            dataType: 'json',
            method: 'get',
            beforeSend: function() {
                $("#loading").html('Loading ....')
            },
        }).done(function(response) {
            $("#loading").html(' ')
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: 'Penduduk Berdasarkan Umur'
                },
                subtitle: {
                    align: 'left',
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: ''
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
                },

                series: [{
                    name: "",
                    colorByPoint: true,
                    data: response
                }],
                drilldown: {
                    breadcrumbs: {
                        position: {
                            align: 'right'
                        }
                    },
                }
            });
        })
    })
</script>
@endpush