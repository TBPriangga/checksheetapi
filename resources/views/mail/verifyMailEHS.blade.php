<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verified EHS</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <h2 style="font-weight: bold;">Verified EHS</h2>

    <p style="font-size: 16px;">
        EHS already approved perbaikan temuan EHS patrol.
    </p>
    <p style="font-size: 16px;">Link temuan : {{ config('app.link_website') }}/detail/{{ $data['id'] }}</p>
    <br>
    <br>
    <br>
        <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Temuan</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <h2 style="font-weight: bold;">Verifikasi Temuan</h2>

    <p style="font-size: 16px;">
        Penemuan pada area <strong>{{ $data['area']->name }}</strong> telah diverifikasi oleh pihak EHS.
    </p>

    <p style="font-size: 16px;">Berikut adalah detail datanya :</p>

    <ul style="list-style-type: none; padding: 0;">
        <li style="font-size: 16px;"><strong>Temuan EHS:</strong> {{ $data['temuan'] }}</li>
        <li style="font-size: 16px;"><strong>Penanggulangan PIC:</strong> {{ $data['penanggulangan'] }}</li>
        <li style="font-size: 16px;"><strong>PIC Area:</strong> {{ $data['PIC']->name }}</li>
        <li style="font-size: 16px;"><strong>Due Date:</strong> {{ $data['deadline_date'] }}</li>
        <li style="font-size: 16px;"><strong>Tanggal Perbaikan:</strong> {{ $data['PIC_submit_at'] }}</li>
    </ul>

    <br>

    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html> --}}