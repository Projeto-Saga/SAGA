<?php
## Este arquivo será incluído pelo adminPanel.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome     = trim($_POST["nome"]);
    $email    = trim($_POST["email"]);
    $senha    = trim($_POST["senha"]);
    $cpf      = trim($_POST["cpf"]);
    $telefone = trim($_POST["telefone"]);
    $tipo     = "S"; ## Sempre será Secretaria

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

        ## verificar se e-mail ou CPF já existem
        $check = $conn->prepare("SELECT iden_user FROM usuario WHERE mail_user = ? OR codg_user = ?");
        $check->bind_param("ss", $email, $cpf_formatado);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            throw new Exception("E-mail ou CPF já cadastrados.");
        }
        $check->close();

        ## Hash da senha
        #$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        ## Inserir na tabela usuario
        $stmt_usuario = $conn->prepare("
            INSERT INTO usuario (regx_user, codg_user, nome_user, mail_user, senh_user, fone_user, flag_user)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt_usuario->bind_param("sssssss", $regex_user, $cpf_formatado, $nome, $email, $senha, $telefone_formatado, $tipo);
        
        if (!$stmt_usuario->execute()) {
            throw new Exception("Erro ao cadastrar secretário: " . $conn->error);
        }
        $stmt_usuario->close();

        ## Commit da transação
        $conn->commit();
        $mensagem = "Secretário cadastrado com sucesso!";

    } catch (Exception $e) {
        ## Rollback em caso de erro
        $conn->rollback();
        echo "<script>Popup.error('" . addslashes($e->getMessage()) . "');</script>";
    }
}
?>