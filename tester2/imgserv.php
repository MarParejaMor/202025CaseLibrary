<?php
$allowedtypes= array("image/jpg","image/jpeg","image/png");
if(!is_dir("imagenes"))
	{
		mkdir("imagenes",0777,true);
	}
//$fi = new FilesystemIterator('imagenes/Producto'.$prodnum);
//$imgnum=iterator_count($fi)+1;
if(isset($_FILES["imagen"])){
	echo("Imagen detectada<br>");
	$mfiles=$_FILES["imagen"];
	//$x=count($_FILES["imagen"]["name"]);
	//for($i=0;$i<$x;$i++){
	$filename=$mfiles["name"];
	$filetype=$mfiles["type"];
	if(!in_array($filetype, $allowedtypes))
	{
		echo("Archivo incorrecto, extension invalida para el archivo $filename. Es tipo $filetype <br>");
	}
	else{
	$extension=".png";
	$filelocation="imagenes/img1".$extension;
	$filelocation=(string)$filelocation;
	if(move_uploaded_file($mfiles["tmp_name"],$filelocation))
	{
		echo("subida exitosa de la imagen".$filelocation);
		header("Location: index.html");
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