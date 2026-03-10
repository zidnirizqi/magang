# Quick Start - API Login & Register

## Setup Cepat

### 1. Install Sanctum
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 2. Setup Database di PHPMyAdmin
- Buka: `http://localhost/phpmyadmin`
- Buat database: `laravel_db`
- Update `.env` (sudah dikonfigurasi):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Jalankan Migration
```bash
php artisan migrate
```

### 4. Start Server
```bash
php artisan serve
```

## Test API

### Via Browser (AJAX):
- Register: `http://localhost:8000/register`
- Login: `http://localhost:8000/login`

### Via Postman/cURL:
```bash
# Register
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@example.com","password":"password123","password_confirmation":"password123"}'

# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'
```

## Endpoints
- `POST /api/register` - Registrasi user baru
- `POST /api/login` - Login user
- `POST /api/logout` - Logout (butuh token)

## Dokumentasi Lengkap
- API Documentation: `API_DOCUMENTATION.md`
- Setup Instructions: `SETUP_INSTRUCTIONS.md`
- Test Script: `test-api.sh`
