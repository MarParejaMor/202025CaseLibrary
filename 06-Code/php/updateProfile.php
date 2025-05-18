<?php
session_start();
if($_SESSION["images"]=="")
{
    include("uploadImage.php");
}
?>