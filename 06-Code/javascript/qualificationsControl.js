const studyForm=document.forms['newStudyForm'];
studyForm.addEventListener("submit",function()
{
    event.preventDefault();
    const title=$('#titleIn').val();
    const institution=$('#instituteIn').val();
    const year=$('#yearIn').val();
    $.ajax({
    url: '../php/addStudyQualification.php',
    method: 'POST',
    data: { titleIn: title,
            instituteIn: institution,
            yearIn: year,
     },
    success: function(response) {
        alert(response);
        location.reload();
    },
    error: function(response) {
            alert("Error "+response);
            }
        });
});
