<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Department Head EHS</title>
</head>
<body style="color: black; font-family: Arial, sans-serif;">

    <h2 style="font-weight: bold;">Approved Department Head EHS</h2>

    <p style="font-size: 16px;">
        Department Head EHS already approved perbaikan temuan EHS patrol.
    </p>
    <p style="font-size: 16px;">Link Laporan : {{ config('app.link_website') }}/patrolEHS/{{ $data['id'] }}</p>

    <br>

    <p style="font-size: 16px;">Terima kasih.</p>

</body>
</html>
// {{-- <!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <title>Verifikasi Temuan</title>
// </head>
// <body style="color: black; font-family: Arial, sans-serif;">

//     <h2 style="font-weight: bold;">Verifikasi Temuan</h2>

//     <p style="font-size: 16px;">
//         Penemuan pada area <strong>{{ $data['area']->name }}</strong> telah approved oleh {{ $data['dept_EHS']->name }}.
//     </p>

//     <p style="font-size: 16px;">Berikut adalah detail datanya :</p>

//     <ul style="list-style-type: none; padding: 0;">
//         <li style="font-size: 16px;"><strong>Temuan EHS:</strong> {{ $data['temuan'] }}</li>
//         <li style="font-size: 16px;"><strong>Penanggulangan PIC:</strong> {{ $data['penanggulangan'] }}</li>
//         <li style="font-size: 16px;"><strong>PIC Area:</strong> {{ $data['PIC']->name }}</li>
//         <li style="font-size: 16px;"><strong>Due Date:</strong> {{ $data['deadline_date'] }}</li>
//         <li style="font-size: 16px;"><strong>Tanggal Perbaikan:</strong> {{ $data['PIC_submit_at'] }}</li>
//         <li style="font-size: 16px;"><strong>Approve Departement Head PIC:</strong> {{ $data['ACC_Dept_Head_PIC_At'] }}</li>
//         <li style="font-size: 16px;"><strong>Verifikasi dari EHS:</strong> {{ $data['verify_submit_at'] }}</li>
//         <li style="font-size: 16px;"><strong>Approve Departement Head EHS:</strong> {{ $data['ACC_Dept_Head_EHS_At'] }}</li>
//     </ul>

//     <p style="font-size: 16px;">
//         Jika diperkenankan, silakan lakukan approve pada aplikasi website portal.
//     </p>

//     <br>

//     <p style="font-size: 16px;">Terima kasih.</p>

// </body>
// </html> --}}