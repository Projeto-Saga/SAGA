<?php
session_start();
$con = include("{$_SERVER["DOCUMENT_ROOT"]}/server/SAGA/php/connect.php");

if (isset($_SESSION['ativ']))
{
    $codg = $_SESSION['ativ'];

    $cmd = "SELECT regx_user FROM usuario WHERE codg_user='$codg'";
    $rst = mysqli_query($con, $cmd);

    while ($r = mysqli_fetch_array($rst)) $regx = $r[0];

    $exts = "." . pathinfo($_FILES['anex_solc']['name'], PATHINFO_EXTENSION);

    $file = $_POST['iden_solc']."_$regx"."_".time().$exts;
    $type = $_POST['tipo_solc'];

    switch ($_POST['iden_solc'])
    {
        case '1':
            $cols = ", cond_soli";
            $vals = ", '".$_POST['trns_solc']."'";
        break;

        case '2':
            $cols = ", mtap_soli";
            $vals = ", '".json_encode($_POST['mtap_solc'])."'";
        break;

        case '4':
            $cols = ", tpau_soli, mtau_soli, dtau_soli";
            $vals = ", '".$_POST['tpau_solc']."', '".$_POST['mtau_solc']."', '".$_POST['dtau_solc']."'";
        break;

        case '5':
            $cols = "";
            $vals = "";
        break;
    }

    if (!empty($_FILES['anex_solc']['size']))
    {
        if ($_FILES['anex_solc']['size'] <= 1000000)
        {
            if (file_put_contents("../arq/solc/$file", file_get_contents($_FILES['anex_solc']['tmp_name'])))
            {
                $cmd = "INSERT INTO solicitacao (regx_user, tipo_soli, anex_soli$cols) VALUES ($regx, '$type', '$file'$vals)";
                $rst = mysqli_query($con, $cmd);

                if ($rst)
                {
                    echo json_encode(array("success" => true, "message" => "SOLICITAÇÃO ENVIADA COM SUCESSO!"));
                }
                else
                {
                    echo json_encode(array("success" => false, "message" => "ERRO AO TENTAR ENVIAR SOLICITAÇÃO!"));
                }
            }
            else
            {
                echo json_encode(array("success" => false, "message" => "ERRO AO TENTAR MOVER ARQUIVO!"));
            }
        }
        else
        {
            echo json_encode(array("success" => false, "message" => "ARQUIVO GRANDE DEMAIS! MÁXIMO: 1MB"));
        }
    }
    else
    {
        echo json_encode(array("success" => false, "message" => "NENHUM ARQUIVO FOI SELECIONADO..."));
    }
}
else
{
    header("location:..");
} 
?>
