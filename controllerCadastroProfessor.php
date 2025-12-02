<?php
## Este arquivo será incluído pelo adminPanel.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome     = trim($_POST["nome"]);
    $email    = trim($_POST["email"]);
    $senha    = trim($_POST["senha"]);
    $cpf      = trim($_POST["cpf"]);
    $telefone = trim($_POST["telefone"]);
    $curso_id = isset($_POST["curso"]) ? intval($_POST["curso"]) : null;
    $turma_id = isset($_POST["turma"]) ? intval($_POST["turma"]) : null; // NOVO: turma selecionada
    $materias = isset($_POST["materias"]) ? $_POST["materias"] : [];
    $tipo     = "P"; ## Sempre será Professor

    // Debug
    error_log("=== CADASTRO PROFESSOR INICIADO ===");
    error_log("Nome: $nome");
    error_log("Curso ID: $curso_id");
    error_log("Turma ID: " . ($turma_id ?? 'null'));
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

        ## Se uma turma foi selecionada, verificar se existe e (se curso_id informado) pertence ao curso
        if ($turma_id) {
            $stmt_check_turma = $conn->prepare("SELECT iden_turm, iden_curs FROM turma WHERE iden_turm = ?");
            $stmt_check_turma->bind_param("i", $turma_id);
            $stmt_check_turma->execute();
            $res_turma = $stmt_check_turma->get_result();
            if ($res_turma->num_rows === 0) {
                throw new Exception("Turma selecionada não existe.");
            }
            $row_turma = $res_turma->fetch_assoc();
            $turma_curso_id = intval($row_turma['iden_curs']);
            $stmt_check_turma->close();

            if ($curso_id && $turma_curso_id !== $curso_id) {
                throw new Exception("A turma selecionada não pertence ao curso escolhido.");
            }
            error_log("Turma validada: pertence ao curso $turma_curso_id");
        }

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

        ## Inserir na tabela professor_materia para cada matéria selecionada (mapa geral)
        $materias_cadastradas = 0;
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
                
                // bind_param aceita apenas variables, usar call_user_func_array
                $stmt_check_curso_params = [];
                $stmt_check_curso_params[] = $types;
                foreach ($params as $p) $stmt_check_curso_params[] = $p;
                // bind dinamico
                $tmp = [];
                foreach ($stmt_check_curso_params as $k => $v) $tmp[$k] = &$stmt_check_curso_params[$k];
                call_user_func_array([$stmt_check_curso, 'bind_param'], $tmp);
                
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

            foreach ($materias as $iden_matr) {
                error_log("Cadastrando matéria ID: $iden_matr para professor $regex_user (professor_materia)");
                
                $stmt_prof_mat->bind_param("si", $regex_user, $iden_matr);
                if ($stmt_prof_mat->execute()) {
                    $materias_cadastradas++;
                    error_log("✅ Matéria $iden_matr cadastrada com sucesso em professor_materia");
                } else {
                    if ($conn->errno == 1062) { // 1062 = Duplicate entry
                        error_log("⚠️ Matéria $iden_matr já estava cadastrada (duplicata) em professor_materia");
                        // Ignora duplicatas e continua
                    } else {
                        throw new Exception("Erro ao vincular matéria $iden_matr: " . $conn->error);
                    }
                }
            }
            $stmt_prof_mat->close();
            error_log("✅ Total de matérias cadastradas em professor_materia: $materias_cadastradas");
        } else {
            error_log("⚠️ Nenhuma matéria selecionada para cadastrar em professor_materia");
        }

        ## INSERIR também em turma_materia (vínculo turma + matéria + professor) se turma foi selecionada
        if ($turma_id && !empty($materias)) {
            error_log("Iniciando cadastro em turma_materia para turma $turma_id");
            $stmt_turm_mat = $conn->prepare("
                INSERT INTO turma_materia (iden_turm, iden_matr, regx_prof)
                VALUES (?, ?, ?)
            ");

            $turma_materias_cadastradas = 0;
            foreach ($materias as $iden_matr) {
                error_log("Cadastrando matéria ID: $iden_matr para turma $turma_id e professor $regex_user (turma_materia)");
                
                $stmt_turm_mat->bind_param("iis", $turma_id, $iden_matr, $regex_user);
                if ($stmt_turm_mat->execute()) {
                    $turma_materias_cadastradas++;
                    error_log("✅ turma_materia inserida: turma $turma_id - mat $iden_matr");
                } else {
                    if ($conn->errno == 1062) {
                        error_log("⚠️ vínculo turma_materia já existe (duplicata) para turma $turma_id mat $iden_matr");
                        // Ignorar duplicata
                    } else {
                        throw new Exception("Erro ao inserir turma_materia (turma $turma_id, mat $iden_matr): " . $conn->error);
                    }
                }
            }
            $stmt_turm_mat->close();
            error_log("✅ Total de turma_materia cadastradas: $turma_materias_cadastradas");
        } else {
            if (!$turma_id) error_log("⚠️ Nenhuma turma selecionada, pulando inserção em turma_materia");
            if (empty($materias)) error_log("⚠️ Nenhuma matéria selecionada, pulando inserção em turma_materia");
        }
        
         ## Commit da transação
        $conn->commit();
        $mensagem = "Professor cadastrado com sucesso!";

    } catch (Exception $e) {
        ## Rollback em caso de erro
        $conn->rollback();
        $mensagem = $e->getMessage();
        error_log("ERRO no cadastro de professor: " . $mensagem);
    }
}
?>
