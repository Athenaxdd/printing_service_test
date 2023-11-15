<?php
@include 'database.php';

if(isset($_POST['building'])) {
    $selectedBuilding = $_POST['building'];
    $query = "SELECT * FROM PRINTERS_LIST WHERE PRINTERS_BUILDINGLOC = '$selectedBuilding'";
    $result = $conn->query($query);

    if ($result) {
        $printers = array();
        while ($row = $result->fetch_assoc()) {
            $printers[] = $row['PRINTERS_ID'];
        }
        echo json_encode($printers);
    } else {
        echo "Error executing the query: " . $conn->error;
    }
}
?>