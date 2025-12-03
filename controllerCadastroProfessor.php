<?php
## Este arquivo será incluído pelo adminPanel.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome     = trim($_POST["nome"]);
    $email    = trim($_POST["email"]);
    $senha    = trim($_POST["senha"]);
    $cpf      = trim($_POST["cpf"]);
    $telefone = trim($_POST["telefone"]);
    $curso_id = isset($_POST["curso"]) ? intval($_POST["curso"]) : null;

    // ✔ RECEBE AGORA MULTIPLAS TURMAS
    $turmas   = isset($_POST["turmas"]) ? $_POST["turmas"] : [];

    // ✔ Mantém as matérias do curso
    $materias = isset($_POST["materias"]) ? $_POST["materias"] : [];

    $tipo     = "P";

    /* ======== FORMATAR CPF E TELEFONE ======== */

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

    $conn->begin_transaction();

    try {

        /* ==========================
           GERAR REGX_USER
        ========================== */

        $ano_atual = date('Y');

        $sql_ultimo_regex = "
            SELECT MAX(CAST(regx_user AS UNSIGNED)) as max_regex
            FROM usuario
            WHERE regx_user LIKE '$ano_atual%'
        ";

        $result_ultimo = $conn->query($sql_ultimo_regex);

        if ($result_ultimo && $result_ultimo->num_rows > 0) {
            $row = $result_ultimo->fetch_assoc();
            $ultimo_regex = $row['max_regex'];
            $sequencial = $ultimo_regex ? $ultimo_regex + 1 : $ano_atual . "000001";
        } else {
            $sequencial = $ano_atual . "000001";
        }

        $regex_user = strval($sequencial);


        /* ==========================
           VERIFICAR E-MAIL / CPF
        ========================== */

        $check = $conn->prepare("
            SELECT iden_user FROM usuario WHERE mail_user = ? OR codg_user = ?
        ");
        $check->bind_param("ss", $email, $cpf_formatado);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            throw new Exception("E-mail ou CPF já cadastrados.");
        }
        $check->close();


        /* ==========================
           INSERIR USUÁRIO
        ========================== */

        $stmt_usuario = $conn->prepare("
            INSERT INTO usuario
            (regx_user, codg_user, nome_user, mail_user, senh_user, fone_user, flag_user)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt_usuario->bind_param(
            "sssssss",
            $regex_user,
            $cpf_formatado,
            $nome,
            $email,
            $senha,
            $telefone_formatado,
            $tipo
        );
        $stmt_usuario->execute();
        $stmt_usuario->close();


        /* ==========================
           INSERIR professor_materia
        ========================== */

        if (!empty($materias)) {

            $stmt_pm = $conn->prepare("
                INSERT INTO professor_materia (regx_user, iden_matr)
                VALUES (?, ?)
            ");

            foreach ($materias as $m) {
                $stmt_pm->bind_param("si", $regex_user, $m);
                $stmt_pm->execute();
            }

            $stmt_pm->close();
        }


        /* ==========================
           INSERIR turma_materia
        ========================== */

        if (!empty($turmas) && !empty($materias)) {

            $stmt_tm = $conn->prepare("
                INSERT INTO turma_materia (iden_turm, iden_matr, regx_prof)
                VALUES (?, ?, ?)
            ");

            foreach ($turmas as $t) {
                foreach ($materias as $m) {
                    $stmt_tm->bind_param("iis", $t, $m, $regex_user);
                    $stmt_tm->execute();
                }
            }

            $stmt_tm->close();
        }

        $conn->commit();
        $mensagem = "Professor cadastrado com sucesso!";

    } catch (Exception $e) {

        $conn->rollback();
        $mensagem = "ERRO: " . $e->getMessage();
    }
}
?>
