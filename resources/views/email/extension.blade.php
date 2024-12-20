<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpanjangan Sewa Berhasil</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px 30px;
            /* Tambahkan padding di kiri dan kanan */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            margin: 20px 0;
        }

        .button {
            display: block;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            width: 100%;
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td {
            padding: 10px;
            border: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/simkt.png') }}" width="100px" height="100px" alt="Logo Website">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h2>Hai, {{ $user->profile->name }}.</h2>
            <p>
                Selamat! Pembayaran perpanjangan Anda telah berhasil kami terima. Masa sewa Anda kini telah
                diperpanjang, informasi lebih lanjut dapat dilihat pada menu <b>Penghuni</b>.
            </p>
            <p>Informasi perpanjangan:</p>
            <table class="info-table">
                <tr>
                    <td>Kamar</td>
                    <td>:</td>
                    <td>{{ $user->userRoom->room->name }}</td>
                </tr>
                <tr>
                    <td>Asrama</td>
                    <td>:</td>
                    <td>{{ $user->userRoom->room->room_type == 'M' ? 'Putra' : 'Putri' }}</td>
                </tr>
                <tr>
                    <td>Masa Sewa</td>
                    <td>:</td>
                    <td>
                        {{ Carbon\Carbon::parse($beforeExtension)->isoFormat('D MMMM YYYY') }} -
                        {{ Carbon\Carbon::parse($user->userRoom->rent_period)->isoFormat('D MMMM YYYY') }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>Salam hormat,</p>
            <p>Tim {{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>
