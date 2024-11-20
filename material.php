<!DOCTYPE html>
<html>
    <head>
        <?php include('html/head.php'); ?>
    </head>
    <body>
        <?php
        if (isset($_SESSION['ativ']))
        {
            include('html/base.php');
        ?>

        <div class="container fanimate">
            <div class="box interface">
                <div class="livrsect">
                    <?php
                    $cmd1 = "SELECT imge_livr, nome_livr, autr_livr, desc_livr, link_livr FROM livro WHERE idcs_livr=$idcs";
                    $rst1 = mysqli_query($conn, $cmd1);

                    while ($a = mysqli_fetch_array($rst1))
                    {
                    echo "
                    <div class=\"row livrbody\">
                        <img class=\"livrimge\" src=\"img/livro/$a[0].jpg\">
                        <div class=\"col\">
                            <h3 class=\"livrtitl\">$a[1]</h3>
                            <h6 class=\"livrauth\">$a[2]</h6>
                            <p class=\"livrtext\">$a[3]</p>
                        </div>
                        <a class=\"livrlink\" href=\"$a[4]\" target=\"_blank\">▶</a>
                    </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <?php 
        }
        else
        {
            header('location:index.php');
        }
        ?>
    </body>
</html>