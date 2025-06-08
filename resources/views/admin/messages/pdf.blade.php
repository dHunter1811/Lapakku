<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pesan Masuk</title>
    {{-- Copy style dari atas --}}
    <style>body { font-family: sans-serif; font-size: 10px; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 5px; text-align: left; } th { background-color: #f2f2f2; }</style>
</head>
<body>
    <h1>Laporan Pesan Masuk</h1>
    <p>Tanggal Cetak: {{ date('d M Y, H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pengirim</th>
                <th>Email</th>
                <th>Pesan</th>
                <th>Status Baca</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $message)
            <tr>
                <td>{{ $message->id }}</td>
                <td>{{ $message->nama ?? ($message->user->name ?? 'Tamu') }}</td>
                <td>{{ $message->email }}</td>
                <td>{{ $message->pesan }}</td>
                <td>{{ $message->is_read ? 'Sudah Dibaca' : 'Belum Dibaca' }}</td>
                <td>{{ $message->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>