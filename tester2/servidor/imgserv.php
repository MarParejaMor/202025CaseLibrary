<?php
if(isset($_FILES["file"])){
	$file=$_FILES['file'];
	$filename=$file['name'];
	$filetype=$file['type'];
	
	$allowedtypes=array("image/jpg","image/jpeg","image/png");
	
	if(in_array($filteype,$allowedtypes))
	{
		header("Location:index.php");
	}
	
	if(!is_dir("uploads"))
	{
		mkdir("uploads",0777);
	}
	
	move_uploaded_file($file["tmp_name"],"uploads/".$filename);
		
} else{
	header("Location:index.php");
}
?>