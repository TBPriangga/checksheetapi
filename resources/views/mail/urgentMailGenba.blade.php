<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urgent Rank A</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <h2 style="font-weight: bold;">Urgent Rank A</h2>

    <p style="font-size: 16px;">
        Penemuan indikasi rank A pada area <strong>{{ $data['area']->name }}</strong> pada laporan Genba Management.
    </p>

    <p style="font-size: 16px;">Berikut adalah detail Analisis datanya :</p>

    <ul style="list-style-type: none; padding: 0;">
        <li style="font-size: 16px;"><strong>Man :</strong> {{ $data['analisis']->man }}</li>
        <li style="font-size: 16px;"><strong>Material :</strong> {{ $data['analisis']->material }}</li>
        <li style="font-size: 16px;"><strong>Machine :</strong> {{ $data['analisis']->machine }}</li>
        <li style="font-size: 16px;"><strong>Methode :</strong> {{ $data['analisis']->methode }}</li>
        <li style="font-size: 16px;"><strong>What :</strong> {{ $data['analisis']->what }}</li>
        <li style="font-size: 16px;"><strong>Where :</strong> {{ $data['analisis']->where }}</li>
        <li style="font-size: 16px;"><strong>When :</strong> {{ $data['analisis']->when }}</li>
        <li style="font-size: 16px;"><strong>Why :</strong> {{ $data['analisis']->why }}</li>
        <li style="font-size: 16px;"><strong>Who :</strong> {{ $data['analisis']->who }}</li>
        <li style="font-size: 16px;"><strong>How :</strong> {{ $data['analisis']->how }}</li>
        <li style="font-size: 16px;"><strong>Category :</strong> {{ $data['kategori'] }}</li>
        <li style="font-size: 16px;"><strong>Rank :</strong> {{ $data['rank'] }}</li>
        <li style="font-size: 16px;"><strong>PIC Area :</strong> {{ $data['PIC']->name }}</li>
        <li style="font-size: 16px;"><strong>Due Date :</strong> {{ $data['deadline_date'] }}</li>
    </ul>

    <p style="font-size: 16px;">
        disegerakan untuk melakukan penanggulangan agar tidak terjadi hal yang di inginkan
    </p>

    <br>

    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>