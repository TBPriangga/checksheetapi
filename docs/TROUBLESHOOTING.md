# 🔧 TROUBLESHOOTING - API Login 404 Error

## ❌ Error: 404 Not Found

Ini terjadi ketika route `/api/v1/auth/login` tidak ditemukan oleh Laravel.

---

## ✅ Solusi Step-by-Step

### LANGKAH 1: Clear All Cache (WAJIB)

```bash
# Hapus cache route
php artisan route:clear

# Hapus cache config
php artisan config:clear

# Hapus cache view
php artisan view:clear

# Hapus cache aplikasi
php artisan cache:clear

# Restart composer autoload
composer dump-autoload

# OPTIONAL: Clear semua cache sekaligus
php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear && composer dump-autoload
```

---

### LANGKAH 2: Verify Routes Terdaftar

```bash
# List semua route yang terdaftar
php artisan route:list

# Filter hanya route auth
php artisan route:list | grep auth

# Output yang harus ada:
# POST api/v1/auth/login
# POST api/v1/auth/register
# POST api/v1/auth/logout
# GET api/v1/auth/me
# POST api/v1/auth/refresh-token
```

Jika tidak ada, lanjut ke LANGKAH 3.

---

### LANGKAH 3: Verifikasi routes/api.php

Pastikan file `routes/api.php` sudah diupdate dengan content ini:

**File: routes/api.php**

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Auth\RefreshTokenController;
use App\Http\Controllers\LoginAJIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Public Routes - Authentication
    Route::prefix('auth')->group(function () {
        Route::post('/login', [LoginController::class, 'login'])->name('api.auth.login');
        Route::post('/register', [RegisterController::class, 'register'])->name('api.auth.register');
    });

    // Protected Routes - Require Authentication
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [LogoutController::class, 'logout'])->name('api.auth.logout');
            Route::get('/me', [MeController::class, 'me'])->name('api.auth.me');
            Route::post('/refresh-token', [RefreshTokenController::class, 'refresh'])->name('api.auth.refresh');
        });

        Route::post('/updateDataAPI', [LoginAJIController::class, 'updateDataAPI'])->name('updateDataAPI');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
```

---

### LANGKAH 4: Verifikasi Controller Existence

Pastikan semua controller file ini ADA:

```
✓ app/Http/Controllers/Api/Auth/LoginController.php
✓ app/Http/Controllers/Api/Auth/RegisterController.php
✓ app/Http/Controllers/Api/Auth/LogoutController.php
✓ app/Http/Controllers/Api/Auth/MeController.php
✓ app/Http/Controllers/Api/Auth/RefreshTokenController.php
```

Jika tidak ada, buat dengan:

```bash
# Buat direktori jika belum ada
mkdir -p app/Http/Controllers/Api/Auth

# Atau buat dengan Artisan
php artisan make:controller Api/Auth/LoginController --api
php artisan make:controller Api/Auth/RegisterController --api
php artisan make:controller Api/Auth/LogoutController --api
php artisan make:controller Api/Auth/MeController --api
php artisan make:controller Api/Auth/RefreshTokenController --api
```

---

### LANGKAH 5: Verifikasi Controller Namespace

Pastikan namespace di setiap controller file BENAR:

```php
// BENAR ✓
namespace App\Http\Controllers\Api\Auth;

// SALAH ✗
namespace App\Http\Controllers\Auth;
namespace App\Controllers\Api\Auth;
namespace App\Api\Controllers\Auth;
```

---

### LANGKAH 6: Verifikasi Sanctum Middleware

Pastikan di `app/Http/Kernel.php` sudah ada:

```php
protected $routeMiddleware = [
    // ... middleware lainnya
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
    'signed' => \App\Http\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
];
```

Tidak perlu tambah middleware khusus, Laravel sudah support `auth:sanctum`.

---

### LANGKAH 7: Verifikasi HTTP Verb

Pastikan Anda menggunakan HTTP method yang BENAR:

```bash
# ✓ BENAR - POST
POST http://localhost:8000/api/v1/auth/login

# ✗ SALAH - GET
GET http://localhost:8000/api/v1/auth/login

# ✗ SALAH - URL tanpa /v1
POST http://localhost:8000/api/auth/login

# ✗ SALAH - URL tanpa /api
POST http://localhost:8000/v1/auth/login
```

---

### LANGKAH 8: Test dengan cURL

```bash
# Test dengan method yang benar
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "Password123"
  }'

# Jika return 404, coba check route list
php artisan route:list --path=api
```

---

## 🔍 Diagnosis Checklist

Jalankan checklist ini untuk menemukan masalah:

```bash
# 1. Clear cache
php artisan cache:clear && php artisan route:clear

# 2. Check route exist
php artisan route:list | grep "auth/login"

# 3. Check controller exist
ls -la app/Http/Controllers/Api/Auth/

# 4. Check file readable
cat app/Http/Controllers/Api/Auth/LoginController.php | head -20

# 5. Test route dengan artisan
php artisan tinker
>>> Route::has('api.auth.login')
# Should return: true

# 6. Get route detail
>>> Route::getRoutes()->getByName('api.auth.login')
```

---

## 📋 Complete Setup Checklist

- [ ] Branch feature/authentication-login sudah di-pulled/checkout
- [ ] `composer install` sudah dijalankan
- [ ] `.env` sudah dikonfigurasi dengan DB yang benar
- [ ] Database sudah dibuat: `php artisan migrate`
- [ ] `php artisan cache:clear && php artisan route:clear` sudah dijalankan
- [ ] Semua 5 controller file ada di `app/Http/Controllers/Api/Auth/`
- [ ] Namespace di controller BENAR (`App\Http\Controllers\Api\Auth`)
- [ ] `routes/api.php` sudah diupdate
- [ ] `php artisan route:list | grep auth` menunjukkan 5 route auth
- [ ] Server dijalankan dengan `php artisan serve`
- [ ] Test dengan Postman: `POST http://localhost:8000/api/v1/auth/login`

---

## 🚀 Quick Fix Command

Jalankan command ini untuk quick fix:

```bash
#!/bin/bash

echo "🔧 Fixing CheckSheet API Authentication..."

echo "1️⃣ Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "2️⃣ Dumping autoloader..."
composer dump-autoload

echo "3️⃣ Checking routes..."
php artisan route:list | grep auth

echo "4️⃣ Listing controllers..."
ls -la app/Http/Controllers/Api/Auth/

echo "✅ Done! Try testing the API now."
echo "📡 Test: POST http://localhost:8000/api/v1/auth/login"
```

Simpan sebagai `fix-auth.sh` dan jalankan:
```bash
chmod +x fix-auth.sh
./fix-auth.sh
```

---

## 🆘 Still Getting 404?

Jika masih 404 setelah semua step, ikuti ini:

### Opsi 1: Test Route Directly

```php
// Test di routes/api.php
Route::post('/test-login', function () {
    return response()->json(['message' => 'Route working!']);
});

// Restart dan test: POST http://localhost:8000/api/test-login
```

### Opsi 2: Check Web Server Logs

```bash
# Lihat error log Laravel
tail -f storage/logs/laravel.log

# Lihat error log web server (Apache/Nginx)
# Ubuntu: sudo tail -f /var/log/apache2/error.log
# Ubuntu: sudo tail -f /var/log/nginx/error.log
```

### Opsi 3: Verify Git Pull

Pastikan semua files sudah ter-pull dari branch:

```bash
# Check current branch
git branch

# Pull latest changes
git pull origin feature/authentication-login

# Check status
git status

# List files in branch
git ls-tree -r HEAD app/Http/Controllers/Api/Auth/
```

---

## 📞 Common Issues & Solutions

| Issue | Cause | Solution |
|-------|-------|----------|
| 404 Not Found | Route tidak terdaftar | Clear cache + verify routes/api.php |
| 405 Method Not Allowed | POST bukan GET | Gunakan POST bukan GET |
| 500 Server Error | Controller error | Check `storage/logs/laravel.log` |
| 422 Unprocessable | Validasi gagal | Check request body format |
| 401 Unauthorized | Token invalid | Use correct token format |
| Class not found | Namespace salah | Verify namespace di controller |
| File not found | Controller belum dibuat | Copy file dari branch atau buat manual |

---

## 💡 Pro Tips

1. **Selalu clear cache** setelah update routes atau controllers
2. **Gunakan Postman** untuk testing API dengan UI yang jelas
3. **Check logs** di `storage/logs/laravel.log` untuk debug error
4. **Gunakan Tinker** untuk test logic: `php artisan tinker`
5. **Test route manual** dengan simple return JSON untuk verify route registered
6. **Use `--no-cache` flag** ketika testing route changes: `php artisan serve --no-cache`
7. **Monitor logs in real-time**: `tail -f storage/logs/laravel.log`

---

## 📞 Still Need Help?

Jika sudah mencoba semua dan masih error, cek:

1. **Laravel version**: `php artisan --version` (harus 8.83.29)
2. **PHP version**: `php --version` (harus 7.4+)
3. **Database connection**: Test DB di `.env`
4. **Composer**: `composer update` jika perlu
5. **GitHub logs**: Check di branch untuk file yang missing

---

**Last Updated**: December 9, 2025
**Framework**: Laravel 8.83.29
**Troubleshooting for**: API Authentication 404 Error
