<?php
class Controller
{
    private $url;
    private $con;
    private $cdg;

    public function __construct()
    {
        $this->url = "http://localhost:8080/aux/materia/find_all";
        $this->con = mysqli_connect('localhost', 'root', '', 'saga_db');
        // $this->con = mysqli_connect('localhost', 'root', 'usbw', 'saga_db');
        $this->cdg = $_SESSION['ativ'];
    }

    public function mtc_callApi($cicl)
    {
        $data = @file_get_contents($this->url);
        
        if ($data === false)
        {
            $response = "<label class=\"reqs-form-labl\">Conexão com API indisponível</label>";
        }
        else
        {
            $data = json_decode($data);
        
            if (json_last_error() !== JSON_ERROR_NONE)
            {
                $response = "<label class=\"reqs-form-labl\">Erro ao processar retorno</label>";
            }
            else
            {
                $response = "
                <div class=\"rowalign grid-g10\">
                    <article class=\"clmalign grid-g10\">";

                $cmd = "SELECT abrv_matr, nome_matr, chor_matr, dias_matr, hora_matr, situ_crsn
                        FROM cursando AS crsn INNER JOIN materia AS matr ON crsn.iden_matr=matr.iden_matr
                        WHERE cicl_alun=$cicl
                          AND regx_user=(SELECT regx_user FROM usuario WHERE codg_user='$this->cdg')
                        ORDER BY dias_matr, hora_matr ASC";
                $rst = mysqli_query($this->con, $cmd);

                while ($r = mysqli_fetch_array($rst))
                {
                    if ($r[5] == 'Retido'  ) $stat = "retd";
                    if ($r[5] == 'Aprovado') $stat = "aprv";

                    $response .= "
                    <div id=\"$r[0]\" class=\"$stat\">
                        <h1>$r[1]</h1>
                        <h2>($r[0])</h2>
                        <p>$r[2] horas - Aula $r[4]</p>
                    </div>";
                }

                $response .= "
                </article>
                <article class=\"clmalign grid-g10\">";

                usort($data, array($this, 'mtc_compare'));

                foreach ($data as $d)
                {
                    if (intval($d->ccpv_matr) == $cicl+1)
                    {
                        $response .= "
                        <div id=\"$d->abrv_matr\" onclick=\"chck($(this))\">
                            <h1>$d->nome_matr</h1>
                            <h2>($d->abrv_matr)</h2>
                            <p>$d->chor_matr horas - Aula $d->hora_matr</p>
                        </div>";
                    }
                }

                $response .= "</article></div>";
            }
        }

        return $response;
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