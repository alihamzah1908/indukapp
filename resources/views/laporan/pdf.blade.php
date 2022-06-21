<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="header-title mt-0 mb-1">Laporan Penduduk</h4>
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
                            <td>{{ $val->nik }}</td>
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
    </div>
</div>