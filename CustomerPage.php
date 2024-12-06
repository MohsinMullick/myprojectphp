<?php
require 'All_Php_Files/connect.php';

// Search query
$searchQuery = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";
    $searchQuery = "WHERE First_Name LIKE ?  OR House_No LIKE ? OR Email LIKE ? OR Location LIKE ?";
    $stmt = $conn->prepare("SELECT * FROM users $searchQuery");
    $stmt->bind_param("ssss", $search, $search, $search,$search,);
} else {
    $stmt = $conn->prepare("SELECT * FROM users");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f2f2f2;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .add-button {
            margin-bottom: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-button:hover {
            background-color: #45a049;
        }
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-container input {
            width: 40%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #45a049;
        }
    </style>

</head>
<body>
<div class="container mt-5">
    <!-- <h2 class="text-center">Manage Users</h2> -->

    <!-- Search Bar -->
    <!-- <form method="GET" action="" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Name, Email, or Location">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form> -->
    <h2>Manage Customer List</h2>
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search....." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <a class="add-button" href="CustomerAddPage.html">Add New Customer</a>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Registration Date</th>
                <th>House No</th>
                <th>Road No</th>
                <th>Location</th>
                <th>Postal Code</th>
                <th>Payment Methods</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
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
                                <a href='All_Php_Files/CustomerUpdatePage.php?User_ID=" . $row['User_ID'] . "' class='btn btn-primary'>Update</a>
                             
                                <a href='All_Php_Files/CustomerDelete.php?User_ID=" . $row['User_ID'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>