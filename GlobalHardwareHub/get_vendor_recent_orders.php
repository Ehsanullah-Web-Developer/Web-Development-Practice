<?php
/**
 * get_vendor_recent_orders.php
 * 
 * This API fetches recent orders for the logged-in vendor.
 * Returns orders that contain products belonging to this vendor.
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

// Map user_id to vendor_id (user_id 11-18 = vendor_id 1-8)
$vendorId = $_SESSION['user_id'] - 10;

if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied. Vendor account required.');
}

// Fetch recent orders for this vendor
$sql = "SELECT 
            o.order_id,
            u.full_name as customer_name,
            SUM(oi.quantity) as total_items,
            SUM(oi.price * oi.quantity) as total_amount,
            o.status,
            o.created_at
        FROM order_items oi
        INNER JOIN orders o ON oi.order_id = o.order_id
        INNER JOIN users u ON o.user_id = u.user_id
        WHERE oi.vendor_id = ?
        GROUP BY o.order_id, u.full_name, o.status, o.created_at
        ORDER BY o.created_at DESC
        LIMIT 10";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $vendorId);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = [
        'order_id' => (int)$row['order_id'],
        'customer_name' => $row['customer_name'],
        'total_items' => (int)$row['total_items'],
        'total_amount' => (float)$row['total_amount'],
        'status' => $row['status'],
        'created_at' => $row['created_at']
    ];
}

$stmt->close();
$conn->close();

sendResponse(true, $orders);
?>