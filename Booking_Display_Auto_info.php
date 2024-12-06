<?php
// Handle AJAX request for fetching bookings
if (isset($_GET['fetch_bookings'])) {
    $servername = "localhost";
    $username = "root";
    $password = ""; // Your database password
    $dbname = "riderent"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch booking data
    $sql = "SELECT booking_id, user_name, booking_date, booking_status, destination FROM booking ORDER BY booking_date DESC";
    $result = $conn->query($sql);

    $bookings = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }
    $conn->close();

    // Return as JSON response
    echo json_encode($bookings);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bookings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .section {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h3 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f4f4f9;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .no-data {
            text-align: center;
            color: #999;
            font-style: italic;
        }
    </style>
    <script>
        function fetchBookings() {
            fetch('?fetch_bookings=true') // AJAX request to the same file
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#bookingTable tbody');
                    tableBody.innerHTML = ''; // Clear current table rows

                    if (data.length > 0) {
                        data.forEach(booking => {
                            const row = `
                                <tr>
                                    <td>#${booking.booking_id}</td>
                                    <td>${booking.user_name}</td>
                                    <td>${booking.booking_date}</td>
                                    <td>${booking.booking_status}</td>
                                    <td>${booking.destination}</td>
                                </tr>
                            `;
                            tableBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="5" class="no-data">No bookings found</td></tr>';
                    }
                })
                .catch(error => console.error('Error fetching bookings:', error));
        }

        // Automatically refresh bookings every 5 seconds
        setInterval(fetchBookings, 5000);

        // Fetch bookings on page load
        document.addEventListener('DOMContentLoaded', fetchBookings);
    </script>
</head>
<body>
    <div class="section">
        <h3>Recent Bookings</h3>
        <table id="bookingTable">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User Name</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th>Destination</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="5" class="no-data">Loading bookings...</td></tr>
            </tbody>
        </table>
    </div>
</body>
</html>
