<?php
@include 'database.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $del = " DELETE FROM request_perform_printer WHERE id = '$id'; ";
    mysqli_query($conn, $del);
    header('location:activitylog.php');
}
if (isset($_GET['confirm_delete_range'])) {
    if (isset($_GET['delete_hour'])) {
        mysqli_query($conn, 'delete request_perform_printer from request_perform_printer join requestprint as R on request_perform_printer.requestid = R.id where starttime >= ( now() - interval 1 hour) and state=1;');
    }
    if (isset($_GET['delete_day'])) {
        mysqli_query($conn, 'delete request_perform_printer from request_perform_printer join requestprint as R on request_perform_printer.requestid = R.id where starttime >= ( now() - interval 1 day) and state=1;');
    }
    if (isset($_GET['delete_week'])) {
        mysqli_query($conn, 'delete request_perform_printer from request_perform_printer join requestprint as R on request_perform_printer.requestid = R.id where starttime >= ( now() - interval 1 week) and state=1;');
    }
    if (isset($_GET['delete_month'])) {
        mysqli_query($conn, 'delete request_perform_printer from request_perform_printer join requestprint as R on request_perform_printer.requestid = R.id where starttime >= ( now() - interval 1 month) and state=1;');
    }
    if (isset($_GET['delete_year'])) {
        mysqli_query($conn, 'delete request_perform_printer from request_perform_printer join requestprint as R on request_perform_printer.requestid = R.id where starttime >= ( now() - interval 1 day) and state=1;');
    }
    header('location:activitylog.php');
}



?>