<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pakta Integritas</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pakta Integritas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pakta.css') }}">

</head>

<body>

@include('layouts.sidebar')

<div class="paper-container dashboard-page">

    <div class="paper dashboard-paper">

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

    <div class="kop">

        {{-- Ganti dengan logo Kementan --}}
        <img src="{{ asset('img/logo-kementan.png') }}" alt="logo">

        <div class="kop-text">

            <h5>KEMENTERIAN PERTANIAN</h5>

            <h6>DIREKTORAT JENDERAL PETERNAKAN DAN KESEHATAN HEWAN</h6>
            <h6>DIREKTORAT KESEHATAN MASYARAKAT VETERINER</h6>

            <h6>BALAI PENGUJIAN MUTU DAN SERTIFIKASI PRODUK HEWAN</h6>

            <p>Jl. PEMUDA NOMOR 29 A BOGOR 16161</p>
            <p>Telp: (0251) 8377111, 8353712 Fax: (0251) 8353712 E-mail: bpmsph@pertanian.go.id</p>

        </div>

        {{-- Logo BPMSPH --}}
        <div class="kan-logo-block">
            <img src="{{ asset('img/logo-kan.png') }}" alt="logo">
            <div class="kan-labels">
                <p>LP-315-IDN</p>
                <p>PUP-013-IDN</p>
            </div>
                <!-- paper content (no pan buttons) -->
            </div>

    </div>

    <hr class="garis1">
    <hr class="garis2">
    <div class="fmi-label">F-MI 01</div>

    <h4 class="judul">

        PAKTA INTEGRITAS

    </h4>


    <form action="{{ route('pakta.store') }}" method="POST">

        @csrf

        <p class="mb-3">
            Saya yang bertanda tangan di bawah ini:
        </p>
        <table>

            <tr>

                <td width="180">

                    Nama Lengkap

                </td>

                <td>

                    :

                </td>

                <td>

                    <input
                        type="text"
                        class="form-control"
                        id="nama"
                        name="nama"
                        required>

                </td>

            </tr>

            <tr>

                <td>

                    Jabatan

                </td>

                <td>

                    :

                </td>

                <td>

                    <input
                        type="text"
                        class="form-control"
                        name="jabatan"
                        required>

                </td>

            </tr>

            <tr>

                <td>

                    Instansi

                </td>

                <td>

                    :

                </td>

                <td>

                    <input
                        type="text"
                        class="form-control"
                        name="instansi"
                        required>

                </td>

            </tr>

            <tr>

                <td>

                    Email

                </td>

                <td>

                    :

                </td>

                <td>

                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        required>

                </td>

            </tr>

            <tr>

                <td>

                    Kepentingan dengan BPMSPH

                </td>

                <td>

                    :

                </td>

                <td>

                    <select
                        class="form-control"
                        name="kepentingan"
                        required>
                        <option value="" disabled selected>Pilih kepentingan</option>
                        <option value="Pengguna Jasa Pengujian">Pengguna Jasa Pengujian</option>
                        <option value="Penyedia Barang/Jasa">Penyedia Barang/Jasa</option>
                        <option value="Magang/PKL">Magang/PKL</option>
                        <option value="Pengguna Sewa Gedung">Pengguna Sewa Gedung</option>
                        <option value="Auditor">Auditor</option>
                        <option value="Pengguna Jasa Uji Profesi">Pengguna Jasa Uji Profesi</option>
                    </select>

                </td>

            </tr>

            <tr>

                <td>

                    Alamat

                </td>

                <td>

                    :

                </td>

                <td>

                    <textarea
                        rows="3"
                        class="form-control"
                        name="alamat"
                        required></textarea>

                </td>

            </tr>

        </table>

                <div class="isi">

            <p>                                  
 
                Saya yang bertanda tangan di bawah ini menyatakan dengan
                sesungguhnya bahwa saya bersedia melaksanakan seluruh
                ketentuan yang berlaku pada Balai Pengujian Mutu dan
                Sertifikasi Produk Hewan (BPMSPH) serta berkomitmen
                menjaga integritas dalam setiap pelaksanaan tugas.

            </p>

            <p>

                Dengan ini saya menyatakan bahwa saya:

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

        <div class="signature-area">

            <div class="ttd">

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

<p>

    Bogor,
    {{ Carbon::now()->translatedFormat('d F Y') }}

</p>

                <p>

                    Yang Membuat Pernyataan,

                </p>

                <canvas id="signature"></canvas>

                <input
                    type="hidden"
                    name="signature"
                    id="signature_input">

                <div class="mt-2">

                    <button
                        type="button"
                        class="btn btn-outline-dark btn-sm"
                        onclick="signaturePad.clear()">

                        Bersihkan

                    </button>

                </div>

                <br>

                <hr>

                <p
                    id="previewNama"
                    style="font-weight:bold;margin-top:-10px">

                    Nama Lengkap

                </p>

            </div>

        </div>

        <div class="text-center mt-5">

            <button
                class="btn btn-black px-5">

                Kirim Pakta Integritas

            </button>

        </div>

    </form>
    </div>
</div>
</main>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.2.0/dist/signature_pad.umd.min.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const hamburger = document.getElementById("hamburger");
    const sidebar = document.getElementById("sidebar");
    const content = document.querySelector(".content");
    const paper = document.querySelector(".paper.dashboard-paper");

    hamburger.addEventListener("click", function () {

        // hitung status sebelum toggle
        const wasClosed = sidebar.classList.contains("close");

        // toggle sidebar and content width so content margin adjusts
        sidebar.classList.toggle("close");
        if (content) content.classList.toggle('full');

        // jika ada paper container, geser horizontal sehingga hanya paper yang terlihat bergerak
        const paperContainer = document.querySelector('.paper-container.dashboard-page');

        if (paperContainer) {
            const shift = 180; // nilai pergeseran, sesuaikan jika perlu

            if (wasClosed) {
                // sidebar sebelumnya sempit, sekarang melebar -> geser paper ke kanan
                paperContainer.scrollBy({ left: shift, behavior: 'smooth' });
            } else {
                // sidebar sebelumnya lebar, sekarang sempit -> geser paper ke kiri
                paperContainer.scrollBy({ left: -shift, behavior: 'smooth' });
            }
        }

    });

    // no pan buttons — rely on scrollbar and toggle behavior

});

</script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.2.0/dist/signature_pad.umd.min.js"></script>
<script>
const canvas = document.getElementById("signature");

function resizeCanvas() {
    const ratio = Math.max(window.devicePixelRatio || 1, 1);

    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;

    canvas.getContext("2d").scale(ratio, ratio);
}

resizeCanvas();

const signaturePad = new SignaturePad(canvas);

window.addEventListener("resize", resizeCanvas);

document.querySelector("form").addEventListener("submit", function () {

    if(signaturePad.isEmpty()){

        alert("Silakan tanda tangan terlebih dahulu.");

        event.preventDefault();

        return;

    }

    document.getElementById("signature_input").value =
        signaturePad.toDataURL();

});
</script>
<script>
const inputNama = document.getElementById("nama");
const previewNama = document.getElementById("previewNama");

inputNama.addEventListener("input", function () {

    if (this.value.trim() === "") {

        previewNama.textContent = "Nama Lengkap";

    } else {

        previewNama.textContent = this.value;

    }

});
</script>
</body>

</html>