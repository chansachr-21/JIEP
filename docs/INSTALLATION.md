# 🚀 Panduan Instalasi & Menjalankan INDUSTRIA

## Kebutuhan Sistem
- **PHP**: >= 8.2 (Disarankan PHP 8.3 dengan ekstensi `pdo_mysql`, `openssl`, `mbstring`, `bcmath`)
- **Composer**: >= 2.x
- **Node.js**: >= 18.x (Teruji pada Node.js v26.x)
- **Database**: MySQL / MariaDB (Port default 3306)

---

## 1. Menjalankan Backend (Laravel 11)

1. Masuk ke direktori backend:
```bash
cd C:\JIEP\backend
```

2. Pastikan file `.env` sudah sesuai (konfigurasi database `industria_db`):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=industria_db
DB_USERNAME=root
DB_PASSWORD=
```

3. Jalankan migrasi dan seeder data awal:
```bash
php artisan migrate --force
php artisan db:seed --force
```

4. Jalankan server backend:
```bash
php artisan serve --host=127.0.0.1 --port=8000
```
Backend API akan aktif di: `http://127.0.0.1:8000`

---

## 2. Menjalankan Frontend (Nuxt 3)

1. Masuk ke direktori frontend:
```bash
cd C:\JIEP\frontend
```

2. Jalankan development server Nuxt:
```bash
npm run dev
```

3. Buka peramban (browser):
- **Halaman Publik**: `http://localhost:3000`
- **Dashboard Admin (Langsung tanpa login)**: `http://localhost:3000/admin`
