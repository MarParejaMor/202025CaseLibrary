<?php
session_start();
if(isset($_SESSION["account_id"]))
{
  header("Location: html/Pagina_principal.php");
}
else
{
  header("Location: html/LoginRegister.html");
}
?>