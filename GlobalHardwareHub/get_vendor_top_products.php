<?php
/**
 * get_vendor_top_products.php
 * 
 * This API fetches top selling products for the logged-in vendor.
 * Returns products with total quantity sold and total revenue.
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

// Fetch top selling products for this vendor
$sql = "SELECT 
            p.product_id,
            p.name as product_name,
            SUM(oi.quantity) as total_sold,
            SUM(oi.price * oi.quantity) as total_revenue,
            (SELECT image_url 
             FROM product_images 
             WHERE product_id = p.product_id 
             ORDER BY sort_order ASC 
             LIMIT 1) as image_url
        FROM order_items oi
        INNER JOIN products p ON oi.product_id = p.product_id
        WHERE oi.vendor_id = ?
        GROUP BY p.product_id, p.name
        ORDER BY total_sold DESC
        LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $vendorId);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = [
        'product_id' => (int)$row['product_id'],
        'product_name' => $row['product_name'],
        'image_url' => $row['image_url'] ?? '',
        'total_sold' => (int)$row['total_sold'],
        'total_revenue' => (float)$row['total_revenue']
    ];
}

$stmt->close();
$conn->close();

sendResponse(true, $products);
?>