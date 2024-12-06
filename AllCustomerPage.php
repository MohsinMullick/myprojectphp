<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-control {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-add {
            background-color: #28a745;
        }
        .btn-edit {
            background-color: #ffc107;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-search {
            background-color: #007bff;
        }
        .btn-submit {
            background-color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: left;
            padding: 10px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Customer Management</h1>

        <!-- Add Customer Form -->
        <form method="POST" action="All_Php_Files/CustomerUpdatePage.php">
            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
            <input type="text" name="phone" class="form-control" placeholder="Enter Phone" required>
            <button type="submit" name="add" class="btn btn-add">Add Customer</button>
        </form>

        <!-- Search Customer Form -->
        <form method="GET" action="All_Php_Files/CustomerSearch.php">
            <input type="text" name="search" class="form-control" placeholder="Search by Name or Email">
            <button type="submit" class="btn btn-search">Search</button>
        </form>

        <!-- Customer List -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'CustomerPage.php';

                // Search functionality
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $query = "SELECT * FROM customers WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td>
                                <a href='edit.php?id={$row['id']}' class='btn btn-edit'>Edit</a>
                                <a href='delete.php?id={$row['id']}' class='btn btn-delete'>Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
