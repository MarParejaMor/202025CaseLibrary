<?php
session_start();
$_SESSION["images"]="";
$allowedtypes= array("image/jpg","image/jpeg","image/png");
//Crea un directorio si no existe
if(!is_dir("../images"))
	{
		mkdir("../images",0777,true);
	}
if(isset($_FILES["profileImg"])){
    //Recibe un array asociativo (En vez de posiciones usa nombres)
	$image=$_FILES["profileImg"];
	$filename=$image["name"];
	$imageType=$image["type"];
	if(!in_array($imageType, $allowedtypes))
	{
		echo("Archivo incorrecto, extension invalida para el archivo $filename. Es tipo $imageType <br>");
	}
	else{
	$extension=".".substr($imageType,6,4);
	$filelocation="../images/profilePicture".$extension;
    if(file_exists($filelocation))
    {
        unlink($filelocation);
    }
    echo("Imagen quitada");
	if(move_uploaded_file($image["tmp_name"],$filelocation))
	{
        $_SESSION["images"]=$filelocation;
		header("Location: ../html/Perfil_privado.php");
	}
	else
	{
		echo("Subida fallida");
	}
}
}
else
{
	echo("Error al cargar la imagen");
}
?>