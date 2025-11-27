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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_base = trim($_POST['email_base'] ?? '');
    
    if (empty($email_base)) {
        echo json_encode(['success' => false, 'message' => 'Email base não fornecido']);
        exit;
    }

    $domain = '@maltec.sp.gov.br';
    
    // Busca TODOS os emails que começam com o email_base (com ou sem números)
    $pattern = $email_base . '%' . $domain;
    
    $stmt = $conn->prepare("SELECT mail_user FROM usuario WHERE mail_user LIKE ? ORDER BY mail_user");
    $stmt->bind_param("s", $pattern);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $emails_existentes = [];
    while ($row = $result->fetch_assoc()) {
        $emails_existentes[] = $row['mail_user'];
    }
    
    $stmt->close();
    
    // Se não existe nenhum email com esse padrão, usa o base sem número
    if (empty($emails_existentes)) {
        $email_final = $email_base . $domain;
    } else {
        // Extrai os números dos emails existentes
        $numeros_existentes = [];
        
        foreach ($emails_existentes as $email_existente) {
            // Remove o domínio e o email base para extrair o número
            $parte_numerica = str_replace([$email_base, $domain], '', $email_existente);
            
            if (is_numeric($parte_numerica)) {
                $numeros_existentes[] = (int)$parte_numerica;
            } else if ($parte_numerica === '') {
                // Email sem número (base pura)
                $numeros_existentes[] = 1;
            }
        }
        
        // Encontra o próximo número disponível
        $proximo_numero = 1;
        if (!empty($numeros_existentes)) {
            // Se existe email sem número (representado como 1), começa do 2
            if (in_array(1, $numeros_existentes)) {
                $proximo_numero = 2;
            }
            
            // Encontra o próximo número sequencial disponível
            while (in_array($proximo_numero, $numeros_existentes)) {
                $proximo_numero++;
            }
        }
        
        // Se o próximo número for 1, usa sem número, senão usa com número
        if ($proximo_numero === 1) {
            $email_final = $email_base . $domain;
        } else {
            $email_final = $email_base . $proximo_numero . $domain;
        }
    }
    
    $conn->close();
    
    echo json_encode([
        'success' => true,
        'email_disponivel' => $email_final,
        'email_base' => $email_base,
        'emails_existentes' => $emails_existentes // Para debug
    ]);
    
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>