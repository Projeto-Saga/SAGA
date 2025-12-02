<?php
session_start();
include_once "php/connect.php";

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'P') {
    die("Erro: professor não logado.");
}

// obter regx_user do professor (a partir do codg_user salvo em session)
$cpf = $_SESSION['ativ'];
$stmt = mysqli_prepare($conn, "SELECT regx_user FROM usuario WHERE codg_user = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $cpf);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
if (!$row) {
    die("Professor não encontrado.");
}
$professor = $row['regx_user'];
mysqli_stmt_close($stmt);

// validar entradas
$turma = isset($_POST['turma']) ? intval($_POST['turma']) : 0;
$materia = isset($_POST['materia']) ? intval($_POST['materia']) : 0;

if (!$turma || !$materia) {
    die("Turma ou matéria inválida.");
}

// verificar se o professor leciona essa matéria nessa turma
$valStmt = $conn->prepare("
    SELECT 1 FROM turma_materia 
    WHERE iden_turm = ? AND iden_matr = ? AND regx_prof = ? LIMIT 1
");
$valStmt->bind_param("iis", $turma, $materia, $professor);
$valStmt->execute();
$valRes = $valStmt->get_result();
if ($valRes->num_rows === 0) {
    die("Erro: você não tem permissão para lançar notas para esta turma/matéria.");
}
$valStmt->close();

$p1 = isset($_POST['p1']) ? $_POST['p1'] : [];
$p2 = isset($_POST['p2']) ? $_POST['p2'] : [];
$p3 = isset($_POST['p3']) ? $_POST['p3'] : [];
$trab = isset($_POST['trab']) ? $_POST['trab'] : [];

// preparar statement de update
$sql = "
    UPDATE cursando
    SET ntp1_crsn = ?, ntp2_crsn = ?, ntp3_crsn = ?, nttt_crsn = ?
    WHERE regx_user = ? AND iden_matr = ?
";
$stmtUpd = $conn->prepare($sql);
if (!$stmtUpd) {
    die("Erro ao preparar statement: " . $conn->error);
}

// iterar alunos recebidos em p1 array (chaves = regx_user)
foreach ($p1 as $aluno => $nota1_raw) {
    // obter demais notas (se existir), tratar valores vazios como NULL
    $nota1 = ($nota1_raw === "" || $nota1_raw === null) ? null : floatval($nota1_raw);
    $nota2 = (isset($p2[$aluno]) && $p2[$aluno] !== "") ? floatval($p2[$aluno]) : null;
    $nota3 = (isset($p3[$aluno]) && $p3[$aluno] !== "") ? floatval($p3[$aluno]) : null;
    $notatrab = (isset($trab[$aluno]) && $trab[$aluno] !== "") ? floatval($trab[$aluno]) : null;

    // bind and execute
    // tipos: d (double) para notas — aceita NULL; s para regx_user; i para iden_matr
    $stmtUpd->bind_param("ddddsi", $nota1, $nota2, $nota3, $notatrab, $aluno, $materia);
    if (!$stmtUpd->execute()) {
        // opcional: registrar erro e continuar
        error_log("Erro ao atualizar notas para aluno $aluno: " . $stmtUpd->error);
    }
}

$stmtUpd->close();

// após salvar, redirecionar de volta ao launchGrades com turma e materia selecionadas
header("Location: launchGrades.php?turma={$turma}&materia={$materia}");
exit;
?>
