<?php

include "config/database.php";

$booking_id = $_GET['id'] ?? 0;

// Get booking and car information
$sql = "SELECT car_id
        FROM bookings
        WHERE id = ? AND status = 'Booked'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Booking not found or already returned.");
}

$booking = $result->fetch_assoc();

$car_id = $booking['car_id'];

// Change booking status
$update_booking = "UPDATE bookings
                   SET status = 'Returned'
                   WHERE id = ?";

$stmt = $conn->prepare($update_booking);
$stmt->bind_param("i", $booking_id);
$stmt->execute();

// Make car available again
$update_car = "UPDATE cars
               SET status = 'Available'
               WHERE id = ?";

$stmt = $conn->prepare($update_car);
$stmt->bind_param("i", $car_id);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Car Returned</title>

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

    <div class="success">

        <h1>Car Returned Successfully! 🚗</h1>

        <p>
            The booking has been marked as returned.
        </p>

        <p>
            The car is now available for rent again.
        </p>

        <br>

        <a href="bookings.php" class="btn">
            Back to Bookings
        </a>

        <a href="cars.php" class="btn">
            View Cars
        </a>

    </div>

</div>

</body>

</html>