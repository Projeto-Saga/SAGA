<!DOCTYPE html>
<html>
<head>
    <?php include('html/head.php'); ?>
</head>
<body>
<?php
if (isset($_SESSION['ativ'])) {
    include('html/base.php');

    $cicl = isset($cicl) ? (int)$cicl : 1; // ciclo padrão
    $rmat = isset($rmat) ? mysqli_real_escape_string($conn, $rmat) : '';

    // Seleção do ciclo
    $tick = isset($_GET['cicl']) ? (int)$_GET['cicl'] : $cicl;
?>
<div class="container fanimate">
    <form id="studbook" class="box interface" method="GET" action="mybook.php">
        <input id="cicl" name="cicl" hidden readonly value="<?php echo $tick; ?>">

        <div class="clmalign">
            <div class="head">
                <h1 style="font-family:Poppins; font-size:28px; font-weight:700; text-align:center; margin:10px 0; color:var(--red-base);">
                    Minhas Disciplinas
                </h1>
            </div>
            
            <hr class="separate">

            <div class="body">
                <section>
                    <h2>Disciplinas</h2>
                    <ul>
                    <?php
                    if (!empty($rmat)) {
                        $cmd2 = "SELECT matr.nome_matr
                                 FROM materia AS matr
                                 INNER JOIN cursando AS crsn ON matr.iden_matr=crsn.iden_matr
                                 WHERE crsn.regx_user='$rmat' AND crsn.cicl_alun=$tick
                                 ORDER BY matr.dias_matr, matr.hora_matr";
                        $rst2 = mysqli_query($conn, $cmd2);

                        while ($b = mysqli_fetch_assoc($rst2)) {
                            echo "<li>{$b['nome_matr']}</li>";
                        }
                    } else {
                        echo "<li>Não foi possível carregar matérias.</li>";
                    }
                    ?>
                    </ul>
                </section>

                <section>
                    <h2>Turma</h2>
                    <ul>
                    <?php
                    if (!empty($rmat)) {
                        $cmd3 = "SELECT crsn.ntp1_crsn, crsn.ntp2_crsn, crsn.ntp3_crsn, crsn.nttt_crsn, matr.iden_matr
                                 FROM cursando AS crsn
                                 INNER JOIN materia AS matr ON crsn.iden_matr=matr.iden_matr
                                 WHERE crsn.regx_user='$rmat' AND crsn.cicl_alun=$tick
                                 ORDER BY matr.dias_matr, matr.hora_matr";
                        $rst3 = mysqli_query($conn, $cmd3);

                        while ($c = mysqli_fetch_assoc($rst3)) {
                            $media = number_format($c['ntp1_crsn']*0.35 + $c['ntp2_crsn']*0.4 + $c['nttt_crsn']*0.25, 2, '.', '');
                            if ($media < 6) {
                                $media = number_format($media + $c['ntp3_crsn']*0.35, 2, '.', '');
                            }

                            echo "<li>
                                <p class=\"media\">$media</p>

                                <button type=\"button\" onmouseover=\"show_grds($('#grade{$c['iden_matr']}'))\" onmouseout=\"show_grds($('#grade{$c['iden_matr']}'))\"></button>

                                <table id=\"grade{$c['iden_matr']}\" class=\"stud-hidden\">
                                    <tr>
                                        <th>P1</th>
                                        <th>P2</th>
                                        <th>P3</th>
                                        <th>TT</th>
                                    </tr>
                                    <tr>
                                        <td>{$c['ntp1_crsn']}</td>
                                        <td>{$c['ntp2_crsn']}</td>
                                        <td>{$c['ntp3_crsn']}</td>
                                        <td>{$c['nttt_crsn']}</td>
                                    </tr>
                                </table>
                            </li>";
                        }
                    } else {
                        echo "<li>Não foi possível carregar as turmas.</li>";
                    }
                    ?>
                    </ul>
                </section>

                <section>
                    <h2>Total de alunos</h2>
                    <ul>
                    <?php
                    if (!empty($rmat)) {
                        $cmd4 = "SELECT crsn.falt_crsn
                                 FROM cursando AS crsn
                                 INNER JOIN materia AS matr ON crsn.iden_matr=matr.iden_matr
                                 WHERE crsn.regx_user='$rmat' AND crsn.cicl_alun=$tick
                                 ORDER BY matr.dias_matr, matr.hora_matr";
                        $rst4 = mysqli_query($conn, $cmd4);

                        while ($d = mysqli_fetch_assoc($rst4)) {
                            echo "<li>{$d['falt_crsn']}</li>";
                        }
                    } else {
                        echo "<li>Não foi possível carregar o total de alunos.</li>";
                    }
                    ?>
                    </ul>
                </section>

                <section>
                    <h2>Ações</h2>
                    <ul>
                    <?php
                    if (!empty($rmat)) {
                        $cmd4 = "SELECT crsn.falt_crsn
                                 FROM cursando AS crsn
                                 INNER JOIN materia AS matr ON crsn.iden_matr=matr.iden_matr
                                 WHERE crsn.regx_user='$rmat' AND crsn.cicl_alun=$tick
                                 ORDER BY matr.dias_matr, matr.hora_matr";
                        $rst4 = mysqli_query($conn, $cmd4);

                        while ($d = mysqli_fetch_assoc($rst4)) {
                            echo "
                            <li>
                                <div class='acoes-botoes'>
                                    <button class='btn btn-faltas'>✔ Faltas</button>
                                    <button class='btn btn-notas'>📝 Notas</button>
                                    <button class='btn btn-turma'>👁 Ver turma</button>
                                </div>
                            </li>";
                        }
                    } else {
                        echo "<li>Não foi possível carregar as ações.</li>";
                    }
                    ?>
                    </ul>
                </section>
            </div>
        </div>
    </form>
</div>

<?php
} else {
    header('location:index.php');
    exit;
}
?>
</body>
</html>
<script src="js/mybook.js"></script>
