<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Due Date Lanjutan DiTolak</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">


    <h2 style="font-weight: bold;">Permintaan Due Date Lanjutan Anda pada {{$data['created_at']->format('Y-m-d')}} Ditolak</h2>

    <p style="font-size: 16px;">
        Diharapkan Temuan dapat ditanggulangi sesuai Deadline Awal.
    </p>

    <p style="font-size: 16px;">Link temuan :  {{ config('app.link_website') }}/detail/{{ $data['id'] }}</p>

    <br>


    <p style="font-size: 16px;">Terima kasih.</p>


</body>
</html>
