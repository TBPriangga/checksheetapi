# CheckSheet API - Setup Instructions

## Prerequisites

- PHP 7.4 atau lebih tinggi
- Composer
- MySQL/MariaDB
- Git

---

## Installation Steps

### 1. Clone Repository

```bash
git clone https://github.com/TBPriangga/checksheetapi.git
cd checksheetapi
```

### 2. Switch to Feature Branch

```bash
git checkout feature/authentication-login
```

### 3. Install Dependencies

```bash
composer install
```

### 4. Copy Environment File

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Configure Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=checksheet_db
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Create Database

```bash
mysql -u root -p -e "CREATE DATABASE checksheet_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Atau gunakan phpMyAdmin untuk membuat database.

### 8. Run Migrations

```bash
php artisan migrate
```

### 9. Publish Sanctum Configuration (if not already published)

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 10. Update API Routes (Sudah dilakukan dalam commit)

File `routes/api.php` sudah diupdate dengan authentication routes.

### 11. Start Development Server

```bash
php artisan serve
```

API akan tersedia di `http://localhost:8000`

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── Auth/
│   │           ├── LoginController.php
│   │           ├── RegisterController.php
│   │           ├── LogoutController.php
│   │           ├── MeController.php
│   │           └── RefreshTokenController.php
│   ├── Requests/
│   │   └── Auth/
│   │       ├── LoginRequest.php
│   │       └── RegisterRequest.php
│   └── Resources/
│       └── UserResource.php
├── Models/
│   └── User.php
└── ...

database/
├── migrations/
│   └── 2024_12_09_130000_create_users_table.php
└── ...

routes/
└── api.php

docs/
├── API_AUTHENTICATION.md
├── SETUP_INSTRUCTIONS.md
└── CheckSheet_API.postman_collection.json
```

---

## Testing

### 1. Test Login

Sebelum test login, buat user di database:

```bash
php artisan tinker

>>> App\Models\User::create([
  'name' => 'Test User',
  'email' => 'test@example.com',
  'password' => 'Password123',
  'role' => 'user',
  'is_active' => true,
])

>>> exit
```

Atau gunakan endpoint `/api/v1/auth/register` untuk mendaftar user baru.

### 2. Test Endpoints

Gunakan Postman, Insomnia, atau cURL untuk testing:

```bash
# Register
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "phone": "081234567890",
    "password": "Password123!",
    "password_confirmation": "Password123!"
  }'

# Login
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "Password123!"
  }'

# Get User Profile (replace TOKEN dengan token dari login)
curl -X GET http://localhost:8000/api/v1/auth/me \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json"

# Logout
curl -X POST http://localhost:8000/api/v1/auth/logout \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json"
```

### 3. Test dengan Postman

1. Import file `CheckSheet_API.postman_collection.json` ke Postman
2. Set base URL ke `http://localhost:8000/api/v1`
3. Jalankan request-request sesuai urutan

---

## Troubleshooting

### 1. CORS Error

Jika mendapat CORS error, update `config/cors.php`:

```php
'allowed_origins' => ['*'], // Untuk development
// Atau spesifik origin untuk production
'allowed_origins' => ['https://yourdomain.com'],
```

### 2. Database Connection Error

Pastikan konfigurasi `.env` sudah benar dan MySQL/MariaDB sudah running.

### 3. Migration Error

Jika migration gagal, cek error log:

```bash
php artisan migrate --seed
```

### 4. Token Not Working

Pastikan:
- Token disertakan di header `Authorization: Bearer {token}`
- Token belum expired (24 jam)
- User masih active di database

### 5. Clear Cache

Jika ada issue dengan cache:

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## Production Deployment

### 1. Environment Variables

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-secure-password
SANCTUM_STATEFUL_DOMAINS=yourdomain.com,*.yourdomain.com
```

### 2. Optimize for Production

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Security Headers

Tambahkan di `.htaccess` atau web server configuration:

```
Strict-Transport-Security: max-age=31536000; includeSubDomains
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
X-XSS-Protection: 1; mode=block
```

### 4. Use HTTPS

Untuk production, selalu gunakan HTTPS. Konfigurasi SSL certificate dengan Let's Encrypt.

---

## Additional Commands

```bash
# Clear all cache
php artisan cache:clear && php artisan config:clear

# Create database tables
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Refresh migrations (reset database)
php artisan migrate:refresh

# Create new migration
php artisan make:migration create_table_name

# Create new controller
php artisan make:controller Api/Auth/ControllerName

# Create new model
php artisan make:model ModelName

# Create new request class
php artisan make:request Auth/RequestClassName

# Tinker - interactive shell
php artisan tinker
```

---

## Next Steps

1. Merge branch `feature/authentication-login` ke `main`
2. Test integration dengan Flutter aplikasi
3. Implementasi fitur tambahan (email verification, password reset, dll)
4. Setup CI/CD pipeline
5. Deploy ke production server

---

**Last Updated**: December 9, 2024
**Laravel Version**: 8.83.29
