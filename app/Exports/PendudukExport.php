<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class PendudukExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($kode, $no_rw)
    {
        $this->kode = $kode;
        $this->no_rw = $no_rw;
    }

    public function collection()
    {
        if(Auth::user()->role == 'desa' || $this->no_rw){
            $data = DB::table('penduduks')
                ->where('kode_desa', $this->kode)
                ->where('no_rw', $this->no_rw)
                ->get();
        }else{
            $data = DB::table('penduduks')
            ->get();
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'NIK',
            'No KK',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Kecamatan',
            'Desa',
            'RW',
            'RT',
            'Alamat Lengkap'
        ];
    }

    public function map($data): array
    {
        return [
            $data->nik,
            $data->no_kk,
            $data->nama_lengkap,
            $data->tempat_lahir,
            $data->tanggal_lahir,
            $data->jenis_kelamin,
            $data->kecamatan,
            $data->kelurahan,
            $data->no_rw,
            $data->no_rt,
            $data->alamat,
        ];
    }

    public function columnFormats(): array
    {
        return [];
    }
}
