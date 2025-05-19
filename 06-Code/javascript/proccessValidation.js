function titleControl()
{
    let titleInput=document.getElementById('processTitle');
    if(!validateTitle())
    {
         titleInput.classList.add('is-invalid');
    }
    else
    {
         titleInput.classList.remove('is-invalid');
    }
}
function validateTitle()
{
    let title=document.getElementById('processTitle').value;
    const format=/^[a-zA-Z0-9áéíóúñÁÉÍÓÚN\s]{7,}$/;
    if(format.test(title))
    {
        return true
    }
    else
    {
        return false;
    }
}
function conflictControl()
{
    let conflictInput=document.getElementById('conflict');
    if(!validateConflict())
    {
         conflictInput.classList.add('is-invalid');
    }
    else
    {
         conflictInput.classList.remove('is-invalid');
    }
}
function validateConflict()
{
    let conflict=document.getElementById('conflict').value;
    const format=/^[a-zA-ZáéíóúñÁÉÍÓÚN\s]{7,}$/;
    if(format.test(conflict))
    {
        return true
    }
    else
    {
        return false;
    }
}
function cantonControl()
{
    let cantonInput=document.getElementById('canton');
    if(!validateCanton())
    {
         cantonInput.classList.add('is-invalid');
    }
    else
    {
         cantonInput.classList.remove('is-invalid');
    }
}
function validateCanton()
{
    let canton=document.getElementById('canton').value;
    const format=/^[a-zA-Z0-9áéíóúñÁÉÍÓÚN\s]{7,}$/;
    if(format.test(canton))
    {
        return true
    }
    else
    {
        return false;
    }
}
function descriptionControl()
{
    let descriptionInput=document.getElementById('description');
    if(!validateDescription())
    {
         descriptionInput.classList.add('is-invalid');
    }
    else
    {
         descriptionInput.classList.remove('is-invalid');
    }
}
function validateDescription()
{
    let description=document.getElementById('processDescription').value;
    let wordCount=description.match(/\S+/g).length;
    const format=/^[a-zA-Z0-9áéíóúñÁÉÍÓÚN\s]{7,}$/;
    if(format.test(description)&&wordCount>=10)
    {
        return true
    }
    else
    {
        return false;
    }
}
function validateProcessCreation()
{
    const inputValidations=[
        validateTitle(),
        validateConflict(),
        validateCanton(),
        validateDescription()
    ];
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