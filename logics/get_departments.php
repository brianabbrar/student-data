<?php 
require('connection.php');

$fac_id = $_GET['fac_id'];
$result = mysqli_query($conn, "SELECT * FROM department WHERE fac_id = '$fac_id'");

$departments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $departments[] = $row;
}

echo json_encode($departments);
?>
