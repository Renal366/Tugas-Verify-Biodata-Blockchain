# 📘 Sistem Verifikasi Dokumen Biodata Digital

Sistem berbasis web untuk memverifikasi keaslian dokumen menggunakan hashing SHA-256. Cocok untuk pemula yang ingin belajar web development dengan PHP.

## 🎯 Untuk Siapa?

- Pemula yang baru belajar pemrograman web
- Belum familiar dengan XAMPP/PHP
- Ingin mencoba sistem verifikasi dokumen dari nol

## ✨ Fitur Utama

- ✅ Upload dokumen (PDF, DOCX, PPTX, dll)
- ✅ Hashing SHA-256 otomatis
- ✅ Verifikasi keaslian dokumen
- ✅ Interface user-friendly
- ✅ Responsif dan mudah digunakan

## 🚀 Quick Start

### 1. Install XAMPP

#### Windows:
1. Download dari [Apache Friends](https://www.apachefriends.org)
2. Jalankan installer
3. Pilih folder default: `C:\xampp`
4. Centang semua komponen (Apache, MySQL, PHP, phpMyAdmin)
5. Selesaikan instalasi

#### macOS:
1. Download XAMPP
2. Drag ke folder Applications
3. Jalankan dari Applications

#### Linux:
```bash
sudo apt-get update
sudo apt-get install apache2 php libapache2-mod-php mysql-server phpmyadmin
```

### 2. Jalankan XAMPP

**Windows/macOS:**
1. Buka XAMPP Control Panel
2. Klik tombol "Start" di sebelah Apache
3. Background Apache akan menjadi hijau ✓

**Verifikasi:**
- Buka browser → ketik `http://localhost`
- Jika muncul halaman XAMPP, berarti berhasil!

### 3. Setup Proyek

Pilih salah satu cara:

**Cara 1: Download dari GitHub**
```bash
1. Download ZIP dari repository
2. Extract ke folder
3. Copy folder ke:
   - Windows: C:\xampp\htdocs\hashing-dokumen
   - macOS: /Applications/XAMPP/htdocs/hashing-dokumen
   - Linux: /var/www/html/hashing-dokumen
```

**Cara 2: Buat Manual**
1. Buka folder `htdocs`
2. Buat folder baru: `hashing-dokumen` (Folder bebas ini contoh saja) 
3. Di dalam folder, buat file:
   - `upload.php`
   - `verify.php`
   - `style.css`
4. Copy kode ke masing-masing file
5. Buat folder: `storage`

### 4. Test Sistem

**Test 1: Akses Halaman**
```
http://localhost/hashing-dokumen/upload.php
```
Jika muncul form upload → ✓ Berhasil!

**Test 2: Upload Dokumen**
- Pilih file PDF/DOCX/PPTX
- Klik "Register Document"
- Jika muncul hash SHA-256 → ✓ Berhasil!

**Test 3: Verifikasi**
- Buka `http://localhost/hashing-dokumen/verify.php`
- Upload file yang sama → Harus muncul "DOKUMEN ASLI"
- Upload file berbeda → Harus muncul "DOKUMEN PALSU"

## 🛠️ Troubleshooting

### ❌ Localhost tidak bisa diakses
```
Solusi:
1. Cek XAMPP Control Panel, pastikan Apache hijau
2. Buka Command Prompt → ping localhost
3. Coba: 127.0.0.1/hashing-dokumen/upload.php
```

### ❌ Error saat upload file
```
Solusi:
1. Pastikan folder "storage" ada
2. Klik kanan folder → Properties → Security
3. Beri full control untuk folder
```

### ❌ File tidak bisa disimpan (Linux/macOS)
```bash
chmod 777 /opt/lampp/htdocs/hashing-dokumen/storage
```

### ❌ Tampilan berantakan
```
Solusi:
1. Pastikan file style.css ada di folder proyek
2. Tekan F12 di browser → Console
3. Lihat apakah ada error loading CSS
```

## 📚 Penjelasan Konsep

### Bagaimana Cara Kerja?

```
Upload File
    ↓
Sistem membaca isi file
    ↓
Hitung "sidik jari digital" (SHA-256 Hash)
    ↓
Simpan ke original_hash.txt
    ↓
Verifikasi: Hitung hash file baru & bandingkan
    ↓
Jika sama → DOKUMEN ASLI
Jika beda → DOKUMEN PALSU/BERUBAH
```

### Analogi Sederhana

| Konsep | Analogi |
|--------|---------|
| File | Dokumen fisik |
| Hash | Cap/stempel basah |
| Verifikasi | Cocokkan cap dengan database resmi |

## 📱 Alternatif Tanpa XAMPP

### Option 1: Online PHP Tester
- Kunjungi [phptester.net](https://phptester.net/)
- Copy kode PHP ke editor
- ⚠️ Sistem file tidak bekerja penuh

### Option 2: PHP Built-in Server
```bash
# Install PHP saja (bukan XAMPP)
# Di folder proyek, buka Command Prompt

php -S localhost:8000

# Akses: http://localhost:8000/upload.php
```

## 🔧 Development Lanjutan

### Text Editor Rekomendasi
- Visual Studio Code (gratis) - [Download](https://code.visualstudio.com/)
- Notepad++

### Debug Mode
Tambahkan di awal kode PHP:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Deploy ke Hosting

1. Pilih hosting yang support PHP (Hostinger, Niagahoster, dll)
2. Upload semua file ke `public_html`
3. Pastikan folder `storage` writable
4. Akses via: `namadomain.com/upload.php`

## 📚 Sumber Belajar

- 📖 [W3Schools PHP Tutorial](https://www.w3schools.com/php/)
- 🎥 [YouTube: Cara Install XAMPP](https://www.youtube.com/results?search_query=install+xampp)
- 📘 [GitHub Guides](https://guides.github.com/)
- 💬 [Stack Overflow](https://stackoverflow.com/)

## 🆘 Butuh Bantuan?

1. Screenshot error yang muncul
2. Cari di Google dengan kata kunci error
3. Cek video tutorial di YouTube
4. Tanya di forum: Stack Overflow, Discord programmer

## 🎓 Tips Testing

Coba berbagai skenario:
- ✓ Upload berbagai jenis file
- ✓ Modifikasi file yang sudah diupload, lalu verifikasi
- ✓ Coba dengan file besar (>100MB)
- ✓ Upload file dengan nama yang sama tapi isi berbeda

## 📋 File Structure

```
hashing-dokumen/
├── upload.php          # Halaman upload dokumen
├── verify.php          # Halaman verifikasi
├── style.css           # Styling
├── storage/            # Folder penyimpanan hash
│   └── original_hash.txt
└── README.md           # Dokumentasi ini
```

## ⚠️ Penting!

⚡ **Sistem ini hanya untuk edukasi dan lingkungan lokal.**

Untuk produksi/production, perlu pengembangan lebih lanjut:
- Database yang proper (MySQL/PostgreSQL)
- Authentication & authorization
- Security hardening
- Backup system
- Error handling yang robust

## 🎉 Selamat!

Jika semua berjalan lancar, Anda sekarang memiliki sistem verifikasi dokumen yang berfungsi penuh di komputer lokal! 🚀

**Happy Coding!** 💻✨

---

**Dibuat untuk pemula. Semoga membantu!** 📚
