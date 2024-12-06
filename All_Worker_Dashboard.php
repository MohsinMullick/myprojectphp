<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('../images/alc.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #333;
            display: flex;
        }
        .wrapper {
            width: 100%;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            padding-top: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px 20px;
            border-bottom: 1px solid #34495e;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
        }
        .sidebar ul li:hover {
            background-color: #34495e;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
        }
        .main-content header {
            margin-bottom: 20px;
        }
        .cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .card {
            width: 23%;
            padding: 20px;
            background-color: #ecf0f1;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card i {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .card p {
            margin: 0;
        }
        .charts {
            display: flex;
            justify-content: space-between;
        }
        .chart-container {
            width: 48%;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Riderent Worker</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="#">Vehicles</a></li>
                <li><a href="All_Booking_Display.php">Bookings</a></li>
                <li><a href="worker-update.php">Update Information</a></li>
                <li><a href="Logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Welcome, Worker</h1>
                <p>Here's an overview of your platform’s performance</p>
            </header>

            <!-- Data Cards Section -->
            <div class="cards">
                <div class="card card-users">
                    <i class="fa fa-users"></i>
                    <h2 id="total-users">
                        <?php
                        // Example: Replace with actual database values
                        echo 150;
                        ?>
                    </h2>
                    <p>Total Users</p>
                </div>
                <div class="card card-vehicles">
                    <i class="fa fa-car"></i>
                    <h2 id="total-vehicles">
                        <?php
                        echo 45; // Replace with database values
                        ?>
                    </h2>
                    <p>Available Vehicles</p>
                </div>
                <div class="card card-bookings">
                    <i class="fa fa-bookmark"></i>
                    <h2 id="total-bookings">
                        <?php
                        echo 20; // Replace with database values
                        ?>
                    </h2>
                    <p>Current Bookings</p>
                </div>
                <div class="card card-revenue">
                    <i class="fa fa-dollar-sign"></i>
                    <h2 id="total-revenue">
                        <?php
                        echo "$" . number_format(12000, 2); // Replace with database values
                        ?>
                    </h2>
                    <p>Total Revenue</p>
                </div>
            </div>

            <!-- Graphs/Charts Section -->
            <div class="charts">
                <div class="chart-container">
                    <canvas id="users-growth-chart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="revenue-chart"></canvas>
                </div>
            </div>

            <footer>
                <p>&copy; <?php echo date('Y'); ?> Riderent. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // User Growth Chart
        var ctx1 = document.getElementById('users-growth-chart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'User Growth',
                    data: [100, 200, 400, 600, 800, 1200],
                    borderColor: 'rgba(41, 128, 185, 1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });

        // Revenue Chart
        var ctx2 = document.getElementById('revenue-chart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [500, 1500, 2000, 2500, 3000, 4000],
                    backgroundColor: 'rgba(46, 204, 113, 0.6)',
                    borderColor: 'rgba(46, 204, 113, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1200,
                    easing: 'easeInOutBack'
                }
            }
        });
    </script>
</body>
</html>
