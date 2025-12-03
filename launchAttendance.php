<?php
// launchAttendance.php - Backend integrado + layout conforme imagens
session_start();
include_once "php/connect.php"; // ajuste o caminho se necessário

// validações de sessão / professor
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== "P") {
    // caso prefira redirecionar: header('Location: index.php'); exit;
    echo "<p style='color:red;margin:18px;'>Erro: apenas professores podem acessar esta página.</p>";
    exit;
}
if (!isset($_SESSION['ativ']) || empty($_SESSION['ativ'])) {
    echo "<p style='color:red;margin:18px;'>Erro: sessão inválida (faltando CPF).</p>";
    exit;
}

// pega regx_user do professor
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
    echo "<p style='color:red;margin:18px;'>Erro: professor não encontrado no banco.</p>";
    exit;
}

// buscar matérias vinculadas ao professor
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

// tratar seleção de matéria (GET)
$materiaSelecionada = null;
$alunos = [];
$datasValidas = [];
$diaMateria = null;
$nomeSelecionada = '';
$abrvSelecionada = '';

if (isset($_GET['materia']) && $_GET['materia'] !== '') {
    $materiaSelecionada = intval($_GET['materia']);

    // buscar alunos matriculados nessa matéria
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

    // buscar info da matéria (dias_matr, nome e abrv)
    $sqlDia = "SELECT dias_matr, nome_matr, abrv_matr FROM materia WHERE iden_matr = ? LIMIT 1";
    if ($stmt3 = mysqli_prepare($conn, $sqlDia)) {
        mysqli_stmt_bind_param($stmt3, "i", $materiaSelecionada);
        mysqli_stmt_execute($stmt3);
        $res3 = mysqli_stmt_get_result($stmt3);
        if ($r = mysqli_fetch_assoc($res3)) {
            $diaMateria = isset($r['dias_matr']) ? (int)$r['dias_matr'] : null;
            $nomeSelecionada = $r['nome_matr'];
            $abrvSelecionada = $r['abrv_matr'];
        }
        mysqli_stmt_close($stmt3);
    }

    // gerar próximas datas conforme dias_matr (1=seg .. 7=dom)
    if ($diaMateria >= 1 && $diaMateria <= 7) {
        $diaPHP = $diaMateria;
        $hoje = new DateTime();
        $count = 0;
        $i = 0;
        while ($count < 8 && $i < 60) {
            $dataTemp = (clone $hoje)->modify("+$i day");
            if ((int)$dataTemp->format('N') === $diaPHP) {
                $datasValidas[] = $dataTemp->format('Y-m-d');
                $count++;
            }
            $i++;
        }
    }
}

// valores front
$cicl = isset($cicl) ? (int)$cicl : 1;
$rmat = isset($rmat) ? mysqli_real_escape_string($conn, $rmat) : '';
$tick = isset($_GET['cicl']) ? (int)$_GET['cicl'] : $cicl;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include('html/head.php'); ?>
    <meta charset="utf-8">
    <title>SAGA — Lançar Faltas</title>
    <link rel="stylesheet" href="css/notasFaltasProf.css">
</head>
<body>
<?php include('html/base.php'); ?>

<div class="container fanimate">
    <form id="selectMateria" method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="discip-info">
            <div class="discip-box">
                <p class="title">Disciplina</p>
                <p class="value"><?= $materiaSelecionada ? htmlspecialchars(mb_strtoupper($nomeSelecionada)) : '—' ?></p>
            </div>

            <div class="discip-box">
                <p class="title">Turma</p>
                <p class="value"><?= $abrvSelecionada ? htmlspecialchars($abrvSelecionada) : '—' ?></p>
            </div>

            <div class="discip-box">
                <p class="title">Total de alunos</p>
                <p class="value"><?= $materiaSelecionada ? count($alunos) : '—' ?></p>
            </div>

            <div class="discip-box">
                <p class="title">Ciclo</p>
                <p class="value"><?= htmlspecialchars($tick) ?></p>
            </div>

            <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
                <select name="materia" required style="padding:8px;border-radius:6px;border:1px solid #ddd;">
                    <option value="">-- selecione matéria --</option>
                    <?php foreach ($resultMaterias as $m):
                        $sel = ($materiaSelecionada !== null && $materiaSelecionada == $m['iden_matr']) ? 'selected' : '';
                    ?>
                        <option value="<?= htmlspecialchars($m['iden_matr']) ?>" <?= $sel ?>>
                            <?= htmlspecialchars($m['abrv_matr'] . " - " . $m['nome_matr']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" style="padding:9px 12px;border-radius:8px;background:#2d89ef;color:#fff;border:0;cursor:pointer;">Carregar</button>
            </div>
        </div>
    </form>

    <!-- tabela de alunos -->
    <div style="margin-top:8px;">
        <?php if (!$materiaSelecionada): ?>
            

            <div class="salvar-container">
                <button class="btn-salvar" type="button" onclick="alert('Selecione uma matéria para habilitar salvar')">SALVAR</button>
            </div>

        <?php else: ?>
            <!-- formulário real para salvar presenças/notas -->
            <form id="savePresenceForm" method="POST" action="saveAttendance.php">
                <input type="hidden" name="materia" value="<?= htmlspecialchars($materiaSelecionada) ?>">
                <input type="hidden" name="cicl" value="<?= htmlspecialchars($tick) ?>">
                <input type="hidden" name="professor" value="<?= htmlspecialchars($professor) ?>">

                <div style="margin-bottom:12px;">
                    <?php if (!empty($datasValidas)): ?>
                        <label class="muted">Data da aula:</label>
                        <select name="data_aula" required style="margin-left:8px;padding:8px;border-radius:6px;border:1px solid #ddd;">
                            <?php foreach ($datasValidas as $d): ?>
                                <option value="<?= $d ?>"><?= date("d/m/Y", strtotime($d)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <p style="color:#c0392b">Não foi possível determinar as próximas datas da matéria (campo <em>dias_matr</em> incorreto ou ausente).</p>
                    <?php endif; ?>
                </div>

                <table class="alunos-tabela" role="table" aria-label="Lista de alunos">
                    <thead>
                        <tr>
                            <th>Aluno</th>
                            <th>RA</th>
                            <th>Faltas</th>
                            <th style="text-align:center">Presente?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($alunos)): ?>
                            <tr><td colspan="5">Nenhum aluno encontrado para a matéria selecionada.</td></tr>
                        <?php else: ?>
                            <?php foreach ($alunos as $al): ?>
                                <tr>
                                    <td><span class="circle"></span> <?= htmlspecialchars($al['nome_user']) ?></td>
                                    <td><?= htmlspecialchars($al['regx_user']) ?></td>
                                    <!-- MÉDIA e FALTAS: não disponíveis nesta query — deixar em branco ou preencher via JOIN -->
                                    <td class="muted">—</td>
                                    <td style="text-align:center">
                                        <input type="checkbox" name="presenca[<?= htmlspecialchars($al['regx_user']) ?>]" value="P" checked>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="salvar-container">
                    <button class="btn-salvar" type="submit">SALVAR</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script src="js/mybook.js"></script>
</body>
</html>
