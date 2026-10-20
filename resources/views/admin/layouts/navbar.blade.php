<header class="admin-navbar">
  <div class="admin-navbar__inner">
    <a class="admin-navbar__brand" href="{{ route('admin.dashboard') }}">
      <span class="admin-navbar__logo">
        <img src="{{ asset('img/logo-bpmsph.jpeg') }}" alt="Logo BPMSPH">
      </span>
      <span class="admin-navbar__brand-text">
        <strong>BPMSPH</strong>
        <small>Pakta Integritas</small>
      </span>
    </a>

    <button class="admin-navbar__toggle" type="button" aria-label="Buka menu" aria-controls="admin-navigation" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <nav class="admin-navbar__navigation" id="admin-navigation">
      <a href="{{ route('admin.dashboard') }}" @class(['is-active' => request()->routeIs('admin.dashboard*')])>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('admin.pengisi-pakta') }}" @class(['is-active' => request()->routeIs('admin.pengisi-pakta', 'admin.pakta.penilaian', 'admin.pakta.penilaian.store')])>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="m9 15 2 2 4-4"/></svg>
        <span>Pengisi Pakta</span>
      </a>
      <a href="{{ route('admin.logout.confirm') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        <span>Keluar</span>
      </a>
    </nav>
  </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.querySelector(".admin-navbar__toggle");
  const navbar = document.querySelector(".admin-navbar");

  if (!toggle || !navbar) {
    return;
  }

  toggle.addEventListener("click", function () {
    const isOpen = navbar.classList.toggle("is-open");
    toggle.setAttribute("aria-expanded", String(isOpen));
    toggle.setAttribute("aria-label", isOpen ? "Tutup menu" : "Buka menu");
  });
});
</script>
