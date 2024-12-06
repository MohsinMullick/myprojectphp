<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'riderent');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search query
$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $conn->real_escape_string($_GET['search']);
    $searchQuery = " AND (
        u.User_Name LIKE '%$searchTerm%' OR 
        u.Phone LIKE '%$searchTerm%' OR 
        u.Email LIKE '%$searchTerm%' OR 
        u.Password LIKE '%$searchTerm%'
    )";
}

// SQL query to fetch candidates with optional search filtering
$queryCandidate = "
    SELECT 
        u.User_Name AS 'User_Name', 
        u.Phone AS 'Phone', 
        u.Email AS 'Email', 
        u.Password AS 'Password'
    FROM workers u
    WHERE 1=1
    $searchQuery
";

$resultCandidate = $conn->query($queryCandidate);

// Check and display results
if ($resultCandidate->num_rows > 0) {
    while ($row = $resultCandidate->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['User_Name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Phone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Password']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No records found.</td></tr>";
}

// Close the connection
$conn->close();
?>
