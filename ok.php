<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "riderent");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Update Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $user_name = $_POST['User_Name'];
    $phone = $_POST['Phone'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Hash password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE workers SET User_Name=?, Phone=?, Email=?, Password=? WHERE id=?");
    $stmt->bind_param("ssssi", $user_name, $phone, $email, $hashed_password, $id);
    $stmt->execute();
    $stmt->close();
    $message = "Worker details updated successfully!";
}

// Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM workers WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $message = "Worker deleted successfully!";
}

// Fetch Workers Data
$result = $conn->query("SELECT * FROM workers");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            color: green;
            border: 1px solid green;
            border-radius: 5px;
            background: #eafaf1;
        }

        form {
            display: inline;
        }

        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-update {
            background-color: #3498db;
        }

        .btn-delete {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>
    <h1>Worker Dashboard</h1>

    <?php if (!empty($message)) : ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <form method="POST" action="">
                      
                        <td><input type="text" name="User_Name" value="<?php echo $row['User_Name']; ?>" required></td>
                        <td><input type="text" name="Phone" value="<?php echo $row['Phone']; ?>" required></td>
                        <td><input type="email" name="Email" value="<?php echo $row['Email']; ?>" required></td>
                        <td><input type="password" name="Password" value="<?php echo $row['Password']; ?>" required></td>
                        <td>
 
                            <button type="submit" name="update" class="btn btn-update">Update</button>
                            <button type="submit" name="delete" class="btn btn-delete">Delete</button>
                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
