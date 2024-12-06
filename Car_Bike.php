<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Rental System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .filter-form {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-form input,
        .filter-form select,
        .filter-form button {
            padding: 10px;
            font-size: 16px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-form button {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #2980b9;
        }

        .box {
            width: 300px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .box:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .box-img img {
            width: 100%;
            height: auto;
        }

        .year {
            color: #888;
            font-size: 14px;
            margin: 10px 0;
        }

        .model {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
            color: #333;
        }

        .price {
            font-size: 18px;
            color: #e74c3c;
            margin: 10px 0;
        }

        .price .per-month {
            font-size: 14px;
            color: #666;
        }

        .btn {
            display: inline-block;
            margin: 15px 0 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <!-- Filter and Sort Form -->
    <form method="GET" class="filter-form">
        <input type="text" name="search" placeholder="Search by model" value="<?php echo $_GET['search'] ?? ''; ?>">
        <select name="sort">
            <option value="asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'asc') echo 'selected'; ?>>Price: Low to High</option>
            <option value="desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'desc') echo 'selected'; ?>>Price: High to Low</option>
        </select>
        <button type="submit">Apply</button>
    </form>

    <?php
    // Vehicle data array
    $vehicles = [
        ["img" => "../images/Yamaha MT15jpg.jpg", "year" => 2021, "model" => "Yamaha MT15", "price" => 3000, "perMonth" => 150],
        ["img" => "../images/Yamaha FZ.jpg", "year" => 2020, "model" => "Yamaha FZ", "price" => 2500, "perMonth" => 120],
        ["img" => "../images/Yamaha R15.jpg", "year" => 2022, "model" => "Yamaha R15", "price" => 4000, "perMonth" => 200],
        ["img" => "../images/Suzuki GIXXER.jpg", "year" => 2019, "model" => "Suzuki GIXXER", "price" => 2800, "perMonth" => 130],
        ["img" => "../images/Suzuki Gixxer SF.jpg", "year" => 2021, "model" => "Suzuki Gixxer SF", "price" => 3200, "perMonth" => 140],
        ["img" => "../images/Yamaha FZ x.jpg", "year" => 2021, "model" => "Yamaha FZ X", "price" => 3200, "perMonth" => 140],
        ["img" => "../images/Honda SP.jpg", "year" => 2021, "model" => "Honda SP", "price" => 3200, "perMonth" => 140],
        ["img" => "../images/Honda CX.jpg", "year" => 2021, "model" => "Honda CX", "price" => 3200, "perMonth" => 140],
    ];

    // Get filter and sort values
    $search = $_GET['search'] ?? '';
    $sort = $_GET['sort'] ?? 'asc';

    // Filter vehicles by search query
    if ($search) {
        $vehicles = array_filter($vehicles, function ($vehicle) use ($search) {
            return stripos($vehicle['model'], $search) !== false;
        });
    }

    // Sort vehicles by price
    usort($vehicles, function ($a, $b) use ($sort) {
        return $sort === 'asc' ? $a['price'] - $b['price'] : $b['price'] - $a['price'];
    });

    // Loop through each vehicle and display it
    foreach ($vehicles as $vehicle) {
        echo "
        <div class='box'>
            <div class='box-img'>
                <img src='{$vehicle['img']}' alt='{$vehicle['model']}'>
            </div>
            <p class='year'>{$vehicle['year']}</p>
            <h3 class='model'>{$vehicle['model']}</h3>
            <h2 class='price'>\${$vehicle['price']} | \${$vehicle['perMonth']}<span class='per-month'>/month</span></h2>
            <a href='Booking.php' class='btn'>Rent Now</a>
        </div>";
    }
    ?>
</body>
</html>
