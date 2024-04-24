<?php
include 'database.php';

if (isset($_POST['state']) && isset($_POST['city'])) {
    $state = $_POST['state'];
    $city = $_POST['city'];
    $stmt = $conn->prepare("SELECT DISTINCT name FROM indianplaces WHERE state = :state AND city = :city");
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':city', $city);
    $stmt->execute();
    $places = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($places);
} else {
    echo json_encode([]);
}
?>
