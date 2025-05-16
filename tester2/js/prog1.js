// JavaScript Document
const extension=[];
function recuperar(){
	const indice=Number(document.getElementById("indice").value);
	const nombreimg=document.getElementById("imageIn").files[0].type;
	extension[indice]=nombreimg;
}
function mostrar(){
	const imagen=document.getElementById("myimg");
	imagen.setAttribute("src","imagenes/img")
}