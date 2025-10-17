<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("php/connect.php"); // Certifique-se de incluir a conexão com o banco
include('php/connect.php');
include('html/head.php');

if (!isset($_SESSION['ativ'])) {
    header('location:index.php');
    exit;
}

include('html/base.php');

$cmd1 = "SELECT idcs_csrl, capa_csrl, nome_csrl, dura_csrl, desc_csrl FROM cursinho";
$result = mysqli_query($conn, $cmd1);

if (mysqli_num_rows($result) === 0) {
    echo "<p>Nenhum curso cadastrado.</p>";
    exit;
}
?>

<div class="container fanimate">
    <div class="box interface">
        <div class="livrsect">
            <?php while ($a = mysqli_fetch_assoc($result)) { ?>
                <a class="row livrbody" href="courses.php?idcs=<?php echo $a['idcs_csrl']; ?>">
                    <img class="livrimge" src="img/fotos/<?php echo $a['capa_csrl']; ?>.jpg" style="height:190px; width:190px">
                    <div class="col" style="height:190px; justify-content:start">
                        <h3 class="livrtitl"><?php echo $a['nome_csrl']; ?></h3>
                        <h6 class="livrauth"><?php echo $a['dura_csrl']; ?> horas</h6>
                        <p class="livrtext" style="font-size:13px"><?php echo $a['desc_csrl']; ?></p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
