# 📚 Dokumentasi REST API — INDUSTRIA

Base URL: `http://127.0.0.1:8000/api/v1`

---

## 1. Kawasan Industri & Statistik

### `GET /industrial-estate`
Mengambil data profil utama Kawasan Industri Pulogadung.
- **Response `200 OK`**:
```json
{
  "data": {
    "name": "Kawasan Industri Pulogadung",
    "manager_name": "PT Jakarta Industrial Estate Pulogadung (PT JIEP)",
    "area_hectares": "433.00",
    "established_year": 1973,
    "established_date": "1973-06-26",
    "ownership_pemprov_pct": "53.06",
    "ownership_danareksa_pct": "46.94",
    "verification_status": "verified"
  }
}
```

### `GET /industrial-estate/stats`
Mengambil metrik ringkas statistik kawasan untuk dashboard dan beranda.

---

## 2. Geospasial & Peta Digital

### `GET /map/locations`
Mengambil seluruh titik lokasi dengan koordinat yang telah diverifikasi (OpenStreetMap compatible).
- **Query Params**:
  - `type` (optional): `estate`, `company`, `facility`, `access`

### `GET /map/filters`
Mengambil kategori filter untuk antarmuka peta interaktif.

---

## 3. Direktori Perusahaan

### `GET /companies`
Daftar tenant/perusahaan di kawasan industri dengan fitur pencarian dan paginasi.
- **Query Params**:
  - `search`: kata kunci pencarian
  - `category`: kategori industri
  - `verification_status`: `verified`, `needs_verification`, `unverified`
  - `per_page`: jumlah data per halaman (default: 15)

### `GET /companies/{id}`
Detail profil perusahaan beserta status verifikasi dan data sumber.

### `POST /admin/companies` (Admin — Demo)
Menambah perusahaan baru.

### `PUT /admin/companies/{id}` (Admin — Demo)
Memperbarui data perusahaan.

### `DELETE /admin/companies/{id}` (Admin — Demo)
Menghapus data perusahaan.

---

## 4. Fasilitas Kawasan

### `GET /facilities`
Daftar sarana & fasilitas kawasan industri (11 kategori resmi JIEP).

### `GET /facilities/{id}`
Detail fasilitas tertentu.

### `POST /admin/facilities` (Admin — Demo)
Menambah fasilitas baru.

### `PUT /admin/facilities/{id}` (Admin — Demo)
Memperbarui data fasilitas.

### `DELETE /admin/facilities/{id}` (Admin — Demo)
Menghapus fasilitas.

---

## 5. Sistem Pengaduan Demonstrasi

### `POST /complaints`
Mengirimkan laporan pengaduan demonstrasi.
- **Request Body**:
```json
{
  "title": "Penerangan Jalan Redup",
  "category": "infrastruktur",
  "description": "Lampu penerangan jalan di sekitar Jl. Pulobuaran redup saat malam hari.",
  "location": "Jl. Pulobuaran Blok JJ",
  "reporter_name": "Anonim"
}
```
- **Response `201 Created`**:
```json
{
  "complaint_number": "IND-20261124-0001",
  "message": "Pengaduan berhasil dikirim.",
  "disclaimer": "Pengaduan ini hanya tersimpan dalam sistem demonstrasi INDUSTRIA dan TIDAK dikirim ke PT JIEP."
}
```

### `GET /complaints/track/{number}`
Melacak status dan histori tindakan penanganan pengaduan berdasarkan nomor tiket.

### `PATCH /admin/complaints/{id}/status` (Admin — Demo)
Memperbarui status pengaduan: `diterima`, `ditinjau`, `diproses`, `selesai`, `ditolak`.

---

## 6. Lowongan Kerja & Pengumuman

### `GET /jobs`
Daftar lowongan kerja terverifikasi di kawasan.

### `GET /announcements`
Daftar warta dan pengumuman operasional.
