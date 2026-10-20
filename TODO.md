# Database — PaktaIntegritas

Dokumentasi seluruh tabel & kolom database berdasarkan file migration.

## Database System Tables

### 1. `users` — Data user/login (Auth)
- [x] `id` — bigint (PK, auto increment)
- [x] `name` — string(255)
- [x] `email` — string(255) — unique
- [x] `password` — string(255)
- [x] `created_at` — timestamp — nullable
- [x] `updated_at` — timestamp — nullable

### 2. `password_reset_tokens` — Token reset password
- [x] `email` — string(255) — PK
- [x] `token` — string(255)
- [x] `created_at` — timestamp — nullable

### 3. `sessions` — Sesi login user
- [x] `id` — string(255) — PK
- [x] `user_id` — bigint (FK → users.id) — nullable, indexed
- [x] `ip_address` — string(45) — nullable
- [x] `payload` — longText
- [x] `last_activity` — integer — indexed

### 4. `cache` — Cache
- [x] `key` — string(255) — PK
- [x] `value` — mediumText
- [x] `expiration` — bigint — indexed

### 5. `cache_locks` — Kunci cache
- [x] `key` — string(255) — PK
- [x] `owner` — string(255)
- [x] `expiration` — bigint — indexed

### 6. `jobs` — Antrian pekerjaan
- [x] `id` — bigint (PK, auto increment)
- [x] `queue` — string(255) — indexed
- [x] `payload` — longText
- [x] `attempts` — unsignedSmallInteger
- [x] `reserved_at` — unsignedInteger — nullable
- [x] `available_at` — unsignedInteger
- [x] `created_at` — unsignedInteger

### 7. `job_batches` — Batch antrian
- [x] `id` — string(255) — PK
- [x] `name` — string(255)
- [x] `total_jobs` — integer
- [x] `pending_jobs` — integer
- [x] `failed_jobs` — integer
- [x] `failed_job_ids` — longText
- [x] `options` — mediumText — nullable
- [x] `cancelled_at` — integer — nullable
- [x] `created_at` — integer
- [x] `finished_at` — integer — nullable

### 8. `failed_jobs` — Antrian gagal
- [x] `id` — bigint (PK, auto increment)
- [x] `uuid` — string(255) — unique
- [x] `connection` — string(255)
- [x] `queue` — string(255)
- [x] `payload` — longText
- [x] `exception` — longText
- [x] `failed_at` — timestamp — default CURRENT_TIMESTAMP

## Business Tables

### 9. `paktas` — Data Pakta Integritas
- [x] `id` — bigint (PK, auto increment)
- [x] `ref_number` — string(255) — unique
- [x] `nama` — string(255)
- [x] `jabatan` — string(255)
- [x] `instansi` — string(255)
- [x] `email` — string(255)
- [x] `kepentingan` — string(255)
- [x] `alamat` — text
- [x] `signature` — longText
- [x] `pdf_path` — string(255) — nullable
- [x] `created_at` — timestamp — nullable
- [x] `updated_at` — timestamp — nullable

### 10. `pengunjungs` — Data pengunjung website
- [x] `id` — bigint (PK, auto increment)
- [x] `ip_address` — string(255) — nullable
- [x] `created_at` — timestamp — nullable
- [x] `updated_at` — timestamp — nullable

### 11. `penilaians` — Penilaian Pakta Integritas
- [x] `id` — bigint (PK, auto increment)
- [x] `pakta_id` — bigint (FK → paktas.id, ON DELETE CASCADE)
- [x] `kriteria` — json (array nama kriteria + skor)
- [x] `catatan` — text — nullable
- [x] `signature` — longText — nullable
- [x] `nama_penilai` — string(255) — nullable
- [x] `created_at` — timestamp — nullable
- [x] `updated_at` — timestamp — nullable

---

## Relasi
- `penilaians.pakta_id` → `paktas.id` (one-to-many, cascade delete)
- `sessions.user_id` → `users.id` (nullable)

---

## Kolom yang dihapus (migration `2026_09_12_000000_drop_unused_columns`)
- `users.email_verified_at` — tidak terpakai (tanpa verifikasi email)
- `users.remember_token` — tidak terpakai (login tanpa remember)
- `paktas.status` — tidak terpakai (selalu `'done'`, tanpa alur ubah status)