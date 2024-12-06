<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/alc.jpg'); /* Background image */
            background-size: cover;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register a Branch</h2>
        <form action="branch.php" method="POST">
            <label for="branch_name">Branch Name:</label>
            <input type="text" id="branch_name" name="branch_name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required>

            <label for="manager_id">Manager ID:</label>
            <input type="number" id="manager_id" name="manager_id" required min="1">

            <input type="submit" value="Register Branch">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get form data
            $branch_name = $_POST['branch_name'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $contact_number = $_POST['contact_number'];
            $manager_id = $_POST['manager_id'];

            // Create database connection
            $conn = new mysqli("localhost", "root", "", "riderent");

            // Check for connection errors
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Sanitize user inputs to prevent SQL injection
            $branch_name = $conn->real_escape_string($branch_name);
            $address = $conn->real_escape_string($address);
            $city = $conn->real_escape_string($city);
            $country = $conn->real_escape_string($country);
            $contact_number = $conn->real_escape_string($contact_number);
            $manager_id = (int)$manager_id;

            // Prepare the SQL query using a prepared statement
            $sql = "INSERT INTO branch (Branch_Name, Address, City, Country, Contact_Number, Manager_ID) 
                    VALUES (?, ?, ?, ?, ?, ?)";

            // Initialize prepared statement
            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters to the query
                $stmt->bind_param("sssssi", $branch_name, $address, $city, $country, $contact_number, $manager_id);
                
                // Execute the query
                if ($stmt->execute()) {
                    echo "<p class='message'>Branch Registered Successfully!</p>";
                } else {
                    echo "<p class='message' style='color: red;'>Error: " . $stmt->error . "</p>";
                }

                // Close the prepared statement
                $stmt->close();
            } else {
                echo "<p class='message' style='color: red;'>Error preparing query: " . $conn->error . "</p>";
            }

            // Close the database connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
