<?php
class Controller
{
    private $url;
    private $con;

    public function __construct()
    {
        $this->url = "http://localhost:8080/aux/materia/find_all";
        $this->con = mysqli_connect('localhost', 'root', '', 'saga_db');
        // $this->con = mysqli_connect('localhost', 'root', 'usbw', 'saga_db');
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
                $response = "<article class=\"clmalign grid-g10\">";

                foreach ($data as $d)
                {
                    if (intval($d->ccpv_matr) == $cicl)
                    {
                        $response .= "
                        <div id=\"$d->abrv_matr\" onclick=\"chck($(this))\">
                            <h1>$d->nome_matr</h1>
                            <h2>($d->abrv_matr)</h2>
                            <p>$d->chor_matr horas - Aula $d->hora_matr</p>
                        </div>";
                    }
                }

                $response .= "</article>";
            }
        }

        return $response;
    }
}
?>