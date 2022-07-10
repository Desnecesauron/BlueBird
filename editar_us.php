<?php
session_start();
include_once("conexao.php");

    $name = $_SESSION['nome'];
    $nome   = $_POST['nome'];
    $cpf    = $_POST['cpf'];
    $email  = $_POST['email'];
    $senha  = $_POST['senha'];
    $fone   = $_POST['fone'];
    $cep    = $_POST['cep'];
    $datan  = $_POST['datan'];

    $sql="UPDATE public.usuario SET nome = '$nome', cpf = '$cpf', email='$email',senha='$senha',fone='$fone',cep='$cep',nasc='$datan' WHERE nome = '$name' ";

     // comente essa linha quando estiver td funcionando pra vc

    $resultado=pg_query($conecta, $sql);
    $linhas=pg_affected_rows($resultado);

    if ($linhas > 0)
    {
              echo '<script>alert("Dados alterados com sucesso! Realize o login novamente.");</script>';
        header("refresh: 1; url=sair.php");
    }
    else 
    {
              echo '<script>alert("Erro!");</script>';
        header("refresh: 1; url=dados.php");
    }


?>