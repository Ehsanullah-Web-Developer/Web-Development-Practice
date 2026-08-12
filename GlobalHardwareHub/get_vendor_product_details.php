<?php
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

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please login first');
}

// Get vendor ID (user_id 11-18, vendor_id = user_id - 10)
$vendorId = $_SESSION['user_id'] - 10;
$productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

if ($productId <= 0) {
    sendResponse(false, null, 'Invalid product ID');
}

// Fetch product details with category
$sql = "SELECT p.product_id, p.name as product_name, p.sku, p.category_id, p.description, 
               p.regular_price, p.sale_price, p.status, 
               c.name as category_name, 
               (SELECT image_url FROM product_images WHERE product_id = p.product_id ORDER BY sort_order LIMIT 1) as image_url
        FROM products p
        LEFT JOIN product_categories c ON p.category_id = c.category_id
        INNER JOIN vendor_products vp ON p.product_id = vp.product_id
        WHERE p.product_id = ? AND vp.vendor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $productId, $vendorId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt->close();
    $conn->close();
    sendResponse(false, null, 'Product not found or access denied');
}

$product = $result->fetch_assoc();

// Fetch specifications
$specs = [];
$specSql = "SELECT spec_key, spec_value FROM product_specifications WHERE product_id = ?";
$specStmt = $conn->prepare($specSql);
$specStmt->bind_param("i", $productId);
$specStmt->execute();
$specResult = $specStmt->get_result();

while ($row = $specResult->fetch_assoc()) {
    $specs[] = ['key' => $row['spec_key'], 'value' => $row['spec_value']];
}
$specStmt->close();

$product['specifications'] = $specs;
$product['category_id'] = (int)$product['category_id'];

$stmt->close();
$conn->close();

sendResponse(true, $product);
?>