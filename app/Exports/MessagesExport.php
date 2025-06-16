<?php
// app/Exports/MessagesExport.php

namespace App\Exports;

use App\Models\Message;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MessagesExport implements FromCollection, WithHeadings, WithMapping
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
        return ['ID', 'Pengirim', 'Email', 'Pesan', 'Status Baca', 'Tanggal Kirim'];
    }

    public function map($message): array
    {
        return [
            $message->id,
            $message->nama ?? ($message->user->name ?? 'Tamu'),
            $message->email,
            $message->pesan,
            $message->is_read ? 'Sudah Dibaca' : 'Belum Dibaca',
            $message->created_at->format('d M Y, H:i'),
        ];
    }
}