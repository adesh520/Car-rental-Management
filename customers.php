<?php

include "config/database.php";

$sql = "SELECT * FROM customers ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Customers</title>

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

    <h1>Customers</h1>

    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>

                </tr>

            </thead>

            <tbody>

            <?php while ($customer = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo $customer['id']; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($customer['name']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($customer['phone']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($customer['email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($customer['address']); ?>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>
