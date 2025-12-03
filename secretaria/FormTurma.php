<?php
// Carregar cursos
$cursos = $conn->query("
    SELECT iden_curs, nome_curs, abrv_curs, total_semestres 
    FROM curso 
    ORDER BY nome_curs
");
?>

<link rel="stylesheet" href="../css/CadastroSec.css">

<div class="container_AdminPainel">

    <h1>Cadastrar Turma</h1>

    <form method="POST" action="?form=turma" class="FormCadastroSec">

        <!-- Nome da Turma -->
        <label>Nome da Turma:</label>
        <input type="text" id="nome_turma" name="nome_turma" placeholder="Gerado automaticamente" readonly required>

        <!-- Curso -->
        <label>Curso:</label>
        <select name="curso_id" id="curso_select" required>
            <option value="">Selecione o curso</option>

            <?php while ($c = $cursos->fetch_assoc()): ?>
                <option 
                    value="<?= $c['iden_curs'] ?>"
                    data-semestres="<?= $c['total_semestres'] ?>"
                    data-abrev="<?= $c['abrv_curs'] ?>"
                >
                    <?= $c['nome_curs'] ?> (<?= $c['abrv_curs'] ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <!-- Semestre -->
        <label>Semestre da Turma:</label>
        <select name="semestre_turma" id="semestre_select" required>
            <option value="">Selecione um curso primeiro</option>
        </select>

        <!-- Ano -->
        <label>Ano da Turma:</label>
        <input type="number" id="ano_turma" name="ano_turma" placeholder="2025" min="2000" max="2100" required>

        <div class="Div_BtnCadastros">
            <button type="submit" class="BtnCadastrar_Sec">Cadastrar</button>
            <button type="button" class="voltar" onclick="voltarAoPainel()">Voltar</button>
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
            } else if (strpos($mensagem, 'ERRO') !== false || strpos($mensagem, 'erro') !== false) {
                echo "Popup.error('" . addslashes($mensagem) . "');";
            } else {
                echo "Popup.info('" . addslashes($mensagem) . "');";
            }
            ?>
        });
    </script>
<?php endif; ?>

<script>
/* ----------- Gerar nome automaticamente ----------- */
function gerarNomeTurma() {
    const cursoSelect = document.getElementById("curso_select");
    const ano = document.getElementById("ano_turma").value;
    const semestre = document.getElementById("semestre_select").value;
    const nomeCampo = document.getElementById("nome_turma");

    if (!cursoSelect.value || !ano || !semestre) {
        nomeCampo.value = "";
        return;
    }

    const abrev = cursoSelect.selectedOptions[0].getAttribute("data-abrev");
    nomeCampo.value = `${abrev}-${ano}-${semestre}`;
}

/* ----------- Quando selecionar curso → carregar semestres ----------- */
document.getElementById("curso_select").addEventListener("change", function () {
    const selectCurso = this;
    const selectSemestre = document.getElementById("semestre_select");

    selectSemestre.innerHTML = "";

    const totalSemestres = selectCurso.selectedOptions[0].getAttribute("data-semestres");

    if (!totalSemestres) {
        selectSemestre.innerHTML = '<option value="">Selecione um curso primeiro</option>';
        return;
    }

    let options = '<option value="">Selecione</option>';
    for (let i = 1; i <= totalSemestres; i++) {
        options += `<option value="${i}">${i}º Semestre</option>`;
    }

    selectSemestre.innerHTML = options;
    gerarNomeTurma();
});

/* ----------- Sempre atualizar o nome ----------- */
document.getElementById("semestre_select").addEventListener("change", gerarNomeTurma);
document.getElementById("ano_turma").addEventListener("input", gerarNomeTurma);

</script>

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