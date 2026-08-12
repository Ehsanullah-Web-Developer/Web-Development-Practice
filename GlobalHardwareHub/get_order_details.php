<?php
/**
 * get_order_details.php (Enhanced Version with Timeline)
 * 
 * Includes order status timeline for tracking
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $message, $data = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($data !== null) $response['order'] = $data;
    echo json_encode($response);
    exit;
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first');
}

$userId = $_SESSION['user_id'];
$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : (isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0);

if ($orderId <= 0) {
    sendResponse(false, 'Invalid order ID');
}

// Fetch order with ownership verification
$orderStmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
$orderStmt->bind_param('ii', $orderId, $userId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

if ($orderResult->num_rows === 0) {
    $orderStmt->close();
    sendResponse(false, 'Order not found');
}

$order = $orderResult->fetch_assoc();
$orderStmt->close();

// Fetch shipping address
$shippingAddress = null;
if ($order['shipping_address_id'] > 0) {
    $addrStmt = $conn->prepare("SELECT * FROM user_addresses WHERE address_id = ?");
    $addrStmt->bind_param('i', $order['shipping_address_id']);
    $addrStmt->execute();
    $addrResult = $addrStmt->get_result();
    if ($addrResult->num_rows > 0) {
        $address = $addrResult->fetch_assoc();
        $shippingAddress = [
            'full_name' => $address['full_name'] ?? '',
            'phone' => $address['phone'] ?? '',
            'address_line1' => $address['address_line1'] ?? '',
            'address_line2' => $address['address_line2'] ?? '',
            'city' => $address['city'] ?? '',
            'state' => $address['state'] ?? '',
            'postal_code' => $address['postal_code'] ?? '',
            'country' => $address['country'] ?? ''
        ];
    }
    $addrStmt->close();
}

// Fetch payment details
$paymentDetails = null;
$payStmt = $conn->prepare("SELECT * FROM order_payments WHERE order_id = ? ORDER BY created_at DESC LIMIT 1");
$payStmt->bind_param('i', $orderId);
$payStmt->execute();
$payResult = $payStmt->get_result();
if ($payResult->num_rows > 0) {
    $payment = $payResult->fetch_assoc();
    $paymentDetails = [
        'payment_method' => $payment['payment_method'],
        'amount' => (float)$payment['amount'],
        'status' => $payment['status'],
        'payment_date' => $payment['created_at']
    ];
}
$payStmt->close();

if (!$paymentDetails) {
    $paymentDetails = [
        'payment_method' => $order['payment_method'],
        'amount' => (float)$order['total_amount'],
        'status' => 'Pending',
        'payment_date' => $order['created_at']
    ];
}

// Fetch order items with product images
$items = [];
$itemStmt = $conn->prepare("
    SELECT oi.*, p.name, p.sku, p.description 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.product_id 
    WHERE oi.order_id = ?
");
$itemStmt->bind_param('i', $orderId);
$itemStmt->execute();
$itemResult = $itemStmt->get_result();

while ($item = $itemResult->fetch_assoc()) {
    $imgStmt = $conn->prepare("SELECT image_url FROM product_images WHERE product_id = ? ORDER BY sort_order ASC LIMIT 1");
    $imgStmt->bind_param('i', $item['product_id']);
    $imgStmt->execute();
    $imgResult = $imgStmt->get_result();
    $imageUrl = $imgResult->num_rows > 0 ? $imgResult->fetch_assoc()['image_url'] : null;
    $imgStmt->close();
    
    $items[] = [
        'product_id' => (int)$item['product_id'],
        'name' => $item['name'],
        'sku' => $item['sku'],
        'quantity' => (int)$item['quantity'],
        'price' => (float)$item['price'],
        'subtotal' => (float)($item['price'] * $item['quantity']),
        'image_url' => $imageUrl
    ];
}
$itemStmt->close();

// Prepare response
$orderData = [
    'order_id' => (int)$order['order_id'],
    'total_amount' => (float)$order['total_amount'],
    'status' => $order['status'],
    'created_at' => $order['created_at'],
    'payment_method' => $order['payment_method'],
    'coupon_code' => $order['coupon_code'],
    'order_notes' => $order['order_notes'],
    'shipping_address' => $shippingAddress,
    'payment' => $paymentDetails,
    'items' => $items,
    'items_count' => count($items),
    'total_quantity' => array_sum(array_column($items, 'quantity'))
];

sendResponse(true, 'Order details fetched successfully', $orderData);

$conn->close();
?>