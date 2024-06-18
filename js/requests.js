// trocar de aba
function form(iden)
{
    for (var i = 0; i <= 6; i++)
    {
        $(`#form_${i}`).addClass("stud-hidden");
    }
    
    $(`#form_${iden}`).removeClass("stud-hidden");
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

// selecionar matéria
function chck(trgt)
{
    trgt.hasClass("actv") ? trgt.removeClass("actv") : trgt.addClass("actv");

    trgt.find("input").is(":checked") ? trgt.find("input").prop("checked", false) : trgt.find("input").prop("checked", true);
}