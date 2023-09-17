<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selectCategory']) || isset($_POST['getCategory'])) {
        $conn = mysqli_connect(
            "localhost",
            "root",
            "",
            "financialDB"
        );


        $sql = "SELECT * FROM categoria";
        $result = mysqli_query($conn, $sql);
        $categories = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }

        echo json_encode($categories);
        mysqli_close($conn);

        exit;

    }
}
?>