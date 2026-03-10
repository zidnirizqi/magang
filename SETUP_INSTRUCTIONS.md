# Setup Instructions - API Login & Register

## Langkah-langkah Setup

### 1. Install Laravel Sanctum
Jalankan command berikut di terminal:
```bash
composer require laravel/sanctum
```

### 2. Publish Sanctum Configuration
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 3. Setup Database MySQL di PHPMyAdmin

#### Buat Database Baru:
1. Buka PHPMyAdmin di browser: `http://localhost/phpmyadmin`
2. Klik tab "Databases"
3. Buat database baru dengan nama: `laravel_db`
4. Collation: `utf8mb4_unicode_ci`

#### Update File .env:
File `.env` sudah diupdate dengan konfigurasi MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan:** Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan kredensial MySQL Anda.

### 4. Jalankan Migration
```bash
php artisan migrate
```

Ini akan membuat tabel:
- users
- password_reset_tokens
- sessions
- cache
- jobs
- personal_access_tokens (untuk Sanctum)

### 5. Clear Cache (Opsional)
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### 6. Jalankan Server
```bash
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

---

## Testing

### Test via Browser (dengan AJAX):

1. **Register:**
   - Buka: `http://localhost:8000/register`
   - Isi form dan submit
   - Akan redirect ke dashboard jika berhasil

2. **Login:**
   - Buka: `http://localhost:8000/login`
   - Isi form dan submit
   - Akan redirect ke dashboard jika berhasil

### Test via API (Postman/Insomnia):

Lihat file `API_DOCUMENTATION.md` untuk detail endpoint dan contoh request.

---

## Troubleshooting

### Error: SQLSTATE[HY000] [1045] Access denied
**Solusi:** Periksa username dan password MySQL di file `.env`

### Error: Base table or view not found
**Solusi:** Jalankan `php artisan migrate`

### Error: Class 'Laravel\Sanctum\HasApiTokens' not found
**Solusi:** Jalankan `composer require laravel/sanctum`

### CORS Error saat test API
**Solusi:** Tambahkan middleware di `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->api(prepend: [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    ]);
})
```

---

## Fitur yang Sudah Diimplementasi

✅ API Register dengan validasi
✅ API Login dengan authentication
✅ API Logout dengan token
✅ Integrasi AJAX di login.blade.php
✅ Integrasi AJAX di registration.blade.php
✅ Error handling dan validasi
✅ Loading spinner saat submit
✅ Token disimpan di localStorage
✅ Auto redirect ke dashboard setelah login/register
✅ Konfigurasi MySQL untuk PHPMyAdmin

---

## Struktur File yang Dibuat/Dimodifikasi

```
├── routes/
│   └── api.php (BARU)
├── app/
│   ├── Models/
│   │   └── User.php (DIUPDATE - tambah HasApiTokens)
│   └── Http/
│       └── Controllers/
│           └── Auth/
│               └── AuthController.php (DIUPDATE - tambah API methods)
├── resources/
│   └── views/
│       └── auth/
│           ├── login.blade.php (DIUPDATE - tambah AJAX)
│           └── registration.blade.php (DIUPDATE - tambah AJAX)
├── .env (DIUPDATE - MySQL config)
├── API_DOCUMENTATION.md (BARU)
└── SETUP_INSTRUCTIONS.md (BARU)
```
