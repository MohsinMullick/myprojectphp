<?php
require 'connect.php';

if (isset($_GET['User_ID'])) {
    $user_id = intval($_GET['User_ID']);

    // Fetch user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE User_ID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['First_Name'];
    $last_name = $_POST['Last_Name'];
    $phone_number = $_POST['Phone_Number'];
    $email = $_POST['Email'];
    $house_no = $_POST['House_No'];
    $road_no = $_POST['Road_No'];
    $location = $_POST['Location'];
    $postal_code = $_POST['Postal_Code'];
    $payment_methods = $_POST['Payment_Methods'];

    // Update query
    $update_stmt = $conn->prepare("UPDATE users SET First_Name = ?, Last_Name = ?, Phone_Number = ?, Email = ?, House_No = ?, Road_No = ?, Location = ?, Postal_Code = ?, Payment_Methods = ? WHERE User_ID = ?");
    $update_stmt->bind_param("sssssssssi", $first_name, $last_name, $phone_number, $email, $house_no, $road_no, $location, $postal_code, $payment_methods, $user_id);

    if ($update_stmt->execute()) {
        echo "User updated successfully.";
        header("Location:../CustomerPage.php"); // Redirect to the main page after update
        exit();
    } else {
        echo "Error updating user: " . $conn->error;
    }
    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Update User Information</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="First_Name" class="form-label">First Name</label>
            <input type="text" name="First_Name" id="First_Name" class="form-control" value="<?php echo htmlspecialchars($user['First_Name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="Last_Name" class="form-label">Last Name</label>
            <input type="text" name="Last_Name" id="Last_Name" class="form-control" value="<?php echo htmlspecialchars($user['Last_Name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="Phone_Number" class="form-label">Phone Number</label>
            <input type="text" name="Phone_Number" id="Phone_Number" class="form-control" value="<?php echo htmlspecialchars($user['Phone_Number']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="Email" class="form-label">Email</label>
            <input type="email" name="Email" id="Email" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="House_No" class="form-label">House No</label>
            <input type="text" name="House_No" id="House_No" class="form-control" value="<?php echo htmlspecialchars($user['House_No']); ?>">
        </div>
        <div class="mb-3">
            <label for="Road_No" class="form-label">Road No</label>
            <input type="text" name="Road_No" id="Road_No" class="form-control" value="<?php echo htmlspecialchars($user['Road_No']); ?>">
        </div>
        <div class="mb-3">
            <label for="Location" class="form-label">Location</label>
            <input type="text" name="Location" id="Location" class="form-control" value="<?php echo htmlspecialchars($user['Location']); ?>">
        </div>
        <div class="mb-3">
            <label for="Postal_Code" class="form-label">Postal Code</label>
            <input type="text" name="Postal_Code" id="Postal_Code" class="form-control" value="<?php echo htmlspecialchars($user['Postal_Code']); ?>">
        </div>
        <div class="mb-3">
            <label for="Payment_Methods" class="form-label">Payment Methods</label>
            <input type="text" name="Payment_Methods" id="Payment_Methods" class="form-control" value="<?php echo htmlspecialchars($user['Payment_Methods']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="../CustomerPage.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>