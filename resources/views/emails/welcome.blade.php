<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>

<body>
    <p>Kepada {{ $data['name'] }},</p>
    <p><b>Selamat Datang di JDS Kost</b></p>
    <p>Anda Telah menyewa kamar {{ $data['number_room'] }}, dan mulai masuk pada hari
        {{ formatDateIndo($data['date']) }}</p>
    <p>Pembayaran serta info lainnya, anda dapat masuk ke sistem kami dengan menekan: <a href="{{url('/login')}}">Masuk</a>, menggunakan email terdaftar dan default password: {{$data['password']}}</p>
    <p>Terima kasih</p>
    <p>JDS KOST</p>
</body>

</html>
