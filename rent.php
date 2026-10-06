<?php

include "config/database.php";

$car_id = $_GET['id'] ?? 0;

// Get selected car
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();

$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    die("Car not found.");
}

// Process booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];

    // Calculate number of rental days
    $start = new DateTime($pickup_date);
    $end = new DateTime($return_date);

    $days = $start->diff($end)->days;

    // Minimum 1 day
    if ($days < 1) {
        $days = 1;
    }

    $total_amount = $days * $car['price_per_day'];

    // Insert customer
    $customer_sql = "INSERT INTO customers
        (name, phone, email, address)
        VALUES (?, ?, ?, ?)";

    $customer_stmt = $conn->prepare($customer_sql);

    $customer_stmt->bind_param(
        "ssss",
        $name,
        $phone,
        $email,
        $address
    );

    $customer_stmt->execute();

    $customer_id = $conn->insert_id;

    // Insert booking
    $booking_sql = "INSERT INTO bookings
        (customer_id, car_id, pickup_date, return_date, total_amount)
        VALUES (?, ?, ?, ?, ?)";

    $booking_stmt = $conn->prepare($booking_sql);

    $booking_stmt->bind_param(
        "iissd",
        $customer_id,
        $car_id,
        $pickup_date,
        $return_date,
        $total_amount
    );

    $booking_stmt->execute();

    // Change car status
    $update_sql = "UPDATE cars
                   SET status = 'Rented'
                   WHERE id = ?";

    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("i", $car_id);
    $update_stmt->execute();

    // Show success message
    $success = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Rent Car</title>

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

<?php if (isset($success)) { ?>

    <div class="success">

        <h1>Booking Successful! 🎉</h1>

        <p>
            <?php echo htmlspecialchars($name); ?>,
            your car has been booked successfully.
        </p>

        <p>
            <strong>Car:</strong>
            <?php echo $car['brand'] . " " . $car['model']; ?>
        </p>

        <p>
            <strong>Total Amount:</strong>
            ₹<?php echo $total_amount; ?>
        </p>

        <br>

        <a href="bookings.php" class="btn">
            View Bookings
        </a>

        <a href="cars.php" class="btn">
            Back to Cars
        </a>

    </div>

<?php } else { ?>


    <h1>Rent This Car</h1>


    <div class="selected-car">

        <h2>
            <?php echo $car['brand'] . " " . $car['model']; ?>
        </h2>

        <p>
            Category:
            <?php echo $car['category']; ?>
        </p>

        <p>
            Price:
            ₹<?php echo $car['price_per_day']; ?> / day
        </p>

    </div>


    <form method="POST">

        <h2>Customer Details</h2>

        <label>Name</label>

        <input
            type="text"
            name="name"
            required
        >


        <label>Phone</label>

        <input
            type="text"
            name="phone"
            required
        >


        <label>Email</label>

        <input
            type="email"
            name="email"
        >


        <label>Address</label>

        <textarea
            name="address"
            rows="3"
        ></textarea>


        <h2>Rental Details</h2>


        <label>Pickup Date</label>

        <input
            type="date"
            name="pickup_date"
            required
        >


        <label>Return Date</label>

        <input
            type="date"
            name="return_date"
            required
        >


        <button
            type="submit"
            class="btn"
        >
            Confirm Rental
        </button>

    </form>

<?php } ?>

</div>

</body>

</html>