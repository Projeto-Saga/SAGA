<?php
// launchAttendance.php - versão corrigida e robusta
session_start();
include_once "php/connect.php"; // ajuste o caminho se necessário

// --- para testes locais: descomente se necessário ---
// $_SESSION['ativ'] = '646.464.646-65'; $_SESSION['tipo'] = 'P';

// validação básica de sessão / professor
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== "P") {
    echo "<p style='color:red;'>Erro: apenas professores podem acessar esta página.</p>"; exit;
}
if (!isset($_SESSION['ativ']) || empty($_SESSION['ativ'])) {
    echo "<p style='color:red;'>Erro: sessão inválida (faltando CPF).</p>"; exit;
}

// obter regx_user do professor pelo cpf salvo em sessão
$cpf = $_SESSION['ativ'];
$professor = null;
if ($stmt = mysqli_prepare($conn, "SELECT regx_user FROM usuario WHERE codg_user = ? LIMIT 1")) {
    mysqli_stmt_bind_param($stmt, "s", $cpf);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) {
        $professor = $row['regx_user'];
    }
    mysqli_stmt_close($stmt);
}
if (!$professor) {
    echo "<p style='color:red;'>Erro: professor não encontrado no banco.</p>"; exit;
}

// Buscar matérias vinculadas ao professor
$sqlMaterias = "
    SELECT m.iden_matr, m.nome_matr, m.abrv_matr, m.dias_matr
    FROM professor_materia pm
    INNER JOIN materia m ON pm.iden_matr = m.iden_matr
    WHERE pm.regx_user = ?
    ORDER BY m.abrv_matr, m.nome_matr
";
$resultMaterias = [];
if ($stmt = mysqli_prepare($conn, $sqlMaterias)) {
    mysqli_stmt_bind_param($stmt, "s", $professor);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($r = mysqli_fetch_assoc($res)) {
        $resultMaterias[] = $r;
    }
    mysqli_stmt_close($stmt);
}

// Tratar seleção de matéria (via GET)
$materiaSelecionada = null;
$alunos = [];
$datasValidas = [];
$diaMateria = null;

if (isset($_GET['materia']) && $_GET['materia'] !== '') {
    $materiaSelecionada = intval($_GET['materia']);

    // Buscar alunos matriculados nessa matéria
    $sqlAlunos = "
        SELECT u.regx_user, u.nome_user
        FROM cursando c
        INNER JOIN usuario u ON c.regx_user = u.regx_user
        WHERE c.iden_matr = ?
        ORDER BY u.nome_user
    ";
    if ($stmt2 = mysqli_prepare($conn, $sqlAlunos)) {
        mysqli_stmt_bind_param($stmt2, "i", $materiaSelecionada);
        mysqli_stmt_execute($stmt2);
        $res2 = mysqli_stmt_get_result($stmt2);
        while ($row = mysqli_fetch_assoc($res2)) {
            $alunos[] = $row;
        }
        mysqli_stmt_close($stmt2);
    }

    // Buscar o dia fixo da matéria (dias_matr)
    $sqlDia = "SELECT dias_matr FROM materia WHERE iden_matr = ? LIMIT 1";
    if ($stmt3 = mysqli_prepare($conn, $sqlDia)) {
        mysqli_stmt_bind_param($stmt3, "i", $materiaSelecionada);
        mysqli_stmt_execute($stmt3);
        $res3 = mysqli_stmt_get_result($stmt3);
        if ($r = mysqli_fetch_assoc($res3)) {
            $diaMateria = (int)$r['dias_matr']; // 1..5 conforme seu schema
        }
        mysqli_stmt_close($stmt3);
    }

    // Se tivermos o dia da matéria, gerar próximas N datas compatíveis
    if ($diaMateria >= 1 && $diaMateria <= 5) {
        // Map do seu valor (1=segunda ..5=sexta) para format('N') do PHP (1=Mon..7=Sun) -> é igual aqui
        $diaPHP = $diaMateria; // já compatível com format('N')
        $hoje = new DateTime();
        // gerar as próximas 8 ocorrências (pode ajustar)
        $count = 0;
        $i = 0;
        while ($count < 8 && $i < 30) { // limite de segurança em 30 dias de varredura
            $dataTemp = (clone $hoje)->modify("+$i day");
            if ((int)$dataTemp->format('N') === $diaPHP) {
                $datasValidas[] = $dataTemp->format('Y-m-d');
                $count++;
            }
            $i++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Lançar Presença</title>
<style>
    body{font-family: Arial, sans-serif; padding:18px}
    table{border-collapse:collapse; margin-top:12px}
    th,td{padding:8px;border:1px solid #ddd}
</style>
</head>
<body>

<h2>Lançar Presença</h2>
<p>Professor logado: <strong><?= htmlspecialchars($professor) ?></strong></p>

<form method="GET" action="launchAttendance.php">
    <label for="materia">Escolha uma matéria:</label>
    <select name="materia" id="materia" required>
        <option value="">-- selecione --</option>
        <?php foreach ($resultMaterias as $m): 
            $sel = ($materiaSelecionada !== null && $materiaSelecionada == $m['iden_matr']) ? 'selected' : '';
        ?>
            <option value="<?= htmlspecialchars($m['iden_matr']) ?>" <?= $sel ?>>
                <?= htmlspecialchars($m['abrv_matr'] . " - " . $m['nome_matr']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Carregar Alunos</button>
</form>

<?php if ($materiaSelecionada !== null): ?>

    <?php if (empty($alunos)): ?>
        <p>Nenhum aluno encontrado para a matéria selecionada.</p>
    <?php else: ?>

        <form method="POST" action="saveAttendance.php">
            <input type="hidden" name="materia" value="<?= htmlspecialchars($materiaSelecionada) ?>">

            <?php if (!empty($datasValidas)): ?>
                <p>
                    <label>Data da aula (dia fixo da matéria):</label>
                    <select name="data_aula" required>
                        <?php foreach ($datasValidas as $d): ?>
                            <option value="<?= $d ?>"><?= date("d/m/Y", strtotime($d)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
            <?php else: ?>
                <p style="color:darkred;">Não foi possível determinar as próximas datas da matéria (campo <em>dias_matr</em> incorreto ou ausente).</p>
            <?php endif; ?>

            <table>
                <thead>
                    <tr><th>Registro</th><th>Nome</th><th>Presente?</th></tr>
                </thead>
                <tbody>
                <?php foreach ($alunos as $al): ?>
                    <tr>
                        <td><?= htmlspecialchars($al['regx_user']) ?></td>
                        <td><?= htmlspecialchars($al['nome_user']) ?></td>
                        <td style="text-align:center">
                            <!-- checkbox marcado = P; falta = ausente do array -->
                            <input type="checkbox" name="presenca[<?= htmlspecialchars($al['regx_user']) ?>]" value="P" checked>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <p><button type="submit">Salvar Presença</button></p>
        </form>

    <?php endif; ?>

<?php endif; ?>

</body>
</html>
