<?php
session_start();
include("php/connect.php"); // se já está incluído no head.php, apenas garanta que seja antes do SQL

$rslt = "";

// Lógica de login deve vir ANTES de qualquer HTML
if (isset($_POST['cpf_']) && isset($_POST['pass'])) {
    $cpf_ = $_POST['cpf_'];
    $pass = $_POST['pass'];

    $cmd1 = "SELECT flag_user FROM usuario WHERE codg_user='$cpf_' AND senh_user='$pass'";
    $rst1 = mysqli_query($conn, $cmd1);

    if (mysqli_num_rows($rst1) > 0) {
        $user = mysqli_fetch_assoc($rst1);
        $_SESSION['ativ'] = $cpf_;
        $_SESSION['tipo'] = $user['flag_user'];

        header('Location: lobby.php');
        exit;
    } else {
        $rslt = "Usuário e Senha Incompatíveis!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include("html/head.php") ?>
</head>
<body class="bodyind">
<div class="clmalign mainform">
    <form class="clmalign fanimate" action="" method="POST">
        <div class="rowalign"><img class="mainlogo" src="img/logos/logo-n-colors.png"></div>
        <h2>Entrar no SAGA</h2>

        <div class="rowalign">
            <div class="clmalign grid-g15">
                <label class="mainlabl">
                    <img src="img/icons/user-icon.png">
                </label>
                <label class="mainlabl">
                    <img src="img/icons/lock-icon.png">
                </label>
            </div>
            <div class="clmalign grid-g15">
                <input name="cpf_" class="maininpt" type="text" oninput="mask(this, 'cpf_')" required maxlength="14">
                <input name="pass" class="maininpt" type="password" required>
            </div>
        </div>

        <?php if (!empty($rslt)) echo "<p class=\"retmsge1\">$rslt</p>"; ?>
        <input class="mainbutn" type="submit" value="ENTRAR">
    </form>
</div>
</body>
</html>
