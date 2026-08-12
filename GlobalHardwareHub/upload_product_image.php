<?php
/**
 * upload_product_image.php
 * 
 * This API endpoint handles product image upload for vendors.
 * Uploads image to uploads/products/ folder and returns the file path.
 * 
 * Expected input: POST FormData with 'product_image' file
 * Expected output: JSON format with image_url or error message
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
function sendResponse($success, $imageUrl = null, $message = null) {
    $response = ['success' => $success];
    
    if ($imageUrl !== null) {
        $response['image_url'] = $imageUrl;
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
 * STEP 3: Check if file was uploaded
 */
if (!isset($_FILES['product_image']) || $_FILES['product_image']['error'] !== UPLOAD_ERR_OK) {
    $errorCode = isset($_FILES['product_image']['error']) ? $_FILES['product_image']['error'] : 'No file uploaded';
    sendResponse(false, null, 'No image file uploaded');
}

$file = $_FILES['product_image'];

/**
 * STEP 4: Validate file size (max 5MB = 5 * 1024 * 1024 bytes)
 */
$maxFileSize = 5 * 1024 * 1024; // 5MB
if ($file['size'] > $maxFileSize) {
    sendResponse(false, null, 'File size exceeds 5MB limit');
}

/**
 * STEP 5: Validate file extension
 */
$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedExtensions)) {
    sendResponse(false, null, 'Invalid file type. Allowed: JPG, JPEG, PNG, WEBP');
}

/**
 * STEP 6: Validate file mime type (additional security)
 */
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedMimeTypes)) {
    sendResponse(false, null, 'Invalid image type. Please upload a valid image file.');
}

/**
 * STEP 7: Create upload directory if not exists
 */
$uploadDir = 'uploads/products/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/**
 * STEP 8: Generate unique filename
 */
$timestamp = time();
$randomNumber = rand(1000, 9999);
$newFileName = 'img_' . $timestamp . '_' . $randomNumber . '.' . $fileExtension;
$uploadPath = $uploadDir . $newFileName;

/**
 * STEP 9: Move uploaded file to destination
 */
if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    sendResponse(true, $uploadPath);
} else {
    sendResponse(false, null, 'Failed to upload image. Please try again.');
}

$conn->close();
?>