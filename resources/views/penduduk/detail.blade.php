@extends('layout.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">Penduduk</a></li>
            </ol>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @php
            if(request()->nik){
            $action = route("penduduk.update");
            }else{
            $action = route("penduduk.add");
            }
            @endphp
            <form action="{{ $action }}" method="post" id="form-penduduk">
                @csrf
                <input type="hidden" id="nik" name="nik" value="{{ $penduduk ? $penduduk->nik : '' }}" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title mt-0 mb-1">Form Penduduk</h4>
                                </div>
                                @if($penduduk)
                                @if($penduduk->status == 'pindah')
                                <div class="col-md-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-sm btn-primary btn-rounded" id="lihat-riwayat">Riwayat Pindah</button>
                                </div>
                                @endif
                                @endif
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col-md-6">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">NIK</label>
                                        <p>{{ $penduduk ? $penduduk->nik : '' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col-md-4">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Nama Lengkap</label>
                                        <p>{{ $penduduk ? $penduduk->nama_lengkap : '' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <p>{{ $penduduk ? ucfirst($penduduk->status) : '' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">No KK</label>
                                        <p>{{ $penduduk ? $penduduk->no_kk : '' }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Tempat Lahir</label>
                                        <p>{{ $penduduk ? $penduduk->tempat_lahir : '' }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Tanggal Lahir</label>
                                        <p>{{ $penduduk ? $penduduk->tanggal_lahir : '' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Jenis Kelamin</label>
                                        <p>{{ $penduduk ? $penduduk->jenis_kelamin : '' }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Agama</label>
                                        <p>{{ $penduduk ? $penduduk->agama : '' }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Hubungan Keluarga</label>
                                        <p>{{ $penduduk ? $penduduk->hubungan_keluarga : '' }}</p>
                                        <!-- <input type="text" name="hubungan_keluarga" id="hubungan_keluarga" class="form-control" value="{{ $penduduk ? $penduduk->hubungan_keluarga : '' }}" /> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Pendidikan Terakhir</label>
                                        <p>{{ $penduduk ? $penduduk->pddk_akhir : '' }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Alamat Lengkap</label>
                                        <p>{{ $penduduk->get_pindah ? $penduduk->get_pindah->alamat_baru : $penduduk->alamat }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Kecamatan</label>
                                        @if($penduduk->get_pindah)
                                        @php
                                        $kecamatan = \App\Models\Kecamatan::select('kecamatan')->where('code_kecamatan', $penduduk->get_pindah->kode_kecamatan)->first();
                                        @endphp
                                        <p>{{ $kecamatan->kecamatan  }}</p>
                                        @else
                                        <p>{{ $penduduk->get_kecamatan->kecamatan }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Desa/Kelurahan</label>
                                        @if($penduduk->get_pindah)
                                        @php
                                        $desa = \App\Models\Desa::select('nama_kelurahan')->where('code_kelurahan', $penduduk->get_pindah->kode_desa)->first();
                                        @endphp
                                        <p>{{ $desa->nama_kelurahan }}</p>
                                        @else
                                        <p>{{ $penduduk->get_desa ? $penduduk->get_desa->nama_kelurahan : '' }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">RW</label>
                                        <p>{{ $penduduk->get_pindah ? $penduduk->get_pindah->rw_baru : $penduduk->no_rw }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">RT</label>
                                        <p>{{ $penduduk->get_pindah ? $penduduk->get_pindah->rt_baru : $penduduk->no_rt }}</p>
                                    </div>
                                </div>
                            </div>
                            <div id="form-pindah" class="mt-4 border-top" @if(!$penduduk || $penduduk->status != 'pindah') style="display: none;" @endif>
                                <h4 class="header-title mt-0 mb-1 mt-4">Informasi Alamat Asal</h4>
                                @php
                                if($penduduk){
                                $status_pindah = \App\Models\PendudukPindah::where('nik', $penduduk->nik)
                                ->orderBy('id','desc')
                                ->first();
                                }else{
                                $status_pindah = false;
                                }
                                @endphp
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Alamat Asal</label>
                                            <p>{{ $penduduk ? $penduduk->alamat : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Kecamatan</label>
                                            <p>{{ $penduduk->get_kecamatan ? $penduduk->get_kecamatan->kecamatan : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Desa</label>
                                            <p>{{ $penduduk->get_desa ? $penduduk->get_desa->nama_kelurahan : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">RT Asal</label>
                                            <p>{{ $penduduk ? $penduduk->no_rt : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">RW Asal</label>
                                            <p>{{ $penduduk ? $penduduk->no_rw : '' }} </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4" id="form-keterangan">
                                    <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">Keterangan</label>
                                            <p>{{ $penduduk ? $penduduk->keterangan : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-meninggal" class="mt-4 border-top" @if(!$penduduk || $penduduk->status != 'meninggal') style="display: none;" @endif>
                                <h4 class="header-title mt-0 mb-1 mt-4">Informasi Meninggal</h4>
                                @php
                                if($penduduk){
                                $status_meninggal = \App\Models\PendudukMeninggal::where('nik', $penduduk->nik)
                                ->orderBy('id','desc')
                                ->first();
                                }else{
                                $status_meninggal = false;
                                }
                                @endphp
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Tempat Meninggal</label>
                                            <p>{{ $status_meninggal ? $status_meninggal->alamat : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Tempat Disemayamkan</label>
                                            <p>{{ $status_meninggal ? $status_meninggal->tempat_disemayamkan : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">Tanggal Meninggal</label>
                                            <p>{{ $status_meninggal ? date('d M Y', strtotime($status_meninggal->tanggal_meninggal)) : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="riwayat-pindah" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <h4 class="modal-title">Riwayat Pindah </h4>
                </div>
                <div class="modal-body">
                    <table class="table" id="table-riwayat">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Alamat Asal</th>
                                <th>Alamat Baru</th>
                                <th>RT Asal</th>
                                <th>RW Asal</th>
                                <th>RT Baru</th>
                                <th>RW Baru</th>
                                <th>Tanggal Pindah</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // LIHAT RIWAYAT PINDAH
        $('body').on('click', '#lihat-riwayat', function() {
            $('#riwayat-pindah').modal('show')
            $('#table-riwayat > tbody').html(' ')
            var nik = $("#nik").val()
            var url = '{{ route("penduduk.pindah", ":nik") }}'
            url = url.replace(':nik', nik)
            $.ajax({
                'url': url,
                'dataType': 'json',
                'method': 'get',
            }).done(function(response) {
                $.each(response, function(index, value) {
                    var body = '<tr>'
                    body += '<td>' + value.nik + '</td>'
                    body += '<td>' + value.alamat_asal + '</td>'
                    body += '<td>' + value.alamat_baru + '</td>'
                    body += '<td>' + value.rt_asal + '</td>'
                    body += '<td>' + value.rw_asal + '</td>'
                    body += '<td>' + value.rt_baru + '</td>'
                    body += '<td>' + value.rw_baru + '</td>'
                    body += '<td>' + value.tanggal_pindah + '</td>'
                    body += '</tr>'
                    $('#table-riwayat > tbody').append(body)
                })
            })
        })
    })
</script>
@endpush