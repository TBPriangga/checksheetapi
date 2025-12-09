<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Temuan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .info { margin: 15px 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; vertical-align: top; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-left { text-align: left !important; }
        .wrap { white-space: normal; word-wrap: break-word; }
        .footer { margin-top: 30px; font-size: 9px; text-align: center; }
    </style>
</head>
<body>

<div class="header">
    <h1>LAPORAN TOTAL TEMUAN</h1>
    <p>PT. Astra Juoku Indonesia</p>
</div>

<div class="info">
    <strong>Filter:</strong> Area: {{ $areaName }} | NPK: {{ $npkFilter }}<br>
    <strong>Total Laporan Temuan:</strong> {{ $totalLaporan }} | 
    <strong>Total Poin:</strong> {{ $totalPoin }}<br>
    <strong>Tanggal Cetak:</strong> {{ $tanggalCetak }}
</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="8%">Tanggal</th>
            <th width="15%">Nama Penemu</th>
            <th width="8%">NPK</th>
            <th width="15%">Area Temuan</th>
            <th width="25%" class="text-left">Temuan</th>
            <th width="24%" class="text-left">Potensi Bahaya</th>
        </tr>
    </thead>
    <tbody>
        @forelse($laporans as $index => $laporan)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $laporan->created_at?->format('d-m-Y') }}</td>
            <td>{{ $laporan->nama_penemu }}</td>
            <td>{{ $laporan->npk }}</td>
            <td>{{ $laporan->area?->name }}</td>
            <td class="text-left wrap">{{ $laporan->temuan }}</td>
            <td class="text-left wrap">{{ $laporan->potensi_bahaya }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Dicetak melalui Sistem Hyarihatto Activity | © {{ date('Y') }} PT. Astra Juoku Indonesia
</div>

</body>
</html>