<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      $this->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(20); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(150, 8, utf8_decode('INSTITUTO DE EDUCACION SUPERIOR TECNOLOGICO PUBLICO'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Cell(20); // Movernos a la derecha
      $this->Cell(150, 8, utf8_decode('"EL NAZARENO"'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->SetFont('Arial', 'B', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Ln(3); // Salto de línea
      $this->Cell(20); // Movernos a la derecha
      $this->Cell(150, 8, utf8_decode('HISTORIAL DEL EGRESADO'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->Cell(20); // Movernos a la derecha
      $this->Cell(150, 12, utf8_decode('(DATOS INTERNOS)'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(8); // Salto de línea
      $this->SetTextColor(103); //color


   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

include '../../modelo/conexion.php';
/* CONSULTA INFORMACION */
$id = $_GET["id"];
$consulta_info = $conexion->query(" SELECT
estudiante.id,
estudiante.dni,
estudiante.nombre,
estudiante.apellido_paterno,
estudiante.apellido_materno,
estudiante.fecha_inicio,
estudiante.fecha_final,
estudiante.titulo,
estudiante.trabajo_actual,
estudiante.ruc,
estudiante.ubicacion,
estudiante.telefono,
estudiante.usuario,
estudiante.clave,
estudiante.foto,
estudiante.estado,
estudiante.correo,
carrera.nombre AS carrera
FROM estudiante
INNER JOIN carrera ON estudiante.carrera = carrera.id_carrera

 where id=$id ");

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas


$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde


while ($datos_reporte = $consulta_info->fetch_object()) {
   /* TABLA */
   $pdf->Cell(20);
   $pdf->SetFont('Arial', 'B', 12);
   $pdf->Cell(25, 0, utf8_decode("                 EGRESADO: "), 0, 1, 'L', 0);
   $pdf->Cell(80);
   $pdf->SetFont('Arial', '', 12);
   $pdf->Cell(25, 0, utf8_decode($datos_reporte->apellido_paterno . ' ' . $datos_reporte->apellido_materno . ', ' . $datos_reporte->nombre), 0, 1, 'L', 0);
   $pdf->Ln(8);

   $pdf->Cell(20);
   $pdf->SetFont('Arial', 'B', 12);
   $pdf->Cell(25, 0, utf8_decode("                               DNI:"), 0, 1, 'L', 0);
   $pdf->Cell(80);
   $pdf->SetFont('Arial', '', 12);
   $pdf->Cell(25, 0, utf8_decode($datos_reporte->dni), 0, 1, 'L', 0);
   $pdf->Cell(8);

   $pdf->Ln(8);

   $pdf->Cell(20);
   $pdf->SetFont('Arial', 'B', 12);
   $pdf->Cell(25, 0, utf8_decode("                    CELULAR:"), 0, 1, 'L', 0);
   $pdf->Cell(80);
   $pdf->SetFont('Arial', '', 12);
   $pdf->Cell(25, 0, utf8_decode($datos_reporte->telefono), 0, 1, 'L', 0);
   $pdf->Cell(8);

   $pdf->Ln(8);

   $pdf->Cell(20);
   $pdf->SetFont('Arial', 'B', 12);
   $pdf->Cell(25, 0, utf8_decode("                         E-MAIL:"), 0, 1, 'L', 0);
   $pdf->Cell(80);
   $pdf->SetFont('Arial', '', 12);
   $pdf->Cell(25, 0, utf8_decode($datos_reporte->correo), 0, 1, 'L', 0);
   $pdf->Cell(8);

   $pdf->Ln(8);

   $pdf->Cell(20);
   $pdf->SetFont('Arial', 'B', 12);
   $pdf->Cell(25, 0, utf8_decode("       ESTADO ACTUAL:"), 0, 1, 'L', 0);
   $pdf->Cell(80);
   $pdf->SetFont('Arial', '', 12);
   $pdf->Cell(25, 0, utf8_decode($datos_reporte->estado), 0, 1, 'L', 0);
   $pdf->Cell(8);


   //---------------------------------------------------

   $pdf->Ln(20);

   $pdf->Cell(20);
   $pdf->SetFont('Arial', 'B', 12);
   $pdf->Cell(25, 0, utf8_decode("         TECNICO (A) EN:"), 0, 1, 'L', 0);
   $pdf->Cell(80);
   $pdf->SetFont('Arial', '', 12);
   $pdf->Cell(25, 0, utf8_decode($datos_reporte->carrera), 0, 1, 'L', 0);
   $pdf->Cell(8);

   $pdf->Ln(8);

   $pdf->Cell(20);
   $pdf->SetFont('Arial', 'B', 12);
   $pdf->Cell(25, 0, utf8_decode("             FECHA INICIO:"), 0, 1, 'L', 0);
   $pdf->Cell(80);
   $pdf->SetFont('Arial', '', 12);
   $pdf->Cell(25, 0, utf8_decode($datos_reporte->fecha_inicio), 0, 1, 'L', 0);
   $pdf->Cell(8);

   $pdf->Ln(8);

   $pdf->Cell(20);
   $pdf->SetFont('Arial', 'B', 12);
   $pdf->Cell(25, 0, utf8_decode("FECHA CONCLUSION:"), 0, 1, 'L', 0);
   $pdf->Cell(80);
   $pdf->SetFont('Arial', '', 12);
   $pdf->Cell(25, 0, utf8_decode($datos_reporte->fecha_final), 0, 1, 'L', 0);
   $pdf->Cell(8);

   $pdf->Ln(8);

   $pdf->Cell(20);
   $pdf->SetFont('Arial', 'B', 12);
   $pdf->Cell(25, 0, utf8_decode("                         TITULO:"), 0, 1, 'L', 0);
   $pdf->Cell(80);
   $pdf->SetFont('Arial', '', 12);
   $pdf->Cell(25, 0, utf8_decode($datos_reporte->titulo), 0, 1, 'L', 0);
   $pdf->Cell(8);




   
}

$pdf->Image('logo.png', 50, 170, 110); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG



$pdf->Output('Historial del egresado.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
