<!DOCTYPE html>
<html>
<head>
<title>Biodata Personal</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h1>Personal Biodata Validation</h1>
<p class="subtitle">Validasi Data Pribadi untuk Sistem Anti Pemalsuan</p>

<?php
session_start();
$biodata_file = __DIR__ . "/storage/biodata.json";
$storage = __DIR__ . '/storage/';


// Buat folder storage jika belum ada
if (!is_dir($storage)) {
    mkdir($storage, 0777, true);
}

// Load biodata jika sudah ada
$biodata = null;
if (file_exists($biodata_file)) {
    $biodata = json_decode(file_get_contents($biodata_file), true);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'save') {
        $new_biodata = [
            'nama' => htmlspecialchars($_POST['nama']),
            'nim' => htmlspecialchars($_POST['nim']),
            'email' => htmlspecialchars($_POST['email']),
            'no_hp' => htmlspecialchars($_POST['no_hp']),
            'alamat' => htmlspecialchars($_POST['alamat']),
            'universitas' => htmlspecialchars($_POST['universitas']),
            'jurusan' => htmlspecialchars($_POST['jurusan']),
            'created_at' => date('Y-m-d H:i:s')
        ];

        file_put_contents($biodata_file, json_encode($new_biodata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $biodata = $new_biodata;

        echo "<div class='result success'>";
        echo "<b>✓ Biodata berhasil disimpan</b>";
        echo "</div>";
    }

    if ($action === 'edit') {
        $biodata = null;
    }
}
?>

<?php if ($biodata === null): ?>
<!-- Form Input Biodata -->
<div class="biodata-form">
<form method="post" action="">
<div class="form-group">
<label>Nama Lengkap:</label>
<input type="text" name="nama" required placeholder="Masukkan nama lengkap Anda">
</div>

<div class="form-group">
<label>NIM:</label>
<input type="text" name="nim" required placeholder="Masukkan NIM Anda">
</div>

<div class="form-group">
<label>Email:</label>
<input type="email" name="email" required placeholder="Masukkan email Anda">
</div>

<div class="form-group">
<label>No. Handphone:</label>
<input type="tel" name="no_hp" required placeholder="Masukkan nomor handphone">
</div>

<div class="form-group">
<label>Alamat:</label>
<textarea name="alamat" required placeholder="Masukkan alamat lengkap Anda"></textarea>
</div>

<div class="form-group">
<label>Universitas:</label>
<input type="text" name="universitas" required placeholder="Masukkan nama universitas">
</div>

<div class="form-group">
<label>Jurusan:</label>
<input type="text" name="jurusan" required placeholder="Masukkan jurusan/program studi">
</div>

<button type="submit" name="action" value="save">Simpan Biodata</button>
</form>
</div>

<?php else: ?>
<!-- Tampilkan Biodata yang Sudah Disimpan -->
<div class="biodata-display">
<h2 style="color: #0d47a1; margin-top: 0;">Data Pribadi Tersimpan</h2>
<div class="biodata-item">
<strong>Nama Lengkap:</strong> <?php echo $biodata['nama']; ?>
</div>
<div class="biodata-item">
<strong>NIM:</strong> <?php echo $biodata['nim']; ?>
</div>
<div class="biodata-item">
<strong>Email:</strong> <?php echo $biodata['email']; ?>
</div>
<div class="biodata-item">
<strong>No. Handphone:</strong> <?php echo $biodata['no_hp']; ?>
</div>
<div class="biodata-item">
<strong>Alamat:</strong> <?php echo nl2br($biodata['alamat']); ?>
</div>
<div class="biodata-item">
<strong>Universitas:</strong> <?php echo $biodata['universitas']; ?>
</div>
<div class="biodata-item">
<strong>Jurusan:</strong> <?php echo $biodata['jurusan']; ?>
</div>
<div class="biodata-item" style="font-size: 12px; color: #999;">
<strong>Disimpan pada:</strong> <?php echo $biodata['created_at']; ?>
</div>

<div class="button-group" style="margin-top: 20px;">
<form method="post" action="" style="flex: 1;">
<button type="submit" name="action" value="edit" class="button-secondary">Edit Data</button>
</form>
<form action="generate.php" method="post" style="flex: 1;">
    <button type="submit" class="btn">Generate PDF</button>
</form>
</div>
</div>

<!-- Navigation ke halaman lain -->
<div class="navigation">
<a href="upload.php">📤 Upload Dokumen</a>
<a href="verify.php">✓ Verifikasi Dokumen</a>

</div>

<?php endif; ?>

</div>

<div class="footer">
Sistem Informasi Terdesentralisasi • Praktikum Blockchain
</div>

<script>
// AUTO-DETECT LOKASI SAAT HALAMAN LOAD - MENGGUNAKAN GOOGLE CHROME API
window.addEventListener('load', function() {
    console.log('Halaman loaded, mulai verifikasi lokasi dari Chrome...');
    requestLocationPermission();
});

async function requestLocationPermission() {
    try {
        // Minta permission dari Chrome secara eksplisit
        const permission = await navigator.permissions.query({ name: 'geolocation' });
        
        console.log('Permission status:', permission.state);
        
        if (permission.state === 'granted') {
            // Sudah pernah diizinkan sebelumnya
            console.log('Permission sudah diberikan sebelumnya');
            detectLocationFromChrome();
        } else if (permission.state === 'denied') {
            // User pernah menolak
            console.log('User pernah menolak akses lokasi');
        } else if (permission.state === 'prompt') {
            // Belum pernah ditanya, minta izin
            console.log('Meminta izin akses lokasi dari Chrome...');
            detectLocationFromChrome();
        }
    } catch (err) {
        console.log('Permission API tidak support, gunakan Geolocation API fallback');
        detectLocationFromChrome();
    }
}

function detectLocationFromChrome() {
    if (!navigator.geolocation) {
        console.error('Browser tidak support Geolocation');
        return;
    }
    
    // Options untuk akurasi maksimal dari Chrome
    const options = {
        enableHighAccuracy: true,  // Gunakan GPS + WiFi + Cell triangulation
        timeout: 30000,             // Tunggu max 30 detik untuk hasil akurat
        maximumAge: 0               // Selalu ambil lokasi terbaru, jangan cache
    };
    
    console.log('Starting geolocation detection with high accuracy...');
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const acc = position.coords.accuracy;
            const alt = position.coords.altitude;
            const altAcc = position.coords.altitudeAccuracy;
            const heading = position.coords.heading;
            const speed = position.coords.speed;
            
       
            console.log('Latitude:', lat, '| Longitude:', lng);
            console.log('Akurasi:', acc, 'meter | Altitude:', alt, '| Speed:', speed);
            
            // Get address dari koordinat yang akurat
            getAddressFromChrome(lat, lng, acc, alt, altAcc, heading, speed);
        },
        function(err) {
            let msg = 'Gagal deteksi lokasi';
            
            if (err.code === err.PERMISSION_DENIED) {
                msg = 'Izin akses lokasi ditolak oleh user';
            } else if (err.code === err.POSITION_UNAVAILABLE) {
                msg = 'Lokasi tidak tersedia - Aktifkan GPS/WiFi';
            } else if (err.code === err.TIMEOUT) {
                msg = 'Timeout - Signal GPS lemah, coba di tempat terbuka';
            }
            
            console.warn(msg);
        },
        options
    );
}

function getAddressFromChrome(lat, lng, acc, alt, altAcc, heading, speed) {
    // Reverse geocoding dengan Google Maps API atau OpenStreetMap
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(r => r.json())
        .then(data => {
            let addr = 'Indonesia';
            if (data.address) {
                // Build address dari data yang akurat
                const road = data.address.road || '';
                const city = data.address.city || data.address.county || '';
                const province = data.address.state || '';
                const country = data.address.country || '';
                
                addr = [road, city, province, country].filter(x => x).join(', ');
            }
            
            console.log('✓ Alamat dari Chrome Geolocation:', addr);
            
            // SIMPAN KE STORAGE DENGAN DATA AKURAT DARI CHROME
            saveLocationFromChrome(lat, lng, acc, alt, altAcc, heading, speed, addr);
        })
        .catch(e => {
            console.log('Geocoding error:', e);
            saveLocationFromChrome(lat, lng, acc, alt, altAcc, heading, speed, 'Indonesia');
        });
}

function saveLocationFromChrome(lat, lng, acc, alt, altAcc, heading, speed, addr) {
    const formData = new FormData();
    formData.append('action', 'save_location');
    formData.append('latitude', lat);
    formData.append('longitude', lng);
    formData.append('accuracy', acc);
    formData.append('altitude', alt || 0);
    formData.append('altitude_accuracy', altAcc || 0);
    formData.append('heading', heading || 0);
    formData.append('speed', speed || 0);
    formData.append('address', addr);
    formData.append('device', getDevice());
    formData.append('browser', 'Chrome Geolocation API');
    
    fetch('<?php echo $_SERVER['PHP_SELF']; ?>', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                console.log('✓ Lokasi berhasil disimpan dari Chrome');
            }
        })
        .catch(e => {
            console.log('Save error:', e);
        });
}

function getDevice() {
    const ua = navigator.userAgent;
    if (/Mobile|Android|iPhone/.test(ua)) return 'Mobile';
    if (/Tablet|iPad/.test(ua)) return 'Tablet';
    return 'Desktop';
}
</script>

<?php
// HANDLE AJAX REQUEST UNTUK SIMPAN LOKASI DARI CHROME
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_location') {
    header('Content-Type: application/json');
    
    $lat = floatval($_POST['latitude']);
    $lng = floatval($_POST['longitude']);
    $acc = floatval($_POST['accuracy']);
    $alt = floatval($_POST['altitude']);
    $alt_acc = floatval($_POST['altitude_accuracy']);
    $heading = floatval($_POST['heading']);
    $speed = floatval($_POST['speed']);
    $addr = htmlspecialchars($_POST['address']);
    $device = htmlspecialchars($_POST['device']);
    $browser = htmlspecialchars($_POST['browser']);
    
    // Load existing locations
    $locationFile = $storage . "location_history.json";
    $locations = file_exists($locationFile) ? json_decode(file_get_contents($locationFile), true) : [];
    if (!is_array($locations)) $locations = [];
    
    // Create new location entry dengan data akurat dari Chrome
    $location_data = [
        'latitude' => $lat,
        'longitude' => $lng,
        'accuracy' => $acc,
        'altitude' => $alt,
        'altitude_accuracy' => $alt_acc,
        'heading' => $heading,
        'speed' => $speed,
        'address' => $addr,
        'device' => $device,
        'browser' => $browser,
        'timestamp' => date('Y-m-d H:i:s'),
        'ip_address' => $_SERVER['REMOTE_ADDR']
    ];
    
    array_unshift($locations, $location_data);
    
    // Keep only last 10 locations
    if (count($locations) > 10) {
        $locations = array_slice($locations, 0, 10);
    }
    
  // Save to storage
    file_put_contents($locationFile, json_encode($locations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    echo json_encode([
        'success' => true,
        'message' => 'Lokasi berhasil disimpan!'
    ]);
    exit;
}
?>

</body>
</html>