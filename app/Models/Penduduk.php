<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table = 'penduduks';

    public function get_pindah()
    {
        return $this->belongsTo('\App\Models\PendudukPindah', 'nik','nik')->orderBy('id','desc');
    }

    public function get_kecamatan()
    {
        return $this->belongsTo('\App\Models\Kecamatan', 'kode_kecamatan','code_kecamatan');
    }

    public function get_desa()
    {
        return $this->belongsTo('\App\Models\Desa', 'kode_desa','code_kelurahan');
    }
}
