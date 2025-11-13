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
            <div class="discip-info">
                <div class="discip-box">
                    <p class="title">Disciplina</p>
                    <p class="value">ÁLGEBRA LINEAR</p>
                </div>
                <div class="discip-box">
                    <p class="title">Turma</p>
                    <p class="value">DSM 3</p>
                </div>
                <div class="discip-box">
                    <p class="title">Total de alunos</p>
                    <p class="value">30</p>
                </div>
                <div class="aula-select">
                    <label for="aula">Selecione a aula:</label>
                    <select id="aula">
                        <option>Aula I</option>
                        <option>Aula II</option>
                        <option>Aula III</option>
                    </select>
                </div>
            </div>

            <table class="alunos-tabela">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>RA</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><div class="circle"></div> Ana Clara Souza</td>
                        <td>2023101</td>
                        <td class="presente"><input type="checkbox" checked> Presente</td>
                    </tr>
                    <tr>
                        <td><div class="circle"></div> Bruno Henrique Alves</td>
                        <td>2023102</td>
                        <td class="ausente"><input type="checkbox"> Não presente</td>
                    </tr>
                    <tr>
                        <td><div class="circle"></div> Camila Rodrigues Lima</td>
                        <td>2023103</td>
                        <td class="presente"><input type="checkbox" checked> Presente</td>
                    </tr>
                    <tr>
                        <td><div class="circle"></div> Daniel Ferreira Costa</td>
                        <td>2023104</td>
                        <td class="presente"><input type="checkbox" checked> Presente</td>
                    </tr>
                </tbody>
            </table>

            <div class="salvar-container">
                <button class="btn-salvar">SALVAR</button>
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
