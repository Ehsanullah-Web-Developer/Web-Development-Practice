<?php
/**
 * submit_warranty_claim.php
 * 
 * This API endpoint allows logged-in users to submit warranty claims
 * from the WarrantyInfo page.
 * 
 * Expected input: POST request with form fields
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
 * STEP 3: Get and sanitize form data
 */
$orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
$productName = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
$serialNumber = isset($_POST['serial_number']) ? trim($_POST['serial_number']) : '';
$issueDescription = isset($_POST['issue_description']) ? trim($_POST['issue_description']) : '';

/**
 * STEP 4: Validate required fields
 */
if ($orderId <= 0) {
    sendResponse(false, 'Order ID is required');
}

if (empty($productName)) {
    sendResponse(false, 'Product name is required');
}

if (empty($serialNumber)) {
    sendResponse(false, 'Serial number is required');
}

if (empty($issueDescription)) {
    sendResponse(false, 'Issue description is required');
}

/**
 * STEP 5: Find product_id from products table using product_name
 */
$productSql = "SELECT product_id FROM products WHERE name = ? OR name LIKE ? LIMIT 1";
$productStmt = $conn->prepare($productSql);

if (!$productStmt) {
    sendResponse(false, 'Unable to verify product');
}

$searchTerm = '%' . $productName . '%';
$productStmt->bind_param('ss', $productName, $searchTerm);
$productStmt->execute();
$productResult = $productStmt->get_result();

if ($productResult->num_rows === 0) {
    $productStmt->close();
    sendResponse(false, 'Product not found. Please check the product name.');
}

$product = $productResult->fetch_assoc();
$productId = $product['product_id'];
$productStmt->close();

/**
 * STEP 6: Verify order belongs to user and find vendor_id from order_items
 */
$orderSql = "SELECT o.user_id, oi.vendor_id 
             FROM orders o 
             INNER JOIN order_items oi ON o.order_id = oi.order_id 
             WHERE o.order_id = ? AND o.user_id = ? AND oi.product_id = ? 
             LIMIT 1";

$orderStmt = $conn->prepare($orderSql);

if (!$orderStmt) {
    sendResponse(false, 'Unable to verify order');
}

$orderStmt->bind_param('iii', $orderId, $userId, $productId);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

if ($orderResult->num_rows === 0) {
    $orderStmt->close();
    sendResponse(false, 'Order not found or product not in this order');
}

$orderData = $orderResult->fetch_assoc();
$vendorId = $orderData['vendor_id'];
$orderStmt->close();

/**
 * STEP 7: Handle image upload (if provided)
 */
$imageUrl = null;

if (isset($_FILES['upload_image']) && $_FILES['upload_image']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['upload_image'];
    $fileName = basename($file['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    
    // Validate file extension
    if (!in_array($fileExt, $allowedExts)) {
        sendResponse(false, 'Invalid image type. Allowed: JPG, PNG, GIF, WEBP');
    }
    
    // Validate file size
    if ($file['size'] > $maxFileSize) {
        sendResponse(false, 'Image too large. Maximum size is 5MB');
    }
    
    // Create upload directory if not exists
    $uploadDir = 'uploads/warranty/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Generate unique filename
    $newFileName = 'warranty_' . $userId . '_' . time() . '_' . rand(1000, 9999) . '.' . $fileExt;
    $uploadPath = $uploadDir . $newFileName;
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $imageUrl = $uploadPath;
    }
}

/**
 * STEP 8: Check if warranty_claims table has additional columns
 */
$hasOrderId = false;
$hasSerialNumber = false;
$hasImageUrl = false;

$columnsQuery = $conn->query("SHOW COLUMNS FROM warranty_claims");
if ($columnsQuery) {
    while ($col = $columnsQuery->fetch_assoc()) {
        if ($col['Field'] === 'order_id') $hasOrderId = true;
        if ($col['Field'] === 'serial_number') $hasSerialNumber = true;
        if ($col['Field'] === 'image_url') $hasImageUrl = true;
    }
}

/**
 * STEP 9: Insert claim into warranty_claims table
 */
// Build dynamic query based on available columns
$insertSql = "INSERT INTO warranty_claims (product_id, user_id, vendor_id, claim_reason, status, created_at";
$insertValues = " VALUES (?, ?, ?, ?, 'pending', NOW()";
$paramTypes = "iiis";
$params = [$productId, $userId, $vendorId, $issueDescription];

if ($hasOrderId && $orderId > 0) {
    $insertSql .= ", order_id";
    $insertValues .= ", ?";
    $paramTypes .= "i";
    $params[] = $orderId;
}

if ($hasSerialNumber && !empty($serialNumber)) {
    $insertSql .= ", serial_number";
    $insertValues .= ", ?";
    $paramTypes .= "s";
    $params[] = $serialNumber;
}

if ($hasImageUrl && $imageUrl) {
    $insertSql .= ", image_url";
    $insertValues .= ", ?";
    $paramTypes .= "s";
    $params[] = $imageUrl;
}

$insertSql .= ")";
$insertValues .= ")";
$fullSql = $insertSql . $insertValues;

$insertStmt = $conn->prepare($fullSql);

if (!$insertStmt) {
    sendResponse(false, 'Unable to submit claim. Please try again.');
}

// Dynamic binding
$insertStmt->bind_param($paramTypes, ...$params);

if ($insertStmt->execute()) {
    $insertStmt->close();
    sendResponse(true, 'Warranty claim submitted successfully');
} else {
    $insertStmt->close();
    sendResponse(false, 'Unable to submit claim. Please try again.');
}

$conn->close();
?>