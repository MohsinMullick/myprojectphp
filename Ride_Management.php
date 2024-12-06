<?php
$host = "localhost";
$user = "root"; // Change as per your database setup
$password = "";
$database = "riderent";

// Connect to the database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if (isset($_POST['add'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $destination = $_POST['destination'];
    $gender = $_POST['gender'];

    $sql = "INSERT INTO ride_management (User_ID, Name, Location, Destination, Gender) VALUES ('$user_id', '$name', '$location', '$destination', '$gender')";
    $conn->query($sql);
}

// Handle delete action
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $sql = "DELETE FROM ride_management WHERE User_ID='$user_id'";
    $conn->query($sql);
}

// Fetch all rides
$sql = "SELECT * FROM ride_management";
$result = $conn->query($sql);

// Display data in table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['User_ID']}</td>
                <td>{$row['Name']}</td>
                <td>{$row['Location']}</td>
                <td>{$row['Destination']}</td>
                <td>{$row['Gender']}</td>
                <td>
                    <a href='?delete={$row['User_ID']}' class='btn'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No rides found</td></tr>";
}

$conn->close();
?>
