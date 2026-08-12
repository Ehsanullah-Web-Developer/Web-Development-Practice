<?php
/**
 * reply_vendor_review.php
 * 
 * This API endpoint allows vendors to reply to customer reviews.
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

// Map to vendor_id
$vendorId = $_SESSION['user_id'] - 10;
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, 'Access denied. Vendor account required.');
}

// Get POST data
$inputData = json_decode(file_get_contents('php://input'), true);
$reviewId = isset($inputData['vendor_review_id']) ? (int)$inputData['vendor_review_id'] : 0;
$replyText = isset($inputData['reply_text']) ? trim($inputData['reply_text']) : '';

// Validate
if ($reviewId <= 0) {
    sendResponse(false, 'Invalid review ID');
}
if (empty($replyText)) {
    sendResponse(false, 'Reply text is required');
}
if (strlen($replyText) > 1000) {
    sendResponse(false, 'Reply text cannot exceed 1000 characters');
}

// Update reply
$stmt = $conn->prepare("UPDATE vendor_reviews SET reply_text = ?, reply_date = NOW() WHERE vendor_review_id = ? AND vendor_id = ?");
$stmt->bind_param('sii', $replyText, $reviewId, $vendorId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $stmt->close();
    sendResponse(true, 'Reply submitted successfully');
} else {
    $stmt->close();
    sendResponse(false, 'Review not found or access denied');
}

$conn->close();
?>