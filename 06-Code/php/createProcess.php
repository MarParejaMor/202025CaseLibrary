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
    $clientGender=$_POST['gender'];
    $clientAge=(int)($_POST['age']);
    //Creacion del codigo interno de caso

    $insertProcess=$conn->prepare("INSERT INTO 
    `process`(`title`, `offense`, `canton`, `province`, `account_id`, `process_type`, `process_description`,`client_gender`,`client_age`)
    VALUES (?,?,?,?,?,?,?,?,?)");
    $insertProcess->bind_param("ssssisssi", 
        $title,
        $conflict,
        $canton,
        $province,
        $account,
        $type,
        $description,
        $clientGender,
        $clientAge
    );
    if($insertProcess->execute())
    {
        $conn->close();
        header("Location: ../html/dashboard.php");
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