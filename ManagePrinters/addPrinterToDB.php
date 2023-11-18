<?php
@include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $printerId = $_POST['printerId'];
    $printerName = $_POST['printerName'];
    $printerDesc = $_POST['printerDesc'];
    $campus = $_POST['campus'];
    $building = $_POST['building'];

    $query = "INSERT INTO PRINTERS_LIST (PRINTERS_ID, PRINTERS_NAME, PRINTERS_DESC, PRINTERS_AVAI, PRINTERS_CAMPUSLOC, PRINTERS_BUILDINGLOC) VALUES (?, ?, ?, 'N', ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $printerId, $printerName, $printerDesc, $campus, $building);

    if ($stmt->execute()) {
        echo "New printer added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>