<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .a4 {
            width: 18cm;
            padding: 10px;
        }

        .invoice-details {
            margin-bottom: 20px;
            padding: 10px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .fb {
            font-weight: bolder;
        }

        .address p {
            margin: 0;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="a4">
        <div class="invoice-details">
            <table style="width: 100%">
                <tr>
                    <td style="width: 30%"><img src="data:image/png;base64,{{ $base64Logo }}" alt="Logo" /></td>
                    <td class="address" style="width: 50%">
                        <p class="fb">JDS KOST KELAPA GADING</p>
                        <p>JL. KELAPA MOLEK II BLOK B2 NO 3</p>
                        <p>KELAPA GADING</p>
                        <p>08170056573</p>
                        <p>jdskost@gmail.com</p>
                    </td>
                    <td class="address">
                        <p style="font-size: 30px; font-weight: bolder; text-align: right">KWITANSI</p>
                    </td>
                </tr>
            </table>
            <p style="text-align: right;margin-right: 0px;font-weight: bold;font-style: italic;">{{$no}}</p>
            <table style="width: 100%;margin-top: 5px;">
                <tr>
                    <td>KEPADA</td>
                    <td style="text-align: right">{{ $date }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; font-size:1.5rem;">{{ $recipient_name }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>{{ $room }}</td>
                    <td></td>
                </tr>
            </table>
            <table style="color:white;background-color: rgb(28, 29, 41); width:100%;margin-top: 50px;">
                <tr>
                    <td style="padding: 5px;">Description</td>
                    <td style="padding: 5px;width: 30%; text-align: center">Price</td>
                </tr>
            </table>
            <table style="width:100%;">
                <tr>
                    <td style="padding: 5px;">{{ $description }}</td>
                    <td style="padding: 5px;width: 30%; text-align: center">{{ $price }}</td>
                </tr>
            </table>
            <div style="width: 100%; background-color: rgb(28, 29, 41);padding: 1px;margin-top:100px;"></div>
            <table style="width:100%;margin-top:10px;">
                <tr>
                    <td style="padding: 5px;"></td>
                    <td
                        style="padding: 5px;width: 30%; text-align: center; background-color: rgb(28, 29, 41);color:white">
                        Total: {{ $total }}
                    </td>
                </tr>
            </table>
            <div style="padding: 0px 10px;margin:1px;">
                <p>TRANSFER KE:</p>
                <p>Account Name : BCA a/n Edwin Setiadi</p>
                <p>Account No : 6340118535</p>
            </div>
            <table style="width:100%;margin-top:10px;margin-top: 100px">
                <tr>
                    <td style="padding: 5px;"></td>
                    <td style="padding: 5px;width: 30%; text-align: center;">
                        <p style="font-weight: bold;color:rgb(28, 29, 41);margin:0px">ANGELLIA SP</p>
                        <p style="font-size:12px;margin-top:3px">ADMINISTRASI</p>
                    </td>
                </tr>
            </table>
        </div>
</body>

</html>
