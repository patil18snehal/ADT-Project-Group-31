<?php
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $servername = "localhost";
    $username = "root";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=India_voyage", $username, '');
        echo "Connected successfully";
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement with named placeholders
        $stmt = $conn->prepare("SELECT * FROM Login WHERE email = '$email' AND password ='$password'");

        // Execute the statement
        $execval = $stmt->execute();
        if($execval==1){
         header("Location: Homepage.html");
         exit();
        }else{
         header("Location: index.html?error=invalid_credentials");
         exit();
        }

        // Close the statement and the connection
        $stmt->closeCursor();
        $conn = null;

       
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>