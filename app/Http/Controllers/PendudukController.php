<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'super admin') {
            // if ($request["nik"] || $request["jenis_kelamin"] || $request["status"]) {
            if ($request["nik"] || $request["no_kk"]) {
                $data["penduduk"] = \App\Models\Penduduk::where('nik', $request["nik"])
                    // ->orWhere('jenis_kelamin', $request["jenis_kelamin"])
                    // ->orWhere('status', $request["status"])
                    ->orWhere('no_kk', $request["no_kk"])
                    ->orderBy('id', 'desc')
                    ->orderBy('status', 'desc')
                    ->paginate(20);
            } else {
                $data["penduduk"] = \App\Models\Penduduk::orderBy('id', 'desc')
                    ->orderBy('status', 'desc')
                    ->paginate(20);
            }
        } else {
            $penduduk = DB::table('penduduks as a')
                ->select(
                    'a.id',
                    'a.nik',
                    'a.no_kk',
                    'a.nama_lengkap',
                    'a.tempat_lahir',
                    'a.jenis_kelamin',
                    'a.tanggal_lahir',
                    'a.hubungan_keluarga',
                    'a.alamat',
                    'a.no_rt',
                    'a.no_rw',
                    'a.kode_desa',
                    'a.kelurahan',
                    'a.kode_kecamatan',
                    'a.kecamatan',
                    'a.status',
                    'a.pddk_akhir',
                    'a.pekerjaan',
                    'a.agama',
                    'a.keterangan',
                    'b.kode_desa',
                    'b.kode_desa as kode_desa_baru',
                    'b.kode_desa_asal'
                )
                ->leftJoin(
                    DB::raw('( 
                        SELECT * FROM penduduk_pindah pp  
                        WHERE updated_at IN 
                        (SELECT MAX(updated_at) FROM penduduk_pindah GROUP BY nik) 
                        ) as b'),
                    function ($join) {
                        $join->on('b.nik', '=', 'a.nik');
                    }
                );
                if($request["nik"] || $request["no_kk"]){
                    $penduduk->where('a.kode_desa', Auth::user()->kode_desa);
                    $penduduk->where('a.nik', $request["nik"]);
                    // ->orWhere('a.jenis_kelamin', $request["jenis_kelamin"])
                    // ->orWhere('a.status', $request["status"])
                    $penduduk->orWhere('no_kk', $request["no_kk"]);
                    $penduduk->orWhere('b.kode_desa', Auth::user()->kode_desa);
                    $penduduk->orWhere('b.kode_desa_asal', Auth::user()->kode_desa);
                    $penduduk->orderBy('a.id', 'desc');
                    $penduduk->orderBy('a.status', 'desc');
                }else{
                    $penduduk->where('a.kode_desa', Auth::user()->kode_desa);
                    $penduduk->orWhere('b.kode_desa', Auth::user()->kode_desa);
                    $penduduk->orWhere('b.kode_desa_asal', Auth::user()->kode_desa);
                    $penduduk->orderBy('a.id', 'desc');
                    $penduduk->orderBy('a.status', 'desc');
                }
                $data["penduduk"] = $penduduk->paginate(20);
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
        if ($request["nik"]) {
            $check = \App\Models\Penduduk::where('nik', $request["nik"])
                ->first();
            $data["penduduk"] = \App\Models\Penduduk::find($check->id);
        } elseif ($request["id"]) {
            $check = \App\Models\Penduduk::where('id', $request["id"])
                ->first();
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
            $data->pddk_akhir = $request["pendidikan_terakhir"];
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
        return redirect(route('penduduk.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data["penduduk"] = \App\Models\Penduduk::findOrFail($id);
        return view('penduduk.detail', $data);
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
            $data->pddk_akhir = $request["pendidikan_terakhir"];
            $data->kode_kecamatan = $request["kode_kecamatan"];
            $data->kecamatan = $request["nama_kecamatan"];
            $data->status = $request["status"];
            $data->keterangan = $request["keterangan"];
            $data->agama = $request["agama"];
            if ($request["status"] == 'pindah_domisili_dalam' || $request["status"] == 'pindah_domisili_luar' || $request["status"] == 'pindah_permanen_dalam' || $request["status"] == 'pindah_permanen_luar') {
                // CHECK DATA PINDAH
                $pindah = \App\Models\PendudukPindah::where('nik', $request["nik"])
                    ->where('alamat_asal', '=', $request["alamat_asal"])
                    ->where('alamat_baru', $request["alamat_baru"])
                    ->orderBy('id', 'desc')
                    ->first();
                // dd($pindah);
                if (!$pindah) {
                    // dd($request["nik"]);
                    $arr = new \App\Models\PendudukPindah();
                    $arr->nik = $request["nik"];
                    $arr->alamat_asal = $request["alamat_dalam_asal"] != '' ? $request["alamat_dalam_asal"] : $request["alamat_asal"];
                    $arr->alamat_baru = $request["alamat_dalam_baru"] != '' ? $request["alamat_dalam_baru"] : $request["alamat_baru"];
                    $arr->rt_asal = $request["rt_dalam_asal"] != '' ? $request["rt_dalam_asal"] : $request["rt_asal"];
                    $arr->rt_baru = $request["rt_dalam_baru"] != '' ? $request["rt_dalam_baru"] : $request["rt_baru"];
                    $arr->rw_asal = $request["rw_dalam_asal"] != '' ? $request["rw_dalam_asal"] : $request["rw_asal"];
                    $arr->rw_baru = $request["rw_dalam_baru"] != '' ? $request["rw_dalam_baru"] : $request["rw_baru"];
                    $arr->kode_kecamatan = $request["kode_kecamatan_pindah"];
                    $arr->kode_desa = $request["kode_desa_pindah"];
                    $arr->kode_kecamatan_asal = $request["kode_kecamatan_asal"] != '' ? $request["kode_kecamatan_asal"] : $request["kode_kecamatan"];
                    $arr->kode_desa_asal = $request["kode_desa_asal"] != '' ? $request["kode_desa_asal"] : $request["kode_desa"];
                    $arr->kode_kecamatan_baru = $request["kode_kecamatan_pindah"];
                    $arr->kode_desa_baru = $request["kode_desa_pindah"];
                    $arr->tanggal_pindah = $request["tanggal_dalam_pindah"] != '' ? $request["tanggal_dalam_pindah"] : $request["tanggal_pindah"];
                    $arr->status_pindah = $request["status_pindah"];
                    $arr->save();
                } else {
                    $arr = \App\Models\PendudukPindah::findOrFail($pindah->id);
                    $arr->nik = $request["nik"];
                    $arr->alamat_asal = $request["alamat_dalam_asal"] != '' ? $request["alamat_dalam_asal"] : $request["alamat_asal"];
                    $arr->alamat_baru = $request["alamat_dalam_baru"] != '' ? $request["alamat_dalam_baru"] : $request["alamat_baru"];
                    $arr->rt_asal = $request["rt_dalam_asal"] != '' ? $request["rt_dalam_asal"] : $request["rt_asal"];
                    $arr->rt_baru = $request["rt_dalam_baru"] != '' ? $request["rt_dalam_baru"] : $request["rt_baru"];
                    $arr->rw_asal = $request["rw_dalam_asal"] != '' ? $request["rw_dalam_asal"] : $request["rw_asal"];
                    $arr->rw_baru = $request["rw_dalam_baru"] != '' ? $request["rw_dalam_baru"] : $request["rw_baru"];
                    $arr->kode_kecamatan = $request["kode_kecamatan_pindah"];
                    $arr->kode_desa = $request["kode_desa_pindah"];
                    $arr->tanggal_pindah = $request["tanggal_dalam_pindah"] != '' ? $request["tanggal_dalam_pindah"] : $request["tanggal_pindah"];
                    $arr->status_pindah = $request["status_pindah"];
                    $arr->save();
                }
            } else if ($request["status"] == 'meninggal') {
                $pindah = \App\Models\PendudukMeninggal::where('nik', $request["nik"])->first();
                if (!$pindah) {
                    $arr = new \App\Models\PendudukMeninggal();
                    $arr->nik = $request["nik"];
                    $arr->alamat = $request["alamat_meninggal"];
                    $arr->tempat_disemayamkan = $request["tempat_disemayamkan"];
                    $arr->tanggal_meninggal = $request["tanggal_meninggal"];
                    $arr->save();
                } else {
                    $arr = \App\Models\PendudukMeninggal::findOrFail($pindah->id);
                    $arr->nik = $request["nik"];
                    $arr->alamat = $request["alamat_meninggal"];
                    $arr->tempat_disemayamkan = $request["tempat_disemayamkan"];
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
        return redirect(route('penduduk.index'));
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

    public function data_kecamatan(Request $request)
    {
        $data = \App\Models\Desa::select('id', 'code_kelurahan', 'nama_kelurahan')->where('code_kecamatan', $request["kode_kecamatan"])->get();
        return response()->json($data);
    }

    public function check_nik(Request $request)
    {
        $data = \App\Models\Penduduk::where('nik', $request["nik"])->count();
        if ($data > 0) {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }
}
