<?php
// Array to store vehicle details
$vehicles = [
    [
        "image" => "images/Yamaha MT15jpg.jpg",
        "alt" => "Yamaha MT15",
        "year" => "2021",
        "model" => "Yamaha MT15",
        "price" => "$3,000",
        "per_month" => "$150/month"
    ],
    [
        "image" => "images/Yamaha FZ.jpg",
        "alt" => "Yamaha FZ",
        "year" => "2020",
        "model" => "Yamaha FZ",
        "price" => "$2,500",
        "per_month" => "$120/month"
    ],
    [
        "image" => "images/Yamaha R15.jpg",
        "alt" => "Yamaha R15",
        "year" => "2022",
        "model" => "Yamaha R15",
        "price" => "$4,000",
        "per_month" => "$200/month"
    ],
    [
        "image" => "images/Suzuki GIXXER.jpg",
        "alt" => "Suzuki GIXXER",
        "year" => "2019",
        "model" => "Suzuki GIXXER",
        "price" => "$2,800",
        "per_month" => "$130/month"
    ],
    [
        "image" => "images/Suzuki Gixxer SF.jpg",
        "alt" => "Suzuki Gixxer SF",
        "year" => "2021",
        "model" => "Suzuki Gixxer SF",
        "price" => "$3,200",
        "per_month" => "$140/month"
    ]
];

// Loop through the vehicles and output their details
foreach ($vehicles as $vehicle): ?>
    <div class="box">
        <div class="box-img">
            <img src="<?php echo $vehicle['image']; ?>" alt="<?php echo $vehicle['alt']; ?>">
        </div>
        <p class="year"><?php echo $vehicle['year']; ?></p>
        <h3 class="model"><?php echo $vehicle['model']; ?></h3>
        <h2 class="price"><?php echo $vehicle['price']; ?> | 
            <span class="per-month"><?php echo $vehicle['per_month']; ?></span>
        </h2>
        <a href="#" class="btn">Rent Now</a>
    </div>
<?php endforeach; ?>
