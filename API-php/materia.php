<?php
include("../php/connect.php");
include("response.php");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // /api/materia.php?action=find_all
        if (isset($_GET['action']) && $_GET['action'] === 'find_all') {
            $sql = "SELECT * FROM materia";
            $result = mysqli_query($conn, $sql);
            $materias = mysqli_fetch_all($result, MYSQLI_ASSOC);
            sendResponse($materias);
        }
        break;

    case 'POST':
        // /api/materia.php?action=insert
        if (isset($_GET['action']) && $_GET['action'] === 'insert') {
            $data = json_decode(file_get_contents("php://input"), true);

            $sql = "INSERT INTO materia (nome_matr, chor_matr, abrv_matr, ccpv_matr, dias_matr, hora_matr)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sisiss",
                $data['nome_matr'], $data['chor_matr'], $data['abrv_matr'],
                $data['ccpv_matr'], $data['dias_matr'], $data['hora_matr']
            );

            if (mysqli_stmt_execute($stmt)) {
                sendResponse(["message" => "Matéria inserida com sucesso"]);
            } else {
                sendResponse(["error" => "Erro ao inserir matéria"], 500);
            }
        }
        break;

    case 'PUT':
        // /api/materia.php?action=update&id=1
        if (isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = json_decode(file_get_contents("php://input"), true);

            $sql = "UPDATE materia SET 
                        nome_matr = ?, chor_matr = ?, abrv_matr = ?, 
                        ccpv_matr = ?, dias_matr = ?, hora_matr = ?
                    WHERE iden_matr = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sisissi",
                $data['nome_matr'], $data['chor_matr'], $data['abrv_matr'],
                $data['ccpv_matr'], $data['dias_matr'], $data['hora_matr'], $id
            );

            if (mysqli_stmt_execute($stmt)) {
                sendResponse(["message" => "Matéria atualizada"]);
            } else {
                sendResponse(["error" => "Falha ao atualizar"], 500);
            }
        }
        break;

    default:
        sendResponse(["error" => "Método não suportado"], 405);
}
?>
