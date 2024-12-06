<?php
// Include database connection
require 'connect.php'; // Ensure this file establishes a connection to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user input
    $User_Name = htmlspecialchars(trim($_POST['User_Name']));
    $Phone = htmlspecialchars(trim($_POST['Phone']));
    $Email = htmlspecialchars(trim($_POST['Email']));
    $Password = password_hash($_POST['Password'], PASSWORD_DEFAULT); // Secure password hashing

    // Insert into the database
    $sql = "INSERT INTO workers (User_Name, Phone, Email, Password) VALUES (?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $User_Name, $Phone, $Email, $Password);
        if ($stmt->execute()) {
            echo "Worker signed up successfully!";
            header("Location:Worker_Login.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
