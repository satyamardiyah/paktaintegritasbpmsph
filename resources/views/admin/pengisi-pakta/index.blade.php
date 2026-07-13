<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengisi Pakta — Dashboard Admin BPMSPH</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
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
  thead th{ text-align:left; font-size:10.5px; text-transform:uppercase; letter-spacing:.06em; color:var(--muted); font-weight:600; padding:11px 22px; border-bottom:1px solid var(--border); background:var(--blue-50); white-space:nowrap; }
  tbody td{ padding:13px 22px; font-size:13px; border-bottom:1px solid var(--border); vertical-align:top; }
  tbody tr:last-child td{ border-bottom:none; }
  tbody tr:hover{ background:var(--blue-50); }
  .name-cell{ display:flex; align-items:center; gap:10px; }
  .mini-avatar{ width:28px; height:28px; border-radius:50%; background:var(--blue-100); color:var(--blue-700); font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
  .name-main{ font-weight:600; font-size:13px; }
  .name-sub{ font-size:11px; color:var(--muted); }
  .addr-cell{ max-width:190px; }
  .addr-main{ font-weight:600; font-size:12.5px; }
  .addr-sub{ font-size:11px; color:var(--muted); margin-top:2px; line-height:1.4; }
  .email-cell{ font-size:12.5px; color:var(--blue-700); }
  .badge{ display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:600; padding:4px 10px; border-radius:999px; white-space:nowrap; }
  .badge.done{ color:var(--green); background:var(--green-bg); }
  .mono{ font-family:'IBM Plex Mono',monospace; font-size:11.5px; color:var(--muted); }
  .dl-link{ font-size:11.5px; color:var(--blue-700); text-decoration:none; font-weight:600; }
  .dl-link:hover{ text-decoration:underline; }

  .pagination-wrap{ padding:16px 22px; display:flex; justify-content:center; }
  .pagination-wrap nav ul{ display:flex; gap:4px; list-style:none; padding:0; margin:0; }
  .pagination-wrap a, .pagination-wrap span{ padding:6px 11px; border-radius:8px; font-size:12.5px; text-decoration:none; color:var(--ink); border:1px solid var(--border); }
  .pagination-wrap .active span{ background:var(--blue-700); color:#fff; border-color:var(--blue-700); }

  @media (max-width: 760px){ .sidebar{ display:none; } .main{ padding:20px; } }
</style>
</head>
<body>
<div class="layout">

  <aside class="sidebar">
    <div class="brand">
      <div class="logo-box">
        <img src="{{ asset('img/logo-bpmsph.jpeg') }}" alt="Logo BPMSPH">
      </div>
      <div class="brand-text">
        <div class="name">BPMSPH</div>
        <div class="sub">Pakta Integritas</div>
      </div>
    </div>

    <div class="nav-label">Menu Utama</div>
    <nav class="nav">
      <a href="{{ route('admin.dashboard') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
        Dashboard
      </a>
      <a href="{{ route('admin.pengisi-pakta') }}" class="active">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="m9 15 2 2 4-4"/></svg>
        Pengisi Pakta
      </a>
            <div class="nav-label">Sistem</div>
      <a href="{{ route('admin.logout.confirm') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Keluar
      </a>
    </nav>

    <div class="sidebar-foot">
      Balai Pengujian Mutu dan Sertifikasi Produk Hewan — Sistem Pakta Integritas Digital.
    </div>
  </aside>

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
          </tr>
        </thead>
        <tbody>
          @forelse($paktas as $pakta)
            @php
              $initials = collect(explode(' ', $pakta->nama))->map(fn($w) => $w[0] ?? '')->take(2)->implode('');
            @endphp
            <tr>
              <td>
                <div class="name-cell">
                  <div class="mini-avatar">{{ strtoupper($initials) }}</div>
                  <div>
                    <div class="name-main">{{ $pakta->nama }}</div>
                    <div class="name-sub">{{ $pakta->jabatan }}</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="addr-cell">
                  <div class="addr-main">{{ $pakta->instansi }}</div>
                  <div class="addr-sub">{{ $pakta->alamat }}</div>
                </div>
              </td>
              <td class="email-cell">{{ $pakta->email }}</td>
              <td><span class="badge" style="color:#0B4F9E; background:#EAF3FC">{{ $pakta->kepentingan }}</span></td>
              <td>{{ $pakta->created_at->translatedFormat('d M Y H:i') }}</td>
              <td class="mono">{{ $pakta->ref_number }}</td>
              <td><span class="badge done">✓ Terverifikasi</span></td>
              <td>
                @if($pakta->pdf_path)
                  <a class="dl-link" href="{{ route('admin.pakta.download', $pakta->id) }}">Unduh</a>
                @else
                  —
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="8" style="text-align:center; color:var(--muted); padding:30px;">Belum ada data.</td></tr>
          @endforelse
        </tbody>
      </table>
      </div>

      <div class="pagination-wrap">
        {{ $paktas->links() }}
      </div>
    </div>

  </main>
</div>
</body>
</html>