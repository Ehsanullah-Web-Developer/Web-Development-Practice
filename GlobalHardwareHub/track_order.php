<?php
/**
 * track_order.php
 * API for tracking orders - Returns order details with simulated timeline
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

// Helper function
function sendResponse($success, $data = null, $message = null) {
    $response = ['success' => $success];
    if ($data) $response = array_merge($response, $data);
    if ($message) $response['message'] = $message;
    echo json_encode($response);
    exit;
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please login first');
}

$userId = $_SESSION['user_id'];
$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

if ($orderId <= 0) {
    sendResponse(false, null, 'Invalid order ID');
}

// Fetch order and verify ownership
$orderSql = "SELECT order_id, total_amount, payment_method, status, created_at, shipping_address_id 
             FROM orders 
             WHERE order_id = ? AND user_id = ?";
$stmt = $conn->prepare($orderSql);
$stmt->bind_param('ii', $orderId, $userId);
$stmt->execute();
$orderResult = $stmt->get_result();

if ($orderResult->num_rows === 0) {
    $stmt->close();
    sendResponse(false, null, 'Order not found');
}

$order = $orderResult->fetch_assoc();
$stmt->close();

// Helper functions for random dates
function addHours($date, $min, $max) {
    $hours = rand($min, $max);
    return date('Y-m-d H:i:s', strtotime($date) + ($hours * 3600));
}

function addDays($date, $min, $max) {
    $days = rand($min, $max);
    return date('Y-m-d H:i:s', strtotime($date) + ($days * 86400));
}

// Generate timeline based on order status
$createdAt = $order['created_at'];
$status = strtolower($order['status']);

$timeline = [
    'ordered' => ['status' => 'completed', 'datetime' => $createdAt],
    'confirmed' => ['status' => $status === 'cancelled' ? 'cancelled' : 'completed', 'datetime' => addHours($createdAt, 2, 10)],
    'shipped' => ['status' => in_array($status, ['pending', 'cancelled']) ? ($status === 'cancelled' ? 'cancelled' : 'pending') : 'completed', 'datetime' => in_array($status, ['pending', 'cancelled']) ? null : addDays($createdAt, 2, 3)],
    'out_for_delivery' => ['status' => in_array($status, ['pending', 'processing', 'cancelled']) ? ($status === 'cancelled' ? 'cancelled' : 'pending') : 'completed', 'datetime' => in_array($status, ['pending', 'processing', 'cancelled']) ? null : addDays(addDays($createdAt, 2, 3), 1, 2)],
    'delivered' => ['status' => $status === 'delivered' ? 'completed' : ($status === 'cancelled' ? 'cancelled' : 'pending'), 'datetime' => $status === 'delivered' ? addHours(addDays(addDays($createdAt, 2, 3), 1, 2), 4, 10) : null]
];

// Estimated delivery
$estimatedDelivery = $status === 'delivered' ? null : addDays(addDays($createdAt, 2, 3), 3, 5);

// Get shipping address
$shippingAddress = null;
if ($order['shipping_address_id'] > 0) {
    $addrSql = "SELECT address_line1, address_line2, city, state, postal_code, country FROM user_addresses WHERE address_id = ?";
    $addrStmt = $conn->prepare($addrSql);
    $addrStmt->bind_param('i', $order['shipping_address_id']);
    $addrStmt->execute();
    $addrResult = $addrStmt->get_result();
    $shippingAddress = $addrResult->fetch_assoc();
    $addrStmt->close();
}

// Get order items with product images
$items = [];
$itemSql = "SELECT oi.product_id, oi.quantity, oi.price, p.name as product_name,
            (SELECT image_url FROM product_images WHERE product_id = p.product_id ORDER BY sort_order ASC LIMIT 1) as image_url
            FROM order_items oi
            INNER JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = ?";
$itemStmt = $conn->prepare($itemSql);
$itemStmt->bind_param('i', $orderId);
$itemStmt->execute();
$itemResult = $itemStmt->get_result();

while ($row = $itemResult->fetch_assoc()) {
    $items[] = [
        'product_id' => (int)$row['product_id'],
        'product_name' => $row['product_name'],
        'image_url' => $row['image_url'] ?? 'placeholder.jpg',
        'quantity' => (int)$row['quantity'],
        'price' => (float)$row['price'],
        'subtotal' => (float)($row['price'] * $row['quantity'])
    ];
}
$itemStmt->close();

$conn->close();

// Final response
sendResponse(true, [
    'order' => [
        'order_id' => (int)$order['order_id'],
        'order_date' => $order['created_at'],
        'payment_method' => $order['payment_method'] ?? 'N/A',
        'total_amount' => (float)$order['total_amount'],
        'status' => $order['status']
    ],
    'timeline' => $timeline,
    'estimated_delivery' => $estimatedDelivery,
    'shipping_address' => $shippingAddress,
    'items' => $items,
    'view_details_url' => 'UserOrderDetails.php?order_id=' . $order['order_id']
]);
?>