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
            <form id="studbook" class="box interface" method="GET" action="mybook.php">
                <input id="cicl" name="cicl" hidden readonly value="<?php echo $cicl ?>">

                <div class="clmalign">
                    <div class="head">
                        <?php
                        $tick = isset($_GET['cicl']) ? $_GET['cicl'] : $cicl;
                        
                        for ($i = 1; $i <= 6; $i++)
                        {
                            $cls = ''; $pro = '';
                            
                            if      ($i == $tick) {$cls = "active";}
                            else if ($i  > $cicl) {$cls = "locked"; $pro = "disabled";}
                            
                        echo "<button class=\"$cls\" $pro type=\"submit\" onclick=\"cicl_slct($i);\">$i"."º CICLO</button>";
                        }?>
                    </div>
                    
                    <hr class="separate">
        
                    <div class="body">
                        <section>
                            <h2>Matérias</h2>
                            <ul>
                            <?php
                            $cmd2 = "SELECT matr.nome_matr
                                     FROM materia AS matr
                                     INNER JOIN cursando AS crsn ON matr.iden_matr=crsn.iden_matr
                                     WHERE crsn.regx_user=$rmat AND crsn.cicl_alun=$tick
                                     ORDER BY matr.dias_matr, matr.hora_matr";
                            $rst2 = mysqli_query($conn, $cmd2);
                            
                            while ($b = mysqli_fetch_array($rst2))
                            {
                            echo "<li>$b[0]</li>";
                            }
                            ?>
                            </ul>
                        </section>

                        <section>
                            <h2>Notas</h2>
                            <ul>
                            <?php
                            $cmd3 = "SELECT ntp1_crsn,ntp2_crsn,ntp3_crsn,nttt_crsn,matr.iden_matr
                                     FROM cursando AS crsn
                                     INNER JOIN materia AS matr ON crsn.iden_matr=matr.iden_matr
                                     WHERE regx_user=$rmat AND cicl_alun=$tick
                                     ORDER BY matr.dias_matr, matr.hora_matr";
                            $rst3 = mysqli_query($conn, $cmd3);
                            
                            while ($c = mysqli_fetch_array($rst3))
                            {
                                $media = number_format($c[0]*0.35 + $c[1]*0.4 + $c[3]*0.25, 2, '.', '');
                                
                                $media < 6 ? $media = number_format($media + $c[2]*0.35, 2, '.', '') : null;
                                    
                            echo "<li>
                                <p class=\"media\">$media</p>

                                <button type=\"button\" onmouseover=\"show_grds($('#grade$c[4]'))\" onmouseout=\"show_grds($('#grade$c[4]'))\"></button>

                                <table id=\"grade$c[4]\" class=\"stud-hidden\">
                                    <tr>
                                        <th>P1</th>
                                        <th>P2</th>
                                        <th>P3</th>
                                        <th>TT</th>
                                    </tr>
                                    <tr>
                                        <td>$c[0]</td>
                                        <td>$c[1]</td>
                                        <td>$c[2]</td>
                                        <td>$c[3]</td>
                                    </tr>
                                </table>
                            </li>";
                            }
                            ?>
                            </ul>
                            </ul>
                        </section>
                        
                        <section>
                            <h2>Faltas</h2>
                            <ul>
                            <?php
                            $cmd4 = "SELECT crsn.falt_crsn
                                     FROM cursando AS crsn INNER JOIN materia AS matr ON crsn.iden_matr=matr.iden_matr
                                     WHERE crsn.regx_user=$rmat AND crsn.cicl_alun=$tick
                                     ORDER BY matr.dias_matr, matr.hora_matr";
                            $rst4 = mysqli_query($conn, $cmd4);
                            
                            while ($d = mysqli_fetch_array($rst4))
                            {
                            echo "<li>$d[0]</li>";
                            }
                            ?>
                            </ul>
                        </section>
                    </div>
                </div>
            </form>
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

<script src="js/mybook.js"></script>