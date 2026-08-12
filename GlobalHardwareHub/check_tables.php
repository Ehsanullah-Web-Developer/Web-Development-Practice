<?php
session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

$result = [];

// Check orders table
$ordersCheck = $conn->query("SHOW TABLES LIKE 'orders'");
$result['orders_table_exists'] = ($ordersCheck->num_rows > 0) ? 'Yes' : 'No';

if ($ordersCheck->num_rows > 0) {
    // Get orders table columns
    $columns = $conn->query("SHOW COLUMNS FROM orders");
    $cols = [];
    while($col = $columns->fetch_assoc()) {
        $cols[] = $col['Field'];
    }
    $result['orders_columns'] = $cols;
}

// Check order_items table
$itemsCheck = $conn->query("SHOW TABLES LIKE 'order_items'");
$result['order_items_table_exists'] = ($itemsCheck->num_rows > 0) ? 'Yes' : 'No';

echo json_encode($result, JSON_PRETTY_PRINT);
?>