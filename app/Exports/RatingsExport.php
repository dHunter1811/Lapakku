<?php
// app/Exports/RatingsExport.php

namespace App\Exports;

use App\Models\Rating;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RatingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return ['ID', 'Lahan', 'Pemberi Rating', 'Email Pemberi', 'Rating (1-5)', 'Komentar', 'Tanggal'];
    }

    public function map($rating): array
    {
        return [
            $rating->id,
            $rating->lahan->judul ?? 'Lahan Dihapus',
            $rating->user->name ?? 'User Dihapus',
            $rating->user->email ?? 'N/A',
            $rating->rating,
            $rating->komentar,
            $rating->created_at->format('d M Y, H:i'),
        ];
    }
}