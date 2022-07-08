<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\PendudukExport;
use App\Exports\PendudukExportBlanko;
use PDF;
use Input;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role == 'super admin') {
            if ($request["nik"] || $request["jenis_kelamin"] || $request["status"]) {
                $penduduk = \App\Models\Penduduk::where('nik', $request["nik"])
                    ->orWhere('jenis_kelamin', $request["jenis_kelamin"])
                    ->orWhere('status', $request["status"])
                    ->orderBy('id', 'desc')
                    ->orderBy('status', 'desc')
                    ->paginate(20);
            } else {
                $penduduk = \App\Models\Penduduk::orderBy('id', 'desc')
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
            if ($request["no_rw"]) {
                $penduduk->where('no_rw', $request["no_rw"]);
                $penduduk->where('a.kode_desa', Auth::user()->kode_desa);
                $penduduk->orWhere('b.kode_desa', Auth::user()->kode_desa);
                $penduduk->orWhere('b.kode_desa_asal', Auth::user()->kode_desa);
                $penduduk->orderBy('a.id', 'desc');
                $penduduk->orderBy('a.status', 'desc');
            } elseif ($request["no_rw"] || $request["no_rt"]) {
                $penduduk->where('no_rw', $request["no_rw"]);
                $penduduk->where('no_rt', $request["no_rt"]);
                $penduduk->where('a.kode_desa', Auth::user()->kode_desa);
                $penduduk->orWhere('b.kode_desa', Auth::user()->kode_desa);
                $penduduk->orWhere('b.kode_desa_asal', Auth::user()->kode_desa);
                $penduduk->orderBy('a.id', 'desc');
                $penduduk->orderBy('a.status', 'desc');
            }
            $result = $penduduk->paginate(20);
            return view('laporan.index', [
                'penduduk' => $result->appends($request->except(''))
            ]);
        }
        return view('laporan.index', [
            'penduduk' => $penduduk
        ]);
    }

    public function penduduk_pdf(Request $request)
    {
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
                'b.kode_desa as kode_desa_baru',
                'b.kode_kecamatan as kode_kecamatan_baru',
                'b.status_pindah',
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
        if ($request["no_rw"]) {
            $penduduk->where('no_rw', $request["no_rw"]);
            $penduduk->where('a.kode_desa', Auth::user()->kode_desa);
            $penduduk->orWhere('b.kode_desa', Auth::user()->kode_desa);
            $penduduk->orWhere('b.kode_desa_asal', Auth::user()->kode_desa);
            $penduduk->orderBy('a.id', 'desc');
            $penduduk->orderBy('a.status', 'desc');
            $penduduk->limit(100);
        } elseif ($request["no_rw"] || $request["no_rt"]) {
            $penduduk->where('no_rw', $request["no_rw"]);
            $penduduk->where('no_rt', $request["no_rt"]);
            $penduduk->where('a.kode_desa', Auth::user()->kode_desa);
            $penduduk->orWhere('b.kode_desa', Auth::user()->kode_desa);
            $penduduk->orWhere('b.kode_desa_asal', Auth::user()->kode_desa);
            $penduduk->orderBy('a.id', 'desc');
            $penduduk->orderBy('a.status', 'desc');
            $penduduk->limit(100);
        }
        $result = $penduduk->get();
        $arr = [];
        foreach ($result as $key => $val) {
            $arrx["nik"] = substr($val->nik, 0, 14) . 'xxxx';
            $arrx["no_kk"] = substr($val->no_kk, 0, 14) . 'xxxx';
            $arrx["nama_lengkap"] = $val->nama_lengkap;
            $arrx["tempat_lahir"] = $val->tempat_lahir;
            $arrx["tanggal_lahir"] = $val->tanggal_lahir;
            $arrx["jenis_kelamin"] = $val->jenis_kelamin;
            $arrx["status"] = $val->status;
            $arrx["alamat"] = $val->alamat;
            $arrx["kode_desa_baru"] = $val->kode_desa_baru;
            $arrz["nik"] = " ";
            $arrz["no_kk"] = " ";
            $arrz["nama_lengkap"] = " ";
            $arrz["tempat_lahir"] = " ";
            $arrz["tanggal_lahir"] = NULL;
            $arrz["jenis_kelamin"] = NULL;
            $arrz["status"] = " ";
            $arrz["alamat"] = " ";
            $arrz["kode_desa_baru"] = " ";
            $arr[] = $arrx;
            $arr[] = $arrz;
        }
        $data2["penduduk"] = $arr;
        // dd($data2["penduduk"]);
        $pdf = PDF::loadView('laporan.pdf', $data2)->setPaper('a4', 'landscape');;
        return $pdf->download('penduduk.pdf');
    }

    public function penduduk_export(Request $request)
    {
        return Excel::download(new PendudukExport($request["no_rw"]), 'export_excel.xlsx');
    }

    public function penduduk_blanko(Request $request)
    {
        return Excel::download(new PendudukExportBlanko($request["no_rw"]), 'export_blanko.xlsx');
    }
}
