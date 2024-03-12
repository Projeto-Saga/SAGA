<div class="topbar rowalign">
    <a class="saga-titl" href="lobby.php">
        <img src="img/logo-n-forwhite.png">
    </a>

    <div id="top_bar" class="clmalign" style="margin-right:101px;">
        <div class="rowalign">
            <a class="topbar-link" href="mybook.php">NOTAS E FALTAS</a>
            <a class="topbar-link" href="calendar.php">CALENDÁRIO</a>
            <a class="topbar-link" href="requests.php">SECRETARIA</a>
        </div>

        <hr class="topbar-hr">
    </div>

    <div class="saga-stud rowalign">
        <div class="stud-text clmalign">
            <p class="stud-name"><?php echo $name; ?></p>
            <p class="stud-mail"><?php echo $mail; ?></p>

            <div class="stud-hidden clmalign">
                <br>

                <a href="profile.php" class="stud-link">Meu Perfil</a>
                <hr style="width:calc(100% - 2px);">
                <a href="logout.php" class="stud-link">Desconectar</a>
            </div>
        </div>
        <div class="stud-ball" style="background-image:url(img/fotos/<?php echo $imge; ?>);"></div>
    </div>
</div>

<div id="sidebar" class="sidebar clmalign collapse">
    <img class="sidebar-menu" src="img/hbm-menuicon.png" onclick="show();">

    <div class="clmalign">
        <a class="sidebar-link" href="mybook.php">
            <img class="sidebar-icon" src="img/notas-icon.png">
            <div class="sidebar-label invobjct">Notas e Faltas</div>
        </a>
        <hr class="sidebar-hr">
        <a class="sidebar-link" href="calendar.php">
            <img class="sidebar-icon" src="img/calendario-icon.png">
            <div class="sidebar-label invobjct">Calendário</div>
        </a>
        <hr class="sidebar-hr">
        <a class="sidebar-link" href="requests.php">
            <img class="sidebar-icon" src="img/secretaria-icon.png">
            <div class="sidebar-label invobjct">Secretaria</div>
        </a>
    </div>
</div>