@extends('layout.master')
@section('content')
<div class="row page-title">
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('penduduk.index') }}" method="get">
                <div class="row">
                    <!-- <div class="col-md-3">
                        <label class="form-label font-weight-bold" for="form9Example2">Status</label>
                        <select name="status" class="form-control">
                            <option value="">Pilih</option>
                            <option value="meninggal" {{ request()->status == 'meninggal' ? ' selected' : ''}}>Meninggal</option>
                            <option value="pindah" {{ request()->status == 'pindah' ? ' selected' : ''}}>Pindah</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold" for="form9Example2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ request()->jenis_kelamin == 'Laki-laki' ? ' selected' : ''}}>Laki - Laki</option>
                            <option value="Perempuan" {{ request()->jenis_kelamin == 'Perempuan' ? ' selected' : ''}}>Perempuan</option>
                        </select>
                    </div> -->
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" for="form9Example2">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ request()->nik }}" placeholder="Cari nik ..."/>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" for="form9Example2">Cari KK</label>
                        <input type="text" name="no_kk" class="form-control" value="{{ request()->no_kk }}" placeholder="Cari kk ..."/>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end">
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
                    <h4 class="header-title mt-0 mb-1">Data Penduduk</h4>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a href="{{ route('penduduk.form') }}">
                        <button class="btn btn-sm btn-success btn-rounded"><i class="uil uil-plus-circle"></i> Tambah Data</button>
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
                            <th>Keterangan</th>
                            <th>Aksi</th>
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
                            <td>
                                <div class="dropdown ">
                                    <button class="btn btn-primary-custom btn-rounded btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">Aksi
                                        <i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg></i>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        {{-- @if($val->status != 'meninggal' && $val->status_pindah != 'luar') --}}
                                        @if($val->kode_desa_baru == Auth::user()->kode_desa || $val->status != 'meninggal' && $val->status != 'pindah_domisili_dalam' && $val->status != 'pindah_domisili_luar' && $val->status != 'pindah_permanen_dalam' && $val->status != 'pindah_permanen_luar')
                                        @if($val->status == 'lahir')
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?id={{ $val->id }}"><i class="uil uil-edit-alt"></i> Edit</a>
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?id={{ $val->id }}&status=pindah"><i class="uil uil-car-sideview"></i> Pindah</a>
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?id={{ $val->id }}&status=meninggal"><i class="uil uil-sad-dizzy"></i> Meninggal</a>
                                        @else 
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?nik={{ $val->nik }}"><i class="uil uil-edit-alt"></i> Edit</a>
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?nik={{ $val->nik }}&status=pindah"><i class="uil uil-car-sideview"></i> Pindah</a>
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?nik={{ $val->nik }}&status=meninggal"><i class="uil uil-sad-dizzy"></i> Meninggal</a>
                                        @endif
                                        <!-- <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?nik={{ $val->nik }}&status=pindah_domisili_dalam"><i class="uil uil-car-sideview"></i> Pindah Domisili Masih Dalam Kabupaten</a>
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?nik={{ $val->nik }}&status=pindah_domisi_luar"><i class="uil uil-car-sideview"></i> Pindah Domisili Ke Luar Kabupaten</a> -->
                                       
                                        @endif
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.detail', $val->id) }}"><i class="uil uil-search"></i> Detail</a>
                                    </div>
                                </div>
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