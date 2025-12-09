<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Deadline EHS Patrol</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">


    <h2 style="font-weight: bold;">Temuan EHS Patrol {{$data['created_at']->format('Y-m-d')}}</h2>


    <p style="font-size: 16px;">
        Nice Reminder, lakukan penanggulangan pada temuan berikut :
    </p>
   
    <ul style="list-style-type: none; padding: 0;">
        <li style="font-size: 16px;"><strong>PIC Area :</strong> {{ $data['PIC']->name }}</li>
        <li style="font-size: 16px;"><strong>Area Temuan :</strong> {{ $data['area']->name }}</li>
        <li style="font-size: 16px;"><strong>Due Date :</strong> {{ \Carbon\Carbon::parse($data['deadline_date'])->format('Y-m-d') }} </li>
    </ul>


    <p style="font-size: 16px;">
        Mohon untuk dapat dilakukan Tindakan perbaikan sebelum melewati due date.
    </p>


    <p style="font-size: 16px;">Link temuan :  {{ config('app.link_website') }}/patrolEHS/{{ $data['patrol_id'] }}</p>




    <br>


    <p style="font-size: 16px;">Terima kasih.</p>


</body>
</html>