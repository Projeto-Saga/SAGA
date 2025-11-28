<?php
session_start();
include "php/connect.php";

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'P') {
    die("Acesso negado");
}

// Variáveis enviadas
$materia = intval($_POST['materia']);
$data_aula = $_POST['data_aula'];
$presencas = $_POST['presenca'] ?? [];

// Buscar regx_user do professor
$cpf = $_SESSION['ativ'];
$sqlProf = "SELECT regx_user FROM usuario WHERE codg_user = '$cpf' LIMIT 1";
$rs = mysqli_query($conn, $sqlProf);
$prof = mysqli_fetch_assoc($rs)['regx_user'];

// Para cada aluno
foreach ($_POST['presenca'] as $regx_user => $valor) {

    // Se checkbox marcado → P, se não estiver → F
    $status = ($valor === "P") ? "P" : "F";

    // Inserir no banco
    $sql = "
        INSERT INTO faltas (regx_user, iden_matr, data_att, stat_att, prof_att)
        VALUES ('$regx_user', $materia, '$data_aula', '$status', '$prof')
    ";

    mysqli_query($conn, $sql);
}

header("Location: launchAttendance.php?materia=$materia&ok=1");
exit;
?>