<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/pakta.css') }}">

    <title>Pakta Integritas BPMSPH</title>
</head>
<body>

@include('layouts.sidebar')

    <div class="paper-container">
        <div class="paper" style="max-width:560px; min-width:320px; min-height:auto; padding:28px;">

            <div style="display:flex;align-items:center;gap:16px;margin-bottom:18px">
                <img src="{{ asset('img/logo-bpmsph.jpeg') }}" alt="logo" style="width:56px; height:56px; object-fit:contain; border-radius:10px; border:2px solid rgba(0,0,0,0.08); background:#fff; padding:4px;">
                <div>
                    <h4 style="margin:0">Login Admin</h4>
                    <small class="text-muted">Masuk untuk mengelola dashboard</small>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input id="adminPassword" type="password" name="password" class="form-control" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center gap-3">
                    <a href="/" class="btn btn-link p-0 text-decoration-none">Kembali</a>
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </form>

        </div>
    </div>

</main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('togglePassword');
    const pwd = document.getElementById('adminPassword');
    if (toggle && pwd) {
        toggle.addEventListener('click', function () {
            const icon = this.querySelector('i');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    }
});

</script>

        </div>
    </div>

</main>
</div>


</html>
