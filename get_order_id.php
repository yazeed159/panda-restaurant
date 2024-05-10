<?php
// Database connection parameters
$servername = "localhost";
$username = "admin"; // Your MySQL username
$password = "admin123"; // Your MySQL password
$dbname = "orders"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
