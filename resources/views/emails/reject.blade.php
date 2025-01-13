<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reject</title>
</head>

<body>
    <p>Kepada {{ $data['name'] }},</p>
    <p>Mohon maaf atas ketidaknyamanannya, kami ingin memberitahukan bahwa pembayaran anda pada hari
        <b>{{ formatDateIndo($data['date']) }}</b> ditolak. dikarenakan:
        <b><i>{{ $data['note'] }}</i></b>, tapi tidak perlu khawatir anda hanya perlu melakukan penginputan bukti bayar kembali dengan
        data yang benar.</p>
    <p>Silahkan lakukan input pembayaran ulang</p>
    <a href="{{ url('/pay-rent') }}" style="padding: 2px 3px; background-color: rgb(51, 51, 51); color:rgb(225, 229, 229);">Input Ulang</a>
    <p>Terima kasih</p>
    <p>JDS KOST</p>
</body>

</html>
