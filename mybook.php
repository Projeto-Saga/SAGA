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
    
        <div class="content fanimate rowalign">
            <!--<img src="img/moon_icon.png" id="icon">-->
            <div class="student-book clmalign">
                <form id="cicl_form" class="book-cicles" action="mybook.php" method="GET">
                    <input id="cicl" name="cicl" hidden="true" readonly value="<?php echo $cicl; ?>">
                    
                    <?php
                    $tick = isset($_GET['cicl']) ? $_GET['cicl'] : $cicl;
                    
                    for ($i = 1; $i <= 6; $i++)
                    {
                        $cls = ''; $pro = '';
                        
                        if      ($i == $tick) {$cls = "active";}
                        else if ($i  > $cicl) {$cls = "locked"; $pro = "disabled";}
                        
                    echo "<button class=\"book-cicles-item $cls\" $pro type=\"button\" onclick=\"cicl_slct($i);\">$i"."º CICLO</button>";
                    }?>
                </form>
                
                <hr class="separate">
    
                <div class="student-book-inner">
                    <div class="book-list" id="materias">
                        <h2 class="book-item">Matérias</h2>
                        <ul class="book-item-list">
                        <?php
                        $cmd2 = "SELECT matr.nome_matr
                                FROM materia AS matr INNER JOIN cursando AS crsn ON matr.iden_matr=crsn.iden_matr
                                WHERE crsn.regx_user=$rmat AND crsn.cicl_alun=$tick";
                        $rst2 = mysqli_query($conn, $cmd2);
                        
                        while ($b = mysqli_fetch_array($rst2))
                        {
                        echo "<li>$b[0]</li>";
                        }
                        ?>
                        </ul>
                    </div>

                    <div class="book-list" id="medias">
                        <h2 class="book-item">Médias</h2>
                        <ul class="book-item-list">
                        <?php
                        $cmd3 = "SELECT ntp1_crsn,ntp2_crsn,ntp3_crsn,nttt_crsn,iden_matr
                                FROM cursando WHERE regx_user=$rmat AND cicl_alun=$tick";
                        $rst3 = mysqli_query($conn, $cmd3);
                        
                        while ($c = mysqli_fetch_array($rst3))
                        {
                            $media = number_format($c[0]*0.35 + $c[1]*0.4 + $c[3]*0.25, 2, '.', '');
                            
                            $media < 6 ? $media = number_format($media + $c[2]*0.35, 2, '.', '') : null;
                                
                            echo "<li class=\"medias\">$media";
                            
                            echo "<button class=\"prev-degs-butn\" onclick=\"show_grds('grade'+$c[4])\">+</button><table id=\"grade$c[4]\" class=\"prev-degs stud-hidden\">
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
                    </div>
                    
                    <div class="book-list" id="faltas">
                        <h2 class="book-item">Faltas</h2>
                        <ul class="book-item-list">
                        <?php
                        $cmd4 = "SELECT falt_crsn FROM cursando WHERE regx_user=$rmat AND cicl_alun=$tick";
                        $rst4 = mysqli_query($conn, $cmd4);
                        
                        while ($d = mysqli_fetch_array($rst4))
                        {
                        echo "<li>$d[0]</li>";
                        }
                        ?>
                        </ul>
                    </div>
                    
                    <div class="book-list" id="situacao">
                        <h2 class="book-item">Situação</h2>
                        <ul class="book-item-list">
                        <?php
                        $cmd5 = "SELECT situ_crsn FROM cursando WHERE regx_user=$rmat AND cicl_alun=$tick";
                        $rst5 = mysqli_query($conn, $cmd5);
                        
                        while ($e = mysqli_fetch_array($rst5))
                        {
                        echo "<li>$e[0]</li>";
                        }
                        ?>
                        </ul>
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

<script type="text/javascript" src="js/notasfalts.js"></script>

<script>
    function cicl_slct(cicl)
    {
        document.getElementById('cicl').value = cicl;
        document.getElementById('cicl_form').submit();
    }
    
    function show_grds(iden)
    {
        var objt = document.getElementById(iden);
        
        objt.classList.contains('stud-hidden') ? objt.classList.remove('stud-hidden') : objt.classList.add('stud-hidden');
    }
</script>