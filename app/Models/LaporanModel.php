<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanModel extends Model
{
    protected $fillable = ['nik', 'no_kk', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'kecamatan', 'kelurahan', 'no_rw', 'no_rt'];
    protected $table = 'penduduks';
}
