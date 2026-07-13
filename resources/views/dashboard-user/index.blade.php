<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengunjung & Pakta Integritas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/pakta.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <style>
        :root {
            --biru: #2563eb;
            --hijau: #16a34a;
            --abu: #64748b;
            --bg: #f1f5f9;
        }
        * { box-sizing: border-box; }
        body{
            font-family:'Segoe UI', Arial, sans-serif;
            background:var(--bg);
            margin:0;
            color:#0f172a;
        }     
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .header h1 { font-size: 22px; margin: 0; }
        .live-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--abu);
        }
        .dot {
            width: 8px; height: 8px;
            background: var(--hijau);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%   { opacity: 1; }
            50%  { opacity: .3; }
            100% { opacity: 1; }
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
        }
        .card .label { font-size: 13px; color: var(--abu); margin-bottom: 8px; }
        .card .value { font-size: 30px; font-weight: 700; }
        .card.pengunjung .value { color: var(--biru); }
        .card.fakta .value { color: var(--hijau); }
        .card.kepentingan {
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card.kepentingan select {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            color: #0f172a;
            background: #fff;
            margin-top: 8px;
            appearance: none;
        }
        .card.kepentingan .count {
            margin-top: 16px;
            font-size: 28px;
            font-weight: 700;
            color: #1d4ed8;
        }
        .chart-box {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            margin-bottom: 16px;
            overflow: visible;
            width: 100%;
            max-width: 980px;
        }
        .chart-box h3 { margin-top: 0; font-size: 15px; color: var(--abu); }
        .chart-box canvas{ width:100% !important; height:auto !important; display:block; }
        .grid-2 {
            display: flex;
            justify-content: center;
            gap: 16px;
            align-items: start;
        }
        @media (max-width: 1040px) {
            .grid-2 { display: block; }
        }
    </style>
</head>
<body>

@include('layouts.sidebar')

    <div class="paper-container dashboard-page">

        <div class="paper dashboard-paper">

    <div class="header">
        <h1>Dashboard Pengunjung & Pakta Integritas</h1>
        <div class="live-badge">
            <span class="dot"></span>
            Live &middot; update terakhir: <span id="updatedAt">-</span>
        </div>
    </div>

    <div class="cards">
        <div class="card pengunjung">
            <div class="label">Total Pengunjung</div>
            <div class="value" id="totalPengunjung">0</div>
        </div>
        <div class="card fakta">
            <div class="label">Total Isi Pakta Integritas</div>
            <div class="value" id="totalPakta">0</div>
        </div>
        <div class="card">
            <div class="label">Persentase Pengisian</div>
            <div class="value" id="persentase" style="color:#7c3aed;">0%</div>
        </div>
        <div class="card kepentingan">
            <div>
                <div class="label">Statistik Kepentingan</div>
                <div class="count" id="selectedKepentinganCount">0</div>
                <div class="label" id="selectedKepentinganLabel">Pilih kategori untuk melihat jumlah pengisi</div>
            </div>
            <div>
                <select id="kepentinganSelect">
                    <option value="Pengguna Jasa Pengujian">Pengguna Jasa Pengujian</option>
                    <option value="Penyedia Barang/Jasa">Penyedia Barang/Jasa</option>
                    <option value="Magang/PKL">Magang/PKL</option>
                    <option value="Pengguna Sewa Gedung">Pengguna Sewa Gedung</option>
                    <option value="Auditor">Auditor</option>
                    <option value="Pengguna Jasa Uji Profesi">Pengguna Jasa Uji Profesi</option>
                </select>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="chart-box">
            <h3>Tren 7 Hari Terakhir</h3>
            <canvas id="lineChart" height="110"></canvas>
        </div>
    </div>

    <script>
        const statsUrl = "{{ route('dashboard.stats') }}";
        const POLLING_INTERVAL_MS = 5000; // ubah sesuai kebutuhan, mis. 3000 - 10000

        const ctxLine = document.getElementById('lineChart');

        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Pengunjung',
                        data: [],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37,99,235,.1)',
                        tension: 0.35,
                        fill: true,
                    },
                    {
                        label: 'Isi Fakta Integritas',
                        data: [],
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22,163,74,.1)',
                        tension: 0.35,
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
            },
        });

        window.latestKepentinganData = {};

        document.getElementById('kepentinganSelect').addEventListener('change', function () {
            const selectedValue = this.value;
            const countValue = window.latestKepentinganData?.[selectedValue] ?? 0;
            document.getElementById('selectedKepentinganCount').textContent = countValue.toLocaleString('id-ID');
            document.getElementById('selectedKepentinganLabel').textContent = selectedValue + ' sudah mengisi';
        });

        async function loadStats() {
            try {
                const res = await fetch(statsUrl, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                if (!res.ok) throw new Error('Gagal ambil data');
                const data = await res.json();

                document.getElementById('totalPengunjung').textContent = data.total_pengunjung.toLocaleString('id-ID');
                document.getElementById('totalPakta').textContent = data.total_pakta.toLocaleString('id-ID');
                document.getElementById('persentase').textContent = data.persentase + '%';
                document.getElementById('updatedAt').textContent = data.updated_at;

                lineChart.data.labels = data.labels;
                lineChart.data.datasets[0].data = data.pengunjung;
                lineChart.data.datasets[1].data = data.pakta;
                lineChart.update();

                window.latestKepentinganData = data.kepentingan;
                const selectedValue = document.getElementById('kepentinganSelect').value;
                const countValue = data.kepentingan[selectedValue] ?? 0;
                document.getElementById('selectedKepentinganCount').textContent = countValue.toLocaleString('id-ID');
                document.getElementById('selectedKepentinganLabel').textContent = selectedValue + ' sudah mengisi';
            } catch (err) {
                console.error(err);
            }
        }

        loadStats();
        setInterval(loadStats, POLLING_INTERVAL_MS);
    </script>

        </div>
    </div>
</main>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const hamburger = document.getElementById("hamburger");
    const sidebar = document.getElementById("sidebar");
    const content = document.querySelector(".content");

    if(hamburger){

        hamburger.addEventListener("click", function(){

            sidebar.classList.toggle("close");
            content.classList.toggle("full");

        });

    }

});
</script>
</body>
</html>