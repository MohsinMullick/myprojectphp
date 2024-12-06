<?php
// Handle AJAX request for fetching payments
if (isset($_GET['fetch_payments'])) {
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

    // Fetch payment data
    $sql = "SELECT payment_id, worker_id, worker_name, payment_date, amount, payment_status FROM worker_payments ORDER BY payment_date DESC";
    $result = $conn->query($sql);

    $payments = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }
    }
    $conn->close();

    // Return as JSON response
    echo json_encode($payments);
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $worker_id = $_POST['worker_id'];
    $worker_name = $_POST['worker_name'];
    $payment_date = $_POST['payment_date'];
    $amount = $_POST['amount'];
    $payment_status = $_POST['payment_status'];

    $conn = new mysqli("localhost", "root", "", "riderent");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO payments (worker_id, worker_name, payment_date, amount, payment_status) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("issss", $worker_id, $worker_name, $payment_date, $amount, $payment_status);
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Payment recorded successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Error preparing query: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker/Driver Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .form-section, .table-section {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        h3 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #444;
        }
        .input-box {
            margin-bottom: 15px;
        }
        .input-box label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .input-box input, .input-box select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #2980b9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f4f4f9;
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
        }
    </style>
    <script>
        function fetchPayments() {
            fetch('?fetch_payments=true')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#paymentTable tbody');
                    tableBody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(payment => {
                            const row = `
                                <tr>
                                    <td>#${payment.payment_id}</td>
                                    <td>${payment.worker_id}</td>
                                    <td>${payment.worker_name}</td>
                                    <td>${payment.payment_date}</td>
                                    <td>${payment.amount}</td>
                                    <td>${payment.payment_status}</td>
                                </tr>
                            `;
                            tableBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="6" class="no-data">No payments found</td></tr>';
                    }
                })
                .catch(error => console.error('Error fetching payments:', error));
        }

        // Fetch payments on page load
        document.addEventListener('DOMContentLoaded', fetchPayments);
    </script>
</head>
<body>
    <div class="form-section">
        <h3>Record Payment</h3>
        <form method="POST">
            <div class="input-box">
                <label for="worker_id">Worker ID</label>
                <input type="number" name="worker_id" id="worker_id" required>
            </div>
            <div class="input-box">
                <label for="worker_name">Worker Name</label>
                <input type="text" name="worker_name" id="worker_name" required>
            </div>
            <div class="input-box">
                <label for="payment_date">Payment Date</label>
                <input type="date" name="payment_date" id="payment_date" required>
            </div>
            <div class="input-box">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" required>
            </div>
            <div class="input-box">
                <label for="payment_status">Payment Status</label>
                <select name="payment_status" id="payment_status" required>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Record Payment</button>
        </form>
    </div>

    <div class="table-section">
        <h3>Payment Records</h3>
        <table id="paymentTable">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Worker ID</th>
                    <th>Worker Name</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="6" class="no-data">Loading payments...</td></tr>
            </tbody>
        </table>
    </div>
</body>
</html>
