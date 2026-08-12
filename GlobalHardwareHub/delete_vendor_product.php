<?php
/**
 * delete_vendor_product.php
 * 
 * This API endpoint allows logged-in vendors to delete their products.
 * Deletes product from vendor_products table only if it belongs to the vendor.
 * 
 * Expected input: POST request with vp_id
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
 * STEP 4: Get and validate vp_id from POST data
 */
$inputData = json_decode(file_get_contents('php://input'), true);

// If JSON decoding failed, try regular POST
if ($inputData === null) {
    $vpId = isset($_POST['vp_id']) ? (int)$_POST['vp_id'] : 0;
} else {
    $vpId = isset($inputData['vp_id']) ? (int)$inputData['vp_id'] : 0;
}

// Validate vp_id
if ($vpId <= 0) {
    sendResponse(false, 'Invalid product ID');
}

/**
 * STEP 5: Verify product ownership and delete
 * First check if the product exists and belongs to this vendor
 */
$checkSql = "SELECT vp_id FROM vendor_products WHERE vp_id = ? AND vendor_id = ?";
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
    sendResponse(false, 'Product not found');
}
$checkStmt->close();

/**
 * STEP 6: Delete the product from vendor_products table
 */
$deleteSql = "DELETE FROM vendor_products WHERE vp_id = ? AND vendor_id = ?";
$deleteStmt = $conn->prepare($deleteSql);

if (!$deleteStmt) {
    sendResponse(false, 'Unable to delete product');
}

$deleteStmt->bind_param('ii', $vpId, $vendorId);

if ($deleteStmt->execute()) {
    // Check if any row was actually deleted
    if ($deleteStmt->affected_rows > 0) {
        $deleteStmt->close();
        sendResponse(true, 'Product deleted successfully');
    } else {
        $deleteStmt->close();
        sendResponse(false, 'Unable to delete product');
    }
} else {
    $deleteStmt->close();
    sendResponse(false, 'Unable to delete product');
}

// Close database connection
$conn->close();
?>