<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Due Date Lanjutan Disetujui</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">


    <h2 style="font-weight: bold;">Permintaan Due Date Lanjutan Anda pada {{$data['created_at']->format('Y-m-d')}} Disetujui</h2>

    <p style="font-size: 16px;">
        Due date Lanjutan dapat dilihat pada link temuan dibawah.
    </p>

    <p style="font-size: 16px;">Link temuan :  {{ config('app.link_website') }}/detail/{{ $data['id'] }}</p>

    <br>


    <p style="font-size: 16px;">Terima kasih.</p>


</body>
</html>
