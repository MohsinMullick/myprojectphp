<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/alc.jpg'); /* Add your image URL or local path */
            background-size: cover;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.8); /* White background with transparency */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
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
        <h2>Register a Vehicle</h2>
        <form action="vehicle.php" method="POST">
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required>

            <label for="license_plate">License Plate:</label>
            <input type="text" id="license_plate" name="license_plate" required>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" required min="1">

            <label for="branch_id">Branch ID:</label>
            <select id="branch_id" name="branch_id" required>
                <option value="">Select Branch</option>
                <!-- PHP code will populate branches -->
                <?php
                // Database connection
                $conn = new mysqli("localhost", "root", "", "riderent");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch branch IDs
                $sql = "SELECT Branch_ID, Branch_Name FROM branch";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['Branch_ID'] . "'>" . $row['Branch_Name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No Branches Available</option>";
                }

                $conn->close();
                ?>
            </select>

            <input type="submit" value="Register Vehicle">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get form data
            $brand = $_POST['brand'];
            $license_plate = $_POST['license_plate'];
            $capacity = $_POST['capacity'];
            $branch_id = $_POST['branch_id'];

            // Create database connection
            $conn = new mysqli("localhost", "root", "", "riderent");

            // Check for connection errors
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Sanitize user inputs to prevent SQL injection
            $brand = $conn->real_escape_string($brand);
            $license_plate = $conn->real_escape_string($license_plate);
            $capacity = (int)$capacity;
            $branch_id = (int)$branch_id;

            // Check if the branch exists
            $check_branch = $conn->prepare("SELECT Branch_ID FROM branch WHERE Branch_ID = ?");
            $check_branch->bind_param("i", $branch_id);
            $check_branch->execute();
            $check_branch->store_result();

            if ($check_branch->num_rows == 0) {
                echo "<p class='message' style='color: red;'>Error: Invalid Branch ID. Please select a valid branch.</p>";
            } else {
                // Prepare the SQL query using a prepared statement
                $sql = "INSERT INTO vehicle (Brand, License_Plate, Capacity, Branch_ID) 
                        VALUES (?, ?, ?, ?)";

                // Initialize prepared statement
                if ($stmt = $conn->prepare($sql)) {
                    // Bind parameters to the query
                    $stmt->bind_param("ssii", $brand, $license_plate, $capacity, $branch_id);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<p class='message'>Vehicle Registered Successfully!</p>";
                    } else {
                        echo "<p class='message' style='color: red;'>Error: " . $stmt->error . "</p>";
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    echo "<p class='message' style='color: red;'>Error preparing query: " . $conn->error . "</p>";
                }
            }

            // Close the database connection
            $check_branch->close();
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
