<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
</head>
<body>

<?php
// Include TCPDF library
require_once(ROOTPATH . 'Vendor/autoload.php'); // Adjust the path as necessary

// Create a new TCPDF instance
$pdf = new TCPDF('P', 'mm', 'A6', true, 'UTF-8', false); // Adjust page size for receipt
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Nota');
$pdf->SetSubject('Nota');

// Add a page
$pdf->AddPage();

// Set margins: left, top, right
$pdf->SetMargins(7, 10, 7); // Set margins to 7mm left, 10mm top, and 7mm right

// Set font to Times New Roman
$pdf->SetFont('times', '', 9); // Set font to Times New Roman, size 9

// Fetch the website name from the setting (ensure these are available and properly fetched)
$websiteName = isset($setting->judul_website) ? $setting->judul_website : 'RM. H. Yoga Slamet'; // Fallback value

// Prepare HTML content with inline styles
$html = '<div style="font-family: Arial, sans-serif; margin: 0; padding: 20px;">';
$html .= '<div style="text-align: center; margin-bottom: 20px;">';
$html .= '<h1>' . htmlspecialchars($websiteName, ENT_QUOTES, 'UTF-8') . '</h1>';
$html .= '<p>' . date('D d/m/Y H:i:s') . '</p>';
$html .= '</div>';

$html .= '<div style="text-align: left; margin: 10px;">';
$html .= '<h2 style="margin-bottom: 0px;">Detail Pemesanan</h2>';
$html .= '<p style="margin: 5px 0;">Kasir: <strong>' . htmlspecialchars(session()->get('nama'), ENT_QUOTES, 'UTF-8') . '</strong></p>'; // Kasir name
$html .= '<p style="margin: 5px 0;">Nama Pelanggan: <strong>' . htmlspecialchars($transaksi->nama_pelanggan, ENT_QUOTES, 'UTF-8') . '</strong></p>'; // Customer name
$html .= '<p style="margin: 5px 0;">No Transaksi: <strong>' . htmlspecialchars($transaksi->nomor_pemesanan, ENT_QUOTES, 'UTF-8') . '</strong></p>'; // Transaction number
$html .= '<p style="margin: 5px 0;">Tanggal: <strong>' . htmlspecialchars($transaksi->tanggal, ENT_QUOTES, 'UTF-8') . '</strong></p>'; // Transaction date

// Table for menu details
$html .= '<hr style="border: 1px solid black; margin: 10px 0;">'; // Horizontal line above table
$html .= '<br>'; // Adding one line break for spacing
$html .= '<table style="width: 100%; border-collapse: collapse; margin: 10px 0; border: none;">';
$html .= '<thead><tr>';
$html .= '<th style="padding: 10px; text-align: left;">Nama Menu</th>';
$html .= '<th style="padding: 10px; text-align: left;">Jumlah</th>';
$html .= '<th style="padding: 10px; text-align: left;">Harga</th>';
$html .= '</tr></thead>';
$html .= '<tbody>';

$totalAmount = 0; // Initialize total amount
foreach ($pemesanan as $item) {
    $itemTotal = floatval(str_replace(['Rp ', '.'], ['', ''], $item->harga_menu)) * (float)$item->jumlah; // Ensure harga_menu is stripped of 'Rp'
    $totalAmount += $itemTotal;
    $html .= '<tr>';
    $html .= '<td style="padding: 10px;">' . htmlspecialchars($item->nama_menu, ENT_QUOTES, 'UTF-8') . '</td>';
    $html .= '<td style="padding: 10px;">' . htmlspecialchars($item->jumlah, ENT_QUOTES, 'UTF-8') . '</td>';
    // Format item total
    $html .= '<td style="padding: 10px;">Rp ' . number_format($itemTotal, 0, ',', '.') . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';

// Add a horizontal line
$html .= '<hr style="border: 1px solid black; margin: 10px 0;">';

// Total calculation
$total = floatval(str_replace(['Rp ', '.'], ['', ''], $transaksi->total));
$bayar = floatval(str_replace(['Rp ', '.'], ['', ''], $transaksi->bayar));
$kembalian = floatval(str_replace(['Rp ', '.'], ['', ''], $transaksi->kembalian));

// Create a table for total, bayar, and kembalian
$html .= '<table style="width: 100%; margin: 10px 0; border: none;">';
$html .= '<tr>';
$html .= '<td style="text-align:right; padding: 5px; font-weight:bold;">Total:</td>'; // Total label bold
$html .= '<td style="text-align:right; padding: 5px; font-weight:bold;">Rp ' . number_format($totalAmount, 0, ',', '.') . '</td>'; // Total amount bold
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td style="text-align:right; padding: 5px;">Bayar:</td>';
$html .= '<td style="text-align:right; padding: 5px;">Rp ' . number_format($bayar, 0, ',', '.') . '</td>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<td style="text-align:right; padding: 5px;">Kembalian:</td>';
$html .= '<td style="text-align:right; padding: 5px;">Rp ' . number_format($kembalian, 0, ',', '.') . '</td>';
$html .= '</tr>';
$html .= '</table>';

$html .= '</div>'; // Close the outer div

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF directly to the browser
$pdfContent = $pdf->Output('nota.pdf', 'S'); // 'S' returns the PDF as a string

header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="nota.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Content-Length: ' . strlen($pdfContent));
ob_clean();
flush();
echo $pdfContent;

// Exit the script
exit;
?>

</body>
</html>
