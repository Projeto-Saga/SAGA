<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'saga_db');
// $con = mysqli_connect('localhost', 'root', 'usbw', 'saga_db');

if (isset($_SESSION['ativ']))
{
    $iden = $_POST["iden"];
    $senh = $_POST["senh"];
    $fone = $_POST["fone"];
    $novo = $_POST["novo"];
    $excl = $_POST["excl"];
    // $foto = $_FILES["foto"];
    
    if (!empty($senh) && strlen($senh) >= 8)
    {
        $cmd = "UPDATE usuario SET senh_user='$senh' WHERE iden_user=$iden";
        $rst = mysqli_query($con, $cmd);
    }
    if (!empty($fone) && strlen($fone) == 15)
    {
        $cmd = "UPDATE usuario SET fone_user='$fone' WHERE iden_user=$iden";
        $rst = mysqli_query($con, $cmd);
    }
    if (!empty($novo) && strlen($novo) == 15)
    {
        $cmd = "INSERT INTO telefone (iden_user, nmro_fone) VALUES ($iden, '$novo')";
        $rst = mysqli_query($con, $cmd);
    }

    header("location:../profile.php");
}
else
{
    header("location:..");
}
?>