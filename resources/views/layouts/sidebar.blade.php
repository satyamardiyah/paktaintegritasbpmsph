<div class="wrapper">

<aside class="sidebar" id="sidebar">

        <div>

            <div class="brand">
                <div class="logo-box">
                    <img src="{{ asset('img/logo-bpmsph.jpeg') }}" alt="Logo BPMSPH">
                </div>
                <div class="brand-text">
                    <h3>BPMSPH</h3>
                    <small>Pakta Integritas</small>
                </div>
                <button id="hamburger" class="hamburger" type="button">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <div class="nav-label">Menu Utama</div>
            <nav class="nav">

                <a href="{{ route('dashboard') }}"
                   class="menu {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                    <i class="bi bi-speedometer2"></i>

                    <span>Dashboard</span>

                </a>

                <a href="{{ route('pakta') }}"
                   class="menu {{ request()->routeIs('pakta') ? 'active' : '' }}">

                    <i class="bi bi-file-earmark-text"></i>

                    <span>Pakta Integritas</span>

                </a>

            </nav>

        </div>

        <div class="bottom">

            <a href="{{ route('admin.login') }}" class="menu">

                <i class="bi bi-box-arrow-in-right"></i>

                <span>Login Admin</span>

            </a>

        </div>

    </aside>
        <main class="content">

<script>
document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const sidebar = document.getElementById("sidebar");
    const content = document.querySelector(".content");

    if (!hamburger || !sidebar) {
        return;
    }

    hamburger.addEventListener("click", function () {
        sidebar.classList.toggle("close");
        if (content) {
            content.classList.toggle("full");
        }
    });
});
</script>