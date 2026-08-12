<?php
/**
 * update_vendor_policies.php
 * 
 * This API updates store policies for the logged-in vendor.
 * Updates: shipping_policy, return_policy, warranty_policy
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
    $shippingPolicy = isset($_POST['shipping_policy']) ? trim($_POST['shipping_policy']) : '';
    $returnPolicy = isset($_POST['return_policy']) ? trim($_POST['return_policy']) : '';
    $warrantyPolicy = isset($_POST['warranty_policy']) ? trim($_POST['warranty_policy']) : '';
} else {
    $shippingPolicy = isset($inputData['shipping_policy']) ? trim($inputData['shipping_policy']) : '';
    $returnPolicy = isset($inputData['return_policy']) ? trim($inputData['return_policy']) : '';
    $warrantyPolicy = isset($inputData['warranty_policy']) ? trim($inputData['warranty_policy']) : '';
}

// Update vendor_policies table
$sql = "UPDATE vendor_policies 
        SET shipping_policy = ?, return_policy = ?, warranty_policy = ? 
        WHERE vendor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sssi', $shippingPolicy, $returnPolicy, $warrantyPolicy, $vendorId);

if ($stmt->execute()) {
    $stmt->close();
    sendResponse(true, 'Store policies updated successfully');
} else {
    $stmt->close();
    sendResponse(false, 'Failed to update store policies');
}

$conn->close();
?>