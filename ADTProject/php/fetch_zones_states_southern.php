<?php
include 'database.php';

$stmt = $conn->prepare("SELECT DISTINCT state FROM indianplaces where zone = 'Southern'");
$stmt->execute();
$states = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($states);
?>
