<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Customer_Login.html"); // Redirect to login page
    exit;
}

echo "<h1>Welcome, " . htmlspecialchars($_SESSION['user_email']) . "!</h1>";
echo "<p>You are successfully logged in.</p>";
echo '<a href="Logout.php">Logout</a>';
?>
