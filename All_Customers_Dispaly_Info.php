<?php
require 'connect.php';

// Handle search if needed
$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";
    $searchQuery = "WHERE First_Name LIKE ? OR Email LIKE ? OR Location LIKE ?";
    $stmt = $conn->prepare("SELECT * FROM users $searchQuery");
    $stmt->bind_param("sss", $search, $search, $search);
} else {
    $stmt = $conn->prepare("SELECT * FROM users");
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['First_Name']) . "</td>
                <td>" . htmlspecialchars($row['Last_Name']) . "</td>
                <td>" . htmlspecialchars($row['Phone_Number']) . "</td>
                <td>" . htmlspecialchars($row['Email']) . "</td>
              
                <td>" . htmlspecialchars($row['Registration_Date']) . "</td>
                <td>" . htmlspecialchars($row['House_No']) . "</td>
                <td>" . htmlspecialchars($row['Road_No']) . "</td>
                <td>" . htmlspecialchars($row['Location']) . "</td>
                <td>" . htmlspecialchars($row['Postal_Code']) . "</td>
                <td>" . htmlspecialchars($row['Payment_Methods']) . "</td>
                <td>
                    <a href='CustomerUpdatePage.php?User_ID=" . $row['User_ID'] . "' class='btn btn-primary'>Update</a>
                    <a href='CustomerDelete.php?User_ID=" . $row['User_ID'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>Delete</a>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='12'>No records found.</td></tr>";
}

$stmt->close();
$conn->close();
?>