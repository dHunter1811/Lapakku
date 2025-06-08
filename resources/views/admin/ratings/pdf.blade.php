<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Rating</title>
    {{-- Copy style dari atas --}}
    <style>body { font-family: sans-serif; font-size: 10px; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 5px; text-align: left; } th { background-color: #f2f2f2; }</style>
</head>
<body>
    <h1>Laporan Data Rating & Ulasan</h1>
    <p>Tanggal Cetak: {{ date('d M Y, H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Lahan</th>
                <th>Pemberi Rating</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $rating)
            <tr>
                <td>{{ $rating->id }}</td>
                <td>{{ $rating->lahan->judul ?? 'Lahan Dihapus' }}</td>
                <td>{{ $rating->user->name ?? 'User Dihapus' }}</td>
                <td>{{ $rating->rating }} ★</td>
                <td>{{ $rating->komentar ?: '-' }}</td>
                <td>{{ $rating->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>