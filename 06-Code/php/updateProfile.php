<?php
session_start();
if(!isset($_SESSION["images"])||$_SESSION["images"]=="")
{
    include("uploadImage.php");
}
$imagelink=$_SESSION['images'];
include_once("db_connection.php");
$account=$_SESSION['account_id'];
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $name=$_POST["name"];
    $lastname=$_POST["lastname"];
    $title=$_POST["title"];
    $bio=$_POST["personalBio"];
    $phone=$_POST["phone"];
    $mail=$_POST["mail"];
    $address=$_POST['address'];

    //Query para actualizar info de la cuenta
    $updateAccountData=$conn->prepare("UPDATE `account` SET `name`=?, `lastname`=?,`phone_number`=?,`email`=? WHERE `account_id`=?");
    $updateAccountData->bind_param("ssssi", 
        $name,
        $lastname,
        $phone,
        $mail,
        $account
    );
    if($updateAccountData->execute())
    {
        echo("exito en la conexión");
    }
    else
    {
        die("Error al actualizar");
    }
    //Query para actualizar info del perfil
    $updateProfileData=$conn->prepare("UPDATE `user_profile` SET `title`=?, `bio`=?,`address`=?,`profile_picture`=? WHERE `account_id`=?");
    $updateProfileData->bind_param("ssssi", 
        $title,
        $bio,
        $address,
        $_SESSION["images"],
        $account
    );
    if($updateProfileData->execute())
    {
        $conn->close();
        header("Location: ../html/menuBar.html");
    }
    else
    {
        $conn->close();
        header("Location: ../html/menuBar.html");
    }
}
else
{
    echo("Metodo invalido");
}
?>