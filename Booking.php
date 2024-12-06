<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $user_name = $_POST['user_name']; // User name
    $booking_date = $_POST['booking_date']; // Booking date
    $booking_status = $_POST['booking_status']; // Booking status
    $destination = $_POST['destination']; // Destination
    $gender = $_POST['gender']; // Gender

    // Create database connection
    $conn = new mysqli("localhost", "root", "", "riderent");

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user inputs to prevent SQL injection
    $user_name = $conn->real_escape_string($user_name);
    $booking_status = $conn->real_escape_string($booking_status);
    $destination = $conn->real_escape_string($destination);
    $gender = $conn->real_escape_string($gender);

    // Prepare the SQL query to insert the booking
    $sql = "INSERT INTO booking (User_Name, Booking_Date, Booking_Status, Destination, Gender) 
            VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the query
        $stmt->bind_param("sssss", $user_name, $booking_date, $booking_status, $destination, $gender);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Booking Registered Successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Error preparing query: " . $conn->error . "</p>";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Booking</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: url('../images/alc.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .input-box {
            margin: 15px 0;
        }

        .input-box label {
            font-size: 14px;
            color: #333;
        }

        .input-box input, .input-box select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }

        p {
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Vehicle Booking Form</h2>
        <form method="POST">
            <div class="input-box">
                <label for="user_name">User Name</label>
                <input type="text" name="user_name" id="user_name" required>
            </div>

            <div class="input-box">
                <label for="booking_date">Booking Date</label>
                <input type="date" name="booking_date" id="booking_date" required>
            </div>

            <div class="input-box">
                <label for="booking_status">Booking Status</label>
                <select name="booking_status" id="booking_status" required>
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <div class="input-box">
                <label for="destination">Destination</label>
                <input type="text" name="destination" id="destination" required>
            </div>

            <div class="input-box">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">Book Now</button>
        </form>
    </div>
</body>
</html>
