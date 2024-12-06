<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection details
    $host = 'localhost'; // Your database host
    $dbname = 'riderent'; // Your database name
    $username = 'root'; // Your database username
    $password = ''; // Your database password

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve form data
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $location = $_POST['location'];
        $destination = $_POST['destination'];
        $action = $_POST['action'];
        $payment = $_POST['payment'];

        // Insert data into the database
        $sql = "INSERT INTO ride_management (Name, Gender, Location, Destination, Action, Payment)
                VALUES (:name, :gender, :location, :destination, :action, :payment)";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':name' => $name,
            ':gender' => $gender,
            ':location' => $location,
            ':destination' => $destination,
            ':action' => $action,
            ':payment' => $payment,
        ]);

        $message = "Ride request successfully submitted!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/alc.jpg'); /* Update the path if necessary */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            width: 400px;
            max-width: 90%;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
            color: #474fa0;
        }
        label {
            font-size: 14px;
            margin: 10px 0 5px;
            display: block;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #474fa0;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #373f90;
        }
        .message {
            text-align: center;
            font-size: 16px;
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Ride Management</h1>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Others">Others</option>
            </select>

            <label for="location">Location (Pick-Up)</label>
            <input type="text" id="location" name="location" placeholder="Enter pick-up location" required>

            <label for="destination">Destination (Drop)</label>
            <input type="text" id="destination" name="destination" placeholder="Enter drop location" required>

            
            </select>

            <label for="payment">Payment Option</label>
            <select id="payment" name="payment" required>
                <option value="">Select Payment Option</option>
                <option value="Bkash">Bkash</option>
                <option value="Nagad">Nagad</option>
                <option value="Others">Others</option>
            </select>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
