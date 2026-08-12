<?php
/**
 * get_order_confirmation.php
 * 
 * This API endpoint fetches order details for the order confirmation page.
 * Returns order information, payment details, and ordered items with images.
 * 
 * Expected input: GET request with order_id parameter
 * Expected output: JSON format with order confirmation data
 */

// Start session to check user login status
session_start();

// Include database connection
require_once 'db_connect.php';

// Set response header to JSON
header('Content-Type: application/json');

/**
 * Helper function to send JSON response and exit
 */
function sendResponse($success, $message, $data = null) {
    $response = [
        'success' => $success,
        'message' => $message
    ];
    if ($data !== null) {
        $response = array_merge($response, $data);
    }
    echo json_encode($response);
    exit;
}

/**
 * STEP 1: Check if user is logged in
 */
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please Login First');
}

$userId = $_SESSION['user_id'];

/**
 * STEP 2: Get and validate order_id from GET parameter
 */
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    sendResponse(false, 'Invalid Order ID');
}

$orderId = (int)$_GET['order_id'];

if ($orderId <= 0) {
    sendResponse(false, 'Invalid Order ID');
}

/**
 * STEP 3: Fetch main order details and verify ownership
 */
$orderSql = "SELECT 
                order_id, 
                user_id, 
                total_amount, 
                payment_method, 
                shipping_address_id, 
                coupon_code, 
                order_notes, 
                status, 
                created_at 
            FROM orders 
            WHERE order_id = ? AND user_id = ?";

$orderStmt = $conn->prepare($orderSql);

if (!$orderStmt) {
    sendResponse(false, 'Unable to load order confirmation');
}

$orderStmt->bind_param('ii', $orderId, $userId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

// Check if order exists and belongs to user
if ($orderResult->num_rows === 0) {
    $orderStmt->close();
    sendResponse(false, 'Order not found');
}

$order = $orderResult->fetch_assoc();
$orderStmt->close();

/**
 * STEP 4: Fetch order payment details
 */
$paymentSql = "SELECT 
                payment_id, 
                order_id, 
                payment_method, 
                amount, 
                status, 
                created_at 
            FROM order_payments 
            WHERE order_id = ? 
            ORDER BY created_at DESC 
            LIMIT 1";

$paymentStmt = $conn->prepare($paymentSql);

if ($paymentStmt) {
    $paymentStmt->bind_param('i', $orderId);
    $paymentStmt->execute();
    $paymentResult = $paymentStmt->get_result();
    $payment = $paymentResult->fetch_assoc();
    $paymentStmt->close();
} else {
    $payment = null;
}

/**
 * STEP 5: Fetch order items with product details and images
 */
$itemsSql = "SELECT 
                oi.order_item_id,
                oi.order_id,
                oi.product_id,
                oi.vendor_id,
                oi.quantity,
                oi.price,
                p.name,
                p.sku,
                p.description,
                p.regular_price,
                p.sale_price,
                p.status as product_status,
                (SELECT image_url 
                 FROM product_images 
                 WHERE product_id = p.product_id 
                 ORDER BY sort_order ASC 
                 LIMIT 1) as image_url
            FROM order_items oi
            INNER JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = ?";

$itemsStmt = $conn->prepare($itemsSql);

if (!$itemsStmt) {
    sendResponse(false, 'Unable to load order items');
}

$itemsStmt->bind_param('i', $orderId);
$itemsStmt->execute();
$itemsResult = $itemsStmt->get_result();

$items = [];
while ($row = $itemsResult->fetch_assoc()) {
    $item = [
        'product_id' => (int)$row['product_id'],
        'name' => $row['name'],
        'sku' => $row['sku'],
        'vendor_id' => (int)$row['vendor_id'],
        'quantity' => (int)$row['quantity'],
        'price' => (float)$row['price'],
        'image_url' => $row['image_url'] ?? null
    ];
    $items[] = $item;
}
$itemsStmt->close();

/**
 * STEP 6: Prepare the response data
 */
$orderData = [
    'order_id' => (int)$order['order_id'],
    'total_amount' => (float)$order['total_amount'],
    'payment_method' => $order['payment_method'],
    'coupon_code' => $order['coupon_code'],
    'order_notes' => $order['order_notes'],
    'status' => $order['status'],
    'created_at' => $order['created_at']
];

$paymentData = null;
if ($payment) {
    $paymentData = [
        'payment_id' => (int)$payment['payment_id'],
        'payment_method' => $payment['payment_method'],
        'amount' => (float)$payment['amount'],
        'status' => $payment['status'],
        'created_at' => $payment['created_at']
    ];
}

/**
 * STEP 7: Return final JSON response
 */
sendResponse(true, 'Order confirmation loaded successfully', [
    'order' => $orderData,
    'payment' => $paymentData,
    'items' => $items
]);

// Close database connection
$conn->close();
?>