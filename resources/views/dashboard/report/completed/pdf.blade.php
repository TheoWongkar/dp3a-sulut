<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/app-logo.svg') }}" type="image/x-icon">
    <title>Laporan {{ $report->ticket_number }}</title>
    <style>
        /* Atur ukuran kertas dan margin */
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .kop {
            overflow: hidden;
        }

        .kop img {
            float: left;
            width: 90px;
            height: 80px;
            margin-right: 20px;
            margin-bottom: 20px
        }

        .kop-text {
            overflow: hidden;
        }

        .kop-text h1 {
            text-transform: uppercase;
            font-size: 14px;
            margin: 0;
            text-align: left;
        }

        .kop-text p {
            margin: 2px 0;
        }

        hr {
            border: 1px solid black;
            margin: 15px 0;
        }

        h1,
        h2 {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }

        p {
            font-size: 12px;
            margin: 5px 0;
            text-align: justify;
        }

        .section {
            margin-bottom: 15px;
        }

        /* Footer untuk nomor halaman (opsional) */
        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Bagian Kop Laporan -->
    <div class="kop">
        <img src="img/application-logo.svg" alt="Kop Surat">
        <div class="kop-text">
            <h1>Dinas Pemberdayaan Perempuan dan Perlindungan Anak</h1>
            <p>Jl. Balaikota No.01, Tikala Ares, Manado 95012</p>
            <p>Telepon: (0431) 456-7890 | Email: dp3asulut@gmail.com</p>
            <p>Website: https://dpppa.manadokota.go.id/</p>
        </div>
    </div>
    <hr>

    <!-- Bagian Judul Laporan -->
    <div class="section">
        <h1>Laporan Kejadian</h1>
        <p><strong>Nomor Tiket:</strong> {{ $report->ticket_number }}</p>
        <p><strong>Tanggal Kejadian:</strong>
            {{ \Carbon\Carbon::parse($report->date)->locale('id')->isoFormat('D MMMM YYYY') }}</p>
        <p><strong>Jenis Kekerasan:</strong> {{ $report->violence_category }}</p>
        <p><strong>Tempat Kejadian:</strong> {{ $report->scene }}, {{ $report->district }}, {{ $report->regency }}</p>
        <p><strong>Kronologi:</strong> {{ $report->chronology }}</p>
    </div>

    <!-- Informasi Korban & Pelaku dalam Tabel -->
    <div class="section">
        <table width="100%" cellspacing="0" cellpadding="5">
            <tr>
                <td width="50%" valign="top">
                    <h2>Informasi Korban</h2><br>
                    <strong>NIK:</strong> {{ $report->victim->nik }}<br>
                    <strong>Nama:</strong> {{ $report->victim->name }}<br>
                    <strong>Telepon:</strong> {{ $report->victim->phone }}<br>
                    <strong>Usia:</strong> {{ $report->victim->age }} tahun<br>
                    <strong>Jenis Kelamin:</strong> {{ $report->victim->gender }}<br>
                    <strong>Alamat:</strong> {{ $report->victim->address }}<br>
                </td>
                <td width="50%" valign="top">
                    <h2>Informasi Pelaku</h2><br>
                    <strong>NIK:</strong> {{ $report->suspect->nik }}<br>
                    <strong>Nama:</strong> {{ $report->suspect->name }}<br>
                    <strong>Telepon:</strong> {{ $report->suspect->phone }}<br>
                    <strong>Usia:</strong> {{ $report->suspect->age }} tahun<br>
                    <strong>Jenis Kelamin:</strong> {{ $report->suspect->gender }}<br>
                    <strong>Alamat:</strong> {{ $report->suspect->address }}<br>
                </td>
            </tr>
        </table>
    </div>

    <!-- Informasi Pelapor -->
    <div class="section">
        <h2>Informasi Pelapor</h2>
        <p><strong>NIK:</strong> {{ $report->reporter->nik }}</p>
        <p><strong>Nama:</strong> {{ $report->reporter->name }}</p>
        <p><strong>Telepon:</strong> {{ $report->reporter->phone }}</p>
        <p><strong>Usia:</strong> {{ $report->reporter->age }} tahun</p>
        <p><strong>Jenis Kelamin:</strong> {{ $report->reporter->gender }}</p>
        <p><strong>Alamat:</strong> {{ $report->reporter->address }}</p>
        <p><strong>Hubungan dengan korban:</strong> {{ $report->reporter->relationship_between }}</p>
    </div>

    <!-- Tempat Tanda Tangan -->
    <div style="margin-top: 50px; text-align: right;">
        <p>Manado, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
        <p style="margin-bottom: 70px;">Kepala Dinas,</p>
        <p><strong>Marcel</strong></p>
    </div>
</body>

</html>
