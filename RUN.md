# 🚀 Project Setup & Execution Guide

Follow these steps to get the **MidwayCafe** restaurant system running on your local machine.

## 📋 Prerequisites

Before you begin, ensure you have the following installed:
- **PHP 8.x**
- **Composer**
- **Node.js & npm**
- **PostgreSQL** (or MySQL if you prefer, though the project defaults to PostgreSQL)

---

## 🛠️ Step-by-Step Setup

### 1. Clone the Repository
```bash
git clone <repository-url>
cd Restaurant_Ecommerce_System_Laravel-master
```

### 2. Install Backend Dependencies
```bash
composer install
```

### 3. Install Frontend Dependencies
```bash
npm install
npm run dev
```

### 4. Environment Configuration
Create a `.env` file by copying the example:
```bash
cp .env.example .env
```
Open `.env` and configure your database settings:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=midway_cafe
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Database Migration & Seeding
Create the database tables and populate them with sample data (chefs, menu items, etc.):
```bash
php artisan migrate --seed
```

### 7. Link Storage
```bash
php artisan storage:link
```

---

## 🏃 Running the Application

### Start the Laravel Server
```bash
php artisan serve
```
The application will be available at: `http://127.0.0.1:8000`

---

## 📧 Required Services

### Mail / OTP Verification
This project uses OTP-based registration. You must configure your mail driver in `.env` for this to work.
For development, you can use **Mailtrap**:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

### Payment Gateways (Optional/Demo)
The project includes integrations for **bKash** and **SSLCommerz**. Ensure your sandbox credentials are set in `.env` if you wish to test these specifically.
