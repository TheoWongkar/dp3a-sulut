<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Kasus</title>
    <style>
        @page {
            size: A4;
            margin: 2cm 1.5cm 2cm 2cm;
        }

        body {
            font-family: "Times New Roman", serif;
            line-height: 1.3;
            color: #000;
            font-size: 11pt;
            position: relative;
            min-height: 100%;
        }

        .kop-surat {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
        }

        .kop-surat td {
            border: none;
            vertical-align: middle;
        }

        .kop-logo {
            width: 100px;
            text-align: center;
        }

        .kop-logo img {
            height: 70px;
            display: block;
            margin: 0 auto;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h1 {
            font-size: 12pt;
            margin: 0;
            font-weight: bold;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 9pt;
        }

        h1.title {
            text-align: center;
            font-size: 12pt;
            margin: 10px 0 20px;
            font-weight: bold;
        }

        .pengantar {
            font-size: 10pt;
            text-align: justify;
            margin: 0;
        }

        h2 {
            font-size: 11pt;
            margin: 8px 0 4px;
        }

        .section p {
            margin: 2px 0;
            font-size: 10pt;
        }

        /* styling key-value */
        .label {
            color: #1d1d1d;
            font-weight: normal;
        }

        .value {
            font-weight: 100;
            color: #000;
        }

        .signature {
            position: absolute;
            bottom: 0;
            right: 0;
            text-align: right;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9pt;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT -->
    <table class="kop-surat">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('img/application-logo.svg') }}" alt="Logo Pemprov Sulut">
            </td>
            <td class="kop-text">
                <h1>PEMERINTAH DAERAH PROVINSI SULAWESI UTARA</h1>
                <h1>DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK</h1>
                <p>Jl. 17 Agustus, Kota Manado, Sulawesi Utara Kode Pos: 95111</p>
                <p>Telepon (+62) 431-843333 | Website: www.dp3a.sulutprov.go.id</p>
            </td>
        </tr>
    </table>

    <!-- HALAMAN 1: LAPORAN KASUS -->
    <h1 class="title">LAPORAN KASUS KEKERASAN</h1>

    <p class="pengantar">
        Dalam rangka melaksanakan tugas dan fungsi Dinas Pemberdayaan Perempuan dan Perlindungan Anak Provinsi Sulawesi
        Utara dalam memberikan perlindungan, pendampingan, serta penanganan kasus kekerasan terhadap perempuan dan anak,
        bersama ini disampaikan laporan resmi atas kasus yang telah diterima dan dapat diselesaikan sesuai prosedur.
    </p>

    <div class="section">
        <h2>Informasi Kasus</h2>
        <p><span class="label">Nomor Tiket:</span> <span class="value">{{ $report->ticket_number }}</span></p>
        <p><span class="label">Kategori Kekerasan:</span> <span class="value">{{ $report->violence_category }}</span>
        </p>
        <p><span class="label">Tanggal Kejadian:</span> <span
                class="value">{{ \Carbon\Carbon::parse($report->incident_date)->translatedFormat('d F Y') }}</span></p>
        <p><span class="label">Lokasi Kejadian:</span> <span class="value">{{ $report->scene }},
                {{ $report->district }}, {{ $report->regency }}</span></p>
        <p><span class="label">Kronologi Singkat:</span></p>
        <p style="text-align: justify;" class="value">{{ $report->chronology }}</p>
    </div>

    <div class="section">
        <h2>Data Pelapor</h2>
        <p><span class="label">Nama:</span> <span class="value">{{ $report->reporter->name }}</span></p>
        <p><span class="label">NIK:</span> <span class="value">{{ $report->reporter->nik }}</span></p>
        <p><span class="label">No. Telpon:</span> <span class="value">{{ $report->reporter->phone }}</span></p>
        <p><span class="label">Jenis Kelamin:</span> <span class="value">{{ $report->reporter->gender }}</span></p>
        <p><span class="label">Usia:</span> <span class="value">{{ $report->reporter->age }}</span></p>
        <p><span class="label">Hubungan dengan Korban:</span> <span
                class="value">{{ $report->reporter->relationship_between }}</span></p>
        <p><span class="label">Alamat:</span> <span class="value">{{ $report->reporter->address }}</span></p>
    </div>

    <!-- Data Korban & Pelaku dalam 2 kolom -->
    <table style="width: 100%; margin-top: 10px; border: none;">
        <tr>
            <td style="width: 50%; vertical-align: top; border: none; padding: 0 30px 0 0;">
                <div class="section">
                    <h2>Data Korban</h2>
                    <p><span class="label">Nama:</span> <span class="value">{{ $report->victim->name }}</span></p>
                    <p><span class="label">NIK:</span> <span class="value">{{ $report->victim->nik }}</span></p>
                    <p><span class="label">No. Telpon:</span> <span class="value">{{ $report->victim->phone }}</span>
                    </p>
                    <p><span class="label">Jenis Kelamin:</span> <span
                            class="value">{{ $report->victim->gender }}</span></p>
                    <p><span class="label">Usia:</span> <span class="value">{{ $report->victim->age }}</span></p>
                    <p><span class="label">Alamat:</span></p>
                    <p style="text-align: justify;" class="value">{{ $report->victim->address }}</p>
                </div>
            </td>
            <td style="width: 50%; vertical-align: top; border: none; padding: 0 0 0 30px;">
                <div class="section">
                    <h2>Data Terlapor/Pelaku</h2>
                    <p><span class="label">Nama:</span> <span class="value">{{ $report->suspect->name }}</span></p>
                    <p><span class="label">NIK:</span> <span class="value">{{ $report->suspect->nik }}</span></p>
                    <p><span class="label">No. Telpon:</span> <span
                            class="value">{{ $report->suspect->phone }}</span></p>
                    <p><span class="label">Jenis Kelamin:</span> <span
                            class="value">{{ $report->suspect->gender }}</span></p>
                    <p><span class="label">Usia:</span> <span class="value">{{ $report->suspect->age }}</span></p>
                    <p><span class="label">Alamat:</span></p>
                    <p style="text-align: justify;" class="value">{{ $report->suspect->address }}</p>
                </div>
            </td>
        </tr>
    </table>

    <!-- TANDA TANGAN -->
    <div class="signature">
        <p>Manado, {{ now()->translatedFormat('d F Y') }}</p>
        <p>{{ Auth::user()->employee->position }}</p>
        <br><br><br>
        <p><b>{{ Auth::user()->employee->name }}</b></p>
    </div>

    <!-- HALAMAN 2: LAMPIRAN -->
    <div class="page-break"></div>

    <h1 class="title">LAMPIRAN</h1>
    <h2>Riwayat Status Laporan</h2>
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Ditangani Oleh</th>
                <th>Deskripsi Tindakan</th>
                <th>Tanggal & Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report->statuses as $status)
                <tr>
                    <td>{{ $status->status }}</td>
                    <td>{{ $status->changedBy->employee->name ?? 'Sistem' }}</td>
                    <td>{{ $status->description ?: 'Tidak ada keterangan tambahan' }}</td>
                    <td>{{ $status->created_at->translatedFormat('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
