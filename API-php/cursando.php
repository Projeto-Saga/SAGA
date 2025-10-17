<?php
include("../php/connect.php");
include("response.php");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // /api/cursando.php?action=find_one&id=123
        if (isset($_GET['action']) && $_GET['action'] === 'find_one' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM cursando WHERE regx_user = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (count($rows) > 0) {
                sendResponse($rows);
            } else {
                sendResponse(["error" => "Aluno não encontrado com RA: $id"], 404);
            }
        }
        break;

    case 'POST':
        // /api/cursando.php?action=insert
        if (isset($_GET['action']) && $_GET['action'] === 'insert') {
            $data = json_decode(file_get_contents("php://input"), true);

            $sql = "INSERT INTO cursando 
                    (regx_user, iden_matr, ntp1_crsn, ntp2_crsn, ntp3_crsn, nttt_crsn, falt_crsn, cicl_alun, _ano_crsn, _sem_crsn, situ_crsn)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iiddddissss",
                $data['regx_user'], $data['iden_matr'],
                $data['ntp1_crsn'], $data['ntp2_crsn'], $data['ntp3_crsn'],
                $data['nttt_crsn'], $data['falt_crsn'],
                $data['cicl_alun'], $data['_ano_crsn'], $data['_sem_crsn'], $data['situ_crsn']
            );

            if (mysqli_stmt_execute($stmt)) {
                sendResponse(["message" => "Cursando inserido com sucesso"]);
            } else {
                sendResponse(["error" => "Erro ao inserir cursando"], 500);
            }
        }
        break;

    default:
        sendResponse(["error" => "Método não suportado"], 405);
}
?>
