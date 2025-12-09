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
        EHS already approved perbaikan temuan EHS patrol pada Area {{ $data[0]['area']->name }} dan tanggal patroli <strong>{{ $data[0]['laporan_patrol']['tanggal_patrol'] }}</strong> dengan detail berikut :
    </p>
    @foreach ($data as $item)
    <ul>
        <li>
            <p style="font-size: 16px;">Temuan : {{ $item['temuan'] }}</p>
        </li>
        @if($item['rank'] == 'A') <li> <p> Dengan status rank {{ $item['rank'] }} </p></li> @endif
        <li>
            <p style="font-size: 16px;">Link temuan : {{ config('app.link_website') }}/detail/{{ $item['id'] }}</p>
        </li>
    </ul>
    <br>
    @endforeach
    <p style="font-size: 16px;">Link Laporan Patroli : {{ config('app.link_website') }}/patrolEHS/{{ $data[0]['id'] }}</p>
    <br>
    <br>
    <br>
        <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>