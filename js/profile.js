$("#foto").on("change", function()
{
    $.ajax(
    {
        url: "php/upload.php",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        data: new FormData($("#studform")[0])
    })
    .done(function(data)
    {
        if (data.success)
        {
            alert(data.message);
            location.reload();
        }
        else
        {
            alert(data.message)
        }
    });
});

function updt(type, item = null)
{
    $.ajax(
    {
        url: "php/update.php",
        type: "POST",
        dataType: "json",
        data: $("#studform").serialize()+`&type=${type}&item=${item}`
    })
    .done(function(data)
    {
        if (data.success)
        {
            alert(data.message);
            location.reload();
        }
        else
        {
            alert(data.message)
        }
    });
}