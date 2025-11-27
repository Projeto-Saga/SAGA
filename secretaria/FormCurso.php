<?php
## conexao banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "saga_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome_curso = trim($_POST["nome_curso"]);
    $abreviatura = trim($_POST["abreviatura"]);
    $total_semestres = intval($_POST["total_semestres"]);
    $total_anos = intval($_POST["total_anos"]);
    $ativo = isset($_POST["ativo"]) ? 1 : 0;

    // Verificar se curso já existe
    $check = $conn->prepare("SELECT iden_curs FROM curso WHERE nome_curs = ? OR abrv_curs = ?");
    $check->bind_param("ss", $nome_curso, $abreviatura);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $mensagem = "Curso ou abreviatura já cadastrados.";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO curso (nome_curs, abrv_curs, total_semestres, total_anos, ativo)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssiii", $nome_curso, $abreviatura, $total_semestres, $total_anos, $ativo);

        if ($stmt->execute()) {
            $curso_id = $conn->insert_id;
            $mensagem = "Curso cadastrado com sucesso! ID: " . $curso_id;
        } else {
            $mensagem = "Erro ao cadastrar curso: " . $conn->error;
        }
        $stmt->close();
    }
    $check->close();
}

$conn->close();
?>

<link rel="stylesheet" href="../css/CadastroSec.css">

<form class="FormCadastroSec" method="POST">
    <h2>Cadastrar Novo Curso</h2>

    <input type="text" name="nome_curso" placeholder="Nome do Curso" value="<?= htmlspecialchars($_POST['nome_curso'] ?? '') ?>" required>
    <input type="text" name="abreviatura" placeholder="Abreviatura (ex: CC)" value="<?= htmlspecialchars($_POST['abreviatura'] ?? '') ?>" maxlength="3" required>
    
    <div class="form-group">
        <label>Total de Semestres:</label>
        <select name="total_semestres" required>
            <option value="">Selecione</option>
            <option value="4" <?= (isset($_POST['total_semestres']) && $_POST['total_semestres'] == 4) ? 'selected' : '' ?>>4 semestres (2 anos)</option>
            <option value="6" <?= (isset($_POST['total_semestres']) && $_POST['total_semestres'] == 6) ? 'selected' : '' ?>>6 semestres (3 anos)</option>
            <option value="8" <?= (isset($_POST['total_semestres']) && $_POST['total_semestres'] == 8) ? 'selected' : '' ?>>8 semestres (4 anos)</option>
            <option value="10" <?= (isset($_POST['total_semestres']) && $_POST['total_semestres'] == 10) ? 'selected' : '' ?>>10 semestres (5 anos)</option>
            <option value="12" <?= (isset($_POST['total_semestres']) && $_POST['total_semestres'] == 12) ? 'selected' : '' ?>>12 semestres (6 anos)</option>
        </select>
    </div>

    <div class="form-group">
        <label>Total de Anos:</label>
        <select name="total_anos" required>
            <option value="">Selecione</option>
            <option value="2" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 2) ? 'selected' : '' ?>>2 anos</option>
            <option value="3" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 3) ? 'selected' : '' ?>>3 anos</option>
            <option value="4" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 4) ? 'selected' : '' ?>>4 anos</option>
            <option value="5" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 5) ? 'selected' : '' ?>>5 anos</option>
            <option value="6" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 6) ? 'selected' : '' ?>>6 anos</option>
        </select>
    </div>

    <div class="form-group checkbox">
        <label>
            <input type="checkbox" name="ativo" <?= (isset($_POST['ativo']) && $_POST['ativo']) ? 'checked' : 'checked' ?>> Curso Ativo
        </label>
    </div>

    <button type="submit" class="BtnCadastrar_Sec">Cadastrar Curso</button>
    
    <button type="button" class="BtnVoltar" onclick="window.location.href = '../adminPanel.php'">Voltar ao Painel</button>
    
    <?php if (isset($mensagem) && $mensagem): ?>
        <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>
</form>