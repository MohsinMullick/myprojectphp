<?php
session_start();

// Database connection (update with your credentials)
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

// Initialize error message
$error_message = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Check user credentials
        $query = "SELECT User_ID, Password FROM users WHERE Email = :Email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':Email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if (password_verify($password, $user['Password'])) {
                $_SESSION['user_id'] = $user['User_ID']; // Store user ID in session
                header("Location: Car_Booking.php"); // Redirect to the dashboard
                exit();
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/alc.jpg'); /* Add your background image here */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9); /* White background with transparency */
            width: 100%;
            max-width: 400px;
            padding: 20px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: #555;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 0.95rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #007bff;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-btn:hover {
            background: #0056b3;
        }

        .forgot-password {
            text-align: center;
            margin-top: 10px;
            font-size: 0.85rem;
        }

        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Customer Login</h1>
        <?php if ($error_message): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="forgot-password">
            <a href="Customer_Login.php">Forgot Password?</a>
        </div>
    </div>
</body>
</html>
