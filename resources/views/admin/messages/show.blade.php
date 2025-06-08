@extends('layouts.admin')

@section('title', 'Detail Pesan - Admin Lapakku')
@section('page-title', 'Detail Pesan Masuk')

@section('content')
<div class="card">
    <div class="card-header">
        <div style="display:flex; justify-content: space-between; align-items: center;">
            <h4 style="margin:0;">Detail Pesan</h4>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary btn-sm">Kembali ke Kotak Masuk</a>
        </div>
    </div>
    <div class="card-body">
        @if(!isset($message))
            <div class="alert alert-danger">Pesan tidak ditemukan.</div>
        @else
            <div style="margin-bottom: 20px; padding-bottom:15px; border-bottom: 1px solid #eee;">
                <p><strong>Pengirim:</strong> {{ $message->nama ?? ($message->user->name ?? 'Tamu') }}</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p>
                <p><strong>Tanggal Kirim:</strong> {{ $message->created_at->format('d F Y, H:i:s') }} ({{ $message->created_at->diffForHumans() }})</p>
                <p><strong>Status:</strong>
                    @if($message->is_read)
                        <span style="color: green;">Sudah Dibaca</span>
                    @else
                        <span style="color: orange;">Belum Dibaca</span>
                        {{-- Tambahkan tombol untuk tandai sudah dibaca jika perlu --}}
                        {{--
                        <form action="{{ route('admin.messages.toggleRead', $message->id) }}" method="POST" style="display:inline; margin-left:10px;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">Tandai Sudah Dibaca</button>
                        </form>
                        --}}
                    @endif
                </p>
            </div>

            <h5 style="margin-bottom: 10px; color:#333;">Isi Pesan:</h5>
            <div style="background-color: #f9f9f9; border: 1px solid #e0e0e0; padding: 15px; border-radius: 5px; min-height: 150px; white-space: pre-wrap; word-wrap: break-word;">
                {!! nl2br(e($message->pesan)) !!}
            </div>

            <hr style="margin-top:30px; margin-bottom:20px;">
            <div style="display:flex; justify-content:space-between;">
                <a href="mailto:{{ $message->email }}?subject=Balasan: {{ Str::limit($message->pesan, 20) }}" class="btn btn-primary">Balas via Email</a>
                <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Pesan Ini</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
