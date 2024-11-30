<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      $this->Image('mine.jpg', 10, 5, 50); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->Image('logo.jpg', 150, 5, 50); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->Ln(15); // Salto de línea
      $this->SetFont('Arial', 'B', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(20); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(150, 8, utf8_decode('INSTITUTO DE EDUCACION SUPERIOR TECNOLOGICO PUBLICO'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Cell(20); // Movernos a la derecha
      $this->Cell(150, 8, utf8_decode('"HUANTA"'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->SetFont('Arial', 'B', 12); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Ln(3); // Salto de línea
      $this->Cell(20); // Movernos a la derecha
      $this->Cell(150, 8, utf8_decode('BOLETA DE INFORMACION DE RENDIMIENTO ACADÉMICO
      '), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea


   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y h:i:s');
      $this->Cell(320, 10, utf8_decode("Fecha y hora de emision" . $hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

include '../../modelo/conexion.php';
$dni = $_GET["txtdni"];
$id_semestre = $_GET["txtsemestre"];
$id_estudiante = $_GET["txtid"];
$id_carrera = $_GET["txtcarrera"];

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$pdf->SetFillColor(0,74,141); //colorFondo
$pdf->SetTextColor(0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(100, 10, utf8_decode('Programa de Estudios'), 1, 0, 'C', 1);
$pdf->Cell(42, 10, utf8_decode('Periodo Academico'), 1, 0, 'C', 1);
$pdf->Cell(42, 10, utf8_decode('Semestre Academico'), 1, 1, 'C', 1);

$carrera = $conexion->query(" SELECT estudiante.nombre,apellido_paterno,apellido_materno,estudiante.id,dni,carrera.id_carrera,carrera.nombre as 'nomCarrera' FROM estudiante INNER JOIN carrera ON estudiante.carrera = carrera.id_carrera where dni='$dni' ");

$semestre = $conexion->query(" select * from semestre where id_semestre=$id_semestre ");

$datosSemestre = $semestre->fetch_object();
$datosCarrera = $carrera->fetch_object();


$sql3 = $conexion->query(" SELECT
nota.id_nota,nota.estudiante,nota.unidad,nota.puntaje,nota.observacion,nota.semestre,nota.nota,estudiante.dni,estudiante.nombre,estudiante.apellido_paterno,
estudiante.apellido_materno,semestre.semestre AS nom_semestre,semestre.`año`,unidades.nombre AS nomUnidad,unidades.carrera,unidades.credito
FROM nota INNER JOIN estudiante ON nota.estudiante = estudiante.id
INNER JOIN semestre ON nota.semestre = semestre.id_semestre
INNER JOIN unidades ON nota.unidad = unidades.id_unidades
WHERE unidades.carrera=$id_carrera and unidades.semestre=$id_semestre and nota.semestre=$id_semestre and nota.estudiante=$id_estudiante ");

$sinNota = $conexion->query(" SELECT
unidades.nombre,
unidades.id_unidades,
unidades.credito
FROM
unidades
WHERE carrera=$id_carrera
and unidades.semestre=$id_semestre
and id_unidades not in(SELECT nota.unidad from nota where nota.estudiante=$id_estudiante and nota.semestre=$id_semestre ) ");

/* TABLA */
$pdf->Cell(100, 10, utf8_decode("$datosCarrera->nomCarrera"), 1, 0, 'C', 0);
$pdf->Cell(42, 10, utf8_decode("$datosSemestre->año"), 1, 0, 'C', 0);
$pdf->Cell(42, 10, utf8_decode(" $datosSemestre->semestre"), 1, 1, 'C', 0);
$pdf->Ln(5);

$pdf->SetFillColor(0,74,141); //colorFondo
$pdf->SetTextColor(0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(70, 10, utf8_decode('N° de Matricula'), 1, 0, 'C', 1);
$pdf->Cell(114, 10, utf8_decode('APELLIDO Y NOMBRES'), 1, 1, 'C', 1);

/* TABLA */
$pdf->Cell(70, 10, utf8_decode("$datosCarrera->dni"), 1, 0, 'C', 0);
$pdf->Cell(114, 10, utf8_decode("$datosCarrera->apellido_paterno" . " " . "$datosCarrera->apellido_materno" . ", " . "$datosCarrera->nombre"), 1, 0, 'C', 0);

$pdf->Ln(20);

$pdf->SetFillColor(0,74,141); //colorFondo
$pdf->SetTextColor(0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(70, 10, utf8_decode('UNIDAD DIDACT.'), 1, 0, 'C', 1);
$pdf->Cell(20, 10, utf8_decode('CREDITO'), 1, 0, 'C', 1);
$pdf->Cell(20, 10, utf8_decode('NOTA.'), 1, 0, 'C', 1);
$pdf->Cell(20, 10, utf8_decode('PUNTAJE'), 1, 0, 'C', 1);
$pdf->Cell(55, 10, utf8_decode('OBSERVACION'), 1, 1, 'C', 1);


$pdf->SetFillColor(255); //colorFondo
$pdf->SetTextColor(0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', 'B', 9);

while ($datosNota = $sql3->fetch_object()) {
   $pdf->Cell(70, 10, utf8_decode("$datosNota->nomUnidad"), 1, 0, 'l', 1);
   $pdf->Cell(20, 10, utf8_decode("$datosNota->credito"), 1, 0, 'C', 1);
   $pdf->Cell(20, 10, utf8_decode("$datosNota->nota"), 1, 0, 'C', 1);
   $pdf->Cell(20, 10, utf8_decode("$datosNota->puntaje"), 1, 0, 'C', 1);
   $pdf->Cell(55, 10, utf8_decode("$datosNota->observacion"), 1, 1, 'l', 1);
}
$pdf->Ln(10);
/* ----------------------------- */
$pdf->SetFillColor(0,74,141); //colorFondo
$pdf->SetTextColor(0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(70, 10, utf8_decode('UNIDAD DIDACT.'), 1, 0, 'C', 1);
$pdf->Cell(20, 10, utf8_decode('CREDITO'), 1, 0, 'C', 1);
$pdf->Cell(20, 10, utf8_decode('NOTA.'), 1, 0, 'C', 1);
$pdf->Cell(20, 10, utf8_decode('PUNTAJE'), 1, 0, 'C', 1);
$pdf->Cell(55, 10, utf8_decode('OBSERVACION'), 1, 1, 'C', 1);


$pdf->SetFillColor(255); //colorFondo
$pdf->SetTextColor(0); //colorTexto
$pdf->SetDrawColor(163, 163, 163); //colorBorde
$pdf->SetFont('Arial', 'B', 9);

while ($datosSinNota = $sinNota->fetch_object()) {
   $pdf->Cell(70, 10, utf8_decode("$datosSinNota->nombre"), 1, 0, 'l', 1);
   $pdf->Cell(20, 10, utf8_decode("$datosSinNota->credito"), 1, 0, 'C', 1);
   $pdf->Cell(20, 10, utf8_decode(""), 1, 0, 'C', 1);
   $pdf->Cell(20, 10, utf8_decode(""), 1, 0, 'C', 1);
   $pdf->Cell(55, 10, utf8_decode(""), 1, 1, 'l', 1);
}


/* ---------------------- */
$pdf->Ln(20);
$pdf->SetFillColor(255); //colorFondo
$pdf->SetTextColor(0); //colorTexto
$pdf->SetDrawColor(255); //colorBorde
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(62, 10, utf8_decode('..........................................'), 1, 0, 'C', 1);
$pdf->Cell(62, 10, utf8_decode('..........................................'), 1, 0, 'C', 1);
$pdf->Cell(62, 10, utf8_decode('...........................................'), 1, 1, 'C', 1);

$pdf->Cell(62, 10, utf8_decode('Director General'), 1, 0, 'C', 1);
$pdf->Cell(62, 10, utf8_decode('Jefe de Area'), 1, 0, 'C', 1);
$pdf->Cell(62, 10, utf8_decode('Secretario Académico'), 1, 1, 'C', 1);

$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde







$pdf->Output('Boleta de Notas.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
