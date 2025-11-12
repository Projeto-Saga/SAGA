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

## cadastro (somente se o form foi enviado)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome     = trim($_POST["nome"]);
    $email    = trim($_POST["email"]);
    $senha    = password_hash(trim($_POST["senha"]), PASSWORD_DEFAULT);
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
    <?php include('html/head.php'); ?>
    <?php include('html/base.php'); ?>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/CadastroSec.css">
    <title>Admin Painel</title>
</head>
<body>

    <div class="container_AdminPainel">
        <h1 id="title_painel">Painel Administrativo</h1>

        <!-- Cards principais -->
        <div class="cards-principais">
            <div class="card" onclick="mostrarSubcards('usuario')">Cadastrar Usuário</div>
            <div class="card" onclick="abrirFormulario('curso')">Cadastrar Cursos e Matérias</div>
            <div class="card" onclick="abrirFormulario('calendario')">Editar Calendário</div>
        </div>

        <!-- Subcards de usuário -->
        <div id="subcards-usuario" class="subcards oculto">
            <div class="card-sub" onclick="abrirFormulario('aluno')">Aluno</div>
            <div class="card-sub" onclick="abrirFormulario('secretaria')">Secretaria</div>
            <div class="card-sub" onclick="abrirFormulario('professor')">Professor</div>
            <button class="voltar" onclick="voltarPrincipal()">Voltar</button>
        </div>

        <!-- Área dinâmica para incluir formulários -->
        <div id="conteudo-dinamico"></div>
    </div>

    <script>

        const titulo = document.getElementById('title_painel');       
        const painel = document.querySelector('.container_AdminPainel');

        function mostrarSubcards(tipo) {
            document.querySelector('.cards-principais').classList.add('oculto');
            document.getElementById('subcards-' + tipo).classList.remove('oculto');
        }

        function voltarPrincipal() {
            document.getElementById('subcards-usuario').classList.add('oculto');
            document.getElementById('conteudo-dinamico').innerHTML = '';
            document.querySelector('.cards-principais').classList.remove('oculto');
        }

        function abrirFormulario(tipo) {
            let url = '';
            if (tipo === 'aluno' || tipo === 'secretaria' || tipo === 'professor') {
                url = 'secretaria/FormUser.php';
                titulo.style.display = 'none';
                painel.style.padding = '0px'
            } else if (tipo === 'curso') {
                url = 'cursos/FormCurso.php';
            } else if (tipo === 'calendario') {
                url = 'calendario/FormCalendario.php';
            }

            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('conteudo-dinamico').innerHTML = html;
                    document.getElementById('subcards-usuario').classList.add('oculto');
                })
                .catch(err => {
                    document.getElementById('conteudo-dinamico').innerHTML = '<p>Erro ao carregar o formulário.</p>';
                });
        }
    </script>
</body>
</html>
