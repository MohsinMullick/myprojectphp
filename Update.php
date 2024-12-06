
    <?php
session_start();
require 'connect.php';

// Initialize variables
$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Assuming user ID is stored in session
$newUserID = isset($_POST['user_id']) ? $_POST['user_id'] : null;

// Fetch employee-specific info if userID is set
if ($userID) {
    $sql = "SELECT * FROM users WHERE User_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $newUserID) {
    // Check for existing User_ID
    $checkSQL = "SELECT User_ID FROM users WHERE User_ID = ? AND User_ID != ?";
    $checkStmt = $conn->prepare($checkSQL);
    $checkStmt->bind_param("ii", $newUserID, $userID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('User ID already exists. Please choose a different ID.');</script>";
    } else {
        // Update User_ID
        $updateSQL = "UPDATE users SET User_ID = ? WHERE User_ID = ?";
        $updateStmt = $conn->prepare($updateSQL);
        $updateStmt->bind_param("ii", $newUserID, $userID);

        if ($updateStmt->execute()) {
            header("Location: Update.php?update_status=success");
            exit;
        } else {
            echo "<script>alert('Failed to update employee information!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Update User ID:</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" 
                   value="<?php echo htmlspecialchars(isset($employee['User_ID']) ? $employee['User_ID'] : ''); ?>" 
                   class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
