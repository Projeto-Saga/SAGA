<!DOCTYPE html>
<html>
    <head>
        <?php include('html/head.php'); ?>
    </head>
    <body>
        <?php
        if (isset($_SESSION['ativ']))
        {
            if ($_SESSION['ativ'] != 3)
            {
                include('html/base.php');
            }
            else
            {
                include('html/base_prof.php');
            }
        ?>

        <div class="container fanimate">
            <div class="grid-box-1">
                <div class="box1">
                    <?php
                    $rst1 = mysqli_query($conn, "SELECT * FROM evento");
                    
                    if (mysqli_affected_rows($conn) > 0)
                    {
                        while ($a = mysqli_fetch_array($rst1))
                        {
                    echo "<div id=\"post_$a[0]\" class=\"post\">
                        <img src=\"img/slides/$a[7]\">
                        <h2>$a[2]</h2>
                        <p>$a[5]</p>
                        <button class=\"info\" onclick=\"abrirJanela('post_$a[0]')\">info.</button>
                    </div>";
                        }
                    }
                    else
                    {
                        echo "Nenhum Evento Disponível";
                    }
                    ?>
                </div>
                <div class="grid-box-2">
                    <div class="box2">
                        <div class="slider">
                            <div class="slides">
                                <input type="radio" name="radio-btn" id="radio1">
                                <input type="radio" name="radio-btn" id="radio2">
                                <input type="radio" name="radio-btn" id="radio3">
                    
                                <div class="slide first">
                                    <img src="img/slides/slide-1.png">
                                </div>
                    
                                <div class="slide second">
                                    <img src="img/slides/slide-2.png">
                                </div>
                    
                                <div class="slide third">
                                    <img src="img/slides/slide-3.png">
                                </div>
                            </div>
                    
                            <div class="manual-navigation">
                                <label for="radio1" class="manual-btn"></label>
                                <label for="radio2" class="manual-btn"></label>
                                <label for="radio3" class="manual-btn"></label>
                            </div>
                        </div>
                    </div>
                    <div class="grid-box-3">
                        <div class="box3">
                            <h3 style="margin:0; text-align:center; font-weight:800">Título Exemplo</h3>
                            <p style="margin:0; text-align:justify; font-weight:500">aaaaaaaaaaaaf.</p>
                        </div>
                        <div class="box3">
                            <h3 style="margin:0; text-align:center; font-weight:800">Título Exemplo</h3>
                            <p style="margin:0; text-align:justify; font-weight:500">bbb.</p>
                        </div>
                    </div>
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

<script src="js/lobby.js"></script>