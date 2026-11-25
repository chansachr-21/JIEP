# 🗄️ Struktur Database & Skema Tabel — INDUSTRIA

Nama Database: `industria_db`  
DBMS: MySQL / MariaDB (InnoDB engine, utf8mb4_unicode_ci)

---

## 1. Tabel `industrial_estates`
Menyimpan profil induk Kawasan Industri Pulogadung dan PT JIEP.

| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | ID unik |
| `name` | VARCHAR(255) | Nama kawasan |
| `slug` | VARCHAR(255) UNIQUE | Slug URL |
| `description` | TEXT | Gambaran umum |
| `manager_name` | VARCHAR(255) | Nama pengelola (PT JIEP) |
| `address` | TEXT | Alamat kantor |
| `area_hectares` | DECIMAL(10,2) | Luas lahan (433 Ha) |
| `established_year` | INT | Tahun berdiri (1973) |
| `established_date` | DATE | Tanggal pendirian (1973-06-26) |
| `ownership_pemprov_pct` | DECIMAL(5,2) | Porsi DKI Jakarta (53.06%) |
| `ownership_danareksa_pct` | DECIMAL(5,2) | Porsi Danareksa (46.94%) |
| `website` | VARCHAR(255) | Website resmi |
| `phone` | VARCHAR(255) | Kontak telepon utama |
| `phone_secondary` | VARCHAR(255) | Kanal layanan pelanggan |
| `latitude` | DECIMAL(10,8) NULL | Koordinat latitude terverifikasi |
| `longitude` | DECIMAL(11,8) NULL | Koordinat longitude terverifikasi |
| `verification_status` | ENUM | `verified`, `needs_verification`, `unverified` |
| `data_source` | VARCHAR(255) | Sumber data resmi |
| `source_url` | VARCHAR(255) | URL rujukan |
| `last_verified_at` | TIMESTAMP NULL | Waktu verifikasi terakhir |

---

## 2. Tabel `companies`
Menyimpan direktori perusahaan dan tenant kawasan.

| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | ID perusahaan |
| `industrial_estate_id` | BIGINT UNSIGNED FK | Relasi ke `industrial_estates` |
| `name` | VARCHAR(255) | Nama perusahaan |
| `slug` | VARCHAR(255) UNIQUE | Slug URL |
| `category` | VARCHAR(255) | Kategori bidang industri |
| `description` | TEXT | Profil bisnis |
| `address` | TEXT | Alamat di KIP |
| `website` | VARCHAR(255) | Website resmi perusahaan |
| `verification_status` | ENUM | `verified`, `needs_verification`, `unverified` |
| `data_source` | VARCHAR(255) | Rujukan dokumen verifikasi |
| `is_featured` | BOOLEAN | Perusahaan unggulan |
| `is_active` | BOOLEAN | Status aktif |

---

## 3. Tabel `facilities`
Menyimpan fasilitas sarana dan prasarana kawasan (11 kategori resmi JIEP).

| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED PK | ID fasilitas |
| `industrial_estate_id` | BIGINT UNSIGNED FK | Relasi ke `industrial_estates` |
| `name` | VARCHAR(255) | Nama fasilitas |
| `category` | VARCHAR(255) | Kategori fasilitas |
| `operational_status` | VARCHAR(255) | Status operasional |
| `data_source` | VARCHAR(255) | Sumber resmi |
| `verification_status` | ENUM | `verified`, `needs_verification`, `unverified` |

---

## 4. Tabel `complaints` & `complaint_status_histories`
Menyimpan laporan pengaduan masyarakat/tenant demonstrasi dan riwayat statusnya.

### `complaints`
- `complaint_number` (VARCHAR, UNIQUE): Format `IND-YYYYMMDD-XXXX`
- `title` (VARCHAR): Judul laporan
- `category` (VARCHAR): `infrastruktur`, `keamanan`, `kebersihan`, `administrasi`, `lainnya`
- `status` (ENUM): `diterima`, `ditinjau`, `diproses`, `selesai`, `ditolak`
- `is_demo` (BOOLEAN): Penanda data demonstrasi

### `complaint_status_histories`
- `complaint_id` (FK): Terhubung ke pengaduan
- `status` (ENUM): Status pada saat perubahan
- `note` (TEXT): Catatan tindak lanjut petugas demo

---

## 5. Tabel `activity_logs`
Menyimpan audit trail setiap mutasi data pada panel admin (Create, Update, Delete, Status Change).
