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
            $mensagem = "Curso cadastrado com sucesso!";
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
<script>
function atualizarTotalAnos() {
    const semestresSelect = document.querySelector('select[name="total_semestres"]');
    const anosSelect = document.querySelector('select[name="total_anos"]');
    
    if (semestresSelect.value) {
        // Calcula os anos baseado nos semestres (2 semestres = 1 ano)
        const totalSemestres = parseInt(semestresSelect.value);
        const totalAnos = Math.ceil(totalSemestres / 2);
        
        // Atualiza o campo de anos
        anosSelect.value = totalAnos;
        
        // Se não existir a opção, cria dinamicamente
        let opcaoExiste = false;
        for (let i = 0; i < anosSelect.options.length; i++) {
            if (anosSelect.options[i].value == totalAnos) {
                opcaoExiste = true;
                break;
            }
        }
        
        if (!opcaoExiste) {
            const novaOpcao = new Option(totalAnos + ' anos', totalAnos);
            anosSelect.add(novaOpcao);
        }
    } else {
        // Se nenhum semestre selecionado, limpa o campo de anos
        anosSelect.value = '';
    }
}

// Função para inicializar o comportamento
document.addEventListener('DOMContentLoaded', function() {
    const semestresSelect = document.querySelector('select[name="total_semestres"]');
    if (semestresSelect) {
        semestresSelect.addEventListener('change', atualizarTotalAnos);
        
        // Se já houver um valor selecionado (em caso de recarregamento da página)
        if (semestresSelect.value) {
            atualizarTotalAnos();
        }
    }
});

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
    <h2>Cadastrar Novo Curso</h2>

    <label style="position: relative; top: 8px;">Nome do Curso:</label>
    <input type="text" name="nome_curso" placeholder="Nome do Curso" value="<?= htmlspecialchars($_POST['nome_curso'] ?? '') ?>" oninput="this.value = this.value.toUpperCase()" required>
    <label style="position: relative; top: 8px;">Abreviatura:</label>
    <input type="text" name="abreviatura" placeholder="Abreviatura (ex: CC)" value="<?= htmlspecialchars($_POST['abreviatura'] ?? '') ?>" oninput="this.value = this.value.toUpperCase()" maxlength="3" required>
    
    <div class="form-group">
        <label>Total de Semestres:</label>
        <select name="total_semestres" required>
            <option value="">Selecione</option>
            <option value="2" <?= (isset($_POST['total_semestres']) && $_POST['total_semestres'] == 2) ? 'selected' : '' ?>>2 semestres (1 ano)</option>
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
            <option value="">Selecione primeiro os semestres</option>
            <option value="1" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 1) ? 'selected' : '' ?>>1 ano</option>
            <option value="2" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 2) ? 'selected' : '' ?>>2 anos</option>
            <option value="3" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 3) ? 'selected' : '' ?>>3 anos</option>
            <option value="4" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 4) ? 'selected' : '' ?>>4 anos</option>
            <option value="5" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 5) ? 'selected' : '' ?>>5 anos</option>
            <option value="6" <?= (isset($_POST['total_anos']) && $_POST['total_anos'] == 6) ? 'selected' : '' ?>>6 anos</option>
        </select>
    </div>

    <div class="form-group checkbox">
        <label  style="display:flex;">
            <input type="checkbox" name="ativo" <?= (isset($_POST['ativo']) && $_POST['ativo']) ? 'checked' : 'checked' ?>> Curso Ativo
        </label>
    </div>

    <button type="submit" class="BtnCadastrar_Sec">Cadastrar Curso</button>
    
    <button type="button" class="BtnVoltar" onclick="voltarAoPainel()">Voltar ao Painel</button>
    
<?php if (isset($mensagem) && $mensagem): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            // Detectar tipo de mensagem
            if (strpos($mensagem, 'sucesso') !== false) {
                echo "Popup.success('" . addslashes($mensagem) . "');";
                echo "document.querySelector('input[name=\"nome_curso\"]').value = '';";
                echo "document.querySelector('input[name=\"abreviatura\"]').value = '';";
                echo "document.querySelector('select[name=\"total_semestres\"]').value = '';";
                echo "document.querySelector('select[name=\"total_anos\"]').value = '';";
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