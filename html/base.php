<div class="topbar rowalign">
    <a class="saga-titl" href="lobby.php">
        <img src="img/logos/logo-n-forwhite.png">
    </a>

    <div class="darkmode">
        <button onclick="darkmode()">
            <img src="img/icons/darkmode-icon.png">
        </button>
    </div>

    <div id="top_bar" class="clmalign" style="margin-right:101px">
        <div class="rowalign">
            <a class="topbar-link" href="">CURSOS</a>
            <a class="topbar-link" href="">MATERIAIS</a>
            <a class="topbar-link" href="">PROJETOS</a>
        </div>

        <hr class="topbar-hr">
    </div>

    <div class="saga-stud rowalign">
        <div class="stud-text clmalign">
            <p class="stud-name"><?php echo $name ?></p>
            <p class="stud-mail"><?php echo $mail ?></p>

            <div class="stud-hidden clmalign">
                <br>

                <a href="profile.php" class="stud-link">Meu Perfil</a>
                <hr style="width:calc(100% - 2px)">
                <a href="php/logout.php" class="stud-link">Desconectar</a>
            </div>
        </div>
        <div class="stud-ball" style="background-image:url(img/fotos/<?php echo $imge ?>)"></div>
    </div>
</div>

<div id="sidebar" class="sidebar clmalign collapse">
    <img class="sidebar-menu" src="img/icons/menu-icon.png" onclick="show()">

    <div class="clmalign">
        <a class="sidebar-link" href="lobby.php">
            <div class="sidebar-icon"><img src="https://cdn-icons-png.flaticon.com/512/25/25694.png"></div>
            <div class="sidebar-label invobjct">Página Inicial</div>
        </a>
        <?php
        if ($flag == "A")
        {?>
        <a class="sidebar-link" href="mybook.php">
            <div class="sidebar-icon"><img src="https://lapka.by/upload/iblock/e8e/literatura-po-shityu.png"></div>
            <div class="sidebar-label invobjct">Notas e Faltas</div>
        </a>
        <?php
        }
        if ($flag == "P")
        {?>
        <a class="sidebar-link" href="setbook.php">
            <div class="sidebar-icon"><img src="https://lapka.by/upload/iblock/e8e/literatura-po-shityu.png"></div>
            <div class="sidebar-label invobjct">Atribuições</div>
        </a>
        <?php
        }?>
        <a class="sidebar-link" href="calendar.php">
            <div class="sidebar-icon"><img src="https://icon-library.com/images/calendar-icon-png/calendar-icon-png-2.jpg"></div>
            <div class="sidebar-label invobjct">Calendário</div>
        </a>
        <?php
        if ($flag == "A")
        {?>
        <a class="sidebar-link" href="requests.php">
            <div class="sidebar-icon"><img src="https://cdn1.iconfinder.com/data/icons/business-705/70/reception__office__desk__employee__screen-512.png"></div>
            <div class="sidebar-label invobjct">Secretaria</div>
        </a>
        <?php
        }?>
    </div>
</div>

<script>
    const elements = [".box", ".box1", ".box2", ".box3", ".topbar", ".post", ".saga-stud", ".darkmode", ".reqs-form-form", ".reqs-form-inpt",
                      ".reqs-form-data", ".topbar-link", ".topbar-hr", "body", ".calendar", ".header", ".month", ".days", ".day", ".holiday",
                      ".separate", "section", "h2", "button", "th", "table", ".weekdays", ".saga-titl", ".update-input", ".update-label", ".mainlabl"];

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