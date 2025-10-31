<script>
    const elements = [".box", ".box1", ".box2", ".box3", ".topbar", ".post", ".saga-stud", ".darkmode", ".reqs-form-form", ".reqs-form-inpt",
                      ".reqs-form-data", ".topbar-link", ".topbar-hr", "body", ".calendar", ".header", ".month", ".days", ".day", ".holiday",
                      ".separate", "section", "h2", "button", "th", "table", ".weekdays", ".saga-titl", ".update-input", ".update-label",
                      ".mainlabl", "footer", "footer div", ".maininpt", ".reqs-docs", "h1", "article div", "article div p",
                      ".FormCadastroSec > input", ".FormCadastroSec", "select"];

    function darkmode()
    {
        if (localStorage.getItem("darkmode") == 'N' ||
            localStorage.getItem("darkmode") == undefined)
        {
            localStorage.setItem("darkmode", 'S');
        }
        else if (localStorage.getItem("darkmode") == 'S')
        {
            localStorage.setItem("darkmode", 'N');
        }

        location.reload();
    }

    $(document).ready(function()
    {
        if (localStorage.getItem("darkmode") == 'N' ||
            localStorage.getItem("darkmode") == undefined)
        {
            $.each(elements, function(key, val)
            {
                $(val).removeClass("dark-mode");
            });
        }
        else if (localStorage.getItem("darkmode") == 'S')
        {
            $.each(elements, function(key, val)
            {
                $(val).addClass("dark-mode");
            });
        }
    });
</script>