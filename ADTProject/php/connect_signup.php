<?php
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $servername = "localhost";
    $username = "root";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=India_voyage", $username, '');
        
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement with named placeholders
        $stmt = $conn->prepare("INSERT INTO Login(firstName, lastName,  email, password) VALUES(:firstName, :lastName, :email, :password)");

        // Bind values to named placeholders
        $stmt->bindValue(':firstName', $firstName);
        $stmt->bindValue(':lastName', $lastName);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);

        // Execute the statement
        $execval = $stmt->execute();
        

        // Close the statement and the connection
        $stmt->closeCursor();
        $conn = null;

        header("Location: index.html");
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
