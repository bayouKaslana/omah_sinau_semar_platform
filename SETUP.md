# 🚀 Panduan Setup Mitra Prestasi

## Prasyarat
- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js & NPM

---

## Langkah Install

### 1. Copy & masuk ke folder proyek
```bash
cd Mitra
```

### 2. Install dependensi PHP
```bash
composer install
```

### 3. Copy file environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setting database di `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mitra_prestasi
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan migrasi + seeder
```bash
php artisan migrate --seed
```

### 6. Buat symlink storage (untuk upload foto)
```bash
php artisan storage:link
```

### 7. Install & build frontend
```bash
npm install
npm run dev
```

### 8. Jalankan server
```bash
php artisan serve
```

---

## 🔐 Login Admin
- **URL:** http://localhost:8000/admin
- **Email:** admin@mitraprestasi.com  
- **Password:** admin123

---

## 📁 Struktur Fitur

| Fitur | URL | Keterangan |
|-------|-----|------------|
| Home | `/` | Landing page dinamis |
| Detail Lomba | `/lomba/{id}` | Info + form daftar |
| Blog | `/blog` | Daftar artikel |
| Admin Dashboard | `/admin` | Ringkasan statistik |
| Admin Lomba | `/admin/lomba` | CRUD lomba |
| Admin Pendaftaran | `/admin/pendaftaran` | Kelola peserta |
| Admin Blog | `/admin/blog` | CRUD artikel |
| Admin Galeri | `/admin/galeri` | Upload & kelola foto |

---

## 📂 File yang Diubah / Ditambah

### Baru (dibuat dari nol):
- `database/migrations/` → 4 migration baru (lomba, pendaftaran, blog, galeri)
- `app/Models/` → Lomba, Pendaftaran, Blog, Galeri
- `app/Http/Controllers/` → HomeController, LombaController, BlogController
- `app/Http/Controllers/Admin/` → Dashboard, Lomba, Pendaftaran, Blog, Galeri
- `routes/web.php` → Semua route public + admin
- `resources/views/admin/` → Seluruh admin panel
- `resources/views/lomba/show.blade.php` → Detail + form pendaftaran
- `resources/views/blog/` → Index + show artikel
- `database/seeders/` → LombaSeeder, BlogSeeder, GaleriSeeder

### Diperbarui:
- `resources/views/home.blade.php` → Data dari database (dinamis)
- `app/Models/User.php` → Tambah field role
- `database/migrations/..._create_users_table.php` → Tambah kolom role
- `database/factories/UserFactory.php` → Password default admin123

---

## 💡 Tips Penggunaan
- Foto galeri yang sudah ada di `public/image/` otomatis di-seed
- Upload foto baru di Admin → Galeri akan disimpan di `storage/app/public/galeri/`
- Jalankan `php artisan storage:link` agar foto yang diupload bisa tampil

---

## 📦 Install Package Excel (wajib untuk Export)

Jalankan perintah ini di folder proyek:
```bash
composer require maatwebsite/excel
```

Setelah install, tambahkan di `config/app.php` bagian `providers`:
```php
Maatwebsite\Excel\ExcelServiceProvider::class,
```
Dan bagian `aliases`:
```php
'Excel' => Maatwebsite\Excel\Facades\Excel::class,
```

Atau jalankan:
```bash
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```
