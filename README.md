# Tani Monitoring — AIoT Smart Farming & Marketplace Melon

Dokumentasi ini menjelaskan struktur, konfigurasi, dan alur pengembangan sementara untuk aplikasi **Tani Monitoring**, yaitu website berbasis **Laravel 13 + Tailwind CSS** yang digunakan untuk monitoring kualitas tanah dan air berbasis AIoT serta pengelolaan produk pertanian kelompok tani.

Dokumentasi ini dibuat sampai tahap pengembangan **Manajemen Produk**. Jika fitur berikutnya seperti cart, checkout, pembayaran, tracking pesanan, review, dan laporan sudah selesai, file README ini dapat diperbarui kembali.

---

## 1. Ringkasan Project

**Tani Monitoring** adalah aplikasi web yang dikembangkan untuk dua kebutuhan utama:

1. **Monitoring kualitas tanah dan air berbasis AIoT**
   - Menerima data sensor dari perangkat IoT.
   - Menyimpan data monitoring ke database.
   - Menampilkan data terbaru pada dashboard monitoring.
   - Mendukung pembaruan realtime menggunakan Laravel Reverb dan Laravel Echo.
   - Menampilkan grafik tren monitoring agar perubahan parameter dapat dipantau secara berkala.

2. **Marketplace produk pertanian**
   - Mengelola produk hasil pertanian, khususnya produk melon.
   - Menyimpan data produk, stok, harga, foto, status, dan SEO produk.
   - Menjadi fondasi untuk fitur katalog publik, keranjang, checkout, pembayaran, dan review produk.

---

## 2. Tech Stack

Project ini menggunakan stack berikut:

| Kebutuhan | Teknologi |
|---|---|
| Backend Framework | Laravel 13 |
| Frontend Template | Blade |
| Styling | Tailwind CSS |
| Authentication | Laravel Fortify |
| Database | MySQL |
| Realtime Server | Laravel Reverb |
| Frontend Realtime Client | Laravel Echo + Pusher JS |
| Chart Monitoring | Chart.js |
| Asset Bundler | Vite |
| Image Storage | Laravel Public Storage |

---

## 3. Standar UI/UX Project

Seluruh tampilan dashboard, tabel, form, card, dan halaman internal mengikuti pola desain berikut:

| Elemen | Standar |
|---|---|
| Primary color | `green-700` |
| Background utama | `slate-50` |
| Card background | `white` |
| Border | `slate-200` |
| Text utama | `slate-900` / `slate-950` |
| Text sekunder | `slate-500` / `slate-600` |
| Radius card | `rounded-2xl` / `rounded-3xl` |
| Radius sidebar/menu/form kecil | `rounded-lg` / `rounded-xl` |
| Shadow | `shadow-sm` |
| Container | `max-w-7xl px-6` |

Catatan desain:
- Sidebar menggunakan posisi fixed agar navigasi tetap stabil saat halaman di-scroll.
- Area menu sidebar dapat di-scroll secara mandiri.
- Tombol logout tetap berada di bagian bawah sidebar dan tidak perlu dicari dengan scroll panjang.
- Dashboard monitoring menggunakan kombinasi kartu ringkasan, data terbaru, grafik tren, dan tabel riwayat.
- Tabel hanya digunakan sebagai log teknis, sedangkan grafik digunakan sebagai elemen utama untuk membaca tren.

---

## 4. Status Tahap Pengembangan

Dokumentasi ini mencakup tahap berikut:

| Tahap | Status | Keterangan |
|---|---|---|
| Tahap 1 — Setup Project | Selesai | Setup database, Tailwind, Fortify, layout Blade dasar |
| Tahap 2 — User dan Role | Selesai | Role `admin`, `owner`, `buyer`, middleware role, dashboard kosong |
| Tahap 3 — Device dan Monitoring | Selesai | Tabel device, soil readings, water readings, API IoT, dashboard monitoring |
| Tahap 4 — Real-Time | Selesai | Laravel Reverb, event broadcast, Laravel Echo |
| Tahap 5 — Manajemen Device | Selesai | CRUD device, reset API key, toggle status, detail device |
| Tahap 6 — Manajemen Produk | Selesai | CRUD produk, upload gambar, kategori, stok, harga, SEO produk |

Tahap berikutnya yang belum final:
- Katalog publik produk
- Cart dan checkout
- Pembayaran
- Tracking pesanan
- Review produk
- Notifikasi transaksi
- Laporan penjualan dan monitoring
- Manajemen konten landing page

---

## 5. Role dan Hak Akses

Aplikasi menggunakan tiga role utama:

| Role | Fungsi |
|---|---|
| `admin` | Mengelola seluruh sistem, user, device, produk, monitoring, transaksi, konten, dan laporan |
| `owner` | Mengelola produk, pesanan, pembayaran, chat pembeli, dan notifikasi |
| `buyer` | Melihat katalog, membeli produk, checkout, pembayaran, tracking pesanan, review, dan notifikasi |

Alur redirect dashboard:

```text
/admin/dashboard   → Admin
/owner/dashboard   → Owner
/buyer/dashboard   → Buyer
/dashboard         → Redirect otomatis sesuai role
```

---

## 6. Struktur Folder Utama

Struktur folder yang digunakan atau disarankan:

```text
app/
├── Events/
│   ├── SoilReadingCreated.php
│   └── WaterReadingCreated.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AdminDashboardController.php
│   │   │   └── DeviceController.php
│   │   ├── Api/
│   │   │   └── IoT/
│   │   │       ├── SoilReadingApiController.php
│   │   │       └── WaterReadingApiController.php
│   │   ├── Buyer/
│   │   │   └── BuyerDashboardController.php
│   │   ├── Monitoring/
│   │   │   └── MonitoringDashboardController.php
│   │   ├── Owner/
│   │   │   └── OwnerDashboardController.php
│   │   ├── Product/
│   │   │   └── ProductManagementController.php
│   │   ├── Public/
│   │   │   └── HomeController.php
│   │   └── DashboardRedirectController.php
│   ├── Middleware/
│   │   ├── RoleMiddleware.php
│   │   └── DeviceApiKeyMiddleware.php
│   └── Requests/
│       ├── Device/
│       │   ├── StoreDeviceRequest.php
│       │   └── UpdateDeviceRequest.php
│       ├── Monitoring/
│       │   ├── StoreSoilReadingRequest.php
│       │   └── StoreWaterReadingRequest.php
│       └── Product/
│           ├── StoreProductRequest.php
│           └── UpdateProductRequest.php
├── Models/
│   ├── Device.php
│   ├── SoilReading.php
│   ├── WaterReading.php
│   ├── Product.php
│   ├── ProductCategory.php
│   └── User.php
└── Services/
    ├── Device/
    │   └── DeviceApiKeyService.php
    ├── Monitoring/
    │   └── MonitoringStatusService.php
    └── Product/
        ├── ProductService.php
        └── ProductCatalogService.php
```

Struktur view:

```text
resources/views/
├── admin/
│   ├── dashboard.blade.php
│   └── devices/
│       ├── index.blade.php
│       ├── create.blade.php
│       ├── edit.blade.php
│       ├── show.blade.php
│       └── _form.blade.php
├── buyer/
│   └── dashboard.blade.php
├── components/
│   ├── layouts/
│   │   ├── dashboard.blade.php
│   │   ├── footer.blade.php
│   │   ├── public.blade.php
│   │   └── sidebar.blade.php
│   └── monitoring/
│       └── metric.blade.php
├── monitoring/
│   └── dashboard.blade.php
├── owner/
│   └── dashboard.blade.php
├── products/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── show.blade.php
│   └── _form.blade.php
└── public/
    ├── home.blade.php
    └── products/
        ├── index.blade.php
        └── show.blade.php
```

---

## 7. Database Tables

Tabel yang digunakan sampai tahap ini:

### 7.1 Users

Digunakan untuk authentication dan role access.

Kolom tambahan penting:
- `phone`
- `role`
- `status`

Role:

```text
admin
owner
buyer
```

Status:

```text
active
inactive
```

### 7.2 Devices

Menyimpan data perangkat IoT.

Kolom utama:
- `device_code`
- `name`
- `type`
- `location_name`
- `latitude`
- `longitude`
- `api_key_hash`
- `status`
- `last_seen_at`
- `created_by`

Tipe device:

```text
soil
water
mixed
```

Status device:

```text
active
inactive
maintenance
```

### 7.3 Soil Readings

Menyimpan data monitoring tanah.

Kolom utama:
- `device_id`
- `nitrogen`
- `phosphorus`
- `potassium`
- `temperature`
- `moisture`
- `ph`
- `ec`
- `latitude`
- `longitude`
- `status`
- `recorded_at`
- `raw_payload`

Status monitoring:

```text
normal
warning
danger
offline
```

### 7.4 Water Readings

Menyimpan data monitoring air.

Kolom utama:
- `device_id`
- `ph`
- `tds`
- `ec`
- `battery`
- `latitude`
- `longitude`
- `status`
- `recorded_at`
- `raw_payload`

### 7.5 Product Categories

Menyimpan kategori produk.

Kolom utama:
- `name`
- `slug`
- `description`
- `status`

### 7.6 Products

Menyimpan produk marketplace.

Kolom utama:
- `owner_id`
- `category_id`
- `name`
- `slug`
- `sku`
- `short_description`
- `description`
- `price`
- `stock`
- `unit`
- `minimum_order`
- `harvest_date`
- `main_image`
- `status`
- `is_featured`
- `meta_title`
- `meta_description`

Status produk:

```text
draft
active
inactive
out_of_stock
```

---

## 8. Instalasi Project

### 8.1 Clone Repository

```bash
git clone <repository-url>
cd <nama-folder-project>
```

### 8.2 Install Dependency PHP

```bash
composer install
```

### 8.3 Install Dependency Node

```bash
npm install
```

### 8.4 Copy Environment

```bash
cp .env.example .env
```

### 8.5 Generate App Key

```bash
php artisan key:generate
```

### 8.6 Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tani_monitoring
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan nama database, username, dan password dengan konfigurasi lokal.

### 8.7 Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

Jika masih dalam tahap development dan database boleh di-reset:

```bash
php artisan migrate:fresh --seed
```

### 8.8 Buat Storage Link

```bash
php artisan storage:link
```

Perintah ini diperlukan agar gambar produk yang tersimpan di `storage/app/public` dapat diakses melalui browser.

### 8.9 Jalankan Development Server

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

---

## 9. Konfigurasi Laravel Reverb

Realtime monitoring menggunakan Laravel Reverb.

### 9.1 Install Reverb

Jika belum diinstall:

```bash
php artisan install:broadcasting --reverb
```

Alternatif manual:

```bash
composer require laravel/reverb
php artisan reverb:install
npm install --save-dev laravel-echo pusher-js
```

### 9.2 Konfigurasi `.env`

```env
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=local-app-id
REVERB_APP_KEY=local-app-key
REVERB_APP_SECRET=local-app-secret
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

### 9.3 Jalankan Reverb

Terminal 3:

```bash
php artisan reverb:start --debug
```

Saat development, idealnya ada 3 terminal aktif:

```text
Terminal 1 → php artisan serve
Terminal 2 → npm run dev
Terminal 3 → php artisan reverb:start --debug
```

---

## 10. Konfigurasi Frontend Realtime

File utama:

```text
resources/js/app.js
```

Konfigurasi minimal:

```js
import './bootstrap';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Chart from 'chart.js/auto';

window.Pusher = Pusher;
window.Chart = Chart;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https',
    enabledTransports: ['ws', 'wss'],
});
```

---

## 11. API IoT

API IoT digunakan oleh device untuk mengirim data sensor ke server.

### 11.1 Header Wajib

Setiap request dari device wajib mengirim header:

```text
Accept: application/json
Content-Type: application/json
X-Device-Code: <kode-device>
X-Device-Key: <api-key-device>
```

Contoh:

```text
X-Device-Code: SOIL-001
X-Device-Key: demo-iot-key-123
```

### 11.2 Endpoint Monitoring Tanah

```text
POST /api/v1/iot/soil-readings
```

Contoh JSON:

```json
{
  "nitrogen": 35,
  "phosphorus": 20,
  "potassium": 45,
  "temperature": 30,
  "moisture": 65,
  "ph": 6.7,
  "ec": 1200,
  "latitude": -7.197,
  "longitude": 113.239
}
```

Contoh response berhasil:

```json
{
  "message": "Data monitoring tanah berhasil disimpan.",
  "data": {
    "id": 1,
    "device_code": "SOIL-001",
    "status": "normal",
    "recorded_at": "2026-05-22 12:30:00"
  }
}
```

### 11.3 Endpoint Monitoring Air

```text
POST /api/v1/iot/water-readings
```

Contoh JSON:

```json
{
  "ph": 6.4,
  "tds": 760,
  "ec": 1300,
  "battery": 92,
  "latitude": -7.197,
  "longitude": 113.239
}
```

Contoh response berhasil:

```json
{
  "message": "Data monitoring air berhasil disimpan.",
  "data": {
    "id": 1,
    "device_code": "WATER-001",
    "status": "normal",
    "recorded_at": "2026-05-22 12:30:00"
  }
}
```

---

## 12. Dashboard Monitoring

Dashboard monitoring dapat diakses oleh:

```text
admin
owner
```

Route:

```text
GET /monitoring
```

Endpoint pendukung dashboard:

```text
GET /monitoring/latest
GET /monitoring/chart-data
```

Fitur dashboard monitoring:
- Ringkasan jumlah device
- Jumlah device online
- Status terbaru tanah
- Status terbaru air
- Data terbaru monitoring tanah
- Data terbaru monitoring air
- Grafik tren tanah
- Grafik tren air
- Riwayat record terakhir

Grafik monitoring menggunakan Chart.js dan diperbarui melalui event realtime:
- `SoilReadingCreated`
- `WaterReadingCreated`

---

## 13. Manajemen Device

Manajemen device hanya dapat diakses oleh admin.

Route utama:

```text
GET    /admin/devices
GET    /admin/devices/create
POST   /admin/devices
GET    /admin/devices/{device}
GET    /admin/devices/{device}/edit
PUT    /admin/devices/{device}
DELETE /admin/devices/{device}
PATCH  /admin/devices/{device}/rotate-key
PATCH  /admin/devices/{device}/toggle-status
```

Fitur:
- Melihat daftar device
- Filter device berdasarkan search, tipe, dan status
- Menambah device baru
- Edit device
- Detail device
- Melihat riwayat tanah dan air per device
- Reset API key
- Aktif/nonaktifkan device
- Hapus device jika belum memiliki data monitoring

Catatan keamanan:
- API key asli hanya muncul saat device dibuat atau saat reset API key.
- Database hanya menyimpan `api_key_hash`.
- Jika API key hilang, admin harus melakukan reset API key.

---

## 14. Manajemen Produk

Manajemen produk dapat diakses oleh admin dan owner.

Admin:

```text
GET    /admin/products
GET    /admin/products/create
POST   /admin/products
GET    /admin/products/{product}
GET    /admin/products/{product}/edit
PUT    /admin/products/{product}
DELETE /admin/products/{product}
```

Owner:

```text
GET    /owner/products
GET    /owner/products/create
POST   /owner/products
GET    /owner/products/{product}
GET    /owner/products/{product}/edit
PUT    /owner/products/{product}
DELETE /owner/products/{product}
```

Fitur:
- Melihat daftar produk
- Search produk berdasarkan nama, SKU, dan deskripsi
- Filter berdasarkan kategori dan status
- Tambah produk
- Edit produk
- Upload gambar produk
- Detail produk
- Hapus produk
- Pengaturan produk unggulan
- Pengaturan meta title dan meta description untuk SEO

Akses:
- Admin dapat melihat seluruh produk.
- Owner hanya dapat melihat produk miliknya sendiri.

---

## 15. Seeder

Seeder yang digunakan:

```text
UserRoleSeeder
DeviceSeeder
ProductCategorySeeder
```

Contoh akun testing yang dapat digunakan jika tersedia di seeder:

```text
Admin
Email    : admin@gmail.com
Password : @admin123

Owner
Email    : owner@gmail.com
Password : @owner123

Buyer
Email    : buyer@gmail.com
Password : @buyer123
```

Jika nama seeder berbeda, sesuaikan daftar seeder di `DatabaseSeeder.php`.

---

## 16. Testing API dengan Postman atau Bruno

### 16.1 Test Data Tanah

Method:

```text
POST
```

URL:

```text
http://127.0.0.1:8000/api/v1/iot/soil-readings
```

Headers:

```text
Accept: application/json
Content-Type: application/json
X-Device-Code: SOIL-001
X-Device-Key: demo-iot-key-123
```

Body JSON:

```json
{
  "nitrogen": 38,
  "phosphorus": 21,
  "potassium": 47,
  "temperature": 31,
  "moisture": 68,
  "ph": 6.8,
  "ec": 1220,
  "latitude": -7.197,
  "longitude": 113.239
}
```

### 16.2 Test Data Air

Method:

```text
POST
```

URL:

```text
http://127.0.0.1:8000/api/v1/iot/water-readings
```

Headers:

```text
Accept: application/json
Content-Type: application/json
X-Device-Code: WATER-001
X-Device-Key: demo-iot-key-123
```

Body JSON:

```json
{
  "ph": 6.5,
  "tds": 780,
  "ec": 1320,
  "battery": 90,
  "latitude": -7.197,
  "longitude": 113.239
}
```

---

## 17. Testing Fitur Produk

Checklist testing produk:

```text
[ ] Login sebagai admin
[ ] Buka /admin/products
[ ] Tambah produk baru
[ ] Upload gambar produk
[ ] Isi harga, stok, kategori, dan status
[ ] Simpan produk
[ ] Buka detail produk
[ ] Edit produk
[ ] Hapus produk

[ ] Login sebagai owner
[ ] Buka /owner/products
[ ] Tambah produk sebagai owner
[ ] Pastikan owner hanya melihat produk miliknya
```

---

## 18. Command Penting Development

Clear cache:

```bash
php artisan optimize:clear
```

Jalankan migration:

```bash
php artisan migrate
```

Reset database development:

```bash
php artisan migrate:fresh --seed
```

Jalankan seeder tertentu:

```bash
php artisan db:seed --class=ProductCategorySeeder
```

Lihat daftar route:

```bash
php artisan route:list
```

Jalankan Laravel:

```bash
php artisan serve
```

Jalankan Vite:

```bash
npm run dev
```

Build asset production:

```bash
npm run build
```

Jalankan Reverb:

```bash
php artisan reverb:start --debug
```

Buat storage link:

```bash
php artisan storage:link
```

---

## 19. Troubleshooting

### 19.1 API IoT Mengembalikan 401

Kemungkinan penyebab:
- Header `X-Device-Code` tidak dikirim.
- Header `X-Device-Key` tidak dikirim.
- Device code salah.
- API key salah.
- Device belum dibuat.
- API key sudah di-reset.

Solusi:
- Cek data device di `/admin/devices`.
- Reset API key jika diperlukan.
- Pastikan device status `active`.

### 19.2 API IoT Mengembalikan 403

Kemungkinan penyebab:
- Device berstatus `inactive` atau `maintenance`.

Solusi:
- Aktifkan device dari halaman manajemen device.

### 19.3 API IoT Mengembalikan 422

Kemungkinan penyebab:
- Format data tidak valid.
- `ph` di luar rentang 0–14.
- Latitude/longitude tidak valid.
- Status tidak sesuai enum.

Solusi:
- Cek kembali body JSON.
- Pastikan request menggunakan `Content-Type: application/json`.

### 19.4 Realtime Tidak Berjalan

Kemungkinan penyebab:
- `php artisan reverb:start --debug` belum berjalan.
- `BROADCAST_CONNECTION` bukan `reverb`.
- `npm run dev` belum dijalankan ulang setelah mengubah `app.js`.
- User belum login sebagai admin/owner.
- `/broadcasting/auth` mengembalikan 403.

Solusi:
- Jalankan ulang server Laravel, Vite, dan Reverb.
- Cek `.env`.
- Cek `routes/channels.php`.
- Cek browser console.

### 19.5 Chart Tidak Muncul

Kemungkinan penyebab:
- Chart.js belum diinstall.
- `window.Chart` belum tersedia.
- `npm run dev` belum dijalankan ulang.
- Endpoint `/monitoring/chart-data` belum dibuat.
- Belum ada data sensor di database.

Solusi:
- Jalankan `npm install chart.js`.
- Pastikan `import Chart from 'chart.js/auto';` ada di `resources/js/app.js`.
- Kirim data sensor via Postman/Bruno.
- Cek browser console.

### 19.6 Upload Gambar Produk Tidak Tampil

Kemungkinan penyebab:
- `php artisan storage:link` belum dijalankan.
- File tidak tersimpan di disk `public`.
- Path gambar salah.
- Permission folder storage bermasalah.

Solusi:
- Jalankan `php artisan storage:link`.
- Cek folder `storage/app/public/products`.
- Pastikan accessor `main_image_url` pada model `Product` sudah benar.

---

## 20. Prinsip Arsitektur yang Dipakai

Project ini mengikuti prinsip berikut:

1. **Controller tetap tipis**
   - Controller bertugas menerima request, memanggil service, dan mengembalikan response.

2. **Validasi dipisah ke Form Request**
   - Request seperti `StoreProductRequest`, `UpdateProductRequest`, `StoreSoilReadingRequest`, dan `StoreWaterReadingRequest` digunakan agar validasi tidak menumpuk di controller.

3. **Business logic masuk ke Service**
   - API key device dikelola oleh `DeviceApiKeyService`.
   - Status monitoring dikelola oleh `MonitoringStatusService`.
   - Produk, slug, dan upload gambar dikelola oleh `ProductService`.

4. **Query penting memakai eager loading**
   - Produk memakai relasi `owner` dan `category`.
   - Monitoring memakai relasi `device`.
   - Tujuannya menghindari N+1 query.

5. **Data realtime tetap disimpan di database**
   - Reverb hanya untuk distribusi event realtime.
   - Database tetap menjadi sumber data utama.

6. **API key tidak disimpan dalam bentuk asli**
   - Database hanya menyimpan hash API key.
   - API key asli hanya ditampilkan saat dibuat atau di-reset.

7. **UI dibuat konsisten**
   - Pola warna, radius, border, shadow, dan container digunakan konsisten di semua halaman.

---

## 21. Roadmap Lanjutan

Tahap berikutnya yang direkomendasikan:

### Tahap 7 — Katalog Produk Publik
- Halaman katalog produk publik
- Detail produk berbasis slug
- Filter kategori dan search
- SEO meta title dan meta description
- Tombol login untuk membeli

### Tahap 8 — Cart dan Checkout
- Keranjang belanja
- Tambah produk ke keranjang
- Validasi stok
- Checkout
- Ringkasan order

### Tahap 9 — Pembayaran
- Upload bukti pembayaran
- Status pembayaran
- Verifikasi pembayaran oleh owner/admin

### Tahap 10 — Tracking Pesanan
- Status pesanan tanpa pengiriman/logistik penuh
- Status: pending, waiting payment, paid, processing, ready, completed, cancelled

### Tahap 11 — Review Produk
- Review produk oleh pembeli
- Rating produk
- Moderasi review

### Tahap 12 — Manajemen Konten
- Profil kelompok tani
- Proses budidaya melon
- Galeri kegiatan
- About/kontak
- Landing page dinamis

### Tahap 13 — Laporan
- Laporan monitoring
- Laporan produk
- Laporan transaksi
- Export PDF/Excel

---

## 22. Catatan Pengembangan

- Gunakan branch Git terpisah untuk setiap tahap besar.
- Jalankan `php artisan route:list` setelah menambah route baru.
- Jalankan `php artisan optimize:clear` setelah mengubah config, route, event, atau broadcasting.
- Hindari menyimpan credential asli di repository.
- Jangan commit file `.env`.
- Gunakan `.env.example` untuk dokumentasi konfigurasi environment.
- Pastikan setiap fitur baru punya validasi Form Request.
- Hindari query berat tanpa pagination.
- Hindari menampilkan ribuan data sensor langsung di Blade.
- Gunakan chart untuk tren dan tabel untuk log teknis.
- Dokumentasi ini perlu diperbarui setelah fitur cart, checkout, pembayaran, dan laporan selesai.

---

## 23. Lisensi

Project ini dikembangkan untuk kebutuhan sistem monitoring AIoT dan marketplace produk pertanian. Informasi lisensi dapat disesuaikan dengan kebijakan institusi atau pemilik project.
