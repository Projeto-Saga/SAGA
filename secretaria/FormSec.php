<?php
$tipoSelecionado = isset($_GET['tipo']) ? $_GET['tipo'] : '';
?>

<link rel="stylesheet" href="../css/CadastroSec.css">

<form class="FormCadastroSec" action="" method="POST">
    <h2>Cadastro de Secretários</h2>

    <input type="text" name="nome" placeholder="Nome completo" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <input type="text" name="cpf" placeholder="CPF (ex: 000.000.000-00)" required>
    <input type="text" name="telefone" placeholder="Telefone (opcional)">
    
    <select name="tipo" required>
        <option value="">Selecione o tipo</option>
        <option value="A" <?= $tipoSelecionado === 'A' ? 'selected' : '' ?>>Aluno</option>
        <option value="P" <?= $tipoSelecionado === 'P' ? 'selected' : '' ?>>Professor</option>
        <option value="S" <?= $tipoSelecionado === 'S' ? 'selected' : '' ?>>Secretaria</option>
    </select>

    <button type="submit" class="BtnCadastrar_Sec">Cadastrar</button>
    <div class="mensagem"><?= htmlspecialchars($mensagem ?? '') ?></div>
</form>
