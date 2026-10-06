<?php

include "config/database.php";

$sql = "SELECT * FROM cars ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cars</title>

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


<div class="page">

    <div class="page-header">

        <h1>Car Management</h1>

        <a href="add_car.php" class="btn">
            + Add New Car
        </a>

    </div>


    <div class="cars-container">

        <?php while ($car = $result->fetch_assoc()) { ?>

            <div class="car-card">

                <h2>
                    <?php
                    echo htmlspecialchars(
                        $car['brand'] . " " . $car['model']
                    );
                    ?>
                </h2>


                <p>
                    <strong>Registration:</strong>
                    <?php echo htmlspecialchars($car['registration_no']); ?>
                </p>


                <p>
                    <strong>Category:</strong>
                    <?php echo htmlspecialchars($car['category']); ?>
                </p>


                <p>
                    <strong>Price:</strong>
                    ₹<?php echo $car['price_per_day']; ?> / day
                </p>


                <p>
                    <strong>Status:</strong>

                    <?php if ($car['status'] == 'Available') { ?>

                        <span class="available">
                            Available
                        </span>

                    <?php } else { ?>

                        <span class="rented">
                            Rented
                        </span>

                    <?php } ?>

                </p>


                <div class="car-actions">

                    <?php if ($car['status'] == 'Available') { ?>

                        <a
                            href="rent.php?id=<?php echo $car['id']; ?>"
                            class="btn"
                        >
                            Rent
                        </a>

                    <?php } else { ?>

                        <button class="disabled">
                            Rented
                        </button>

                    <?php } ?>


                    <a
                        href="delete_car.php?id=<?php echo $car['id']; ?>"
                        class="delete-btn"
                        onclick="return confirm('Are you sure you want to delete this car?');"
                    >
                        Delete
                    </a>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

</body>

</html>