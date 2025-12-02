<?php
## conexao banco de dados apenas para buscar cursos
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "saga_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

## Buscar cursos do banco de dados
$cursos = [];
$sql_cursos = "SELECT iden_curs, nome_curs, abrv_curs FROM curso ORDER BY nome_curs";
$result_cursos = $conn->query($sql_cursos);
if ($result_cursos && $result_cursos->num_rows > 0) {
    while($row = $result_cursos->fetch_assoc()) {
        $cursos[] = $row;
    }
}

## Buscar turmas (todas, com id do curso)
$turmas = [];
$sql_turmas = "SELECT iden_turm, nome_turm, iden_curs FROM turma ORDER BY nome_turm";
$result_turmas = $conn->query($sql_turmas);
if ($result_turmas && $result_turmas->num_rows > 0) {
    while($row = $result_turmas->fetch_assoc()) {
        $turmas[] = $row;
    }
}

$conn->close();
?>

<link rel="stylesheet" href="css/CadastroSec.css">

<form class="FormCadastroSec" method="POST">
    <h2>Cadastro de Aluno</h2>

    <div class="inputsAluno">
        <label style="position: relative; top: 8px;">Nome completo:</label>
        <input type="text" name="nome" placeholder="Nome completo" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>

        <input type="email" name="email" placeholder="E-mail será gerado automaticamente" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required readonly>

        <label style="position: relative; top: 8px;">Senha:</label>
        <input type="password" name="senha" placeholder="Senha" required>

        <label style="position: relative; top: 8px;">CPF:</label>
        <input type="text" name="cpf" placeholder="CPF (ex: 000.000.000-00)" value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>" required>

        <label style="position: relative; top: 8px;">Telefone:</label>
        <input type="text" name="telefone" placeholder="Telefone (ex: (11) 91234-5678)" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>">
    </div>

    <!-- SELECIONAR CURSO -->
    <label>Curso:</label>
    <select name="curso" id="curso_select" required>
        <option value="">Selecione o curso</option>
        <?php foreach ($cursos as $curso): ?>
            <option value="<?= $curso['iden_curs'] ?>" <?= (isset($_POST['curso']) && $_POST['curso'] == $curso['iden_curs']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($curso['nome_curs']) ?> (<?= htmlspecialchars($curso['abrv_curs']) ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <!-- SELECIONAR TURMA (DINÂMICO) -->
    <label>Turma:</label>
    <select name="turma" id="turma_select" required>
        <option value="">Selecione um curso primeiro</option>
    </select>

    <input type="hidden" name="tipo" value="A">

    <div class="Div_BtnCadastros">
        <button type="submit" class="BtnCadastrar_Sec">Cadastrar Aluno</button>
        <!-- Botão Voltar -->
        <button type="button" class="BtnVoltar" onclick="voltarAoPainel()">Voltar ao Painel</button>
    </div>
</form>

<!-- POPUP -->
<?php if (isset($mensagem) && $mensagem): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            if (strpos($mensagem, 'sucesso') !== false) {
                echo "Popup.success('" . addslashes($mensagem) . "');";
                echo "document.querySelector('input[name=\"nome\"]').value = '';";
                echo "document.querySelector('input[name=\"email\"]').value = '';";
                echo "document.querySelector('input[name=\"senha\"]').value = '';";
                echo "document.querySelector('input[name=\"cpf\"]').value = '';";
                echo "document.querySelector('input[name=\"telefone\"]').value = '';";
                echo "document.querySelector('select[name=\"curso\"]').value = '';";
                echo "document.querySelector('select[name=\"turma\"]').innerHTML = '<option>Selecione um curso primeiro</option>';";
            } else if (strpos($mensagem, 'ERRO') !== false || strpos($mensagem, 'erro') !== false) {
                echo "Popup.error('" . addslashes($mensagem) . "');";
            } else {
                echo "Popup.info('" . addslashes($mensagem) . "');";
            }
            ?>
        });
    </script>
<?php endif; ?>

<!-- EMAIL AUTO -->
<script src="js/emailGenerator.js"></script>

<script>
// Inicializar gerador de email
document.addEventListener('DOMContentLoaded', function() {
    EmailGenerator.inicializar('input[name="nome"]', 'input[name="email"]');
});

// Máscara CPF
document.querySelector('input[name="cpf"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }
    e.target.value = value;
});

// Máscara telefone
document.querySelector('input[name="telefone"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{2})(\d)/, '($1) $2')
                    .replace(/(\d{5})(\d)/, '$1-$2');
    }
    e.target.value = value;
});

// ---------- NOVO: LISTA DE TURMAS FILTRADA POR CURSO ----------

// Array de turmas vindas do PHP
const turmas = [
    <?php foreach ($turmas as $t): ?>
        {
            id: "<?= $t['iden_turm'] ?>",
            nome: "<?= $t['nome_turm'] ?>",
            curso: "<?= $t['iden_curs'] ?>"
        },
    <?php endforeach; ?>
];

// Quando selecionar o curso → filtra turmas
document.getElementById("curso_select").addEventListener("change", function() {
    const cursoId = this.value;
    const turmaSelect = document.getElementById("turma_select");

    turmaSelect.innerHTML = "";

    if (!cursoId) {
        turmaSelect.innerHTML = '<option value="">Selecione um curso primeiro</option>';
        return;
    }

    const filtradas = turmas.filter(t => t.curso === cursoId);

    if (filtradas.length === 0) {
        turmaSelect.innerHTML = '<option value="">Nenhuma turma encontrada</option>';
        return;
    }

    turmaSelect.innerHTML = '<option value="">Selecione</option>';
    filtradas.forEach(t => {
        turmaSelect.innerHTML += `<option value="${t.id}">${t.nome}</option>`;
    });
});

// Função para voltar ao painel
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
