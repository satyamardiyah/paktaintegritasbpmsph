<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 30px 40px; }
    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 12px;
        color: #222;
    }
    .kop {
        width: 100%;
        border-bottom: 3px double #000;
        padding-bottom: 10px;
        margin-bottom: 14px;
        overflow: hidden;
    }
    .kop table { width: 100%; border-collapse: collapse; }
    .kop td { vertical-align: middle; }
    .kop .logo-kiri { width: 70px; text-align: left; }
    .kop .logo-kiri img { width: 60px; }
    .kop .teks-tengah { text-align: center; }
    .kop .teks-tengah h3 { margin: 0; font-size: 14px; }
    .kop .teks-tengah h4 { margin: 2px 0; font-size: 12px; }
    .kop .teks-tengah p { margin: 2px 0; font-size: 10px; }
    .kop .logo-kanan { width: 90px; text-align: center; font-size: 8px; }
    .kop .logo-kanan img { width: 55px; margin-bottom: 2px; }

    .fmi-label { text-align: right; font-weight: bold; margin-bottom: 6px; }

    h3.judul {
        text-align: center;
        text-decoration: underline;
        font-size: 16px;
        margin: 20px 0;
    }

    table.data { width: 100%; margin: 14px 0; }
    table.data td { padding: 5px 6px; vertical-align: top; font-size: 12px; }
    table.data td:first-child { width: 170px; }
    table.data td:nth-child(2) { width: 15px; }

    .isi p { margin: 10px 0; text-align: justify; }
    .isi ol { margin: 8px 0; padding-left: 20px; }
    .isi ol li { margin-bottom: 4px; }

    .persetujuan { margin-top: 16px; font-size: 12px; }

    .ttd { margin-top: 50px; text-align: right; }
    .ttd p { margin: 3px 0; }
    img.sign { height: 70px; margin: 6px 0; }
    .nama-ttd { font-weight: bold; margin-top: 4px; }
</style>
</head>
<body>

<div class="kop">
    <table>
        <tr>
            <td class="logo-kiri">
                <img src="{{ public_path('img/logo-kementan.png') }}">
            </td>
            <td class="teks-tengah">
                <h3>KEMENTERIAN PERTANIAN</h3>
                <h4>DIREKTORAT JENDERAL PETERNAKAN DAN KESEHATAN HEWAN</h4>
                <h4>DIREKTORAT KESEHATAN MASYARAKAT VETERINER</h4>
                <h4>BALAI PENGUJIAN MUTU DAN SERTIFIKASI PRODUK HEWAN</h4>
                <p>Jl. Pemuda Nomor 29 A Bogor 16161</p>
                <p>Telp: (0251) 8377111, 8353712 Fax: (0251) 8353712 E-mail: bpmsph@pertanian.go.id</p>
            </td>
            <td class="logo-kanan">
                <img src="{{ public_path('img/logo-kan.png') }}"><br>
                LP-315-IDN<br>
                PUP-013-IDN
            </td>
        </tr>
    </table>
</div>

<div class="fmi-label">F-MI 01</div>

<h3 class="judul">PAKTA INTEGRITAS</h3>
<p style="text-align:right; margin-top:-14px;">No. Ref: {{ $pakta->ref_number }}</p>

<p>Saya yang bertanda tangan di bawah ini:</p>

<table class="data">
    <tr><td>Nama Lengkap</td><td>:</td><td>{{ $pakta->nama }}</td></tr>
    <tr><td>Jabatan</td><td>:</td><td>{{ $pakta->jabatan }}</td></tr>
    <tr><td>Instansi</td><td>:</td><td>{{ $pakta->instansi }}</td></tr>
    <tr><td>Email</td><td>:</td><td>{{ $pakta->email }}</td></tr>
    <tr><td>Kepentingan dengan BPMSPH</td><td>:</td><td>{{ $pakta->kepentingan }}</td></tr>
    <tr><td>Alamat</td><td>:</td><td>{{ $pakta->alamat }}</td></tr>
</table>

<div class="isi">
    <p>
Menyatakan bahwa saya dengan sungguh-sungguh dalam rangka pelaksanaan kegiatan di BPMSPH bersedia menjalankan dan mentaati hal-hal seperti yang tertulis dibawah ini :
    </p>
    <ol>
        <li>Berperan secara pro aktif dalam upaya pencegahan dan pemberantasan Korupsi, Kolusi dan Nepotisme (KKN) serta tidak melibatkan diri dalam perbuatan tercela;</li>
        <li>Tidak melakukan pemberian atau menerima secara langsung dan/atau tidak langsung berupa suap, hadiah, bantuan, atau bentuk lainnya yang tidak sesuai dengan ketentuan yang berlaku serta melaporkan pemberian permintaan tersebut apabila ada yang menerimanya;</li>
        <li>Bersikap transparan, jujur, objektif dan akuntabel dalam melaksanakan kegiatan BPMSPH;</li>
        <li>Menghindari benturan kepentingan (conflict of interest) dalam pelaksanaan kegiatan BPMSPH;</li>
        <li>Memberi contoh dalam kepatuhan terhadap peraturan perundang-undangan dalam melaksanakan kegiatan BPMSPH;</li>
        <li>Akan menyampaikan informasi penyimpangan integritas serta turut menjaga kerahasiaan atas pelanggaran peraturan yang dilaporkannya;</li>
        <li>Bila saya melanggar hal-hal tersebut di atas, saya siap menghadapi konsekuensi berdasarkan ketentuan dan perundang-undangan yang berlaku.</li>
    </ol>
</div>

<div class="ttd">
    <p>Bogor, {{ $pakta->created_at->translatedFormat('d F Y') }}</p>
    <p>Yang Membuat Pernyataan,</p>
    <img class="sign" src="{{ $pakta->signature }}">
    <p class="nama-ttd">{{ $pakta->nama }}</p>
</div>

</body>
</html>