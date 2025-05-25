<?php
session_start();
include("db_connection.php");
$account=$_SESSION['account_id'];
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $title=$_POST["titleIn"];
    $institution=$_POST["instituteIn"];
    $year=$_POST["yearIn"];
    $type="studies";
    //Creacion del codigo interno de caso

    $insertStudy=$conn->prepare("INSERT INTO 
    `qualification`(`role`, `institution`, `startYear`,`qualification_type`,`profile_id`)
    VALUES (?,?,?,?,?)");
    $insertStudy->bind_param("ssssi", 
        $title,
        $institution,
        $year,
        $type,
        $account
    );
    if($insertStudy->execute())
    {
        $conn->close();
        echo("Agregado con exito");
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