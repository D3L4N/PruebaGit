<?php
require('pdf/fpdf.php');
include("Php/Conexion.php");
date_default_timezone_set('America/Bogota');

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('Icons/informes.png', 17, 0, 180, 70);
        // Espacio adicional después del encabezado
        $this->Ln(50);
        
    }

    function Footer()
    {
        $this->SetFont('helvetica', 'B', 8);
        $this->SetY(-15);
        $this->Cell(95, 5, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'L');
        $this->Cell(95, 5, date('d/m/Y | g:i:a'), 0, 1, 'R');
        $this->Line(10, 287, 200, 287);
    
        // Colocar el logo debajo de "STARINVENTORY"
        $this->Cell(0, 5, utf8_decode("STARINVENTORY"), 0, 0, "C");
    }
    
    function CreateReport($CONEXION)
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetAutoPageBreak(true, 20);
        $this->SetTopMargin(15);
        $this->SetLeftMargin(10);
        $this->SetRightMargin(10);

        

        // Tabla de ENTRADAS DE PRODUCTOS (Compra)
        $this->SetFont('Arial', 'B', 24); 
        $this->Cell(0, 8, utf8_decode('Tabla de Compras'), 0, 1, 'C');
        $this->Ln(10);  // Agrega un espacio de 10 unidades (puedes ajustar según sea necesario)
        $this->SetX(15);

        // Colores de fondo y fuente para el encabezado
        $this->SetFillColor(25, 132, 151);
        $this->SetTextColor(255); // Texto en color blanco
        $this->SetFont('Arial', 'B', 10); // Reduce el tamaño de fuente para el encabezado

        // Altura uniforme para todas las celdas
        $alturaCelda = 10;

        // Encabezado de la tabla
        $this->Cell(8, $alturaCelda, utf8_decode('ID'), 1, 0, 'C', 1);
        $this->Cell(30, $alturaCelda, utf8_decode('Usuario'), 1, 0, 'C', 1);
        $this->Cell(40, $alturaCelda, utf8_decode('Producto'), 1, 0, 'C', 1);
        $this->Cell(10, $alturaCelda, utf8_decode('Stock'), 1, 0, 'C', 1);
        $this->Cell(35, $alturaCelda, utf8_decode('Proveedor'), 1, 0, 'C', 1);
        $this->Cell(40, $alturaCelda, utf8_decode('Fecha'), 1, 0, 'C', 1);
        $this->Cell(30, $alturaCelda, utf8_decode('Precio'), 1, 1, 'C', 1);

        // Restablece colores y fuente para los datos
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 10);

        // Recuperar datos de la tabla Compra
        $sql = "SELECT * FROM Compra";
        $result = $CONEXION->query($sql);

        $fill = false;
        $totalPrecio = 0; 
        while ($row = $result->fetch_assoc()) {
            $this->SetX(15);

            if ($fill) {
                $this->SetFillColor(232, 232, 232);
            } else {
                $this->SetFillColor(255, 255, 255);
            }
            $fill = !$fill;

            // Datos de la fila
            $this->Cell(8, $alturaCelda, $row['ID_Compra'], 1, 0, 'C', 1);
            $this->Cell(30, $alturaCelda, utf8_decode($row['Nombre_Usuario']), 1, 0, 'C', 1);
            $this->Cell(40, $alturaCelda, utf8_decode($row['Nombre_Producto']), 1, 0, 'C', 1);
            $this->Cell(10, $alturaCelda, $row['Stock'], 1, 0, 'C', 1);
            $this->Cell(35, $alturaCelda, utf8_decode($row['Nombre_Proveedor']), 1, 0, 'C', 1);
            $this->Cell(40, $alturaCelda, utf8_decode($row['Fecha_Compra']), 1, 0, 'C', 1);
            $this->Cell(30, $alturaCelda, '$ ' . number_format($row['Precio_Total'], 0, ',', '.'), 1, 1, 'C', 1);

            $totalPrecio += $row['Precio_Total'];
        }

        // Al final de la tabla, muestra el total
            $this->SetFillColor(25, 132, 151);
            $this->Cell(5);  // Ajusta según sea necesario
            $this->Cell(163, $alturaCelda, 'Total', 1, 0, 'C', 1); 
            $this->Cell(30, $alturaCelda, '$ ' . number_format($totalPrecio, 0, ',', '.'), 1, 1, 'C', 1);
            if ($this->GetY() > 190) {
                $this->AddPage();
            }
            $this->Ln(10);

        // Tabla de SALIDAS DE PRODUCTOS
        $this->AddPage(); // Agrega una nueva página para la siguiente tabla

        $this->SetFont('Arial', 'B', 24); 
        $this->Cell(0, 8, utf8_decode('Tabla de Ventas'), 0, 1, 'C');
        $this->Ln(10);  // Agrega un espacio de 10 unidades (puedes ajustar según sea necesario)
        $this->SetX(15);

        // Colores de fondo y fuente para el encabezado
        $this->SetFillColor(25, 132, 151);
        $this->SetTextColor(255); // Texto en color blanco
        $this->SetFont('Arial', 'B', 10); // Reduce el tamaño de fuente para el encabezado

        // Altura uniforme para todas las celdas
        $alturaCelda = 10;

        // Encabezado de la tabla
        $this->Cell(8, $alturaCelda, utf8_decode('ID'), 1, 0, 'C', 1);
        $this->Cell(30, $alturaCelda, utf8_decode('Usuario'), 1, 0, 'C', 1);
        $this->Cell(40, $alturaCelda, utf8_decode('Producto'), 1, 0, 'C', 1);
        $this->Cell(10, $alturaCelda, utf8_decode('Stock'), 1, 0, 'C', 1);
        $this->Cell(40, $alturaCelda, utf8_decode('Fecha'), 1, 0, 'C', 1);   
        $this->Cell(30, $alturaCelda, utf8_decode('Precio'), 1, 1, 'C', 1);

        // Restablece colores y fuente para los datos
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 10);

        // Recuperar datos de la tabla Compra
        $sql = "SELECT * FROM Venta";
        $result = $CONEXION->query($sql);

        $fill = false;
        $totalPrecio = 0; 
        while ($row = $result->fetch_assoc()) {
            $this->SetX(15);

            if ($fill) {
                $this->SetFillColor(232, 232, 232);
            } else {
                $this->SetFillColor(255, 255, 255);
            }
            $fill = !$fill;

            // Datos de la fila
            $this->Cell(8, $alturaCelda, $row['ID_Venta'], 1, 0, 'C', 1);
            $this->Cell(30, $alturaCelda, utf8_decode($row['Nombre_Usuario']), 1, 0, 'C', 1);
            $this->Cell(40, $alturaCelda, utf8_decode($row['Nombre_Producto']), 1, 0, 'C', 1);
            $this->Cell(10, $alturaCelda, $row['Stock'], 1, 0, 'C', 1);
            $this->Cell(40, $alturaCelda, utf8_decode($row['Fecha_Venta']), 1, 0, 'C', 1);
            $this->Cell(30, $alturaCelda, '$ ' . number_format($row['Precio'], 0, ',', '.'), 1, 1, 'C', 1);
            $totalPrecio += $row['Precio'];
        }

        // Al final de la tabla, muestra el total
        $this->SetFillColor(25, 132, 151);
        $this->Cell(5);  // Ajusta según sea necesario
        $this->Cell(128, $alturaCelda, 'Total', 1, 0, 'C', 1); 
        $this->Cell(30, $alturaCelda, '$ ' . number_format($totalPrecio, 0, ',', '.'), 1, 1, 'C', 1);
        if ($this->GetY() > 190) {
            $this->AddPage();
        }
        $this->Ln(10);
        

         // Tabla de DEVOLUCIONES
        // Añade una nueva página antes de la tabla de devoluciones
$this->AddPage(); 

// Configuración del encabezado de la tabla
$this->SetFont('Arial', 'B', 24); 
$this->Cell(0, 8, utf8_decode('Tabla de Devoluciones'), 0, 1, 'C');
$this->Ln(10); 
$this->SetX(15);

// Colores de fondo y fuente para el encabezado
$this->SetFillColor(25, 132, 151);
$this->SetTextColor(255); 
$this->SetFont('Arial', 'B', 10); 

// Altura uniforme para todas las celdas
$alturaCelda = 10;

// Encabezado de la tabla
$this->Cell(8, $alturaCelda, utf8_decode('ID'), 1, 0, 'C', 1);
$this->Cell(30, $alturaCelda, utf8_decode('Usuario'), 1, 0, 'C', 1);
$this->Cell(40, $alturaCelda, utf8_decode('Producto'), 1, 0, 'C', 1);
$this->Cell(10, $alturaCelda, utf8_decode('Stock'), 1, 0, 'C', 1);
$this->Cell(40, $alturaCelda, utf8_decode('Fecha'), 1, 0, 'C', 1);
$this->Cell(60, $alturaCelda, utf8_decode('Motivo'), 1, 1, 'C', 1);

// Restablece colores y fuente para los datos
$this->SetFillColor(255, 255, 255);
$this->SetTextColor(0);
$this->SetFont('Arial', '', 10);

// Recuperar datos de la tabla Devolucion
$sql = "SELECT * FROM Devolucion";
$result = $CONEXION->query($sql);

// Verificar si hay errores en la consulta SQL
if (!$result) {
    die("Error en la consulta SQL: " . $CONEXION->error);
}

$fill = false; 
while ($row = $result->fetch_assoc()) {
    $this->SetX(15);

    // Ajusta los colores de fondo para las filas alternas
    $this->SetFillColor($fill ? 232 : 255, $fill ? 232 : 255, $fill ? 232 : 255);
    $fill = !$fill;

    // Datos de la fila
    $this->Cell(8, $alturaCelda, $row['ID_Devolucion'], 1, 0, 'C', 1);
    $this->Cell(30, $alturaCelda, utf8_decode($row['Nombre_Usuario']), 1, 0, 'C', 1);
    $this->Cell(40, $alturaCelda, utf8_decode($row['Nombre_Producto']), 1, 0, 'C', 1);
    $this->Cell(10, $alturaCelda, $row['Stock'], 1, 0, 'C', 1);
    $this->Cell(40, $alturaCelda, utf8_decode($row['Fecha_Devolucion']), 1, 0, 'C', 1);
    $this->Cell(60, $alturaCelda, utf8_decode($row['Motivo']), 1, 1, 'C', 1);
}

// Salto de línea después de la tabla
$this->Ln(10);

    }
}

$pdf = new PDF();
$pdf->CreateReport($CONEXION);
$pdf->Output();