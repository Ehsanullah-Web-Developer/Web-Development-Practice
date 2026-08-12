<?php
/**
 * get_vendor_orders.php
 * 
 * This API fetches all orders for the logged-in vendor.
 * Supports filtering by status and searching by order ID.
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

// Get filter parameters
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : 'all';
$searchOrderId = isset($_GET['search']) ? (int)$_GET['search'] : 0;

// Build query - get orders that contain items from this vendor
$sql = "SELECT 
            o.order_id,
            o.total_amount,
            o.status,
            o.created_at,
            u.full_name as customer_name,
            SUM(oi.quantity) as total_items
        FROM orders o
        INNER JOIN order_items oi ON o.order_id = oi.order_id
        INNER JOIN users u ON o.user_id = u.user_id
        WHERE oi.vendor_id = ?";

// Add status filter if not 'all'
if ($statusFilter !== 'all') {
    $sql .= " AND o.status = ?";
}

// Add search filter if provided
if ($searchOrderId > 0) {
    $sql .= " AND o.order_id = ?";
}

$sql .= " GROUP BY o.order_id, o.total_amount, o.status, o.created_at, u.full_name
          ORDER BY o.created_at DESC";

// Prepare and execute statement
$stmt = $conn->prepare($sql);

if (!$stmt) {
    sendResponse(false, null, 'Unable to fetch orders');
}

// Bind parameters based on filters
if ($statusFilter !== 'all' && $searchOrderId > 0) {
    $stmt->bind_param('isi', $vendorId, $statusFilter, $searchOrderId);
} elseif ($statusFilter !== 'all') {
    $stmt->bind_param('is', $vendorId, $statusFilter);
} elseif ($searchOrderId > 0) {
    $stmt->bind_param('ii', $vendorId, $searchOrderId);
} else {
    $stmt->bind_param('i', $vendorId);
}

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