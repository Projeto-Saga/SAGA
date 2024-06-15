$("#foto").on("change", function()
{
    $.ajax(
    {
        url: "php/upload.php",
        type: "POST",
        processData: false,
        contentType: false,
        data: new FormData($("#studform")[0])
    })
    .done(function(data)
    {
        location.refresh;
    });
});