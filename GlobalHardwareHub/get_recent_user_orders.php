<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch recent 5 orders for logged-in user
$sql = "SELECT order_id, created_at, status, total_amount 
        FROM orders 
        WHERE user_id = ? 
        ORDER BY created_at DESC 
        LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = [
        "order_id" => (int)$row['order_id'],
        "date" => $row['created_at'],
        "status" => $row['status'],
        "total_amount" => (float)$row['total_amount']
    ];
}

$stmt->close();
$conn->close();

// Return success response with orders
echo json_encode([
    "success" => true,
    "orders" => $orders
]);
?>