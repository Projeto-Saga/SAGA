<link rel="shortcut icon" type="img/png" href="img/logo-colors.png">
<title>SAGA</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/calend.css">
<link rel="stylesheet" href="css/mybook.css">
<link rel="stylesheet" href="css/rqests.css">
<link rel="stylesheet" href="css/homepg.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script type="text/javascript" src="js/dataformat.js"></script>
<script type="text/javascript" src="js/animations.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
$conn = mysqli_connect('localhost', 'root', '', 'saga_db');

session_start();

if (isset($_SESSION['ativ']))
{
	$ativ = $_SESSION['ativ'];

	$cmd1 = "SELECT aluno.rmat_alun,aluno.mail_alun,aluno.nome_alun,curso.nome_curs,aluno.cicl_alun,aluno.codg_alun,
					aluno.senh_alun,aluno.fone_alun,aluno.foto_alun
			  FROM aluno INNER JOIN curso ON aluno.curs_alun=curso.codg_curs WHERE aluno.codg_alun='$ativ'";
	$rst1 = mysqli_query($conn, $cmd1);

	while ($a = mysqli_fetch_array($rst1))
	{
		$rmat = $a[0];
		$mail = $a[1];
		$name = $a[2];
		$curs = $a[3];
		$cicl = $a[4];
		$codg = $a[5];
		$pass = $a[6];
		$fone = $a[7];
		$imge = $a[8];
	}
}
?>