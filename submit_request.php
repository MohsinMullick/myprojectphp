<?php
$conn = new mysqli('localhost', 'root', '', 'riderent');
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'];
    $request_details = $_POST['request_details'];

    $stmt = $conn->prepare("INSERT INTO car_requests (car_id, request_details, status) VALUES (?, ?, 'Pending')");
    $stmt->bind_param("ss", $car_id, $request_details);

    if ($stmt->execute()) {
        echo "<script>alert('Request submitted successfully!'); window.location.href = 'aaaaaaaaaa.html';</script>";
    } else {
        echo "<script>alert('Failed to submit the request. Please try again.'); window.location.href = 'submit_request.html.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
