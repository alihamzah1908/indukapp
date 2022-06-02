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
                <input type="hidden" name="nik" value="{{ $penduduk ? $penduduk->nik : '' }}" />
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
                                        <input type="text" name="nik" id="nik" class="form-control" placeholder="isi dengan nik" value="{{ $penduduk ? $penduduk->nik : '' }}" @if(request()->nik) disabled @endif/>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col-md-4">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ $penduduk ? $penduduk->nama_lengkap : '' }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <select name="status" class="form-control" id="form-status">
                                            <option value="">Pilih</option>
                                            <option value="lahir" @if($penduduk) {{ $penduduk->status == 'lahir' ? ' selected' : ''}}@endif>Lahir</option>
                                            <option value="pindah" @if($penduduk) {{ $penduduk->status == 'pindah' ? ' selected' : ''}}@endif>Pindah / Datang</option>
                                            <option value="meninggal" @if($penduduk) {{ $penduduk->status == 'meninggal' ? ' selected' : ''}}@endif>Meninggal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">No KK</label>
                                        <input type="text" name="kk" id="kk" class="form-control" value="{{ $penduduk ? $penduduk->no_kk : '' }}" />
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ $penduduk ? $penduduk->tempat_lahir : '' }}" />
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Tanggal Lahir</label>
                                        <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ $penduduk ? $penduduk->tanggal_lahir : '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Jenis Kelamin</label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="1" @if($penduduk) {{ $penduduk->jenis_kelamin == '1' ? ' selected' : '' }}@endif>Laki - Laki</option>
                                            <option value="2" @if($penduduk) {{ $penduduk->jenis_kelamin == '2' ? ' selected' : '' }}@endif>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Agama</label>
                                        <select name="agama" id="agama" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="islam" @if($penduduk) {{ $penduduk->agama == 'islam' ? ' selected' : '' }}@endif>Islam</option>
                                            <option value="kristen" @if($penduduk) {{ $penduduk->agama == 'kristen' ? ' selected' : '' }}@endif>Kristen</option>
                                            <option value="budha" @if($penduduk) {{ $penduduk->agama == 'budha' ? ' selected' : '' }}@endif>Budha</option>
                                            <option value="hindu" @if($penduduk) {{ $penduduk->agama == 'hindu' ? ' selected' : '' }}@endif>Hindu</option>
                                            <option value="konghucu" @if($penduduk) {{ $penduduk->agama == 'konghucu' ? ' selected' : '' }}@endif>Konghucu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Hubungan Keluarga</label>
                                        <select name="hubungan_keluarga" id="hubungan_keluarga" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="1" @if($penduduk) {{ $penduduk->hubungan_keluarga == '1' ? ' selected' : '' }}@endif>Kepala Keluarga</option>
                                            <option value="2" @if($penduduk) {{ $penduduk->hubungan_keluarga == '2' ? ' selected' : '' }}@endif>Suami</option>
                                            <option value="3" @if($penduduk) {{ $penduduk->hubungan_keluarga == '3' ? ' selected' : '' }}@endif>Istri</option>
                                            <option value="4" @if($penduduk) {{ $penduduk->hubungan_keluarga == '4' ? ' selected' : '' }}@endif>Anak</option>
                                            <option value="5" @if($penduduk) {{ $penduduk->hubungan_keluarga == '5' ? ' selected' : '' }}@endif>Menantu</option>
                                            <option value="6" @if($penduduk) {{ $penduduk->hubungan_keluarga == '6' ? ' selected' : '' }}@endif>Cucu</option>
                                            <option value="7" @if($penduduk) {{ $penduduk->hubungan_keluarga == '7' ? ' selected' : '' }}@endif>Orang Tua</option>
                                            <option value="8" @if($penduduk) {{ $penduduk->hubungan_keluarga == '8' ? ' selected' : '' }}@endif>Mertua</option>
                                            <option value="9" @if($penduduk) {{ $penduduk->hubungan_keluarga == '9' ? ' selected' : '' }}@endif>Famili Lain</option>
                                            <option value="10" @if($penduduk) {{ $penduduk->hubungan_keluarga == '10' ? ' selected' : '' }}@endif>Lainya</option>
                                        </select>
                                        <!-- <input type="text" name="hubungan_keluarga" id="hubungan_keluarga" class="form-control" value="{{ $penduduk ? $penduduk->hubungan_keluarga : '' }}" /> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Alamat Lengkap</label>
                                        <textarea id="alamat" name="alamat" class="form-control" value="{{ $penduduk->get_pindah ? $penduduk->get_pindah->alamat_baru : $penduduk->alamat }}">{{ $penduduk->get_pindah ? $penduduk->get_pindah->alamat_baru : $penduduk->alamat }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Kecamatan</label>
                                        <select id="kode_kecamatan" name="kode_kecamatan" class="form-control">
                                            @php
                                            $kecamatan = \App\Models\Kecamatan::all();
                                            @endphp
                                            <option value="">Pilih</option>
                                            @foreach($kecamatan as $val)
                                                @if($penduduk->get_pindah)
                                                    <option value="{{ $val->code_kecamatan }}" @if($penduduk->get_pindah){{ $val->code_kecamatan == $penduduk->get_pindah->kode_kecamatan ? ' selected' : ''}}@endif>{{ $val->kecamatan }}</option>
                                                @else
                                                    <option value="{{ $val->code_kecamatan }}" @if($penduduk){{ $val->code_kecamatan == $penduduk->kode_kecamatan ? ' selected' : ''}}@endif>{{ $val->kecamatan }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Desa/Kelurahan</label>
                                        <select name="kode_desa" id="kode_desa" class="form-control">
                                            @if($penduduk)
                                            @php
                                            if($penduduk->get_pindah){
                                                $desa = \App\Models\Desa::where('code_kecamatan', $penduduk->get_pindah->kode_kecamatan)->get();
                                            }else{
                                                $desa = \App\Models\Desa::where('code_kecamatan', $penduduk->kode_kecamatan)->get();
                                            }
                                            @endphp
                                            @foreach($desa as $val)
                                                @if($penduduk->get_pindah)
                                                <option value="{{ $val->code_kelurahan }}" @if($penduduk->get_pindah){{ $penduduk->get_pindah->kode_desa == $val->code_kelurahan ? ' selected' : ''}}@endif>{{ $val->nama_kelurahan }}</option>
                                                @else
                                                <option value="{{ $val->code_kelurahan }}" @if($penduduk) {{ $penduduk->kode_desa == $val->code_kelurahan ? ' selected' : ''}}@endif>{{ $val->nama_kelurahan }}</option>
                                                @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">RW</label>
                                        <input type="text" name="no_rw" id="no_rw" class="form-control" value="{{ $penduduk->get_pindah ? $penduduk->get_pindah->rw_baru : $penduduk->no_rw }}" />
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">RT</label>
                                        <input type="text" name="no_rt" id="no_rt" class="form-control" value="{{ $penduduk->get_pindah ? $penduduk->get_pindah->rt_baru : $penduduk->no_rt }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4" id="form-keterangan">
                                <div class="col">
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" class="form-control" value="{{ $penduduk ? $penduduk->keterangan : '' }}">{{ $penduduk ? $penduduk->keterangan : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="form-pindah" class="mt-4 border-top" @if(!$penduduk || $penduduk->status != 'pindah') style="display: none;" @endif>
                                <h4 class="header-title mt-0 mb-1 mt-4">Informasi Pindah / Datang</h4>
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
                                            <textarea name="alamat_asal" id="alamat_asal" class="form-control" value="{{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}">{{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">Alamat Baru</label>
                                            <textarea name="alamat_baru" id="alamat_baru" class="form-control" value="" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Kecamatan</label>
                                            <select id="kode_kecamatan_pindah" name="kode_kecamatan_pindah" class="form-control">
                                                @php
                                                $kecamatan = \App\Models\Kecamatan::all();
                                                @endphp
                                                <option value="">Pilih</option>
                                                @foreach($kecamatan as $val)
                                                    @if($penduduk->get_pindah)
                                                        <option value="{{ $val->code_kecamatan }}" @if($penduduk->get_pindah){{ $val->code_kecamatan == $penduduk->get_pindah->kode_kecamatan ? ' selected' : ''}}@endif>{{ $val->kecamatan }}</option>
                                                    @else
                                                        <option value="{{ $val->code_kecamatan }}" @if($penduduk){{ $val->code_kecamatan == $penduduk->kode_kecamatan ? ' selected' : ''}}@endif>{{ $val->kecamatan }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Desa</label>
                                            <select name="kode_desa_pindah" id="kode_desa_pindah" class="form-control">
                                                @if($penduduk)
                                                @php
                                                if($penduduk->get_pindah){
                                                    $desa = \App\Models\Desa::where('code_kecamatan', $penduduk->get_pindah->kode_kecamatan)->get();
                                                }else{
                                                    $desa = \App\Models\Desa::where('code_kecamatan', $penduduk->kode_kecamatan)->get();
                                                }
                                                @endphp
                                                    @foreach($desa as $val)
                                                        @if($penduduk->get_pindah)
                                                            <option value="{{ $val->code_kelurahan }}" @if($penduduk->get_pindah){{ $penduduk->get_pindah->kode_desa == $val->code_kelurahan ? ' selected' : ''}}@endif>{{ $val->nama_kelurahan }}</option>
                                                        @else
                                                            <option value="{{ $val->code_kelurahan }}" @if($penduduk) {{ $penduduk->kode_desa == $val->code_kelurahan ? ' selected' : ''}}@endif>{{ $val->nama_kelurahan }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">RT Asal</label>
                                            <input type="text" name="rt_asal" id="rt_asal" class="form-control" value="{{ $status_pindah ? $status_pindah->rt_baru : $penduduk->no_rt }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">RT Baru</label>
                                            <input type="text" name="rt_baru" id="rt_baru" class="form-control" value="" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">RW Asal</label>
                                            <input type="text" name="rw_asal" id="rw_asal" class="form-control" value="{{ $status_pindah ? $status_pindah->rw_baru : $penduduk->no_rw }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">RW Baru</label>
                                            <input type="text" name="rw_baru" id="rw_baru" class="form-control" value="" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Tanggal Pindah</label>
                                            <input type="date" name="tanggal_pindah" id="tanggal_pindah" class="form-control" value="{{ $status_pindah ? $status_pindah->tanggal_pindah : ''}}" />
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
                                            <label class="form-label font-weight-bold" for="form9Example1">Alamat Meninggal</label>
                                            <textarea name="alamat_meninggal" id="alamat_meninggal" class="form-control" value="{{ $status_meninggal ? $status_meninggal->alamat : '' }}">{{ $status_meninggal ? $status_meninggal->alamat : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">Tanggal Meninggal</label>
                                            <input type="date" name="tanggal_meninggal" id="tanggal_meninggal" class="form-control" value="{{ $status_meninggal ? $status_meninggal->tanggal_meninggal : '' }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-1">
                                    <!-- Name input -->
                                    <div class="form-outline" style="margin-top: 30px;">
                                        @if(request()->nik)
                                        <button class="btn btn-primary-custom btn-rounded simpan" type="submit">Ubah</button>
                                        @else
                                        <button class="btn btn-primary-custom btn-rounded update" type="submit">Simpan</button>
                                        @endif
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
                                <th>RT Baru</th>
                                <th>RW Asal</th>
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
        $('body').on('change', '#form-status', function() {
            var status = $(this).val()
            if (status == 'pindah') {
                $('#form-pindah').show()
                $('#form-meninggal').hide()
            } else if (status == 'meninggal') {
                $('#form-pindah').hide()
                $('#form-meninggal').show()
            } else if (status == 'lahir' || status == '') {
                $('#form-pindah').hide()
                $('#form-meninggal').hide()
            }
        })

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
                    body += '<td>' + value.rt_baru + '</td>'
                    body += '<td>' + value.rw_asal + '</td>'
                    body += '<td>' + value.rw_baru + '</td>'
                    body += '<td>' + value.tanggal_pindah + '</td>'
                    body += '</tr>'
                    $('#table-riwayat > tbody').append(body)
                })
            })
        })

        // GET KECAMATAN
        $('body').on('change', '#kode_kecamatan', function() {
            $('#kode_desa').html(' ')
            $.ajax({
                url: '{{ route("data.kecamatan") }}',
                dataType: 'json',
                method: 'get',
                data: {
                    'kode_kecamatan': $(this).val()
                }
            }).done(function(response) {
                $.each(response, function(index, value) {
                    var body = '<option value=' + value.code_kelurahan + '>' + value.nama_kelurahan + '</option>'
                    $('#kode_desa').append(body)
                })
            })
        })

        // GET KECAMATAN PINDAH
        $('body').on('change', '#kode_kecamatan_pindah', function() {
            $('#kode_desa_pindah').html(' ')
            $.ajax({
                url: '{{ route("data.kecamatan") }}',
                dataType: 'json',
                method: 'get',
                data: {
                    'kode_kecamatan': $(this).val()
                }
            }).done(function(response) {
                $.each(response, function(index, value) {
                    var body = '<option value=' + value.code_kelurahan + '>' + value.nama_kelurahan + '</option>'
                    $('#kode_desa_pindah').append(body)
                })
            })
        })
    })
</script>
@endpush