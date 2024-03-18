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

        <div class="content fanimate">
            <div class="grid-box-1">
                <div class="box1">
                    <?php
                    $cmd1 = "SELECT * FROM eventos";
                    $rst1 = mysqli_query($conn, $cmd1);
                    
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
                    <div class="box3">
                        
                    </div>
                </div>
            </div>

            <!-- -->
            
            <!--<div class="box" style="margin-top:15px; width:auto;">
                <div class="rowalign">
                    <div class="clmalign">
                        <?php
                        $cmd2 = "SELECT * FROM eventos";
                        $rst2 = mysqli_query($conn, $cmd2);
                        
                        while ($b = mysqli_fetch_array($rst2))
                        {
                        ?>
                        <container class="feed" id="container">
                            <div class="post" id="<?php echo $b[0]; ?>">
                                <img src="img/slides/<?php echo $b[7]; ?>">
                                <h2><?php echo $b[2]; ?></h2>
                                <p><?php echo $b[5]; ?></p>
                                <button class="info" onclick="abrirJanela(<?php echo $b[0]; ?>)">info.</button>
                            </div>
                
                            <div class="janela" id="janela<?php echo $b[0]; ?>" style="display:none;">
                                <div class="janela-container">
                                    <img src="img/slides/<?php echo $b[7]; ?>">
                                    <button class="button" onclick="fecharJanela(<?php echo $b[0]; ?>)">
                                        <span class="X"></span>
                                        <span class="Y"></span>
                                        <div class="close">Close</div>
                                    </button>
                                    <h2><?php echo $b[2]; ?></h2>
                                    <p><?php echo $b[5]; ?></p>
                                    <div class="dados">
                                        <p>
                                            <b>Local</b><br>
                                            <?php echo $b[4]; ?><br><br>
                                            <b>Data</b><br>
                                            <?php echo date('d/m/Y', strtotime($b[3])); ?><br><br>
                                            <b>Duração</b><br>
                                            <?php echo $b[6].'hora(s)'; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </container>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>-->
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

<script src="js/homepage.js"></script>