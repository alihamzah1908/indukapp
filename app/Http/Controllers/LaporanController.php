<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\PendudukExport;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role == 'super admin') {
            if ($request["nik"] || $request["jenis_kelamin"] || $request["status"]) {
                $data["penduduk"] = \App\Models\Penduduk::where('nik', $request["nik"])
                    ->orWhere('jenis_kelamin', $request["jenis_kelamin"])
                    ->orWhere('status', $request["status"])
                    ->orderBy('id', 'desc')
                    ->orderBy('status', 'desc')
                    ->paginate(20);
            } else {
                $data["penduduk"] = \App\Models\Penduduk::orderBy('id', 'desc')
                    ->orderBy('status', 'desc')
                    ->paginate(20);
            }
        } else {
            if ($request["no_rw"]) {
                $data["penduduk"] = DB::table('penduduks as a')
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
                    )
                    ->where('a.no_rw', $request["no_rw"])
                    ->where('a.kode_desa', Auth::user()->kode_desa)
                    ->orWhere('b.kode_desa', Auth::user()->kode_desa)
                    ->orWhere('b.kode_desa_asal', Auth::user()->kode_desa)
                    ->orderBy('a.id', 'desc')
                    ->orderBy('a.status', 'desc')
                    ->paginate(20);
            } else {
                $data["penduduk"] = DB::table('penduduks as a')
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
                    )
                    ->where('a.kode_desa', Auth::user()->kode_desa)
                    ->orWhere('b.kode_desa', Auth::user()->kode_desa)
                    ->orWhere('b.kode_desa_asal', Auth::user()->kode_desa)
                    ->orderBy('a.id', 'desc')
                    ->paginate(20);
            }
        }
        return view('laporan.index', $data);
    }

    public function penduduk_export(Request $request)
    {
        return Excel::download(new PendudukExport($request["no_rw"]), 'siswa.xlsx');
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
            )
            ->where('a.kode_desa', Auth::user()->kode_desa)
            ->orWhere('b.kode_desa', Auth::user()->kode_desa)
            ->orWhere('b.kode_desa_asal', Auth::user()->kode_desa)
            ->orderBy('a.id', 'desc')
            ->paginate(20);
        $pdf = PDF::loadView('laporan.pdf', compact('penduduk'));

        return $pdf->download('penduduk.pdf');
    }
}
