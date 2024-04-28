<?php
// Include your database connection file
include 'php/database.php';

session_start(); // Fix syntax here
// Assuming $_POST['name'] contains the name of the item to delete
$name = $_POST['name'];

// Retrieve user ID from the session
$userID = $_SESSION['userID'];

// Prepare SQL statement to delete data from wishlist table
$stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = :userID AND name = :name");
$stmt->bindParam(':userID', $userID);
$stmt->bindParam(':name', $name);

// Check if the deletion was successful
if ($stmt->execute()) {
    // Return a success response
    echo json_encode(['success' => true]);
} else {
    // Return a failure response
    echo json_encode(['success' => false]);
}
?>
