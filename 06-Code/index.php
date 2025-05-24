<?php
session_start();
if(isset($_SESSION["account_id"]))
{
  header("Location: html/menuBar.html");
}
else
{
  header("Location: html/loginRegister.html");
}
?>
