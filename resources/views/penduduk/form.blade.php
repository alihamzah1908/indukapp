@extends('layout.master')
@section('content')
<style>
    form .error {
        color: #990073;
    }
</style>
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
                <input type="hidden" name="status" value="{{ request()->status ? request()->status : '' }}" />
                <input type="hidden" name="kode_kecamatan" value="{{ $penduduk ? $penduduk->kode_kecamatan : ''  }}" />
                <input type="hidden" name="kode_desa" value="{{ $penduduk ? $penduduk->kode_desa : ''  }}" />
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
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">No KK</label>
                                        <input type="number" minlength="16" name="kk" id="kk" class="form-control" value="{{ $penduduk ? $penduduk->no_kk : '' }}" @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif/>
                                    </div>
                                </div>
                                @if(request()->status == 'pindah' || request()->status == 'meninggal')
                                <div class="col-md-4">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <select name="status" class="form-control" id="form-status">
                                            <option value="" @if(request()->status == 'pindah' || request()->status == 'meninggal') disabled @endif>Pilih</option>
                                            <option value="pindah" @if($penduduk) {{ request()->status == 'pindah' || request()->status == 'pindah' ? ' selected' : ''}}@endif @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif>Pindah</option>
                                            <option value="meninggal" @if($penduduk) {{ request()->status == 'meninggal' ? ' selected' : ''}}@endif @if(request()->status == 'pindah' || request()->status == 'meninggal') disabled @endif>Meninggal</option>
                                        </select>
                                    </div>
                                </div>
                                @elseif(request()->edit != null)
                                <div class="col-md-4">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <select name="status" class="form-control" id="form-status" disabled>
                                            <option value="">Pilih</option>
                                            <option value="lahir" @if($penduduk) {{ $penduduk->status == 'lahir' ? ' selected' : ''}}@endif>Lahir</option>
                                            <option value="pindah" @if($penduduk) {{ $penduduk->status == 'pindah' || request()->status == 'pindah' ? ' selected' : ''}}@endif>Pindah</option>
                                            <option value="meninggal" @if($penduduk) {{ $penduduk->status == 'meninggal' ? ' selected' : ''}}@endif>Meninggal</option>
                                        </select>
                                    </div>
                                </div>
                                @elseif(request()->edit == null)
                                <div class="col-md-4">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <select name="status" class="form-control" id="form-status">
                                            <option value="">Pilih</option>
                                            <option value="lahir" @if($penduduk) {{ $penduduk->status == 'lahir' ? ' selected' : ''}}@endif>Lahir</option>
                                            <option value="datang" @if($penduduk) {{ $penduduk->status == 'datang' || request()->status == 'pindah' ? ' selected' : ''}}@endif>Datang</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row mt-4">

                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">NIK</label>
                                        <input type="number" minlength="16" name="nik" id="nik" class="form-control" placeholder="isi dengan nik" value="{{ $penduduk ? $penduduk->nik : '' }}" @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif/>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ $penduduk ? $penduduk->nama_lengkap : '' }}" @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif/>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ $penduduk ? $penduduk->tempat_lahir : '' }}" @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif//>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" id="basic-datepicker" class="form-control" value="{{ $penduduk ? $penduduk->tanggal_lahir : '' }}" @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif//>
                                    </div>
                                </div>

                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Jenis Kelamin</label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif/>
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki" @if($penduduk) {{ $penduduk->jenis_kelamin == 'Laki-laki' ? ' selected' : '' }}@endif>Laki - Laki</option>
                                            <option value="Perempuan" @if($penduduk) {{ $penduduk->jenis_kelamin == 'Perempuan' ? ' selected' : '' }}@endif>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Agama</label>
                                        <select name="agama" id="agama" class="form-control" @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif/>
                                            <option value="">Pilih</option>
                                            <option value="Islam" @if($penduduk) {{ $penduduk->agama == 'Islam' ? ' selected' : '' }}@endif>Islam</option>
                                            <option value="Kristen" @if($penduduk) {{ $penduduk->agama == 'Kristen' ? ' selected' : '' }}@endif>Kristen</option>
                                            <option value="Budha" @if($penduduk) {{ $penduduk->agama == 'Budha' ? ' selected' : '' }}@endif>Budha</option>
                                            <option value="Hindu" @if($penduduk) {{ $penduduk->agama == 'Hindu' ? ' selected' : '' }}@endif>Hindu</option>
                                            <option value="Konghucu" @if($penduduk) {{ $penduduk->agama == 'Konghucu' ? ' selected' : '' }}@endif>Konghucu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Hubungan Keluarga</label>
                                        <select name="hubungan_keluarga" id="hubungan_keluarga" class="form-control" @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif/>
                                            <option value="">Pilih</option>
                                            <option value="Kepala Keluarga" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Kepala Keluarga' ? ' selected' : '' }}@endif>Kepala Keluarga</option>
                                            <option value="Suami" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Suami' ? ' selected' : '' }}@endif>Suami</option>
                                            <option value="Istri" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Istri' ? ' selected' : '' }}@endif>Istri</option>
                                            <option value="Anak" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Anak' ? ' selected' : '' }}@endif>Anak</option>
                                            <option value="Menantu" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Menantu' ? ' selected' : '' }}@endif>Menantu</option>
                                            <option value="Cucu" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Cucu' ? ' selected' : '' }}@endif>Cucu</option>
                                            <option value="Orang Tua" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Orang Tua' ? ' selected' : '' }}@endif>Orang Tua</option>
                                            <option value="Mertua" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Mertua' ? ' selected' : '' }}@endif>Mertua</option>
                                            <option value="Famili Lain" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Famili Lain' ? ' selected' : '' }}@endif>Famili Lain</option>
                                            <option value="Lainnya" @if($penduduk) {{ $penduduk->hubungan_keluarga == 'Lainnya' ? ' selected' : '' }}@endif>Lainnya</option>
                                        </select>
                                        <!-- <input type="text" name="hubungan_keluarga" id="hubungan_keluarga" class="form-control" value="{{ $penduduk ? $penduduk->hubungan_keluarga : '' }}" /> -->
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Pendidikan Terakhir</label>
                                        <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control" value="{{ $penduduk ? $penduduk->pddk_akhir : '' }}" @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif//>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Alamat Lengkap</label>
                                        <textarea id="alamat" name="alamat" class="form-control" @if($penduduk) value="{{ $penduduk->get_pindah ? $penduduk->get_pindah->alamat_baru : $penduduk->alamat }}" @else value="" @endif @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif/>@if($penduduk) {{ $penduduk->get_pindah ? $penduduk->get_pindah->alamat_baru : $penduduk->alamat }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Kecamatan</label>
                                        <select id="kode_kecamatan" name="kode_kecamatan" class="form-control" @if(request()->status == 'pindah' || request()->status == 'meninggal') disabled @endif>
                                            @php
                                            $kecamatan = \App\Models\Kecamatan::all();
                                            @endphp
                                            <option value="">Pilih</option>
                                            @foreach($kecamatan as $val)
                                            @if($penduduk)
                                            <option value="{{ $val->code_kecamatan }}" @if($penduduk->get_pindah){{ $val->code_kecamatan == $penduduk->get_pindah->kode_kecamatan ? ' selected' : ''}} @elseif($penduduk) {{ $val->code_kecamatan == $penduduk->kode_kecamatan ? ' selected' : ''}} @endif>{{ $val->kecamatan }}</option>
                                            @else
                                            <option value="{{ $val->code_kecamatan }}" {{ $val->code_kecamatan == Auth::user()->kode_kecamatan ? ' selected' : '' }}>{{ $val->kecamatan }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Desa/Kelurahan</label>
                                        <select name="kode_desa" id="kode_desa" class="form-control" @if(request()->status == 'pindah' || request()->status == 'meninggal') disabled @endif>
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
                                        <input type="number" name="no_rw" id="no_rw" minlength="3" class="form-control" @if($penduduk) value="{{ $penduduk->get_pindah ? $penduduk->get_pindah->rw_baru : $penduduk->no_rw }}" @else value="" @endif @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">RT</label>
                                        <input type="number" name="no_rt" id="no_rt" minlength="3" class="form-control" @if($penduduk) value="{{ $penduduk->get_pindah ? $penduduk->get_pindah->rt_baru : $penduduk->no_rt }}" @else value="" @endif @if(request()->status == 'pindah' || request()->status == 'meninggal') readonly @endif/>
                                    </div>
                                </div>
                            </div>
                            <div id="form-pindah" class="mt-4 border-top" @if(!$penduduk || request()->edit != null || request()->status == 'meninggal') style="display: none;" @endif>
                                <h4 class="header-title mt-0 mb-1 mt-4">Form Kepindahan</h4>
                                @php
                                if($penduduk){
                                $status_pindah = \App\Models\PendudukPindah::where('nik', $penduduk->nik)
                                ->orderBy('id','desc')
                                ->first();
                                }else{
                                $status_pindah = false;
                                }
                                @endphp
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div>
                                            <input type="radio" class="pindah" name="drone" value="dalam">
                                            <label for="huey">Dalam Kabupaten</label>
                                            <input type="radio" class="pindah" name="drone" value="luar">
                                            <label for="dewey">Luar Kabupaten</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="dalam-kabupaten" style="display: none">
                                    <div class="row g-1 mt-4">
                                        <!-- <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Alamat Asal</label>
                                            <textarea name="alamat_asal" id="alamat_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}" @else value="" @endif>@if($penduduk) {{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}@endif</textarea>
                                        </div>
                                    </div> -->
                                        <input type="hidden" name="alamat_dalam_asal" id="alamat_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}" @else value="" @endif>
                                        <div class="col-md-6">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example2">Alamat Baru</label>
                                                <textarea name="alamat_dalam_baru" id="alamat_baru" class="form-control" value=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1 mt-4">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example1">Kecamatan Baru</label>
                                                <select id="kode_kecamatan_pindah" name="kode_kecamatan_pindah" class="form-control">
                                                    @php
                                                    $kecamatan = \App\Models\Kecamatan::all();
                                                    @endphp
                                                    <option value="">Pilih</option>
                                                    @foreach($kecamatan as $val)
                                                    <option value="{{ $val->code_kecamatan }}">{{ $val->kecamatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example1">Desa Baru</label>
                                                <select name="kode_desa_pindah" id="kode_desa_pindah" class="form-control">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1 mt-4">
                                        <!-- <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">RT Asal</label>
                                            <input type="text" name="rt_asal" id="rt_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->rt_baru : $penduduk->no_rt }}" @else value="" @endif/>
                                        </div>
                                    </div> -->
                                        <input type="hidden" name="rw_asal" id="rw_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->rw_baru : $penduduk->no_rw }}" @else value="" @endif />
                                        <input type="hidden" name="rt_asal" id="rt_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->rt_baru : $penduduk->no_rt }}" @else value="" @endif />
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example1">RT Baru</label>
                                                <input type="text" name="rt_dalam_baru" id="rt_baru" class="form-control" value="" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example2">RW Baru</label>
                                                <input type="text" name="rw_dalam_baru" id="rw_baru" class="form-control" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1 mt-4">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example1">Tanggal Pindah</label>
                                                <input type="date" name="tanggal_dalam_pindah" id="tanggal_pindah" class="form-control" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1 mt-4" id="form-keterangan">
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example2">Keterangan Pindah</label>
                                                <textarea name="keterangan" id="keterangan" class="form-control" value=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="luar-kabupaten" style="display: none">
                                    <div class="row g-1 mt-4">
                                        <!-- <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Alamat Asal</label>
                                            <textarea name="alamat_asal" id="alamat_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}" @else value="" @endif>@if($penduduk) {{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}@endif</textarea>
                                        </div>
                                    </div> -->
                                        <input type="hidden" name="alamat_asal" id="alamat_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}" @else value="" @endif>
                                        <div class="col-md-6">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example2">Alamat Baru</label>
                                                <textarea name="alamat_baru" id="alamat_baru" class="form-control" value=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1 mt-4">
                                        <!-- <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">RT Asal</label>
                                            <input type="text" name="rt_asal" id="rt_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->rt_baru : $penduduk->no_rt }}" @else value="" @endif/>
                                        </div>
                                    </div> -->
                                        <input type="hidden" name="rw_asal" id="rw_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->rw_baru : $penduduk->no_rw }}" @else value="" @endif />
                                        <input type="hidden" name="rt_asal" id="rt_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->rt_baru : $penduduk->no_rt }}" @else value="" @endif />
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example1">RT Baru</label>
                                                <input type="text" name="rt_baru" id="rt_baru" class="form-control" value="" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example2">RW Baru</label>
                                                <input type="text" name="rw_baru" id="rw_baru" class="form-control" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1 mt-4">
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example1">Tanggal Pindah</label>
                                                <input type="date" name="tanggal_pindah" id="tanggal_pindah" class="form-control" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1 mt-4" id="form-keterangan">
                                        <div class="col">
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example2">Keterangan Pindah</label>
                                                <textarea name="keterangan" id="keterangan" class="form-control" value=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form-meninggal" class="mt-4 border-top" @if(!$penduduk || request()->edit != null || request()->status == 'pindah') style="display: none;" @endif>
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
                                            <textarea name="alamat_meninggal" id="alamat_meninggal" class="form-control" value="{{ $status_meninggal ? $status_meninggal->alamat : '' }}">{{ $status_meninggal ? $status_meninggal->alamat : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <!-- Name input -->
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Tempat Disemayamkan</label>
                                            <textarea name="tempat_disemayamkan" id="tempat_disemayamkan" class="form-control" value="{{ $status_meninggal ? $status_meninggal->alamat : '' }}">{{ $status_meninggal ? $status_meninggal->alamat : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-1 mt-4">
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

        // GET DESA 
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

        // GET DESA WITHOUT CHANGE KECAMATAN
        $.ajax({
            url: '{{ route("data.kecamatan") }}',
            dataType: 'json',
            method: 'get',
            data: {
                'kode_kecamatan': '{{ Auth::user()->kode_kecamatan }}'
            }
        }).done(function(response) {
            $.each(response, function(index, value) {
                var body = '<option value=' + value.code_kelurahan + '>' + value.nama_kelurahan + '</option>'
                $('#kode_desa').append(body)
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

    $('body').on('click', '.pindah', function() {
        var data = $(this).val()
        if (data == 'dalam') {
            $('#dalam-kabupaten').show()
            $('#luar-kabupaten').hide()
        } else if (data == 'luar') {
            $('#luar-kabupaten').show()
            $('#dalam-kabupaten').hide()
        }
    })
</script>
<script>
    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });
    $("#form-penduduk").validate({
        rules: {
            nik: {
                required: true,
            },
            kk: {
                required: true,
            },
            nama_lengkap: {
                required: true,
            },
            no_rw: {
                required: true,
            },
            no_rt: {
                required: true,
            }
        },
        messages: {
            nik: {
                required: "Mohon isi NIK",
                maxlength: 16
            },
            kk: {
                required: "Mohon isi nomor KK",
                maxlength: 16
            },
            nama_lengkap: "Mohon isi nama lengkap",
            no_rw: {
                required: "Mohon isi nomor rt",
                maxlength: 3
            },
            no_rt: {
                required: "Mohon isi nomor rw",
                maxlength: 3
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@endpush