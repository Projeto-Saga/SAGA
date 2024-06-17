function show()
{
    var sbar = document.getElementById("sidebar");
    var lbls = document.getElementsByClassName("sidebar-label");
    var line = document.getElementsByClassName("sidebar-hr");

    if (sbar.classList.contains("collapse"))
    {
        sbar.classList.remove("collapse");
        
        for (var i = 0; i < lbls.length; i++)
        {
            lbls[i].classList.remove("invobjct");
        }
    }
    else
    {
        sbar.classList.add("collapse");

        for (var i = 0; i < lbls.length; i++)
        {
            lbls[i].classList.add("invobjct");
        }
    }
}

function modal(modal)
{
    if (modal.css("visibility") == "hidden")
    {
        modal.css("visibility", "visible");
        modal.css("opacity", 1);
    }
    else
    {
        modal.css("opacity", 0);
        modal.css("visibility", "hidden");
    }
}