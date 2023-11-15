<?php
@include 'database.php';

if(isset($_POST['campus'])) {
    $selectedCampus = $_POST['campus'];
    $query = "SELECT * FROM CAMPUS_BUILDING WHERE PRINTERS_CAMPUSLOC = '$selectedCampus'";
    $result = $conn->query($query);

    if ($result) {
        $buildings = array();
        while ($row = $result->fetch_assoc()) {
            $buildings[] = $row['PRINTERS_BUILDINGLOC'];
        }
        echo json_encode($buildings);
    } else {
        echo "Error executing the query: " . $conn->error;
    }
}
?>