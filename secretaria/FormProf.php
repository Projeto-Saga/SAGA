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
                <input type="text" name="nome" placeholder="Nome completo" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                <input type="email" name="email" placeholder="E-mail será gerado automaticamente" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required readonly>
                <input type="password" name="senha" placeholder="Senha" required>
                <input type="text" name="cpf" placeholder="CPF (ex: 000.000.000-00)" value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>" required>
                <input type="text" name="telefone" placeholder="Telefone (ex: (11) 91234-5678)" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>">
            </div>
            
            <!-- Seleção de curso -->
            <div class="curso-container">
                <select name="curso" id="curso" required onchange="carregarMaterias(this.value)">
                    <option value="">Selecione um curso</option>
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?= $curso['iden_curs'] ?>" <?= (isset($_POST['curso']) && $_POST['curso'] == $curso['iden_curs']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($curso['nome_curs']) ?> (<?= htmlspecialchars($curso['abrv_curs']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
        
        <input type="hidden" name="tipo" value="P">

        <div class="direito">
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
        </div>
 <!-- Container das matérias DO LADO do formulário -->
    </div>

        <div class="Div_BtnCadastros">
            <button type="submit" class="BtnCadastrar_Sec">Cadastrar Professor</button>
            <button type="button" class="BtnVoltar" onclick="voltarAoPainel()">Voltar ao Painel</button>
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

// Função para carregar matérias do curso selecionado
// Função para carregar matérias do curso selecionado
function carregarMaterias(cursoId) {
    const materiasContainer = document.getElementById('materiasContainer');
    const materiasGrid = document.getElementById('materiasGrid');
    
    if (!cursoId) {
        materiasContainer.style.display = 'none';
        materiasGrid.innerHTML = '';
        return;
    }
    
    // Mostrar loading
    materiasContainer.style.display = 'block';
    materiasGrid.innerHTML = '<div class="loading">Carregando matérias...</div>';
    
    fetch('buscarMateriasCurso.php?curso_id=' + cursoId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (data.materias.length > 0) {
                    materiasGrid.innerHTML = '';
                    data.materias.forEach(materia => {
                        const materiaItem = document.createElement('div');
                        materiaItem.className = 'materia-item';
                        materiaItem.innerHTML = `
                            <input type="checkbox" name="materias[]" value="${materia.iden_matr}" id="materia_${materia.iden_matr}">
                            <label for="materia_${materia.iden_matr}">
                                <strong>${materia.abrv_matr}</strong> - ${materia.nome_matr}
                            </label>
                        `;
                        materiasGrid.appendChild(materiaItem);
                    });
                } else {
                    materiasGrid.innerHTML = '<div class="no-materias">Nenhuma matéria encontrada para este curso.</div>';
                }
            } else {
                materiasGrid.innerHTML = '<div class="error">' + (data.message || 'Erro ao carregar matérias.') + '</div>';
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            materiasGrid.innerHTML = '<div class="error">Erro ao carregar matérias.</div>';
        });
}
// Função para selecionar todas as matérias
function selecionarTodasMaterias() {
    const checkboxes = document.querySelectorAll('#materiasGrid input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}

// Função para deselecionar todas as matérias
function deselecionarTodasMaterias() {
    const checkboxes = document.querySelectorAll('#materiasGrid input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}

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

// Prevenir comportamento padrão do formulário e mostrar loading
document.getElementById('formProfessor').addEventListener('submit', function(e) {
    console.log('Formulário submetido - processando...');
    
    // Mostrar loading no botão
    const btnSubmit = this.querySelector('button[type="submit"]');
    const originalText = btnSubmit.textContent;
    btnSubmit.textContent = 'Cadastrando...';
    btnSubmit.disabled = true;
    
    // O formulário continuará com o comportamento normal (POST)
    // mas pelo menos o usuário verá o loading
    
    setTimeout(() => {
        btnSubmit.textContent = originalText;
        btnSubmit.disabled = false;
    }, 3000);
});

</script>