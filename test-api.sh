#!/bin/bash

# Test API Login & Register
# Pastikan server Laravel sudah berjalan: php artisan serve

BASE_URL="http://localhost:8000/api"

echo "================================"
echo "Testing API Register"
echo "================================"
curl -X POST $BASE_URL/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

echo -e "\n\n================================"
echo "Testing API Login"
echo "================================"
curl -X POST $BASE_URL/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'

echo -e "\n\n================================"
echo "Testing API Logout"
echo "================================"
echo "Ganti YOUR_TOKEN dengan token dari response login"
echo "curl -X POST $BASE_URL/logout \\"
echo "  -H \"Content-Type: application/json\" \\"
echo "  -H \"Accept: application/json\" \\"
echo "  -H \"Authorization: Bearer YOUR_TOKEN\""
