<?php
/**
 * generate_sku.php
 * 
 * This API endpoint generates a unique SKU automatically for vendor products.
 * Format: GHH-XXXXXX (6 random digits)
 * 
 * Expected output: JSON format with generated SKU
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
function sendResponse($success, $sku = null, $message = null) {
    $response = ['success' => $success];
    
    if ($sku !== null) {
        $response['sku'] = $sku;
    }
    
    if ($message !== null) {
        $response['message'] = $message;
    }
    
    echo json_encode($response);
    exit;
}

/**
 * STEP 1: Check if user is logged in (vendor only)
 */
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please login first');
}

$loggedInUserId = $_SESSION['user_id'];

/**
 * STEP 2: Verify vendor account (user_id 11-18)
 */
$vendorId = $loggedInUserId - 10;
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied. Vendor account required.');
}

/**
 * STEP 3: Function to generate random 6-digit number
 */
function generateRandomSKU() {
    $prefix = "GHH-";
    $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    return $prefix . $randomNumber;
}

/**
 * STEP 4: Generate unique SKU (check against database)
 */
$maxAttempts = 10;
$attempt = 0;
$sku = null;

while ($attempt < $maxAttempts) {
    $sku = generateRandomSKU();
    
    // Check if SKU already exists in products table
    $checkSql = "SELECT product_id FROM products WHERE sku = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param('s', $sku);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows === 0) {
        // SKU is unique
        $checkStmt->close();
        sendResponse(true, $sku);
    }
    
    $checkStmt->close();
    $attempt++;
}

/**
 * STEP 5: If max attempts reached, generate timestamp-based SKU as fallback
 */
$fallbackSKU = "GHH-" . time();
sendResponse(true, $fallbackSKU);

$conn->close();
?>