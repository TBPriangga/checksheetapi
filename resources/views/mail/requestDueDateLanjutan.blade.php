<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Due Date Lanjutan</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">


    <h2 style="font-weight: bold;">Permintaan Due Date Lanjutan pada {{$data['created_at']->format('Y-m-d')}}</h2>


    <p style="font-size: 16px;">
        {{ $data['PIC']->name }} mengajukan Request Due Date Lanjutan dengan detail Berikut :
    </p>

    <ul style="list-style-type: none; padding: 0;">
        <li style="font-size: 16px;"><strong>Temuan :</strong> {{ $data['temuan'] }}</li>
        <li style="font-size: 16px;"><strong>PIC Area :</strong> {{ $data['PIC']->name }}</li>
        <li style="font-size: 16px;"><strong>Area Temuan :</strong> {{ $data['area']->name }}</li>
        <li style="font-size: 16px;"><strong>Due Date :</strong> <span style="color:red; font-weight:600;"> {{ \Carbon\Carbon::parse($data['deadline_date'])->format('Y-m-d') }} </span></li>
        <li style="font-size: 16px;"><strong>Alasan Meminta DueDate Lanjutan :</strong> </strong> {{ $data['alasan_due_date_lanjutan'] }}</li>
        <li style="font-size: 16px;"><strong>Due Date Lanjutan Sampai :</strong> </strong> {{ $data['tanggal_request_due_date_lanjutan'] }}</li>
    </ul>


    <p style="font-size: 16px;">
        Mohon untuk dapat melakukan approval atau penolakan kepada request Due Date Lanjutan tersebut.
    </p>

    <p style="font-size: 16px;">Link temuan :  {{ config('app.link_website') }}/detail/{{ $data['id'] }}</p>




    <br>


    <p style="font-size: 16px;">Terima kasih.</p>


</body>
</html>
