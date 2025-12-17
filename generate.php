<?php
/* =======================
   INCLUDE FPDF
======================= */
// Include FPDF library
require_once __DIR__ . '/fpdf/fpdf.php';

// Load biodata dari session atau file
session_start();

$biodata_file = __DIR__ . "/storage/biodata.json";

// Cek apakah biodata ada di file
if (!file_exists($biodata_file)) {
    die("❌ Error: Biodata not found. Please fill the form first at <a href='index.php'>index.php</a>");
}

$biodata = json_decode(file_get_contents($biodata_file), true);

if ($biodata === null) {
    die("❌ Error: Biodata file is corrupted.");
}

// Simpan ke session
$_SESSION['biodata'] = $biodata;

/* =======================
   CUSTOM PDF CLASS
======================= */
class PDF_Biodata extends FPDF
{
    function Header()
    {
        $this->SetFillColor(13, 71, 161);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 15, 'BIODATA PRIBADI', 0, 1, 'C', true);
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 10, 'Sistem Informasi Terdesentralisasi • Praktikum Blockchain', 0, 0, 'C');
    }

    function RowData($label, $value)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(13, 71, 161);
        $this->Cell(50, 10, $label, 0, 0);

        $this->SetFont('Arial', '', 11);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 10, $value, 0, 1);
    }
}

/* =======================
   GENERATE PDF
======================= */
try {
    $pdf = new PDF_Biodata('P', 'mm', 'A4');
    $pdf->AddPage();

    $pdf->RowData('Nama Lengkap:', $biodata['nama']);
    $pdf->RowData('NIM:', $biodata['nim']);
    $pdf->RowData('Email:', $biodata['email']);
    $pdf->RowData('No. Handphone:', $biodata['no_hp']);

    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetTextColor(13, 71, 161);
    $pdf->Cell(50, 10, 'Alamat:', 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(0, 6, $biodata['alamat']);

    $pdf->RowData('Universitas:', $biodata['universitas']);
    $pdf->RowData('Jurusan:', $biodata['jurusan']);

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->SetTextColor(120, 120, 120);
    $pdf->Cell(0, 10, 'Dibuat pada: ' . date('Y-m-d H:i:s'), 0, 1);

    /* =======================
       SIMPAN PDF
    ======================= */
    $storage = __DIR__ . '/storage/';
    if (!is_dir($storage)) {
        mkdir($storage, 0777, true);
    }

    $filename = 'biodata_' . str_replace(' ', '_', $biodata['nama']) . '_' . time() . '.pdf';
    $pdfPath = $storage . $filename;
    
    // Generate PDF file
    $pdf->Output('F', $pdfPath);
    
    if (file_exists($pdfPath)) {
        // Simpan info ke session
        $_SESSION['pdf_file'] = $filename;
        $_SESSION['pdf_path'] = $pdfPath;
        
        // Redirect dengan status sukses
        header('Location: index.php?status=success&file=' . urlencode($filename));
        exit;
    } else {
        header('Location: index.php?status=error&msg=PDF+creation+failed');
        exit;
    }
    
} catch (Exception $e) {
    die("❌ Error creating PDF: " . $e->getMessage() . "<br><br><a href='index.php'>Kembali</a>");
}
?>