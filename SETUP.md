# 🚀 Roomly Backend Setup Guide

## Prerequisites
- PHP 8.2+
- Composer
- MySQL 5.7+ (Configured by default)
- XAMPP/LAMP/LEMP stack

---

## ⚡ Quick Setup (3 Steps)

```bash
# 1. Copy environment file
cp .env.example .env

# 2. Install dependencies
composer install && npm install && npm run build

# 3. Run migrations & seed
php artisan migrate --seed
php artisan serve
```

**Done!** Application ready at `http://localhost:8000`

---

## 📝 Detailed Installation Steps

### 1. Copy Environment File
```bash
cp .env.example .env
```

### 2. Generate Application Key
```bash
php artisan key:generate
```

This will generate a secure APP_KEY in your `.env` file.

**Pre-configured in `.env.example`:**
- ✅ DB_CONNECTION=mysql
- ✅ DB_DATABASE=roomly
- ✅ DB_HOST=127.0.0.1
- ✅ DB_USERNAME=root
- ✅ MAIL configured for Gmail SMTP

### 3. Update Email Configuration (Optional - for booking notifications)
Edit `.env` to configure Gmail:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Roomly"
```

**How to get Gmail App Password:**
1. Go to [myaccount.google.com/security](https://myaccount.google.com/security)
2. Enable 2-Step Verification
3. Go to App passwords → Select "Mail" and "Windows Computer"
4. Copy the generated password to `.env`

### 3. Ensure MySQL is Running
```bash
# On Windows XAMPP
# Start MySQL from XAMPP Control Panel
# or use: mysql -u root -p

# Verify MySQL connection
mysql -u root -e "SELECT 1;"
```

### 4. Install PHP Dependencies
```bash
composer install
```

### 5. Install Frontend Dependencies
```bash
npm install
npm run build
```

### 6. Run Database Migrations
```bash
php artisan migrate
```

This will create all tables:
- ✅ users, sessions, password_reset_tokens
- ✅ cards, ewallets
- ✅ resources, bookings, payments
- ✅ cache, jobs infrastructure

### 7. Seed Database (Optional - Creates test data)
```bash
php artisan db:seed
```

This creates:
- **Admin User**: test@example.com / password
- **10 Test Users**: fake@example.com series
- **15 Sample Resources**: with pricing & capacity

### 8. Start Development Server
```bash
php artisan serve
```

Application will be available at: **http://localhost:8000**

---

## 📋 Test Accounts

### Admin Account
```
Email: test@example.com
Password: password
Role: admin
```

All test users share the same password: `password`

---

## 🔑 API Endpoints

### Bookings
- `GET /bookings` - List user bookings
- `GET /bookings/{id}` - Get booking detail
- `POST /bookings` - Create booking

### Cards
- `GET /profile/cards` - List cards
- `POST /profile/cards` - Add card
- `PUT /profile/cards/{id}` - Update card
- `DELETE /profile/cards/{id}` - Delete card

### E-Wallet
- `GET /profile/e-wallet` - List e-wallets
- `POST /profile/e-wallet` - Add e-wallet
- `PUT /profile/e-wallet/{id}` - Update e-wallet
- `DELETE /profile/e-wallet/{id}` - Delete e-wallet

### Profile
- `GET /profile` - Get profile
- `PUT /profile/update` - Update profile

---

## ⚠️ Common Issues

### Issue: "SQLSTATE[HY000]: General error: 1030 Got error 28 from storage engine"
**Solution**: Database permissions issue. Ensure MySQL/SQLite database file has write permissions.

### Issue: "No application encryption key has been specified"
**Solution**: Run `php artisan key:generate`

### Issue: Migration fails with "Unknown database"
**Solution**: Ensure MySQL user has CREATE DATABASE privilege or use SQLite instead.

### Issue: Seeder fails creating users
**Solution**: Ensure database tables are created first - run migrations again.

---

## 📚 Project Structure

```
app/
  ├── Http/
  │   ├── Controllers/      # API Controllers
  │   ├── Middleware/       # Auth & Admin middleware
  ├── Models/               # Database Models
  ├── Mail/                 # Email notifications
database/
  ├── migrations/           # Database schema
  ├── factories/            # Test data factories
  ├── seeders/              # Database seeders
routes/
  ├── web.php               # API routes
```

---

## 🔒 Security Notes

- Authorization checks implemented for user-specific resources
- Cards and E-Wallets are protected per user
- Admin routes protected with middleware
- Passwords hashed with bcrypt

---

## 📧 Email Configuration

Update `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@roomly.local
MAIL_FROM_NAME="Roomly"
```

---

## 🚀 Ready to Deploy!

All backend modules are production-ready:
- ✅ Authentication
- ✅ Resource/Room CRUD
- ✅ Booking with conflict validation
- ✅ User Management
- ✅ Email Notifications
- ✅ Security & Authorization

Happy Coding! 🎉
