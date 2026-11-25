# 🏭 INDUSTRIA — Industrial Information & Digital Area
> **Digital Innovation for Industry** | Kawasan Industri Pulogadung (KIP)

INDUSTRIA adalah platform digital terintegrasi yang menyajikan informasi kawasan industri secara modern, transparan, dan terstruktur. Berfokus pada Kawasan Industri Pulogadung (KIP) yang dikelola oleh **PT Jakarta Industrial Estate Pulogadung (PT JIEP)**, platform ini mengintegrasikan direktori tenant terverifikasi, visualisasi geospasial interaktif OpenStreetMap, dan modul pengaduan demonstrasi dengan pelacakan status tiket.

---

## ✨ Fitur Utama

1. **Beranda Interaktif**: Hero section futuristik, ringkasan statistik kawasan, preview peta Leaflet, direktori perusahaan unggulan, warta dan pengumuman.
2. **Profil Kawasan KIP**: Profil sejarah 1973, luas 433 Ha, struktur kepemilikan saham (53,06% Pemprov DKI Jakarta dan 46,94% PT Danareksa), serta kontak resmi.
3. **Peta Geospasial Interaktif**: Peta digital berbasis Leaflet dan OpenStreetMap yang memfilter lokasi dengan koordinat terverifikasi (bebas error SSR).
4. **Direktori Perusahaan Terverifikasi**: Pencarian tenant dengan transparansi badge status verifikasi (`verified`, `needs_verification`, `unverified`).
5. **Fasilitas Kawasan**: Informasi 11 kategori fasilitas resmi yang tercantum dalam publikasi PT JIEP.
6. **Sistem Pengaduan Demonstrasi**: Formulir pengaduan dengan kode tiket unik otomatis (`IND-YYYYMMDD-XXXX`) dan penafian (disclaimer) demo yang jelas.
7. **Tracking Pengaduan**: Pelacakan status pengaduan dan riwayat tindak lanjut penanganan.
8. **Dashboard Admin Publik**: Dapat diakses langsung melalui `http://localhost:3000/admin` tanpa autentikasi/login sesuai ketentuan demonstrasi kompetisi.
9. **Audit Trail (Activity Logs)**: Pencatatan otomatis setiap aksi create, update, delete, dan perubahan status pengaduan.

---

## 🛠️ Arsitektur Teknologi

- **Frontend**: Nuxt 3, Vue 3, TypeScript, Tailwind CSS
- **Peta Digital**: Leaflet + OpenStreetMap (Client-side dynamic import)
- **Backend**: Laravel 11 REST API, PHP 8.3, Eloquent ORM, Request Validation
- **Database**: MySQL / MariaDB (`industria_db`)

---

## 🚀 Cara Menjalankan

### Backend:
```bash
cd C:\JIEP\backend
php artisan serve --host=127.0.0.1 --port=8000
```

### Frontend:
```bash
cd C:\JIEP\frontend
npm run dev
```

Akses aplikasi pada:
- **Publik**: `http://localhost:3000`
- **Admin**: `http://localhost:3000/admin`
