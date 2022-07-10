<?php

include "minhasfuncoes.php";



if ($_POST)  {
   echo "<br>Recuperando a senha...";
   $NovaSenha = GeraSenha();
   
   if (EnviaEmail ( $_POST['login'], "Recuperação de Senha", "<html><body>Sua nova senha: <b>".$NovaSenha."</b></body></html>", "Suporte" ))
   {
      if (ExecutaSQL("update public.usuario set senha='".$NovaSenha."' where email='".$_POST['login']."'"))
          {
            echo "<br>Senha gerada com sucesso!";
            echo'<script>
            {
                alert("Senha alterada com sucesso!\nNova senha enviada pelo e-mail inserido!");
                window.location.href = "login.php";
            }
            </script>';
          
          }
          else
          {
              echo"<script>
            {
                window.alert('É preciso criar a tabela!')
                window.location.href = 'login.php';
            }
            </script>";
          }
       
   }
   
   else
   {
       echo"<script>
            {
                window.alert('Erro ao enviar e-mail!')
                window.location.href = 'login.php';
            }
            </script>";
   }
}



?>