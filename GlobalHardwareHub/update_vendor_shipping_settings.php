<?php
/**
 * update_vendor_shipping_settings.php
 * 
 * This API updates shipping settings for the logged-in vendor.
 * Updates: default_shipping_method, available_methods, handling_time
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method');
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first');
}

$vendorId = $_SESSION['user_id'] - 10;
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, 'Access denied');
}

// Get POST data
$inputData = json_decode(file_get_contents('php://input'), true);
if ($inputData === null) {
    $defaultShippingMethod = isset($_POST['default_shipping_method']) ? trim($_POST['default_shipping_method']) : '';
    $availableMethods = isset($_POST['available_methods']) ? $_POST['available_methods'] : '';
    $handlingTime = isset($_POST['handling_time']) ? (int)$_POST['handling_time'] : 2;
} else {
    $defaultShippingMethod = isset($inputData['default_shipping_method']) ? trim($inputData['default_shipping_method']) : '';
    $availableMethods = isset($inputData['available_methods']) ? $inputData['available_methods'] : '';
    $handlingTime = isset($inputData['handling_time']) ? (int)$inputData['handling_time'] : 2;
}

// Validate
if (empty($defaultShippingMethod)) {
    sendResponse(false, 'Default shipping method is required');
}
if ($handlingTime < 1 || $handlingTime > 10) {
    sendResponse(false, 'Handling time must be between 1 and 10 days');
}

// Convert available_methods array to JSON string if it's an array
if (is_array($availableMethods)) {
    $availableMethods = json_encode($availableMethods);
}

// Update vendor_shipping_settings table
$sql = "UPDATE vendor_shipping_settings 
        SET default_shipping_method = ?, available_methods = ?, handling_time = ?, updated_at = NOW() 
        WHERE vendor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssii', $defaultShippingMethod, $availableMethods, $handlingTime, $vendorId);

if ($stmt->execute()) {
    $stmt->close();
    sendResponse(true, 'Shipping settings updated successfully');
} else {
    $stmt->close();
    sendResponse(false, 'Failed to update shipping settings');
}

$conn->close();
?>