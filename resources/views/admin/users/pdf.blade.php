<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pengguna</title>
    {{-- Copy style dari atas --}}
    <style>body { font-family: sans-serif; font-size: 10px; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 5px; text-align: left; } th { background-color: #f2f2f2; }</style>
</head>
<body>
    <h1>Laporan Data Pengguna</h1>
    <p>Tanggal Cetak: {{ date('d M Y, H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>No. Telepon</th>
                <th>Tanggal Registrasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->no_telepon ?: '-' }}</td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>