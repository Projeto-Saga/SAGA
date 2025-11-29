<link rel="stylesheet" href="css/CadastroSec.css">

<form class="FormCadastroSec" method="POST">
    <h2>Cadastro de Secretário</h2>

    <div class="inputsSecretaria" style="display: flex; flex-direction:column; gap: 10px;">
        <label>Nome Completo:</label>
        <input type="text" name="nome" placeholder="Nome completo" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
        <input type="email" name="email" placeholder="E-mail será gerado automaticamente" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required readonly>
        <label>Senha:</label>
        <input type="password" name="senha" placeholder="Senha" required>
        <label>CPF:</label>
        <input type="text" name="cpf" placeholder="CPF (ex: 000.000.000-00)" value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>" required>
        <label>Telefone:</label>
        <input type="text" name="telefone" placeholder="Telefone (ex: (11) 91234-5678)" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>">
    </div>

    <input type="hidden" name="tipo" value="S">

    <div class="Div_BtnCadastros">
        <button type="submit" class="BtnCadastrar_Sec">Cadastrar Secretário</button>
        <button type="button" class="BtnVoltar" onclick="voltarAoPainel()">Voltar ao Painel</button>
    </div>
</form>

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
<script src="js/emailGenerator.js"></script>

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

// Função para voltar ao painel
function voltarAoPainel() {
    if (window.parent && window.parent !== window) {
        if (typeof window.parent.voltarAoPainel === 'function') {
            window.parent.voltarAoPainel();
        } else {
            window.parent.location.href = '../adminPanel.php';
        }
    } else {
        window.location.href = '../adminPanel.php';
    }
}
</script>