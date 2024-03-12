$(document).ready(function()
{
    $(".book-cicles-item").click(function()
    {
        var index = $(this).index();
        
        $(".book-cicles-item").removeClass("active");
        $(this).addClass("active");
        $(".content").removeClass("active");
        $(".content").eq(index).addClass("active");
    });
});

function updateListItemColors()
{
    var listItems = document.querySelectorAll('.medias');

    for (var i = 0; i < listItems.length; i++)
    {
        var item = listItems[i];
        var itemValue = parseInt(item.textContent);

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

document.addEventListener('DOMContentLoaded', updateListItemColors);