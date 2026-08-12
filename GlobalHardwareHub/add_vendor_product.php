<?php
session_start();
require_once 'db_connect.php';

// Set header
header('Content-Type: application/json');

// Simple array for response
$result = array();
$result['success'] = false;
$result['message'] = '';

// Check login
if (!isset($_SESSION['user_id'])) {
    $result['message'] = 'Please login first';
    echo json_encode($result);
    exit;
}

$vendorId = $_SESSION['user_id'] - 10;
if ($vendorId < 1 || $vendorId > 8) {
    $result['message'] = 'Access denied';
    echo json_encode($result);
    exit;
}

// Get POST data
$postData = file_get_contents('php://input');
$inputData = json_decode($postData, true);

if (!$inputData) {
    $result['message'] = 'No data received';
    echo json_encode($result);
    exit;
}

$productName = isset($inputData['product_name']) ? trim($inputData['product_name']) : '';
$categoryId = isset($inputData['category_id']) ? (int)$inputData['category_id'] : 0;
$description = isset($inputData['description']) ? trim($inputData['description']) : '';
$regularPrice = isset($inputData['regular_price']) ? (float)$inputData['regular_price'] : 0;
$salePrice = isset($inputData['sale_price']) ? (float)$inputData['sale_price'] : 0;
$sku = isset($inputData['sku']) ? trim($inputData['sku']) : '';
$status = isset($inputData['status']) ? trim($inputData['status']) : 'draft';
$imageUrl = isset($inputData['image_url']) ? trim($inputData['image_url']) : '';
$stockQuantity = isset($inputData['stock_quantity']) ? (int)$inputData['stock_quantity'] : 0;

// Validate
if (empty($productName)) {
    $result['message'] = 'Product name is required';
    echo json_encode($result);
    exit;
}
if ($regularPrice <= 0) {
    $result['message'] = 'Regular price must be greater than 0';
    echo json_encode($result);
    exit;
}
if (empty($sku)) {
    $result['message'] = 'SKU is required';
    echo json_encode($result);
    exit;
}

// Check if SKU exists
$checkSql = "SELECT product_id FROM products WHERE sku = '" . mysqli_real_escape_string($conn, $sku) . "'";
$checkResult = $conn->query($checkSql);
if ($checkResult && $checkResult->num_rows > 0) {
    $result['message'] = 'SKU already exists';
    echo json_encode($result);
    exit;
}

// ========== FIX: REMOVE stock_quantity FROM products INSERT ==========
// The products table does NOT have stock_quantity column
$salePriceValue = ($salePrice > 0) ? $salePrice : 'NULL';
$insertSql = "INSERT INTO products (name, sku, category_id, description, regular_price, sale_price, status) 
              VALUES ('" . mysqli_real_escape_string($conn, $productName) . "', 
                      '" . mysqli_real_escape_string($conn, $sku) . "', 
                      $categoryId, 
                      '" . mysqli_real_escape_string($conn, $description) . "', 
                      $regularPrice, 
                      $salePriceValue, 
                      '" . mysqli_real_escape_string($conn, $status) . "')";

if ($conn->query($insertSql)) {
    $productId = $conn->insert_id;
    
    // Insert into vendor_products
    $vendorSql = "INSERT INTO vendor_products (vendor_id, product_id) VALUES ($vendorId, $productId)";
    $conn->query($vendorSql);
    
    // ========== FIX: Insert stock into product_stock table ==========
    $stockSql = "INSERT INTO product_stock (product_id, vendor_id, quantity) VALUES ($productId, $vendorId, $stockQuantity)";
    if (!$conn->query($stockSql)) {
        $result['message'] = 'Product added but stock error: ' . $conn->error;
        echo json_encode($result);
        exit;
    }
    
    // Insert image if provided
    if (!empty($imageUrl)) {
        $imageSql = "INSERT INTO product_images (product_id, image_url, sort_order) VALUES ($productId, '" . mysqli_real_escape_string($conn, $imageUrl) . "', 1)";
        $conn->query($imageSql);
    }
    
    $result['success'] = true;
    $result['message'] = 'Product added successfully with stock: ' . $stockQuantity . ' units';
    $result['product_id'] = $productId;
} else {
    $result['message'] = 'Database error: ' . $conn->error;
}

echo json_encode($result);
$conn->close();
?>