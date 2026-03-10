# Test Category API CRUD Operations
# Pastikan server Laravel sudah berjalan: php artisan serve

$BaseUrl = "http://localhost:8000/api"

Write-Host "================================" -ForegroundColor Green
Write-Host "Testing Category API CRUD" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Green

# Test 1: Create Category
Write-Host "`n1. Creating new category..." -ForegroundColor Yellow

$createBody = @{
    name = "Test Category API"
    description = "Category created via API test"
    status = "active"
} | ConvertTo-Json

try {
    $createResponse = Invoke-WebRequest -Uri "$BaseUrl/categories" -Method POST -Headers @{
        "Content-Type" = "application/json"
        "Accept" = "application/json"
    } -Body $createBody
    
    Write-Host "✅ Create Status: $($createResponse.StatusCode)" -ForegroundColor Green
    $createData = $createResponse.Content | ConvertFrom-Json
    $categoryId = $createData.data.id
    Write-Host "Created Category ID: $categoryId" -ForegroundColor Cyan
} catch {
    Write-Host "❌ Create Error: $($_.Exception.Message)" -ForegroundColor Red
    exit
}

# Test 2: Get All Categories
Write-Host "`n2. Getting all categories..." -ForegroundColor Yellow

try {
    $getAllResponse = Invoke-WebRequest -Uri "$BaseUrl/categories" -Method GET -Headers @{
        "Accept" = "application/json"
    }
    
    Write-Host "✅ Get All Status: $($getAllResponse.StatusCode)" -ForegroundColor Green
    $getAllData = $getAllResponse.Content | ConvertFrom-Json
    Write-Host "Total Categories: $($getAllData.data.Count)" -ForegroundColor Cyan
} catch {
    Write-Host "❌ Get All Error: $($_.Exception.Message)" -ForegroundColor Red
}

# Test 3: Get Single Category
Write-Host "`n3. Getting single category..." -ForegroundColor Yellow

try {
    $getSingleResponse = Invoke-WebRequest -Uri "$BaseUrl/categories/$categoryId" -Method GET -Headers @{
        "Accept" = "application/json"
    }
    
    Write-Host "✅ Get Single Status: $($getSingleResponse.StatusCode)" -ForegroundColor Green
    $getSingleData = $getSingleResponse.Content | ConvertFrom-Json
    Write-Host "Category Name: $($getSingleData.data.name)" -ForegroundColor Cyan
} catch {
    Write-Host "❌ Get Single Error: $($_.Exception.Message)" -ForegroundColor Red
}

# Test 4: Update Category
Write-Host "`n4. Updating category..." -ForegroundColor Yellow

$updateBody = @{
    name = "Updated Test Category API"
    description = "Updated description via API test"
    status = "inactive"
} | ConvertTo-Json

try {
    $updateResponse = Invoke-WebRequest -Uri "$BaseUrl/categories/$categoryId" -Method PUT -Headers @{
        "Content-Type" = "application/json"
        "Accept" = "application/json"
    } -Body $updateBody
    
    Write-Host "✅ Update Status: $($updateResponse.StatusCode)" -ForegroundColor Green
    $updateData = $updateResponse.Content | ConvertFrom-Json
    Write-Host "Updated Name: $($updateData.data.name)" -ForegroundColor Cyan
    Write-Host "Updated Status: $($updateData.data.status)" -ForegroundColor Cyan
} catch {
    Write-Host "❌ Update Error: $($_.Exception.Message)" -ForegroundColor Red
}

# Test 5: Toggle Status
Write-Host "`n5. Toggling category status..." -ForegroundColor Yellow

try {
    $toggleResponse = Invoke-WebRequest -Uri "$BaseUrl/categories/$categoryId/toggle-status" -Method PATCH -Headers @{
        "Accept" = "application/json"
    }
    
    Write-Host "✅ Toggle Status: $($toggleResponse.StatusCode)" -ForegroundColor Green
    $toggleData = $toggleResponse.Content | ConvertFrom-Json
    Write-Host "New Status: $($toggleData.data.status)" -ForegroundColor Cyan
} catch {
    Write-Host "❌ Toggle Error: $($_.Exception.Message)" -ForegroundColor Red
}

# Test 6: Delete Category
Write-Host "`n6. Deleting category..." -ForegroundColor Yellow

try {
    $deleteResponse = Invoke-WebRequest -Uri "$BaseUrl/categories/$categoryId" -Method DELETE -Headers @{
        "Accept" = "application/json"
    }
    
    Write-Host "✅ Delete Status: $($deleteResponse.StatusCode)" -ForegroundColor Green
    $deleteData = $deleteResponse.Content | ConvertFrom-Json
    Write-Host "Message: $($deleteData.message)" -ForegroundColor Cyan
} catch {
    Write-Host "❌ Delete Error: $($_.Exception.Message)" -ForegroundColor Red
}

# Test 7: Verify Deletion
Write-Host "`n7. Verifying deletion..." -ForegroundColor Yellow

try {
    $verifyResponse = Invoke-WebRequest -Uri "$BaseUrl/categories/$categoryId" -Method GET -Headers @{
        "Accept" = "application/json"
    }
    
    Write-Host "❌ Category still exists!" -ForegroundColor Red
} catch {
    if ($_.Exception.Response.StatusCode -eq 404) {
        Write-Host "✅ Category successfully deleted (404 Not Found)" -ForegroundColor Green
    } else {
        Write-Host "❌ Unexpected error: $($_.Exception.Message)" -ForegroundColor Red
    }
}

Write-Host "`n================================" -ForegroundColor Green
Write-Host "Category API Testing Complete!" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Green

# Test 8: Create Sample Data
Write-Host "`n8. Creating sample categories..." -ForegroundColor Yellow

$sampleCategories = @(
    @{ name = "Electronics"; description = "Electronic devices and gadgets"; status = "active" },
    @{ name = "Clothing"; description = "Fashion and apparel"; status = "active" },
    @{ name = "Books"; description = "Books and literature"; status = "active" },
    @{ name = "Sports"; description = "Sports equipment"; status = "inactive" }
)

foreach ($category in $sampleCategories) {
    $sampleBody = $category | ConvertTo-Json
    
    try {
        $sampleResponse = Invoke-WebRequest -Uri "$BaseUrl/categories" -Method POST -Headers @{
            "Content-Type" = "application/json"
            "Accept" = "application/json"
        } -Body $sampleBody
        
        Write-Host "✅ Created: $($category.name)" -ForegroundColor Green
    } catch {
        Write-Host "❌ Failed to create: $($category.name)" -ForegroundColor Red
    }
}

Write-Host "`n✅ Sample data created! Check the admin panel at:" -ForegroundColor Green
Write-Host "http://localhost:8000/admin/category" -ForegroundColor Cyan