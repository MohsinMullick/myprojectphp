<?php
// Include your database connection file
require 'connect.php'; // Ensure this file connects to your database and assigns $conn

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $User_Name = htmlspecialchars(trim($_POST['User_Name'] ?? ''));
    $Phone = htmlspecialchars(trim($_POST['Phone'] ?? ''));
    $Email = htmlspecialchars(trim($_POST['Email'] ?? ''));
    $Password = $_POST['Password'] ?? '';

    // Validate form data
    if (empty($User_Name) || empty($Phone) || empty($Email) || empty($Password)) {
        echo "All fields are required.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($Password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert data
    $sql = "INSERT INTO admin (User_Name, Phone, Email, Password) VALUES (?, ?, ?, ?)";

    // Use a prepared statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("ssss", $User_Name, $Phone, $Email, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            echo "User registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    // If the request method is not POST
    echo "Please submit the form to register a user.";
}
?>
