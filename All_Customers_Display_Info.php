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
        u.First_Name LIKE '%$searchTerm%' OR 
        u.Last_Name LIKE '%$searchTerm%' OR 
        u.Phone_Number LIKE '%$searchTerm%' OR 
        u.Email LIKE '%$searchTerm%' OR 
        u.Location LIKE '%$searchTerm%' OR 
        u.Road_No LIKE '%$searchTerm%' OR
        u.House_No LIKE '%$searchTerm%' OR
        u.Registration_Date LIKE '%$searchTerm%' OR
        u.Postal_Code LIKE '%$searchTerm%' OR
        u.Payment_Methods LIKE '%$searchTerm%' OR
        u.User_Type LIKE '%$searchTerm%'
    )";
}

// SQL query to fetch candidates with optional search filtering
$queryCandidate = "
    SELECT 
        u.First_Name AS 'First Name', 
        u.Last_Name AS 'Last Name', 
        u.Phone_Number AS 'Phone Number', 
        u.Email, 
        u.User_Type AS 'User Type', 
        u.Registration_Date AS 'Registration Date', 
        u.House_No AS 'House No', 
        u.Road_No AS 'Road No', 
        u.Location AS 'Location', 
        u.Postal_Code AS 'Postal Code', 
        u.Payment_Methods AS 'Payment Methods'
    FROM users u
    WHERE 1=1
    $searchQuery
";

$resultCandidate = $conn->query($queryCandidate);

// Check and display results
if ($resultCandidate->num_rows > 0) {
    while ($row = $resultCandidate->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['First Name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Last Name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Phone Number']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['User Type']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Registration Date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['House No']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Road No']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Location']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Postal Code']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Payment Methods']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='11'>No records found.</td></tr>";
}

// Close the connection
$conn->close();
?>