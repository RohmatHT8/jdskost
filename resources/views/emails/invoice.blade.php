<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
</head>
<body>
    <p>Kepada {{ $data['name'] }},</p>
    <p>Berikut adalah kwitansi pembayaran Anda dengan nomor kwitansi: {{ $data['no'] }} pada hari {{ $data['date'] }}.</p>
    <p>Terima kasih</p>
    <p>JDS KOST</p>
</body>
</html>