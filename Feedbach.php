<?php
$host = "localhost";
$user = "root"; // Change if necessary
$password = "";
$database = "riderent";

// Connect to the database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if (isset($_POST['submit'])) {
    $rating = $_POST['rating'];
    $comments = $conn->real_escape_string($_POST['comments']);
    $feedback_date = $_POST['feedback_date'];

    $sql = "INSERT INTO feedback (Rating, Comments, Feedback_Date) VALUES ('$rating', '$comments', '$feedback_date')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Feedback added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding feedback: " . $conn->error . "');</script>";
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM feedback WHERE id='$id'";
    $conn->query($sql);
}

// Fetch all feedback
$sql = "SELECT * FROM feedback ORDER BY Feedback_Date DESC";
$result = $conn->query($sql);

// Display feedback in table rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['Rating']}</td>
                <td>{$row['Comments']}</td>
                <td>{$row['Feedback_Date']}</td>
                <td>
                   
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No feedback found</td></tr>";
}

$conn->close();
?>
