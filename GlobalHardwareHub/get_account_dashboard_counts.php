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

// Initialize counts
$total_orders = 0;
$wishlist_items = 0;
$saved_addresses = 0;
$payment_methods = 0;

// 1. Fetch Total Orders Count
$orders_sql = "SELECT COUNT(*) as count FROM orders WHERE user_id = ?";
$orders_stmt = $conn->prepare($orders_sql);
$orders_stmt->bind_param("i", $user_id);
$orders_stmt->execute();
$orders_result = $orders_stmt->get_result();
if ($orders_row = $orders_result->fetch_assoc()) {
    $total_orders = (int)$orders_row['count'];
}
$orders_stmt->close();

// 2. Fetch Wishlist Items Count
$wishlist_sql = "SELECT COUNT(*) as count FROM wishlist WHERE user_id = ?";
$wishlist_stmt = $conn->prepare($wishlist_sql);
$wishlist_stmt->bind_param("i", $user_id);
$wishlist_stmt->execute();
$wishlist_result = $wishlist_stmt->get_result();
if ($wishlist_row = $wishlist_result->fetch_assoc()) {
    $wishlist_items = (int)$wishlist_row['count'];
}
$wishlist_stmt->close();

// 3. Fetch Saved Addresses Count
$addresses_sql = "SELECT COUNT(*) as count FROM user_addresses WHERE user_id = ?";
$addresses_stmt = $conn->prepare($addresses_sql);
$addresses_stmt->bind_param("i", $user_id);
$addresses_stmt->execute();
$addresses_result = $addresses_stmt->get_result();
if ($addresses_row = $addresses_result->fetch_assoc()) {
    $saved_addresses = (int)$addresses_row['count'];
}
$addresses_stmt->close();

// 4. Fetch Payment Methods Count
$payments_sql = "SELECT COUNT(*) as count FROM user_payment_methods WHERE user_id = ?";
$payments_stmt = $conn->prepare($payments_sql);
$payments_stmt->bind_param("i", $user_id);
$payments_stmt->execute();
$payments_result = $payments_stmt->get_result();
if ($payments_row = $payments_result->fetch_assoc()) {
    $payment_methods = (int)$payments_row['count'];
}
$payments_stmt->close();

$conn->close();

// Return success response with counts
echo json_encode([
    "success" => true,
    "counts" => [
        "total_orders" => $total_orders,
        "wishlist_items" => $wishlist_items,
        "saved_addresses" => $saved_addresses,
        "payment_methods" => $payment_methods
    ]
]);
?>