<?php
session_start();
include_once "php/connect.php";

// --- Verificar se professor está logado ---
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== "P") {
    echo "Acesso negado.";
    exit;
}

$cpf = $_SESSION['ativ'];

// Buscar regx_user do professor
$stmt = mysqli_prepare($conn, "SELECT regx_user FROM usuario WHERE codg_user = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $cpf);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$professor = mysqli_fetch_assoc($res)['regx_user'];
mysqli_stmt_close($stmt);

// ---------------------
// 1. BUSCAR TURMAS DO PROFESSOR
// ---------------------
$sqlTurmas = "
    SELECT DISTINCT t.iden_turm, t.nome_turm
    FROM turma t
    INNER JOIN turma_materia tm ON tm.iden_turm = t.iden_turm
    WHERE tm.regx_prof = ?
    ORDER BY t.nome_turm
";
$stmt = mysqli_prepare($conn, $sqlTurmas);
mysqli_stmt_bind_param($stmt, "s", $professor);
mysqli_stmt_execute($stmt);
$resTurmas = mysqli_stmt_get_result($stmt);

$turmas = [];
while ($row = mysqli_fetch_assoc($resTurmas)) {
    $turmas[] = $row;
}
mysqli_stmt_close($stmt);

// Obter turma selecionada
$turmaSelecionada = isset($_GET['turma']) ? intval($_GET['turma']) : null;

// ---------------------
// 2. BUSCAR MATÉRIAS DESSA TURMA QUE SÃO DESSE PROFESSOR
// ---------------------
$materias = [];
if ($turmaSelecionada) {
    $sqlMat = "
        SELECT tm.iden_turm_matr, m.iden_matr, m.nome_matr, m.abrv_matr, m.dias_matr
        FROM turma_materia tm
        INNER JOIN materia m ON m.iden_matr = tm.iden_matr
        WHERE tm.iden_turm = ? AND tm.regx_prof = ?
    ";
    $stmt = mysqli_prepare($conn, $sqlMat);
    mysqli_stmt_bind_param($stmt, "is", $turmaSelecionada, $professor);
    mysqli_stmt_execute($stmt);
    $resMat = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resMat)) {
        $materias[] = $row;
    }

    mysqli_stmt_close($stmt);
}

$materiaSelecionada = isset($_GET['materia']) ? intval($_GET['materia']) : null;

// ---------------------
// 3. BUSCAR ALUNOS DA TURMA
// ---------------------
$alunos = [];
if ($turmaSelecionada && $materiaSelecionada) {
    $sqlAl = "
        SELECT u.regx_user, u.nome_user
        FROM aluno_turma at
        INNER JOIN usuario u ON u.regx_user = at.regx_user
        WHERE at.iden_turm = ?
        ORDER BY u.nome_user
    ";
    $stmt = mysqli_prepare($conn, $sqlAl);
    mysqli_stmt_bind_param($stmt, "i", $turmaSelecionada);
    mysqli_stmt_execute($stmt);
    $resAl = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resAl)) $alunos[] = $row;

    mysqli_stmt_close($stmt);
}

// ---------------------
// 4. GERAR DATAS FIXAS DE ACORDO COM A MATÉRIA
// ---------------------
$datasValidas = [];
if ($materiaSelecionada) {

    // pegar o dia da matéria
    foreach ($materias as $m) {
        if ($m['iden_matr'] == $materiaSelecionada) {
            $diaMateria = $m['dias_matr']; // 1..5
        }
    }

    if (!empty($diaMateria)) {
        $hoje = new DateTime();
        $count = 0;

        while ($count < 8) {
            if ($hoje->format('N') == $diaMateria) {
                $datasValidas[] = $hoje->format('Y-m-d');
                $count++;
            }
            $hoje->modify('+1 day');
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lançar Presença</title>
</head>
<body>

<h2>Lançar Presença</h2>

<form method="GET" action="launchAttendance.php">
    <label>Turma:</label>
    <select name="turma" onchange="this.form.submit()">
        <option value="">-- selecione --</option>
        <?php foreach ($turmas as $t): ?>
            <option value="<?= $t['iden_turm'] ?>" <?= ($turmaSelecionada==$t['iden_turm'])?'selected':'' ?>>
                <?= $t['nome_turm'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($turmaSelecionada): ?>

<form method="GET" action="launchAttendance.php">
    <input type="hidden" name="turma" value="<?= $turmaSelecionada ?>">
    <label>Matéria:</label>
    <select name="materia" onchange="this.form.submit()">
        <option value="">-- selecione --</option>
        <?php foreach ($materias as $m): ?>
            <option value="<?= $m['iden_matr'] ?>" <?= ($materiaSelecionada==$m['iden_matr'])?'selected':'' ?>>
                <?= $m['abrv_matr']." - ".$m['nome_matr'] ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php endif; ?>

<?php if ($materiaSelecionada && !empty($alunos)): ?>

<form method="POST" action="saveAttendance.php">
    <input type="hidden" name="materia" value="<?= $materiaSelecionada ?>">
    <input type="hidden" name="turma" value="<?= $turmaSelecionada ?>">

    <label>Data da aula:</label>
    <select name="data_aula" required>
        <?php foreach ($datasValidas as $d): ?>
            <option value="<?= $d ?>"><?= date("d/m/Y", strtotime($d)) ?></option>
        <?php endforeach; ?>
    </select>

    <table border="1" cellpadding="5">
        <tr><th>Aluno</th><th>Presente?</th></tr>
        <?php foreach ($alunos as $al): ?>
        <tr>
            <td><?= $al['nome_user'] ?></td>
            <td><input type="checkbox" name="presenca[<?= $al['regx_user'] ?>]" checked></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <button type="submit">Salvar Presença</button>
</form>

<?php endif; ?>

</body>
</html>
