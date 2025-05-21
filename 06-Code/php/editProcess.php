<?php
session_start();
$processId=$_SESSION["selected-process"];
include("db_connection.php");
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $title=$_POST["title"];
    $type=$_POST["type"];
    $conflict=$_POST["conflict"];
    $province=$_POST["province"];
    $canton=$_POST["canton"];
    $description=$_POST["description"];
    $clientGender=$_POST['gender'];
    $clientAge=$_POST['age'];
    $editQuery = $conn->prepare("UPDATE `process` SET `title`=?,`offense`=?,`client_gender`=?,
    `client_age`=?,`canton`=?,`province`=?,`process_type`=?,`process_description`=?  WHERE process_id='$processId'");
    $editQuery->bind_param("sssissss",
    $title,
    $conflict,
    $clientGender,
    $clientAge,
    $canton,
    $province,
    $type,
    $description
    );
    if($editQuery->execute())
    {
        echo("Cambios guardados con exito");
    }
    else
    {
        echo("Error al guardar los cambios");
    }

}
else
{
    echo("método de conexión inválido");
}
?>