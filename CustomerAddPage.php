<?php
// Include your database connection file
require 'connect.php'; // Ensure this file correctly connects to your database

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data with checks for undefined keys
    $first_name = htmlspecialchars(trim($_POST['first_name'] ?? ''));
    $last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''));
    $phone_number = htmlspecialchars(trim($_POST['phone_number'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? ''; // Password hashing will be applied later
    $user_type = htmlspecialchars(trim($_POST['user_type'] ?? ''));
    $registration_date = htmlspecialchars(trim($_POST['registration_date'] ?? ''));
    $postal_code = htmlspecialchars(trim($_POST['postal_code'] ?? ''));
    $payment_methods = htmlspecialchars(trim($_POST['payment_methods'] ?? ''));
    $road_no = htmlspecialchars(trim($_POST['road_no'] ?? ''));
    $house_no = htmlspecialchars(trim($_POST['house_no'] ?? ''));
    $location = htmlspecialchars(trim($_POST['location'] ?? ''));

    

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert data
    $sql = "INSERT INTO users (
                First_Name, Last_Name, Phone_Number, Email, Password, User_Type, 
                Registration_Date, Postal_Code, Payment_Methods, Road_No, House_No, Location
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Use a prepared statement to prevent SQL injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param(
            "ssssssssssss",
            $first_name, $last_name, $phone_number, $email, $hashed_password, $user_type,
            $registration_date, $postal_code, $payment_methods, $road_no, $house_no, $location
        );

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

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
