function enableEdition()
{
    const inputs=document.getElementsByTagName("input");
   const selects=document.getElementsByTagName("select");
   const buttons=document.getElementById("buttonContainer");
   for(let i=0;i<inputs.length;i++)
   {
        inputs[i].removeAttribute("disabled");
   }
   for(let i=0;i<selects.length;i++)
   {
        selects[i].removeAttribute("disabled");
   }
   buttons.classList.remove("visually-hidden");
}
const mform=document.forms['processEditionForm'];
mform.addEventListener("submit",function()
{
    event.preventDefault();
    const title=$('title').val();
    const type=$('processType').val();
    const conflict=$('conflict').val();
    const resume=$('processResume').val();
    const gender=$('gender').val();
    const age=$('age').val();
    const province=$('province').val();
    const canton=$('canton').val();
    $.ajax({
    url: '../php/editProcess.php',
    method: 'POST',
    data: { title: title,
            type: type,
            conflict: conflict,
            province: province,
            description: resume,
            canton: canton,
            age: age,
            gender: gender
     },
    success: function(response) {
        alert(response);
        Location.reload();
    },
    error: function(response) {
            alert(response);
            }
        });
});
