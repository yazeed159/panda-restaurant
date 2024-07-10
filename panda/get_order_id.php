<?php
date_default_timezone_set('Africa/Cairo');
// Include db_connection.php for database connection
include 'db_connection.php';

// Query to get the last inserted order ID
$sql = "SELECT MAX(order_id) AS max_order_id FROM checkout";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $order_id = $row["max_order_id"];
    echo $order_id; // Output the last inserted order ID
} else {
    echo "No orders found";
}

$conn->close();
?>
