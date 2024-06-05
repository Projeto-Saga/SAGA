<!DOCTYPE html>
<html>
    <head>
        <?php include('html/head.php'); ?>
    </head>
    <body>
        <?php
        if (isset($_SESSION['ativ']))
        {
            include('html/base.php');
        ?>

        <div class="content fanimate">
            <form id="studform" class="box" enctype="multipart/form-data">
                <div class="clmalign">
                    <h1 class="update-group" style="margin-top:0;">Básico</h1>
                    <label class="update-label">Nome</label>
                    <input type="text" class="update-input" value="<?php echo $name; ?>" disabled>
                    <label class="update-label">CPF</label>
                    <input type="text" class="update-input" value="<?php echo $codg; ?>" disabled>
                    <label class="update-label">Senha</label>
                    <input name="pass" type="text" class="update-input" value="<?php echo $pass; ?>">
                    <h1 class="update-group">Institucional</h1>
                    <label class="update-label">RA</label>
                    <input type="text" class="update-input" value="<?php echo sprintf("%010d", $rmat) ?>" disabled>
                    <label class="update-label">Curso</label>
                    <input type="text" class="update-input" value="<?php echo $curs; ?>" disabled>

                    <h1 class="update-group">Contato</h1>
                    <label class="update-label">Telefone 1</label>
                    <input id="slctfone" name="exclfone" type="hidden">
                    <input name="fone" type="text" class="update-input" placeholder="(00) 90000-0000" value="<?php echo $fone; ?>" oninput="mask(this, 'fone');" minlength="15" maxlength="15">
                    <?php
                    $cmd2 = "SELECT nmro_fone,iden_fone FROM telefone WHERE iden_alun='$iden'";
                    $rst2 = mysqli_query($conn, $cmd2);

                    if (mysqli_affected_rows($conn) > 0)
                    {
                        $cont = 2;

                        while ($b = mysqli_fetch_array($rst2))
                        {
                    echo "<label class=\"update-label\">Telefone $cont</label>
                    <div class=\"rowalign\" style=\"align-items:center;\">
                        <input name=\"fone$b[1]\" style=\"width:50%;\" type=\"text\" class=\"update-input disabled\" value=\"$b[0]\" oninput=\"mask(this, 'fone');\" minlength=\"15\" maxlength=\"15\" disabled>
                        <input name=\"done\" class=\"demibutn\" type=\"submit\" value=\"X\" onmouseover=\"slct_fone('fone$b[1]')\">
                    </div>";

                            $cont += 1;
                        }
                    }
                    ?>
                    <div class="rowalign" style="align-items:center;">
                        <input name="novofone" style="width:50%;" type="text" class="update-input" placeholder="(00) 90000-0000" oninput="mask(this, 'fone');" minlength="15" maxlength="15">
                        <input id="" type="button" class="demibutn" value="Adicionar Telefone">
                    </div>

                    <div class="rowalign grid-g15">
                        <input id="" type="button" class="mainbutn" value="Salvar Alterações">
                        <input id="" type="button" class="mainbutn" value="Visualizar Carteirinha" onclick="modal($('#studcard'))">
                    </div>
                </div>
            </form>

            <div id="studcard" class="modal hidden">
                <form id="stud_card" class="student-card" method="POST" enctype="multipart/form-data" action="php/upload.php">
                    <div class="rowalign">
                        <input id="file_foto" name="file_foto" type="file" hidden="true">

                        <div id="card_imge" class="card-imge">
                            <img src="img/<?php echo $imge != null ? "fotos/$imge" : "foto-icon.png" ?>">
                        </div>
                    </div>
                    <p class="card-name"><?php echo $name ?></p>
                    <p class="card-text">MATRÍCULA <?php echo sprintf("%010d", $rmat) ?></p><br>
                    <p class="card-text"><?php echo "$cicl"."º CICLO" ?></p>
                    <p class="card-text"><?php echo $curs ?></p>
                    <p class="card-text"><?php echo $mail ?></p><br>
                </form>
            </div>
        </div>
        <?php 
        }
        else
        {
            header('location:index.php');
        }
        ?>
    </body>
</html>

<script src="js/profile.js"></script>