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

## cadastro

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome     = trim($_POST["nome"]);
    $email    = trim($_POST["email"]);
    $senha    = trim($_POST["senha"], PASSWORD_DEFAULT);
    $cpf      = trim($_POST["cpf"]);
    $telefone = trim($_POST["telefone"]);
    $tipo     = $_POST["tipo"]; ## A, P ou S

    ## verificar se e-mail ou CPF já existem
    $check = $conn->prepare("
        SELECT iden_user 
        FROM usuario
        WHERE mail_user = ? OR codg_user = ?
    ");
    $check->bind_param("ss", $email, $cpf);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $mensagem = "E-mail ou CPF já cadastrados.";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO usuario (codg_user, nome_user, mail_user, senh_user, fone_user, flag_user)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssssss", $cpf, $nome, $email, $senha, $telefone, $tipo);

        if ($stmt->execute()) {
            $mensagem = "Usuário cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar: " . $conn->error;
        }
        $stmt->close();
    }
    $check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            width: 320px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .mensagem {
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<form action="" method="POST">
    <h2>Cadastro</h2>
    <input type="text" name="nome" placeholder="Nome completo" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <input type="text" name="cpf" placeholder="CPF (ex: 000.000.000-00)" required>
    <input type="text" name="telefone" placeholder="Telefone (opcional)">
    <select name="tipo" required>
        <option value="">Selecione o tipo</option>
        <option value="A">Aluno</option>
        <option value="P">Professor</option>
        <option value="S">Secretaria</option>
    </select>
    <button type="submit">Cadastrar</button>
    <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
</form>

</body>
</html>