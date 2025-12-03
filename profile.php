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

        <div class="container fanimate">
            <form id="studform" class="box interface" method="POST" enctype="multipart/form-data" action="php/update.php">
                <input name="iden" hidden readonly value="<?php echo $iden ?>">

                <div class="rowalign grid-g15">
                    <div class="clmalign" style="width:50%; justify-content:unset">
                        <!-- seção: básico -->
                        <h1 class="update-group" style="margin-top:0">Básico</h1>
                        <label class="update-label">Nome</label>
                        <input class="update-input" type="text" value="<?php echo $name ?>" disabled>

                        <label class="update-label">CPF</label>
                        <input class="update-input" type="text" value="<?php echo $codg ?>" disabled>

                        <label class="update-label">Senha</label>
                        <input name="senh" class="update-input" type="text" value="<?php echo $pass ?>">

                        <!-- seção: contatos -->
                        <h1 class="update-group">Contato</h1>
                        <label class="update-label">Telefones</label>
                        <input name="fone" class="update-input" type="text" placeholder="(00) 90000-0000" value="<?php echo $fone ?>" oninput="mask(this, 'fone')" maxlength="15">
                        <?php
                        $cmd2 = "SELECT nmro_fone, iden_fone FROM telefone WHERE iden_user=$iden";
                        $rst2 = mysqli_query($conn, $cmd2);

                        if (mysqli_affected_rows($conn) > 0)
                        {
                            while ($b = mysqli_fetch_array($rst2))
                            {?>
                        <div class="rowalign" style="align-items:center">
                            <input class="update-input" style="width:calc(100% - 35px)" value="<?php echo $b[0] ?>" oninput="mask(this, 'fone')" maxlength="15" disabled>
                            <input class="demibutn" style="width:35px" type="button" value="X" onclick="updt('fone', <?php echo $b[1] ?>)">
                        </div>
                            <?php
                            }
                        }

                        $cmd3 = "SELECT COUNT(iden_user) FROM telefone WHERE iden_user=$iden";
                        $rst3 = mysqli_query($conn, $cmd3);

                        if (mysqli_fetch_array($rst3)[0] < 2)
                        {?>
                        <div class="rowalign" style="align-items:center">
                            <input name="novo" class="update-input" style="width:50%" type="text" placeholder="(00) 90000-0000" oninput="mask(this, 'fone')" maxlength="15">
                            <input class="demibutn" type="button" value="Adicionar Telefone" onclick="updt('fone')">
                        </div>
                        <?php
                        }?>
                    </div>

                    <div class="clmalign" style="width:50%; justify-content:unset">
                        <!-- seção: institucional -->
                        <h1 class="update-group" style="margin-top:0">Institucional</h1>
                        <label class="update-label">RA</label>
                        <input class="update-input" type="text" value="<?php echo $rmat ?>" disabled>

                        <label class="update-label">Curso</label>
                        <input class="update-input" type="text" value="<?php echo $curs ?>" disabled>

                        <label class="update-label">E-Mail</label>
                        <input class="update-input" type="text" value="<?php echo $mail ?>" disabled>

                        <!-- seção: adicional -->
                        <h1 class="update-group">Adicional</h1>
                        <label class="update-label">Foto</label>
                        <div class="rowalign" style="align-items:center">
                            <input id="foto" name="foto" type="file" accept=".png, .jpg, .jpeg" hidden>

                            <input class="update-input" style="width:50%" type="text" value="<?php echo (!empty($imge) ? "$imge.jpg" : "selecionar") ?>" disabled>
                            <input class="demibutn" type="button" value="Adicionar Foto" onclick="$('#foto').click()">
                        </div>
                    </div>
                </div>

                <div class="rowalign grid-g15">
                    <input class="mainbutn" type="button" value="Salvar Alterações" onclick="updt('altr')">
                    <input class="mainbutn" type="button" value="Visualizar Carteirinha" onclick="modal($('#studcard'))">
                </div>
            </form>
            
            <!-- carteirinha -->
            <div id="studcard" class="modal" style="visibility:hidden; opacity:0">
                <div class="student-card">
                    <div class="card-imge" style="background-image: url('img/<?php echo $imge != null ? "fotos/$imge.jpg" : "foto-icon.png"; ?>');"></div>
                    <div class="card-text">
                        <h4><?php echo $name ?></h4>
                        <p>MATRÍCULA: <?php echo $regx ?></p>
                        <p><?php echo "$cicl"."º CICLO" ?></p>
                        <p><?php echo $curs ?></p>
                        <p><?php echo $mail ?></p>
                    </div>
                    <button class="card-exit" onclick="modal($('#studcard'))">X</button>
                </div>
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