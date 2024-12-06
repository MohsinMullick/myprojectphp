<?php
// Include database connection
include 'connect.php';

// Default SQL query
$query = "SELECT * FROM cars";

// Filter and sorting logic
if (isset($_GET['search']) || isset($_GET['sort'])) {
    $search = $_GET['search'] ?? '';
    $sort = $_GET['sort'] ?? 'asc';

    // Update query with filters
    $query = "SELECT * FROM cars WHERE name LIKE '%$search%' ORDER BY salary $sort";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Car List</h1>
        <form method="GET" action="index.php" class="filter-form">
            <input type="text" name="search" placeholder="Search by car name" value="<?php echo $_GET['search'] ?? ''; ?>">
            <select name="sort">
                <option value="asc" <?php if (($_GET['sort'] ?? '') == 'asc') echo 'selected'; ?>>Sort by Salary: Low to High</option>
                <option value="desc" <?php if (($_GET['sort'] ?? '') == 'desc') echo 'selected'; ?>>Sort by Salary: High to Low</option>
            </select>
            <button type="submit">Apply</button>
        </form>

        <table class="car-list">
            <thead>
                <tr>
                    <th>Car Name</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['salary']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
