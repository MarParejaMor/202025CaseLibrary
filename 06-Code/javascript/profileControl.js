function profileImgPreview()
{
    let imageSource=getUploadedImg();
    const image=document.getElementById("profileImg");
    image.setAttribute("src",imageSource);
}
function getUploadedImg(){
	const imageInput=document.getElementById("profileImgInput");
	let imageSource=URL.createObjectURL(imageInput.files[0]);
    return imageSource;
}
//Colocar funciones para abrir y cerrar dialogs
