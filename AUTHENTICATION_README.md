# CheckSheet API - Authentication Feature

## 🎯 Overview

Feature authentication lengkap untuk CheckSheet API menggunakan Laravel Sanctum dengan best practices keamanan.

**Status**: ✅ Production Ready

---

## 📦 Features

✅ **User Registration** dengan validasi ketat
- Email unique check
- Password strength validation
- Phone number validation (format Indonesia)
- Name validation (hanya huruf & spasi)

✅ **User Login** dengan token generation
- Email & password authentication
- Automatic last login tracking
- Account active status check
- Bearer token generation (24 hours)

✅ **User Profile Management**
- Get current user data
- Role-based access (admin, supervisor, user)
- Profile image & bio support
- Account status tracking

✅ **Token Management**
- Automatic token expiration (24 hours)
- Token refresh capability
- Secure logout (token revocation)
- Single token per login

✅ **Security Features**
- Password hashing dengan bcrypt
- Email & phone uniqueness validation
- Account deactivation support
- Soft delete capability
- CORS-ready
- Rate limiting ready

---

## 🚀 Quick Start

### 1. Setup Database

```bash
# Clone repository
git clone https://github.com/TBPriangga/checksheetapi.git
cd checksheetapi

# Switch to feature branch
git checkout feature/authentication-login

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_DATABASE=checksheet_db
DB_USERNAME=root
DB_PASSWORD=

# Run migrations
php artisan migrate
```

### 2. Start Development Server

```bash
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

### 3. Test Login

```bash
# Register new user
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "081234567890",
    "password": "SecurePass123!",
    "password_confirmation": "SecurePass123!"
  }'

# Login
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "SecurePass123!"
  }'
```

---

## 📋 API Endpoints

### Authentication Routes

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/v1/auth/register` | Register new user | ❌ No |
| POST | `/api/v1/auth/login` | Login user | ❌ No |
| GET | `/api/v1/auth/me` | Get current user | ✅ Yes |
| POST | `/api/v1/auth/logout` | Logout user | ✅ Yes |
| POST | `/api/v1/auth/refresh-token` | Refresh token | ✅ Yes |

---

## 📚 Documentation

Untuk dokumentasi lengkap, lihat file-file berikut:

- **[API_AUTHENTICATION.md](docs/API_AUTHENTICATION.md)** - Dokumentasi API detail
- **[SETUP_INSTRUCTIONS.md](docs/SETUP_INSTRUCTIONS.md)** - Instruksi setup lengkap
- **[CheckSheet_API.postman_collection.json](docs/CheckSheet_API.postman_collection.json)** - Postman collection untuk testing

---

## 🔒 Security

### Implemented
- ✅ Password hashing dengan bcrypt
- ✅ Email verification (MustVerifyEmail contract)
- ✅ Token expiration (24 hours)
- ✅ Account status checking
- ✅ Soft delete support
- ✅ Input validation & sanitization
- ✅ CORS configuration ready
- ✅ Secure HTTP methods

### Recommended for Production
- 📌 Enable HTTPS
- 📌 Implement rate limiting
- 📌 Add email verification on registration
- 📌 Implement password reset flow
- 📌 Add two-factor authentication
- 📌 Implement refresh token rotation
- 📌 Add audit logging

---

## 📁 Project Structure

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

## 🧪 Testing

### Dengan Postman

1. Import `docs/CheckSheet_API.postman_collection.json` ke Postman
2. Set variable `base_url` ke `http://localhost:8000/api/v1`
3. Jalankan request sesuai urutan

### Dengan cURL

Lihat [API_AUTHENTICATION.md](docs/API_AUTHENTICATION.md) untuk contoh cURL lengkap.

### Dengan Flutter

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

future<void> login(String email, String password) async {
  final response = await http.post(
    Uri.parse('http://localhost:8000/api/v1/auth/login'),
    headers: {'Content-Type': 'application/json'},
    body: jsonEncode({
      'email': email,
      'password': password,
    }),
  );

  if (response.statusCode == 200) {
    final data = jsonDecode(response.body);
    String token = data['data']['token'];
    // Simpan token di secure storage
  }
}
```

---

## 🔄 Request/Response Format

### Success Response

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
    "token": "1|jVHGEF...",
    "token_type": "Bearer",
    "expires_in": 86400
  }
}
```

### Error Response

```json
{
  "success": false,
  "message": "Email atau password tidak sesuai.",
  "data": null
}
```

---

## ⚙️ Configuration

### Sanctum Configuration

**File:** `config/sanctum.php`

- Token expiration: 525600 menit (1 tahun) - dapat di-override per token
- Guard: `web` (dapat diubah sesuai kebutuhan)
- Stateful domains: Konfigurasi di `.env`

### Authentication Guard

**File:** `config/auth.php`

```php
'guards' => [
    'api' => [
        'driver' => 'sanctum',
        'provider' => 'users',
        'hash' => false,
    ],
],
```

---

## 📊 Database Schema

### Users Table

| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Primary key |
| name | string | User's full name |
| email | string | Unique email |
| phone | string | Unique phone (optional) |
| password | string | Hashed password |
| role | enum | admin, supervisor, user |
| is_active | boolean | Account status |
| profile_image | string | Profile image path |
| bio | text | User bio |
| email_verified_at | timestamp | Email verification |
| last_login_at | timestamp | Last login time |
| remember_token | string | Remember me token |
| created_at | timestamp | Created time |
| updated_at | timestamp | Updated time |
| deleted_at | timestamp | Soft delete |

---

## 🚀 Next Steps

### Phase 2 (Upcoming)
- [ ] Email verification on registration
- [ ] Password reset/forgot password
- [ ] User profile update
- [ ] Change password
- [ ] Two-factor authentication
- [ ] Social login (Google, Facebook)
- [ ] Role-based access control (RBAC)
- [ ] User management (admin)

### Phase 3 (Future)
- [ ] Audit logging
- [ ] Activity tracking
- [ ] Session management
- [ ] Device management
- [ ] IP whitelisting
- [ ] Advanced permission system

---

## 🐛 Troubleshooting

### Token not working
- Pastikan format header: `Authorization: Bearer {token}`
- Token mungkin sudah expired (24 jam)
- User mungkin dinonaktifkan

### Database migration error
```bash
php artisan migrate:rollback
php artisan migrate
```

### CORS error
Update `config/cors.php`:
```php
'allowed_origins' => ['*'],
```

### Cache issues
```bash
php artisan cache:clear
php artisan config:clear
```

---

## 📝 Changelog

### v1.0.0 (2024-12-09)
- ✅ Initial release
- ✅ User registration
- ✅ User login
- ✅ Token management
- ✅ User profile
- ✅ Logout

---

## 📖 Resources

- [Laravel Sanctum Documentation](https://laravel.com/docs/8.x/sanctum)
- [Laravel API Documentation](https://laravel.com/api/8.x/)
- [API Best Practices](https://restfulapi.net/)
- [OWASP Security Guidelines](https://owasp.org/www-project-cheat-sheets/)

---

## 👨‍💼 Author

**Tri Bayu Priangga** (TBPriangga)

---

## 📄 License

MIT License - lihat [LICENSE](LICENSE) file untuk detail

---

## 🤝 Contributing

Jika ingin berkontribusi, silakan:

1. Fork repository
2. Buat feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buat Pull Request

---

## 📞 Support

Jika ada pertanyaan atau issue, silakan buat GitHub issue di repository ini.

---

**Last Updated**: December 9, 2024  
**Framework**: Laravel 8.83.29  
**API Version**: v1
