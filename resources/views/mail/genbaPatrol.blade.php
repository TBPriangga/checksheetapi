<!DOCTYPE html>
<html>
<head>
  <title>Genba Management {{ $area }}</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 14px;
      line-height: 1.5;
      color: #333;
      padding: 20px;
      background-image: url('https://i.imgur.com/YOUR_IMAGE_URL.png');
      background-repeat: no-repeat;
      background-position: right top;
      background-size: 200px;
    }
    p {
      margin-bottom: 10px;
    }
    ul {
      padding-left: 20px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <p>Dear All Tim Auditor Genba Management {{ $area }},</p>
  <p>Semangat Pagi,</p>
  <p>Sehubungan adanya jadwal Genba Management {{ $area}}, Kami mengundang Bapak/Ibu Auditor & PIC Area untuk hadir pada:</p>
  <ul>
    <li>{{ $tanggal_patrol }}</li>
    <li>09.30-10.00 WIB, After Asakai Meeting</li>
    <li>Depan Office Produksi (Tempat asakai plant)</li>
  </ul>
  <p>Group & Anggota:</p>
  <table>
    <thead>
      <tr>
        <th>Group</th>
        <th>Anggota</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $group)
      <tr>
        <td>{{ $group->team->name }}</td>
        <td>
          <ul>
            @foreach($group->detail as $member)
            <li>{{ $member->genba_member->name }} - {{ $member->genba_member->npk }} @if($member->genba_member->id == $group->pic_auditor_id) (PIC Auditor) @endif</li>
            @endforeach
          </ul>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <p>Group & APD:</p>
  <table>
    <thead>
      <tr>
        <th>Group</th>
        <th>APD</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $group)
      <tr>
        <td>{{ $group->team->name }}</td>
        <td>Wajib APD Helm & Sepatu Safety</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <p>Mengingat pentingnya program perusahaan berjalan efektif, Kami mengharapkan kehadiran Tim Auditor & PIC area tepat waktu dan tidak diwakilkan.</p>
  <p>Mohon untuk diinformasikan kepada PIC Area terkait (leader/foreman) Wajib melakukan pendampingan Tim Auditor dalam pelaksanaannya dengan membawa</p>
  <ul>
    <li>'Form Perbaikan Genba Sebelumnya, Dilakukan Verifikasi Oleh Auditor'</li>
  </ul>
  <p>Serta hadir 5 menit sebelum Opening.</p>
  <p>Demikian, atas perhatian dan kerjasama yang baik kami ucapkan.</p>
  <p>Terima kasih</p>
</body>
</html>