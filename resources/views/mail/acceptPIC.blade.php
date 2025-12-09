{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Temuan</title>
</head>
<body style="color:black">
    <h3><b>Penemuan pada area {{ $data['area']->name }} telah di approve oleh {{ $data['dept_PIC']->name }} seorang Departement Head pada area tesebut.</b></h3>
    <p>Berikut adalah detail datanya :</p>
    <p>Temuan EHS : {{ $data['temuan'] }}</p>
    <p>Penanggulangan PIC : {{ $data['penanggulangan'] }}</p>
    <p>PIC Area : {{ $data['PIC']->name }}</p>
    <p>Due Data : {{ $data['deadline_date']}}</p>
    <p>Tanggal Perbaikan : {{ $data['PIC_submit_at']}}</p>

</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Department Head PIC</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <h2 style="font-weight: bold;">Approved Department Head PIC</h2>

    <p style="font-size: 16px;">
        Department Head PIC area already approved perbaikan temuan EHS patrol.
    </p>
    <p style="font-size: 16px;">Link temuan : {{ config('app.link_website') }}/detail/{{ $data['id'] }}</p>
<br>
<br>
<br>
    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>