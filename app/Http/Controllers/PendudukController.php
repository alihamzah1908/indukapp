<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'super admin') {
            $data["penduduk"] = \App\Models\Penduduk::orderBy('id', 'desc')->paginate(20);
        } else {
            $data["penduduk"] = \App\Models\Penduduk::orderBy('id', 'desc')
                ->where('kode_desa', Auth::user()->kode_desa)
                ->paginate(20);
        }

        return view('penduduk.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $check = \App\Models\Penduduk::where('nik', $request["nik"])->first();
        if ($check) {
            $data["penduduk"] = \App\Models\Penduduk::find($check->id);
        } else {
            $data["penduduk"] = false;
        }
        return view('penduduk.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = \App\Models\Penduduk::where('nik', $request["nik"])->get();
        if ($check->count() == 0) {
            $data = new \App\Models\Penduduk();
            $data->nik = $request["nik"];
            $data->no_kk = $request["kk"];
            $data->nama_lengkap = $request["nama_lengkap"];
            $data->tempat_lahir = $request["tempat_lahir"];
            $data->tanggal_lahir = $request["tanggal_lahir"];
            $data->jenis_kelamin = $request["jenis_kelamin"];
            $data->hubungan_keluarga = $request["hubungan_keluarga"];
            $data->alamat = $request["alamat"];
            $data->no_rt = $request["no_rt"];
            $data->no_rw = $request["no_rw"];
            $data->kode_desa = $request["kode_desa"];
            $data->kelurahan = $request["kelurahan"];
            $data->kode_kecamatan = $request["kode_kecamatan"];
            $data->kecamatan = $request["nama_kecamatan"];
            $data->status = $request["status"];
            $data->agama = $request["agama"];
            $data->keterangan = $request["keterangan"];
            if ($data->save()) {
                $response = [
                    'status' => 200,
                    'information' => 'Data berhasil Ditambahkan.',
                ];
            } else {
                $response = [
                    'status' => 401,
                    'information' => 'Data gagal Ditambahkan.',
                ];
            };
        } else {
            $response = [
                'status' => 401,
                'information' => 'Nik atau nomor Kartu Keluarga sudah tersedia.',
            ];
        }
        // } else {
        //     $response = [
        //         'status' => 401,
        //         'information' => 'Token tidak ditemukan, harap informasikan ke pihak terkait',
        //     ];
        // }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $check = \App\Models\Penduduk::where('nik', $request["nik"])->first();
        if ($check) {
            $data = \App\Models\Penduduk::findOrFail($check->id);
            $data->nik = $request["nik"];
            $data->no_kk = $request["kk"];
            $data->nama_lengkap = $request["nama_lengkap"];
            $data->tempat_lahir = $request["tempat_lahir"];
            $data->tanggal_lahir = $request["tanggal_lahir"];
            $data->jenis_kelamin = $request["jenis_kelamin"];
            $data->hubungan_keluarga = $request["hubungan_keluarga"];
            $data->alamat = $request["alamat"];
            $data->no_rt = $request["no_rt"];
            $data->no_rw = $request["no_rw"];
            $data->kode_desa = $request["kode_desa"];
            $data->kelurahan = $request["kelurahan"];
            $data->kode_kecamatan = $request["kode_kecamatan"];
            $data->kecamatan = $request["nama_kecamatan"];
            $data->status = $request["status"];
            $data->keterangan = $request["keterangan"];
            $data->agama = $request["agama"];
            if ($request["status"] == 'pindah') {
                $pindah = \App\Models\PendudukPindah::where('nik', $request["nik"])
                    ->where('alamat_asal', $request["alamat_asal"])
                    ->where('alamat_baru', $request["alamat_baru"])
                    ->first();
                $data1 = \App\Models\Penduduk::findOrFail($check->id);
                $data1->alamat = $request["alamat_baru"];
                $data1->no_rt = $request["rt_baru"];
                $data1->no_rw = $request["rw_baru"];
                $data1->save();
                if (!$pindah) {
                    $arr = new \App\Models\PendudukPindah();
                    $arr->nik = $request["nik"];
                    $arr->alamat_asal = $request["alamat_asal"];
                    $arr->alamat_baru = $request["alamat_baru"];
                    $arr->rt_asal = $request["rt_asal"];
                    $arr->rt_baru = $request["rt_baru"];
                    $arr->rw_asal = $request["rw_asal"];
                    $arr->rw_baru = $request["rw_baru"];
                    $arr->tanggal_pindah = $request["tanggal_pindah"];
                    $arr->save();
                } else {
                    $arr = \App\Models\PendudukPindah::findOrFail($pindah->id);
                    $arr->nik = $request["nik"];
                    $arr->alamat_asal = $request["alamat_asal"];
                    $arr->alamat_baru = $request["alamat_baru"];
                    $arr->rt_asal = $request["rt_asal"];
                    $arr->rt_baru = $request["rt_baru"];
                    $arr->rw_asal = $request["rw_asal"];
                    $arr->rw_baru = $request["rw_baru"];
                    $arr->tanggal_pindah = $request["tanggal_pindah"];
                    $arr->save();
                }
            } else if ($request["status"] == 'meninggal') {
                $pindah = \App\Models\PendudukMeninggal::where('nik', $request["nik"])->first();
                if (!$pindah) {
                    $arr = new \App\Models\PendudukMeninggal();
                    $arr->nik = $request["nik"];
                    $arr->alamat = $request["alamat_meninggal"];
                    $arr->tanggal_meninggal = $request["tanggal_meninggal"];
                    $arr->save();
                } else {
                    $arr = \App\Models\PendudukMeninggal::findOrFail($pindah->id);
                    $arr->nik = $request["nik"];
                    $arr->alamat = $request["alamat_meninggal"];
                    $arr->tanggal_meninggal = $request["tanggal_meninggal"];
                    $arr->save();
                }
            }
            if ($data->save()) {
                $response = [
                    'status' => 200,
                    'information' => 'Data berhasil diubah.',
                ];
            } else {
                $response = [
                    'status' => 401,
                    'information' => 'Data gagal diubah.',
                ];
            };
        } else {
            $response = [
                'status' => 401,
                'information' => 'Nik atau nomor Kartu Keluarga tidak tersedia.',
            ];
        }
        // } else {
        //     $response = [
        //         'status' => 401,
        //         'information' => 'Token tidak ditemukan, harap informasikan ke pihak terkait',
        //     ];
        // }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function data_pindah($nik)
    {
        $data = \App\Models\PendudukPindah::where('nik', $nik)->get();
        return response()->json($data);
    }
}
