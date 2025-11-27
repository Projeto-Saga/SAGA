<?php
## Este arquivo será incluído pelo adminPanel.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome     = trim($_POST["nome"]);
    $email    = trim($_POST["email"]);
    $senha    = trim($_POST["senha"]);
    $cpf      = trim($_POST["cpf"]);
    $telefone = trim($_POST["telefone"]);
    $curso_id = $_POST["curso"];
    $tipo     = "A"; ## Sempre será Aluno

    ## Formatar telefone
    $telefone_formatado = preg_replace('/[^0-9]/', '', $telefone);
    if (strlen($telefone_formatado) === 11) {
        $telefone_formatado = "(" . substr($telefone_formatado, 0, 2) . ") " . 
                             substr($telefone_formatado, 2, 5) . "-" . 
                             substr($telefone_formatado, 7);
    }

    ## Formatar CPF
    $cpf_formatado = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf_formatado) === 11) {
        $cpf_formatado = substr($cpf_formatado, 0, 3) . "." . 
                        substr($cpf_formatado, 3, 3) . "." . 
                        substr($cpf_formatado, 6, 3) . "-" . 
                        substr($cpf_formatado, 9);
    }

    ## Iniciar transação
    $conn->begin_transaction();
    
    try {
        ## Gerar regex_user (ano atual + sequencial)
        $ano_atual = date('Y');
        
        $sql_ultimo_regex = "SELECT MAX(CAST(regx_user AS UNSIGNED)) as max_regex 
                             FROM usuario 
                             WHERE regx_user LIKE '$ano_atual%'";
        $result_ultimo = $conn->query($sql_ultimo_regex);
        
        if ($result_ultimo && $result_ultimo->num_rows > 0) {
            $row = $result_ultimo->fetch_assoc();
            $ultimo_regex = $row['max_regex'];
            $sequencial = $ultimo_regex ? $ultimo_regex + 1 : $ano_atual . "000001";
        } else {
            $sequencial = $ano_atual . "000001";
        }
        
        $regex_user = strval($sequencial);

        ## Buscar último iden_alun
        $sql_ultimo_aluno = "SELECT MAX(iden_alun) as ultimo_id FROM aluno";
        $result_ultimo_aluno = $conn->query($sql_ultimo_aluno);
        $ultimo_id_aluno = $result_ultimo_aluno && $result_ultimo_aluno->num_rows > 0 ? $result_ultimo_aluno->fetch_assoc()['ultimo_id'] : 0;
        $novo_id_aluno = $ultimo_id_aluno + 1;

        ## Buscar matérias do curso para o 1º semestre
        $materias_curso = [];
        $sql_materias = "SELECT cm.iden_matr 
                         FROM curso_materia cm 
                         WHERE cm.iden_curs = ? AND cm.ciclo_semestre = 1";
        $stmt_materias = $conn->prepare($sql_materias);
        $stmt_materias->bind_param("i", $curso_id);
        $stmt_materias->execute();
        $result_materias = $stmt_materias->get_result();
        while($row = $result_materias->fetch_assoc()) {
            $materias_curso[] = $row['iden_matr'];
        }
        $stmt_materias->close();

        ## Verificar se e-mail ou CPF já existem
        $check = $conn->prepare("SELECT iden_user FROM usuario WHERE mail_user = ? OR codg_user = ?");
        $check->bind_param("ss", $email, $cpf_formatado);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            throw new Exception("E-mail ou CPF já cadastrados.");
        }
        $check->close();

        ## Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        ## Inserir na tabela usuario
        $stmt_usuario = $conn->prepare("
            INSERT INTO usuario (regx_user, codg_user, nome_user, mail_user, senh_user, fone_user, flag_user)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt_usuario->bind_param("sssssss", $regex_user, $cpf_formatado, $nome, $email, $senha_hash, $telefone_formatado, $tipo);
        $stmt_usuario->execute();
        $stmt_usuario->close();

        ## Inserir na tabela aluno
        $cicl_alun = 1;
        $stmt_aluno = $conn->prepare("
            INSERT INTO aluno (regx_user, iden_curs, iden_alun, cicl_alun)
            VALUES (?, ?, ?, ?)
        ");
        $stmt_aluno->bind_param("siii", $regex_user, $curso_id, $novo_id_aluno, $cicl_alun);
        $stmt_aluno->execute();
        $stmt_aluno->close();

        ## Inserir na tabela cursando
        if (!empty($materias_curso)) {
            $ano_atual_cursando = date('Y');
            $semestre_atual = (date('n') <= 6) ? 1 : 2;
            $situacao = "Em curso";

            $stmt_cursando = $conn->prepare("
                INSERT INTO cursando (regx_user, iden_matr, ntp1_crsn, ntp2_crsn, ntp3_crsn, nttt_crsn, falt_crsn, cicl_alun, _ano_crsn, _sem_crsn, situ_crsn)
                VALUES (?, ?, 0, 0, 0, 0, 0, ?, ?, ?, ?)
            ");

            foreach ($materias_curso as $iden_matr) {
                $stmt_cursando->bind_param("siiiss", $regex_user, $iden_matr, $cicl_alun, $ano_atual_cursando, $semestre_atual, $situacao);
                $stmt_cursando->execute();
            }
            $stmt_cursando->close();
        }

        ## Commit da transação
        $conn->commit();
        $mensagem = "Aluno cadastrado com sucesso!";

    } catch (Exception $e) {
        ## Rollback em caso de erro
        $conn->rollback();
        $mensagem = $e->getMessage();
    }
}
?>