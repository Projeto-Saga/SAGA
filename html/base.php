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
            <a class="topbar-link" href="courses.php">CURSOS</a>
            <a class="topbar-link" href="material.php">MATERIAIS</a>
            <a class="topbar-link" href="projects.php">PROJETOS</a>
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

        <?php if ($flag == 'A'): ?>
            <a class="sidebar-link" href="mybook.php">
                <div class="sidebar-icon"><img src="https://static.thenounproject.com/png/903291-200.png"></div>
                <div class="sidebar-label invobjct">Notas e Faltas</div>
            </a>
            <a class="sidebar-link" href="requests.php">
                <div class="sidebar-icon"><img src="https://cdn1.iconfinder.com/data/icons/business-705/70/reception__office__desk__employee__screen-512.png"></div>
                <div class="sidebar-label invobjct">Secretaria</div>
            </a>
        <?php elseif ($flag == 'P'): ?>
            <a class="sidebar-link" href="launchGrades.php">
                <div class="sidebar-icon"><img src="img/icons/grades-icon.png"></div>
                <div class="sidebar-label invobjct">Lançar Notas</div>
            </a>
            <a class="sidebar-link" href="launchAttendance.php">
                <div class="sidebar-icon"><img src="img/icons/attendance-icon.png"></div>
                <div class="sidebar-label invobjct">Lançar Faltas</div>
            </a>
        <?php elseif ($flag == 'S'): ?>
            <a class="sidebar-link" href="adminPanel.php">
                <div class="sidebar-icon"><img src="https://cdn-icons-png.flaticon.com/512/709/709579.png"></div>
                <div class="sidebar-label invobjct">Painel da Secretaria</div>
            </a>
        <?php endif; ?>

        <a class="sidebar-link" href="calendar.php">
            <div class="sidebar-icon"><img src="https://eurovisionohlala.com/images/icones/by_year.png"></div>
            <div class="sidebar-label invobjct">Calendário</div>
        </a>
    </div>
</div>