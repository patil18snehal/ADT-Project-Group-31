<?php
include 'database.php';

// Start the session
session_start();

// Check if the request contains place data
if (isset($_POST['name'])) {
    // Retrieve place data from the request
    $name = $_POST['name'];

    // Retrieve user ID from the session
    $userID = $_SESSION['userID'];

    // Prepare SQL statement to check if the place exists in the wishlist table
    $stmt = $conn->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = :userID AND name = :name");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':name', $name);
    $stmt->execute();

    // Fetch the count
    $count = $stmt->fetchColumn();

    // Check if the count is greater than 0
    $exists = ($count > 0);

    // Return the result as JSON
    echo json_encode(['exists' => $exists]);
} else {
    // If place data is not provided, send false response
    echo json_encode(['exists' => false]);
}
?>