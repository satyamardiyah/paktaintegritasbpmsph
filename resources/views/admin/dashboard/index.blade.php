<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin — Pakta Integritas BPMSPH</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin-navbar.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<style>
  :root{
    --blue-900:#0B3D78;
    --blue-700:#0B4F9E;
    --blue-500:#2E7DD1;
    --blue-100:#EAF3FC;
    --blue-50:#F5F9FE;
    --white:#FFFFFF;
    --ink:#132038;
    --muted:#5B6B84;
    --border:#DCE7F5;
    --green:#17A673;
    --green-bg:#E7F7F1;
    --amber:#C9852B;
    --amber-bg:#FBF1E3;
    --purple:#7C5CBF;
    --purple-bg:#F1EDFB;
    --pink:#D1477A;
    --pink-bg:#FBEAF1;
    --teal:#1A8E8E;
    --teal-bg:#E7F6F6;
    --radius:14px;
    --shadow: 0 1px 2px rgba(11,63,120,0.06), 0 8px 24px -12px rgba(11,63,120,0.18);
  }
  *{box-sizing:border-box;}
  body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:var(--blue-50);
    color:var(--ink);
    -webkit-font-smoothing:antialiased;
  }
  .layout{ display:flex; min-height:100vh; }

  .sidebar{
    width:248px;
    flex-shrink:0;
    background:linear-gradient(180deg,var(--blue-900),var(--blue-700) 60%);
    color:var(--white);
    display:flex;
    flex-direction:column;
    padding:26px 18px;
    position:sticky;
    top:0;
    height:100vh;
  }
  .brand{ display:flex; align-items:center; gap:10px; padding:0 6px 26px; }
  .logo-box{
    width:38px; height:38px;
    border:2px solid rgba(255,255,255,0.55);
    border-radius:10px;
    overflow:hidden;
    flex-shrink:0;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
  }
  .logo-box img{
    width:100%;
    height:100%;
    object-fit:contain;
    display:block;
  }
  .brand-text{ line-height:1.2; }
  .brand-text .name{ font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:14.5px; }
  .brand-text .sub{ font-size:11px; color:rgba(255,255,255,0.65); letter-spacing:.02em; }

  .nav{ display:flex; flex-direction:column; gap:3px; margin-top:8px; }
  .nav a{
    display:flex; align-items:center; gap:11px;
    padding:10px 12px; border-radius:10px;
    color:rgba(255,255,255,0.78);
    text-decoration:none; font-size:13.5px; font-weight:500;
    transition:background .15s ease, color .15s ease;
  }
  .nav a svg{ width:17px; height:17px; opacity:.9; flex-shrink:0; }
  .nav a:hover{ background:rgba(255,255,255,0.12); color:var(--white); }
  .nav a.active{ background:rgba(255,255,255,0.15); color:var(--white); font-weight:600; }
  .nav-label{ font-size:10.5px; text-transform:uppercase; letter-spacing:.09em; color:rgba(255,255,255,0.4); margin:18px 12px 6px; }

  .sidebar-foot{
    margin-top:auto; padding:14px 12px; border-radius:12px;
    background:rgba(255,255,255,0.07);
    font-size:11.5px; color:rgba(255,255,255,0.7); line-height:1.5;
  }

  .main{ flex:1; min-width:0; padding:26px 34px 60px; }

  .topbar{
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:26px; gap:20px;
  }
  .topbar h1{ font-family:'Plus Jakarta Sans',sans-serif; font-size:21px; font-weight:700; margin:0 0 3px; }
  .topbar .desc{ font-size:13px; color:var(--muted); margin:0; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
  .admin-chip{
    display:flex; align-items:center; gap:10px;
    background:var(--white); border:1px solid var(--border);
    padding:7px 14px 7px 8px; border-radius:999px; box-shadow:var(--shadow);
  }
  .admin-chip .avatar{
    width:30px; height:30px; border-radius:50%;
    background:var(--blue-100); color:var(--blue-700);
    display:flex; align-items:center; justify-content:center;
    font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:12.5px;
  }
  .admin-chip .who{ line-height:1.25; }
  .admin-chip .who .n{ font-size:12.5px; font-weight:600; }
  .admin-chip .who .r{ font-size:10.5px; color:var(--muted); }

  .stats{ display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:22px; }
  .stat-card{
    background:var(--white); border:1px solid var(--border); border-radius:var(--radius);
    padding:18px 18px 16px; box-shadow:var(--shadow); position:relative; overflow:hidden;
  }
  .stat-card .icon{
    width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center;
    background:var(--blue-100); color:var(--blue-700); margin-bottom:14px;
  }
  .stat-card .icon svg{ width:17px; height:17px; }
  .stat-card .val{ font-family:'Plus Jakarta Sans',sans-serif; font-size:26px; font-weight:800; line-height:1; transition:color .3s ease; }
  .stat-card .val.bump{ color:var(--blue-700); }
  .stat-card .lbl{ font-size:12.5px; color:var(--muted); margin-top:6px; }
  .stat-card .delta{ position:absolute; top:18px; right:18px; font-size:11px; font-weight:600; padding:3px 8px; border-radius:999px; }
  .delta.up{ color:var(--green); background:var(--green-bg); }
  .delta.warn{ color:var(--amber); background:var(--amber-bg); }

  .panels{ display:grid; grid-template-columns:1.55fr 1fr; gap:16px; margin-bottom:16px; }
  .panel{
    background:var(--white); border:1px solid var(--border); border-radius:var(--radius);
    padding:20px 22px; box-shadow:var(--shadow);
  }
  .panel-head{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:14px; gap:10px;}
  .panel-head h2{ font-family:'Plus Jakarta Sans',sans-serif; font-size:15px; font-weight:700; margin:0 0 2px; }
  .panel-head p{ font-size:12px; color:var(--muted); margin:0; }
  .tabs{ display:flex; gap:4px; background:var(--blue-50); border:1px solid var(--border); border-radius:9px; padding:3px; }
  .tabs button{
    border:none; background:transparent; font-family:'Inter',sans-serif; font-size:11.5px; font-weight:600;
    color:var(--muted); padding:6px 11px; border-radius:7px; cursor:pointer;
    transition:background .15s ease, color .15s ease;
  }
  .tabs button:hover:not(.active){ background:rgba(11,79,158,0.08); color:var(--blue-700); }
  .tabs button.active{ background:var(--blue-700); color:var(--white); }
  .chart-wrap{ height:230px; }
  .chart-wrap.small{ height:210px; }
  .score-chart-wrap{ height:300px; }
  .score-summary{ margin:12px 0 0; font-size:13px; font-weight:600; color:var(--blue-700); }
  .score-summary.empty{ font-weight:400; color:var(--muted); }

  .legend-row{ display:flex; gap:16px; margin-top:12px; flex-wrap:wrap; }
  .legend-item{ display:flex; align-items:center; gap:7px; font-size:11.5px; color:var(--muted); }
  .dot{ width:9px; height:9px; border-radius:3px; }

  .table-panel{ background:var(--white); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow); overflow:hidden; }
  .table-panel .panel-head{ padding:20px 22px 0; }
  .table-scroll{ overflow-x:auto; }
  table{ width:100%; min-width:920px; border-collapse:collapse; margin-top:8px; }
  thead th{
    text-align:left; font-size:10.5px; text-transform:uppercase; letter-spacing:.06em;
    color:var(--muted); font-weight:600; padding:11px 22px; border-bottom:1px solid var(--border);
    background:var(--blue-50); white-space:nowrap;
  }
  tbody td{ padding:13px 22px; font-size:13px; border-bottom:1px solid var(--border); vertical-align:top; }
  tbody tr:last-child td{ border-bottom:none; }
  tbody tr:hover{ background:var(--blue-50); }
  tbody tr.row-new{ animation:rowIn .6s ease; }
  @keyframes rowIn{
    from{ background:var(--blue-100); }
    to{ background:transparent; }
  }
  .name-cell{ display:flex; align-items:center; gap:10px; }
  .name-details{ flex:1; min-width:0; }
  .mini-avatar{
    width:28px; height:28px; border-radius:50%; background:var(--blue-100); color:var(--blue-700);
    font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:11px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
  }
  .name-main{ font-weight:600; font-size:13px; line-height:1.35; overflow-wrap:anywhere; }
  .name-sub{ margin-top:3px; font-size:11px; line-height:1.3; color:var(--muted); overflow-wrap:anywhere; }
  .addr-cell{ max-width:190px; }
  .addr-main{ font-weight:600; font-size:12.5px; }
  .addr-sub{ font-size:11px; color:var(--muted); margin-top:2px; line-height:1.4; }
  .email-cell{ font-size:12.5px; color:var(--blue-700); }
  .badge{
    display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:600;
    padding:4px 10px; border-radius:999px; white-space:nowrap;
  }
  .badge.done{ color:var(--green); background:var(--green-bg); }
  .badge.pending{ color:var(--amber); background:var(--amber-bg); }
  .mono{ font-family:'IBM Plex Mono',monospace; font-size:11.5px; color:var(--muted); }

  @media (max-width: 1080px){
    .panels{ grid-template-columns:1fr; }
    .stats{ grid-template-columns:repeat(2,1fr); }
  }
  @media (max-width: 760px){
    .main{ padding:16px 12px 32px; }
    .main > *{ width:100%; max-width:100%; min-width:0; }
    .stats{ grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; }
    .stat-card{ min-width:0; padding:14px 12px; }
    .stat-card .val{ font-size:22px; overflow-wrap:anywhere; }
    .stat-card .lbl{ font-size:11px; }
    .panels{ width:100%; min-width:0; grid-template-columns:minmax(0,1fr) !important; gap:12px; }
    .panel, .table-panel{ width:100%; min-width:0; }
    .panel{ padding:16px 14px; }
    .panel-head{ flex-wrap:wrap; }
    .tabs{ max-width:100%; }
    .tabs button{ padding:6px 8px; font-size:10.5px; }
    .chart-wrap, .chart-wrap.small{ width:100%; min-width:0; height:210px; }
    .score-chart-wrap{ height:280px; }
    .table-scroll{ width:100%; max-width:100%; overflow-x:auto; }
    .topbar{ align-items:flex-start; flex-wrap:wrap; gap:12px; }
    .topbar h1{ font-size:18px; }
  }

  @media (max-width: 380px){
    .stats{ grid-template-columns:minmax(0,1fr); }
    .admin-chip{ padding-right:10px; }
  }
</style>
</head>
<body>
@include('admin.layouts.navbar')
<div class="layout">

  <main class="main">

    <div class="topbar">
      <div>
        <h1>Dashboard Admin</h1>
      </div>
      <div class="admin-chip">
        <div class="avatar">AD</div>
        <div class="who">
          <div class="n">Admin BPMSPH</div>
          <div class="r">Administrator</div>
        </div>
      </div>
    </div>

    <div class="stats">
      <div class="stat-card">
        <div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></div>
        <div class="delta up" id="deltaKunjungan">▲ 0%</div>
        <div class="val" id="statKunjungan">0</div>
        <div class="lbl">Total kunjungan bulan ini</div>
      </div>
      <div class="stat-card">
        <div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="m9 15 2 2 4-4"/></svg></div>
        <div class="delta up" id="deltaPengisi">▲ 0%</div>
        <div class="val" id="statPengisi">0</div>
        <div class="lbl">Total pengisi Pakta Integritas</div>
      </div>
      <div class="stat-card">
        <div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div class="delta warn" id="deltaHariIni">▼ 0%</div>
        <div class="val" id="statHariIni">0</div>
        <div class="lbl">Pengunjung hari ini</div>
      </div>
      <div class="stat-card">
        <div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
        <div class="delta up" id="deltaRasio">0%</div>
        <div class="val" id="statRasio">0/0</div>
        <div class="lbl">Rasio pengunjung → pengisi</div>
      </div>
    </div>

    <div class="panels">
      <div class="panel">
        <div class="panel-head">
          <div>
            <h2>Grafik Kunjungan</h2>
            <p id="kunjunganSubtitle">Jumlah pengunjung situs per hari, 30 hari terakhir</p>
          </div>
          <div class="tabs" id="tabsKunjungan">
            <button class="active" data-view="harian">Harian</button>
            <button data-view="mingguan">Mingguan</button>
            <button data-view="bulanan">Bulanan</button>
          </div>
        </div>
        <div class="chart-wrap"><canvas id="chartKunjungan"></canvas></div>
      </div>

      <div class="panel">
        <div class="panel-head">
          <div>
            <h2>Pengisi per Kepentingan dengan BPMSPH</h2>
            <p>Distribusi kategori kepentingan pengisi Pakta Integritas</p>
          </div>
        </div>
        <div class="chart-wrap small"><canvas id="chartUnit"></canvas></div>
        <div class="legend-row" id="legendUnit"></div>
      </div>
    </div>

    <div class="panels" style="grid-template-columns:1fr;">
      <div class="panel">
        <div class="panel-head">
          <div>
            <h2>Tren Pengisi Pakta Integritas</h2>
            <p>Perbandingan jumlah pengunjung dan pengisi per bulan</p>
          </div>
        </div>
        <div class="chart-wrap"><canvas id="chartTren"></canvas></div>
      </div>
    </div>

    <div class="panels" style="grid-template-columns:1fr;">
      <div class="panel">
        <div class="panel-head">
          <div>
            <h2>Nilai Penilaian per Kategori</h2>
            <p>Rata-rata skor dari kriteria yang telah dinilai admin (skala 1–3)</p>
          </div>
        </div>
        <div class="chart-wrap score-chart-wrap"><canvas id="chartCategoryScores"></canvas></div>
        <p class="score-summary empty" id="topRatedCategory">Belum ada data penilaian.</p>
      </div>
    </div>

    <div class="panels" style="grid-template-columns:1fr;">
      <div class="panel">
        <div class="panel-head">
          <div>
            <h2>Rekapitulasi Hasil Penilaian</h2>
            <p>Rata-rata nilai akhir berdasarkan kategori kepentingan</p>
          </div>
        </div>

        <div class="table-scroll">
          <table style="width:100%; min-width:650px;">
            <thead>
              <tr>
                <th>Kategori Kepentingan</th>
                <th>Jumlah Dinilai</th>
                <th>Rata-rata Nilai Akhir</th>
                <th>Hasil</th>
              </tr>
            </thead>
            <tbody id="rekapPenilaianBody">
              <tr>
                <td colspan="4">Memuat data penilaian...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>


  </main>
</div>

<script>
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#5B6B84';

const COLORS = {
  blue900:'#0B3D78',
  blue700:'#0B4F9E',
  blue500:'#2E7DD1',
  blue300:'#7FB2E8',
  blue100:'#C7DEF6',
  purple:'#7C5CBF',
  amber:'#C9852B',
  pink:'#D1477A'
};

const ADMIN_STATS_URL = "{{ route('admin.dashboard.stats') }}";
const KEPENTINGAN = [
  { label:'Pengguna Jasa Pengujian', color: COLORS.blue700, bg: '#EAF3FC' },
  { label:'Penyedia Barang/Jasa', color: COLORS.blue500, bg: '#fcc204' },
  { label:'Magang/PKL', color: '#000000', bg: '#E7F7F1' },
  { label:'Pengguna Sewa Gedung', color: COLORS.purple, bg: '#F1EDFB' },
  { label:'Auditor', color: COLORS.amber, bg: '#FBF1E3' },
  { label:'Pengguna Jasa Uji Profesi', color: COLORS.pink, bg: '#FBEAF1' }
];
const KEPENTINGAN_MAP = KEPENTINGAN.reduce((acc, item) => {
  acc[item.label] = item;
  return acc;
}, {});
const KATEGORI_REKAP = [
  'Pengguna Jasa Pengujian',
  'Penyedia Barang/Jasa',
  'Magang/PKL',
  'Pengguna Sewa Gedung',
  'Auditor',
  'Pengguna Jasa Uji Profesi'
];

let chartKunjungan = null;
let chartUnit = null;
let chartTren = null;
let chartCategoryScores = null;
let stats = { total_kunjungan: 0, total_pengisi: 0, hari_ini: 0 };
let daftarHasilPenilaian = [];
let kunjunganViews = { harian: { labels: [], values: [] }, mingguan: { labels: [], values: [] }, bulanan: { labels: [], values: [] } };
let currentView = 'harian';
let trenLabels = [];
let trenPengunjung = [];
let trenPengisi = [];
let latestRows = [];
let kepentinganData = [0, 0, 0, 0, 0, 0];
let categoryScoreRows = [];
let topRatedCategories = [];

function pad(n) {
  return n.toString().padStart(2, '0');
}

function buildWeeklyView(labels, values) {
  const result = { labels: [], values: [] };
  for (let i = 0; i < values.length; i += 7) {
    const weekValues = values.slice(i, i + 7);
    const weekLabel = labels[i] || `Mgg ${result.values.length + 1}`;
    result.labels.push(weekLabel);
    result.values.push(weekValues.reduce((sum, value) => sum + value, 0));
  }
  return result;
}

function transformLatestRows(rows) {
  return rows.map(row => ({
    ...row,
    kepentingan: KEPENTINGAN_MAP[row.kepentingan] || { color: COLORS.blue700, bg: '#EAF3FC', label: row.kepentingan }
  }));
}

document.addEventListener('DOMContentLoaded', () => {
  initCharts();
  fetchStats();
  setInterval(fetchStats, 10000);

  const tabButtons = document.querySelectorAll('#tabsKunjungan button');
  tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      tabButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentView = btn.dataset.view;
      updateKunjunganChart();
      const subtitles = {
        harian: 'Jumlah pengunjung situs per hari, 30 hari terakhir',
        mingguan: 'Jumlah pengunjung situs per minggu, 12 minggu terakhir',
        bulanan: 'Jumlah pengunjung situs per bulan, 6 bulan terakhir'
      };
      document.getElementById('kunjunganSubtitle').innerText = subtitles[currentView];
    });
  });
});

function fetchStats() {
  fetch(ADMIN_STATS_URL)
    .then(response => {
      if (!response.ok) {
        throw new Error('Gagal memuat data dashboard');
      }
      return response.json();
    })
    .then(data => {
      stats.total_kunjungan = data.total_kunjungan;
      stats.total_pengisi = data.total_pengisi;
      stats.hari_ini = data.hari_ini;

      kunjunganViews.harian = { labels: data.labels, values: data.pengunjung };
      kunjunganViews.mingguan = buildWeeklyView(data.labels, data.pengunjung);
      kunjunganViews.bulanan = { labels: data.trend_labels, values: data.trend_pengunjung };

      trenLabels = data.trend_labels;
      trenPengunjung = data.trend_pengunjung;
      trenPengisi = data.trend_pengisi;

      kepentinganData = KEPENTINGAN.map(item => data.kepentingan[item.label] || 0);
      latestRows = transformLatestRows(data.latest_rows);
      categoryScoreRows = data.category_scores || [];
      daftarHasilPenilaian = data.daftar_hasil_penilaian || [];
      renderRekapPenilaian(data.rekap_penilaian || []);
      topRatedCategories = data.top_rated_categories || [];

      renderAll();
    })
    .catch(error => {
      console.error(error);
    });
}

function kepentinganCounts() {
  return {
    labels: KEPENTINGAN.map(k => k.label),
    values: kepentinganData,
    colors: KEPENTINGAN.map(k => k.color)
  };
}

function initCharts() {
  chartKunjungan = new Chart(document.getElementById('chartKunjungan'), {
    type: 'line',
    data: { labels: [], datasets: [{
      label: 'Pengunjung',
      data: [],
      borderColor: COLORS.blue700,
      borderWidth: 2.5,
      pointRadius: 0,
      pointHoverRadius: 4,
      tension: 0.35,
      fill: true,
      backgroundColor: ctx => {
        const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 240);
        gradient.addColorStop(0, 'rgba(11,79,158,0.22)');
        gradient.addColorStop(1, 'rgba(11,79,158,0)');
        return gradient;
      }
    }] },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: { duration: 400 },
      interaction: { intersect: false, mode: 'index' },
      plugins: { legend: { display: false }, tooltip: { backgroundColor: COLORS.blue900, padding: 10, cornerRadius: 10 } },
      scales: { x: { grid: { display: false }, ticks: { maxTicksLimit: 8 } }, y: { beginAtZero: true, grid: { color: '#EAF3FC' } } }
    }
  });

  chartUnit = new Chart(document.getElementById('chartUnit'), {
    type: 'doughnut',
    data: { labels: [], datasets: [{ data: [], backgroundColor: [COLORS.blue700, COLORS.blue500, COLORS.green, COLORS.purple, COLORS.amber, COLORS.pink], borderWidth: 3, borderColor: '#fff', hoverOffset: 6 }] },
    options: { responsive: true, maintainAspectRatio: false, cutout: '68%', animation: { duration: 400 }, plugins: { legend: { display: false }, tooltip: { backgroundColor: COLORS.blue900 } } }
  });

  chartTren = new Chart(document.getElementById('chartTren'), {
    type: 'bar',
    data: { labels: [], datasets: [ { label: 'Pengunjung', data: [], backgroundColor: COLORS.blue100, borderRadius: 6, maxBarThickness: 34 }, { label: 'Pengisi Pakta', data: [], backgroundColor: COLORS.blue700, borderRadius: 6, maxBarThickness: 34 } ] },
    options: { responsive: true, maintainAspectRatio: false, animation: { duration: 400 }, plugins: { legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8 } }, tooltip: { backgroundColor: COLORS.blue900 } }, scales: { x: { grid: { display: false } }, y: { beginAtZero: true, grid: { color: '#EAF3FC' } } } }
  });

  chartCategoryScores = new Chart(document.getElementById('chartCategoryScores'), {
    type: 'bar',
    data: { labels: [], datasets: [{
      label: 'Rata-rata skor',
      data: [],
      backgroundColor: [],
      borderRadius: 6,
      maxBarThickness: 30
    }] },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      animation: { duration: 400 },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: COLORS.blue900,
          callbacks: {
            label: context => {
              const value = Number(context.raw);
              return `Rata-rata: ${value.toFixed(2)} (${scoreLevel(value)})`;
            }
          }
        }
      },
      scales: {
        x: {
          min: 0,
          max: 3,
          ticks: {
            stepSize: 1,
            callback: value => ({ 1: 'Rendah', 2: 'Sedang', 3: 'Tinggi' }[value] || '')
          },
          grid: { color: '#EAF3FC' }
        },
        y: { grid: { display: false } }
      }
    }
  });

}

function renderAll() {
  updateStats();
  updateKunjunganChart();
  updateUnitChart();
  updateTrendChart();
  updateCategoryScoreChart();
  updateTable();
}

function updateStats() {
  setStat('statKunjungan', formatNumber(stats.total_kunjungan));
  setStat('statPengisi', formatNumber(stats.total_pengisi));
  setStat('statHariIni', formatNumber(stats.hari_ini));
  setStat('statRasio', formatNumber(stats.total_pengisi) + '/' + formatNumber(stats.total_kunjungan));
  document.getElementById('deltaKunjungan').innerText = '▲ 8,2%';
  document.getElementById('deltaPengisi').innerText = '▲ 4,6%';
  document.getElementById('deltaHariIni').innerText = '▼ 1,3%';
  const rasio = stats.total_kunjungan > 0 ? Math.round((stats.total_pengisi / stats.total_kunjungan) * 1000) / 10 : 0;
  document.getElementById('deltaRasio').innerText = rasio + '%';
}

function setStat(id, value) {
  const el = document.getElementById(id);
  if (el && el.innerText !== String(value)) {
    el.innerText = value;
    el.classList.add('bump');
    setTimeout(() => el.classList.remove('bump'), 500);
  }
}

function updateKunjunganChart() {
  const view = kunjunganViews[currentView] || kunjunganViews.harian;
  chartKunjungan.data.labels = view.labels;
  chartKunjungan.data.datasets[0].data = view.values;
  chartKunjungan.update();
}

function updateUnitChart() {
  const unit = kepentinganCounts();
  chartUnit.data.labels = unit.labels;
  chartUnit.data.datasets[0].data = unit.values;
  chartUnit.update();
  updateLegend(unit);
}

function updateLegend(unit) {
  const legend = document.getElementById('legendUnit');
  legend.innerHTML = '';
  const total = unit.values.reduce((sum, value) => sum + value, 0);
  unit.labels.forEach((label, index) => {
    const percent = total ? Math.round((unit.values[index] / total) * 100) : 0;
    legend.innerHTML += `
      <div class="legend-item">
        <span class="dot" style="background:${unit.colors[index]}"></span>
        ${label} · ${percent}%
      </div>`;
  });
}

function updateTrendChart() {
  chartTren.data.labels = trenLabels;
  chartTren.data.datasets[0].data = trenPengunjung;
  chartTren.data.datasets[1].data = trenPengisi;
  chartTren.update();
}

function scoreLevel(value) {
  if (value >= 2.5) return 'Tinggi';
  if (value >= 1.5) return 'Sedang';
  return 'Rendah';
}

function updateCategoryScoreChart() {
  const highest = categoryScoreRows.reduce((max, row) => Math.max(max, row.average), 0);
  chartCategoryScores.data.labels = categoryScoreRows.map(row => row.label);
  chartCategoryScores.data.datasets[0].data = categoryScoreRows.map(row => row.average);
  chartCategoryScores.data.datasets[0].backgroundColor = categoryScoreRows.map(row =>
    topRatedCategories.includes(row.label) ? '#17A673' : COLORS.blue500
  );
  chartCategoryScores.update();

  const summary = document.getElementById('topRatedCategory');
  if (topRatedCategories.length === 0) {
    summary.textContent = 'Belum ada data penilaian.';
    summary.classList.add('empty');
    return;
  }

  summary.textContent = `Nilai tertinggi: ${topRatedCategories.join(', ')} — ${highest.toFixed(2)}/3 (${scoreLevel(highest)})`;
  summary.classList.remove('empty');
}

function renderRekapPenilaian(data) {
  const tbody = document.getElementById('rekapPenilaianBody');
  if (!tbody) return;

  tbody.replaceChildren();

  KATEGORI_REKAP.forEach(kategori => {
    const item = data.find(row => row.kategori === kategori);
    const jumlah = Number(item?.jumlah_dinilai ?? 0);
    const rataRata = item?.rata_rata;

    let nilai = '—';
    let hasil = '—';

    if (jumlah > 0 && rataRata !== null && rataRata !== undefined) {
      const skor = Number(rataRata);

      nilai = skor.toLocaleString('id-ID', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });

      hasil = skor >= 80
        ? 'Tinggi'
        : skor >= 60
          ? 'Sedang'
          : 'Rendah';
    }

    const tr = document.createElement('tr');

    [kategori, jumlah, nilai, hasil].forEach(teks => {
      const td = document.createElement('td');
      td.textContent = teks;
      tr.appendChild(td);
    });

    tbody.appendChild(tr);
  });
}

function updateTable() {
  const tbody = document.getElementById('tableBody');
  tbody.innerHTML = '';
  latestRows.forEach(row => {
    const initials = row.nama.split(' ').map(word => word[0]).slice(0, 2).join('').toUpperCase();
    const kepentingan = typeof row.kepentingan === 'string' ? (KEPENTINGAN_MAP[row.kepentingan] || { color: COLORS.blue700, bg: '#EAF3FC', label: row.kepentingan }) : row.kepentingan;
    const badge = '<span class="badge done">✓ Terverifikasi</span>';
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>
        <div class="name-cell">
          <div class="mini-avatar">${initials}</div>
          <div class="name-details">
            <div class="name-main">${row.nama}</div>
            <div class="name-sub">${row.jabatan}</div>
          </div>
        </div>
      </td>
      <td>
        <div class="addr-cell">
          <div class="addr-main">${row.instansi}</div>
          <div class="addr-sub">${row.alamat}</div>
        </div>
      </td>
      <td class="email-cell">${row.email}</td>
      <td><span class="badge" style="color:${kepentingan.color}; background:${kepentingan.bg}">${kepentingan.label}</span></td>
      <td>${row.waktu}</td>
      <td class="mono">${row.ref}</td>
      <td>${badge}</td>
    `;
    tbody.appendChild(tr);
  });
}

function formatNumber(number) {
  return new Intl.NumberFormat('id-ID').format(number);
}
</script>