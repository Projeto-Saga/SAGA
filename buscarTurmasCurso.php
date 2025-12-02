<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "saga_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erro na conexão"]);
    exit;
}

$curso_id = intval($_GET['curso_id']);

$sql = "SELECT iden_turm, nome_turm, ano_turm, seme_turm 
        FROM turma 
        WHERE iden_curs = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $curso_id);
$stmt->execute();
$result = $stmt->get_result();

$turmas = [];
while ($row = $result->fetch_assoc()) {
    $turmas[] = $row;
}

echo json_encode([
    "success" => true,
    "turmas" => $turmas
]);