<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Lahan</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Laporan Data Lahan</h1>
    <p>Tanggal Cetak: {{ date('d M Y, H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Lahan</th>
                <th>Pemilik</th>
                <th>Harga Sewa</th>
                <th>Tipe</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Tgl Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $lahan)
            <tr>
                <td>{{ $lahan->id }}</td>
                <td>{{ $lahan->judul }}</td>
                <td>{{ $lahan->user->name ?? 'N/A' }}</td>
                <td>Rp {{ number_format($lahan->harga_sewa, 0, ',', '.') }}</td>
                <td>{{ $lahan->tipe_lahan }}</td>
                <td>{{ $lahan->lokasi }}</td>
                <td>{{ $lahan->status }}</td>
                <td>{{ $lahan->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>