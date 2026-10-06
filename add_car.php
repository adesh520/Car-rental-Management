<?php

include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $registration_no = $_POST['registration_no'];
    $category = $_POST['category'];
    $price_per_day = $_POST['price_per_day'];

    $sql = "INSERT INTO cars
            (brand, model, registration_no, category, price_per_day)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssd",
        $brand,
        $model,
        $registration_no,
        $category,
        $price_per_day
    );

    if ($stmt->execute()) {
        $message = "Car added successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Car</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<nav>

    <div class="logo">
        CAR RENTAL
    </div>

    <div class="nav-links">

        <a href="index.php">Home</a>
        <a href="cars.php">Cars</a>
        <a href="customers.php">Customers</a>
        <a href="bookings.php">Bookings</a>

    </div>

</nav>

<div class="form-container">

    <h1>Add New Car</h1>

    <?php if ($message != "") { ?>

        <p class="success-message">
            <?php echo $message; ?>
        </p>

    <?php } ?>

    <form method="POST">

        <label>Brand</label>

        <input
            type="text"
            name="brand"
            placeholder="e.g. Toyota"
            required
        >


        <label>Model</label>

        <input
            type="text"
            name="model"
            placeholder="e.g. Fortuner"
            required
        >


        <label>Registration Number</label>

        <input
            type="text"
            name="registration_no"
            placeholder="e.g. MH12AB1234"
            required
        >


        <label>Category</label>

        <select name="category" required>

            <option value="">Select Category</option>

            <option value="SUV">SUV</option>

            <option value="Sedan">Sedan</option>

            <option value="Hatchback">Hatchback</option>

            <option value="Luxury">Luxury</option>

        </select>


        <label>Price Per Day (₹)</label>

        <input
            type="number"
            name="price_per_day"
            min="1"
            step="0.01"
            placeholder="e.g. 2500"
            required
        >


        <button
            type="submit"
            class="btn"
        >
            Add Car
        </button>

    </form>

</div>

</body>

</html>