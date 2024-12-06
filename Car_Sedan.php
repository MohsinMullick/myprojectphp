<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedan Rental System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 20px;
        }

        .filters {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .filters select, .filters input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filters button {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filters button:hover {
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

        .vehicles {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
    </style>
</head>
<body>
    <h1>Sedan Rental System</h1>
    <form class="filters" method="GET" action="">
        <select name="sort">
            <option value="">Sort by</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
            <option value="year_asc">Year: Old to New</option>
            <option value="year_desc">Year: New to Old</option>
        </select>
        <input type="text" name="search" placeholder="Search by model or year" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Apply</button>
    </form>

    <div class="vehicles">
        <?php
        // Vehicle data array
        $vehicles = [
            ["img" => "../images/Toyota Corolla Altis.jpg", "year" => 2021, "model" => "Toyota Corolla Altis", "price" => 3000, "perMonth" => 150],
            ["img" => "../images/Honda Civic.jpg", "year" => 2020, "model" => "Honda Civic", "price" => 2500, "perMonth" => 120],
            ["img" => "../images/Hyundai Sonata.jpg", "year" => 2022, "model" => "Hyundai Sonata", "price" => 4000, "perMonth" => 200],
            ["img" => "../images/Mazda Axela.jpg", "year" => 2019, "model" => "Mazda Axela", "price" => 2800, "perMonth" => 130],
            ["img" => "../images/Nissan Bluebird.jpg", "year" => 2021, "model" => "Nissan Bluebird", "price" => 3200, "perMonth" => 140],
            ["img" => "../images/Toyota Camry.jpg", "year" => 2021, "model" => "Toyota Camry", "price" => 3200, "perMonth" => 140],
            ["img" => "../images/Honda Insight.jpg", "year" => 2021, "model" => "Honda Insight", "price" => 3200, "perMonth" => 140],
            ["img" => "../images/Toyota Crown.jpg", "year" => 2021, "model" => "Toyota Crown", "price" => 3200, "perMonth" => 140],
        ];

        // Handle filtering and sorting
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $search = strtolower($_GET['search']);
            $vehicles = array_filter($vehicles, function ($vehicle) use ($search) {
                return strpos(strtolower($vehicle['model']), $search) !== false || strpos(strval($vehicle['year']), $search) !== false;
            });
        }

        if (isset($_GET['sort']) && $_GET['sort'] !== '') {
            $sort = $_GET['sort'];
            usort($vehicles, function ($a, $b) use ($sort) {
                if ($sort === 'price_asc') return $a['price'] - $b['price'];
                if ($sort === 'price_desc') return $b['price'] - $a['price'];
                if ($sort === 'year_asc') return $a['year'] - $b['year'];
                if ($sort === 'year_desc') return $b['year'] - $a['year'];
                return 0;
            });
        }

        // Display filtered and sorted vehicles
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
    </div>
</body>
</html>
