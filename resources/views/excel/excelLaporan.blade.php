<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 10px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Area</th>
                <th>Temuan</th>
                <th>Foto Temuan</th>
                <th>Kategori Stop-6</th>
                <th>Rank</th>
                <th>Penanggulangan</th>
                <th>Foto Temuan</th>
                <th>PIC</th>
                <th>Due Date</th>
                <th>Due Date lanjutan</th>
                <th>Verif</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
                <tr>
                    <td>{{ $item->no }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->area }}</td>
                    <td>{{ $item->temuan }}</td>
                    <td>{{ $item->foto_temuan }}</td>
                    <td>{{ $item->kategori_stop }}</td>
                    <td>{{ $item->rank }}</td>
                    <td>{{ $item->penanggulangan }}</td>
                    <td>{{ $item->foto_temuan }}</td>
                    <td>{{ $item->pic }}</td>
                    <td>{{ $item->deadline_date_awal }}</td>
                    @if ($item->deadline_date_awal == $item->deadline_date)
                    <td>{{ $item->deadline_date }}</td>
                    @else
                    <td>-</td>
                    @endif
                    <td>{{ $item->verif }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
