# 🚀 HireCadePro - Premium Digital Marketplace & Services Platform

HireCadePro is a high-performance, production-ready Laravel platform designed for developers and agencies to showcase their portfolio, sell digital products (SaaS Kits, CMS, Scripts), and manage professional service inquiries.

---


## ✨ Key Features

### 🛒 Digital Product Marketplace
- **Curated Catalog**: Showcase Software (ERP/HMS), Apps (CRM/Ecommerce), and Scripts.
- **Product Details**: Tech stack badges, version tracking, and feature lists.
- **Responsive Layout**: Premium, clean UI with Dark/Light mode support.

### 🛠️ Professional Services & Quotes
- **Interactive Quote Wizard**: A step-by-step interactive form for capturing detailed client requirements.
- **Service Categories**: Web Development, API Design, SaaS Architecture, and more.

### 📊 Advanced Admin Analytics
- **Business Intelligence**: Track revenue trends, order status, and customer growth.
- **Geographical Insights**: Visualize which global markets are driving your revenue.
- **Service Demand Tracking**: See exactly which specific service add-ons are most requested.
- **Conversion Tracking**: Monitor how many inquiries turn into paid projects.

### 🎨 Fully Customizable Appearance
- **Admin Theme Settings**: Change primary, secondary, and accent colors directly from the dashboard.
- **Live Preview**: Real-time color updates for the entire platform.
- **Dynamic Branding**: Easily upload logos and favicons for light and dark themes.

---

## 🛠️ Tech Stack
- **Framework**: Laravel 11.x
- **Frontend**: Blade Templating, Vanilla CSS (Modern Flex/Grid), JavaScript (ES6+)
- **Charts**: Chart.js 4.4
- **Icons**: Font Awesome 6 (Pro/Solid/Brands)
- **Database**: MySQL / PostgreSQL / SQLite

---

## 🚀 Quick Setup Guide

Follow these steps to get your site running locally:

### 1. Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- Database (MySQL, PostgreSQL, or SQLite)

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/your-username/hirecadepro.git
cd hirecode_laravel

# Install dependencies
composer install
npm install
```

### 3. Configuration
```bash
# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```
*Open `.env` and configure your database settings.*

### 4. Database & Initial Data
```bash
# Run migrations and seed the database with products and settings
php artisan migrate --seed
```

### 5. Start Development Server
```bash
# Run Laravel development server
php artisan serve

# Build or run Vite for assets
npm run dev
```

---

## 🔐 Admin Access
Once the database is seeded, you can access the admin panel at `/admin/login`.

**Default Credentials:**
- **Email:** `admin@codecraftstudio.com`
- **Password:** `Admin123!`

---

## 📁 Project Structure Highlights
- `/app/Http/Controllers/Admin`: Core logic for analytics, products, and site settings.
- `/resources/views/admin`: Specialized dashboard and analytics UI.
- `/resources/views/layouts`: Reusable theme system for User and Admin sides.
- `/database/seeders`: Consolidated seeders for a "one-click" setup experience.

---

## 📄 License
This project is licensed under the MIT License.
