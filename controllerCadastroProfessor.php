<?php
## Este arquivo será incluído pelo adminPanel.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome     = trim($_POST["nome"]);
    $email    = trim($_POST["email"]);
    $senha    = trim($_POST["senha"]);
    $cpf      = trim($_POST["cpf"]);
    $telefone = trim($_POST["telefone"]);
    $curso_id = $_POST["curso"] ?? null;
    $materias = isset($_POST["materias"]) ? $_POST["materias"] : [];
    $tipo     = "P"; ## Sempre será Professor

    // Debug
    error_log("=== CADASTRO PROFESSOR INICIADO ===");
    error_log("Nome: $nome");
    error_log("Curso ID: $curso_id");
    error_log("Matérias selecionadas: " . implode(', ', $materias));
    error_log("Total de matérias: " . count($materias));

    ## Formatar telefone e CPF (código existente)
    $telefone_formatado = preg_replace('/[^0-9]/', '', $telefone);
    if (strlen($telefone_formatado) === 11) {
        $telefone_formatado = "(" . substr($telefone_formatado, 0, 2) . ") " . 
                             substr($telefone_formatado, 2, 5) . "-" . 
                             substr($telefone_formatado, 7);
    }

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
        ## Gerar regex_user
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
        error_log("Regex gerado: $regex_user");

        ## verificar se e-mail ou CPF já existem
        $check = $conn->prepare("SELECT iden_user FROM usuario WHERE mail_user = ? OR codg_user = ?");
        $check->bind_param("ss", $email, $cpf_formatado);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            throw new Exception("E-mail ou CPF já cadastrados.");
        }
        $check->close();

        ## Verificar se o curso existe
        if ($curso_id) {
            $stmt_curso = $conn->prepare("SELECT iden_curs FROM curso WHERE iden_curs = ?");
            $stmt_curso->bind_param("i", $curso_id);
            $stmt_curso->execute();
            $stmt_curso->store_result();
            
            if ($stmt_curso->num_rows === 0) {
                throw new Exception("Curso selecionado não existe.");
            }
            $stmt_curso->close();
        }

        ## Hash da senha
        #$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        ## Inserir na tabela usuario
        $stmt_usuario = $conn->prepare("
            INSERT INTO usuario (regx_user, codg_user, nome_user, mail_user, senh_user, fone_user, flag_user)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt_usuario->bind_param("sssssss", $regex_user, $cpf_formatado, $nome, $email, $senha, $telefone_formatado, $tipo);
        
        if (!$stmt_usuario->execute()) {
            throw new Exception("Erro ao cadastrar usuário: " . $conn->error);
        }
        $stmt_usuario->close();
        error_log("✅ Usuário cadastrado na tabela usuario");

        ## Inserir na tabela professor_materia para cada matéria selecionada
        if (!empty($materias)) {
            error_log("Iniciando cadastro de " . count($materias) . " matérias...");
            
            // Verificar se as matérias pertencem ao curso selecionado
            if ($curso_id) {
                $placeholders = str_repeat('?,', count($materias) - 1) . '?';
                $sql_check_curso = "SELECT COUNT(*) as total 
                                   FROM curso_materia 
                                   WHERE iden_curs = ? AND iden_matr IN ($placeholders)";
                $stmt_check_curso = $conn->prepare($sql_check_curso);
                
                // Criar array de parâmetros: curso_id + array de matérias
                $params = array_merge([$curso_id], $materias);
                
                // Criar string de tipos: 'i' para curso_id + 'i' para cada matéria
                $types = str_repeat('i', count($params));
                
                $stmt_check_curso->bind_param($types, ...$params);
                $stmt_check_curso->execute();
                $result_check = $stmt_check_curso->get_result();
                $row_check = $result_check->fetch_assoc();
                $stmt_check_curso->close();

                error_log("Matérias encontradas no curso: " . $row_check['total'] . " de " . count($materias));

                if ($row_check['total'] != count($materias)) {
                    throw new Exception("Uma ou mais matérias selecionadas não pertencem ao curso.");
                }
            }

            $stmt_prof_mat = $conn->prepare("
                INSERT INTO professor_materia (regx_user, iden_matr)
                VALUES (?, ?)
            ");

            $materias_cadastradas = 0;
            foreach ($materias as $iden_matr) {
                error_log("Cadastrando matéria ID: $iden_matr para professor $regex_user");
                
                $stmt_prof_mat->bind_param("si", $regex_user, $iden_matr);
                if ($stmt_prof_mat->execute()) {
                    $materias_cadastradas++;
                    error_log("✅ Matéria $iden_matr cadastrada com sucesso");
                } else {
                    if ($conn->errno == 1062) { // 1062 = Duplicate entry
                        error_log("⚠️ Matéria $iden_matr já estava cadastrada (duplicata)");
                        // Ignora duplicatas e continua
                    } else {
                        throw new Exception("Erro ao vincular matéria $iden_matr: " . $conn->error);
                    }
                }
            }
            $stmt_prof_mat->close();
            error_log("✅ Total de matérias cadastradas: $materias_cadastradas");
        } else {
            error_log("⚠️ Nenhuma matéria selecionada para cadastrar");
        }
        
         ## Commit da transação
        $conn->commit();
        $mensagem = "Professor cadastrado com sucesso!";

    } catch (Exception $e) {
        ## Rollback em caso de erro
        $conn->rollback();
        $mensagem = $e->getMessage();
    }
}
?>