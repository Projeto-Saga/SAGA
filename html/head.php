<link rel="shortcut icon" type="img/png" href="img/logos/logo-colors.png">
<title>SAGA</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/studnt.css">
<link rel="stylesheet" href="css/homepg.css">
<link rel="stylesheet" href="css/mybook.css">
<link rel="stylesheet" href="css/calend.css">
<link rel="stylesheet" href="css/respons.css">
<link rel="stylesheet" href="css/professor.css">
<link rel="stylesheet" href="css/rqests.css">
<link rel="stylesheet" href="css/rspnsv.css">
<link rel="stylesheet" href="css/mtrial.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script type="text/javascript" src="js/dataformat.js"></script>
<script type="text/javascript" src="js/animations.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
$conn = include(__DIR__ . "/../php/connect.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("php/connect.php"); // Certifique-se de incluir a conexão com o banco
include("php/darkmode.php");
include("php/controller.php");

$main = new Controller();

$name = $mail = $imge = '';
$curs = $cicl = $codg = $pass = $fone = $iden = $idcs = '';

if (isset($_SESSION['ativ'])) {
    $ativ = $_SESSION['ativ'];

    $cmd1 = "SELECT flag_user FROM usuario WHERE codg_user='$ativ'";
    $rst1 = mysqli_query($conn, $cmd1);

    if ($rst1 && mysqli_num_rows($rst1) > 0) {
        $flag = mysqli_fetch_assoc($rst1)['flag_user'];

        if ($flag == 'A') {
            $cmd2 = "SELECT user.regx_user,user.mail_user,user.nome_user,curs.nome_curs,alun.cicl_alun,user.codg_user,
                            user.senh_user,user.fone_user,user.foto_user,user.iden_user,alun.iden_curs
                     FROM usuario AS user
                     INNER JOIN aluno AS alun ON user.regx_user=alun.regx_user 
                     INNER JOIN curso AS curs ON alun.iden_curs=curs.iden_curs
                     WHERE user.flag_user='A' AND user.codg_user='$ativ'";

            $rst2 = mysqli_query($conn, $cmd2);
            if ($rst2 && mysqli_num_rows($rst2) > 0) {
                $b = mysqli_fetch_assoc($rst2);
                $rmat = $b['regx_user'];
                $mail = $b['mail_user'];
                $name = $b['nome_user'];
                $curs = $b['nome_curs'];
                $cicl = $b['cicl_alun'];
                $codg = $b['codg_user'];
                $pass = $b['senh_user'];
                $fone = $b['fone_user'];
                $imge = $b['foto_user'];
                $iden = $b['iden_user'];
                $idcs = $b['iden_curs'];
            }
        }
    } else {
        $flag = '';
    }
}
?>

<link rel="shortcut icon" type="img/png" href="img/logos/logo-colors.png">
<title>SAGA</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/studnt.css">
<link rel="stylesheet" href="css/homepg.css">
<link rel="stylesheet" href="css/professor.css">
<link rel="stylesheet" href="css/mybook.css">
<link rel="stylesheet" href="css/calend.css">
<link rel="stylesheet" href="css/rqests.css">
<link rel="stylesheet" href="css/respons.css">
<link rel="stylesheet" href="css/rspnsv.css">
<link rel="stylesheet" href="css/mtrial.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script type="text/javascript" src="js/dataformat.js"></script>
<script type="text/javascript" src="js/animations.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- VLibras -->
<div vw class="enabled">
  <div vw-access-button class="active"></div>
  <div vw-plugin-wrapper>
    <div class="vw-plugin-top-wrapper"></div>
  </div>
</div>

<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>
  new window.VLibras.Widget('https://vlibras.gov.br/app');
</script>