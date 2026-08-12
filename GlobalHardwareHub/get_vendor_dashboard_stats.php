<?php
/**
 * get_vendor_dashboard_stats.php
 * 
 * This API fetches dashboard statistics for the logged-in vendor.
 * Returns total sales, pending orders, total products, and average rating.
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

// Initialize stats with default values
$stats = [
    'total_sales' => 0,
    'pending_orders' => 0,
    'total_products' => 0,
    'avg_rating' => 0
];

// 1. Calculate total sales
$salesSql = "SELECT SUM(oi.price * oi.quantity) as total_sales 
             FROM order_items oi 
             WHERE oi.vendor_id = ?";
$salesStmt = $conn->prepare($salesSql);
$salesStmt->bind_param('i', $vendorId);
$salesStmt->execute();
$salesResult = $salesStmt->get_result();
if ($salesRow = $salesResult->fetch_assoc()) {
    $stats['total_sales'] = (float)($salesRow['total_sales'] ?? 0);
}
$salesStmt->close();

// 2. Calculate pending orders (orders containing vendor's items with status 'pending')
$pendingSql = "SELECT COUNT(DISTINCT o.order_id) as pending_orders 
               FROM order_items oi 
               INNER JOIN orders o ON oi.order_id = o.order_id 
               WHERE oi.vendor_id = ? AND o.status = 'pending'";
$pendingStmt = $conn->prepare($pendingSql);
$pendingStmt->bind_param('i', $vendorId);
$pendingStmt->execute();
$pendingResult = $pendingStmt->get_result();
if ($pendingRow = $pendingResult->fetch_assoc()) {
    $stats['pending_orders'] = (int)($pendingRow['pending_orders'] ?? 0);
}
$pendingStmt->close();

// 3. Calculate total products
// First, check if products table has vendor_id column
$hasVendorColumn = false;
$vendorCheck = $conn->query("SHOW COLUMNS FROM products LIKE 'vendor_id'");
if ($vendorCheck && $vendorCheck->num_rows > 0) {
    $hasVendorColumn = true;
}

if ($hasVendorColumn) {
    // Use vendor_id column from products table
    $productSql = "SELECT COUNT(*) as total_products FROM products WHERE vendor_id = ?";
    $productStmt = $conn->prepare($productSql);
    $productStmt->bind_param('i', $vendorId);
} else {
    // Fallback: Count distinct products from order_items
    $productSql = "SELECT COUNT(DISTINCT product_id) as total_products FROM order_items WHERE vendor_id = ?";
    $productStmt = $conn->prepare($productSql);
    $productStmt->bind_param('i', $vendorId);
}

$productStmt->execute();
$productResult = $productStmt->get_result();
if ($productRow = $productResult->fetch_assoc()) {
    $stats['total_products'] = (int)($productRow['total_products'] ?? 0);
}
$productStmt->close();

// 4. Calculate average rating from vendor_reviews
// 4. Calculate average rating from vendor_reviews
$ratingSql = "SELECT AVG(rating) as avg_rating FROM vendor_reviews WHERE vendor_id = ?";
$ratingStmt = $conn->prepare($ratingSql);
$ratingStmt->bind_param('i', $vendorId);
$ratingStmt->execute();
$ratingResult = $ratingStmt->get_result();

if ($ratingResult && $ratingResult->num_rows > 0) {
    $ratingRow = $ratingResult->fetch_assoc();
    if ($ratingRow && $ratingRow['avg_rating'] !== null) {
        $stats['avg_rating'] = round((float)$ratingRow['avg_rating'], 1);
    }
}
$ratingStmt->close();

$conn->close();

sendResponse(true, $stats);
?>