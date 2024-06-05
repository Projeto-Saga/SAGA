<?php
class Controller
{
    private $url;

    public function __construct()
    {
        $this->url = "https://localhost:8080/aux/materia/find_all";
    }

    public function mtc_callApi()
    {
        $options = [
            'http' => [
                'method' => 'GET',
                'timeout' => 0
            ]
        ];
        
        $context = stream_context_create($options);
        
        $response = @file_get_contents($this->url, false, $context);
        
        if ($response === false)
        {
            $response = "Erro ao tentar acessar a API.";
        }
        else
        {
            $response = json_decode($response);
        
            if (json_last_error() !== JSON_ERROR_NONE)
            {
                $response = "Erro ao processar resposta.";
            }
        }

        return $response;
    }
}
?>