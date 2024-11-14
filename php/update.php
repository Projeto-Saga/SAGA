<?php
include("{$_SERVER['DOCUMENT_ROOT']}/php/connect.php");

if (isset($_SESSION['ativ']))
{
    $iden = $_POST["iden"];

    switch ($_REQUEST["type"])
    {
        case 'fone':
            if ($_POST["item"] == 'null')
            {
                $fone = $_POST["novo"];

                if (!empty($fone) && strlen($fone) == 15)
                {
                    $cmd = "INSERT INTO telefone (iden_user, nmro_fone) VALUES ($iden, '$fone')";
                    $rst = mysqli_query($con, $cmd);

                    echo json_encode(array("success" => true, "message" => "NOVO NÚMERO INCLUÍDO COM SUCESSO!")); die;
                }
                else
                {
                    echo json_encode(array("success" => false, "message" => "TELEFONE: NÚMERO ESTÁ INCOMPLETO!")); die;
                }
            }
            else
            {
                $iden = $_POST["item"];

                $cmd = "DELETE FROM telefone WHERE iden_fone=$iden";
                $rst = mysqli_query($con, $cmd);

                echo json_encode(array("success" => true, "message" => "NOVO NÚMERO EXCLUÍDO COM SUCESSO!")); die;
            }
        break;

        case 'altr':
            $senh = $_POST["senh"];
            $fone = $_POST["fone"];

            if (strlen($senh) >= 8)
            {
                $cmd = "UPDATE usuario SET senh_user='$senh' WHERE iden_user=$iden";
                $rst = mysqli_query($con, $cmd);
            }
            else
            {
                echo json_encode(array("success" => false, "message" => "SENHA: PELO MENOS 8 CARACTERES!")); die;
            }
            if (strlen($fone) == 15)
            {
                $cmd = "UPDATE usuario SET fone_user='$fone' WHERE iden_user=$iden";
                $rst = mysqli_query($con, $cmd);
            }
            else
            {
                echo json_encode(array("success" => false, "message" => "TELEFONE: NÚMERO ESTÁ INCOMPLETO!")); die;
            }

            echo json_encode(array("success" => true, "message" => "ALTERAÇÕES SALVAS COM SUCESSO!")); die;
        break;
    }
}
else
{
    header("location:..");
}
?>