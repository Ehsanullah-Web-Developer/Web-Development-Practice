<?php
/**
 * get_order_details.php
 * 
 * This API fetches complete details of a single order.
 * Returns order info, items, customer details, and payment info.
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $data = null, $message = null) {
    $response = ['success' => $success];
    if ($data !== null) $response['data'] = $data;
    if ($message !== null) $response['message'] = $message;
    echo json_encode($response);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please login first');
}

// Get order_id from GET parameter
$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

if ($orderId <= 0) {
    sendResponse(false, null, 'Invalid order ID');
}

// Fetch order details
$sql = "SELECT 
            o.order_id,
            o.total_amount,
            o.status,
            o.created_at,
            o.payment_method,
            o.order_notes,
            u.user_id,
            u.full_name as customer_name,
            u.email as customer_email,
            u.phone as customer_phone
        FROM orders o
        INNER JOIN users u ON o.user_id = u.user_id
        WHERE o.order_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $orderId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    sendResponse(false, null, 'Order not found');
}

$order = $result->fetch_assoc();
$stmt->close();

// Fetch order items for this vendor only
$itemsSql = "SELECT 
                oi.order_item_id,
                oi.product_id,
                oi.quantity,
                oi.price,
                p.name as product_name,
                p.sku,
                (SELECT image_url FROM product_images WHERE product_id = p.product_id ORDER BY sort_order ASC LIMIT 1) as image_url
            FROM order_items oi
            INNER JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = ?";

$itemsStmt = $conn->prepare($itemsSql);
$itemsStmt->bind_param('i', $orderId);
$itemsStmt->execute();
$itemsResult = $itemsStmt->get_result();

$items = [];
while ($row = $itemsResult->fetch_assoc()) {
    $items[] = [
        'product_id' => (int)$row['product_id'],
        'product_name' => $row['product_name'],
        'sku' => $row['sku'],
        'quantity' => (int)$row['quantity'],
        'price' => (float)$row['price'],
        'subtotal' => (float)($row['price'] * $row['quantity']),
        'image_url' => $row['image_url'] ?? ''
    ];
}
$itemsStmt->close();

// Calculate vendor total (sum of vendor's items only)
$vendorTotal = 0;
foreach ($items as $item) {
    $vendorTotal += $item['subtotal'];
}

$conn->close();

$data = [
    'order_id' => (int)$order['order_id'],
    'total_amount' => (float)$order['total_amount'],
    'vendor_total' => $vendorTotal,
    'status' => $order['status'],
    'created_at' => $order['created_at'],
    'payment_method' => $order['payment_method'] ?? 'N/A',
    'order_notes' => $order['order_notes'] ?? '',
    'customer' => [
        'name' => $order['customer_name'],
        'email' => $order['customer_email'],
        'phone' => $order['customer_phone'] ?? 'N/A'
    ],
    'items' => $items
];

sendResponse(true, $data);
?>