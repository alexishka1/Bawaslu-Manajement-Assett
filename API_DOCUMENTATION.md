# 🌐 BAWASLU Asset Management System - REST API Documentation (v1)

Dokumentasi resmi Application Programming Interface (API) untuk sistem Manajemen Aset (BMN) Badan Pengawas Pemilihan Umum (BAWASLU).

---

## 📌 Base Information

- **Base URL:** `/api/v1`
- **Default Headers:**
  ```http
  Accept: application/json
  Content-Type: application/json
  ```
- **Standard Success Response Format:**
  ```json
  {
    "success": true,
    "message": "Deskripsi sukses (opsional)",
    "data": { ... }
  }
  ```
- **Standard Error Response Format:**
  ```json
  {
    "success": false,
    "message": "Pesan deskripsi kegagalan",
    "error": "KODE_ERROR"
  }
  ```

---

## 🔐 1. Autentikasi (`/auth`)

### 1.1 Login Pengguna
- **Method:** `POST`
- **Endpoint:** `/auth/login`
- **Rate Limit:** 10 requests / menit
- **Request Body:**
  ```json
  {
    "email": "staff@bawaslu.go.id",
    "password": "password123"
  }
  ```
- **Response 200 OK:**
  ```json
  {
    "success": true,
    "message": "Autentikasi berhasil.",
    "data": {
      "user": {
        "id": 1,
        "name": "Staff Lapangan",
        "email": "staff@bawaslu.go.id",
        "role": "staff"
      }
    }
  }
  ```
- **Response 401 Unauthorized:**
  ```json
  {
    "success": false,
    "message": "Email atau password salah.",
    "error": "INVALID_CREDENTIALS"
  }
  ```

### 1.2 Profil Pengguna Saat Ini
- **Method:** `GET`
- **Endpoint:** `/auth/me`

### 1.3 Logout
- **Method:** `POST`
- **Endpoint:** `/auth/logout`

---

## 📦 2. Manajemen Aset BMN (`/items`)

### 2.1 Daftar Aset (Paginated & Filtered)
- **Method:** `GET`
- **Endpoint:** `/items`
- **Query Parameters:**
  - `search` (string, opsional): Pencarian nama barang, kode BMN, lokasi
  - `kategori` (string, opsional): `Elektronik`, `ATK`, `Kendaraan`, `Mebel`, `Arsip`
  - `status` (string, opsional): `tersedia`, `terpakai`, `servis`, `rusak`
  - `per_page` (int, default: 15)
- **Response 200 OK:**
  ```json
  {
    "success": true,
    "data": [
      {
        "id": 1,
        "kode_bmn": "BMN-ELK-001",
        "nama_barang": "Laptop HP ProBook",
        "kategori": "Elektronik",
        "lokasi_simpan": "Gudang Lt. 2",
        "status": "tersedia",
        "qr_code": "http://localhost:8000/scan/BMN-ELK-001"
      }
    ],
    "meta": {
      "current_page": 1,
      "last_page": 1,
      "per_page": 15,
      "total": 1
    }
  }
  ```

### 2.2 Scan QR Code Aset (Mobile Scanner)
- **Method:** `GET`
- **Endpoint:** `/items/scan/{kode_bmn}`
- **Contoh:** `/api/v1/items/scan/BMN-ELK-001`
- **Response 200 OK:**
  ```json
  {
    "success": true,
    "data": {
      "id": 1,
      "kode_bmn": "BMN-ELK-001",
      "nama_barang": "Laptop HP ProBook",
      "kategori": "Elektronik",
      "lokasi_simpan": "Gudang Lt. 2",
      "status": "tersedia",
      "transactions": [...]
    }
  }
  ```
- **Response 404 Not Found:**
  ```json
  {
    "success": false,
    "message": "Barang dengan kode BMN 'BMN-XXX' tidak ditemukan.",
    "error": "ITEM_NOT_FOUND"
  }
  ```

### 2.3 Tambah Aset Baru (Admin Only)
- **Method:** `POST`
- **Endpoint:** `/items`
- **Request Body:**
  ```json
  {
    "kode_bmn": "BMN-ELK-002",
    "nama_barang": "Scanner Fujitsu ScanSnap",
    "kategori": "Elektronik",
    "lokasi_simpan": "Ruang IT",
    "status": "tersedia"
  }
  ```

---

## 📋 3. Laporan Kondisi & Audit Lapangan (`/reports`)

### 3.1 Ringkasan Statistik Aset (Dashboard Metrics)
- **Method:** `GET`
- **Endpoint:** `/reports/summary`
- **Response 200 OK:**
  ```json
  {
    "success": true,
    "data": {
      "total_items": 45,
      "tersedia": 32,
      "terpakai": 8,
      "servis": 3,
      "rusak": 2,
      "laporan_menunggu": 4,
      "total_transaksi": 52
    }
  }
  ```

### 3.2 Kirim Laporan Audit Lapangan (Upload Foto)
- **Method:** `POST`
- **Endpoint:** `/reports`
- **Content-Type:** `multipart/form-data`
- **Payload:**
  - `kode_bmn` (string, required): Kode BMN barang yang diaudit
  - `kondisi_aktual` (string, required): `tersedia` | `terpakai` | `servis` | `rusak` | `hilang`
  - `catatan` (string, optional): Keterangan kerusakan / kondisi fisik
  - `foto_bukti` (file image, required, max 5MB): Foto fisik barang
- **Response 201 Created:**
  ```json
  {
    "success": true,
    "message": "Laporan fisik aset berhasil dikirim, menunggu validasi administrator.",
    "data": {
      "id": 12,
      "item_id": 1,
      "user_id": 2,
      "kondisi_aktual": "rusak",
      "catatan": "Konektor power longgar",
      "foto_bukti": "reports/xyz.jpg",
      "status_validasi": "menunggu"
    }
  }
  ```

---

## 🔒 Security & Rate Limiting

- Login Endpoint: Maksimal 10 percobaan per menit (`throttle:10,1`)
- Laporan Endpoint: Maksimal 30 unggahan per menit (`throttle:30,1`)
- Dokumen BAST & QR Code: Dilindungi autorisasi peran Admin (`Role: admin`).
