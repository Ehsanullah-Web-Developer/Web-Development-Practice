<?php
session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method');
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first');
}

// Get vendor ID
$vendorId = $_SESSION['user_id'] - 10;

// Get POST data
$inputData = [];
if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    $inputData = json_decode(file_get_contents('php://input'), true);
} else {
    $inputData = $_POST;
}

if (!$inputData || empty($inputData)) {
    sendResponse(false, 'No data received');
}

$productId = isset($inputData['product_id']) ? (int) $inputData['product_id'] : 0;
$productName = isset($inputData['product_name']) ? trim($inputData['product_name']) : '';
$sku = isset($inputData['sku']) ? trim($inputData['sku']) : '';
$categoryInput = isset($inputData['category_id']) ? $inputData['category_id'] : 0;
$description = isset($inputData['description']) ? trim($inputData['description']) : '';
$regularPrice = isset($inputData['regular_price']) ? (float) $inputData['regular_price'] : 0;
$salePrice = isset($inputData['sale_price']) && $inputData['sale_price'] !== '' && $inputData['sale_price'] !== null ? (float) $inputData['sale_price'] : null;
$status = isset($inputData['status']) ? $inputData['status'] : 'draft';
$imageUrl = isset($inputData['image_url']) ? trim($inputData['image_url']) : '';
$specifications = isset($inputData['specifications']) ? $inputData['specifications'] : [];
$stockQuantity = isset($inputData['stock_quantity']) ? (int) $inputData['stock_quantity'] : 0;


// Validate
if ($productId <= 0) {
    sendResponse(false, 'Invalid product ID');
}
if (empty($productName)) {
    sendResponse(false, 'Product name required');
}
if ($regularPrice <= 0) {
    sendResponse(false, 'Valid price required');
}

// Convert category name to category_id if needed
$categoryId = 0;
if (is_numeric($categoryInput) && $categoryInput > 0) {
    $categoryId = (int)$categoryInput;
} else {
    $catSql = "SELECT category_id FROM product_categories WHERE name = ?";
    $catStmt = $conn->prepare($catSql);
    $catStmt->bind_param("s", $categoryInput);
    $catStmt->execute();
    $catResult = $catStmt->get_result();
    if ($catRow = $catResult->fetch_assoc()) {
        $categoryId = $catRow['category_id'];
    }
    $catStmt->close();
}

// Check if product belongs to this vendor
$checkSql = "SELECT vp.product_id FROM vendor_products vp 
             WHERE vp.product_id = ? AND vp.vendor_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $productId, $vendorId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows == 0) {
    $checkStmt->close();
    sendResponse(false, 'Product not found or access denied');
}
$checkStmt->close();

// Update product (NO stock here - stock goes to product_stock table)
if ($salePrice !== null) {
    $updateSql = "UPDATE products SET 
        name = ?,
        sku = ?,
        category_id = ?,
        description = ?,
        regular_price = ?,
        sale_price = ?,
        status = ?
    WHERE product_id = ?";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssisdssi", $productName, $sku, $categoryId, $description, $regularPrice, $salePrice, $status, $productId);
} else {
    $updateSql = "UPDATE products SET 
        name = ?,
        sku = ?,
        category_id = ?,
        description = ?,
        regular_price = ?,
        sale_price = NULL,
        status = ?
    WHERE product_id = ?";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssisdsi", $productName, $sku, $categoryId, $description, $regularPrice, $status, $productId);
}

if (!$updateStmt->execute()) {
    $updateStmt->close();
    sendResponse(false, 'Database error: ' . $conn->error);
}
$updateStmt->close();

// ========== UPDATE STOCK USING DELETE + INSERT ==========
// First delete existing stock
$deleteSql = "DELETE FROM product_stock WHERE product_id = ? AND vendor_id = ?";
$deleteStmt = $conn->prepare($deleteSql);
$deleteStmt->bind_param("ii", $productId, $vendorId);
$deleteStmt->execute();
$deleteStmt->close();

// Then insert new stock
$insertSql = "INSERT INTO product_stock (product_id, vendor_id, quantity) VALUES (?, ?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param("iii", $productId, $vendorId, $stockQuantity);

if (!$insertStmt->execute()) {
    sendResponse(false, 'Stock insert error: ' . $conn->error);
}
$insertStmt->close();

// Update image if provided
if (!empty($imageUrl)) {
    $checkImgSql = "SELECT image_id FROM product_images WHERE product_id = ?";
    $checkImgStmt = $conn->prepare($checkImgSql);
    $checkImgStmt->bind_param("i", $productId);
    $checkImgStmt->execute();
    $imgResult = $checkImgStmt->get_result();
    
    if ($imgResult->num_rows > 0) {
        $updateImgSql = "UPDATE product_images SET image_url = ? WHERE product_id = ?";
        $updateImgStmt = $conn->prepare($updateImgSql);
        $updateImgStmt->bind_param("si", $imageUrl, $productId);
        $updateImgStmt->execute();
        $updateImgStmt->close();
    } else {
        $insertImgSql = "INSERT INTO product_images (product_id, image_url, sort_order) VALUES (?, ?, 1)";
        $insertImgStmt = $conn->prepare($insertImgSql);
        $insertImgStmt->bind_param("is", $productId, $imageUrl);
        $insertImgStmt->execute();
        $insertImgStmt->close();
    }
    $checkImgStmt->close();
}

// Update specifications
if (!empty($specifications)) {
    $deleteSpecSql = "DELETE FROM product_specifications WHERE product_id = ?";
    $deleteSpecStmt = $conn->prepare($deleteSpecSql);
    $deleteSpecStmt->bind_param("i", $productId);
    $deleteSpecStmt->execute();
    $deleteSpecStmt->close();
    
    $insertSpecSql = "INSERT INTO product_specifications (product_id, spec_key, spec_value) VALUES (?, ?, ?)";
    $insertSpecStmt = $conn->prepare($insertSpecSql);
    
    foreach ($specifications as $spec) {
        if (!empty($spec['key']) && !empty($spec['value'])) {
            $insertSpecStmt->bind_param("iss", $productId, $spec['key'], $spec['value']);
            $insertSpecStmt->execute();
        }
    }
    $insertSpecStmt->close();
}

$conn->close();
sendResponse(true, 'Product updated successfully with stock: ' . $stockQuantity . ' units');
?>