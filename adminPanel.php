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

## Determinar qual formulário está ativo
$formularioAtivo = isset($_GET['form']) ? $_GET['form'] : '';

## Processar cadastro baseado no formulário ativo
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    switch($formularioAtivo) {
        case 'aluno':
            include 'controllerCadastroAluno.php';
            break;
        case 'professor':
            include 'controllerCadastroProfessor.php';
            break;
        case 'secretaria':
            include 'controllerCadastroSecretaria.php';
            break;
        case 'curso':
            // Incluir controller para curso quando existir
            break;
        case 'materia':
            include 'controllerCadastroMateria.php';
            break;
        case 'turma':
            include 'controllerCadastroTurma.php';
            break;
        default:
            ## cadastro genérico (fallback)
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
            break;
    }
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
    <link rel="stylesheet" href="css/popup.css">
    <script src="js/popup.js"></script>
    <title>Admin Painel</title>
    <style>
        .oculto {
            display: none !important;
        }
    </style>
    
</head>
<body>
    <div class="container_AdminPainel">
        <h1 id="title_painel" <?= $formularioAtivo ? 'style="display: none;"' : '' ?>>Painel Administrativo</h1>

        <!-- Cards principais -->
        <div class="cards-principais" <?= $formularioAtivo ? 'style="display: none;"' : '' ?>>
            <div class="card" onclick="mostrarSubcards('usuario')">Cadastrar Usuário</div>
            <div class="card" onclick="mostrarSubcards('cursos')">Cadastrar Cursos e Matérias</div>
            <div class="card" onclick="abrirFormulario('calendario')">Editar Calendário</div>
        </div>

        <!-- Subcards de usuário -->
        <div id="subcards-usuario" class="subcards oculto">
            <div class="card-sub" onclick="abrirFormulario('aluno')">Aluno</div>
            <div class="card-sub" onclick="abrirFormulario('secretaria')">Secretaria</div>
            <div class="card-sub" onclick="abrirFormulario('professor')">Professor</div>
            <button class="voltar" onclick="voltarPrincipal()">Voltar</button>
        </div>

        <!-- Subcards de cursos e matérias -->
        <div id="subcards-cursos" class="subcards oculto">
            <div class="card-sub" onclick="abrirFormulario('curso')">Curso</div>
            <div class="card-sub" onclick="abrirFormulario('materia')">Matéria</div>
            <div class="card-sub" onclick="abrirFormulario('turma')">Turma</div>
            <button class="voltar" onclick="voltarPrincipal()">Voltar</button>
        </div>

        <!-- Área dinâmica para incluir formulários -->
        <div id="conteudo-dinamico">
            <?php
            ## Incluir formulário baseado no parâmetro GET
            if ($formularioAtivo) {
                switch($formularioAtivo) {
                    case 'aluno':
                        include 'secretaria/FormAluno.php';
                        break;
                    case 'secretaria':
                        include 'secretaria/FormSec.php';
                        break;
                    case 'professor':
                        include 'secretaria/FormProf.php';
                        break;
                    case 'curso':
                        include 'secretaria/FormCurso.php';
                        break;
                    case 'materia':
                        include 'secretaria/FormMat.php';
                        break;
                    case 'turma':
                        include 'secretaria/FormTurma.php';
                        break;
                    case 'calendario':
                        include 'secretaria/FormCalendario.php';
                        break;
                    default:
                        echo "<p>Formulário não encontrado.</p>";
                        break;
                }
            }
            ?>
        </div>
    </div>

    <script>
        const titulo = document.getElementById('title_painel');       
        const painel = document.querySelector('.container_AdminPainel');
        const cardsPrincipais = document.querySelector('.cards-principais');
        const subcardsUsuario = document.getElementById('subcards-usuario');
        const subcardsCursos = document.getElementById('subcards-cursos');
        const conteudoDinamico = document.getElementById('conteudo-dinamico');

        // Verificar se há um formulário ativo na carga da página
        const urlParams = new URLSearchParams(window.location.search);
        const formAtivo = urlParams.get('form');
        
        if (formAtivo) {
            // Se há um formulário ativo, esconder elementos do painel
            titulo.style.display = 'none';
            cardsPrincipais.style.display = 'none';
            subcardsUsuario.classList.add('oculto');
            subcardsCursos.classList.add('oculto');
            painel.style.padding = '0px';
        }

        function mostrarSubcards(tipo) {
            titulo.style.display = 'none';
            cardsPrincipais.classList.add('oculto');
            if (tipo === 'usuario') {
                subcardsUsuario.classList.remove('oculto');
                subcardsCursos.classList.add('oculto');
            } else if (tipo === 'cursos') {
                subcardsCursos.classList.remove('oculto');
                subcardsUsuario.classList.add('oculto');
            }
        }

        function voltarPrincipal() {
            subcardsUsuario.classList.add('oculto');
            subcardsCursos.classList.add('oculto');
            conteudoDinamico.innerHTML = '';
            cardsPrincipais.classList.remove('oculto');
            titulo.style.display = 'block';
            painel.style.padding = '';
            // Limpar URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        function abrirFormulario(tipo) {
            // Redirecionar para a mesma página com parâmetro GET
            window.location.href = '?form=' + tipo;
        }
    </script>
</body>
</html>