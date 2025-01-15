<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keluar Kamar</title>
</head>

<body>
    <h1>Pengajuan Keluar Kamar</h1>
    <div style="margin: 0px">
        <p>Nama : <b>{{ $data['name'] }}</b></p>
        <p>Email : <b>{{ $data['email'] }}</b></p>
        <p>No. Rekening : <b>{{ $data['no_rek'] }}</b></p>
        <p>Jumlah Deposit : <b>{{ formatRupiah($data['amount_dp']) }}</b></p>
        <p>Tanggal Masuk : <b>{{ formatDateIndo($data['date_in']) }}</b></p>
        <p>Lama Tinggal : <b>{{ $data['long_stay'] }}</b></p>
        <p>Tanggal Keluar : <b>{{ formatDateIndo($data['date']) }}</b></p>
    </div>
</body>

</html>
