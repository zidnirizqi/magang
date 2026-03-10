# Checklist Setup API Login & Register

## ✅ File yang Sudah Dibuat/Dimodifikasi

### Routes
- [x] `routes/api.php` - API routes untuk register, login, logout

### Controllers
- [x] `app/Http/Controllers/Auth/AuthController.php` - Tambah method:
  - `apiRegister()` - Handle API register
  - `apiLogin()` - Handle API login
  - `apiLogout()` - Handle API logout

### Models
- [x] `app/Models/User.php` - Tambah `HasApiTokens` trait

### Views
- [x] `resources/views/auth/login.blade.php` - Integrasi AJAX
- [x] `resources/views/auth/registration.blade.php` - Integrasi AJAX

### Config
- [x] `.env` - Update ke MySQL configuration
- [x] `bootstrap/app.php` - Tambah API routes & Sanctum middleware
- [x] `config/cors.php` - CORS configuration

### Documentation
- [x] `API_DOCUMENTATION.md` - Dokumentasi lengkap API
- [x] `SETUP_INSTRUCTIONS.md` - Instruksi setup detail
- [x] `README_API.md` - Quick start guide
- [x] `POSTMAN_COLLECTION.json` - Postman collection
- [x] `test-api.sh` - Script testing cURL
- [x] `CHECKLIST.md` - File ini

---

## ✅ Setup Completed Successfully!

### Database & Migration
- [x] ✅ MySQL database `laravel_db` created
- [x] ✅ Laravel Sanctum installed
- [x] ✅ All migrations completed successfully:
  - users table
  - cache table  
  - jobs table
  - categories table (reordered)
  - products table
  - personal_access_tokens table (Sanctum)

### API Testing Results
- [x] ✅ POST /api/register - Status 201 ✓
- [x] ✅ POST /api/login - Status 200 ✓  
- [x] ✅ POST /api/logout - Status 200 ✓
- [x] ✅ Token generation working ✓
- [x] ✅ Authentication working ✓

---

## 📋 Langkah Setup (Urutan)

### 1. Install Dependencies
```bash
[x] ✅ composer require laravel/sanctum
[x] ✅ php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 2. Database Setup
```bash
[x] ✅ Buka PHPMyAdmin: http://localhost/phpmyadmin
[x] ✅ Buat database: laravel_db
[x] ✅ Update .env dengan kredensial MySQL yang benar
```

### 3. Migration
```bash
[x] ✅ php artisan migrate (fixed foreign key constraint issue)
```

### 4. Clear Cache (Optional)
```bash
[ ] php artisan config:clear
[ ] php artisan cache:clear
[ ] php artisan route:clear
```

### 5. Start Server
```bash
[x] ✅ php artisan serve
```

---

## 🧪 Testing

### Browser Testing
```bash
[ ] Buka http://localhost:8000/register
[ ] Test form register dengan AJAX
[ ] Buka http://localhost:8000/login
[ ] Test form login dengan AJAX
[ ] Cek redirect ke dashboard setelah login
```

### API Testing (Postman/Insomnia)
```bash
[ ] Import POSTMAN_COLLECTION.json
[ ] Test POST /api/register
[ ] Test POST /api/login
[ ] Simpan token dari response
[ ] Test POST /api/logout dengan token
```

### cURL Testing
```bash
[ ] chmod +x test-api.sh
[ ] ./test-api.sh
```

---

## 🔍 Verifikasi

### Database
```bash
[ ] Cek tabel users di PHPMyAdmin
[ ] Cek tabel personal_access_tokens (untuk Sanctum)
[ ] Cek data user setelah register
```

### API Response
```bash
[ ] Register return status 201 dengan token
[ ] Login return status 200 dengan token
[ ] Logout return status 200
[ ] Validation error return status 422
[ ] Invalid credentials return status 401
```

### Frontend
```bash
[ ] Form validation bekerja
[ ] Error message tampil dengan benar
[ ] Loading spinner muncul saat submit
[ ] Token tersimpan di localStorage
[ ] Redirect ke dashboard setelah sukses
```

---

## 🚨 Troubleshooting

### Error: Class 'Laravel\Sanctum\HasApiTokens' not found
```bash
Solusi: composer require laravel/sanctum
```

### Error: SQLSTATE[HY000] [1045] Access denied
```bash
Solusi: Periksa DB_USERNAME dan DB_PASSWORD di .env
```

### Error: Base table or view not found
```bash
Solusi: php artisan migrate
```

### CORS Error
```bash
Solusi: Sudah dikonfigurasi di config/cors.php dan bootstrap/app.php
```

### Token tidak tersimpan
```bash
Solusi: Cek console browser untuk error JavaScript
```

---

## 📝 Catatan Penting

1. **Sanctum** digunakan untuk API authentication
2. **Token** disimpan di localStorage browser
3. **MySQL** digunakan sebagai database (bukan SQLite)
4. **AJAX** digunakan untuk komunikasi frontend-backend
5. **CORS** sudah dikonfigurasi untuk development
6. **Validation** dilakukan di backend dan frontend
7. **Error handling** sudah diimplementasi

---

## 🎯 Fitur yang Sudah Diimplementasi

✅ API Register dengan validasi lengkap
✅ API Login dengan authentication
✅ API Logout dengan token revocation
✅ AJAX integration di login form
✅ AJAX integration di register form
✅ Real-time error display
✅ Loading state saat submit
✅ Token management di localStorage
✅ Auto redirect setelah login/register
✅ MySQL database configuration
✅ CORS configuration
✅ Sanctum middleware
✅ Comprehensive documentation
✅ Testing tools (Postman, cURL)

---

## 📚 File Dokumentasi

- `API_DOCUMENTATION.md` - Detail endpoint, request, response
- `SETUP_INSTRUCTIONS.md` - Panduan setup lengkap
- `README_API.md` - Quick start guide
- `POSTMAN_COLLECTION.json` - Import ke Postman
- `test-api.sh` - Script testing cURL
- `CHECKLIST.md` - Checklist ini
