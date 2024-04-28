<?php
include 'database.php';

if (isset($_POST['state'])) {
    $state = $_POST['state'];
    $stmt = $conn->prepare("SELECT DISTINCT city FROM indianplaces WHERE state = :state");
    $stmt->bindParam(':state', $state);
    $stmt->execute();
    $cities = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($cities);
} else {
    echo json_encode([]);
}
?>
