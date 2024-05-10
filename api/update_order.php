<?php
// Include database connection
include 'db_connection.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present
    if(isset($_POST['order_id']) && !empty($_POST['order_id']) && isset($_POST['item_id']) && isset($_POST['item_name']) && isset($_POST['item_price']) && isset($_POST['quantity'])) {
        // Sanitize input data
        $order_id = $_POST['order_id'];
        $item_id = $_POST['item_id'];
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        $quantity = $_POST['quantity'];

        // Prepare and execute the SQL statement to update the order details
        $sql = "UPDATE order_items SET item_id=?, item_name=?, item_price=?, quantity=? WHERE order_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issii", $item_id, $item_name, $item_price, $quantity, $order_id);
        if ($stmt->execute()) {
            // Redirect back to admin.php page with success message
            header("Location: admin.php?success=Order updated successfully.");
            exit();
        } else {
            // Redirect back to admin.php page with error message
            header("Location: admin.php?error=Failed to update order. Please try again.");
            exit();
        }
    } else {
        // Redirect back to admin.php page with error message if required fields are missing
        header("Location: admin.php?error=All fields are required.");
        exit();
    }
} else {
    // Redirect back to admin.php page if form data is not submitted
    header("Location: admin.php");
    exit();
}

// Close database connection
$conn->close();
?>
