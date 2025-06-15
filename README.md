<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🇱🇰 Sri Lankan Digital Identity System

[![Laravel](https://img.shields.io/badge/Laravel-12.0-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.4-38B2AC.svg)](https://tailwindcss.com)

> **A complete government-grade digital identity management system built with Laravel 12**

Modern web application that digitizes Sri Lanka's ID card issuance process with multi-role authentication, workflow management, and secure digital card generation.

## ✨ Key Features

- **🔐 Multi-Role System** - Admin, DS Officers, GS Officers, and Citizens
- **💳 Digital Card Generation** - PDF certificates with QR codes
- **📊 Real-time Dashboards** - Application tracking and analytics  
- **🔍 Public Verification** - Instant card verification portal
- **📱 Responsive Design** - Mobile-first government interfaces

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+

### Installation

```bash
# Clone repository
git clone https://github.com/J33WAKASUPUN/sri-lanka-digital-id.git
cd sri-lanka-digital-id

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Build and serve
npm run build
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 👥 Demo Accounts

| Role | Email | Password | Access |
|------|-------|----------|---------|
| Admin | admin@digitalid.gov.lk | admin123 | Full system |
| DS Officer | ds.colombo@digitalid.gov.lk | ds123456 | Approvals |
| GS Officer | gs.kandy@digitalid.gov.lk | gs123456 | Reviews |

## 🏗️ Tech Stack

**Backend**
- Laravel 12 with PHP 8.2+
- MySQL 8.0 database
- DomPDF for certificate generation
- QR Code integration

**Frontend**  
- Tailwind CSS 3.4
- Alpine.js for interactions
- Blade templating
- Responsive design

## 🔄 Application Workflow

```
Citizen Application → GS Review → DS Approval → Digital Card → Public Verification
```

## 📊 Project Stats

- ⏱️ **Built in:** 18 hours
- 📁 **Files:** 50+ components
- 🛠️ **Controllers:** 15+ modules
- 🎨 **Views:** 30+ templates
- 🔐 **Security:** Enterprise-level

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📝 License

This project is licensed under the MIT License.

---

<div align="center">

**Built with ❤️ by [J33WAKASUPUN](https://github.com/J33WAKASUPUN)**

⭐ Star this repository if you found it helpful!

</div>
