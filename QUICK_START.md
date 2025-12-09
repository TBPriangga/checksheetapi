# 🚀 Quick Start - CheckSheet API Authentication

## ⚡ 5 Menit Setup

### 1. Pull Branch
```bash
git fetch
git checkout feature/authentication-login
```

### 2. Setup Environment
```bash
composer install
cp .env.example .env
php artisan key:generate

# Configure .env
DB_DATABASE=checksheet_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Setup Database
```bash
# Create database
mysql -u root -e "CREATE DATABASE checksheet_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations
php artisan migrate
```

### 4. Clear Cache & Start
```bash
php artisan cache:clear && php artisan route:clear && composer dump-autoload
php artisan serve
```

### 5. Create Test User
```bash
php artisan tinker
>>> App\Models\User::create([
  'name' => 'Test User',
  'email' => 'test@example.com',
  'password' => 'Password123!',
  'role' => 'user',
  'is_active' => true,
])
>>> exit
```

### 6. Test Login
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "Password123!"
  }'
```

---

## ❌ Jika Dapat 404 Error

**IMPORTANT**: Clear cache ini WAJIB:

```bash
php artisan cache:clear && \
php artisan config:clear && \
php artisan route:clear && \
php artisan view:clear && \
composer dump-autoload
```

Lalu verify route:
```bash
php artisan route:list | grep auth
```

Harus keluar 5 route auth. Jika tidak, baca **docs/TROUBLESHOOTING.md**

---

## 📚 Complete Documentation

| File | Purpose |
|------|----------|
| [AUTHENTICATION_README.md](AUTHENTICATION_README.md) | Overview & features |
| [docs/API_AUTHENTICATION.md](docs/API_AUTHENTICATION.md) | API endpoints documentation |
| [docs/SETUP_INSTRUCTIONS.md](docs/SETUP_INSTRUCTIONS.md) | Detailed setup guide |
| [docs/TROUBLESHOOTING.md](docs/TROUBLESHOOTING.md) | 🔧 Fix 404 error |
| [IMPLEMENTATION_CHECKLIST.md](IMPLEMENTATION_CHECKLIST.md) | Complete checklist |
| [docs/CheckSheet_API.postman_collection.json](docs/CheckSheet_API.postman_collection.json) | Postman collection |

---

## 🔐 API Endpoints

```bash
# Register
POST /api/v1/auth/register
{"name", "email", "phone", "password", "password_confirmation"}

# Login
POST /api/v1/auth/login
{"email", "password"}

# Get User (require token)
GET /api/v1/auth/me
Header: Authorization: Bearer {token}

# Refresh Token (require token)
POST /api/v1/auth/refresh-token
Header: Authorization: Bearer {token}

# Logout (require token)
POST /api/v1/auth/logout
Header: Authorization: Bearer {token}
```

---

## ✅ Success Response Format

```json
{
  "success": true,
  "message": "Login berhasil.",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "081234567890",
      "role": "user",
      "is_active": true,
      "profile_image": null,
      "bio": null,
      "created_at": "2024-12-09T10:00:00.000000Z",
      "updated_at": "2024-12-09T10:00:00.000000Z"
    },
    "token": "1|jVHGEFexample...",
    "token_type": "Bearer",
    "expires_in": 86400
  }
}
```

---

## 🛠️ Common Commands

```bash
# List all routes
php artisan route:list

# Filter auth routes
php artisan route:list | grep auth

# Check specific route
php artisan route:list --name=api.auth.login

# Clear all cache
php artisan cache:clear && php artisan config:clear

# Generate new key
php artisan key:generate

# Reset database
php artisan migrate:refresh

# Open tinker console
php artisan tinker
```

---

## 📦 What's Included

✅ 5 Authentication Controllers  
✅ 2 Form Request Validators  
✅ User Model with auth methods  
✅ UserResource for JSON  
✅ Database migration  
✅ API routes (v1)  
✅ Complete documentation  
✅ Postman collection  
✅ Security best practices  
✅ Error handling & logging  

---

## 🔒 Security Features

✅ Password hashing (bcrypt)  
✅ Email validation  
✅ Phone number validation (Indonesia)  
✅ Strong password requirement  
✅ Token expiration (24 hours)  
✅ Account deactivation support  
✅ Soft delete capability  
✅ Login tracking  
✅ CORS-ready  
✅ Input validation  

---

## 🚀 Next Phase

Plan untuk Phase 2:
- Email verification
- Password reset
- Profile management
- Two-factor authentication
- Role-based access control

---

## 📞 Need Help?

1. **404 Error?** → Read [docs/TROUBLESHOOTING.md](docs/TROUBLESHOOTING.md)
2. **API Documentation?** → Read [docs/API_AUTHENTICATION.md](docs/API_AUTHENTICATION.md)
3. **Setup Issues?** → Read [docs/SETUP_INSTRUCTIONS.md](docs/SETUP_INSTRUCTIONS.md)
4. **Testing?** → Import [CheckSheet_API.postman_collection.json](docs/CheckSheet_API.postman_collection.json)

---

**Framework**: Laravel 8.83.29  
**API Version**: v1  
**Status**: Production Ready ✅  
**Last Updated**: December 9, 2025
