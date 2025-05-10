<?php
require_once __DIR__ . '/../../../Controller/CasoController.php';
// Asegúrate de tener FPDF en public/fpdf/fpdf.php
require_once __DIR__ . '/../../fpdf/fpdf.php';

$casoController = new CasoController();
$casos = $casoController->getCasos();
// Ordenar por fecha de creación descendente y tomar los 10 más recientes
usort($casos, function($a, $b) {
    return strtotime($b['fecha_creacion']) - strtotime($a['fecha_creacion']);
});
$casosRecientes = array_slice($casos, 0, 10);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Reporte de Casos Recientes'), 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 8, 'ID', 1);
$pdf->Cell(30, 8, 'Ambiente', 1);
$pdf->Cell(30, 8, 'Usuario', 1);
$pdf->Cell(30, 8, 'Producto', 1);
$pdf->Cell(30, 8, 'Estado', 1);
$pdf->Cell(55, 8, 'Descripcion', 1);
$pdf->Ln();
$pdf->SetFont('Arial', '', 9);
foreach ($casosRecientes as $caso) {
    $pdf->Cell(15, 8, $caso['id'], 1);
    $pdf->Cell(30, 8, utf8_decode($caso['ambiente']), 1);
    $pdf->Cell(30, 8, utf8_decode($caso['usuario']), 1);
    $pdf->Cell(30, 8, utf8_decode($caso['producto']), 1);
    $pdf->Cell(30, 8, utf8_decode($caso['estados_casos']), 1);
    $pdf->Cell(55, 8, utf8_decode(substr($caso['descripcion'],0,40)), 1);
    $pdf->Ln();
}
$pdf->Output('I', 'reporte_casos.pdf');
exit; 