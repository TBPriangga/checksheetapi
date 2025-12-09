

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Need Approve</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <p style="font-size: 16px;">Need approved, hasil perbaikan temuan EHS Patrol pada area <strong>{{ $data['area']->name }}</strong> @if($data['rank'] == 'A')dengan status rank {{ $data['rank'] }} @endif. Dibutuhkan approval untuk hasil perbaikan laporan temuan</p></p>
    <p style="font-size: 16px;">Link temuan : {{ config('app.link_website') }}/detail/{{ $data['id'] }}</p>
<br>
<br>
<br>
    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>