<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Form Penilaian — Dashboard Admin BPMSPH</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin-navbar.css') }}">
<style>
  :root{
    --blue-900:#0B3D78; --blue-700:#0B4F9E; --blue-500:#2E7DD1;
    --blue-100:#EAF3FC; --blue-50:#F5F9FE; --white:#FFFFFF;
    --ink:#132038; --muted:#5B6B84; --border:#DCE7F5;
    --red:#D1477A; --red-bg:#FBEAF1;
    --radius:14px;
    --shadow: 0 1px 2px rgba(11,63,120,0.06), 0 8px 24px -12px rgba(11,63,120,0.18);
  }
  *{box-sizing:border-box;}
  body{ margin:0; font-family:'Inter',sans-serif; background:var(--blue-50); color:var(--ink); }
  .layout{ display:flex; min-height:100vh; }
  .sidebar{
    width:248px; flex-shrink:0;
    background:linear-gradient(180deg,var(--blue-900),var(--blue-700) 60%);
    color:var(--white); display:flex; flex-direction:column;
    padding:26px 18px; position:sticky; top:0; height:100vh;
  }
  .brand{ display:flex; align-items:center; gap:10px; padding:0 6px 26px; }
  .logo-box{ width:38px; height:38px; border-radius:12px; overflow:hidden; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:#fff; border:2px solid rgba(255,255,255,0.55); }
  .logo-box img{ width:100%; height:100%; object-fit:contain; }
  .brand-text .name{ font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14.5px; }
  .brand-text .sub{ font-size:11px; color:rgba(255,255,255,0.65); }
  .nav{ display:flex; flex-direction:column; gap:3px; margin-top:8px; }
  .nav a{ display:flex; align-items:center; gap:11px; padding:10px 12px; border-radius:10px; color:rgba(255,255,255,0.78); text-decoration:none; font-size:13.5px; font-weight:500; }
  .nav a svg{ width:17px; height:17px; opacity:.9; flex-shrink:0; }
  .nav a:hover{ background:rgba(255,255,255,0.12); color:var(--white); }
  .nav a.active{ background:rgba(255,255,255,0.15); color:var(--white); font-weight:600; }
  .nav-label{ font-size:10.5px; text-transform:uppercase; letter-spacing:.09em; color:rgba(255,255,255,0.4); margin:18px 12px 6px; }
  .sidebar-foot{ margin-top:auto; padding:14px 12px; border-radius:12px; background:rgba(255,255,255,0.07); font-size:11.5px; color:rgba(255,255,255,0.7); line-height:1.5; }
  .main{ flex:1; min-width:0; padding:26px 34px 60px; }
  .topbar h1{ font-family:'Plus Jakarta Sans',sans-serif; font-size:21px; font-weight:700; margin:0 0 14px; }

  .doc-sheet{ background:var(--white); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow); width:100%; max-width:1000px; min-height:297mm; margin-inline:auto; overflow:hidden; }

  .kop{ padding:20px 26px 0; }
  .kop table{ width:100%; border-collapse:collapse; border-bottom:3px double #000; }
  .kop td{ vertical-align:middle; padding-bottom:10px; }
  .kop .logo-kiri{ width:70px; text-align:left; }
  .kop .logo-kiri img{ width:60px; }
  .kop .teks-tengah{ text-align:center; }
  .kop .teks-tengah h3{ margin:0; font-size:14px; }
  .kop .teks-tengah h4{ margin:2px 0; font-size:12px; }
  .kop .teks-tengah p{ margin:2px 0; font-size:10px; }
  .kop .logo-kanan{ width:90px; text-align:center; font-size:8px; }
  .kop .logo-kanan img{ width:55px; margin-bottom:2px; }
  .fmi-label{ text-align:right; font-weight:bold; margin:8px 26px 6px; }

  .form-body{ padding:24px 26px; }
  .info-row{ display:flex; margin-bottom:8px; font-size:13.5px; }
  .info-row .label{ width:210px; color:var(--muted); }
  .info-row .value{ font-weight:600; }

  .criteria-table-scroll{ width:100%; overflow-x:auto; }
  .kriteria-table{ width:100%; border-collapse:collapse; margin-top:18px; }
  .kriteria-table th, .kriteria-table td{ border:1px solid var(--border); padding:9px 10px; font-size:13px; text-align:left; vertical-align:middle; }
  .kriteria-table th{ background:var(--blue-50); font-size:11.5px; text-transform:uppercase; letter-spacing:.04em; color:var(--muted); }
  .kriteria-table td.no-col{ width:36px; text-align:center; color:var(--muted); }
  .kriteria-table th.skor-col, .kriteria-table td.skor-col{ width:150px; min-width:150px; }
  .kriteria-table td.aksi-col{ width:44px; text-align:center; }
  .kriteria-table input[type="text"]{
    width:100%; border:none; font-size:13px; font-family:'Inter',sans-serif; outline:none;
  }
  .kriteria-table select{
    width:100%; min-width:120px; border:1px solid var(--border); border-radius:7px; padding:6px; font-size:13px;
  }
  .btn-remove{
    width:26px; height:26px; border:none; border-radius:7px;
    background:var(--red-bg); color:var(--red); font-size:14px; font-weight:700; cursor:pointer;
  }
  .btn-add-row{
    margin-top:12px; display:inline-flex; align-items:center; gap:6px;
    border:1px dashed var(--blue-500); background:var(--blue-50); color:var(--blue-700);
    font-size:12.5px; font-weight:600; padding:8px 14px; border-radius:9px; cursor:pointer;
  }
  .btn-add-row:hover{ background:var(--blue-100); }

  .field-group{ margin-top:22px; }
  .field-group label{ display:block; font-size:12.5px; font-weight:600; color:var(--muted); margin-bottom:6px; }
  .field-group textarea, .field-group input[type="text"]{
    width:100%; border:1px solid var(--border); border-radius:9px;
    padding:10px 13px; font-size:13px; font-family:'Inter',sans-serif; resize:vertical;
  }

  .ttd-box{ margin-top:26px; text-align:right; }
  .ttd-box canvas{ border:1px solid var(--border); border-radius:9px; width:260px; height:110px; margin-top:8px; }
  .btn-clear{
    margin-top:6px; border:1px solid var(--border); background:var(--white); color:var(--muted);
    font-size:11.5px; padding:5px 12px; border-radius:7px; cursor:pointer;
  }

  .form-actions{ margin-top:26px; display:flex; gap:10px; }
  .btn-submit{ background:var(--blue-700); color:#fff; border:none; border-radius:10px; padding:11px 24px; font-size:13.5px; font-weight:600; cursor:pointer; }
  .btn-submit:hover{ background:var(--blue-900); }
  .btn-cancel{
    background:var(--white); color:var(--muted); border:1px solid var(--border); border-radius:10px;
    padding:11px 24px; font-size:13.5px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center;
  }
  .btn-cancel:hover{ background:var(--blue-50); }

  @media (max-width: 760px){
    .main{ padding:20px 12px; }
    .topbar h1{ font-size:18px; }
    .doc-sheet{ min-height:0; }
    .kop{ padding:14px 12px 0; }
    .kop .logo-kiri{ width:48px; }
    .kop .logo-kiri img{ width:42px; }
    .kop .logo-kanan{ width:58px; }
    .kop .logo-kanan img{ width:42px; }
    .kop .teks-tengah h3{ font-size:11px; }
    .kop .teks-tengah h4{ font-size:9px; }
    .kop .teks-tengah p{ font-size:8px; }
    .fmi-label{ margin-right:12px; }
    .form-body{ padding:18px 12px; }
    .info-row{ gap:8px; font-size:12px; }
    .info-row .label{ width:130px; flex:0 0 130px; }
    .kriteria-table{ min-width:560px; }
    .form-actions{ flex-wrap:wrap; }
    .form-actions > *{ flex:1 1 140px; justify-content:center; }
    .ttd-box canvas{ width:min(100%,260px); }
    .info-row .label{ width:120px; flex-basis:120px; }
  }
</style>
</head>
<body>
@include('admin.layouts.navbar')
<div class="layout">

  <main class="main">
    <div class="topbar"><h1>{{ $pakta->penilaian ? 'Edit Penilaian' : 'Form Penilaian' }}</h1></div>

    <div class="doc-sheet">

      <div class="kop">
        <table>
          <tr>
            <td class="logo-kiri">
              <img src="{{ asset('img/logo-kementan.png') }}" alt="Logo Kementerian Pertanian">
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
              <img src="{{ asset('img/logo-kan.png') }}" alt="Logo akreditasi"><br>
              LP-315-IDN<br>
              PUP-013-IDN
            </td>
          </tr>
        </table>
      </div>
      <div class="fmi-label">F-PN-001</div>

      <div class="form-body">

        <div class="info-row"><div class="label">Nama Pengguna Jasa/Pelanggan</div><div class="value">: {{ $pakta->nama }}</div></div>
        <div class="info-row"><div class="label">Instansi</div><div class="value">: {{ $pakta->instansi }}</div></div>
        <div class="info-row"><div class="label">Jabatan</div><div class="value">: {{ $pakta->jabatan }}</div></div>
        <div class="info-row"><div class="label">Hubungan dengan BPMSPH</div><div class="value">: {{ $pakta->kepentingan }}</div></div>

        <form method="POST" action="{{ route('admin.pakta.penilaian.store', $pakta->id) }}" id="formPenilaian">
          @csrf

@if ($errors->any())
    <div style="margin: 12px 0; padding: 12px; background: #FBEAF1; color: #9F1239; border-radius: 8px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


          <div class="criteria-table-scroll">
            <table class="kriteria-table">
              <thead>
                <tr>
                  <th class="no-col">No</th>
                  <th>Kriteria</th>
                  <th class="skor-col">Skor</th>
                  <th class="aksi-col"></th>
                </tr>
              </thead>
              <tbody id="kriteria-list"></tbody>
            </table>
          </div>

          <button type="button" class="btn-add-row" onclick="tambahKriteria()">+ Tambah Kriteria</button>

          <div class="field-group">
            <label>Kesimpulan / Catatan Penilaian</label>
            <textarea name="catatan" rows="3" placeholder="Tulis kesimpulan hasil penilaian...">{{ old('catatan', $pakta->penilaian->catatan ?? '') }}</textarea>
          </div>

          <div class="field-group">
            <label>Nama Penilai</label>
            <input type="text" name="nama_penilai" value="{{ old('nama_penilai', $pakta->penilaian->nama_penilai ?? '') }}" placeholder="Nama admin/petugas penilai" required>
          </div>

          <div class="ttd-box">
            <div style="font-size:12.5px; color:var(--muted);">Tanda Tangan Penilai</div>
            <canvas id="signature"></canvas><br>
            <input type="hidden" name="signature" id="signature_input">
            <button type="button" class="btn-clear" onclick="signaturePad.clear()">Bersihkan</button>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-submit">{{ $pakta->penilaian ? 'Simpan Perubahan' : 'Simpan Penilaian' }}</button>
            <a href="{{ route('admin.pengisi-pakta') }}" class="btn-cancel">Batal</a>
          </div>
        </form>

      </div>
    </div>
  </main>
</div>

<script type="application/json" id="existing-kriteria-data">{!! json_encode($pakta->penilaian->kriteria ?? []) !!}</script>
<script type="application/json" id="existing-signature-data">{!! json_encode($pakta->penilaian->signature ?? null) !!}</script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.2.0/dist/signature_pad.umd.min.js"></script>
<script>
const KRITERIA_DEFAULT = {
    "Pengguna Jasa Pengujian": ["Kesesuaian sampel dengan prosedur pengujian","Ketepatan waktu pengambilan hasil","Kepatuhan terhadap prosedur administrasi"],
    "Penyedia Barang/Jasa": ["Kesesuaian barang/jasa dengan spesifikasi","Ketepatan waktu pengiriman/penyelesaian","Transparansi proses pengadaan"],
    "Magang/PKL": ["Kedisiplinan kehadiran","Sikap dan etika kerja","Pemahaman terhadap tugas yang diberikan"],
    "Pengguna Sewa Gedung": ["Kepatuhan terhadap tata tertib penggunaan gedung","Ketepatan waktu penggunaan sesuai jadwal","Kebersihan dan kerapian setelah penggunaan"],
    
"Auditor": [
    "Objektivitas dalam pelaksanaan audit",
    "Kepatuhan terhadap kode etik auditor",
    "Kualitas laporan hasil audit",
    "Kelengkapan bukti audit",
    "Ketepatan rekomendasi tindak lanjut"
],
    "Pengguna Jasa Uji Profesi": ["Kesesuaian dokumen persyaratan uji profesi","Kepatuhan terhadap jadwal pelaksanaan uji","Sikap selama proses pengujian"]
};

let kriteriaIndex = 0;

function buatBarisKriteria(namaKriteria, skorTerpilih) {
    const list = document.getElementById("kriteria-list");
    const nomor = list.children.length + 1;
    const row = document.createElement("tr");
    const opsiSkor = ['Tinggi', 'Sedang', 'Rendah'].map(function (v) {
        const selected = (skorTerpilih != null && String(skorTerpilih) === v) ? ' selected' : '';
        return '<option value="' + v + '"' + selected + '>' + v + '</option>';
    }).join('');
    const namaAman = (namaKriteria || '').replace(/"/g, '&quot;');
    row.innerHTML =
        '<td class="no-col nomor">' + nomor + '</td>' +
        '<td><input type="text" name="kriteria[' + kriteriaIndex + '][nama]" value="' + namaAman + '" placeholder="Nama kriteria" required></td>' +
        '<td class="skor-col"><select name="kriteria[' + kriteriaIndex + '][skor]" required>' +
            '<option value="">-</option>' + opsiSkor +
        '</select></td>' +
        '<td class="aksi-col"><button type="button" class="btn-remove" onclick="hapusBaris(this)">&times;</button></td>';
    list.appendChild(row);
    kriteriaIndex++;
}

function hapusBaris(btn) {
    btn.closest('tr').remove();
    document.querySelectorAll('#kriteria-list .nomor').forEach((el, i) => el.textContent = i + 1);
}

function tambahKriteria() { buatBarisKriteria(""); }

document.addEventListener("DOMContentLoaded", function () {
const EXISTING_KRITERIA = JSON.parse(document.getElementById("existing-kriteria-data").textContent);
const EXISTING_SIGNATURE = JSON.parse(document.getElementById("existing-signature-data").textContent);

    if (EXISTING_KRITERIA.length > 0) {
        // Mode edit: pakai kriteria & skor yang sudah tersimpan
        EXISTING_KRITERIA.forEach(item => buatBarisKriteria(item.nama, item.skor));
    } else {
        // Mode tambah baru: pakai default sesuai kategori
        const kepentingan = "{{ $pakta->kepentingan }}";
        const defaultList = KRITERIA_DEFAULT[kepentingan] || [];
        if (defaultList.length > 0) {
            defaultList.forEach(nama => buatBarisKriteria(nama));
        } else {
            buatBarisKriteria("");
        }
    }

    const canvas = document.getElementById("signature");
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
    window.signaturePad = new SignaturePad(canvas);

    if (EXISTING_SIGNATURE) {
        // Tampilkan tanda tangan lama di canvas, tetap bisa digambar ulang kalau mau ganti
        document.getElementById("signature_input").value = EXISTING_SIGNATURE;
        const img = new Image();
        img.onload = function () {
            canvas.getContext("2d").drawImage(img, 0, 0, canvas.width, canvas.height);
        };
        img.src = EXISTING_SIGNATURE;
    }

    document.getElementById("formPenilaian").addEventListener("submit", function (e) {
        if (!signaturePad.isEmpty()) {
            document.getElementById("signature_input").value = signaturePad.toDataURL();
        } else if (!document.getElementById("signature_input").value) {
            alert("Silakan tanda tangan terlebih dahulu.");
            e.preventDefault();
            return;
        }
        // Kalau canvas kosong tapi sudah ada tanda tangan lama tersimpan,
        // biarkan pakai signature_input yang sudah di-prefill (tidak wajib gambar ulang)
    });
});
</script>

</body>
</html>