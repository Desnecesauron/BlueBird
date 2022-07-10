





<?php

define('FPDF_FONTPATH', 'font/');
require('./fpdf/fpdf.php');


include 'conexao.php';


$sql=("SELECT * FROM public.produto order by id_produt");
$busca = pg_query($conecta,$sql);

$pdf= new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(200,10,('Relatorio de Produto'),0,0,"C");


$pdf->Image('logomarca.png',10,1,50,21,'PNG');
$pdf->ln(15);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,7,'ID',1,0,"C");
$pdf->Cell(40,7,'Nome',1,0,"C");
$pdf->Cell(35,7,'Valor',1,0,"C");
$pdf->Cell(35,7,'Categoria',1,0,"C");
$pdf->Cell(35,7,'Quantidade',1,0,"C");
$pdf->Cell(30,7,'Excluido?',1,0,"C");
$pdf->ln();

while($resultado = pg_fetch_array($busca)){


$pdf->Cell(20,7, $resultado['id_produt'],1,0,"C");
$pdf->Cell(40,7, $resultado['nome'],1,0,"C");
$pdf->Cell(35,7, $resultado['valor'],1,0,"C");
$pdf->Cell(35,7, $resultado['categoria'],1,0,"C");
$pdf->Cell(35,7, $resultado['quant'],1,0,"C");
$pdf->Cell(30,7, $resultado['excluido'],1,0,"C");
$pdf->ln();
    
}
                            
$pdf->Output();
?>