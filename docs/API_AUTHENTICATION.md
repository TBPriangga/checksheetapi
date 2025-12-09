# CheckSheet API - Authentication Documentation

## Overview

CheckSheet API menggunakan **Laravel Sanctum** untuk autentikasi berbasis token. Setiap permintaan ke endpoint yang dilindungi harus menyertakan token yang valid di header `Authorization`.

---

## Base URL

```
http://localhost:8000/api/v1
```

---

## 1. Login

### Endpoint
```
POST /auth/login
```

### Headers
```
Content-Type: application/json
```

### Request Body
```json
{
    "email": "user@example.com",
    "password": "Password123"
}
```

### Success Response (200)
```json
{
    "success": true,
    "message": "Login berhasil.",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com",
            "phone": null,
            "role": "user",
            "is_active": true,
            "profile_image": null,
            "bio": null,
            "email_verified_at": null,
            "last_login_at": "2024-12-09T10:30:00.000000Z",
            "created_at": "2024-12-09T10:00:00.000000Z",
            "updated_at": "2024-12-09T10:30:00.000000Z"
        },
        "token": "1|jVHGEF...",
        "token_type": "Bearer",
        "expires_in": 86400
    }
}
```

### Error Response (401)
```json
{
    "success": false,
    "message": "Email atau password tidak sesuai.",
    "data": null
}
```

### Error Response (403) - User Not Active
```json
{
    "success": false,
    "message": "Akun Anda telah dinonaktifkan. Hubungi admin untuk bantuan.",
    "data": null
}
```

---

## 2. Register

### Endpoint
```
POST /auth/register
```

### Headers
```
Content-Type: application/json
```

### Request Body
```json
{
    "name": "John Doe",
    "email": "newuser@example.com",
    "phone": "081234567890",
    "password": "SecurePass123!",
    "password_confirmation": "SecurePass123!"
}
```

### Validation Rules
- **name**: Required, string, 3-255 chars, only letters and spaces
- **email**: Required, valid email, unique in database
- **phone**: Optional, format Indonesia (081xxx), unique
- **password**: Required, min 8 chars, must contain:
  - At least 1 uppercase letter
  - At least 1 lowercase letter
  - At least 1 number
  - At least 1 special character (@$!%*?&)
- **password_confirmation**: Must match password

### Success Response (201)
```json
{
    "success": true,
    "message": "Pendaftaran berhasil. Silakan login.",
    "data": {
        "user": {
            "id": 2,
            "name": "John Doe",
            "email": "newuser@example.com",
            "phone": "081234567890",
            "role": "user",
            "is_active": true,
            ...
        },
        "token": "2|jVHGEF...",
        "token_type": "Bearer",
        "expires_in": 86400
    }
}
```

### Error Response (409) - Email Already Registered
```json
{
    "success": false,
    "message": "Email sudah terdaftar.",
    "data": null
}
```

### Error Response (422) - Validation Error
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["Email sudah terdaftar."],
        "password": ["Password minimal mengandung 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter spesial."]
    }
}
```

---

## 3. Get Current User Profile

### Endpoint
```
GET /auth/me
```

### Headers
```
Authorization: Bearer {token}
Content-Type: application/json
```

### Success Response (200)
```json
{
    "success": true,
    "message": "Data pengguna berhasil diambil.",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com",
        "phone": null,
        "role": "user",
        "is_active": true,
        "profile_image": null,
        "bio": null,
        "email_verified_at": null,
        "last_login_at": "2024-12-09T10:30:00.000000Z",
        "created_at": "2024-12-09T10:00:00.000000Z",
        "updated_at": "2024-12-09T10:30:00.000000Z"
    }
}
```

### Error Response (401) - Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

---

## 4. Logout

### Endpoint
```
POST /auth/logout
```

### Headers
```
Authorization: Bearer {token}
Content-Type: application/json
```

### Success Response (200)
```json
{
    "success": true,
    "message": "Logout berhasil.",
    "data": null
}
```

### Error Response (401) - Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

---

## 5. Refresh Token

### Endpoint
```
POST /auth/refresh-token
```

### Headers
```
Authorization: Bearer {token}
Content-Type: application/json
```

### Success Response (200)
```json
{
    "success": true,
    "message": "Token berhasil diperbarui.",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "user@example.com",
            ...
        },
        "token": "1|newTokenHere...",
        "token_type": "Bearer",
        "expires_in": 86400
    }
}
```

### Error Response (401) - Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

---

## Authentication Usage in Subsequent Requests

Setiap request ke endpoint yang dilindungi harus menyertakan token di header:

```
Authorization: Bearer {token_dari_login_atau_register}
```

### Example:
```bash
curl -X GET http://localhost:8000/api/v1/auth/me \
  -H "Authorization: Bearer 1|jVHGEFexample..." \
  -H "Content-Type: application/json"
```

---

## Token Information

- **Type**: Bearer Token (Sanctum)
- **Expiration**: 24 hours from creation
- **Format**: `{ID}|{TOKEN_STRING}`
- **Revocation**: Token direvoke saat logout atau ekspirasi waktu

---

## Error Codes

| Code | Status | Meaning |
|------|--------|----------|
| 200 | OK | Request berhasil |
| 201 | Created | Resource berhasil dibuat |
| 400 | Bad Request | Request tidak valid |
| 401 | Unauthorized | Token tidak valid atau expired |
| 403 | Forbidden | User tidak memiliki akses (e.g., akun dinonaktifkan) |
| 404 | Not Found | Resource tidak ditemukan |
| 409 | Conflict | Resource sudah ada (e.g., email duplicate) |
| 422 | Unprocessable Entity | Validasi gagal |
| 500 | Server Error | Terjadi error di server |

---

## Testing

### 1. Test dengan cURL

**Login:**
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "Password123"
  }'
```

**Register:**
```bash
curl -X POST http://localhost:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "newuser@example.com",
    "phone": "081234567890",
    "password": "SecurePass123!",
    "password_confirmation": "SecurePass123!"
  }'
```

**Get User:**
```bash
curl -X GET http://localhost:8000/api/v1/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

**Logout:**
```bash
curl -X POST http://localhost:8000/api/v1/auth/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

### 2. Test dengan Postman

Import file `CheckSheet_API.postman_collection.json` ke Postman untuk testing yang lebih mudah.

### 3. Test dengan Flutter

Gunakan package `http` atau `dio` untuk membuat request:

```dart
import 'package:http/http.dart' as http;

// Login
var response = await http.post(
  Uri.parse('http://localhost:8000/api/v1/auth/login'),
  headers: {'Content-Type': 'application/json'},
  body: jsonEncode({
    'email': 'user@example.com',
    'password': 'Password123'
  }),
);

var data = jsonDecode(response.body);
if (data['success']) {
  String token = data['data']['token'];
  // Simpan token di SharedPreferences atau Secure Storage
}
```

---

## CORS Configuration

Jika frontend (Flutter) berada di domain berbeda, pastikan CORS sudah dikonfigurasi di Laravel:

**File:** `config/cors.php`

```php
'allowed_origins' => ['*'], // Atau spesifik domain mobile app
```

---

## Security Best Practices

1. **Simpan token di Secure Storage** (bukan SharedPreferences untuk production)
2. **Gunakan HTTPS** di production
3. **Set token expiration** yang appropriate (sekarang 24 jam)
4. **Validasi input** pada setiap endpoint
5. **Hash password** dengan bcrypt (sudah dilakukan)
6. **Log authentication attempts** untuk security audit
7. **Rate limiting** untuk login attempts (opsional)
8. **CSRF protection** untuk web apps

---

## Next Steps

1. **Email Verification**: Verifikasi email saat registrasi
2. **Password Reset**: Endpoint untuk reset password yang lupa
3. **Two-Factor Authentication**: MFA untuk security lebih tinggi
4. **Refresh Token Logic**: Implementasi refresh token terpisah
5. **User Profile Update**: Endpoint untuk update profil user
6. **Role-Based Access Control**: Middleware untuk role-based access

---

**Last Updated**: December 9, 2024
**API Version**: v1
**Laravel Version**: 8.83.29
