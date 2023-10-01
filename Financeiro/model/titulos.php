<?php
// session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $conn = mysqli_connect(
                "localhost",
                "root",
                "",
                "financialDB"
        );



        if (isset($_POST['createBond'])) {
                $nomeTitulo = $_POST['nomeTitulo'];
                $valorTotal = $_POST['ValorTotal'];
                $dataAbertura = $_POST['dataAbertura'];
                $categoria = $_POST['categoria'];
                $qtdParcelas = $_POST['qtdParcelas'];
                $recorrente = $_POST['recorrente'];
                $tipo = $_POST['tipo'];

                $getID = "SELECT MAX(IDTitulo) + 1 AS nextID FROM titulos;";
                $result = mysqli_query($conn, $getID);
                $row = mysqli_fetch_assoc($result);
                $IDTitulo = $row['nextID'];

                $sql = "INSERT INTO titulos (IDTitulo,nomeTitulo,valorTotal,valorAberto,dataAbertura,dataQuitacao,qtdParcelas,recorrente,situacao,tipo,categoria)
                        VALUES ($IDTitulo, '$nomeTitulo', '$valorTotal', '$valorTotal', '$dataAbertura', NULL, '$qtdParcelas', '$recorrente', '1', '$tipo', '$categoria')";

                $result = mysqli_query($conn, $sql);
                if ($result) {
                        echo "OK\n";
                } else {
                        echo "Erro na inserção do título: " . mysqli_error($conn) . "\n";
                }
                // echo $sql; 

                $parcelasJSON = json_decode($_POST['parcelasJSON'], true);

                if ($categoria == 1) {
                        $cartao = 1;
                } else
                        $cartao = 0;

                $tituloRef = $IDTitulo;

                foreach ($parcelasJSON as $parcela) {
                        $valor = $parcela['valor'];
                        $emissao = $parcela['emissao'];
                        $vencimento = $parcela['vencimento'];
                        $numeroParcela = $parcela['numero'];

                        // Execute a consulta para obter o próximo IDParcela
                        $sql2 = 'SELECT MAX(IDParcela) + 1 AS nextID FROM parcelas;';
                        $result2 = mysqli_query($conn, $sql2);
                        $row = mysqli_fetch_assoc($result2);
                        $IDParcela = $row['nextID'];

                        // Certifique-se de verificar se $IDParcela é nulo ou indefinido antes de usá-lo
                        if ($IDParcela === null) {
                                $IDParcela = 1; // Se for nulo, defina como 1 para a primeira inserção
                        }

                        // Continue com a inserção
                        $sql3 = "INSERT INTO parcelas (IDParcela,valor,emissao,vencimento,numeroParcela,tituloRef,cartao,categoria) 
                                VALUES ($IDParcela, '$valor', '$emissao', '$vencimento', $numeroParcela, $tituloRef, $cartao, $categoria);";
                        $result3 = mysqli_query($conn, $sql3);

                        if ($result3) {
                                echo "OK\n";
                        } else {
                                echo "Erro na inserção da parcela: " . mysqli_error($conn) . "<br>";
                        }
                }
        }else
        if(isset($_POST['selectInicialConsulta'])){
                $sql = "SELECT IDTitulo, nomeTitulo, valorTotal, valorAberto, dataAbertura, dataQuitacao, qtdParcelas, s.descricao as 'situacao', tipo, c.descricao as 'categoria' FROM titulos
                        LEFT JOIN categoria c on c.ID = titulos.categoria
                        LEFT JOIN situacao s on s.IDSituacao = titulos.situacao
                        WHERE titulos.situacao = 1";
                $result = mysqli_query($conn, $sql);
                $titulos = array();
                while ($row = mysqli_fetch_assoc($result)) {
                        $titulos[] = $row;
                }
                echo json_encode($titulos);
        }



}
?>