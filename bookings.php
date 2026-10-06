<?php

include "config/database.php";

$sql = "SELECT 
            bookings.id,
            customers.name,
            customers.phone,
            cars.brand,
            cars.model,
            cars.registration_no,
            bookings.pickup_date,
            bookings.return_date,
            bookings.total_amount,
            bookings.status
        FROM bookings
        INNER JOIN customers
            ON bookings.customer_id = customers.id
        INNER JOIN cars
            ON bookings.car_id = cars.id
        ORDER BY bookings.id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Bookings</title>

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

    <h1>Rental Bookings</h1>

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Car</th>
                    <th>Registration</th>
                    <th>Pickup</th>
                    <th>Return</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

            <?php while ($booking = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo $booking['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($booking['name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($booking['phone']); ?>
                    </td>

                    <td>
                        <?php
                        echo $booking['brand'] . " "
                           . $booking['model'];
                        ?>
                    </td>

                    <td>
                        <?php echo $booking['registration_no']; ?>
                    </td>

                    <td>
                        <?php echo $booking['pickup_date']; ?>
                    </td>

                    <td>
                        <?php echo $booking['return_date']; ?>
                    </td>

                    <td>
                        ₹<?php echo $booking['total_amount']; ?>
                    </td>

                    <td>
                        <?php echo $booking['status']; ?>
                    </td>

                    <td>

                        <?php if ($booking['status'] == 'Booked') { ?>

                            <a
                                href="return.php?id=<?php echo $booking['id']; ?>"
                                class="return-btn"
                            >
                                Return
                            </a>

                        <?php } else { ?>

                            <span class="returned">
                                Returned
                            </span>

                        <?php } ?>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>