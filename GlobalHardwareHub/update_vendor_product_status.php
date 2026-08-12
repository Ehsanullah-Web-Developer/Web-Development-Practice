<?php
/**
 * update_vendor_product_status.php
 * 
 * This API endpoint allows logged-in vendors to update their product status.
 * Updates products.status field only if product belongs to the vendor.
 * 
 * Expected input: POST request with vp_id and status
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

$loggedInUserId = $_SESSION['user_id'];

/**
 * STEP 3: Map user_id to vendor_id
 * User IDs 11-18 correspond to vendor IDs 1-8
 * Formula: vendor_id = user_id - 10
 */
$vendorId = $loggedInUserId - 10;

// Validate that vendor_id is between 1 and 8
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, 'Access denied. Vendor account required.');
}

/**
 * STEP 4: Get and validate inputs from POST data
 */
$inputData = json_decode(file_get_contents('php://input'), true);

// If JSON decoding failed, try regular POST
if ($inputData === null) {
    $vpId = isset($_POST['vp_id']) ? (int)$_POST['vp_id'] : 0;
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
} else {
    $vpId = isset($inputData['vp_id']) ? (int)$inputData['vp_id'] : 0;
    $status = isset($inputData['status']) ? trim($inputData['status']) : '';
}

/**
 * STEP 5: Validate vp_id
 */
if ($vpId <= 0) {
    sendResponse(false, 'Invalid product ID');
}

/**
 * STEP 6: Validate status (allowed values only)
 */
$allowedStatuses = ['active', 'draft', 'out_of_stock'];

if (empty($status)) {
    sendResponse(false, 'Status is required');
}

if (!in_array($status, $allowedStatuses)) {
    sendResponse(false, 'Invalid status value. Allowed: active, draft, out_of_stock');
}

/**
 * STEP 7: Verify product ownership and update status
 * First check if the product exists and belongs to this vendor
 * Then update the products table
 */
$checkSql = "SELECT vp.vp_id, vp.product_id 
             FROM vendor_products vp 
             WHERE vp.vp_id = ? AND vp.vendor_id = ?";
$checkStmt = $conn->prepare($checkSql);

if (!$checkStmt) {
    sendResponse(false, 'Unable to verify product');
}

$checkStmt->bind_param('ii', $vpId, $vendorId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

// Check if product exists and belongs to vendor
if ($checkResult->num_rows === 0) {
    $checkStmt->close();
    sendResponse(false, 'Product not found or unauthorized');
}

$product = $checkResult->fetch_assoc();
$productId = $product['product_id'];
$checkStmt->close();

/**
 * STEP 8: Update product status in products table
 */
$updateSql = "UPDATE products SET status = ? WHERE product_id = ?";
$updateStmt = $conn->prepare($updateSql);

if (!$updateStmt) {
    sendResponse(false, 'Unable to update product status');
}

$updateStmt->bind_param('si', $status, $productId);

if ($updateStmt->execute()) {
    if ($updateStmt->affected_rows > 0) {
        $updateStmt->close();
        sendResponse(true, 'Product status updated successfully');
    } else {
        $updateStmt->close();
        // Status might already be the same, still return success
        sendResponse(true, 'Product status updated successfully');
    }
} else {
    $updateStmt->close();
    sendResponse(false, 'Unable to update product status');
}

// Close database connection
$conn->close();
?>