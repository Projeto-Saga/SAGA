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

<link rel="manifest" href="/manifest.php">
<meta name="theme-color" content="#007bff">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script type="text/javascript" src="js/dataformat.js"></script>
<script type="text/javascript" src="js/animations.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
$conn = include(__DIR__ . "/../php/connect.php");
mysqli_set_charset($conn, "utf8");

session_start();

include("php/darkmode.php");
include("php/controller.php");

$main = new Controller();

if (isset($_SESSION['ativ']))
{
	$ativ = $_SESSION['ativ'];

	$cmd1 = "SELECT flag_user FROM usuario WHERE codg_user='$ativ'";
	$rst1 = mysqli_query($conn, $cmd1);

	while ($a = mysqli_fetch_array($rst1)) $flag = $a[0];

	switch ($flag)
	{
		case 'A':
			$cmd2 = "SELECT user.regx_user,user.mail_user,user.nome_user,curs.nome_curs,alun.cicl_alun,user.codg_user,
							user.senh_user,user.fone_user,user.foto_user,user.iden_user,alun.iden_curs
					FROM usuario AS user INNER JOIN aluno AS alun ON user.regx_user=alun.regx_user 
										 INNER JOIN curso AS curs ON alun.iden_curs=curs.iden_curs
					WHERE user.flag_user='A' AND user.codg_user='$ativ'";
			$rst2 = mysqli_query($conn, $cmd2);

			while ($b = mysqli_fetch_array($rst2))
			{
				$rmat = $b[0];
				$mail = $b[1];
				$name = $b[2];
				$curs = $b[3];
				$cicl = $b[4];
				$codg = $b[5];
				$pass = $b[6];
				$fone = $b[7];
				$imge = $b[8];
				$iden = $b[9];
				$idcs = $b[10];
			}
		break;
		
		case 'S':
		break;

		case 'F':
		break;
	}
}
?>
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

<script>
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/service-worker.js')
      .then(reg => console.log('Service Worker registrado:', reg))
      .catch(err => console.error('Erro ao registrar SW:', err));
  });
}
</script>