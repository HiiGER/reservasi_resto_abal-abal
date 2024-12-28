<?php
require '../fpdf/fpdf.php';

// Ambil data dari URL
$name = htmlspecialchars($_GET['name']);
$email = htmlspecialchars($_GET['email']);
$phone = htmlspecialchars($_GET['phone']);
$reservation_code = htmlspecialchars($_GET['reservation_code']);
$table_number = htmlspecialchars($_GET['table_number']);
$date = htmlspecialchars($_GET['date']);
$time = htmlspecialchars($_GET['time']);

// Inisialisasi FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Judul
$pdf->Cell(0, 10, 'Reservation Details', 0, 1, 'C');
$pdf->Ln(10);

// Isi detail reservasi
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Name:', 0, 0);
$pdf->Cell(0, 10, $name, 0, 1);
$pdf->Cell(50, 10, 'Email:', 0, 0);
$pdf->Cell(0, 10, $email, 0, 1);
$pdf->Cell(50, 10, 'Phone:', 0, 0);
$pdf->Cell(0, 10, $phone, 0, 1);
$pdf->Cell(50, 10, 'Reservation Code:', 0, 0);
$pdf->Cell(0, 10, $reservation_code, 0, 1);
$pdf->Cell(50, 10, 'Table Number:', 0, 0);
$pdf->Cell(0, 10, $table_number, 0, 1);
$pdf->Cell(50, 10, 'Date:', 0, 0);
$pdf->Cell(0, 10, $date, 0, 1);
$pdf->Cell(50, 10, 'Time:', 0, 0);
$pdf->Cell(0, 10, $time, 0, 1);

// Output PDF
$pdf->Output('D', 'Reservation_' . $reservation_code . '.pdf'); // Unduh langsung
?>
