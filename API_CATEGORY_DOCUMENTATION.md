# API Documentation - Category CRUD

## Base URL
```
http://localhost:8000/api
```

## Category Endpoints

### 1. Get All Categories
**Endpoint:** `GET /api/categories`

**Response (200):**
```json
{
    "success": true,
    "message": "Categories retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Electronics",
            "description": "Electronic devices and gadgets",
            "status": "active",
            "products_count": 5,
            "created_at": "2026-03-10 15:19:13",
            "updated_at": "2026-03-10 15:19:13"
        }
    ]
}
```

---

### 2. Get Single Category
**Endpoint:** `GET /api/categories/{id}`

**Response (200):**
```json
{
    "success": true,
    "message": "Category retrieved successfully",
    "data": {
        "id": 1,
        "name": "Electronics",
        "description": "Electronic devices and gadgets",
        "status": "active",
        "products_count": 5,
        "created_at": "2026-03-10 15:19:13",
        "updated_at": "2026-03-10 15:19:13"
    }
}
```

**Error Response (404):**
```json
{
    "success": false,
    "message": "Category not found"
}
```

---

### 3. Create Category
**Endpoint:** `POST /api/categories`

**Request Body:**
```json
{
    "name": "Electronics",
    "description": "Electronic devices and gadgets",
    "status": "active"
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters, unique
- `description`: optional, string
- `status`: optional, enum (active/inactive), default: active

**Success Response (201):**
```json
{
    "success": true,
    "message": "Category created successfully",
    "data": {
        "id": 1,
        "name": "Electronics",
        "description": "Electronic devices and gadgets",
        "status": "active",
        "products_count": 0,
        "created_at": "2026-03-10 15:19:13",
        "updated_at": "2026-03-10 15:19:13"
    }
}
```

**Error Response (422):**
```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "name": ["The name field is required."],
        "status": ["The selected status is invalid."]
    }
}
```

---

### 4. Update Category
**Endpoint:** `PUT /api/categories/{id}`

**Request Body:**
```json
{
    "name": "Updated Electronics",
    "description": "Updated description",
    "status": "inactive"
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters, unique (except current record)
- `description`: optional, string
- `status`: optional, enum (active/inactive)

**Success Response (200):**
```json
{
    "success": true,
    "message": "Category updated successfully",
    "data": {
        "id": 1,
        "name": "Updated Electronics",
        "description": "Updated description",
        "status": "inactive",
        "products_count": 5,
        "created_at": "2026-03-10 15:19:13",
        "updated_at": "2026-03-10 15:25:30"
    }
}
```

---

### 5. Delete Category
**Endpoint:** `DELETE /api/categories/{id}`

**Success Response (200):**
```json
{
    "success": true,
    "message": "Category deleted successfully"
}
```

**Error Response (400) - Has Products:**
```json
{
    "success": false,
    "message": "Cannot delete category. It has associated products."
}
```

**Error Response (404):**
```json
{
    "success": false,
    "message": "Category not found"
}
```

---

### 6. Toggle Category Status
**Endpoint:** `PATCH /api/categories/{id}/toggle-status`

**Success Response (200):**
```json
{
    "success": true,
    "message": "Category status updated successfully",
    "data": {
        "id": 1,
        "name": "Electronics",
        "status": "inactive"
    }
}
```

---

## Testing Examples

### Create Category
```bash
curl -X POST http://localhost:8000/api/categories \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Books",
    "description": "Books and literature",
    "status": "active"
  }'
```

### Get All Categories
```bash
curl -X GET http://localhost:8000/api/categories \
  -H "Accept: application/json"
```

### Update Category
```bash
curl -X PUT http://localhost:8000/api/categories/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Books",
    "description": "Updated description",
    "status": "inactive"
  }'
```

### Delete Category
```bash
curl -X DELETE http://localhost:8000/api/categories/1 \
  -H "Accept: application/json"
```

### Toggle Status
```bash
curl -X PATCH http://localhost:8000/api/categories/1/toggle-status \
  -H "Accept: application/json"
```

---

## PowerShell Examples

### Create Category
```powershell
Invoke-WebRequest -Uri "http://localhost:8000/api/categories" -Method POST -Headers @{
    "Content-Type" = "application/json"
    "Accept" = "application/json"
} -Body '{"name":"Sports","description":"Sports equipment","status":"active"}'
```

### Get Categories
```powershell
Invoke-WebRequest -Uri "http://localhost:8000/api/categories" -Method GET -Headers @{
    "Accept" = "application/json"
}
```

### Update Category
```powershell
Invoke-WebRequest -Uri "http://localhost:8000/api/categories/1" -Method PUT -Headers @{
    "Content-Type" = "application/json"
    "Accept" = "application/json"
} -Body '{"name":"Updated Sports","description":"Updated description"}'
```

---

## Error Codes

| Status Code | Description |
|-------------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request (e.g., category has products) |
| 404 | Category Not Found |
| 422 | Validation Error |
| 500 | Internal Server Error |

---

## Features

✅ **CRUD Operations**
- Create new categories
- Read all categories with product count
- Update existing categories
- Delete categories (with protection)

✅ **Status Management**
- Toggle active/inactive status
- Filter by status

✅ **Validation**
- Required field validation
- Unique name validation
- Status enum validation

✅ **Relationships**
- Product count per category
- Prevent deletion if has products

✅ **Error Handling**
- Comprehensive error responses
- Validation error details
- Not found handling