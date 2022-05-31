@extends('layout.master')
@section('content')
<div class="row page-title">
    <div class="col-md-12 ml-2">
        <a href="{{ route('penduduk.form') }}">
            <button class="btn btn-sm btn-primary">Tambah Data</button>
        </a>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title mt-0 mb-1">Data Penduduk</h4>
            <p class="sub-header">
                Use <code>.table-striped</code> to add zebra-striping to any table row within the <code>&lt;tbody&gt;</code>.
            </p>

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
                                <button class="btn btn-sm btn-success">Form</button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
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