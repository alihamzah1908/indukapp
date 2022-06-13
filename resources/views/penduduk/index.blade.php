@extends('layout.master')
@section('content')
<div class="row page-title">
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('penduduk.index') }}" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold" for="form9Example2">Status</label>
                        <select name="status" class="form-control">
                            <option value="">Pilih</option>
                            <option value="meninggal"{{ request()->status == 'meninggal' ? ' selected' : ''}}>Meninggal</option>
                            <option value="pindah"{{ request()->status == 'pindah' ? ' selected' : ''}}>Pindah</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold" for="form9Example2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">Pilih</option>
                            <option value="Laki-laki"{{ request()->jenis_kelamin == 'Laki-laki' ? ' selected' : ''}}>Laki - Laki</option>
                            <option value="Perempuan"{{ request()->jenis_kelamin == 'Perempuan' ? ' selected' : ''}}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-weight-bold" for="form9Example2">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ request()->nik }}" />
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        <button class="btn btn-primary-custom btn-rounded mt-4" type="submit">Cari</button>
                        <button class="btn btn-primary btn-rounded mt-4 ml-2" type="reset">Reset</button>
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
                        <button class="btn btn-sm btn-success btn-rounded">Tambah Data</button>
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
                            <th>Status</th>
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
                            <td>{{ $val->tanggal_lahir }}</td>
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
                                @elseif($val->status == 'lahir')
                                <span class="badge badge-success">
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
                                    <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?nik={{ $val->nik }}&edit={{$val->id}}">Edit</a>
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.form') }}?nik={{ $val->nik }}&status=pindah">Pindah</a>
                                        <a class="dropdown-item" role="presentation" href="{{ route('penduduk.detail', $val->id) }}">Detail</a>
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