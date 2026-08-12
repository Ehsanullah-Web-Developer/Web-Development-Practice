<?php
/**
 * get_product_categories.php
 * 
 * This API endpoint fetches all product categories for dropdown selection.
 * Used in Vendor Add Product page.
 * 
 * Expected output: JSON format with categories data
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
function sendResponse($success, $data = null, $message = null) {
    $response = ['success' => $success];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    if ($message !== null) {
        $response['message'] = $message;
    }
    
    echo json_encode($response);
    exit;
}

/**
 * STEP 1: Check if user is logged in (optional - allow for vendors only)
 */
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please login first');
}

$loggedInUserId = $_SESSION['user_id'];

/**
 * STEP 2: Map user_id to vendor_id (verify vendor access)
 * User IDs 11-18 correspond to vendor IDs 1-8
 */
$vendorId = $loggedInUserId - 10;

// Validate that vendor_id is between 1 and 8
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied. Vendor account required.');
}

/**
 * STEP 3: Fetch all categories
 */
$sql = "SELECT category_id, name, description, image_url 
        FROM product_categories 
        ORDER BY name ASC";

$result = $conn->query($sql);

if (!$result) {
    sendResponse(false, null, 'Unable to fetch categories');
}

/**
 * STEP 4: Build categories array
 */
$categories = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = [
        'category_id' => (int)$row['category_id'],
        'name' => $row['name'],
        'description' => $row['description'] ?? '',
        'image_url' => $row['image_url'] ?? ''
    ];
}

/**
 * STEP 5: Return success response
 */
sendResponse(true, $categories);

$conn->close();
?>