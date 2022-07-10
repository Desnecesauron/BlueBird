<?php
session_start();
include 'conexao.php';
  $qtd1 = $_SESSION['quanti'];
  $id_produto1 = $_SESSION['id_pro'];




 $codc = $_SESSION['id_usuario'];


    //Registro pedidos

    $excluido = 'n';
    //$qtd_prod = count($_SESSION['carrinho']);
    $data = date('d/m/Y');  //date('Y-m-d');
    $total =  $_SESSION['total'];  

foreach($_SESSION['carrinho'] as $id_produto1 => $qtd1){
    $sql = "INSERT INTO public.compra (id_usuario,quant,valor,data,exc) VALUES ($codc,$qtd1,$total,'$data','$excluido') RETURNING id_compra;";
    $result = pg_query($conecta,$sql);
    $id_venda = pg_fetch_assoc($result)['id_compra'];
    $linhas = pg_fetch_array($result);
    if($result > 0)
    {
        echo "<script>alert('Compra realizada com sucesso!!')</script>  ";
    }

foreach($_SESSION['carrinho'] as $id_produto1 => $qtd1){
        $sql = "select * from public.produto
                where id_produt=$id_produto1;";
        $res = pg_query($conecta, $sql);
        $regs = pg_num_rows($res);
        if($regs>0)
        {
            $linha = pg_fetch_array($res);
            $estoque = (int)$linha['quant'];
            $novoestoque = $estoque - $qtd1;
            //echo "<br>".$estoque."<br>".$novoestoque;
            $sqlup = "UPDATE public.produto
                    set
                    quant = $novoestoque
                    where id_produt=$id_produto1;";
            $result = pg_query($conecta, $sqlup);
            $resp = pg_num_rows($res);
            if($resp > 0)
                 {
              echo '<script>alert("Compra efetuada com sucesso!!");</script>';
                   unset( $_SESSION['carrinho'] );
        header("refresh: 1; url=home.php");
    }
    else 
    {
              echo '<script>alert("Erro!");</script>';
        header("refresh: 1; url=dados.php");
    }
        }
}
}
                
/*        
$sql = "UPDATE public.produto SET quant= quant-'$qtd1' WHERE nome='$nome_produto1' ";
$resultado = pg_query($conecta, $sql);
 $linhas=pg_affected_rows($resultado);

    if ($linhas > 0)
    {
              echo '<script>alert("Dados alterados com sucesso! Realize o login novamente.");</script>';
        header("refresh: 1; url=home.php");
    }
    else 
    {
              echo '<script>alert("Erro!");</script>';
        header("refresh: 1; url=dados.php");
    }

*/

?>
