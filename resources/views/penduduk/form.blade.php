@extends('layout.master')
@section('content')
<style>
    form .error {
        color: red;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-left mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('penduduk.index') }}">List Penduduk / </a></li>
            </ol>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @php
            if(request()->nik || request()->id){
                $action = route("penduduk.update");
            }else{
                $action = route("penduduk.add");
            }
            @endphp
            <form action="{{ $action }}" method="post" id="{{ request()->nik ? 'edit-penduduk' : 'form-penduduk'}}">
                @csrf
                <input type="hidden" name="nik" value="{{ $penduduk ? $penduduk->nik : '' }}" />
                <input type="hidden" name="status" value="{{ request()->status ? request()->status : '' }}" />
                <input type="hidden" name="nama_kecamatan" value="{{ $penduduk ? $penduduk->kecamatan : ''  }}" />
                <input type="hidden" name="kelurahan" value="{{ $penduduk ? $penduduk->kelurahan : ''  }}" />
                <input type="hidden" name="kode_kecamatan" value="{{ $penduduk ? $penduduk->kode_kecamatan : ''  }}" />
                <input type="hidden" name="kode_desa" value="{{ $penduduk ? $penduduk->kode_desa : ''  }}" />
                <input type="hidden" name="kode_desa_asal" value="{{ $penduduk && $penduduk->get_pindah != '' ? $penduduk->get_pindah->kode_desa_baru : ''  }}" />
                <input type="hidden" name="kode_kecamatan_asal" value="{{ $penduduk && $penduduk->get_pindah != '' ? $penduduk->get_pindah->kode_kecamatan_baru : ''  }}" />
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            <div class="row ml-0" style="border-bottom: 1px solid #990073;">
                                <div class="col-md-6">
                                    @if(request()->status == 'meninggal')
                                        <h4 class="header-title mt-0 mb-3">Formulir Meninggal</h4>
                                    @elseif(request()->status == 'pindah')
                                        <h4 class="header-title mt-0 mb-3">Formulir Pindah Penduduk</h4>
                                    @else 
                                        <h4 class="header-title mt-0 mb-3">Formulir Penduduk</h4>
                                    @endif
                                    
                                </div>
                                @if($penduduk)
                                    @if($penduduk->status == 'pindah')
                                    <div class="col-md-6 d-flex justify-content-end mb-4">
                                        <button type="button" class="btn btn-sm btn-primary btn-rounded" id="lihat-riwayat"><i class="uil uil-search"></i> Riwayat Pindah</button>
                                    </div>
                                    @endif
                                @endif
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">No KK</label>
                                        <input type="number" minlength="16" name="kk" id="kk" class="form-control" value="{{ $penduduk ? $penduduk->no_kk : '' }}" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') readonly @endif/>
                                    </div>
                                </div>
                                @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_luar' || request()->status == 'pindah_domisili_dalam')
                                <div class="col-md-4">
                                    <!-- <input type="hidden" name="status" value="{{ request()->status }}" /> -->
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <select name="status" class="form-control" id="form_status_pindah" required>
                                            <option value="">Pilih</option>
                                            <option value="pindah_domisili_dalam">Penduduk Beda Domisili Dalam kabupaten</option>
                                            <option value="pindah_domisili_luar">Penduduk Beda Domisili Luar kabupaten</option>
                                            <option value="pindah_permanen_dalam">Pindah Permanen Dalam Daerah kabupaten</option>
                                            <option value="pindah_permanen_luar">Pindah Permanen Luar Daerah kabupaten</option>
                                            <option value="meninggal">Meninggal</option>
                                        </select>
                                    </div>
                                </div>
                                @elseif(request()->edit != null)
                                <div class="col-md-4">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <select name="status" class="form-control" id="form_status">
                                            <option value="">Pilih</option>
                                            <option value="lahir" @if($penduduk) {{ $penduduk->status == 'lahir' ? ' selected' : ''}}@endif>Lahir</option>
                                            <option value="pindah_domisili_dalam"@if($penduduk) {{ $penduduk->status == 'pindah_domisili_dalam' ? ' selected' : ''}}@endif>Penduduk Beda Domisili Dalam kabupaten</option>
                                            <option value="pindah_domisili_luar"@if($penduduk) {{ $penduduk->status == 'pindah_domisili_luar' ? ' selected' : ''}}@endif>Penduduk Beda Domisili Luar kabupaten</option>
                                            <option value="pindah_permanen_dalam"@if($penduduk) {{ $penduduk->status == 'pindah_permanen_dalam' ? ' selected' : ''}}@endif>Pindah Permanen Dalam Daerah kabupaten</option>
                                            <option value="pindah_permanen_luar"@if($penduduk) {{ $penduduk->status == 'pindah_permanen_luar' ? ' selected' : ''}}@endif>Pindah Permanen Luar Daerah kabupaten</option>
                                            <option value="datang" @if($penduduk) {{ $penduduk->status == 'datang' || request()->status == 'pindah' ? ' selected' : ''}}@endif>Datang Permanen</option>
                                            <option value="datang_non_permanen" @if($penduduk) {{ $penduduk->status == 'datang_non_permanen' || request()->status == 'pindah' ? ' selected' : ''}}@endif>Datang Permanen</option>
                                            <option value="meninggal" @if($penduduk) {{ $penduduk->status == 'meninggal' ? ' selected' : ''}}@endif>Meninggal</option>
                                        </select>
                                    </div>
                                </div>
                                @elseif(request()->edit == null && request()->status != 'meninggal')
                                <div class="col-md-4">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <select name="status" class="form-control" id="form_status">
                                            <option value="">Pilih</option>
                                            <option value="lahir" @if($penduduk) {{ $penduduk->status == 'lahir' ? ' selected' : ''}}@endif>Lahir</option>
                                            <option value="datang" @if($penduduk) {{ $penduduk->status == 'datang' || request()->status == 'pindah' ? ' selected' : ''}}@endif>Datang Permanen</option>
                                            <option value="datang_non_permanen" @if($penduduk) {{ $penduduk->status == 'datang_non_permanen' || request()->status == 'pindah' ? ' selected' : ''}}@endif>Datang Non Permanen</option>
                                        </select>
                                    </div>
                                </div>
                                @elseif(request()->status == 'meninggal')
                                <div class="col-md-4">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Status Data</label>
                                        <select name="status" class="form-control" id="form_status">
                                            <option value="">Pilih</option>
                                            <option value="meninggal" @if($penduduk) {{ $penduduk->status == 'meninggal' || request()->status == 'meninggal' ? ' selected' : ''}}@endif>Meninggal</option>
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
                                        <input type="number" name="nik" id="nik" class="form-control" placeholder="isi dengan nik" value="{{ $penduduk ? $penduduk->nik : '' }}" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') readonly @endif/>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ $penduduk ? $penduduk->nama_lengkap : '' }}" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') readonly @endif/>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ $penduduk ? $penduduk->tempat_lahir : '' }}" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') readonly @endif//>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" id="basic-datepicker" class="form-control basic-datepicker" value="{{ $penduduk ? $penduduk->tanggal_lahir : '' }}" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') readonly @endif//>
                                    </div>
                                </div>

                                <div class="col">
                                    <input type="hidden" name="jenis_kelamin" value="{{ $penduduk ? $penduduk->jenis_kelamin : ''  }}" />
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Jenis Kelamin</label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') disabled @endif/>
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki" @if($penduduk) {{ $penduduk->jenis_kelamin == 'Laki-laki' ? ' selected' : '' }}@endif>Laki - Laki</option>
                                            <option value="Perempuan" @if($penduduk) {{ $penduduk->jenis_kelamin == 'Perempuan' ? ' selected' : '' }}@endif>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <input type="hidden" name="agama" value="{{ $penduduk ? $penduduk->agama : ''  }}" />
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Agama</label>
                                        <select name="agama" id="agama" class="form-control" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') disabled @endif/>
                                            <option value="">Pilih</option>
                                            <option value="Islam" @if($penduduk) {{ $penduduk->agama == 'Islam' ? ' selected' : '' }}@endif>Islam</option>
                                            <option value="Kristen" @if($penduduk) {{ $penduduk->agama == 'Kristen' ? ' selected' : '' }}@endif>Kristen</option>
                                            <option value="Budha" @if($penduduk) {{ $penduduk->agama == 'Budha' ? ' selected' : '' }}@endif>Budha</option>
                                            <option value="Hindu" @if($penduduk) {{ $penduduk->agama == 'Hindu' ? ' selected' : '' }}@endif>Hindu</option>
                                            <option value="Konghucu" @if($penduduk) {{ $penduduk->agama == 'Konghucu' ? ' selected' : '' }}@endif>Konghucu</option>
                                            <option value="Lainnya" @if($penduduk) {{ $penduduk->agama == 'Lainnya' ? ' selected' : '' }}@endif>Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <input type="hidden" name="hubungan_keluarga" value="{{ $penduduk ? $penduduk->hubungan_keluarga : ''  }}" />
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Hubungan Keluarga</label>
                                        <select name="hubungan_keluarga" id="hubungan_keluarga" class="form-control" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') disabled @endif/>
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
                                        <input type="hidden" name="pendidikan_terakhir" value="{{ $penduduk ? $penduduk->pddk_akhir : ' ' }}">
                                        <label class="form-label font-weight-bold" for="form9Example2">Pendidikan Terakhir</label>
                                        <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') disabled @endif/>
                                            <option value="Tidak/Belum Sekolah" @if($penduduk) {{ $penduduk->pddk_akhir == 'Tidak/Belum Sekolah ' ? ' selected' : '' }}@endif>Tidak/Belum Sekolah</option>
                                            <option value="Tidak Tamat SD/Sederajat" @if($penduduk) {{ $penduduk->pddk_akhir == 'Tidak Tamat SD/Sederajat' ? ' selected' : '' }}@endif>Tidak Tamat SD/Sederajat</option>
                                            <option value="SD/Sederajat" @if($penduduk) {{ $penduduk->pddk_akhir == 'SD/Sederajat' ? ' selected' : '' }}@endif>SD/Sederajat</option>
                                            <option value="SMP/Sederajat" @if($penduduk) {{ $penduduk->pddk_akhir == 'SMP/Sederajat' ? ' selected' : '' }}@endif>SMP/Sederajat</option>
                                            <option value="SMA/Sederajat" @if($penduduk) {{ $penduduk->pddk_akhir == 'SMA/Sederajat' ? ' selected' : '' }}@endif>SMA/Sederajat</option>
                                            <option value="Diploma I/II" @if($penduduk) {{ $penduduk->pddk_akhir == 'Diploma I/II' ? ' selected' : '' }}@endif>Diploma I/II</option>
                                            <option value="Diploma III/S. Muda" @if($penduduk) {{ $penduduk->pddk_akhir == 'Diploma III/S. Muda' ? ' selected' : '' }}@endif>Diploma III/S. Muda</option>
                                            <option value="Strata I/D4" @if($penduduk) {{ $penduduk->pddk_akhir == 'Strata I/D4' ? ' selected' : '' }}@endif>Strata I/D4</option>
                                            <option value="Strata II" @if($penduduk) {{ $penduduk->pddk_akhir == 'Strata II' ? ' selected' : '' }}@endif>Strata II</option>
                                            <option value="Strata III" @if($penduduk) {{ $penduduk->pddk_akhir == 'Strata III' ? ' selected' : '' }}@endif>Strata III</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Pekerjaan</label>
                                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="{{ $penduduk ? $penduduk->pekerjaan : '' }}" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') readonly @endif//>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">Kecamatan</label>
                                        <select id="kode_kecamatan" name="kode_kecamatan" class="form-control" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') disabled @endif>
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
                                        <select name="kode_desa" id="kode_desa" class="form-control" @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') disabled @endif>
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
                                        <input type="number" name="no_rw" id="no_rw" minlength="3" class="form-control" @if($penduduk) value="{{ $penduduk->get_pindah ? $penduduk->get_pindah->rw_baru : $penduduk->no_rw }}" @else value="" @endif @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') readonly @endif>
                                    </div>
                                </div>
                                <div class="col">
                                    <!-- Email input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example2">RT</label>
                                        <input type="number" name="no_rt" id="no_rt" minlength="3" class="form-control" @if($penduduk) value="{{ $penduduk->get_pindah ? $penduduk->get_pindah->rt_baru : $penduduk->no_rt }}" @else value="" @endif @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') readonly @endif/>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-1 mt-4">
                                <div class="col">
                                    <!-- Name input -->
                                    <div class="form-outline">
                                        <label class="form-label font-weight-bold" for="form9Example1">Alamat Lengkap</label>
                                        <textarea id="alamat" name="alamat" class="form-control" @if($penduduk) value="{{ $penduduk->get_pindah ? $penduduk->get_pindah->alamat_baru : $penduduk->alamat }}" @else value="" @endif @if(request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar' || request()->status == 'meninggal') readonly @endif/>@if($penduduk) {{ $penduduk->get_pindah ? $penduduk->get_pindah->alamat_baru : $penduduk->alamat }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="form-pindah" class="mt-4" @if(!$penduduk || request()->edit != null || request()->status != 'pindah' || request()->status == 'meninggal') style="display: none;" @endif>
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
                                    <div class="col-md-12">
                                        <div>
                                            <input type="radio" class="pindah" name="status_pindah" value="pindah_domisili_dalam">
                                            <label for="huey" class="mr-3">Penduduk Beda Domisili Dalam kabupaten</label>
                                            <input type="radio" class="pindah" name="status_pindah" value="pindah_domisili_luar">
                                            <label for="dewey" class="mr-3">Penduduk Beda Domisili Luar kabupaten</label>
                                            <br />
                                            <input type="radio" class="pindah" name="status_pindah" value="pindah_permanen_dalam">
                                            <label for="dewey" class="mr-3">Pindah Permanen Dalam Daerah kabupaten</label>
                                            <input type="radio" class="pindah" name="status_pindah" value="pindah_permanen_luar">
                                            <label for="dewey" class="mr-3">Pindah Permanen Luar Daerah kabupaten</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="dalam-kabupaten" style="display: none">
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
                                            <!-- Email input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example2">RW Baru</label>
                                                <input type="number" name="rw_dalam_baru" id="rw_baru" class="form-control" value="" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <!-- Name input -->
                                            <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example1">RT Baru</label>
                                                <input type="number" name="rt_dalam_baru" id="rt_baru" class="form-control" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1 mt-4">
                                        <!-- <div class="col">
                                        <div class="form-outline">
                                            <label class="form-label font-weight-bold" for="form9Example1">Alamat Asal</label>
                                            <textarea name="alamat_asal" id="alamat_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}" @else value="" @endif>@if($penduduk) {{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}@endif</textarea>
                                        </div>
                                    </div> -->
                                        <input type="hidden" name="alamat_dalam_asal" id="alamat_asal" class="form-control" @if($penduduk) value="{{ $status_pindah ? $status_pindah->alamat_baru : $penduduk->alamat }}" @else value="" @endif>
                                        <div class="col">
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
                                        <div class="col">
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
                                        <!-- <div class="col"> -->
                                        <!-- Name input -->
                                        <!-- <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example1">RT Baru</label>
                                                <input type="text" name="rt_baru" id="rt_baru" class="form-control" value="" />
                                            </div> -->
                                        <!-- </div> -->
                                        <!-- <div class="col"> -->
                                        <!-- Email input -->
                                        <!-- <div class="form-outline">
                                                <label class="form-label font-weight-bold" for="form9Example2">RW Baru</label>
                                                <input type="text" name="rw_baru" id="rw_baru" class="form-control" value="" />
                                            </div>
                                        </div> -->
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
                            <div id="form-meninggal" class="mt-4 border-top" @if(!$penduduk || request()->edit != null || request()->status != 'meninggal' || request()->status == 'pindah' || request()->status == 'pindah_domisili_dalam' || request()->status == 'pindah_domisili_luar') style="display: none;" @endif>
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
                                        @if($penduduk)
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
        // var el = document.getElementById('form-penduduk');
        // el.addEventListener('submit', function() {
        //     return confirm('Apakah anda yakin menambahkan data?');
        // }, false);

        $('body').on('change', '#form_status', function() {
            var status = $(this).val()
            console.log(status)
            if (status == 'pindah') {
                $('#form-pindah').show()
                $('#form-meninggal').hide()
            } else if (status == 'meninggal') {
                $('#form-pindah').hide()
                $('#form-meninggal').show()
            } else if (status == 'lahir' || status == '') {
                $('#form-pindah').hide()
                $('#form-meninggal').hide()
                $('#nik').removeAttr('name')
            } else if (status == 'datang') {
                $('#nik').attr('name', "nik");
            } else if (status == 'datang_non_permanen') {
                $('#nik').attr('name', "nik");
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
                var kode_desa_exist = '{{ Auth::user()->kode_desa }}';
                var selected = value.code_kelurahan == kode_desa_exist ? ' selected' : ' ' 
                var body = '<option value=' + value.code_kelurahan + ' ' + selected + '>' + value.nama_kelurahan + '</option>'
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
        if (data == 'pindah_domisili_dalam') {
            $('#dalam-kabupaten').show()
            $('#luar-kabupaten').hide()
        } else if (data == 'pindah_domisili_luar') {
            $('#luar-kabupaten').show()
            $('#dalam-kabupaten').hide()
        } else if (data == 'pindah_permanen_dalam') {
            $('#dalam-kabupaten').show()
            $('#luar-kabupaten').hide()
        }else if (data == 'pindah_permanen_luar') {
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
                remote: {
                    url: "{{ route('check.nik') }}",
                    type: "get"
                }
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
            },
            form_status: {
                required: true,
            }
        },
        messages: {
            nik: {
                required: "Mohon isi NIK",
                maxlength: 16,
                remote: "NIK sudah tersedia!"
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
            form_status: {
                required: "Mohon isi Status Data",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
<script>
    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });
    $("#edit-penduduk").validate({
        rules: {
            form_status_pindah: {
                required: true,
            }
        },
        messages: {
            form_status_pindah: {
                required: "Mohon isi Status Data",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@endpush