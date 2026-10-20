<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 30px 40px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #222; }
    .kop {
        width: 100%;
        border-bottom: 3px double #000;
        padding-bottom: 10px;
        margin-bottom: 8px;
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

    .judul { text-align:center; font-weight:bold; font-size:15px; text-decoration:underline; margin:16px 0; }

    .info p { margin:4px 0; }
    .info .label { display:inline-block; width:200px; }

    table.kriteria { width:100%; border-collapse:collapse; margin-top:14px; }
    table.kriteria th, table.kriteria td { border:1px solid #000; padding:6px 8px; font-size:11px; }
    table.kriteria th { background:#f0f0f0; text-align:center; }
    table.kriteria td.no { width:30px; text-align:center; }
    table.kriteria td.skor { width:60px; text-align:center; }

    .catatan { margin-top:16px; }
    .ttd { margin-top:40px; text-align:right; }
    .ttd-box { display:inline-block; text-align:center; }
    img.sign { height:65px; display:block; margin:6px auto; }
</style>
</head>
<body>

@php \Carbon\Carbon::setLocale('id'); @endphp

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

<div class="fmi-label">F-PN-001</div>

<div class="judul">HASIL PENILAIAN PAKTA INTEGRITAS</div>

<div class="info">
    <p><span class="label">Nama Pengguna Jasa</span>: {{ $penilaian->pakta->nama }}</p>
    <p><span class="label">Instansi</span>: {{ $penilaian->pakta->instansi }}</p>
    <p><span class="label">Jabatan</span>: {{ $penilaian->pakta->jabatan }}</p>
    <p><span class="label">Hubungan dengan BPMSPH</span>: {{ $penilaian->pakta->kepentingan }}</p>
</div>

<table class="kriteria">
    <tr>
        <th class="no">No</th>
        <th>Kriteria</th>
        <th class="skor">Skor</th>
    </tr>
    @foreach($penilaian->kriteria as $i => $item)
    <tr>
        <td class="no">{{ $i + 1 }}</td>
        <td>{{ $item['nama'] }}</td>
        <td class="skor">{{ \App\Models\Penilaian::scoreLabel($item['skor'] ?? null) }}</td>
    </tr>
    @endforeach
</table>

<div class="catatan">
    <strong>Kesimpulan / Catatan:</strong>
    <p>{{ $penilaian->catatan ?: '-' }}</p>
</div>

<div class="ttd">
    <p>Bogor, {{ $penilaian->created_at->translatedFormat('d F Y') }}</p>
    <p>Penilai,</p>
    <div class="ttd-box">
        <img class="sign" src="{{ $penilaian->signature }}">
        <p><strong>{{ $penilaian->nama_penilai }}</strong></p>
    </div>
</div>

</body>
</html>