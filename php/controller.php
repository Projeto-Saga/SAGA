<?php
class Controller
{
    private $url;
    private $con;

    public function __construct()
    {
        $this->url = "http://localhost:8080/aux/materia/find_all";
        // $this->con = mysqli_connect('localhost', 'root', '', 'saga_db');
        $this->con = mysqli_connect('localhost', 'root', 'usbw', 'saga_db');
        mysqli_set_charset($this->con, "utf8");
    }

    public function mtc_callApi($iden, $cicl)
    {
        $data = @file_get_contents($this->url);
        
        if ($data === false)
        {
            $response = "<label class=\"reqs-form-labl\">Indisponível</label>";
        }
        else
        {
            $data = json_decode($data);
        
            if (json_last_error() !== JSON_ERROR_NONE)
            {
                $response = "<label class=\"reqs-form-labl\">Erro processual</label>";
            }
            else
            {
                $cmd = "SELECT DISTINCT cicl_alun
                        FROM cursando AS crsn INNER JOIN usuario AS user ON crsn.regx_user=user.regx_user
                        WHERE iden_user=$iden AND cicl_alun<$cicl ORDER BY cicl_alun ASC";
                $rst = mysqli_query($this->con, $cmd);

                while ($r = mysqli_fetch_array($rst)) $all[] = $r[0];

                $semAt = date('n') >= 1 && date('n') <= 6 ? '2' : '1';

                $cmd = "SELECT DISTINCT _sem_crsn
                        FROM cursando AS crsn INNER JOIN usuario AS user ON crsn.regx_user=user.regx_user
                        WHERE iden_user=$iden AND cicl_alun=$cicl-1";
                $rst = mysqli_query($this->con, $cmd);

                while ($r = mysqli_fetch_array($rst)) $semAl = $r[0];

                $enable = $semAt == $semAl ? "disabled" : "";

                $response = "
                <input type=\"button\" value=\"Confirmar Rematrícula\" onclick=\"send($('#reqs_3'), true)\" $enable>
                <div class=\"rowalign grid-g10\">";

                foreach ($all as $key => $val)
                {
                    $response .= "
                    <article class=\"clmalign grid-g10\">";

                    $cmd = "SELECT abrv_matr, nome_matr, chor_matr, dias_matr, hora_matr, situ_crsn, cicl_alun
                            FROM cursando AS crsn INNER JOIN materia AS matr ON crsn.iden_matr=matr.iden_matr
                                                  INNER JOIN usuario AS user ON crsn.regx_user=user.regx_user
                            WHERE iden_user=$iden AND cicl_alun=$val ORDER BY cicl_alun, dias_matr, hora_matr ASC";
                    $rst = mysqli_query($this->con, $cmd);

                    while ($r = mysqli_fetch_array($rst))
                    {
                        $response .= "
                        <div id=\"$r[0]\" class=\"".$this->mtc_statMtr($r[5])."\">
                            <h1>$r[1]</h1>
                            <h2>($r[0])</h2>
                            <p>$r[2] horas - Aula $r[4]</p>
                        </div>";
                    }

                    $response .= "
                    </article>";
                }

                $response .= "
                    <article class=\"clmalign grid-g10\">";

                if (empty($enable))
                {
                    usort($data, array($this, 'mtc_compare'));

                    foreach ($data as $d)
                    {
                        if (intval($d->ccpv_matr) == $cicl)
                        {
                            $response .= "
                        <div id=\"$d->abrv_matr\" onclick=\"chck($(this))\">
                            <h1>$d->nome_matr</h1>
                            <h2>($d->abrv_matr)</h2>
                            <p>$d->chor_matr horas - Aula $d->hora_matr</p>

                            <input name=\"matr[]\" type=\"checkbox\" value=\"$d->iden_matr\" hidden>
                        </div>";
                        }
                    }
                }

                $response .= "
                    </article>
                </div>";
            }
        }

        return $response;
    }

    private function mtc_statMtr($stat)
    {
        switch ($stat)
        {
            case 'Em Curso':
                return 'open';
            break;

            case 'Aprovado':
                return 'aprv';
            break;

            case 'Retido':
                return 'retd';
            break;

            case 'Próximo':
                return 'next';
            break;
        }
    }

    private function mtc_compare($a, $b)
    {
        if ($a->dias_matr < $b->dias_matr)
        {
            return -1;
        }
        elseif ($a->dias_matr > $b->dias_matr)
        {
            return 1;
        }
        else
        {
            return strcmp($a->hora_matr, $b->hora_matr);
        }
    }
}
?>