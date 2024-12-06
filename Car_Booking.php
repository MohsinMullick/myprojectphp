<?php
// PHP code to handle logout functionality
session_start();
if (isset($_GET['logout'])) {
    session_unset();  // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: ../C_v_R.html"); // Redirect to the homepage (or login page)
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Rental System</title>
    <style>
        /* General Reset */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Header Styling */
        header {
            text-align: center;
            background-color: blue;
            color: white;
            padding: 20px 0;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        header p {
            margin: 10px 0 0;
            font-size: 1.2em;
        }

        /* Logout Button Styling */
        .logout-btn {
            margin-left :1580px;
            background-color: red;
            color: white;
            padding: 10px 20px;
            font-size: 1.1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: darkred;
        }

        /* Hero Section Styling */
        .home {
            width: 100%;
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px;
            background: url('../images/alc.jpg') no-repeat center;
            background-size: cover;
            color: white;
        }

        .home .text {
            max-width: 50%;
        }

        .home .text h1 {
            font-size: 3em;
            margin: 0 0 20px;
            line-height: 1.2;
        }

        .home .text p {
            font-size: 1.2em;
            line-height: 1.6;
        }

        /* Form Styling */
        .form-container {
            position: absolute;
            bottom: 2rem;
            left: 100px;
            background: #e61515;
            padding: 20px;
            border-radius: 0.5rem;
        }

        .form-container form {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
        }

        .input-box {
            flex: 1 1 7rem;
            display: flex;
            flex-direction: column;
        }

        .input-box span {
            font-weight: 500;
            margin-bottom: 5px;
            color: white;
        }

        .input-box input {
            padding: 7px;
            outline: none;
            border: none;
            background: #eeeff1;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .form-container .btn {
            flex: 1 1 7rem;
            padding: 10px 20px;
            border: none;
            border-radius: 0.5rem;
            background: #474fa0;
            color: #fff;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
        }

        .form-container .btn:hover {
            background: #333;
        }

        /* Vehicle Categories */
        .category {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            margin: 30px 20px;
        }

        .category-card {
            width: 250px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
            text-decoration: none;
            color: black;
        }

        .category-card:hover {
            transform: scale(1.05);
        }

        .category-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .category-card h2 {
            margin: 0;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.5em;
        }

        /* Footer Styling */
        footer {
            text-align: center;
            padding: 15px;
            background-color: #333;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to the<br> Vehicle Rental System</h1>
        <p>Choose from a variety of vehicles to suit your needs.</p>
        <div>
            <!-- Logout Button -->
            <a href="?logout=true">
                <button class="logout-btn">Logout</button>
            </a>
        </div>
    </header>
    
    <main>
        <!-- Hero Section -->
        <section class="home" id="home">
            <div class="text">
                <h1><span>Looking To</span><br>Rent A Vehicle</h1>
                <p>Choose from a variety of vehicles below that suit your needs!</p>
            </div>

            <!-- Form Section -->
            <div class="form-container">
                <form action="">
                    <div class="input-box">
                        <span>Location</span>
                        <input type="search" name="location" placeholder="Search place">
                    </div>
                    <div class="input-box">
                        <span>Destination</span>
                        <input type="search" name="Destination" placeholder="Search place">
                    </div>
                    <div class="input-box">
                        <span>Pick-Up Date</span>
                        <input type="date" name="pickup_date">
                    </div>
                    <div class="input-box">
                        <span>Return Date</span>
                        <input type="date" name="return_date">
                    </div>
                    <input type="submit" value="Search" class="btn">
                </form>
            </div>
        </section>

        <!-- Vehicle Categories -->
        <div class="category">
            <!-- Sedans Category -->
            <a href="Car_Sedan.php" class="category-card">
                <img src="../images/2.jpg" alt="Car">
                <h2>Sedans</h2>
            </a>

            <!-- Bikes Category -->
            <a href="Car_Bike.php" class="category-card">
                <img src="../images/f1.jpg" alt="Bike">
                <h2>Bikes</h2>
            </a>

            <!-- SUVs Category -->
            <a href="Car_Suv.php" class="category-card">
                <img src="../images/cng.jpg" alt="SUVs">
                <h2>Suvs</h2>
            </a>

            <!-- MiniBus Category -->
            <a href="Car_Mini_Van.php" class="category-card">
                <img src="../images/cng.jpg" alt="MiniVan">
                <h2>MiniVan</h2>
            </a>
        </div>
    </main>

    <footer>
        <p>© 2024 Vehicle Rental System | All Rights Reserved</p>
    </footer>
</body>
</html>
