@extends('layout.master')
@section('content')
<div class="row page-title">
</div>
<div class="col-lg-12">
    @if(Auth::user()->role != 'super admin')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('laporan.index') }}" method="get">
                <div class="row">
                    @php
                    if(Auth::user()->role == 'desa'){
                        // GET DATA RW
                        $rw = \App\Models\Penduduk::select('no_rw')
                        ->where('kode_desa', Auth::user()->kode_desa)
                        ->orderBy('no_rw','asc')
                        ->groupBy('no_rw')
                        ->get();

                        // GET DATA RT
                        $rt = \App\Models\Penduduk::select('no_rt')
                        ->where('kode_desa', Auth::user()->kode_desa)
                        ->orderBy('no_rt','asc')
                        ->groupBy('no_rt')
                        ->get();
                    }else{
                        // GET DATA RW
                        $rw = \App\Models\Penduduk::select('no_rw')
                        ->orderBy('no_rw','asc')
                        ->groupBy('no_rw')
                        ->get();

                        // GET DATA RT
                        $rt = \App\Models\Penduduk::select('no_rt')
                        ->orderBy('no_rt','asc')
                        ->groupBy('no_rt')
                        ->get();
                    }
                    @endphp
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" for="form9Example2">RW</label>
                        <select name="no_rw" class="form-control">
                            <option value="">Pilih</option>
                            @foreach($rw as $val)
                            <option value="{{ $val->no_rw }}" {{ $val->no_rw == request()->no_rw ? ' selected' : ''}}>{{ $val->no_rw }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" for="form9Example2">RT</label>
                        <select name="no_rt" class="form-control">
                            <option value="">Pilih</option>
                            @foreach($rt as $val)
                            <option value="{{ $val->no_rt }}" {{ $val->no_rt == request()->no_rt ? ' selected' : ''}}>{{ $val->no_rt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        <button class="btn btn-primary-custom btn-rounded mt-4" type="submit"><i class="uil uil-search"></i> Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="header-title mt-0 mb-1">Laporan Penduduk</h4>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <!-- <a href="javascript:void(0)" class="download-excel">
                        <span class="m-y-5 badge badge-pill badge-primary">
                            <div id="loading_export"></div>
                            <div id="text-button-voucher-export" class="text-button text-button-voucher-export">
                                <i class="uil uil-file-download"></i> Download Laporan
                            </div>
                            <div id="loading-wrap-voucher-export" class="text-center loading-wrap loading-wrap-voucher-export" style="display: none;">
                                <div class="spinner-border text-light" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </span>
                    </a> -->
                    <!-- <a href="javascript:void(0)" class="download-blanko ml-2">
                        <span class="m-y-5 badge badge-pill badge-warning">
                            <div id="loading_blanko"></div>
                            <div id="text-button-voucher" class="text-button text-button-voucher">
                                <i class="uil uil-file-download"></i> Download Blanko
                            </div>
                            <div id="loading-wrap-voucher-blanko" class="text-center loading-wrap loading-wrap-voucher-blanko" style="display: none;">
                                <div class="spinner-border text-light" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </span>
                    </a> -->
                    @if(Auth::user()->role != 'super admin')
                    <a href="{{ route('penduduk.pdf') }}{{ request()->no_rw != '' || request()->no_rt != ''? '?no_rw=' . request()->no_rw .'&no_rt=' . request()->no_rt : '' }}" class="ml-2">
                        <span class="m-y-5 badge badge-pill badge-danger">
                            <div id="loading_pdf"></div>
                            <div id="text-button-voucher-pdf" class="text-button text-button-voucher-pdf">
                                <i class="uil uil-file-download"></i> Download PDF
                            </div>
                            <div id="loading-wrap-voucher-pdf" class="text-center loading-wrap loading-wrap-voucher-pdf" style="display: none;">
                                <div class="spinner-border text-light" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </span>
                    </a>
                    @endif
                </div>
            </div>
            <div class="row mt-4">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <tr>
                            <th>NIK</th>
                            <th>No KK</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Keterangan</th>
                        </tr>
                        @foreach($penduduk as $val)
                        <tr>
                            <td>
                                <a href="{{ route('penduduk.detail', $val->id) }}">
                                    {{ $val->nik }}
                                </a>
                            </td>
                            <td>{{ $val->no_kk }}</td>
                            <td>{{ $val->nama_lengkap }}</td>
                            <td>{{ $val->tempat_lahir }}</td>
                            <td>{{ $val->tanggal_lahir != '' || $val->tanggal_lahir != null ? date('d M Y', strtotime($val->tanggal_lahir)) : '' }}</td>
                            <td>{{ $val->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                            <td>
                                @if($val->status == 'meninggal')
                                <span class="badge badge-danger">
                                    {{ ucfirst($val->status) }}
                                </span>
                                {{-- @elseif(Auth::user()->role != 'super admin' && $val->status == 'pindah_domisili_dalam' && $val->status == 'pindah_domisili_luar' && $val->status == 'pindah_permanen_dalam' && $val->status == 'pindah_permanen_luar' && $val->kode_desa_baru == Auth::user()->kode_desa) --}}
                                @elseif(Auth::user()->role != 'super admin' && $val->kode_desa_baru == Auth::user()->kode_desa)
                                <span class="badge badge-success">
                                    @if($val->status == 'pindah_permanen_dalam')
                                    Datang Permanen
                                    @elseif($val->status == 'pindah_domisili_dalam')
                                    Datang Non Permanen
                                    @endif
                                </span>
                                @elseif($val->status == 'pindah_permanen_dalam')
                                <span class="badge badge-primary">
                                    Pindah Permanen Dalam Daerah kabupaten
                                </span>
                                @elseif($val->status == 'pindah_permanen_luar')
                                <span class="badge badge-primary">
                                    Pindah Permanen Luar Daerah kabupaten
                                </span>
                                @elseif($val->status == 'pindah_domisili_dalam')
                                <span class="badge badge-primary">
                                    Penduduk Beda Domisili Dalam kabupaten
                                </span>
                                @elseif($val->status == 'pindah_domisili_luar')
                                <span class="badge badge-primary">
                                    Penduduk Beda Domisili Luar kabupaten
                                </span>
                                @elseif($val->status == 'pindah' && $val->status_pindah == 'luar')
                                <span class="badge badge-primary">
                                    Pindah (Luar Ciamis)
                                </span>
                                @elseif($val->status == 'datang')
                                <span class="badge badge-success">
                                    Datang Permanen
                                </span>
                                @elseif($val->status == 'datang_non_permanen')
                                <span class="badge badge-success">
                                    Datang Non Permanen
                                </span>
                                @elseif($val->status == 'lahir')
                                <span class="badge badge-warning">
                                    {{ ucfirst($val->status) }}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <ul class="pagination pagination-rounded d-flex justify-content-end">
            {{ $penduduk->links() }}
        </ul>
    </div>
</div>
{{--Halaman : {{ $penduduk->currentPage() }} <br />
Jumlah Data : {{ $penduduk->total() }} <br />
Data Per Halaman : {{ $penduduk->perPage() }} <br />
--}}
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('body').on('click', '.download-excel', function() {
            var kode = $(this).attr('data-bind')
            var no_rw = '{{ request()->no_rw }}'
            var url = '{{ route("download.penduduk") }}';
            $.ajax({
                url: url,
                method: 'get',
                xhrFields: {
                    responseType: 'blob'
                },
                data: {
                    'no_rw': no_rw
                },
                beforeSend: function() {
                    $("#loading_export").html('Loading ....')
                },
                success: function(data) {
                    $("#loading_export").html(' ')
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = 'Data-Penduduk.xlsx';
                    document.body.append(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                    $(this).sess
                }
            })
            $(".loading-wrap-voucher-export").css("display", "block")
            $(".text-button-voucher-export").css("display", "none")
            setTimeout(function() {
                $(this).prop('disabled', false)
                $(".loading-wrap-voucher-export").css("display", "none")
                $(".text-button-voucher-export").css("display", "block")
            }, 1000);
        })

        // GET DOWNLOAD EXCEL BLANKO
        $('body').on('click', '.download-blanko', function() {
            var kode = $(this).attr('data-bind')
            var no_rw = '{{ request()->no_rw }}'
            var url = '{{ route("penduduk.blanko") }}';
            $.ajax({
                url: url,
                method: 'get',
                xhrFields: {
                    responseType: 'blob'
                },
                data: {
                    'no_rw': no_rw
                },
                beforeSend: function() {
                    $("#loading_blanko").html('Loading ....')
                },
                success: function(data) {
                    $("#loading_blanko").html(' ')
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = 'Data-Penduduk.xlsx';
                    document.body.append(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                    $(this).sess
                }
            })
            $(".loading-wrap-voucher-blanko").css("display", "block")
            $(".text-button-voucher-blanko").css("display", "none")
            setTimeout(function() {
                $(this).prop('disabled', false)
                $(".loading-wrap-voucher-blanko").css("display", "none")
                $(".text-button-voucher-blanko").css("display", "block")
            }, 1000);
        })
    })
</script>
@endpush