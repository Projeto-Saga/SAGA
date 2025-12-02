<?php
session_start();
include "php/connect.php";

$materia = intval($_POST['materia']);
$turma   = intval($_POST['turma']);
$data    = $_POST['data_aula'];
$presencas = $_POST['presenca'];

$cpf = $_SESSION['ativ'];
$res = mysqli_query($conn, "SELECT regx_user FROM usuario WHERE codg_user='$cpf' LIMIT 1");
$prof = mysqli_fetch_assoc($res)['regx_user'];

foreach ($presencas as $regx_user => $valor) {
    $status = $valor ? "P" : "F";

    $sql = "
        INSERT INTO faltas (regx_user, iden_matr, data_att, stat_att, prof_att)
        VALUES ('$regx_user', $materia, '$data', '$status', '$prof')
    ";
    mysqli_query($conn, $sql);
}

header("Location: launchAttendance.php?turma=$turma&materia=$materia&ok=1");
exit;
?>
