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
    modal.removeClass("hidden");
}