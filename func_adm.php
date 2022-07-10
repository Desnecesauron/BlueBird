<?php session_start(); ?>
<HTML lang="pt-br">
    <HEAD>
        <TITLE> BlueBird - Admin </TITLE>
        
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        
        <link rel="stylesheet" type="text/css" href="Estilos/estilo_home.css" />
        
        <link rel="sortcut icon" href="Imagens/icone_pagina.png" type="image/x-icon" />
        
    </HEAD>
    <BODY link="black" vlink="red" alink="black">
     
      <div id = "mae">
       <font face="Arial" size="7">
        <ul class="menu">
                        <li>
                            <div id="logo">
                                <a href="home.php">
                                    <img src="Imagens/homefotos/logomarca.png" width="300">
                                </a>
                            </div>
                        </li>
                      
                        <li>
                            <br>
                            <div id="divBusca">
                                <form method = "POST" action="pesquisar.php">
                                <input type="text" name="pesquisar" id="txtBusca" placeholder="Buscar..."/>
                                <!-- insere, dentro do input, um texto que será apagado quando começar a digitar dentro do campo, e mostrado de novo ao perder o focus do elemento e o conteúdo seja vazio. -->
                                <div id="btn_busca">
                                    <button type="submit" id="btn_Busca">
                                        <img src="Imagens/homefotos/lupa.png" height="60" width="65"   alt="Buscar"/>
                                    </button>
                                </div>
                                </form>
                            </div>
                        </li>
                        <li>
                            &nbsp;&nbsp; &nbsp;&nbsp;
                            <div id="perfil">
                                      <?php
                        if($_SESSION['logado'] == true){
                        echo '                                <a href="dados.php">
                                    &nbsp;&nbsp; <img src="Imagens/homefotos/Perfil.png" height="80" width="85">
                                </a>' ;
                        }
                        else{
                        echo '                                <a href="login.php">
                                    &nbsp;&nbsp; <img src="Imagens/homefotos/Perfil.png" height="80" width="85">
                                </a>'; 
                            
                        }
                    ?> 
                            </div>
                        </li>
                        <li>
                            &nbsp;&nbsp;
                            <div id="carrinho">
                                <a href="carrinho.php">
                                    
                                    &nbsp;&nbsp; <img src="Imagens/homefotos/carrinho.PNG" height="100" width="105">
                                </a>
                            </div>
                        </li>
                    </ul>
            
                    <br>
                    <br>
                    <br>
                    <hr>
                                      <?php
                    if(isset($_SESSION['admin']) && $_SESSION['admin'] == true)  
                    {?> <div id="btn"> //
                        <a class="btn" href="func_adm.php" style="text-decoration:none"> Admin </a>
                    </div> 
           <?php 
                        
                    } ?>
                    <div id="btn">
                        <a class="btn" href="home.php" style="text-decoration:none"> Home </a>
                    </div>
                        
                    <div id="btn">
                        <a class="btn" href="comprar.php" style="text-decoration:none"> Produtos   </a>   
                    </div>
                    
                    
                        <?php
                        if(isset($_SESSION['admin']) && $_SESSION['admin'] == true)  {
                            
                        }
                        else{
                        if($_SESSION['logado'] == true){
                            echo '<div id="btn">';
                        echo '<a class="btn" href="dados.php" style="text-decoration:none" > Login </a>' ;
                            echo '</div>';
                        }
                        else{
                            echo '<div id="btn">';
                        echo '<a class="btn" href="login.php" style="text-decoration:none" > Login </a>'; 
                            echo '</div>';
                        }
                        }
                    ?>        
                    
                    
                        
                        
                    <div id="btn">
                        <a class="btn" href="sobre.php" style="text-decoration:none"> DEV </a> 
                    </div>
                              
                    <div id="btn">
                        <a class="btn" href="saiba.php" style="text-decoration:none"> Saiba Mais </a> 
                    </div>
            
                    <hr>
 <h2>ADMIN</h2>
<?php
    
    include 'conexao.php';
    
    
    
    $sql = "select * from public.produto order by id_produt";
    $dados = pg_query($conecta,$sql);
    while ($linha = pg_fetch_array($dados))
    {
        $codd = $linha['id_produt'];
    }
    $codd += 1;
    
    $codn;
    
    
    echo "<center>";
        echo "<a href=func_adm.php?codigo=0>Pesquisar/remover/habilitar/atualizar produtos</a>";
        echo "<br>";
        echo "<a href=func_adm.php?codigo=1&id=".$codd.">Adicionar produtos</a>";
        echo "<br>";
        echo "<a href=func_adm.php?codigo=4>Pesquisar/remover/habilitar usuários</a>";
        echo "<br>";
        echo "<a href=pdf.php>Gerar PDF produtos</a>";
        echo "<br>";
        echo "<a href=pdf_.php>Gerar PDF usuários</a>";
        echo "<br>";
        echo "<a href=func_adm.php?codigo=2>Ver relatório de vendas</a>";
        echo "<br>";
        echo "<br><br>";
    echo "</center>";
    
    if ($_GET)
    {
        $codigo = $_GET['codigo'];
        $id;
        $exc;
        $idalt;
        //$cod_pizza = $_GET['cod_pizza'];
        
        if($codigo==0)
        {
            $sql = "select * from public.produto order by id_produt";
            $dados = pg_query($conecta, $sql);
            
            /*$id;
            $quant;
            $valor;
            $estampa;
            $fk_idcat;
            $excluido;*/
            
            $id;
            $nome;
            $valor;
            $cat;
            $quant;
            $exc;
            
            echo "<center>";
            echo "<table border='9'>";
            echo "<tr><td>Id<td>Nome<td>Valor<td>Categoria<td>Quantidade<td>Excluído?<td>Alternar exclusão<td>Atualizar dados";
            while ($linha = pg_fetch_array($dados))
            {
                $id = $linha['id_produt'];
                $nome = $linha['nome'];
                $valor = $linha['valor'];
                $cat = $linha['categoria'];
                $quant = $linha['quant'];
                $exc = $linha['excluido'];
                $_SESSION['qtd2'] = $quant;
                if($exc == "n" || $exc == "N")
                {
                    $sn=0;
                    $exc = "Não";
                }
                else if($exc == "s" || $exc == "S")
                {
                    $sn=1;
                    $exc = "Sim";
                }
                
                if($cat==1)
                {
                    $cat="Pokémon";
                }
                else if($cat==2)
                {
                    $cat="Marvel";
                }
                else if($cat==3)
                {
                    $cat="DC";
                }
                else if($cat==4)
                {
                    $cat="CTI";
                }
                
                
                
                echo "<tr><td>".$id."<td>".$nome."<td>".$valor."<td>".$cat."<td>".$quant."<td>".$exc."<td><a href=func_adm.php?codigo=3&id=".$id."&exc=".$sn."><img src='Imagens/exc_icon.png' height=50></a><td><a href=func_adm.php?codigo=1&id=".$id."><img src='Imagens/alt_icon.png' height=50></a>";
                
            }
            echo "</table>";
            echo "</center>";
        }
        else if($codigo==1)
        {
            $id = $_GET['id'];
            
            if($id == $codd)
            {
                $nome;
                $valor;
                $cat;
                $quant;
                $exc;
                
                
                echo "<center>";
                echo "<form method='post' action='func_adm.php'>";
                
                //echo "<form method='post' enctype='multipart/form-data' action='func_adm.php'>";
                
                echo "<input type='hidden' name='codn' value=".$id.">";
                echo "<br>";
                echo "<br>";
                echo "Nome<br>";
                echo "<input type='hidden' name='codg' value=2>";
                echo "<input type='text' name='nome'>";
                echo "<br>";
                echo "<br>";
                echo "Valor<br>";
                echo "<input type='text' name='valor'>";
                echo "<br>";
                echo "<br>";
                echo "Categoria (números)<br>";
                echo "<input type='number' name='cat'>";
                echo "<br>";
                echo "<br>";
                echo "Quantidade do produto<br>";
                echo "<input type='text' name='quant'>";
                echo "<br>";
                echo "<input type='hidden' name='exc' value='n'>";
                echo "<br>";
                
                //echo "<input name='arquivo' type='file' />";
                
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Adicionar produto'/>";
                echo "</center></form>";
                
                
            }
            else
            {
                $nome;
                $valor;
                $cat;
                $quant;
                $exc;
                
                
                $sql = "select * from public.produto where id_produt=$id";
                $dados = pg_query($conecta,$sql);   // faz o select
                $linha = pg_fetch_array($dados);    // carrega o registro num vetor $linha
                
                $nome = $linha['nome'];
                $valor = $linha['valor'];
                $cat = $linha['categoria'];
                $quant = $linha['quant'];
                $exc = $linha['excluido'];
                
                
                echo "<center>";
                echo "<form method='post' action='func_adm.php'>";
                echo "<input type='hidden' name='codn' value=".$id.">";
                echo "<br>";
                echo "<br>";
                echo "<input type='hidden' name='codg' value=1>";
                echo "Nome<br>";
                echo "<input type='text' name='nome' value='".$nome."'>";
                echo "<br>";
                echo "<br>";
                echo "Valor<br>";
                echo "<input type='text' name='valor' value='".$valor."'>";
                echo "<br>";
                echo "<br>";
                echo "Categoria (números)<br>";
                echo "<input type='number' name='cat' value=".$cat.">";
                echo "<br>";
                echo "<br>";
                echo "Quantidade do produto<br>";
                echo "<input type='text' name='quant' value=".$quant.">";
                echo "<br>";
                echo "<input type='hidden' name='exc' value=".$exc.">";
                echo "<br>";
                
                
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='Alterar produto'/>";
                echo "</center></form>";
                
                
            }
        }
        else if($codigo==2)
        {
            //$sql = "select public.compra*, MONTH(data) as dataa from public.compra order by id_compra";
            //$sql = "select * from public.compra order by id_compra";
            $mesat=date('m');
            $anoat=date('Y');
            
            
            $sql ="select * FROM public.compra";
            
            
            
            $dados = pg_query($conecta, $sql);
            
            /*
            $id_compra;
            $id_usuario;
            $quant;
            $valor;
            $data;
            $exc;
            */
            
            $vendas=0;
            $data;
            $valtot=0;
            $valliq=0;
            
            $meses = array("nada", "janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
            
            echo "<center>";
            echo "Exibindo os relatórios do mês de ";
            echo "$meses[$mesat]";
            
            echo "<br><table border='9'>";
            
            echo "<tr><td>Total de vendas";
            
            while ($linha = pg_fetch_array($dados))
            {
                $id_compra = $linha['id_compra'];
                $id_usuario = $linha['id_usuario'];
                $quant = $linha['quant'];
                $valor = $linha['valor'];
                $data = $linha['data'];
                $_SESSION['qtd2'] = $quant;
                
                //if($mesat == $data)
                //{
                    $vendas++;
                    $valtot+=$valor;
                    $valliq+=($valor-3*$quant);
                //}
                
                
                /*
                $dias="";
                
                if($mesat == 1)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$mesat=='".$di."/01/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/01/".$anoat."";
                }
                else if($mesat == 2)
                {
                    for($di=1;$di<=28;$di++)
                    {
                        $dias.="$mesat=='".$di."/02/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/02/".$anoat."";
                }
                else if($mesat == 3)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$mesat=='".$di."/03/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/03/".$anoat."";
                }
                else if($mesat == 4)
                {
                    for($di=1;$di<=29;$di++)
                    {
                        $dias.="$mesat=='".$di."/04/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/04/".$anoat."";
                }
                else if($mesat == 5)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$mesat=='".$di."/05/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/05/".$anoat."";
                }
                else if($mesat == 6)
                {
                    for($di=1;$di<=29;$di++)
                    {
                        $dias.="$mesat=='".$di."/06/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/06/".$anoat."";
                }
                else if($mesat == 7)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$mesat=='".$di."/07/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/07/".$anoat."";
                }
                else if($mesat == 8)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$mesat=='".$di."/08/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/08/".$anoat."";
                }
                else if($mesat == 9)
                {
                    for($di=1;$di<=29;$di++)
                    {
                        $dias.="$mesat=='".$di."/09/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/09/".$anoat."";
                }
                else if($mesat == 10)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$mesat=='".$di."/10/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/10/".$anoat."";
                }
                else if($mesat == 11)
                {
                    $dias="";
                    for($di=1;$di<=29;$di++)
                    {
                        $dias.="$mesat=='".$di."/11/".$anoat."' || ";
                    }
                    $dias.="$mesat=='".$di."/11/".$anoat."'";
                }
                else if($mesat == 12)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$mesat=='".$di."/12/".$anoat." || ";
                    }
                    $dias.="$mesat=='".$di."/12/".$anoat."";
                }
                
                if(".$dias.")
                {
                    $vendas++;
                    $valtot+=$valor;
                    $valliq+=($valor-3*$quant);
                    
                }
                
                */
            }
            
            
            
            
            $vendas = $id_compra;
            
            echo "<td>".$vendas."<tr>";
            echo "<td>Receita Bruta";
            echo "<td>".$valtot."<tr>";
            echo "<td>Receita Líquida";
            echo "<td>".$valliq."<tr>";
            echo "<td>Porcentagem de lucro:";
            
            
            if($valtot!==0)
            {
                $xxxx=($valliq*100)/$valtot;
            }
            else
            {
                $xxxx=0;
            }
            echo "<td>";
            echo round($xxxx, 2);
            echo " %<tr>";
            
            
            echo "</table>";
            /*
            echo "<br><br><br>";
            
            echo "<h2>Buscar resultado de outro mês:</h2>";
            
            echo "<form method='post' action='func_adm.php'>";
            
            echo "<select name='mee'>";
                echo "<option value=1>Janeiro</option>";
                echo "<option value=2>Fevereiro</option>";
                echo "<option value=3>Março</option>";
                echo "<option value=4>Abril</option>";
                echo "<option value=5>Maio</option>";
                echo "<option value=6>Junho</option>";
                echo "<option value=7>Julho</option>";
                echo "<option value=8>Agosto</option>";
                echo "<option value=9>Setembro</option>";
                echo "<option value=10>Outubro</option>";
                echo "<option value=11>Novembro</option>";
                echo "<option value=12>Dezembro</option>";
            echo "</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            
            echo "<input type='hidden' name='codg' value=3>";
            echo "<input type='submit' value='Gerar relatório'/>";
            echo "</form>";
            */
            
            echo "</center>";
        }
        else if($codigo==3)
        {
            $idalt = $_GET['id'];
            $exc = $_GET['exc'];
            
            if($exc==0)
            {
                
                $sql = "update public.produto set excluido='s' where id_produt=$idalt";
                $dados = pg_query($conecta, $sql);

                $resultado=pg_query($conecta, $sql);
                $linhas=pg_affected_rows($resultado);

                if ($linhas > 0)
                {
                   $msg = "Produto excluído.";
                }
                else 
                {
                   $msg = "Erro SQL:".pg_last_error()."";
                }
                
                
            }
            else /*($exc==1)*/
            {
                
                $sql = "update public.produto set excluido='n' where id_produt=$idalt";
                $dados = pg_query($conecta, $sql);

                $resultado=pg_query($conecta, $sql);
                $linhas=pg_affected_rows($resultado);

                if ($linhas > 0)
                {
                   $msg = "Produto habilitado.";
                }
                else 
                {
                   $msg = "Erro SQL:".pg_last_error()."";
                }
                
            }
            
            
            
            echo"<script>
            {
                var texto ='$msg'+' Redirecionando para a lista novamente.';
                
                window.alert(texto)
                window.location.href = 'func_adm.php?codigo=0';
            }
            </script>";
            
            
            
            
            
            // Fecha a conexão com o PostgreSQL//
            pg_close($conecta);
        }
        
        else if($codigo==4)
        {
            $sql = "select * from public.usuario order by id_usuario";
            $dados = pg_query($conecta, $sql);
            
            
            $id;
            $nome;
            $cpf;
            $email;
            $senha;
            $tel;
            $cep;
            $nasc;
            $exc;
            
            $sn;
            
            echo "<center>";
            echo "<table border='9'>";
            echo "<tr><td>Id<td>Nome<td>Cpf<td>Email<td>Senha<td>Telefone<td>CEP<td>Data de nascimento<td>Excluído?<td>Alternar exclusão";
            while ($linha = pg_fetch_array($dados))
            {
                $id = $linha['id_usuario'];
                $nome = $linha['nome'];
                $cpf = $linha['cpf'];
                $email = $linha['email'];
                $senha = $linha['senha'];
                $tel = $linha['fone'];
                $cep = $linha['cep'];
                $nasc = $linha['nasc'];
                $exc = $linha['exc'];
                
                if($exc == "n" || $exc == "N")
                {
                    $sn=0;
                    $exc = "Não";
                }
                else if($exc == "s" || $exc == "S")
                {
                    $sn=1;
                    $exc = "Sim";
                }
                
                echo "<tr><td>".$id."<td>".$nome."<td>".$cpf."<td>".$email."<td>".$senha."<td>".$tel."<td>".$cep."<td>".$nasc."<td>".$exc."<td><a href=func_adm.php?codigo=5&id=".$id."&exc=".$sn."><img src='Imagens/exc_icon.png' height=50></a>";
                
                
            }
            echo "</table>";
            echo "</center>";
        }
            
        else if($codigo==5)
        {
            $idalt = $_GET['id'];
            $exc = $_GET['exc'];
            
            if($exc==0)
            {
                
                $sql = "update public.usuario set exc='s' where id_usuario=$idalt";
                $dados = pg_query($conecta, $sql);

                $resultado=pg_query($conecta, $sql);
                $linhas=pg_affected_rows($resultado);

                if ($linhas > 0)
                {
                   $msg = "Cliente excluído.";
                }
                else 
                {
                   $msg = "Erro SQL:".pg_last_error()."";
                }
                
                
            }
            else /*($exc==1)*/
            {
                
                $sql = "update public.usuario set exc='n' where id_usuario=$idalt";
                $dados = pg_query($conecta, $sql);

                $resultado=pg_query($conecta, $sql);
                $linhas=pg_affected_rows($resultado);

                if ($linhas > 0)
                {
                   $msg = "Cliente habilitado.";
                }
                else 
                {
                   $msg = "Erro SQL:".pg_last_error()."";
                }
                
            }
            
            echo"<script>
            {
                var texto ='$msg'+' Redirecionando para a lista novamente.';
                
                window.alert(texto)
                window.location.href = 'func_adm.php?codigo=4';
            }
            </script>";
            
            
            // Fecha a conexão com o PostgreSQL//
            pg_close($conecta);
            
            
        }
        
        
    }
    
    
    if ($_POST)
    {
        $codg = $_POST['codg'];
        
        if($codg==1)
        {
            
            $codn = $_POST['codn'];
            $nome = $_POST['nome'];
            $valor = $_POST['valor'];
            $cat = $_POST['cat'];
            $quant = $_POST['quant'];
            $exc = $_POST['exc'];
            
            
            $sql = "update public.produto set nome='$nome', valor=$valor, categoria=$cat, quant=$quant, excluido='$exc' where id_produt=$codn";
            $resultado=pg_query($conecta, $sql);
            $linhas=pg_affected_rows($resultado);

            if ($linhas > 0)
            {
               $msg = "Produto alterado.";
            }
            else 
            {
               $msg = "Erro SQL:".pg_last_error()."";
            }
            
            /*
            UPDATE DA IMAGEM
            \Imagens\homefotos
            
            $destino = '\Imagens\homefotos\ ' . $_FILES['arquivo']['name'];
            $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
            move_uploaded_file( $arquivo_tmp, $destino  );
            */
            
            $uploaddir = '/Imagens/homefotos/';
            $uploadfile = $uploaddir . basename($_FILES['arquivo']['name']);

            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile))
            {
                echo "Arquivo válido e enviado com sucesso.\n";
            }
            else
            {
                echo "Possível ataque de upload de arquivo!\n";
            }
            
            
            echo"<script>
            {
                var texto ='$msg'+' Redirecionando para a lista novamente.';
                
                window.alert(texto)
                window.location.href = 'func_adm.php?codigo=0';
            }
            </script>";
            
            
            // Fecha a conexão com o PostgreSQL//
            pg_close($conecta);
            
            
        }
        else if($codg==2)
        {
            
            $codn = $_POST['codn'];
            $nome = $_POST['nome'];
            $valor = $_POST['valor'];
            $cat = $_POST['cat'];
            $quant = $_POST['quant'];
            $exc = $_POST['exc'];
            
            
            $sql = "insert into public.produto (id_produt, nome, valor, categoria, quant, excluido) values ($codn, '$nome', $valor, $cat, $quant, '$exc')";
            $resultado=pg_query($conecta, $sql);
            $linhas=pg_affected_rows($resultado);

            if ($linhas > 0)
            {
               $msg = "Produto inserido.";
            }
            else 
            {
               $msg = "Erro SQL:".pg_last_error()."";
            }
            
            /*
            ENVIO DA IMAGEM
            \Imagens\homefotos
            */
            
            echo"<script>
            {
                var texto ='$msg'+' Redirecionando para a lista novamente.';
                
                window.alert(texto)
                window.location.href = 'func_adm.php?codigo=0';
            }
            </script>";
            
            
            // Fecha a conexão com o PostgreSQL//
            pg_close($conecta);
            
            
        }
        /*
        else if($codg==3)
        {
            $meee = $_POST['mee'];
            $anoat=date('Y');
            
            
            $sql = "select * from public.compra order by id_compra";
            $dados = pg_query($conecta, $sql);
            */
            /*
            $id_compra;
            $id_usuario;
            $quant;
            $valor;
            $data;
            $exc;
            */
            /*
            $mesnome;
            $vendas=0;
            $data;
            $valtot=0;
            $valliq=0;
            
            $meses = array("nada", "janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
            
            for($i=1;$i<=12;$i++)
            {
                if($meee==$i)
                {
                    $mesnome=$meses[$i];
                }
            }
            
            
            
            echo "<center>";
            echo "Exibindo os relatórios do mês de ";
            echo "$mesnome";
            
            echo "<br><table border='9'>";
            
            echo "<tr><td>Total de vendas";
            
            while ($linha = pg_fetch_array($dados))
            {
                $id_compra = $linha['id_compra'];
                $id_usuario = $linha['id_usuario'];
                $quant = $linha['quant'];
                $valor = $linha['valor'];
                $data = $linha['data'];
                $_SESSION['qtd2'] = $quant;*/
                /*
                //echo "'.$data.'<br>";
                $data=date('m',$data);
                //$data-=1;
                //echo "$data<br>";
                
                if($meee == $data)
                {
                    $vendas++;
                    $valtot+=$valor;
                    $valliq+=($valor-3*$quant);
                }
                */
                /*
                $dias="";
                if($meee == 1)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$meee=='".$di."/01/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/01/".$anoat."";
                }
                else if($meee == 2)
                {
                    for($di=1;$di<=28;$di++)
                    {
                        $dias.="$meee=='".$di."/02/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/02/".$anoat."";
                }
                else if($meee == 3)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$meee=='".$di."/03/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/03/".$anoat."";
                }
                else if($meee == 4)
                {
                    for($di=1;$di<=29;$di++)
                    {
                        $dias.="$meee=='".$di."/04/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/04/".$anoat."";
                }
                else if($meee == 5)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$meee=='".$di."/05/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/05/".$anoat."";
                }
                else if($meee == 6)
                {
                    for($di=1;$di<=29;$di++)
                    {
                        $dias.="$meee=='".$di."/06/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/06/".$anoat."";
                }
                else if($meee == 7)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$meee=='".$di."/07/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/07/".$anoat."";
                }
                else if($meee == 8)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$meee=='".$di."/08/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/08/".$anoat."";
                }
                else if($meee == 9)
                {
                    for($di=1;$di<=29;$di++)
                    {
                        $dias.="$meee=='".$di."/09/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/09/".$anoat."";
                }
                else if($meee == 10)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$meee=='".$di."/10/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/10/".$anoat."";
                }
                else if($meee == 11)
                {
                    $dias="";
                    for($di=1;$di<=29;$di++)
                    {
                        $dias.="$meee=='".$di."/11/".$anoat."' || ";
                    }
                    $dias.="$meee=='".$di."/11/".$anoat."'";
                }
                else if($meee == 12)
                {
                    for($di=1;$di<=30;$di++)
                    {
                        $dias.="$meee=='".$di."/12/".$anoat." || ";
                    }
                    $dias.="$meee=='".$di."/12/".$anoat."";
                }
                
                if(".$dias.")
                {
                    $vendas++;
                    $valtot+=$valor;
                    $valliq+=($valor-3*$quant);
                    
                }
                
                
            }
            
            $vendas = $id_compra;
            
            echo "<td>".$vendas."<tr>";
            echo "<td>Receita Bruta";
            echo "<td>".$valtot."<tr>";
            echo "<td>Receita Líquida";
            echo "<td>".$valliq."<tr>";
            echo "<td>Porcentagem de lucro:";
            
            
            if($valtot!==0)
            {
                $xxxx=($valliq*100)/$valtot;
            }
            else
            {
                $xxxx=0;
            }
            echo "<td>";
            echo round($xxxx, 2);
            echo " %<tr>";
            
            echo "</table>";
            
            echo "<br><br><br>";
            
            echo "<h2>Buscar resultado de outro mês:</h2>";
            
            echo "<form method='post' action='func_adm.php'>";
            
            echo "<select name='mee'>";
                echo "<option value=1>Janeiro</option>";
                echo "<option value=2>Fevereiro</option>";
                echo "<option value=3>Março</option>";
                echo "<option value=4>Abril</option>";
                echo "<option value=5>Maio</option>";
                echo "<option value=6>Junho</option>";
                echo "<option value=7>Julho</option>";
                echo "<option value=8>Agosto</option>";
                echo "<option value=9>Setembro</option>";
                echo "<option value=10>Outubro</option>";
                echo "<option value=11>Novembro</option>";
                echo "<option value=12>Dezembro</option>";
            echo "</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            
            echo "<input type='hidden' name='codg' value=3>";
            echo "<input type='submit' value='Gerar relatório'/>";
            echo "</center></form>";
            
            
        }*/
        
        
    }
    
    
           
    
    pg_close($conecta);
    
    /*
     ---------USUARIO--------
    create table usuario
    (
        id_usuario integer not null primary key,
        nome varchar not null,
        cpf varchar not null,
        email varchar not null unique,
        senha varchar not null,
        fone varchar not null,
        cep varchar not null,
        nasc date not null,
        exc BOOLEAN not null
    );

     ---------PRODUTO--------
     
     id_produt
     nome
     valor
     categoria
     
     create table produto
    (
        id_produto integer not null primary key,
        quantidade INT NOT NULL,
        valor NUMERIC (5,2) not null,
        estampa varchar,
        CONSTRAINT fk_idcat FOREIGN KEY(id_cat) references categoria(id_cat),
        excluido BOOLEAN not null
    );
    
    */
?>

                        <ul class="menu">
                        
                            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                            <hr>
                                                        <li>
                                <a href="home.php" style="text-decoration:none;">
                               <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home </h4></a>
                                
                            </li>
                            
                            <li>
                                <a href="comprar.php" style="text-decoration:none;">
                                <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Produtos</h4></a>
                            </li>
                            <li>
                                          <?php
                        if($_SESSION['logado'] == true){
                        echo '<a href="dados.php" style="text-decoration:none;">
                                <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login</h4> </a>
                        ' ;
                        }
                        else{
                        echo '<a href="login.php" style="text-decoration:none;">
                                <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login</h4> </a>
                        '; 
                            
                        }
                    ?>      
                            </li>
                            
                                                        <li>
                                <a href="sobre.php" style="text-decoration:none;">
                                <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEV</h4></a>
                            </li>
                            
                            
                            <li>
                                <a href="saiba.php" style="text-decoration:none;">
                                <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saiba mais</h4></a>
                            </li>
                            <br>
                            <br>
                        </ul>
                        <font size="5">
                        <ul class="menu">
                           <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                            <hr>
                            <li>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                02 Bruna Lemes 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li>04 César Gomes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li>10 Kemily Heleno</li>
                            <br>
                            <br>
                            <li>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                12 Lídia silva 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li>18 Natan Rosica &nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19 Paola Santos</li>
                            <br>
                            <hr>
                        </ul>
                        </font>
                </font>
          
        </div>
        
    </BODY>
</HTML>