<?php
/**
 * get_user_orders.php
 * 
 * This API endpoint fetches all orders of the logged-in user.
 * Returns order details, item counts, preview images, and payment status.
 * 
 * Expected output: JSON format with user's orders data
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
function sendResponse($success, $message = null, $orders = null) {
    $response = ['success' => $success];
    
    if ($message !== null) {
        $response['message'] = $message;
    }
    
    if ($orders !== null) {
        $response['orders'] = $orders;
    }
    
    echo json_encode($response);
    exit;
}

/**
 * STEP 1: Check if user is logged in
 */
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first');
}

$userId = $_SESSION['user_id'];

/**
 * STEP 2: Fetch all orders for the logged-in user
 * Order by created_at DESC (latest first)
 */
$ordersSql = "SELECT 
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
              WHERE user_id = ? 
              ORDER BY created_at DESC";

$ordersStmt = $conn->prepare($ordersSql);

if (!$ordersStmt) {
    sendResponse(false, 'Unable to load orders');
}

$ordersStmt->bind_param('i', $userId);
$ordersStmt->execute();
$ordersResult = $ordersStmt->get_result();

// If no orders found, return empty array
if ($ordersResult->num_rows === 0) {
    $ordersStmt->close();
    sendResponse(true, null, []);
}

$orders = [];

/**
 * STEP 3: Process each order
 */
while ($order = $ordersResult->fetch_assoc()) {
    $orderId = $order['order_id'];
    
    /**
     * STEP 4: Get payment status from order_payments table
     */
    $paymentStatus = 'Pending';
    $paymentSql = "SELECT status FROM order_payments WHERE order_id = ? ORDER BY created_at DESC LIMIT 1";
    $paymentStmt = $conn->prepare($paymentSql);
    
    if ($paymentStmt) {
        $paymentStmt->bind_param('i', $orderId);
        $paymentStmt->execute();
        $paymentResult = $paymentStmt->get_result();
        
        if ($paymentResult->num_rows > 0) {
            $payment = $paymentResult->fetch_assoc();
            $paymentStatus = $payment['status'];
        }
        $paymentStmt->close();
    }
    
    /**
     * STEP 5: Calculate order items summary (total_items and item_count)
     */
    $itemsSql = "SELECT 
                    COUNT(*) as item_count,
                    SUM(quantity) as total_items
                 FROM order_items 
                 WHERE order_id = ?";
    
    $itemsStmt = $conn->prepare($itemsSql);
    
    if (!$itemsStmt) {
        continue;
    }
    
    $itemsStmt->bind_param('i', $orderId);
    $itemsStmt->execute();
    $itemsResult = $itemsStmt->get_result();
    $itemsSummary = $itemsResult->fetch_assoc();
    $itemsStmt->close();
    
    $itemCount = (int)($itemsSummary['item_count'] ?? 0);
    $totalItems = (int)($itemsSummary['total_items'] ?? 0);
    
    /**
     * STEP 6: Fetch product preview images (up to 3 images per order)
     */
    $previewImages = [];
    $imagesSql = "SELECT DISTINCT pi.image_url 
                  FROM order_items oi
                  INNER JOIN products p ON oi.product_id = p.product_id
                  INNER JOIN product_images pi ON p.product_id = pi.product_id
                  WHERE oi.order_id = ?
                  ORDER BY pi.sort_order ASC
                  LIMIT 3";
    
    $imagesStmt = $conn->prepare($imagesSql);
    
    if ($imagesStmt) {
        $imagesStmt->bind_param('i', $orderId);
        $imagesStmt->execute();
        $imagesResult = $imagesStmt->get_result();
        
        while ($image = $imagesResult->fetch_assoc()) {
            if (!empty($image['image_url'])) {
                $previewImages[] = $image['image_url'];
            }
        }
        $imagesStmt->close();
    }
    
    /**
     * STEP 7: Build order object
     */
    $orders[] = [
        'order_id' => (int)$order['order_id'],
        'total_amount' => (float)$order['total_amount'],
        'payment_method' => $order['payment_method'] ?? 'N/A',
        'coupon_code' => $order['coupon_code'] ?? '',
        'status' => $order['status'] ?? 'Pending',
        'created_at' => $order['created_at'],
        'payment_status' => $paymentStatus,
        'total_items' => $totalItems,
        'item_count' => $itemCount,
        'preview_images' => $previewImages
    ];
}

$ordersStmt->close();

/**
 * STEP 8: Return success response with orders
 */
sendResponse(true, null, $orders);

// Close database connection
$conn->close();
?>