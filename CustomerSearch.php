<?php
require 'connect.php';

if (isset($_GET['search_query'])) {
    $search_query = '%' . $conn->real_escape_string($_GET['search_query']) . '%';

    $stmt = $conn->prepare("SELECT User_ID, Name, Email, Phone FROM users WHERE Name LIKE ? OR Email LIKE ? OR Phone LIKE ?");
    $stmt->bind_param("sss", $search_query, $search_query, $search_query);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['User_ID']}</td>
                        <td>{$row['Name']}</td>
                        <td>{$row['Email']}</td>
                        <td>{$row['Phone']}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "No results found.";
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Please provide a search query.";
}
?>


/*
$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $conn->real_escape_string($_GET['search']);
    $searchQuery = " AND (u.Fname LIKE '%$searchTerm%' OR u.Lname LIKE '%$searchTerm%' OR u.Email LIKE '%$searchTerm%' OR u.Phone LIKE '%$searchTerm%' OR u.District LIKE '%$searchTerm%' OR u.Division LIKE '%$searchTerm%')";
}

// SQL query to retrieve employee data with search filtering
$queryCandidate = "SELECT u.UserID, u.Fname, u.Lname, u.Email, u.Phone, u.District, u.Division, u.Register_Date, u.Birth_Date 
                  FROM user_info u 
                  INNER JOIN user_by_type t ON u.UserID = t.UserID
                  WHERE t.User_Type = 'Candidate' $searchQuery";
$resultCandidate = $conn->query($queryCandidate);

// Check and display results
$users = [];
if ($resultCandidate->num_rows > 0) {
    while ($row = $resultCandidate->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    $users = null;
}

// Close the connection
$conn->close();*/
