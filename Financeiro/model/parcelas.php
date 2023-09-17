<?php
//A inserção das parcelas está no títulos.php, pois ela é feita concomitantemente à inserção do título.
$conn = mysqli_connect("localhost","root","","financialDB");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['SelectInicial'])) {
        $sql = "SELECT * FROM parcelas"; // futuramente adicionar uma cláusula WHERE para pegar apenas as parcelas que estão vencendo nesse mês
        $result = mysqli_query($conn, $sql);
        $parcelas = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($parcelas);

    }
}

?>