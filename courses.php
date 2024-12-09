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
                    $cmd1 = "SELECT capa_csrl, nome_csrl, dura_csrl, desc_csrl FROM cursinho WHERE idcs_csrl=$idcs";
                    $rst1 = mysqli_query($conn, $cmd1);

                    while ($a = mysqli_fetch_array($rst1))
                    {
                    echo "
                    <a class=\"row livrbody\">
                        <img class=\"livrimge\" src=\"img/curso/$a[0].jpg\" style=\"height:190px; width:190px\">
                        <div class=\"col\" style=\"height:190px; justify-content:start\">
                            <h3 class=\"livrtitl\">$a[1]</h3>
                            <h6 class=\"livrauth\">$a[2] horas</h6>
                            <p class=\"livrtext\" style=\"font-size:13px\">$a[3]</p>
                        </div>
                    </a>";
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