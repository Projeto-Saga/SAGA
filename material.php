<!DOCTYPE html>
<html>
<head>
    <?php include('html/head.php'); ?>
</head>
<body>
<?php
if (isset($_SESSION['ativ'])) {
    include('html/base.php');

    // Garantir que $idcs exista
    $idcs = isset($idcs) ? (int)$idcs : 0;

    if ($idcs > 0) {
        $cmd1 = "SELECT imge_livr, nome_livr, autr_livr, desc_livr, link_livr 
                 FROM livro 
                 WHERE idcs_livr = $idcs";
        $rst1 = mysqli_query($conn, $cmd1);
    } else {
        $rst1 = false;
    }
?>
<div class="container fanimate">
    <div class="box interface">
        <div class="livrsect">
            <?php
            if ($rst1 && mysqli_num_rows($rst1) > 0) {
                while ($a = mysqli_fetch_assoc($rst1)) {
                    echo "
                    <div class=\"row livrbody\">
                        <img class=\"livrimge\" src=\"img/livro/{$a['imge_livr']}.jpg\">
                        <div class=\"col\">
                            <h3 class=\"livrtitl\">{$a['nome_livr']}</h3>
                            <h6 class=\"livrauth\">{$a['autr_livr']}</h6>
                            <p class=\"livrtext\">{$a['desc_livr']}</p>
                        </div>
                        <a class=\"livrlink\" href=\"{$a['link_livr']}\" target=\"_blank\">▶</a>
                    </div>";
                }
            } else {
                echo "<p>Nenhum material disponível para este usuário.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php
} else {
    header('location:index.php');
    exit;
}
?>
</body>
</html>
