<?php
## Este arquivo será incluído pelo adminPanel.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome_materia = trim($_POST["nome_materia"]);
    $carga_horaria = intval($_POST["carga_horaria"]);
    $abreviatura = trim($_POST["abreviatura"]);
    $codigo_curso_periodo_versao = intval($_POST["codigo_curso_periodo_versao"]);
    $curso_id = intval($_POST["curso_id"]);
    $dias_semana = isset($_POST["dias_semana"]) ? implode(',', $_POST["dias_semana"]) : '';
    
    // Lógica para hora_matr baseada na carga horária
    if ($carga_horaria == 40) {
        $horario_aula = ''; // Vazio para 40h
    } elseif ($carga_horaria == 80) {
        $horario_aula = 'A'; // 'A' para 80h (será definido depois na turma)
    } else {
        $horario_aula = ''; // Padrão vazio para outras cargas
    }

    // Iniciar transação para garantir que ambos os inserts funcionem
    $conn->begin_transaction();

    try {
        // Verificar se matéria já existe
        $check = $conn->prepare("SELECT iden_matr FROM materia WHERE nome_matr = ? OR abrv_matr = ?");
        $check->bind_param("ss", $nome_materia, $abreviatura);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            throw new Exception("Matéria ou abreviatura já cadastradas.");
        }

        // Inserir na tabela materia
        $stmt = $conn->prepare("
            INSERT INTO materia (nome_matr, chor_matr, abrv_matr, ccpv_matr, dias_matr, hora_matr)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("sissss", $nome_materia, $carga_horaria, $abreviatura, $codigo_curso_periodo_versao, $dias_semana, $horario_aula);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao cadastrar matéria: " . $conn->error);
        }

        $materia_id = $conn->insert_id;

        // Inserir na tabela curso_materia para relacionar com o curso
        $stmt_relacao = $conn->prepare("
            INSERT INTO curso_materia (iden_curs, iden_matr, ciclo_semestre)
            VALUES (?, ?, ?)
        ");
        $stmt_relacao->bind_param("iii", $curso_id, $materia_id, $codigo_curso_periodo_versao);

        if (!$stmt_relacao->execute()) {
            throw new Exception("Erro ao relacionar matéria com curso: " . $conn->error);
        }

        // Commit da transação
        $conn->commit();
        $mensagem = "Matéria cadastrada com sucesso! ID: ";

    } catch (Exception $e) {
        // Rollback em caso de erro
        $conn->rollback();
        $mensagem = $e->getMessage();
    }
}
?>