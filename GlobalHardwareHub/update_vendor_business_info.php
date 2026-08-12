<?php
/**
 * update_vendor_business_info.php
 * 
 * This API updates business information for the logged-in vendor.
 * Updates: tax_id, business_address, city, country
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
    $taxId = isset($_POST['tax_id']) ? trim($_POST['tax_id']) : '';
    $businessAddress = isset($_POST['business_address']) ? trim($_POST['business_address']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';
} else {
    $taxId = isset($inputData['tax_id']) ? trim($inputData['tax_id']) : '';
    $businessAddress = isset($inputData['business_address']) ? trim($inputData['business_address']) : '';
    $city = isset($inputData['city']) ? trim($inputData['city']) : '';
    $country = isset($inputData['country']) ? trim($inputData['country']) : '';
}

// Validate
if (empty($businessAddress)) {
    sendResponse(false, 'Business address is required');
}
if (empty($city)) {
    sendResponse(false, 'City is required');
}
if (empty($country)) {
    sendResponse(false, 'Country is required');
}

// Update vendor_business_info table
$sql = "UPDATE vendor_business_info 
        SET tax_id = ?, business_address = ?, city = ?, country = ?, updated_at = NOW() 
        WHERE vendor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssi', $taxId, $businessAddress, $city, $country, $vendorId);

if ($stmt->execute()) {
    $stmt->close();
    sendResponse(true, 'Business information updated successfully');
} else {
    $stmt->close();
    sendResponse(false, 'Failed to update business information');
}

$conn->close();
?>