function updateListItemColors()
{
    var listItems = document.querySelectorAll(".media");

    for (var i = 0; i < listItems.length; i++)
    {
        var item = listItems[i];
        var itemValue = parseFloat(item.textContent);

        if (itemValue >= 0 && itemValue <= 5.99)
        {
            item.style.color = 'red';
        }
        else if (itemValue >= 6 && itemValue <= 10)
        {
            item.style.color = 'green';
        }
    }
}

function cicl_slct(cicl)
{
    $("#cicl").val(cicl);
    $("#studbook").submit();
}

function show_grds(objt)
{
    objt.hasClass("stud-hidden") ? objt.removeClass("stud-hidden") : objt.addClass("stud-hidden");
}

$(document).ready(function()
{
    updateListItemColors();
});