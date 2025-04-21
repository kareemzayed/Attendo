# Attendo Backend 🌐📍  
**Laravel-Powered API for Location-Based Attendance System**  

# Laravel + MySQL 

<div style="display: flex; gap: 10px; align-items: center;">
  <img src="https://laravel.com/img/logomark.min.svg" width="30">
  <span style="font-size: 30px; margin-left: 10px; margin-right: 10px;">+</span>
  <img src="https://www.mysql.com/common/logos/logo-mysql-170x115.png" width="60">
</div>

## 🔍 Overview  
This repository contains the **backend API** for **Attendo**, a geofenced attendance system built with Laravel. It handles:  
- ✅ User authentication.  
- ✅ Geofence validation.  
- ✅ Check-in/out logs stored in MySQL.  
- ✅ Admin dashboards and reporting.  

---

## 🛠️ Tech Stack  
- **Framework**: Laravel 12.x  
- **Database**: MySQL (via phpMyAdmin)  
- **API**: RESTful JSON  
- **Auth**: Laravel Sanctum 
- **Geofencing**: Google Maps API / Haversine formula  
- **Testing**: PHPUnit  

---

## ⚙️ Installation  

### Prerequisites  
- PHP ≥ 8.4, Composer, MySQL  
- Google Maps API key (for geofencing)  

### Steps  
1. **Clone the repo**:  
   ```bash
   git clone https://github.com/kareemzayed/Attendo.git
   cd attendo-backend
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Configure environment**:
   ```bash
   cp .env.example .env
   ```
   Then edit the .env file with your configuration.

4. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

5. **Generate application key**:
   ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=attendo
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**:
   ```bash
   php artisan migrate --seed
   ```

7. **Generate JWT secret (if using JWT auth)**:
   ```bash
   php artisan jwt:secret
   ```

8. **Start development server**:
   ```bash
   php artisan serve
   ```

9. **Run queue worker (for jobs/notifications)**:
   ```bash
   php artisan queue:work
   ```


## ⚙️ Additional Setup for Production
1. **Optimize autoloader**:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

2. **Cache configuration**:
   ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
   ```

3. **Key variables to configure in .env**:
   ```dotenv
    APP_ENV=production
    APP_DEBUG=false
    GOOGLE_MAPS_API_KEY=your_api_key
    ATTENDANCE_RADIUS=100  # in meters
   ```
