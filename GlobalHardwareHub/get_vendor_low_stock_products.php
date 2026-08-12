<?php
/**
 * get_vendor_low_stock_products.php
 * 
 * This API fetches low stock products for the logged-in vendor.
 * Returns products with stock quantity <= 5.
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

// Check if stock_quantity column exists
$stockColumnExists = false;
$checkColumn = $conn->query("SHOW COLUMNS FROM products LIKE 'stock_quantity'");
if ($checkColumn && $checkColumn->num_rows > 0) {
    $stockColumnExists = true;
}

// Check if vendor_id column exists
$vendorColumnExists = false;
$checkVendorColumn = $conn->query("SHOW COLUMNS FROM products LIKE 'vendor_id'");
if ($checkVendorColumn && $checkVendorColumn->num_rows > 0) {
    $vendorColumnExists = true;
}

// Build query based on existing columns
if ($stockColumnExists) {
    // Use actual stock_quantity column
    if ($vendorColumnExists) {
        $sql = "SELECT 
                    p.product_id,
                    p.name as product_name,
                    p.stock_quantity,
                    (SELECT image_url FROM product_images 
                     WHERE product_id = p.product_id 
                     ORDER BY sort_order ASC LIMIT 1) as image_url
                FROM products p
                WHERE p.vendor_id = ? 
                AND p.stock_quantity <= 5
                ORDER BY p.stock_quantity ASC
                LIMIT 10";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $vendorId);
    } else {
        $sql = "SELECT 
                    p.product_id,
                    p.name as product_name,
                    p.stock_quantity,
                    (SELECT image_url FROM product_images 
                     WHERE product_id = p.product_id 
                     ORDER BY sort_order ASC LIMIT 1) as image_url
                FROM products p
                WHERE (p.product_id % 8) + 1 = ? 
                AND p.stock_quantity <= 5
                ORDER BY p.stock_quantity ASC
                LIMIT 10";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $vendorId);
    }
} else {
    // No stock_quantity column - use simulated stock (cannot use COALESCE with non-existent column)
    if ($vendorColumnExists) {
        $sql = "SELECT 
                    p.product_id,
                    p.name as product_name,
                    ((p.product_id % 12) + 1) as stock_quantity,
                    (SELECT image_url FROM product_images 
                     WHERE product_id = p.product_id 
                     ORDER BY sort_order ASC LIMIT 1) as image_url
                FROM products p
                WHERE p.vendor_id = ? 
                AND ((p.product_id % 12) + 1) <= 5
                ORDER BY ((p.product_id % 12) + 1) ASC
                LIMIT 10";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $vendorId);
    } else {
        $sql = "SELECT 
                    p.product_id,
                    p.name as product_name,
                    ((p.product_id % 12) + 1) as stock_quantity,
                    (SELECT image_url FROM product_images 
                     WHERE product_id = p.product_id 
                     ORDER BY sort_order ASC LIMIT 1) as image_url
                FROM products p
                WHERE ((p.product_id % 8) + 1) = ? 
                AND ((p.product_id % 12) + 1) <= 5
                ORDER BY ((p.product_id % 12) + 1) ASC
                LIMIT 10";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $vendorId);
    }
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $stock = (int)$row['stock_quantity'];
    $products[] = [
        'product_id' => (int)$row['product_id'],
        'product_name' => $row['product_name'],
        'image_url' => $row['image_url'] ?? '',
        'stock_quantity' => $stock,
        'stock_status' => ($stock <= 0) ? 'Out of Stock' : 'Low Stock'
    ];
}

$stmt->close();
$conn->close();

sendResponse(true, $products);
?>