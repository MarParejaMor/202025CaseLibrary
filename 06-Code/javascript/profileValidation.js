function nameControl(inputId)
{
    let nameInput=document.getElementById(inputId);
    if(!validateName(inputId))
    {
         nameInput.classList.add('is-invalid');
    }
    else
    {
         nameInput.classList.remove('is-invalid');
    }
}
function validateName(inputId)
{
    let name=document.getElementById(inputId).value;
    const format=/^[a-zA-ZáéíóúñÁÉÍÓÚN\s]{2,}$/;
    if(format.test(name))
    {
        return true
    }
    else
    {
        return false;
    }
}
function phoneControl()
{
    const phoneInput=document.getElementById('phone');
    if(!validatePhone())
    {
        phoneInput.classList.add('is-invalid');
    }
    else
    {
        phoneInput.classList.remove('is-invalid');
    }
}
function validatePhone()
{
    let phone=document.getElementById('phone').value;
    const format=/^09{1}[0-9]{8}$/;
    if(format.test(phone))
    {
        return true
    }
    else
    {
        return false;
    }
}
function mailControl()
{
    const mailInput=document.getElementById('mail');
    if(!validateMail())
    {
        mailInput.classList.add('is-invalid');
    }
    else
    {
        mailInput.classList.remove('is-invalid');
    }
}
function validateMail()
{
    let mail=document.getElementById("mail").value;
    let format=/(?=.+\@)(?=.+\.)[a-zA-Z0-9]{2,}\@{1}[a-z]{5,}\.{1}[a-z]{2,}/;
    if(format.test(mail))
    {
        return true;
    }
    else
    {
        return false;
    }
}
function addressControl()
{
    const mailInput=document.getElementById('address');
    if(!validateAddress())
    {
        mailInput.classList.add('is-invalid');
    }
    else
    {
        mailInput.classList.remove('is-invalid');
    }
}
function validateAddress()
{
    let mail=document.getElementById("address").value;
    let format=/[a-zA-Z0-9áéíóúñÁÉÍÓÚN\s\.\,\-]{6,}/;
    if(format.test(mail))
    {
        return true;
    }
    else
    {
        return false;
    }
}
function imageControl()
{
    const imageInput=document.getElementById('profileImg');
    if(!validateImage())
    {
        imageInput.classList.add('is-invalid');
    }
    else
    {
        imageInput.classList.remove('is-invalid');
    }
}
function validateImage()
{
    let imageSource=document.getElementById("profileImg").getAttribute('src');
    if(imageSource != "../images/blank-profile-picture.png")
    {
        return true;
    }
    else
    {
        return false;
    }
}

function formSubmissionControl()//Controla el envio
{
    if(!validateFormSubmission())
    {
        return false;
    }
    else
    {
        console.log("envia");
        return true;
    }
}
function validateFormSubmission()
{
    const inputValidations=[];
    inputValidations.push(validateName("name"));
    console.log("Validando nombre");
    inputValidations.push(validateName("lastname"));
    console.log("Validando apellido");
    inputValidations.push(validatePhone());
    console.log("Validando telefono");
    inputValidations.push(validateMail());
    console.log("Validando correo");
    inputValidations.push(validateAddress());
    console.log("Validando direccion");
    inputValidations.push(validateImage());
    console.log("Validando imagen");
    let isFormReady=true;
    for(let i=0; i<inputValidations.length; i++)
    {
        if(inputValidations[i]==false)
        {
            isFormReady=false;
            console.log("Validacion fallida, no se envia");
        }
    }
    return isFormReady;
}