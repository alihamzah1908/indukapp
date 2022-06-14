<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function data_agama(Request $request){
        $data = DB::select('SELECT agama, COUNT(*) as n 
        FROM penduduks 
        GROUP BY agama 
        ORDER BY n DESC');
        $arr = [];
        foreach ($data as $val) {
            $arrx["agama"] = $val->agama;
            $arrx["n"] = number_format($val->n, 0, ",", ".");
            $arr[] = $arrx;
        }
        return response()->json($arr);
    }

    public function data_umur(Request $request){
        $data = DB::select('SELECT 
                            CASE WHEN umur < 10 THEN "1-10"
                             WHEN umur BETWEEN 11 and 15 THEN "11-15"
                             WHEN umur BETWEEN 16 and 20 THEN "16-20"
                             WHEN umur BETWEEN 21 and 25 THEN "21-25"
                             WHEN umur BETWEEN 26 and 30 THEN "26-30"
                             WHEN umur BETWEEN 31 and 35 THEN "31-35"
                             WHEN umur BETWEEN 36 and 40 THEN "36-40"
                             WHEN umur BETWEEN 41 and 50 THEN "41-50"
                             WHEN umur BETWEEN 51 and 60 THEN "51-60"
                             WHEN umur BETWEEN 61 and 70 THEN "61-70"
                             WHEN umur BETWEEN 71 and 75 THEN "71-75"
                             WHEN umur >= 75 THEN "75 - ..."
                             WHEN umur IS NULL THEN "(NULL)"
                            END as range_umur,
                            COUNT(*) AS jumlah FROM 
                            ((SELECT DATE_FORMAT(FROM_DAYS(DATEDIFF(now(), tanggal_lahir)), "%Y")+0 AS umur FROM penduduks)  as dummy_table)
                            GROUP BY range_umur
                            ORDER BY range_umur');
        foreach ($data as $val) {
            $arrx["name"] = $val->range_umur;
            $arrx["y"] = $val->jumlah;
            $arr[] = $arrx;
        }
        return response()->json($arr);
    }

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
