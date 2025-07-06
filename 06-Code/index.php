<?php
session_start();
if(isset($_SESSION["account_id"]))
{
  header("Location: html/menuBar.php");
}
else
{
  header("Location: html/loginRegister.html");
}
?>
