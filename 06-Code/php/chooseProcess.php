<?php
session_start();
$_SESSION["selected-process"]=0;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $_SESSION["selected-process"]=$_POST['process_id'];
    echo("Exito en la conexion");
}
else
{
    echo("Error en la conexion");
}
?>