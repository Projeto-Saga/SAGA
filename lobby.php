<!DOCTYPE html>
<html>
<head>
    <?php include('html/head.php'); ?>
</head>
<body>
<?php
if (!isset($_SESSION['ativ'])) {
    header('location:index.php');
    exit;
}

include('html/base.php');
?>

<div class="container fanimate">

    <h2 class="welcome-msg">
        <?php
        switch ($flag) {
            case 'A': echo "Bem-vindo, $name! Confira seus cursos, materiais e notas."; break;
            case 'P': echo "Bem-vindo, Professor $name! Aqui você pode lançar notas e faltas dos alunos."; break;
            case 'S': echo "Bem-vindo à Secretaria, $name! Gerencie usuários, turmas e relatórios."; break;
        }
        ?>
    </h2>

    <div class="grid-box-1">
        <div class="box1">
            <?php
            $rst1 = mysqli_query($conn, "SELECT * FROM evento");
            if (mysqli_affected_rows($conn) > 0) {
                while ($a = mysqli_fetch_array($rst1)) {
                    echo "<div id=\"post_$a[0]\" class=\"post\">
                            <img src=\"img/slides/$a[7]-feed.png\">
                            <h2>$a[2]</h2>
                            <p>$a[5]</p>
                            <button class=\"info\" onclick=\"modal($('#evento_$a[0]'))\">info.</button>
                          </div>";
                }
            } else {
                echo "Nenhum Evento Disponível";
            }
            ?>
        </div>

        <div class="grid-box-2">
            <div class="box2">
                <div class="slider">
                    <div class="slides">
                        <input type="radio" name="radio-btn" id="radio1">
                        <input type="radio" name="radio-btn" id="radio2">
                        <input type="radio" name="radio-btn" id="radio3">

                        <div class="slide first"><img src="img/slides/1-carousel.png"></div>
                        <div class="slide second"><img src="img/slides/2-carousel.png"></div>
                        <div class="slide third"><img src="img/slides/3-carousel.png"></div>
                    </div>

                    <div class="manual-navigation">
                        <label for="radio1" class="manual-btn"></label>
                        <label for="radio2" class="manual-btn"></label>
                        <label for="radio3" class="manual-btn"></label>
                    </div>
                </div>
            </div>

            <div class="grid-box-3">
                <div class="box3">
                    <h3 style="margin:0; text-align:center; font-weight:800">Sobre Nós</h3><br>
                    <p style="margin:0; text-align:justify; font-weight:500; text-indent:60px">
                        Fundado em 2024 em Mauá, São Paulo, o SAGA surgiu com a missão de transformar a gestão educacional através da tecnologia. Nossa plataforma foi criada para atender às necessidades de instituições de ensino, facilitando a administração acadêmica e promovendo uma experiência educacional mais eficiente e integrada.
                    </p><br>
                    <p style="margin:0; text-align:justify; font-weight:500; text-indent:60px">
                        No SAGA, acreditamos que a educação é a base para um futuro melhor. Nossa missão é fornecer ferramentas inovadoras que simplifiquem a gestão acadêmica, permitindo que educadores e administradores se concentrem no que realmente importa: o aprendizado dos alunos. Buscamos constantemente aprimorar nossa plataforma para garantir que as instituições de ensino possam operar de forma mais organizada e eficaz.
                    </p>
                </div>
                <div class="box3">
                    <footer class="rowalign">
                        <div>
                            <img src="img/icons/phone-icon.png">
                            <p>(11) 4545-2024</p>
                            <p>(11) 9 9045-2024</p>
                        </div>
                        <div>
                            <img src="img/icons/mail-icon.png">
                            <p>atendimento@maltec.sp.gov.br</p>
                            <p>suporte@maltec.sp.gov.br</p>
                            <p>suporte2@maltec.sp.gov.br</p>
                        </div>
                        <div>
                            <img src="img/icons/insta-icon.png">
                            <p>@saga_maltecmaua</p>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <!-- modals -->
    <?php
    $rst2 = mysqli_query($conn, "SELECT * FROM evento");
    while ($b = mysqli_fetch_array($rst2)) { ?>
        <div id="evento_<?php echo $b[0] ?>" class="modal" style="visibility:hidden; opacity:0">
            <div class="informt-card">
                <div class="card-imge" style="background-image:url('img/slides/<?php echo $b[7] ?>-modal.png')"></div>
                <div class="card-text">
                    <p><?php echo $b[1] ?></p>
                    <h4><?php echo $b[2] ?></h4>
                    <p><?php echo date("d/m/Y", strtotime($b[3])) ?></p>
                    <p><?php echo "Local: $b[4]" ?></p>
                    <p><?php echo $b[5] ?></p>
                    <p><?php echo "Duração: $b[6] hora(s)" ?></p>
                </div>
                <button class="card-exit" onclick="modal($('#evento_<?php echo $b[0] ?>'))">X</button>
            </div>
        </div>
    <?php } ?>

</div>
<script src="js/lobby.js"></script>
</body>
</html>
