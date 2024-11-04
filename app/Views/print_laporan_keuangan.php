<?php
//============================================================+
// File name   : laporan_keuangan.php
// Begin       : 2024-10-23
// Description : Laporan Keuangan - Total Biaya Produksi, Penjualan Produk, dan Laba Rugi
// Author: [Nama Anda]
//============================================================+

require_once(ROOTPATH . 'Vendor/autoload.php');

// Extend TCPDF to create a custom PDF class
class CustomPDF extends TCPDF {
    public function Header() {
        // Do not display any header
    }

    public function Footer() {
        // Do not display any footer
    }
}

// Create new PDF document with A4 size in landscape orientation
$pdf = new CustomPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->SetFont('helvetica', '', 12);
$pdf->AddPage();

// Function to add a section title
function SectionTitle($pdf, $title) {
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, $title, 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', '', 12);
}

// Function to create a custom table
function CustomTable($pdf, $header, $data) {
    // Set header colors
    $pdf->SetFillColor(0, 0, 255);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(255, 255, 255);
    $pdf->SetLineWidth(0.3);
    $pdf->SetFont('', 'B');

    // Header
    foreach ($header as $head) {
        $pdf->Cell(40, 7, $head, 1, 0, 'C', 1);
    }
    $pdf->Ln();

    // Data
    $pdf->SetFillColor(224, 235, 255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    $fill = 0;

    foreach ($data as $row) {
        foreach ($row as $column) {
            $pdf->Cell(40, 6, $column, 'LR', 0, 'L', $fill);
        }
        $pdf->Ln();
        $fill = !$fill;
    }
    $pdf->Cell(array_sum(array_fill(0, count($header), 40)), 0, '', 'T');
}

// Function to calculate totals and display total rows
function DisplayTotalRow($pdf, $label, $totalSum) {
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(160, 10, $label, 1, 0, 'R');
    $pdf->Cell(40, 10, number_format($totalSum, 2), 1, 1, 'R');
}

// 1. Tabel Total Biaya Produksi
SectionTitle($pdf, 'Total Biaya Produksi');
$headerProduksi = ['Nomor', 'Deskripsi', 'Jumlah', 'Satuan', 'Harga Satuan', 'Total Bahan'];
$dataProduksi = [];
$totalBahanSum = 0;

foreach ($produksi as $row) {
    $hargaSatuan = is_numeric($row['harga_satuan']) ? floatval($row['harga_satuan']) : 0;
    $totalBahan = is_numeric($row['total_bahan']) ? floatval($row['total_bahan']) : 0;

    $totalBahanSum += $totalBahan;
    $dataProduksi[] = [
        $row['id_modal'],
        $row['deskripsi'],
        $row['jumlah'],
        $row['satuan'],
        number_format($hargaSatuan, 2),
        number_format($totalBahan, 2)
    ];
}

CustomTable($pdf, $headerProduksi, $dataProduksi);
DisplayTotalRow($pdf, 'Total Bahan:', $totalBahanSum);

// 2. Tabel Penjualan Produk
$pdf->AddPage();
SectionTitle($pdf, 'Penjualan Produk');
$headerPenjualan = ['Nomor', 'Tanggal', 'Nama Menu', 'Jumlah Jual', 'Harga Satuan', 'Total'];
$dataPenjualan = [];
$totalPenjualanSum = 0;

foreach ($penjualan_produk as $row) {
    $hargaSatuan = is_numeric($row['harga_satuan']) ? floatval($row['harga_satuan']) : 0;
    $total = is_numeric($row['total']) ? floatval($row['total']) : 0;

    $totalPenjualanSum += $total;

    $dataPenjualan[] = [
        $row['id_penjualan_produk'],
        date('d-m-Y', strtotime($row['tanggal'])),
        isset($row['nama_menu']) ? $row['nama_menu'] : 'N/A',
        $row['jumlah_jual'],
        number_format($hargaSatuan, 2),
        number_format($total, 2)
    ];
}

CustomTable($pdf, $headerPenjualan, $dataPenjualan);
DisplayTotalRow($pdf, 'Total Penjualan:', $totalPenjualanSum);

// 3. Tabel Pengeluaran
$pdf->AddPage();
SectionTitle($pdf, 'Pengeluaran');
$headerPengeluaran = ['Nomor', 'Tanggal', 'Nama Pengeluaran', 'Total Pengeluaran'];
$dataPengeluaran = [];
$totalPengeluaranSum = 0;

foreach ($pengeluaran as $row) {
    $totalPengeluaran = is_numeric(trim(str_replace(['Rp ', '.', ' '], '', $row['total_pengeluaran']))) 
        ? floatval(trim(str_replace(['Rp ', '.', ' '], '', $row['total_pengeluaran']))) 
        : 0;

    $dataPengeluaran[] = [
        $row['id_pengeluaran'],
        date('d-m-Y', strtotime($row['tanggal'])),
        isset($row['nama_pengeluaran']) ? $row['nama_pengeluaran'] : 'N/A',
        number_format($totalPengeluaran, 2)
    ];

    $totalPengeluaranSum += $totalPengeluaran;
}

CustomTable($pdf, $headerPengeluaran, $dataPengeluaran);
DisplayTotalRow($pdf, 'Total Pengeluaran:', $totalPengeluaranSum);

// 4. Tabel Laporan Laba Rugi
// 4. Tabel Laporan Laba Rugi
// 4. Tabel Laporan Laba Rugi
// 4. Tabel Laporan Laba Rugi
$pdf->AddPage();
SectionTitle($pdf, 'Laporan Laba Rugi');

// Calculate totals for Laba Rugi
$labaKotor = abs($totalPenjualanSum - $totalBahanSum); // Laba Kotor
$pendapatanBersih = abs($labaKotor - $totalPengeluaranSum); // Pendapatan Bersih

// Menampilkan hasil dalam format teks di luar batas
$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(10); // Jarak sebelum teks
$pdf->Cell(0, 10, 'Total Bahan: ' . number_format($totalBahanSum, 2), 0, 1, 'L');
$pdf->Cell(0, 10, 'Total Penjualan: ' . number_format($totalPenjualanSum, 2), 0, 1, 'L');
$pdf->Cell(0, 10, 'Laba Kotor: ' . number_format($labaKotor, 2), 0, 1, 'L');
$pdf->Cell(0, 10, 'Beban: ' . number_format($totalPengeluaranSum, 2), 0, 1, 'L');
$pdf->Cell(0, 10, 'Pendapatan Bersih: ' . number_format($pendapatanBersih, 2), 0, 1, 'L');




// Close and output PDF document
$pdf->Output('laporan_keuangan.pdf', 'I');
exit();


?>
