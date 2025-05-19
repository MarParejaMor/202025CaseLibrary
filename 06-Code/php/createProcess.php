<?php
session_start();
include("db_connection.php");
$account=$_SESSION['account_id'];
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $title=$_POST["processTitle"];
    $type=$_POST["processType"];
    $conflict=$_POST["conflict"];
    $province=$_POST["province"];
    $canton=$_POST["canton"];
    $description=$_POST["processDescription"];

    //Creacion del codigo interno de caso

    $insertProcess=$conn->prepare("INSERT INTO `process`(`title`, `type`, `offense`, `canton`, `province`, `account_id`, `process_type`, `process_description`) 
    VALUES (?,?,?,?,?,?,?,?)");
    $insertProcess->bind_param("ssssssss", 
        $title,
        $type,
        $conflict,
        $canton,
        $province,
        $account,
        $type,
        $description
    );
    if($insertProcess->execute())
    {
        header("Location: ../html/Pagina_principal.php");
    }
    else
    {
        die("Insercion fallida");
    }
}
else
{
    echo("Metodo invalido");
}
?>