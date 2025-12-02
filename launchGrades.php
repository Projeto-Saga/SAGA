<?php
session_start();
include_once "php/connect.php"; // garante que $conn esteja disponível

// --- Verificar se professor está logado ---
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== "P") {
    echo "Acesso negado.";
    exit;
}

// $_SESSION['ativ'] guarda o CPF (codg_user) conforme seu sistema
$cpf = $_SESSION['ativ'];

// Buscar regx_user do professor (mesma lógica do launchAttendance)
$stmt = mysqli_prepare($conn, "SELECT regx_user FROM usuario WHERE codg_user = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $cpf);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
if (!$row) {
    echo "Professor não encontrado.";
    exit;
}
$professor = $row['regx_user'];
mysqli_stmt_close($stmt);


/* =======================
   1. BUSCAR TURMAS DO PROFESSOR
   ======================= */
$sql_turmas = "
    SELECT DISTINCT t.iden_turm, t.nome_turm
    FROM turma t
    INNER JOIN turma_materia tm ON tm.iden_turm = t.iden_turm
    WHERE tm.regx_prof = ?
    ORDER BY t.nome_turm
";
$stmt = mysqli_prepare($conn, $sql_turmas);
mysqli_stmt_bind_param($stmt, "s", $professor);
mysqli_stmt_execute($stmt);
$resTurmas = mysqli_stmt_get_result($stmt);

$turmas = [];
while ($row = mysqli_fetch_assoc($resTurmas)) {
    $turmas[] = $row;
}
mysqli_stmt_close($stmt);

/* =======================
   2. BUSCAR MATÉRIAS DA TURMA SELECIONADA
   ======================= */
$materias = [];
$turmaSelecionada = isset($_GET['turma']) ? intval($_GET['turma']) : null;
if ($turmaSelecionada) {
    $sql_materias = "
        SELECT m.iden_matr, m.nome_matr, m.abrv_matr
        FROM turma_materia tm
        INNER JOIN materia m ON m.iden_matr = tm.iden_matr
        WHERE tm.iden_turm = ? AND tm.regx_prof = ?
    ";
    $stmt = mysqli_prepare($conn, $sql_materias);
    mysqli_stmt_bind_param($stmt, "is", $turmaSelecionada, $professor);
    mysqli_stmt_execute($stmt);
    $resMat = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resMat)) {
        $materias[] = $row;
    }
    mysqli_stmt_close($stmt);
}

/* =======================
   3. BUSCAR ALUNOS DA TURMA SELECIONADA
   ======================= */
$alunos = [];
$materiaSelecionada = isset($_GET['materia']) ? intval($_GET['materia']) : null;
if ($turmaSelecionada && $materiaSelecionada) {
    $sql_alunos = "
        SELECT u.regx_user, u.nome_user
        FROM aluno_turma at
        INNER JOIN usuario u ON u.regx_user = at.regx_user
        WHERE at.iden_turm = ?
        ORDER BY u.nome_user
    ";
    $stmt = mysqli_prepare($conn, $sql_alunos);
    mysqli_stmt_bind_param($stmt, "i", $turmaSelecionada);
    mysqli_stmt_execute($stmt);
    $resAl = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resAl)) {
        $alunos[] = $row;
    }
    mysqli_stmt_close($stmt);
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include("html/head.php"); ?>
    <meta charset="utf-8">
    <title>Lançamento de Notas</title>
    <style>
        body { padding: 20px; font-family: Arial, sans-serif; }
        select, input { padding: 8px; margin: 5px 0; width: 100%; box-sizing: border-box; }
        table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        button { padding: 10px 20px; margin-top: 20px; }
        .col-50 { max-width: 600px; }
    </style>
</head>
<body>

<h2>Lançamento de Notas</h2>

<!-- Seleção da Turma -->
<form method="GET" class="col-50">
    <label>Selecione a Turma:</label>
    <select name="turma" onchange="this.form.submit()">
        <option value="">-- Escolha --</option>
        <?php foreach ($turmas as $t): ?>
            <option value="<?= $t['iden_turm'] ?>"
                <?= (isset($_GET['turma']) && $_GET['turma'] == $t['iden_turm']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($t['nome_turm']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if (!empty($materias)) : ?>
<form method="GET" class="col-50">
    <input type="hidden" name="turma" value="<?= $turmaSelecionada ?>">

    <label>Selecione a Matéria:</label>
    <select name="materia" onchange="this.form.submit()">
        <option value="">-- Escolha --</option>
        <?php foreach ($materias as $m): ?>
            <option value="<?= $m['iden_matr'] ?>"
                <?= (isset($_GET['materia']) && $_GET['materia'] == $m['iden_matr']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($m['abrv_matr']) ?> - <?= htmlspecialchars($m['nome_matr']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>
<?php endif; ?>

<?php if (!empty($alunos)) : ?>
<form method="POST" action="saveGrades.php">
    <input type="hidden" name="turma" value="<?= $turmaSelecionada ?>">
    <input type="hidden" name="materia" value="<?= $materiaSelecionada ?>">

    <table>
        <tr>
            <th>Aluno</th>
            <th>P1</th>
            <th>P2</th>
            <th>P3</th>
            <th>Trabalho</th>
        </tr>

        <?php foreach ($alunos as $a): ?>
            <tr>
                <td style="text-align:left;"><?= htmlspecialchars($a['nome_user']) ?></td>
                <td><input type="number" name="p1[<?= $a['regx_user'] ?>]" min="0" max="10" step="0.1"></td>
                <td><input type="number" name="p2[<?= $a['regx_user'] ?>]" min="0" max="10" step="0.1"></td>
                <td><input type="number" name="p3[<?= $a['regx_user'] ?>]" min="0" max="10" step="0.1"></td>
                <td><input type="number" name="trab[<?= $a['regx_user'] ?>]" min="0" max="10" step="0.1"></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <button type="submit">Salvar Notas</button>
</form>
<?php endif; ?>

</body>
</html>
