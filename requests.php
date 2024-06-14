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
            <div class="box">
                <!-- índice de abas -->
                <div class="reqs-docs">
                    <div id="rdit_1" class="reqs-docs-item" onclick="form(1);">
                        <div class="reqs-docs-item-head">Passe Escolar</div>
                    </div>
                    <div id="rdit_2" class="reqs-docs-item" onclick="form(2);">
                        <div class="reqs-docs-item-head">Aproveitamento</div>
                    </div>
                    <div id="rdit_3" class="reqs-docs-item" onclick="form(3);">
                        <div class="reqs-docs-item-head">Rematrícula</div>
                    </div>
                    <div id="rdit_4" class="reqs-docs-item" onclick="form(4);">
                        <div class="reqs-docs-item-head">Atestados</div>
                    </div>
                    <div id="rdit_5" class="reqs-docs-item" onclick="form(5);">
                        <div class="reqs-docs-item-head">Papéis de Estágio</div>
                    </div>
                    <div id="rdit_6" class="reqs-docs-item" onclick="form(6);">
                        <div class="reqs-docs-item-head">Histórico Escolar</div>
                    </div>
                </div>

                <!-- corpo das abas -->
                <!-- passe escolar -->
                <div id="form_1" class="reqs-form rowalign">
                    <div class="reqs-form-prev">
                        <h3 style="margin:0;">Passe Escolar</h3>
                        <hr>
                        <p style="margin:0;" class="reqs-form-prev-text">O aluno regularmente matriculado deverá solicitar a inclusão dos seus dados junto à empresa de transportes preenchendo o formulário de solicitação ao lado.</p>
                    </div>
                    <form action="php/request.php" method="POST" enctype="multipart/form-data" class="reqs-form-form clmalign" style="justify-content:unset;">
                        <input id="file1" name="anex_solc" type="file" hidden="true">
                        <input name="iden_solc" type="text" value="1" hidden="true">
                        <input name="tipo_solc" type="text" value="Passe Escolar" hidden="true">
                        
                        <label class="reqs-form-labl">Comprovante de Residência</label>
                        <input id="file_show1" class="reqs-form-inpt" type="button" value="Clique Para Subir Arquivo" onclick="file(1);">
                        <br>
                        <label class="reqs-form-labl">Linhas Disponíveis</label>
                        <select name="trns_solc" class="reqs-form-inpt">
                           <option>Linha A-09</option>
                           <option>Linha A-11</option>
                           <option>Linha A-15</option>
                           <option>Linha B-01</option>
                           <option>Linha B-19</option>
                           <option>Linha C-12</option>
                           <option>Linha C-13</option>
                           <option>Linha C-26</option>
                        </select>
                        <br>
                        <input class="reqs-form-butn" type="submit" value="Concluído">
                    </form>
                </div>
                <!-- aproveitamento -->
                <div id="form_2" class="reqs-form rowalign stud-hidden">
                    <div class="reqs-form-prev">
                        <h3 style="margin:0;">Aproveitamento de Estudos</h3>
                        <hr>
                        <p style="margin:0;" class="reqs-form-prev-text">O aluno ingressante que já cursou outra instituição de ensino superior pode solicitar aproveitamento de estudos para eliminação de disciplinas.<br>O mesmo terá que solicitar somente no período de matrícula atendendo ao calendário acadêmico.<br>Para tal o aluno(a) deverá encaminhas os documentos informados ao lado:</p>
                    </div>
                    <form action="php/request.php" method="POST" enctype="multipart/form-data" class="reqs-form-form clmalign" style="justify-content:unset;">
                        <input id="file2" name="anex_solc" type="file" hidden="true">
                        <input name="iden_solc" type="text" value="2" hidden="true">
                        <input name="tipo_solc" type="text" value="Aproveitamento" hidden="true">
                        
                        <label class="reqs-form-labl">Histórico Escolar (cópia)</label>
                        <input id="file_show2" class="reqs-form-inpt" type="button" value="Clique Para Subir Arquivo" onclick="file(2);">
                        <br>
                        <label name="mtap_solc" class="reqs-form-labl">Próximas Disciplinas</label>
                        <?php
                        $cmd4 = "SELECT iden_matr,nome_matr FROM materia WHERE ccpv_matr='".($cicl+1)."'";
                        $rst4 = mysqli_query($conn, $cmd4);
                        
                        while ($d = mysqli_fetch_array($rst4))
                        {
                        echo "<div onclick=\"tick($d[0]);\" class=\"rowalign\" style=\"justify-content:unset\">
                            <input id=\"aprv_mat$d[0]\" name=\"mtap_solc[]\" class=\"reqs-form-optn\" type=\"checkbox\" value=\"$d[0]\">
                            <label>$d[1]</label>
                        </div>";
                        }
                        ?>
                        <br>
                        <input class="reqs-form-butn" type="submit" value="Concluído">
                    </form>
                </div>
                <!-- rematrícula -->
                <div id="form_3" class="reqs-form rowalign stud-hidden">
                    <div class="reqs-form-prev">
                        <h3 style="margin:0;">Rematrícula</h3>
                        <hr>
                        <p style="margin:0;" class="reqs-form-prev-text">Valide a continuidade dos seus estudos conosco, só assim a sua permanência na instituição é garantida.</p>
                    </div>
                    <form class="reqs-form-form clmalign" style="justify-content:unset">
                        <?php print_r($main->mtc_callApi($cicl+1)); ?>
                    </form>
                </div>
                <!-- atestados -->
                <div id="form_4" class="reqs-form rowalign stud-hidden">
                    <div class="reqs-form-prev">
                        <h3 style="margin:0;">Atestado</h3>
                        <hr>
                        <p style="margin:0;" class="reqs-form-prev-text">Preencha o formulário ao lado com todas as informações devidas para que suas ausências sejam justificadas.</p>
                    </div>
                    <form action="php/request.php" method="POST" enctype="multipart/form-data" class="reqs-form-form clmalign" style="justify-content:unset;">
                        <input id="file4" name="anex_solc" type="file" hidden="true">
                        <input name="iden_solc" type="text" value="4" hidden="true">
                        <input name="tipo_solc" type="text" value="Atestado" hidden="true">
                        
                        <label class="reqs-form-labl">Tipo de Atestado</label>
                        <select name="tpau_solc" class="reqs-form-inpt">
                           <option>Médico</option>
                           <option>Óbito</option>
                           <option>Acidente de Trabalho</option>
                           <option>Repouso a Gestante</option>
                           <option>Convocação Militar</option>
                        </select>
                        <br>
                        <label class="reqs-form-labl">Documento</label>
                        <input id="file_show4" class="reqs-form-inpt" type="button" value="Clique Para Subir Arquivo" onclick="file(4);">
                        <br>
                        <label class="reqs-form-labl">Disciplina</label>
                        <select name="mtau_solc" class="reqs-form-inpt">
                            <?php
                            $cmd3 = "SELECT matr.iden_matr,matr.nome_matr
                                    FROM materia AS matr LEFT JOIN cursando AS crsn ON matr.iden_matr=crsn.iden_matr
                                                         LEFT JOIN aluno    AS alun ON crsn.cicl_alun=alun.cicl_alun
                                    WHERE crsn.regx_user=$rmat AND alun.cicl_alun=$cicl";
                            $rst3 = mysqli_query($conn, $cmd3);
                            
                            while ($c = mysqli_fetch_array($rst3))
                            {
                            echo "<option value=\"$c[0]\">$c[1]</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label class="reqs-form-labl">Data da Ausência</label>
                        <input name="dtau_solc" class="reqs-form-data" type="date">
                        <br>
                        <input class="reqs-form-butn" type="submit" value="Concluído">
                    </form>
                </div>
                <!-- papéis de estágio -->
                <div id="form_5" class="reqs-form rowalign stud-hidden">
                    <div class="reqs-form-prev">
                        <h3 style="margin:0;">Papéis de Estágio</h3>
                        <hr>
                        <p style="margin:0;" class="reqs-form-prev-text">O estágio constitui-se em trabalho de campo, onde as atividades práticas são exercidas mediante fundamentação teórica prévia ou simultaneamente adquirida, em situações reais de trabalho.<br>Tem duração de 240 horas e é atividade obrigatória. Sua integralização, com êxito, é indispensável à conclusão do curso.</p>
                    </div>
                    <form action="php/request.php" method="POST" enctype="multipart/form-data" class="reqs-form-form clmalign" style="justify-content:unset;">
                        <input id="file5" name="anex_solc" type="file" hidden="true">
                        <input name="iden_solc" type="text" value="5" hidden="true">
                        <input name="tipo_solc" type="text" value="Papéis de Estágio" hidden="true">
                        
                        <label class="reqs-form-labl">Termo de Compromisso</label>
                        <a href="arq/base/termo-de-compromisso.docx" download="termo-de-compromisso.docx"><input class="reqs-form-butn" type="button" value="Clique Para Baixar Arquivo"></a>
                        <br>
                        <label class="reqs-form-labl">Seu Preenchimento</label>
                        <input id="file_show5" class="reqs-form-inpt" type="button" value="Clique Para Subir Arquivo" onclick="file(5);">
                        <br>
                        <input class="reqs-form-butn" type="submit" value="Concluído">
                    </form>
                </div>
                <!-- histórico escolar -->
                <div id="form_6" class="reqs-form rowalign stud-hidden">
                    <div class="reqs-form-prev">
                        <h3 style="margin:0;">Histórico Escolar</h3>
                        <hr>
                        <p style="margin:0;" class="reqs-form-prev-text">Aqui você poderá verificar informações  importantes sobre o desempenho acadêmico até agora, podendo visualizar a frequência, notas e situação atual em cada disciplina. É uma ferramenta simples e eficaz para acompanhar o progresso.</p>
                    </div>
                    <div class="table-container">
                        <table class="reqs-form-form clmalign" style="justify-content:unset;">
                            <tr>
                                <th class="reqs-form-form-th">MATÉRIA</th>
                                <th class="reqs-form-form-th">MÉDIA</th>
                                <th class="reqs-form-form-th">FREQUÊNCIA</th>
                                <th class="reqs-form-form-th">CICLO</th>
                                <th class="reqs-form-form-th">SITUAÇÃO</th>
                            </tr>
                            <?php
                            $cmd2 = "SELECT matr.nome_matr,crsn.ntp1_crsn,crsn.ntp2_crsn,crsn.ntp3_crsn,crsn.nttt_crsn,
                                            crsn.falt_crsn,matr.chor_matr,crsn._ano_crsn,crsn._sem_crsn,crsn.situ_crsn
                                    FROM cursando AS crsn INNER JOIN materia AS matr ON crsn.iden_matr=matr.iden_matr
                                    WHERE crsn.regx_user='$rmat'";
                            $rst2 = mysqli_query($conn, $cmd2);
                            
                            while ($b = mysqli_fetch_array($rst2))
                            {
                                $media = number_format($b[1]*0.35 + $b[2]*0.4 + $b[4]*0.25, 2, '.', '');
                                
                                $media < 6 ? $media = number_format($media + $b[3]*0.35, 2, '.', '') : null;
                                
                                $freqs = (($b[6] - $b[5]) / $b[6]) * 100;
                                
                                $clr1  = $media < 6  ? 'red' : 'green';
                                $clr2  = $freqs < 75 ? 'red' : 'green';
                                $clr3  = $b[9] == 'Retido' ? 'red' : ($b[9] == 'Aprovado' ? 'green' : 'gray');
                            
                            echo "<tr>
                                <td class=\"reqs-form-form-td\">$b[0]</td>
                                <td class=\"reqs-form-form-td\" style=\"color:$clr1\">$media</td>
                                <td class=\"reqs-form-form-td\" style=\"color:$clr2\">$freqs%</td>
                                <td class=\"reqs-form-form-td\">$b[7]-$b[8]</td>
                                <td class=\"reqs-form-form-td\" style=\"color:$clr3\">$b[9]</td>
                            </tr>";
                            }
                            ?>
                        </table>
                    </div>
               </div>
               
                <?php
                if (isset($_SESSION['msge']))
                {
                    $type = $_SESSION['type'];
                    
                echo "<script>
                    form($type);
                </script>";
                    
                    echo  $_SESSION['msge'];
                    unset($_SESSION['msge']);
                }
                ?>
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

<script src="js/requests.js"></script>