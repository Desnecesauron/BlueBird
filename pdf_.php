





<?php

define('FPDF_FONTPATH', 'font/');
require('./fpdf/fpdf.php');


include 'conexao.php';


$sql=("SELECT * FROM public.usuario order by id_usuario");
$busca = pg_query($conecta,$sql);

$pdf= new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(200,10,('Relatorio de Usuarios'),0,0,"C");


$pdf->Image('logomarca.png',10,1,50,21,'PNG');
$pdf->ln(15);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,7,'ID',1,0,"C");
$pdf->Cell(50,7,'Nome',1,0,"C");
$pdf->Cell(35,7,'CPF',1,0,"C");
$pdf->Cell(70,7,'E-mail',1,0,"C");
$pdf->Cell(30,7,'Telefone',1,0,"C");

$pdf->ln();

while($resultado = pg_fetch_array($busca)){


$pdf->Cell(10,7, $resultado['id_usuario'],1,0,"C");
$pdf->Cell(50,7, $resultado['nome'],1,0,"C");
$pdf->Cell(35,7, $resultado['cpf'],1,0,"C");
$pdf->Cell(70,7, $resultado['email'],1,0,"C");
$pdf->Cell(30,7, $resultado['fone'],1,0,"C");

$pdf->ln();
    
}
                            
$pdf->Output();
?>