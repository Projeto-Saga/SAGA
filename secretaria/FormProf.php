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

## Buscar cursos do banco de dados
$cursos = [];
$sql_cursos = "SELECT iden_curs, nome_curs, abrv_curs FROM curso ORDER BY nome_curs";
$result_cursos = $conn->query($sql_cursos);
if ($result_cursos && $result_cursos->num_rows > 0) {
    while($row = $result_cursos->fetch_assoc()) {
        $cursos[] = $row;
    }
}
$conn->close();
?>

<link rel="stylesheet" href="../css/CadastroSec.css">

<div class="professor-container">
    <form class="FormCadastroSec" method="POST" id="formProfessor">
        <h2>Cadastro de Professor</h2>

        <div class="conjunto">
            
            <div class="esquerdo">
                <div class="inputsProfessor">
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
                
                <!-- Seleção de curso -->
                <div class="curso-container">
                    <select name="curso" id="curso" required onchange="carregarMaterias(this.value); carregarTurmas(this.value);">
                        <option value="">Selecione um curso</option>
                        <?php foreach ($cursos as $curso): ?>
                            <option value="<?= $curso['iden_curs'] ?>" <?= (isset($_POST['curso']) && $_POST['curso'] == $curso['iden_curs']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($curso['nome_curs']) ?> (<?= htmlspecialchars($curso['abrv_curs']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Aqui podem ir outros campos do lado esquerdo -->

            </div>
            
            <input type="hidden" name="tipo" value="P">

            <div class="direito">
                <!-- Matérias (já existente, sem alteração) -->
                <div class="materias-container" id="materiasContainer">
                    <div class="materias-header">
                        <h3>Matérias do Curso</h3>
                        <p>Selecione um curso para carregar as matérias</p>
                    </div>
                    <div class="materias-grid" id="materiasGrid">
                        <!-- As matérias serão carregadas aqui via JavaScript -->
                    </div>
                    <div class="materias-actions">
                        <button type="button" class="btn-selecionar-todas" onclick="selecionarTodasMaterias()">Selecionar Todas</button>
                        <button type="button" class="btn-deselecionar-todas" onclick="deselecionarTodasMaterias()">Deselecionar Todas</button>
                    </div>
                </div>

                <!-- Turmas (nova área com checkboxes) -->
                <div class="materias-container" id="turmasContainer" style="margin-top:18px;">
                    <div class="materias-header">
                        <h3>Turmas do Curso</h3>
                        <p>Selecione uma ou mais turmas para este professor</p>
                    </div>
                    <div class="materias-grid" id="turmasGrid">
                        <!-- As turmas serão carregadas aqui via JavaScript -->
                    </div>
                    <div class="materias-actions">
                        <button type="button" class="btn-selecionar-todas" onclick="selecionarTodasTurmas()">Selecionar Todas</button>
                        <button type="button" class="btn-deselecionar-todas" onclick="deselecionarTodasTurmas()">Deselecionar Todas</button>
                    </div>
                </div>
            </div>
        </div>
 <!-- Container das matérias DO LADO do formulário -->
    </div>

        <div class="Div_BtnCadastros">
            <button type="submit" class="BtnCadastrar_Sec">Cadastrar Professor</button>
            <button type="button" class="BtnVoltar" onclick="voltarAoPainel()" style="margin-bottom:10px;">Voltar ao Painel</button>
        </div>
    
    </form>
</div>

<?php if (isset($mensagem) && $mensagem): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            // Detectar tipo de mensagem
            if (strpos($mensagem, 'sucesso') !== false) {
                echo "Popup.success('" . addslashes($mensagem) . "');";
                echo "document.querySelector('input[name=\"nome\"]').value = '';";
                echo "document.querySelector('input[name=\"email\"]').value = '';";
                echo "document.querySelector('input[name=\"senha\"]').value = '';";
                echo "document.querySelector('input[name=\"cpf\"]').value = '';";
                echo "document.querySelector('input[name=\"telefone\"]').value = '';";
                echo "document.querySelector('select[name=\"curso\"]').value = '';";
                echo "document.getElementById('materiasGrid').innerHTML = '';";
                echo "document.getElementById('turmasGrid').innerHTML = '';";
            } else if (strpos($mensagem, 'ERRO') !== false || strpos($mensagem, 'erro') !== false) {
                echo "Popup.error('" . addslashes($mensagem) . "');";
            } else {
                echo "Popup.info('" . addslashes($mensagem) . "');";
            }
            ?>
        });
    </script>
<?php endif; ?>

<!-- Incluir o gerador de email -->
<script src="/SAGA/js/emailGenerator.js"></script>

<script>
// Inicializar gerador de email quando o DOM carregar
document.addEventListener('DOMContentLoaded', function() {
    EmailGenerator.inicializar('input[name="nome"]', 'input[name="email"]');
});

// Máscara para CPF
document.querySelector('input[name="cpf"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }
    e.target.value = value;
});

// Máscara para telefone
document.querySelector('input[name="telefone"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{2})(\d)/, '($1) $2')
                    .replace(/(\d{5})(\d)/, '$1-$2');
    }
    e.target.value = value;
});

// ---------- MATÉRIAS (já implementado) ----------
function carregarMaterias(cursoId) {
    const materiasGrid = document.getElementById('materiasGrid');
    materiasGrid.innerHTML = '<div class="loading">Carregando matérias...</div>';
    if (!cursoId) {
        materiasGrid.innerHTML = '';
        return;
    }

    fetch('buscarMateriasCurso.php?curso_id=' + cursoId)
        .then(r => r.json())
        .then(data => {
            if (data.success && data.materias.length) {
                materiasGrid.innerHTML = '';
                data.materias.forEach(materia => {
                    const el = document.createElement('div');
                    el.className = 'materia-item';
                    el.innerHTML = `
                        <label style="display:flex;align-items:center;gap:12px;">
                            <input type="checkbox" name="materias[]" value="${materia.iden_matr}" id="mat_${materia.iden_matr}">
                            <span><strong>${materia.abrv_matr}</strong> - ${materia.nome_matr}</span>
                        </label>
                    `;
                    materiasGrid.appendChild(el);
                });
            } else {
                materiasGrid.innerHTML = '<div class="no-materias">Nenhuma matéria encontrada para este curso.</div>';
            }
        })
        .catch(e => {
            console.error(e);
            materiasGrid.innerHTML = '<div class="error">Erro ao carregar matérias.</div>';
        });
}

function selecionarTodasMaterias() {
    document.querySelectorAll('#materiasGrid input[type="checkbox"]').forEach(c => c.checked = true);
}
function deselecionarTodasMaterias() {
    document.querySelectorAll('#materiasGrid input[type="checkbox"]').forEach(c => c.checked = false);
}

// ---------- TURMAS (nova) ----------
function carregarTurmas(cursoId) {
    const turmasGrid = document.getElementById('turmasGrid');
    turmasGrid.innerHTML = '<div class="loading">Carregando turmas...</div>';
    if (!cursoId) {
        turmasGrid.innerHTML = '';
        return;
    }

    fetch('buscarTurmasCurso.php?curso_id=' + cursoId)
        .then(r => r.json())
        .then(data => {
            if (data.success && data.turmas.length) {
                turmasGrid.innerHTML = '';
                data.turmas.forEach(turma => {
                    const el = document.createElement('div');
                    el.className = 'materia-item'; // reaproveita estilo
                    el.innerHTML = `
                        <label style="display:flex;align-items:center;gap:12px;">
                            <input type="checkbox" name="turmas[]" value="${turma.iden_turm}" id="turm_${turma.iden_turm}">
                            <span><strong>${turma.nome_turm}</strong></span>
                        </label>
                    `;
                    turmasGrid.appendChild(el);
                });
            } else {
                turmasGrid.innerHTML = '<div class="no-materias">Nenhuma turma encontrada para este curso.</div>';
            }
        })
        .catch(e => {
            console.error(e);
            turmasGrid.innerHTML = '<div class="error">Erro ao carregar turmas.</div>';
        });
}

function selecionarTodasTurmas() {
    document.querySelectorAll('#turmasGrid input[type="checkbox"]').forEach(c => c.checked = true);
}
function deselecionarTodasTurmas() {
    document.querySelectorAll('#turmasGrid input[type="checkbox"]').forEach(c => c.checked = false);
}

// Prevenir comportamento padrão do formulário e mostrar loading
document.getElementById('formProfessor').addEventListener('submit', function(e) {
    // mostra loading no botão
    const btnSubmit = this.querySelector('button[type="submit"]');
    const originalText = btnSubmit.textContent;
    btnSubmit.textContent = 'Cadastrando...';
    btnSubmit.disabled = true;

    setTimeout(() => {
        btnSubmit.textContent = originalText;
        btnSubmit.disabled = false;
    }, 3000);
});

// Função para voltar ao painel (igual ao seu original)
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
