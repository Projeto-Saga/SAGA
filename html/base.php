<div class="topbar rowalign">
    <a class="saga-titl" href="lobby">
        <img src="img/logo-n-forwhite.png">
    </a>

    <div id="top_bar" class="clmalign" style="margin-right:101px">
        <div class="rowalign">
            <a class="topbar-link" href="mybook">NOTAS E FALTAS</a>
            <a class="topbar-link" href="calendar">CALENDÁRIO</a>
            <a class="topbar-link" href="requests">SECRETARIA</a>
        </div>

        <hr class="topbar-hr">
    </div>

    <div class="saga-stud rowalign">
        <div class="stud-text clmalign">
            <p class="stud-name"><?php echo $name; ?></p>
            <p class="stud-mail"><?php echo $mail; ?></p>

            <div class="stud-hidden clmalign">
                <br>

                <a href="profile" class="stud-link">Meu Perfil</a>
                <hr style="width:calc(100% - 2px)">
                <a href="php/logout" class="stud-link">Desconectar</a>
            </div>
        </div>
        <div class="stud-ball" style="background-image:url(img/fotos/<?php echo $imge; ?>)"></div>
    </div>
</div>

<div id="sidebar" class="sidebar clmalign collapse">
    <img class="sidebar-menu" src="https://cc.sj-cdn.net/instructor/oq965j8f0qmg-zendesk/courses/1gkqtncquj9ay/promo-image.1661989652.png" onclick="show()">

    <div class="clmalign" style="gap:15px">
        <a class="sidebar-link" href="mybook">
            <div class="sidebar-icon"><img src="https://lapka.by/upload/iblock/e8e/literatura-po-shityu.png"></div>
            <div class="sidebar-label invobjct">Notas e Faltas</div>
        </a>
        <a class="sidebar-link" href="calendar">
            <div class="sidebar-icon"><img src="https://icon-library.com/images/calendar-icon-png/calendar-icon-png-2.jpg"></div>
            <div class="sidebar-label invobjct">Calendário</div>
        </a>
        <a class="sidebar-link" href="requests">
            <div class="sidebar-icon"><img src="https://cdn1.iconfinder.com/data/icons/business-705/70/reception__office__desk__employee__screen-512.png"></div>
            <div class="sidebar-label invobjct">Secretaria</div>
        </a>
    </div>
</div>