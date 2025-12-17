<!DOCTYPE html>
<html>
<head>
<title>Verifikasi Dokumen</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h1>Document Verification</h1>
<p class="subtitle">Cek Keaslian Dokumen Digital</p>

<?php
$biodata_file = __DIR__ . "/storage/biodata.json";
$storage = __DIR__ . "/storage/";
$hashFile = $storage . "original_hash.txt";

if (!file_exists($biodata_file)) {
    echo "<div class='result error'>";
    echo "<b>⚠ Biodata belum diisi. Silakan isi biodata terlebih dahulu.</b>";
    echo "<br><br><a href='index.php' style='color: #b71c1c; text-decoration: none;'><b>← Kembali ke Biodata</b></a>";
    echo "</div>";
} else {
    $biodata = json_decode(file_get_contents($biodata_file), true);
    echo "<div style='background: #f0f7ff; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #0d47a1;'>";
    echo "<b>✓ Terverifikasi sebagai:</b> " . $biodata['nama'] . " (NIM: " . $biodata['nim'] . ")";
    echo "</div>";

    // Cek apakah sudah ada hash original
    if (!file_exists($hashFile)) {
        echo "<div class='result error'>";
        echo "<b>⚠ Dokumen asli belum diregistrasi</b><br><br>";
        echo "Silakan upload dokumen asli terlebih dahulu di halaman <a href='upload.php'><b>Upload Dokumen</b></a>";
        echo "</div>";
    } else {
        // Form verifikasi
        ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Pilih dokumen untuk diverifikasi:</label>
                <input type="file" name="doc" required>
            </div>
            <button type="submit">Verify Document</button>
        </form>

        <?php
        // Process verification
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['doc'])) {
            
            // Cek apakah file upload valid
            if ($_FILES['doc']['error'] !== UPLOAD_ERR_OK) {
                echo "<div class='result error'>";
                echo "<b>❌ Error saat upload file</b>";
                echo "</div>";
            } else {
                $hashUpload = hash_file('sha256', $_FILES['doc']['tmp_name']);
                $hashAsli = trim(file_get_contents($hashFile));

                if ($hashUpload === $hashAsli) {
                    echo "<div class='result success'>";
                    echo "<b>✓ DOKUMEN ASLI - TERVERIFIKASI</b><br><br>";
                } else {
                    echo "<div class='result error'>";
                    echo "<b>✗ DOKUMEN PALSU / TELAH DIUBAH</b><br><br>";
                }

                echo "Hash Upload:<br>";
                echo "<div class='hash-box'>" . $hashUpload . "</div><br>";

                echo "Hash Tersimpan:<br>";
                echo "<div class='hash-box'>" . $hashAsli . "</div>";

                echo "</div>";
            }
        }
        ?>
        <?php
    }
}
?>

</div>

<div class="footer">
Sistem Informasi Terdesentralisasi • Verifikasi Publik
</div>

</body>
</html>