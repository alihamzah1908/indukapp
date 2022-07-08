<style>
    table {
        border-collapse: collapse;
    }

    .page-break {
        page-break-after: always;
    }
</style>
<div class="col-lg-12">
    @php
    $desa = \App\Models\Desa::where('code_kelurahan', Auth::user()->kode_desa)->first();
    @endphp
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="header-title mt-0 mb-1">Laporan Penduduk Desa {{ $desa->nama_kelurahan }} {{ request()->no_rw ? 'RW ' . request()->no_rw : ' '}} </h4>
                </div>
            </div>
            <div class="row mt-4">
                <div class="table-responsive">
                    <table class="table table-striped mb-0" border='1'>
                        <tr>
                            <th>No KK</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>JK</th>
                            <th>Alamat</th>
                            <th>Ket.</th>
                        </tr>
                        @foreach($penduduk as $val)
                        @php
                        if($val["jenis_kelamin"] == 'Laki-laki'){
                            $jk = 'L';
                        }elseif($val["jenis_kelamin"] == 'Perempuan'){
                            $jk = 'P';
                        }
                        else {
                            $jk = NULL;
                        }
                        @endphp
                        <tr>
                            <td>{{ $val["no_kk"] }}</td>
                            <td>{{ $val["nik"] }}</td>
                            <td>{{ $val["nama_lengkap"] }}</td>
                            <td>{{ $val["tempat_lahir"] }}</td>
                            <td>{{ $val["tanggal_lahir"] != '' || $val["tanggal_lahir"] != null ? date('d M Y', strtotime($val["tanggal_lahir"])) : '' }}</td>
                            <td>{{ $jk }}</td>
                            <td height="50">{{ $val["alamat"] }}</td>
                            <td>
                                @if($val["status"] == 'meninggal')
                                <span class="badge badge-danger">
                                    {{ ucfirst($val->status) }}
                                </span>
                               {{-- @elseif(Auth::user()->role != 'super admin' && $val->status == 'pindah_domisili_dalam' && $val->status == 'pindah_domisili_luar' && $val->status == 'pindah_permanen_dalam' && $val->status == 'pindah_permanen_luar' && $val->kode_desa_baru == Auth::user()->kode_desa) --}}
                                @elseif(Auth::user()->role != 'super admin' && $val["kode_desa_baru"] == Auth::user()->kode_desa)
                                <span class="badge badge-success">
                                    @if($val["status"] == 'pindah_permanen_dalam')
                                        Datang Permanen
                                    @elseif($val["status"] == 'pindah_domisili_dalam')
                                        Datang Non Permanen
                                    @endif
                                </span>
                                @elseif($val["status"] == 'pindah_permanen_dalam')
                                <span class="badge badge-primary">
                                    Pindah Permanen Dalam Daerah kabupaten
                                </span>
                                @elseif($val["status"] == 'pindah_permanen_luar')
                                <span class="badge badge-primary">
                                    Pindah Permanen Luar Daerah kabupaten
                                </span>
                                @elseif($val["status"] == 'pindah_domisili_dalam')
                                <span class="badge badge-primary">
                                    Penduduk Beda Domisili Dalam kabupaten
                                </span>
                                @elseif($val["status"] == 'pindah_domisili_luar')
                                <span class="badge badge-primary">
                                    Penduduk Beda Domisili Luar kabupaten
                                </span>
                                @elseif($val["status"] == 'pindah' && $val["status"] == 'luar')
                                <span class="badge badge-primary">
                                    Pindah (Luar Ciamis)
                                </span>
                                @elseif($val["status"] == 'datang')
                                <span class="badge badge-success">
                                    Datang Permanen
                                </span>
                                @elseif($val["status"] == 'datang_non_permanen')
                                <span class="badge badge-success">
                                    Datang Non Permanen
                                </span>
                                @elseif($val["status"]== 'lahir')
                                <span class="badge badge-warning">
                                    {{ ucfirst($val["status"]) }}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>