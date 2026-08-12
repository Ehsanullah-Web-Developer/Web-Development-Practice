<?php
/**
 * upload_vendor_logo.php
 * 
 * This API uploads store logo image for the logged-in vendor.
 * Saves image to uploads/vendors/logos/ folder.
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $message, $imageUrl = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($imageUrl !== null) {
        $response['image_url'] = $imageUrl;
    }
    echo json_encode($response);
    exit;
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first');
}

$vendorId = $_SESSION['user_id'] - 10;
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, 'Access denied');
}

// Check if file was uploaded
if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
    sendResponse(false, 'No image file uploaded');
}

$file = $_FILES['logo'];

// Validate file size (max 2MB)
if ($file['size'] > 2 * 1024 * 1024) {
    sendResponse(false, 'File size exceeds 2MB limit');
}

// Validate file extension
$allowed = ['jpg', 'jpeg', 'png', 'webp'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    sendResponse(false, 'Invalid file type. Allowed: JPG, JPEG, PNG, WEBP');
}

// Create directory if not exists
$uploadDir = 'uploads/vendors/logos/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Generate unique filename
$newFileName = 'vendor_' . $vendorId . '_logo_' . time() . '.' . $ext;
$uploadPath = $uploadDir . $newFileName;

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    // Update database with new logo URL
    $stmt = $conn->prepare("UPDATE vendor_settings SET logo_url = ? WHERE vendor_id = ?");
    $stmt->bind_param('si', $uploadPath, $vendorId);
    $stmt->execute();
    $stmt->close();
    
    sendResponse(true, 'Logo uploaded successfully', $uploadPath);
} else {
    sendResponse(false, 'Failed to upload image');
}

$conn->close();
?>