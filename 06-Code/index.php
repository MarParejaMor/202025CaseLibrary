<?php
session_start();
if(isset($_SESSION["account_id"]))
{
  header("Location: html/Pagina_principal.html");
}
else
{
  header("Location: html/LoginRegister.html");
}
?>