<?php
## conexao banco de dados para buscar cursos
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "saga_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Buscar cursos para o select
$cursos = [];
$result_cursos = $conn->query("SELECT iden_curs, nome_curs, abrv_curs FROM curso WHERE ativo = 1 ORDER BY nome_curs");
if ($result_cursos) {
    while ($row = $result_cursos->fetch_assoc()) {
        $cursos[] = $row;
    }
}

$conn->close();
?>

<link rel="stylesheet" href="../css/CadastroSec.css">
<script>
function voltarAoPainel() {
    if (window.parent && window.parent !== window) {
        if (typeof window.parent.voltarAoPainel === 'function') {
            window.parent.voltarAoPainel();
        } else {
            window.parent.location.href = 'adminPanel.php';
        }
    } else {
        window.location.href = 'adminPanel.php';
    }
}

</script>

<form class="FormCadastroSec" method="POST">
    <h2>Cadastrar Nova Matéria</h2>

    <div class="form-group">
        <label>Curso:</label>
        <select name="curso_id" required>
            <option value="">Selecione o curso</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso['iden_curs'] ?>" <?= (isset($_POST['curso_id']) && $_POST['curso_id'] == $curso['iden_curs']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($curso['nome_curs']) ?> (<?= htmlspecialchars($curso['abrv_curs']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <label style="position: relative; top: 8px;">Nome da Matéria:</label>
    <input type="text" name="nome_materia" placeholder="Nome da Matéria" value="<?= htmlspecialchars($_POST['nome_materia'] ?? '') ?>" oninput="this.value = this.value.toUpperCase()" required>
    
    <div class="form-group">
        <label>Carga Horária:</label>
        <select name="carga_horaria" required>
            <option value="">Selecione a carga horária</option>
            <option value="20" <?= (isset($_POST['carga_horaria']) && $_POST['carga_horaria'] == 20) ? 'selected' : '' ?>>20 horas</option>
            <option value="40" <?= (isset($_POST['carga_horaria']) && $_POST['carga_horaria'] == 40) ? 'selected' : '' ?>>40 horas</option>
            <option value="80" <?= (isset($_POST['carga_horaria']) && $_POST['carga_horaria'] == 80) ? 'selected' : '' ?>>80 horas</option>
            <option value="120" <?= (isset($_POST['carga_horaria']) && $_POST['carga_horaria'] == 120) ? 'selected' : '' ?>>120 horas</option>
        </select>
    </div>
    
    <label style="position: relative; top: 8px;">Abreviatura:</label>
    <input type="text" name="abreviatura" placeholder="Abreviatura (ex: CAL1)" value="<?= htmlspecialchars($_POST['abreviatura'] ?? '') ?>" oninput="this.value = this.value.toUpperCase()" maxlength="10" required>
    
    <div class="form-group">
        <label>Semestre:</label>
        <select name="codigo_curso_periodo_versao" required>
            <option value="">Selecione o semestre</option>
            <option value="1" <?= (isset($_POST['codigo_curso_periodo_versao']) && $_POST['codigo_curso_periodo_versao'] == 1) ? 'selected' : '' ?>>1º Semestre</option>
            <option value="2" <?= (isset($_POST['codigo_curso_periodo_versao']) && $_POST['codigo_curso_periodo_versao'] == 2) ? 'selected' : '' ?>>2º Semestre</option>
            <option value="3" <?= (isset($_POST['codigo_curso_periodo_versao']) && $_POST['codigo_curso_periodo_versao'] == 3) ? 'selected' : '' ?>>3º Semestre</option>
            <option value="4" <?= (isset($_POST['codigo_curso_periodo_versao']) && $_POST['codigo_curso_periodo_versao'] == 4) ? 'selected' : '' ?>>4º Semestre</option>
            <option value="5" <?= (isset($_POST['codigo_curso_periodo_versao']) && $_POST['codigo_curso_periodo_versao'] == 5) ? 'selected' : '' ?>>5º Semestre</option>
            <option value="6" <?= (isset($_POST['codigo_curso_periodo_versao']) && $_POST['codigo_curso_periodo_versao'] == 6) ? 'selected' : '' ?>>6º Semestre</option>
            <option value="7" <?= (isset($_POST['codigo_curso_periodo_versao']) && $_POST['codigo_curso_periodo_versao'] == 7) ? 'selected' : '' ?>>7º Semestre</option>
            <option value="8" <?= (isset($_POST['codigo_curso_periodo_versao']) && $_POST['codigo_curso_periodo_versao'] == 8) ? 'selected' : '' ?>>8º Semestre</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Dias da Semana:</label>
        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px;">
            <label style="display: flex; align-items: center; gap: 5px;">
                <input type="checkbox" name="dias_semana[]" value="1" <?= (isset($_POST['dias_semana']) && in_array('S', $_POST['dias_semana'])) ? 'checked' : '' ?>> Segunda
            </label>
            <label style="display: flex; align-items: center; gap: 5px;">
                <input type="checkbox" name="dias_semana[]" value="2" <?= (isset($_POST['dias_semana']) && in_array('T', $_POST['dias_semana'])) ? 'checked' : '' ?>> Terça
            </label>
            <label style="display: flex; align-items: center; gap: 5px;">
                <input type="checkbox" name="dias_semana[]" value="3" <?= (isset($_POST['dias_semana']) && in_array('Q', $_POST['dias_semana'])) ? 'checked' : '' ?>> Quarta
            </label>
            <label style="display: flex; align-items: center; gap: 5px;">
                <input type="checkbox" name="dias_semana[]" value="4" <?= (isset($_POST['dias_semana']) && in_array('QI', $_POST['dias_semana'])) ? 'checked' : '' ?>> Quinta
            </label>
            <label style="display: flex; align-items: center; gap: 5px;">
                <input type="checkbox" name="dias_semana[]" value="5" <?= (isset($_POST['dias_semana']) && in_array('SE', $_POST['dias_semana'])) ? 'checked' : '' ?>> Sexta
            </label>
            <label style="display: flex; align-items: center; gap: 5px;">
                <input type="checkbox" name="dias_semana[]" value="6" <?= (isset($_POST['dias_semana']) && in_array('SA', $_POST['dias_semana'])) ? 'checked' : '' ?>> Sábado
            </label>
        </div>
    </div>

    <button type="submit" class="BtnCadastrar_Sec">Cadastrar Matéria</button>
    
    <button type="button" class="BtnVoltar" onclick="voltarAoPainel()">Voltar ao Painel</button>
    
<?php if (isset($mensagem) && $mensagem): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            // Detectar tipo de mensagem
            if (strpos($mensagem, 'sucesso') !== false) {
                echo "Popup.success('" . addslashes($mensagem) . "');";
                // Limpa os campos após cadastro bem-sucedido
                echo "document.querySelector('select[name=\"curso_id\"]').value = '';";
                echo "document.querySelector('input[name=\"nome_materia\"]').value = '';";
                echo "document.querySelector('select[name=\"carga_horaria\"]').value = '';";
                echo "document.querySelector('input[name=\"abreviatura\"]').value = '';";
                echo "document.querySelector('select[name=\"codigo_curso_periodo_versao\"]').value = '';";
                // Limpa checkboxes
                echo "document.querySelectorAll('input[type=\"checkbox\"]').forEach(checkbox => checkbox.checked = false);";
            } else if (strpos($mensagem, 'ERRO') !== false || strpos($mensagem, 'erro') !== false) {
                echo "Popup.error('" . addslashes($mensagem) . "');";
            } else {
                echo "Popup.info('" . addslashes($mensagem) . "');";
            }
            ?>
        });
    </script>
<?php endif; ?>
</form>