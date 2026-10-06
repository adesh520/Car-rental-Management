<?php

include "config/database.php";

$car_id = $_GET['id'] ?? 0;

// Check if car exists
$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Car not found.");
}

$car = $result->fetch_assoc();

// Don't allow deletion if the car has bookings
$check_sql = "SELECT * FROM bookings WHERE car_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $car_id);
$check_stmt->execute();

$booking_result = $check_stmt->get_result();

if ($booking_result->num_rows > 0) {
    die("This car cannot be deleted because it has booking records.");
}

// Delete car
$delete_sql = "DELETE FROM cars WHERE id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $car_id);

if ($delete_stmt->execute()) {

    header("Location: cars.php");
    exit();

} else {

    echo "Error deleting car: " . $conn->error;

}

?>