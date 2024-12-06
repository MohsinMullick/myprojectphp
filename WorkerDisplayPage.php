<?php
// Include database connection
$host = 'localhost';
$dbname = 'riderent';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Add new worker logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_worker'])) {
    // Collect form data
    $user_name = trim($_POST['user_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif (empty($user_name) || empty($phone) || empty($email) || empty($password)) {
        $error_message = "All fields are required.";
    } else {
        // Insert worker into the database
        $query = "INSERT INTO workers (User_Name, Phone, Email, Password) VALUES (:User_Name, :Phone, :Email, :Password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':User_Name', $user_name);
        $stmt->bindParam(':Phone', $phone);
        $stmt->bindParam(':Email', $email);
        $stmt->bindParam(':Password', $password);
        
        if ($stmt->execute()) {
            $success_message = "Worker added successfully!";
        } else {
            $error_message = "Failed to add worker. Please try again.";
        }
    }
}

// Fetch workers for display
$query = "SELECT * FROM workers";
$stmt = $conn->prepare($query);
$stmt->execute();
$workers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Display Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('../images/alc..jpg'); /* Replace with the path to your background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.8); /* Adds a transparent white background to the table */
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        h2 {
            text-align: center;
            color: #333;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.3); /* Optional text shadow for better readability on background */
        }
        .add-button {
            margin-bottom: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-button:hover {
            background-color: #45a049;
        }
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-container input {
            width: 40%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #45a049;
        }
        .worker-form {
            width: 40%;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Transparent background for form */
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .worker-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .worker-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .worker-form button:hover {
            background-color: #45a049;
        }
        .error-message, .success-message {
            color: red;
            text-align: center;
        }
        .success-message {
            color: green;
        }
    </style>
</head>
<body>
    <h2>Worker List</h2>

    <div class="search-container">
        <form action="WorkerDisplayPage.php" method="GET">
            <input type="text" name="search" placeholder="Search by name, phone, or email" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <a class="add-button" href="WorkerDisplayPage.php#add-worker-form">Add New Worker</a>
    
    <!-- Worker Addition Form -->
    <div class="worker-form" id="add-worker-form">
        <h3>Add Worker</h3>
        <?php
        if (isset($error_message)) {
            echo "<div class='error-message'>$error_message</div>";
        }
        if (isset($success_message)) {
            echo "<div class='success-message'>$success_message</div>";
        }
        ?>
        <form method="POST">
            <input type="text" name="user_name" placeholder="Name" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="add_worker">Add Worker</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($workers as $worker) {
                echo "<tr>
                        <td>" . htmlspecialchars($worker['User_Name']) . "</td>
                        <td>" . htmlspecialchars($worker['Phone']) . "</td>
                        <td>" . htmlspecialchars($worker['Email']) . "</td>
                        <td>" . htmlspecialchars($worker['Password']) . "</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
