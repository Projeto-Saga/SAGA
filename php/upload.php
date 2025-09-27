<?php
session_start();
$con = include("{$_SERVER["DOCUMENT_ROOT"]}/SAGA/php/connect.php");

if (isset($_SESSION['ativ']))
{
    header('Content-Type: application/json; charset=utf-8');
    $iden = $_POST['iden'];
    $foto = "IMG_{$_SESSION["regx"]}.jpg";

    if (!empty($_FILES['foto']['size']))
    {
        if ($_FILES['foto']['size'] <= 1000000)
        {
            if (file_put_contents("../img/fotos/$foto", file_get_contents($_FILES['foto']['tmp_name'])))
            {
                $cmd = "UPDATE usuario SET foto_user='$foto' WHERE iden_user=$iden";
                $rst = mysqli_query($con, $cmd);

                if ($rst)
                {
                    echo json_encode(array("success" => true, "message" => "FOTO DE PERFIL ALTERADA COM SUCESSO!"));
                }
                else
                {
                    echo json_encode(array("success" => false, "message" => "ERRO AO TENTAR ALTERAR FOTO DE PERFIL!"));
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