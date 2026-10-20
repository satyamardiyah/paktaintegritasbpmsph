<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengisi Pakta — Dashboard Admin BPMSPH</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin-navbar.css') }}">
<style>
  :root{
    --blue-900:#0B3D78; --blue-700:#0B4F9E; --blue-500:#2E7DD1;
    --blue-100:#EAF3FC; --blue-50:#F5F9FE; --white:#FFFFFF;
    --ink:#132038; --muted:#5B6B84; --border:#DCE7F5;
    --green:#17A673; --green-bg:#E7F7F1;
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
  .topbar{ display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; gap:20px; }
  .topbar h1{ font-family:'Plus Jakarta Sans',sans-serif; font-size:21px; font-weight:700; margin:0 0 3px; }
  .topbar p{ font-size:13px; color:var(--muted); margin:0; }

  .search-box{
    display:flex; align-items:center; gap:8px; background:var(--white);
    border:1px solid var(--border); border-radius:10px; padding:9px 14px;
    margin-bottom:18px; max-width:360px; box-shadow:var(--shadow);
  }
  .search-box input{ border:none; outline:none; font-size:13px; flex:1; font-family:'Inter',sans-serif; }
  .search-box svg{ width:16px; height:16px; color:var(--muted); flex-shrink:0; }

  .table-panel{ background:var(--white); border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow); overflow:hidden; }
  .table-scroll{ overflow-x:auto; }
  table{ width:100%; min-width:920px; border-collapse:collapse; }
  thead th{ text-align:center; font-size:10.5px; text-transform:uppercase; letter-spacing:.06em; color:var(--muted); font-weight:600; padding:11px 22px; border-bottom:1px solid var(--border); background:var(--blue-50); white-space:nowrap; }
  tbody td{ padding:13px 22px; font-size:13px; border-bottom:1px solid var(--border); vertical-align:middle; text-align:center; }
  thead th:nth-child(8), tbody td:nth-child(8){ min-width:120px; }
  thead th:nth-child(9), tbody td:nth-child(9){ min-width:150px; }
  tbody tr:last-child td{ border-bottom:none; }
  tbody tr:hover{ background:var(--blue-50); }
  .name-cell{ display:flex; align-items:center; justify-content:flex-start; gap:10px; text-align:left; }
  .mini-avatar{ width:28px; height:28px; border-radius:50%; background:var(--blue-100); color:var(--blue-700); font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
  .name-details{ flex:1; min-width:0; }
  .name-main{ font-weight:600; font-size:13px; line-height:1.35; overflow-wrap:anywhere; }
  .name-sub{ margin-top:3px; font-size:11px; line-height:1.3; color:var(--muted); overflow-wrap:anywhere; }
  .addr-cell{ max-width:190px; margin:0 auto; }
  .addr-main{ font-weight:600; font-size:12.5px; }
  .addr-sub{ font-size:11px; color:var(--muted); margin-top:2px; line-height:1.4; }
  .email-cell{ font-size:12.5px; color:var(--blue-700); }
  .badge{ display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:600; padding:4px 10px; border-radius:999px; white-space:nowrap; }
  .badge.done{ color:var(--green); background:var(--green-bg); }
  .mono{ font-family:'IBM Plex Mono',monospace; font-size:11.5px; color:var(--muted); }
  .dl-link{ font-size:11.5px; color:var(--blue-700); text-decoration:none; font-weight:600; }
  .dl-link:hover{ text-decoration:underline; }
  .action-group{ display:flex; align-items:center; justify-content:center; gap:8px; white-space:nowrap; }
  .sep{ color:var(--border); font-size:11px; }

  .btn-add{
  display:inline-flex; align-items:center; justify-content:center;
  width:28px; height:28px; border-radius:8px;
  background:var(--blue-700); color:#fff;
  font-size:16px; font-weight:700; text-decoration:none;
  transition:background .15s ease;
}
.btn-add:hover{ background:var(--blue-900); }
.btn-edit{
  display:inline-flex; align-items:center; justify-content:center;
  width:28px; height:28px; border-radius:8px;
  background:var(--green); color:#fff;
  text-decoration:none;
  transition:background .15s ease;
}
.btn-edit:hover{ background:#128c60; }
.btn-edit svg{ width:14px; height:14px; }

  .pagination-wrap{ padding:16px 22px; display:flex; justify-content:center; }
  .pagination-wrap nav{ width:100%; }
  .pagination-list{ display:flex; flex-wrap:wrap; justify-content:center; gap:6px; list-style:none; padding:0; margin:0; }
  .pagination-link{ display:flex; align-items:center; justify-content:center; min-width:36px; height:36px; padding:0 10px; border:1px solid var(--border); border-radius:8px; background:#fff; color:var(--ink); font-size:13px; line-height:1; text-decoration:none; }
  a.pagination-link:hover{ background:var(--blue-50); color:var(--blue-700); }
  .pagination-link.is-active{ background:var(--blue-700); border-color:var(--blue-700); color:#fff; }
  .pagination-link.is-disabled{ color:var(--muted); background:var(--blue-50); }

  @media (max-width: 760px){
    .main{ padding:16px 12px 32px; }
    .topbar h1{ font-size:18px; }
    .search-box{ width:100%; max-width:none; }
    .table-scroll{ width:100%; max-width:100%; overflow-x:auto; }
    .pagination-wrap{ padding:12px 8px; overflow-x:auto; }
    .pagination-wrap nav ul{ flex-wrap:wrap; justify-content:center; }
  }
</style>
</head>
<body>
@include('admin.layouts.navbar')
<div class="layout">

  <main class="main">
    <div class="topbar">
      <div>
        <h1>Pengisi Pakta Integritas</h1>
        <p>Seluruh data pengguna yang telah mengisi Pakta Integritas</p>
      </div>
    </div>

    <form method="GET" class="search-box">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, instansi, atau no. referensi...">
    </form>

    <div class="table-panel">
      <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th>Nama Lengkap / Jabatan</th>
            <th>Instansi / Alamat</th>
            <th>Email</th>
            <th>Kepentingan dengan BPMSPH</th>
            <th>Waktu Pengisian</th>
            <th>No. Referensi</th>
            <th>Status</th>
            <th>PDF</th>
            <th>Penilaian</th>
          </tr>
        </thead>
        <tbody id="pakta-tbody">
          @include('admin.pengisi-pakta.rows', ['paktas' => $paktas])
        </tbody>
      </table>
      </div>

      <div class="pagination-wrap" id="pakta-pagination">
        {{ $paktas->links('admin.pengisi-pakta.pagination') }}
      </div>
    </div>

  </main>
</div>  <script>
    (function () {
      const searchInput = document.querySelector('.search-box input[name="search"]');
      const tbody = document.getElementById('pakta-tbody');
      const paginationWrap = document.getElementById('pakta-pagination');
      const baseUrl = "{{ route('admin.pengisi-pakta') }}";
      let debounceTimer = null;

      function fetchResults(url) {
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
          .then(function (res) { return res.json(); })
          .then(function (data) {
            tbody.innerHTML = data.rows;
            paginationWrap.innerHTML = data.pagination;
          })
          .catch(function () {
            // Kalau AJAX gagal, biarkan form fallback jalan normal (reload biasa)
          });
      }

      if (searchInput) {
        searchInput.addEventListener('input', function () {
          clearTimeout(debounceTimer);
          const value = searchInput.value;
          debounceTimer = setTimeout(function () {
            const url = baseUrl + '?search=' + encodeURIComponent(value);
            fetchResults(url);
          }, 350); // jeda 350ms biar tidak spam request tiap ketikan
        });
      }

      // Klik link pagination juga lewat AJAX, tidak reload halaman
      if (paginationWrap) {
        paginationWrap.addEventListener('click', function (e) {
          const link = e.target.closest('a');
          if (!link) return;
          e.preventDefault();
          fetchResults(link.href);
        });
      }
    })();
  </script>
</body>
</html>
