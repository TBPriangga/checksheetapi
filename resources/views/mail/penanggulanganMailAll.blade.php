{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Penanggulangan Temuan</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <h2 style="font-weight: bold;">Verifikasi Penanggulangan Temuan</h2>

    <p style="font-size: 16px;">PIC telah melakukan penanggulangan pada area <strong>{{ $data['area']->name }}</strong>, Berikut adalah detail datanya :</p>

    <ul style="list-style-type: none; padding: 0;">
        <li style="font-size: 16px;"><strong>Temuan EHS : </strong> {{ $data['temuan'] }}</li>
        <li style="font-size: 16px;"><strong>Penanggulangan PIC :</strong> {{ $data['penanggulangan'] }}</li>
        <li style="font-size: 16px;"><strong>PIC Area :</strong> {{ $data['PIC']->name }}</li>
        <li style="font-size: 16px;"><strong>Due Data :</strong> {{ $data['deadline_date']}}</li>
    </ul>

    <br>

    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Need Approve</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <p style="font-size: 16px;">Need approved, hasil perbaikan temuan EHS patrol pada area {{ $data['area_patrol']->name }} <strong>. Dibutuhkan approval untuk hasil perbaikan laporan temuan</p></p>
    <p style="font-size: 16px;">Link laporan: {{ config('app.link_website') }}/patrolEHS/{{ $data['id'] }}</p>
<br>
<br>
<br>
    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>