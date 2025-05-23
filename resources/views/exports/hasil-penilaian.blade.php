<!DOCTYPE html> 
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .header-table td {
            vertical-align: top;
        }

        .logo {
            width: 70px;
            height: 70px;
        }

        .instansi-text {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.5;
        }

        .line {
            border-top: 2px solid black;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .document-info {
            font-size: 11px;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .document-info div {
            margin-bottom: 2px;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 11px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .footer {
            text-align: right;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
<table class="header-table" style="border: none;">
    <tr>
        <td style="width: 15%; border: none;">
            <img src="{{ public_path('images/logo-polije.png') }}" class="logo" alt="Logo">
        </td>
        <td style="width: 85%; border: none;" class="instansi-text">
            KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI<br>
            POLITEKNIK NEGERI JEMBER<br>
            JL. Mastrip PO BOX 164 Jember 68101
        </td>
    </tr>
</table>

    <div class="line"></div>

    <!-- INFO DOKUMEN -->
    <div class="document-info">
        <div><strong>Kode Dokumen</strong>: FR-JUR-031</div>
        <div><strong>Tanggal Berlaku</strong>: {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</div>
        <div><strong>Revisi</strong>: 0</div>
        <div><strong>Halaman</strong>: 1</div>
    </div>

    <!-- JUDUL -->
    <div class="title">{{ $title }}</div>
    <div class="subtitle">Tanggal: {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</div>

    <!-- TABEL -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>Jurusan</th>
                <th>Program Studi</th>
                <th>Akreditasi</th>
                <th>Total Nilai</th>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->mahasiswa->nama }}</td>
                    <td>{{ $item->mahasiswa->jurusan->nama }}</td>
                    <td>{{ $item->mahasiswa->prodi->nama }}</td>
                    <td>{{ $item->mahasiswa->prodi->akreditasi }}</td>
                    <td>{{ number_format($item->total_nilai, 4) }}</td>
                    <td>
                        @if($item->hasil == 'Diterima')
                            <span class="badge success">Diterima</span>
                        @else
                            <span class="badge danger">Tidak Diterima</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>

</body>
</html>