<?php
include 'php/database.php';

// Start the session
session_start();

// Check if the request contains place data
if (isset($_POST['name'])) {
    // Retrieve place data from the request
    $name = $_POST['name'];

    // Retrieve user ID from the session
    $userID = $_SESSION['userID'];

    // Prepare SQL statement to delete data from wishlist table
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = :userID AND name = :name");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':name', $name);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // If deletion is successful, send success response
        echo json_encode(['success' => true]);
    } else {
        // If deletion fails, send failure response
        echo json_encode(['success' => false]);
    }
} else {
    // If place data is not provided, send failure response
    echo json_encode(['success' => false]);
}
?>