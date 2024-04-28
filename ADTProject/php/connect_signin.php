<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $servername = "localhost";
    $username = "root";
    $dbname = "India_voyage";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, '');
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to fetch the email associated with the provided email
        $stmtEmail = $conn->prepare("SELECT email FROM Login WHERE email = :email");
        $stmtEmail->bindParam(':email', $email);
        $stmtEmail->execute();
        $storedEmail = $stmtEmail->fetchColumn();

        // Prepare the SQL statement to fetch the password associated with the provided email
        $stmtPassword = $conn->prepare("SELECT password FROM Login WHERE email = :email");
        $stmtPassword->bindParam(':email', $email);
        $stmtPassword->execute();
        $storedPassword = $stmtPassword->fetchColumn();

        // Verify the email and password
        if ($email == $storedEmail && $password == $storedPassword) {
            $stmtUserId = $conn->prepare("SELECT login_id FROM Login WHERE email = :email");
            $stmtUserId->bindParam(':email', $email);
            $stmtUserId->execute();
            $userId = $stmtUserId->fetchColumn();
            $_SESSION['userID'] = $userId;
            header("Location: /ADTProject/Homepage.html");
        } else {
            // Invalid credentials
            header("Location: /ADTProject/index.html");
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
