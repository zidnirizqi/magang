# Test API Login & Register untuk Windows PowerShell
# Pastikan server Laravel sudah berjalan: php artisan serve

$BaseUrl = "http://localhost:8000/api"

Write-Host "================================" -ForegroundColor Green
Write-Host "Testing API Register" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Green

$registerBody = @{
    name = "Test User PowerShell"
    email = "testps@example.com"
    password = "password123"
    password_confirmation = "password123"
} | ConvertTo-Json

try {
    $registerResponse = Invoke-WebRequest -Uri "$BaseUrl/register" -Method POST -Headers @{
        "Content-Type" = "application/json"
        "Accept" = "application/json"
    } -Body $registerBody
    
    Write-Host "Status: $($registerResponse.StatusCode)" -ForegroundColor Yellow
    Write-Host "Response: $($registerResponse.Content)" -ForegroundColor Cyan
} catch {
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host "`n================================" -ForegroundColor Green
Write-Host "Testing API Login" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Green

$loginBody = @{
    email = "testps@example.com"
    password = "password123"
} | ConvertTo-Json

try {
    $loginResponse = Invoke-WebRequest -Uri "$BaseUrl/login" -Method POST -Headers @{
        "Content-Type" = "application/json"
        "Accept" = "application/json"
    } -Body $loginBody
    
    Write-Host "Status: $($loginResponse.StatusCode)" -ForegroundColor Yellow
    Write-Host "Response: $($loginResponse.Content)" -ForegroundColor Cyan
    
    # Extract token for logout test
    $responseData = $loginResponse.Content | ConvertFrom-Json
    $token = $responseData.data.token
    
    Write-Host "`n================================" -ForegroundColor Green
    Write-Host "Testing API Logout" -ForegroundColor Green
    Write-Host "================================" -ForegroundColor Green
    
    $logoutResponse = Invoke-WebRequest -Uri "$BaseUrl/logout" -Method POST -Headers @{
        "Content-Type" = "application/json"
        "Accept" = "application/json"
        "Authorization" = "Bearer $token"
    }
    
    Write-Host "Status: $($logoutResponse.StatusCode)" -ForegroundColor Yellow
    Write-Host "Response: $($logoutResponse.Content)" -ForegroundColor Cyan
    
} catch {
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host "`n================================" -ForegroundColor Green
Write-Host "Testing Complete!" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Green