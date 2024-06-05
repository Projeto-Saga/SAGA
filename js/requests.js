// trocar de aba
function form(iden)
{
    for (var i = 0; i <= 6; i++)
    {
        $(`#form_${i}`).addClass("stud-hidden");
    }
    
    $(`#form_${iden}`).removeClass("stud-hidden");
}

// selecionar matéria
function tick(iden)
{
    var trgt = document.getElementById('aprv_mat'+iden);
    
    trgt.checked == true ? trgt.checked = false : trgt.checked = true;
}

// subir arquivo
function file(iden)
{
    var trgt = document.getElementById("file"+iden);
    trgt.click();
    
    trgt.addEventListener('change', function(event)
    {
        document.getElementById('file_show'+iden).value = trgt.files[0].name;
    });
}