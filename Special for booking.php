<?php
// Database Connection
$host = 'localhost'; // Database host
$user = 'root';      // Database username
$pass = '';          // Database password
$dbname = 'car_rental'; // Database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch recent bookings
$sql = "SELECT id, user_name, car_model, booking_date, status, destination FROM bookings ORDER BY booking_date DESC LIMIT 5";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        /* Layout */
        .dashboard {
            display: grid;
            grid-template-columns: 250px auto;
            grid-template-rows: 60px auto;
            height: 100vh;
            grid-template-areas:
                "sidebar header"
                "sidebar main";
        }
        /* Sidebar */
        .sidebar {
            grid-area: sidebar;
            background-color: #007bff;
            color: white;
            padding: 20px 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 22px;
        }
        .sidebar a {
            text-decoration: none;
            color: white;
            margin: 10px 0;
            font-size: 16px;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-radius: 4px;
            width: 90%;
            justify-content: left;
            transition: background-color 0.3s;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
            background-color: #0056b3;
        }
        /* Header */
        .header {
            grid-area: header;
            background-color: #0056b3;
            color: white;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 20px;
        }
        .header .profile {
            display: flex;
            align-items: center;
        }
        .header .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        /* Main Content */
        .main {
            grid-area: main;
            padding: 20px;
            overflow-y: auto;
        }
        .main h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .card h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }
        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        thead {
            background-color: #007bff;
            color: white;
        }
        thead th {
            text-align: left;
            padding: 10px;
        }
        tbody tr {
            border-bottom: 1px solid #ccc;
        }
        tbody td {
            padding: 10px;
        }
        tbody tr:nth-child(even) {
            background-color: #f4f4f9;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Car Rental</h2>
            <a href="#"><i class="bx bx-home"></i> Dashboard</a>
            <a href="#"><i class="bx bx-car"></i> Manage Cars</a>
            <a href="#"><i class="bx bx-user"></i> Customers</a>
            <a href="#"><i class="bx bx-user"></i> Workers</a>
            <a href="#"><i class="bx bx-calendar"></i> Bookings</a>
            <a href="#"><i class="bx bx-bar-chart"></i> Reports</a>
            <a href="#"><i class="bx bx-cog"></i> Settings</a>
            <a href="#"><i class="bx bx-log-out"></i> Logout</a>
        </div>

        <!-- Header -->
        <div class="header">
            <h1>Car Rental Dashboard</h1>
            <div class="profile">
                <img src="images/Mohsin.jpg" alt="Admin Profile">
                <span>Admin</span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main">
            <h2>Welcome, Admin</h2>
            <div class="cards">
                <div class="card">
                    <h3>Total Cars</h3>
                    <p>120</p>
                </div>
                <div class="card">
                    <h3>Total Customers</h3>
                    <p>560</p>
                </div>
                <div class="card">
                    <h3>Active Bookings</h3>
                    <p>45</p>
                </div>
                <div class="card">
                    <h3>Total Revenue</h3>
                    <p>$25,340</p>
                </div>
            </div>

            <div class="section">
                <h3>Recent Bookings</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>User Name</th>
                            <th>Car Model</th>
                            <th>Booking Date</th>
                            <th>Booking Status</th>
                            <th>Destination</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>#{$row['id']}</td>";
                                echo "<td>{$row['user_name']}</td>";
                                echo "<td>{$row['car_model']}</td>";
                                echo "<td>{$row['booking_date']}</td>";
                                echo "<td>{$row['status']}</td>";
                                echo "<td>{$row['destination']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No bookings found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>
