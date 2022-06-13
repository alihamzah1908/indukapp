<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function data_jumlah_penduduk(Request $request)
    {
        if (Auth::user()->role == 'super admin') {
            $data = DB::select('SELECT COUNT(*) as n 
            FROM penduduks 
            WHERE status != "meninggal" LIMIT 1');
        } else if (Auth::user()->role == 'desa') {
            $data = DB::select('SELECT COUNT(*) as n 
            FROM penduduks 
            WHERE status != "meninggal" AND kode_desa=' . Auth::user()->kode_desa . ' LIMIT 1');
        }
        $arr = [];
        foreach ($data as $val) {
            $arr["jumlah"] = number_format($val->n, 0, ",", ".");
        }
        return response()->json($arr);
    }

    public function data_jenis_kelamin(Request $request)
    {
        if (Auth::user()->role == 'super admin') {
            $data = DB::select('SELECT kecamatan, kelurahan, jenis_kelamin, 
                    COUNT(jenis_kelamin) as n 
                    FROM penduduks 
                    WHERE status != "meninggal"
                    GROUP BY jenis_kelamin');
        } else if (Auth::user()->role == 'desa') {
            $data = DB::select('SELECT kecamatan, kelurahan, jenis_kelamin, 
                    COUNT(jenis_kelamin) as n 
                    FROM penduduks 
                    WHERE status != "meninggal" AND kode_desa=' . Auth::user()->kode_desa . '
                    GROUP BY jenis_kelamin');
        }
        $arr = [];
        foreach ($data as $val) {
            $arrx["jenis_kelamin"] = $val->jenis_kelamin;
            $arrx["jumlah"] = number_format($val->n, 0, ",", ".");
            $arr[] = $arrx;
        }
        return response()->json($arr);
    }
}
