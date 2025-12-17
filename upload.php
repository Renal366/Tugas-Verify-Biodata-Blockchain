<!DOCTYPE html>
<html>
<head>
<title>Upload Dokumen Asli</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h1>Document Registration</h1>
<p class="subtitle">Sistem Anti Pemalsuan Dokumen</p>

<?php
$biodata_file = __DIR__ . "/storage/biodata.json";
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
?>

<form method="post" enctype="multipart/form-data" action="">
<input type="file" name="doc" required>
<button type="submit">Register Document</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$storage = __DIR__ . "/storage/";

if (!is_dir($storage)) {
mkdir($storage, 0777, true);
}

$hash = hash_file('sha256', $_FILES['doc']['tmp_name']);

file_put_contents($storage . "original_hash.txt", $hash);
move_uploaded_file($_FILES['doc']['tmp_name'], $storage . "original.bin");

echo "<div class='result success'>";
echo "<b>✔ Dokumen berhasil diregistrasi</b><br><br>";
echo "SHA-256 Hash:";
echo "<div class='hash-box'>$hash</div>";
echo "<br><b>Redirecting to verification...</b>";
echo "</div>";
header("Refresh: 2; url=verify.php");
}
?>

<?php } ?>

</div>

<div class="footer">
Sistem Informasi Terdesentralisasi • Praktikum Blockchain
</div>

</body>
</html>