<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

// Database connection
$conn = new mysqli('localhost', 'root', '', 'riderent');

// Check if worker is logged in, else redirect to login page
if (!isset($_SESSION['Worker_ID'])) {
    header('Location: Worker_Login.php');
    exit();
}

// Initialize error/success messages
$message = "";

// Fetch worker details
$worker_id = $_SESSION['Worker_ID'];
$stmt = $conn->prepare("SELECT * FROM workers WHERE Worker_ID = ?");
$stmt->bind_param("i", $worker_id);
$stmt->execute();
$result = $stmt->get_result();
$worker = $result->fetch_assoc();
$stmt->close();

// Handle Update Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Get the form inputs
    $user_name = $_POST['User_Name'];
    $phone = $_POST['Phone'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Debugging: Check if the variables are populated
    echo "<pre>";
    var_dump($user_name, $phone, $email, $password); // Debugging the form data
    echo "</pre>";

    // Validate inputs
    if (empty($user_name) || empty($phone) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    } else {
        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update worker details in the database
        $stmt = $conn->prepare("UPDATE workers SET User_Name = ?, Phone = ?, Email = ?, Password = ? WHERE Worker_ID = ?");
        $stmt->bind_param("ssssi", $user_name, $phone, $email, $hashed_password, $worker_id);
        
        if ($stmt->execute()) {
            $message = "Worker details updated successfully!";
            header("Location:  All_Worker_Dashboard.php");
            exit();
            
        } else {
            $message = "Error: " . $stmt->error; // Display any error that occurs
        }

        $stmt->close();

        // Update session email after update
        $_SESSION['Email'] = $email;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Dashboard</title>
    <style>
        /* Full page background */
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/alc.jpg'); /* Change this to the correct path of your background image */
            background-size: cover;
            background-position: center;
            color: white;
            margin: 0;
            padding: 0;
        }

        /* Center the content */
        .container {
            width: 100%;
            max-width: 600px;
            margin: 100px auto;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background for contrast */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            margin-top: 5px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #4cae4c;
        }

        .message {
            color: yellow;
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-delete {
            background-color: red;
            margin-top: 10px;
        }

        .btn-delete:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($worker['User_Name']); ?></h2>

        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="User_Name">User Name:</label>
                <input type="text" id="User_Name" name="User_Name" value="<?php echo $worker['User_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="Phone">Phone:</label>
                <input type="text" id="Phone" name="Phone" value="<?php echo $worker['Phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" id="Email" name="Email" value="<?php echo $worker['Email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="Password">Password:</label>
                <input type="password" id="Password" name="Password" value="<?php echo $worker['Password']; ?>" required>
            </div>

            <button type="submit" name="update" class="btn">Update</button>
            <button type="submit" name="delete" class="btn btn-delete">Delete Account</button>
        </form>
    </div>

</body>
</html>
