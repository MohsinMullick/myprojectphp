<?php
require 'connect.php';

if (isset($_GET['User_ID'])) {
    $userID = $_GET['User_ID'];

    // Fetch user details
    $stmt = $conn->prepare("SELECT * FROM users WHERE User_ID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = $_POST['First_Name'];
        $lastName = $_POST['Last_Name'];
        $phone = $_POST['Phone_Number'];
        $email = $_POST['Email'];
        $location = $_POST['Location'];

        // Update user details
        $updateStmt = $conn->prepare("UPDATE users SET First_Name = ?, Last_Name = ?, Phone_Number = ?, Email = ?, Location = ? WHERE User_ID = ?");
        $updateStmt->bind_param("sssssi", $firstName, $lastName, $phone, $email, $location, $userID);

        if ($updateStmt->execute()) {
            echo "<script>alert('Customer updated successfully!'); window.location.href = 'CustomerDisplayPage.php';</script>";
        } else {
            echo "<script>alert('Failed to update customer.');</script>";
        }
    }
} else {
    echo "<script>alert('Invalid User ID!'); window.location.href = 'CustomerDisplayPage.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Center the form on the page */
        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 50px auto;
        }

        /* Label styling */
        label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        /* Input field styling */
        input[type="text"], input[type="email"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Input focus state */
        input[type="text"]:focus, input[type="email"]:focus, input[type="number"]:focus {
            border-color: #80bdff;
            outline: none;
        }

        /* Submit button styling */
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        /* Button hover effect */
        button:hover {
            background-color: #0056b3;
        }

        /* Style for alerts or messages */
        script {
            margin-top: 20px;
            color: #ff0000;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- HTML Form for Updating -->
<form method="POST">
    <label for="First_Name">First Name:</label>
    <input type="text" id="First_Name" name="First_Name" value="<?php echo htmlspecialchars($user['First_Name']); ?>" required>
    
    <label for="Last_Name">Last Name:</label>
    <input type="text" id="Last_Name" name="Last_Name" value="<?php echo htmlspecialchars($user['Last_Name']); ?>" required>
    
    <label for="Phone_Number">Phone Number:</label>
    <input type="text" id="Phone_Number" name="Phone_Number" value="<?php echo htmlspecialchars($user['Phone_Number']); ?>" required>
    
    <label for="Email">Email:</label>
    <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
    
    <label for="Location">Location:</label>
    <input type="text" id="Location" name="Location" value="<?php echo htmlspecialchars($user['Location']); ?>" required>

    <button type="submit">Update</button>
</form>

</body>
</html>
