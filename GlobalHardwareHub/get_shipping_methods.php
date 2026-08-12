<?php
/**
 * get_shipping_methods.php
 * 
 * This API endpoint fetches all available shipping methods from the database
 * and returns them in JSON format for the checkout page.
 * 
 * Expected output: JSON format with list of shipping methods
 */

// Start session (optional - for tracking user if needed)
session_start();

// Include database connection
require_once 'db_connect.php';

// Set response header to JSON
header('Content-Type: application/json');

/**
 * Helper function to send JSON response and exit
 */
function sendResponse($success, $data = null, $message = null) {
    $response = [
        'success' => $success
    ];
    
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
 * STEP 1: Fetch all shipping methods from database
 * Only fetch columns that exist in your table
 * 
 * Note: If your table doesn't have 'description' or 'is_active' columns,
 * remove them from the query
 */
$sql = "
    SELECT 
        shipping_id,
        method_name,
        cost,
        estimated_date
    FROM shipping_methods 
    ORDER BY cost ASC
";

// Use prepared statement for security
$stmt = $conn->prepare($sql);

if (!$stmt) {
    // Database error occurred - don't expose details for security
    sendResponse(false, null, 'Unable to fetch shipping methods. Please try again later.');
}

$stmt->execute();
$result = $stmt->get_result();

/**
 * STEP 2: Build shipping methods array
 */
$shippingMethods = [];

while ($row = $result->fetch_assoc()) {
    $method = [
        'shipping_id' => (int)$row['shipping_id'],
        'method_name' => $row['method_name'],
        'cost' => (float)$row['cost'],
        'estimated_date' => $row['estimated_date']
    ];
    
    $shippingMethods[] = $method;
}

// Close the prepared statement
$stmt->close();

// Close database connection
$conn->close();

/**
 * STEP 3: Return success response with shipping methods
 * If no methods found, return empty array
 */
sendResponse(true, $shippingMethods);
?>