<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logout — Dashboard Admin BPMSPH</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --blue-900:#0B3D78;
    --blue-700:#0B4F9E;
    --blue-100:#EAF3FC;
    --blue-50:#F5F9FE;
    --ink:#132038;
    --muted:#5B6B84;
    --border:#DCE7F5;
    --red:#D1477A;
    --red-bg:#FBEAF1;
  }
  *{box-sizing:border-box;}
  body{
    margin:0;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Inter',sans-serif;
    background:var(--blue-50);
    color:var(--ink);
  }
  .card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:36px 34px 30px;
    max-width:380px;
    width:100%;
    text-align:center;
    box-shadow:0 8px 24px -12px rgba(11,63,120,0.18);
  }
  .icon{
    width:56px; height:56px; border-radius:50%;
    background:var(--red-bg); color:var(--red);
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 18px;
  }
  .icon svg{ width:26px; height:26px; }
  h1{
    font-family:'Plus Jakarta Sans',sans-serif;
    font-size:19px; font-weight:700; margin:0 0 8px;
  }
  p{ font-size:13.5px; color:var(--muted); margin:0 0 26px; line-height:1.5; }
  .actions{ display:flex; gap:10px; }
  .btn{
    flex:1;
    padding:11px 0;
    border-radius:10px;
    font-size:13.5px;
    font-weight:600;
    cursor:pointer;
    border:1px solid var(--border);
    text-decoration:none;
    display:inline-block;
  }
  .btn-cancel{ background:#fff; color:var(--ink); }
  .btn-cancel:hover{ background:var(--blue-100); }
  .btn-confirm{ background:var(--red); color:#fff; border-color:var(--red); }
  .btn-confirm:hover{ background:#b83a68; }
</style>
</head>
<body>

<div class="card">
  <div class="icon">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
      <polyline points="16 17 21 12 16 7"/>
      <line x1="21" y1="12" x2="9" y2="12"/>
    </svg>
  </div>
  <h1>Yakin ingin keluar?</h1>
  <p>Anda akan keluar dari Dashboard Admin BPMSPH. Sesi Anda akan diakhiri dan perlu login kembali untuk mengakses dashboard.</p>

  <div class="actions">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel">Batal</a>
    <form action="{{ route('admin.logout') }}" method="POST" style="flex:1; margin:0;">
      @csrf
      <button type="submit" class="btn btn-confirm" style="width:100%;">Ya, Keluar</button>
    </form>
  </div>
</div>

</body>
</html>