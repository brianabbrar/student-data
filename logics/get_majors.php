<?php
require('connection.php');

if (isset($_GET['dept_id'])) {
    $dept_id = $_GET['dept_id'];
    $query = mysqli_query($conn, "SELECT * FROM major WHERE dept_id='$dept_id' ORDER BY major_name ASC");
    $majors = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $majors[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($majors);
}
