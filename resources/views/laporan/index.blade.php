@extends('layout.master')
@section('content')
<div class="row page-title">
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('laporan.index') }}" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold" for="form9Example2">RW</label>
                        @php
                        $rw = \App\Models\Penduduk::select('no_rw')
                        ->orderBy('no_rw','asc')
                        ->groupBy('no_rw')
                        ->get();
                        @endphp
                        <select name="no_rw" class="form-control">
                            <option value="">Pilih</option>
                            @foreach($rw as $val)
                            <option value="{{ $val->no_rw }}" {{ $val->no_rw == request()->no_rw ? ' selected' : ''}}>{{ $val->no_rw }}</option>
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
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="header-title mt-0 mb-1">Laporan Penduduk</h4>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a href="javascript:void(0)" class="download-excel" data-bind="{{ Auth::user()->kode_desa }}">
                        <span class="m-y-5 badge badge-pill badge-primary">
                            <div id="loading"></div>
                            <div id="text-button-voucher" class="text-button text-button-voucher">
                                <i class="fa fa-download" aria-hidden="true"></i> Export Excel
                            </div>
                            <div id="loading-wrap-voucher" class="text-center loading-wrap loading-wrap-voucher" style="display: none;">
                                <div class="spinner-border text-light" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </span>
                    </a>
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
                            <th>Status</th>
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
                                @elseif(Auth::user()->role != 'super admin' && $val->status == 'pindah' && $val->kode_desa_baru == Auth::user()->kode_desa)
                                <span class="badge badge-success">
                                    Datang
                                </span>
                                @elseif($val->status == 'pindah')
                                <span class="badge badge-primary">
                                    {{ ucfirst($val->status) }}
                                </span>
                                @elseif($val->status == 'pindah' && $val->status_pindah == 'luar')
                                <span class="badge badge-primary">
                                    Pindah (Luar Ciamis)
                                </span>
                                @elseif($val->status == 'datang')
                                <span class="badge badge-success">
                                    {{ ucfirst($val->status) }}
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
                    'kode': kode,
                    'no_rw': no_rw
                },
                beforeSend: function(){
                    $("#loading").html('Loading ....')
                },
                success: function(data) {
                    $("#loading").html(' ')
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = 'Data-Penduduk' + kode + '.xlsx';
                    document.body.append(a);
                    a.click();
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                    $(this).sess
                }
            })
            $(".loading-wrap-voucher").css("display", "block")
            $(".text-button-voucher").css("display", "none")
            setTimeout(function() {
                $(this).prop('disabled', false)
                $(".loading-wrap-voucher").css("display", "none")
                $(".text-button-voucher").css("display", "block")
            }, 1000);
        })
    })
</script>
@endpush