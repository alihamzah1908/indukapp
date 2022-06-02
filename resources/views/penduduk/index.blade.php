@extends('layout.master')
@section('content')
<div class="row page-title">
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="header-title mt-0 mb-1">Data Penduduk</h4>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a href="{{ route('penduduk.form') }}">
                        <button class="btn btn-sm btn-primary-custom btn-rounded">Tambah Data</button>
                    </a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <tr>
                            <th>Nik</th>
                            <th>No KK</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat Lahir</th>
                            <th>Aksi</th>
                        </tr>
                        @foreach($penduduk as $val)
                        <tr>
                            <td>{{ $val->nik }}</td>
                            <td>{{ $val->no_kk }}</td>
                            <td>{{ $val->nama_lengkap }}</td>
                            <td>{{ $val->tempat_lahir }}</td>
                            <td>
                                <a href="{{ route('penduduk.form') }}?nik={{ $val->nik }}">
                                    <button class="btn btn-sm btn-success-custom btn-rounded">Form</button>
                                </a>
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