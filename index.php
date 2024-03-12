<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php include("html/head.php") ?>
    </head>
    <body style="background:white">
    <?php
        if (isset($_SESSION['ativ']))
        {
            header('location:lobby');
        }
        else
        {
            if (isset($_POST['cpf_']) && isset($_POST['pass']))
            {
                $cpf_ = $_POST['cpf_'];
                $pass = $_POST['pass'];

                $cmd1 = "SELECT * FROM aluno WHERE codg_alun='$cpf_' AND senh_alun='$pass'";
                $rst1 = mysqli_query($conn, $cmd1);

                if (mysqli_affected_rows($conn) > 0)
                {
                    $_SESSION['ativ'] = $cpf_;

                    header('location:lobby');
                }
                else
                {
                    $rslt = "Usuário e Senha Incompatíveis!";
                }
            }
            ?>

            <div class="clmalign mainform">
                <form class="clmalign fanimate" action="" method="POST">
                    <div class="rowalign"><img class="mainlogo" src="img/logo-n-colors.png"></div>

                    <h2>Entrar no SAGA</h2>

                    <div class="rowalign">
                        <div class="clmalign">
                            <label class="labltext">CPF</label>
                            <label class="labltext">Senha</label>
                        </div>
                        <div class="vertline"></div>
                        <div class="clmalign">
                            <input name="cpf_" class="maininpt" type="text"     placeholder="cpf"   oninput="mask(this, 'cpf_');" required>
                            <input name="pass" class="maininpt" type="password" placeholder="senha" required>
                        </div>
                    </div>
                    <?php
                    if (isset($rslt) != '')
                    {
                    echo "<p class=\"retmsge1\">$rslt</p>";
                    }
                    ?>
                    <input class="mainbutn" type="submit" value="ENTRAR">
                </form>
            </div>
        <?php
        }
        ?>
    </body>
</html>