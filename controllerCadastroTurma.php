<?php
## Arquivo: controllerCadastroTurma.php
## Será incluído pelo adminPanel.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitização dos dados recebidos
    $nome_turma = trim($_POST["nome_turma"]);
    $curso_id = intval($_POST["curso_id"]);
    $ano_turma = intval($_POST["ano_turma"]);
    $semestre_turma = intval($_POST["semestre_turma"]);
    $ativo_turma = 1;

    // Validar dados básicos
    if (empty($nome_turma) || empty($curso_id) || empty($ano_turma) || empty($semestre_turma)) {
        $mensagem = "Preencha todos os campos obrigatórios.";
        return;
    }

    // Iniciar transação
    $conn->begin_transaction();

    try {
        // Verificar duplicidade: uma turma não pode ter mesmo nome + ano + semestre
        $check = $conn->prepare("
            SELECT iden_turm 
            FROM turma 
            WHERE nome_turm = ? AND ano_turm = ? AND seme_turm = ?
        ");
        $check->bind_param("sii", $nome_turma, $ano_turma, $semestre_turma);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            throw new Exception("Turma já cadastrada para esse semestre/ano.");
        }

        // Inserir a turma
        $stmt = $conn->prepare("
            INSERT INTO turma (nome_turm, iden_curs, ano_turm, seme_turm, ativo_turm)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("siiii", $nome_turma, $curso_id, $ano_turma, $semestre_turma, $ativo_turma);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao cadastrar turma: " . $conn->error);
        }

        // Obter ID gerado
        $turma_id = $conn->insert_id;

        // Commit da transação
        $conn->commit();
        $mensagem = "Turma cadastrada com sucesso! ID: $turma_id";

    } catch (Exception $e) {
        // Rollback em caso de falha
        $conn->rollback();
        $mensagem = $e->getMessage();
    }
}
?>