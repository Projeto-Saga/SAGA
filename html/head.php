<link rel="shortcut icon" type="img/png" href="img/logos/logo-colors.png">
<title>SAGA</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/studnt.css">
<link rel="stylesheet" href="css/homepg.css">
<link rel="stylesheet" href="css/mybook.css">
<link rel="stylesheet" href="css/calend.css">
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

    // Busca o usuário logado
    $cmd = "SELECT * FROM usuario WHERE codg_user = '$ativ'";
    $rst = mysqli_query($conn, $cmd);

    if ($rst && mysqli_num_rows($rst) > 0) {
        $b = mysqli_fetch_assoc($rst);

        $flag = $b['flag_user'];
        $name = $b['nome_user'];
        $mail = $b['mail_user'];
        $imge = $b['foto_user'];
        $codg = $b['codg_user'];
        $fone = $b['fone_user'];
        $iden = $b['iden_user'];
        $pass = $b['senh_user'];

        // Só busca dados extras se for aluno (curso e ciclo)
        if ($flag == 'A') {
            $cmd2 = "SELECT curs.nome_curs, alun.cicl_alun, alun.iden_curs
                     FROM aluno AS alun
                     INNER JOIN curso AS curs ON alun.iden_curs = curs.iden_curs
                     WHERE alun.regx_user = '{$b['regx_user']}'";
            $rst2 = mysqli_query($conn, $cmd2);

            if ($rst2 && mysqli_num_rows($rst2) > 0) {
                $a = mysqli_fetch_assoc($rst2);
                $curs = $a['nome_curs'];
                $cicl = $a['cicl_alun'];
                $idcs = $a['iden_curs'];
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
<link rel="stylesheet" href="css/mybook.css">
<link rel="stylesheet" href="css/calend.css">
<link rel="stylesheet" href="css/rqests.css">
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