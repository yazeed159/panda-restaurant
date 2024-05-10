<?php
// Include database connection
include 'db_connection.php';

// Check if order_id is provided in the URL
if(isset($_GET['order_id']) && !empty($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details from the database based on order_id
    $sql = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if order exists
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        // Assign values to variables
        $item_name = $order['item_name'];
        $item_price = $order['item_price'];
        $quantity = $order['quantity'];
        $status = $order['status']; // Assuming 'status' is a column in your order_items table
    } else {
        echo "Order not found.";
    }

    // Close prepared statement
    $stmt->close();
} else {
    echo "Order ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Order</h1>
        <form action="update_order.php" method="POST">
            <!-- Add form fields to edit order details -->
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <label for="item_name">Item Name:</label>
            <input type="text" name="item_name" value="<?php echo $item_name; ?>">
            <label for="item_price">Item Price:</label>
            <input type="text" name="item_price" value="<?php echo $item_price; ?>">
            <label for="quantity">Quantity:</label>
            <input type="text" name="quantity" value="<?php echo $quantity; ?>">
            <label for="status">Status:</label> <!-- New field: Status -->
            <input type="text" name="status" value="<?php echo $status; ?>"> <!-- New field: Status -->
            <!-- Add more fields as needed -->
            <input type="submit" value="Update Order">
        </form>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
