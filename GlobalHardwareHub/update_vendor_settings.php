<?php
/**
 * update_vendor_settings.php
 * 
 * This API updates store information for the logged-in vendor.
 * Updates: store_name, logo_url, cover_image_url, description
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
    $storeName = isset($_POST['store_name']) ? trim($_POST['store_name']) : '';
    $logoUrl = isset($_POST['logo_url']) ? trim($_POST['logo_url']) : '';
    $coverUrl = isset($_POST['cover_image_url']) ? trim($_POST['cover_image_url']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
} else {
    $storeName = isset($inputData['store_name']) ? trim($inputData['store_name']) : '';
    $logoUrl = isset($inputData['logo_url']) ? trim($inputData['logo_url']) : '';
    $coverUrl = isset($inputData['cover_image_url']) ? trim($inputData['cover_image_url']) : '';
    $description = isset($inputData['description']) ? trim($inputData['description']) : '';
}

// Validate
if (empty($storeName)) {
    sendResponse(false, 'Store name is required');
}

// Update vendor_settings table
$sql = "UPDATE vendor_settings 
        SET store_name = ?, logo_url = ?, cover_image_url = ?, description = ?, updated_at = NOW() 
        WHERE vendor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssi', $storeName, $logoUrl, $coverUrl, $description, $vendorId);

if ($stmt->execute()) {
    $stmt->close();
    sendResponse(true, 'Store information updated successfully');
} else {
    $stmt->close();
    sendResponse(false, 'Failed to update store information');
}

$conn->close();
?>