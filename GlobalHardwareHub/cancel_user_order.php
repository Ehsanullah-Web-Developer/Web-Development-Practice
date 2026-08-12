<?php
/**
 * cancel_user_order.php
 * 
 * This API endpoint allows logged-in users to cancel their orders.
 * Only allows cancellation if order status is not 'Completed' or already 'Cancelled'.
 * 
 * Expected input: POST request with order_id
 * Expected output: JSON format with success/error message
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
function sendResponse($success, $message) {
    $response = [
        'success' => $success,
        'message' => $message
    ];
    echo json_encode($response);
    exit;
}

/**
 * STEP 1: Check if request method is POST
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method');
}

/**
 * STEP 2: Check if user is logged in
 */
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first');
}

$userId = $_SESSION['user_id'];

/**
 * STEP 3: Get and validate order_id from POST data
 */
$inputData = json_decode(file_get_contents('php://input'), true);

// If JSON decoding failed, try regular POST
if ($inputData === null) {
    $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
} else {
    $orderId = isset($inputData['order_id']) ? (int)$inputData['order_id'] : 0;
}

// Validate order_id
if ($orderId <= 0) {
    sendResponse(false, 'Invalid order ID');
}

/**
 * STEP 4: Verify order ownership and get current status
 */
$orderSql = "SELECT order_id, user_id, status FROM orders WHERE order_id = ? AND user_id = ?";
$orderStmt = $conn->prepare($orderSql);

if (!$orderStmt) {
    sendResponse(false, 'Unable to verify order');
}

$orderStmt->bind_param('ii', $orderId, $userId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

// Check if order exists and belongs to user
if ($orderResult->num_rows === 0) {
    $orderStmt->close();
    sendResponse(false, 'Order not found or unauthorized');
}

$order = $orderResult->fetch_assoc();
$currentStatus = $order['status'];
$orderStmt->close();

/**
 * STEP 5: Check if order can be cancelled based on status
 */
$currentStatusLower = strtolower($currentStatus);

if ($currentStatusLower === 'completed') {
    sendResponse(false, 'Cannot cancel a completed order');
}

if ($currentStatusLower === 'cancelled') {
    sendResponse(false, 'Order already cancelled');
}

/**
 * STEP 6: Update order status to 'Cancelled'
 */
$updateSql = "UPDATE orders SET status = 'Cancelled' WHERE order_id = ? AND user_id = ?";
$updateStmt = $conn->prepare($updateSql);

if (!$updateStmt) {
    sendResponse(false, 'Unable to process cancellation');
}

$updateStmt->bind_param('ii', $orderId, $userId);

if ($updateStmt->execute()) {
    // Check if any row was actually updated
    if ($updateStmt->affected_rows > 0) {
        $updateStmt->close();
        
        /**
         * STEP 7: Optional - Update payment status to 'Refunded' if payment exists
         */
        $paymentSql = "SELECT payment_id FROM order_payments WHERE order_id = ?";
        $paymentStmt = $conn->prepare($paymentSql);
        
        if ($paymentStmt) {
            $paymentStmt->bind_param('i', $orderId);
            $paymentStmt->execute();
            $paymentResult = $paymentStmt->get_result();
            
            if ($paymentResult->num_rows > 0) {
                // Update payment status to Refunded
                $refundSql = "UPDATE order_payments SET status = 'Refunded' WHERE order_id = ?";
                $refundStmt = $conn->prepare($refundSql);
                
                if ($refundStmt) {
                    $refundStmt->bind_param('i', $orderId);
                    $refundStmt->execute();
                    $refundStmt->close();
                }
            }
            $paymentStmt->close();
        }
        
        /**
         * STEP 8: Optional - Restore product stock (commented for future use)
         * If you have an inventory system with stock tracking, uncomment this section:
         * 
         * $stockSql = "SELECT oi.product_id, oi.quantity 
         *              FROM order_items oi 
         *              WHERE oi.order_id = ?";
         * $stockStmt = $conn->prepare($stockSql);
         * $stockStmt->bind_param('i', $orderId);
         * $stockStmt->execute();
         * $stockResult = $stockStmt->get_result();
         * 
         * while ($item = $stockResult->fetch_assoc()) {
         *     $restoreSql = "UPDATE products SET stock = stock + ? WHERE product_id = ?";
         *     $restoreStmt = $conn->prepare($restoreSql);
         *     $restoreStmt->bind_param('ii', $item['quantity'], $item['product_id']);
         *     $restoreStmt->execute();
         *     $restoreStmt->close();
         * }
         * $stockStmt->close();
         */
        
        sendResponse(true, 'Order cancelled successfully');
    } else {
        $updateStmt->close();
        sendResponse(false, 'Unable to cancel order. Please try again.');
    }
} else {
    $updateStmt->close();
    sendResponse(false, 'Unable to cancel order. Please try again.');
}

// Close database connection
$conn->close();
?>