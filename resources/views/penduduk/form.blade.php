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
                            <h4 class="header-title mt-0 mb-1">Form Penduduk</h4>
                            <p class="sub-header">
                                Mohon isi sesuai dengan form yang sudah disediakan
                            </p>
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
                                <div class="col-md-4" id="form-status">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <select name="status" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="lahir" @if($penduduk) {{ $penduduk->status == 'lahir' ? ' selected' : ''}}@endif>Lahir</option>
                                            <option value="pindah" @if($penduduk) {{ $penduduk->status == 'pindah' ? ' selected' : ''}}@endif>Pindah</option>
                                            <option value="meninggal" @if($penduduk) {{ $penduduk->status == 'meninggal' ? ' selected' : ''}}@endif>Meninggal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-outline" style="margin-top: 30px;">
                                        <a href="#form-pindah">
                                            <button class="btn btn-primary" style="display:none" id="show-form-pindah" type="button">Lihat Form Pindah</button>
                                        </a>
                                        <a href="#form-meninggal">
                                            <button class="btn btn-primary" style="display:none" id="show-form-meninggal" type="button">Lihat Form Meninggal</button>
                                        </a>
                                        <button class="btn btn-primary" style="display:none" id="show-form-riwayat" type="button">Riwayat Pindah</button>
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
                                        <select id="jenis_kelamin" class="form-control">
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
                                        <input type="text" name="agama" id="agama" class="form-control" value="{{ $penduduk ? $penduduk->agama : '' }}" />
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Hubungan Keluarga</label>
                                        <input type="text" name="hubungan_keluarga" id="hubungan_keluarga" class="form-control" value="{{ $penduduk ? $penduduk->hubungan_keluarga : '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Alamat Lengkap</label>
                                        <textarea id="alamat" name="alamat" class="form-control" value="{{ $penduduk ? $penduduk->alamat : '' }}">{{ $penduduk ? $penduduk->alamat : '' }}</textarea>
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
                                            <option value="{{ $val->code_kecamatan }}" @if($penduduk){{ $val->code_kecamatan == $penduduk->kode_kecamatan ? ' selected' : ''}}@endif>{{ $val->kecamatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Desa/Kelurahan</label>
                                        <input type="text" name="kelurahan" id="kelurahan" class="form-control" value="{{ $penduduk ? $penduduk->kelurahan : '' }}" />
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">RW</label>
                                        <input type="text" name="no_rw" id="no_rw" class="form-control" value="{{ $penduduk ? $penduduk->no_rw : '' }}" />
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">RT</label>
                                        <input type="text" name="no_rt" id="no_rt" class="form-control" value="{{ $penduduk ? $penduduk->no_rt : '' }}" />
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
                            @if($penduduk)
                            @if($penduduk->status == 'pindah')
                            @php 
                            $status_pindah = \App\Models\PendudukPindah::where('nik', $penduduk->nik)->first();
                            @endphp
                            <div id="form-pindah" class="mt-4 border-top">
                                <h4 class="header-title mt-0 mb-1 mt-4">Form Status Pindah</h4>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Alamat Asal</label>
                                            <textarea name="alamat_asal" id="alamat_asal" class="form-control" value="{{ $status_pindah ? $status_pindah->alamat_asal : '' }}">{{ $status_pindah ? $status_pindah->alamat_asal: ''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">Alamat Baru</label>
                                            <textarea name="alamat_baru" id="alamat_baru" class="form-control" value="{{ $status_pindah ? $status_pindah->alamat_baru : ''}}">{{ $status_pindah ? $status_pindah->alamat_baru : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">RT Asal</label>
                                            <input type="text" name="rt_asal" id="rt_asal" class="form-control" value="{{ $status_pindah ? $status_pindah->rt_asal : ''}}"/>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">RT Baru</label>
                                            <input type="text" name="rt_baru" id="rt_baru" class="form-control" value="{{ $status_pindah ? $status_pindah->rt_baru : '' }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">RW Asal</label>
                                            <input type="text" name="rw_asal" id="rw_asal" class="form-control" value="{{ $status_pindah ? $status_pindah->rw_asal : ''}}"/>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">RW Baru</label>
                                            <input type="text" name="rw_baru" id="rw_baru" class="form-control" value="{{ $status_pindah ? $status_pindah->rw_baru : ''}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Tanggal Pindah</label>
                                            <input type="date" name="tanggal_pindah" id="tanggal_pindah" class="form-control" value="{{ $status_pindah ? $status_pindah->tanggal_pindah : ''}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                            @if($penduduk)
                            @if($penduduk->status == 'meninggal')
                            <div id="form-meninggal" class="mt-4 border-top">
                                <h4 class="header-title mt-0 mb-1 mt-4">Form Status Meninggal</h4>
                                <div class="row g-1 mt-4">
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Alamat</label>
                                            <textarea name="alamat_meninggal" id="alamat_meninggal" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Email input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example2">Tanggal Meninggal</label>
                                            <input type="date" name="tanggal_meninggal" id="tanggal_meninggal" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                            <div class="row mt-4">
                                <div class="col-md-1">
                                    <!-- Name input -->
                                    <div class="form-outline" style="margin-top: 30px;">
                                        @if(request()->nik)
                                        <button class="btn btn-primary simpan" type="submit">Ubah</button>
                                        @else 
                                        <button class="btn btn-primary update" type="submit">Simpan</button>
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
</div>
@endsection