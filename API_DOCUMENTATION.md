# API Documentation - Login & Register

## Base URL
```
http://localhost:8000/api
```

## Endpoints

### 1. Register
**Endpoint:** `POST /api/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Success Response (201):**
```json
{
    "success": true,
    "message": "Registration successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "created_at": "2026-03-10T10:00:00.000000Z",
            "updated_at": "2026-03-10T10:00:00.000000Z"
        },
        "token": "1|abcdefghijklmnopqrstuvwxyz"
    }
}
```

**Error Response (422):**
```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "email": ["The email has already been taken."],
        "password": ["The password confirmation does not match."]
    }
}
```

---

### 2. Login
**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Success Response (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "created_at": "2026-03-10T10:00:00.000000Z",
            "updated_at": "2026-03-10T10:00:00.000000Z"
        },
        "token": "2|abcdefghijklmnopqrstuvwxyz"
    }
}
```

**Error Response (401):**
```json
{
    "success": false,
    "message": "Invalid credentials"
}
```

---

### 3. Logout
**Endpoint:** `POST /api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Success Response (200):**
```json
{
    "success": true,
    "message": "Logout successful"
}
```

---

## Testing dengan Postman/Insomnia

### Register
1. Method: POST
2. URL: `http://localhost:8000/api/register`
3. Headers: `Content-Type: application/json`
4. Body (raw JSON):
```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### Login
1. Method: POST
2. URL: `http://localhost:8000/api/login`
3. Headers: `Content-Type: application/json`
4. Body (raw JSON):
```json
{
    "email": "test@example.com",
    "password": "password123"
}
```

### Logout
1. Method: POST
2. URL: `http://localhost:8000/api/logout`
3. Headers: 
   - `Content-Type: application/json`
   - `Authorization: Bearer {your_token_here}`
