<?php
// Conexão com o banco de dados
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $conn = mysqli_connect('localhost', 'root', '', 'saga_db');
} else {
    $conn = mysqli_connect('sql209.infinityfree.com', 'if0_40039126', 'projetosaga123', 'if0_40039126_saga_db');
}

// Verifica se a conexão funcionou
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Define charset
mysqli_set_charset($conn, "utf8");
?>
