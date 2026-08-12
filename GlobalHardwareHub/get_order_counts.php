<?php
/**
 * get_order_counts.php (Optimized Version)
 * 
 * Uses a single query with conditional aggregation for better performance.
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $message = null, $counts = null) {
    $response = ['success' => $success];
    if ($message !== null) $response['message'] = $message;
    if ($counts !== null) $response['counts'] = $counts;
    echo json_encode($response);
    exit;
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first');
}

$userId = $_SESSION['user_id'];

/**
 * Single query to get all counts at once
 * Using conditional aggregation (SUM with CASE)
 */
$sql = "SELECT 
            COUNT(*) as total_orders,
            SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending_orders,
            SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_orders,
            SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_orders,
            SUM(CASE WHEN status != 'Cancelled' THEN total_amount ELSE 0 END) as total_spent
        FROM orders 
        WHERE user_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    sendResponse(false, 'Unable to fetch order counts');
}

$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    $counts = [
        'total_orders' => (int)($row['total_orders'] ?? 0),
        'pending_orders' => (int)($row['pending_orders'] ?? 0),
        'completed_orders' => (int)($row['completed_orders'] ?? 0),
        'cancelled_orders' => (int)($row['cancelled_orders'] ?? 0),
        'total_spent' => (float)($row['total_spent'] ?? 0)
    ];
    
    sendResponse(true, null, $counts);
} else {
    // No orders found - return zeros
    $counts = [
        'total_orders' => 0,
        'pending_orders' => 0,
        'completed_orders' => 0,
        'cancelled_orders' => 0,
        'total_spent' => 0.00
    ];
    sendResponse(true, null, $counts);
}

$stmt->close();
$conn->close();
?>