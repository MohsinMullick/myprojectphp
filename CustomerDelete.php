<?php
require 'connect.php';

if (isset($_GET['User_ID'])) {
    $user_id = intval($_GET['User_ID']);
    $stmt = $conn->prepare("DELETE FROM users WHERE User_ID = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    header("Location:../CustomerPage.php"); // Redirect back to the main page
    exit();
}
?>