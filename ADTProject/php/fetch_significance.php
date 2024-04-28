<?php
// Include your database connection file
include 'database.php';

// Check if state and city are provided in the POST request
if(isset($_POST['state']) && isset($_POST['city'])) {
    $state = $_POST['state'];
    $city = $_POST['city'];

    // Prepare SQL statement to fetch types based on the selected state and city
    $stmt = $conn->prepare("SELECT DISTINCT Significance FROM Indianplaces WHERE state = :state AND city = :city");
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':city', $city);
    $stmt->execute();
    $significance = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return the types as JSON response
    echo json_encode($significance);
} else {
    // If state or city is not provided, return empty response
    echo json_encode([]);
}
?>