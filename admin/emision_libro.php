<?php
require('fpdf/fpdf.php');

// Crear la clase PDF personalizada
class PDF extends FPDF
{
    // Encabezado
    function Header()
    {
        // Logo
        $this->Image('logo.png', 10, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Emisión de Libro', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear un nuevo objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Obtener los datos del formulario
$studentname = $_POST['studentname'];
$nombre = $_POST['nombre'];
$emision = $_POST['emision'];
$regreso = $_POST['regreso'];

// Escribir los datos en el PDF
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Nombre del estudiante:', 0, 0);
$pdf->Cell(0, 10, $studentname, 0, 1);
$pdf->Cell(40, 10, 'Nombre del libro:', 0, 0);
$pdf->Cell(0, 10, $nombre, 0, 1);
$pdf->Cell(40, 10, 'Fecha de emisión:', 0, 0);
$pdf->Cell(0, 10, $emision, 0, 1);
$pdf->Cell(40, 10, 'Fecha de regreso:', 0, 0);
$pdf->Cell(0, 10, $regreso, 0, 1);

// Mostrar el PDF en el navegador
$pdf->Output();
?>
