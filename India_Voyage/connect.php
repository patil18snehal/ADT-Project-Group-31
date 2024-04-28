<?php
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $number = $_POST['number'];
    $servername = "localhost";
    $username = "root";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=India_voyage", $username, '');
        echo "Connected successfully";
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement with named placeholders
        $stmt = $conn->prepare("INSERT INTO regisrations(firstName, lastName, gender, email, password, number) VALUES(:firstName, :lastName, :gender, :email, :password, :number)");

        // Bind values to named placeholders
        $stmt->bindValue(':firstName', $firstName);
        $stmt->bindValue(':lastName', $lastName);
        $stmt->bindValue(':gender', $gender);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':number', $number);

        // Execute the statement
        $execval = $stmt->execute();
        echo $execval;

        // Close the statement and the connection
        $stmt->closeCursor();
        $conn = null;

        echo "Registration successful";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
