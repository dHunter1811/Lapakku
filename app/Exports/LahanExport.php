<?php
// app/Exports/LahanExport.php

namespace App\Exports;

use App\Models\Lahan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LahanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Judul Lahan',
            'Pemilik',
            'Email Pemilik',
            'Harga Sewa',
            'Tipe Lahan',
            'Lokasi',
            'Alamat Lengkap',
            'Status',
            'Tanggal Dibuat',
        ];
    }

    /**
     * @param mixed $lahan
     * @return array
     */
    public function map($lahan): array
    {
        return [
            $lahan->id,
            $lahan->judul,
            $lahan->user->name ?? 'N/A',
            $lahan->user->email ?? 'N/A',
            $lahan->harga_sewa,
            $lahan->tipe_lahan,
            $lahan->lokasi,
            $lahan->alamat_lengkap,
            $lahan->status,
            $lahan->created_at->format('d M Y, H:i'),
        ];
    }
}