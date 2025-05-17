<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan KIP-K</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
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
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            margin-bottom: 30px;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid black;
            width: 200px;
            margin-left: auto;
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

    <div class="header">
        <h2>SURAT KETERANGAN</h2>
        <h3>PENERIMA KIP-K</h3>
        <p>Nomor: {{ date('Y') }}/KIP-K/{{ str_pad($mahasiswa->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala Program Studi {{ $mahasiswa->prodi->nama ?? '-' }}, menyatakan bahwa:</p>
        
        <table style="margin-left: 40px;">
            <tr>
                <td>No. Registrasi KIP-K</td>
                <td>: {{ $mahasiswa->noreg_kipk }}</td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>: {{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>: {{ $mahasiswa->NIM }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>: {{ $mahasiswa->prodi->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>: {{ $mahasiswa->jurusan->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Akreditasi Prodi</td>
                <td>: {{ $mahasiswa->akreditasi }}</td>
            </tr>
            <tr>
                <td>Angkatan</td>
                <td>: {{ $mahasiswa->angkatan }}</td>
            </tr>
            <tr>
                <td>Jalur Masuk</td>
                <td>: {{ $mahasiswa->jalur_masuk }}</td>
            </tr>
            <tr>
                <td>No. Handphone</td>
                <td>: {{ $mahasiswa->ponsel }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $mahasiswa->alamat }}</td>
            </tr>
        </table>

        <p style="margin-top: 20px;">
            Telah dinyatakan <strong>DITERIMA</strong> sebagai penerima Kartu Indonesia Pintar Kuliah (KIP-K) 
            berdasarkan hasil seleksi yang telah dilakukan.
        </p>
    </div>

    <div class="footer">
        <p>Jember, {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('D MMMM Y') }}</p>
        <table style="width: 100%; margin-top: 50px;">
            <tr>
                <td style="width: 33%; text-align: center;">
                    <p>Penerima KIP-K</p>
                    <div style="border-top: 1px solid black; width: 200px; margin: 50px auto 0;"></div>
                    <p>{{ $mahasiswa->nama }}</p>
                </td>
                <td style="width: 33%; text-align: center;">
                    <p>Wali Mahasiswa</p>
                    <div style="border-top: 1px solid black; width: 200px; margin: 50px auto 0;"></div>
                    <p>........................</p>
                </td>
                <td style="width: 33%; text-align: center;">
                    <p>Kepala Program Studi</p>
                    <div style="border-top: 1px solid black; width: 200px; margin: 50px auto 0;"></div>
                    <p>........................</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html> 