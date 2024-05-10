<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .data-table table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #ddd;
        }

        .data-table th, .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .data-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .data-table tr:hover {
            background-color: #f1f1f1;
        }


        .edit-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px 0;
            transition-duration: 0.4s;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-button:hover {
            background-color: #45a049;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .data-table {
            overflow-x: auto;
        }

        .group-header {
            font-size: 18px;
        }

        .group-header .highlight {
            color: #fff;
            background-color: #ADD8E6;
            padding: 4px 8px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Item Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Ready Time</th>
                        <th>Served Time</th>
                        <th>Status</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                <?php
                // Include database connection
                include 'db_connection.php';

                // Fetch data from the order_items table
                $sql = "SELECT * FROM order_items ORDER BY order_id";
                $result = $conn->query($sql);

                // Check if there are any records
                if ($result->num_rows > 0) {
                    // Initialize current order ID and table number variables
                    $currentOrderId = null;
                    $currentTableNumber = null;
                    $currentCustomerName = null;
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        // If current order ID is different from previous row, add group header
                        if ($currentOrderId !== $row["order_id"]) {
                            // Fetch and store the customer name for the group header
                            $customerNameSql = "SELECT customer_name FROM order_items WHERE order_id = " . $row["order_id"] . " LIMIT 1";
                            $customerNameResult = $conn->query($customerNameSql);
                            if ($customerNameResult->num_rows > 0) {
                                $customerNameRow = $customerNameResult->fetch_assoc();
                                $currentCustomerName = $customerNameRow["customer_name"];
                            }
                            // Output the group header with order ID, table number, and customer name
                            echo "<tr class='group-header'><td class='highlight' colspan='9'>Order ID: " . $row["order_id"] . " - Table Number: " . $row["table_number"] . " - Customer Name: " . $currentCustomerName . "</td></tr>"; // Group header
                            $currentOrderId = $row["order_id"];
                            $currentTableNumber = $row["table_number"];
                        }
                            // Output row data
                            echo "<tr>";
                            echo "<td>" . $row["item_name"] . "</td>";
                            echo "<td>" . $row["item_price"] . "</td>";
                            echo "<td>" . $row["quantity"] . "</td>";
                            echo "<td>" . $row["total_price"] . "</td>";
                            echo "<td>" . $row["order_date"] . "</td>"; 
                            echo "<td>" . $row["ready_time"] . "</td>"; // Display Ready Time
                            echo "<td>" . $row["served_time"] . "</td>"; // Display Served Time
                            echo "<td>" . $row["status"] . "</td>"; // Status column
                            // Add an edit button for each row
                            echo "<td><button class='edit-button' onclick='window.location.href=\"edit_order.php?order_id=" . $row["order_id"] . "\"'>Edit</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No items found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    // Function to reload the page after a certain interval (e.g., 5 seconds)
    function reloadPage() {
        location.reload();
    }

    // Call the reloadPage function after 5 seconds (5000 milliseconds)
    setTimeout(reloadPage, 5000);
    </script>
</body>
</html>

<?php

// Close database connection
$conn->close();
?>
