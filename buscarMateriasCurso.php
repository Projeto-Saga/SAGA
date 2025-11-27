<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "saga_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro na conexão com o banco']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $curso_id = intval($_GET['curso_id'] ?? 0);
    
    if ($curso_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID do curso inválido']);
        exit;
    }

    // Buscar matérias do curso (todas os semestres)
    $sql = "SELECT DISTINCT m.iden_matr, m.nome_matr, m.abrv_matr 
            FROM materia m 
            INNER JOIN curso_materia cm ON m.iden_matr = cm.iden_matr 
            WHERE cm.iden_curs = ? 
            ORDER BY m.nome_matr";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $curso_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $materias = [];
    while ($row = $result->fetch_assoc()) {
        $materias[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    echo json_encode([
        'success' => true,
        'materias' => $materias,
        'total' => count($materias)
    ]);
    
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>