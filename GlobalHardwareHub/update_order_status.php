<?php
/**
 * update_order_status.php
 * 
 * This API updates the status of an order for the logged-in vendor.
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method');
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first');
}

// Map user_id to vendor_id
$vendorId = $_SESSION['user_id'] - 10;

if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, 'Access denied. Vendor account required.');
}

// Get POST data
$inputData = json_decode(file_get_contents('php://input'), true);

if (!$inputData) {
    sendResponse(false, 'Invalid data received');
}

$orderId = isset($inputData['order_id']) ? (int)$inputData['order_id'] : 0;
$newStatus = isset($inputData['status']) ? trim($inputData['status']) : '';

// Validate inputs
if ($orderId <= 0) {
    sendResponse(false, 'Invalid order ID');
}

// Allowed status values
$allowedStatuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
if (!in_array($newStatus, $allowedStatuses)) {
    sendResponse(false, 'Invalid status value');
}

// Verify that this order contains items from this vendor
$checkSql = "SELECT DISTINCT o.order_id 
             FROM orders o
             INNER JOIN order_items oi ON o.order_id = oi.order_id
             WHERE o.order_id = ? AND oi.vendor_id = ?";

$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param('ii', $orderId, $vendorId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $checkStmt->close();
    sendResponse(false, 'Order not found or access denied');
}
$checkStmt->close();

// Update order status
$updateSql = "UPDATE orders SET status = ? WHERE order_id = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param('si', $newStatus, $orderId);

if ($updateStmt->execute()) {
    $updateStmt->close();
    sendResponse(true, 'Order status updated successfully');
} else {
    $updateStmt->close();
    sendResponse(false, 'Failed to update order status: ' . $conn->error);
}

$conn->close();
?>