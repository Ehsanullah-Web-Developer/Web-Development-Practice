<?php
/**
 * filter_vendor_reviews.php (Fixed Version)
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $data = null, $message = null) {
    $response = ['success' => $success];
    if ($data !== null) $response['data'] = $data;
    if ($message !== null) $response['message'] = $message;
    echo json_encode($response);
    exit;
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please login first');
}

// Map to vendor_id
$vendorId = $_SESSION['user_id'] - 10;
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied. Vendor account required.');
}

// Get rating filter - convert to integer properly
$rating = isset($_GET['rating']) ? (int)$_GET['rating'] : 0;

// Debug: You can remove this after testing
error_log("Filtering reviews for vendor_id: $vendorId, rating: $rating");

// Build query
if ($rating > 0 && $rating <= 5) {
    $sql = "SELECT 
                vr.vendor_review_id,
                vr.rating,
                vr.comment,
                vr.created_at,
                p.name as product_name,
                u.full_name as customer_name
            FROM vendor_reviews vr
            INNER JOIN products p ON vr.product_id = p.product_id
            INNER JOIN users u ON vr.user_id = u.user_id
            WHERE vr.vendor_id = ? AND vr.rating = ?
            ORDER BY vr.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $vendorId, $rating);
} else {
    $sql = "SELECT 
                vr.vendor_review_id,
                vr.rating,
                vr.comment,
                vr.created_at,
                p.name as product_name,
                u.full_name as customer_name
            FROM vendor_reviews vr
            INNER JOIN products p ON vr.product_id = p.product_id
            INNER JOIN users u ON vr.user_id = u.user_id
            WHERE vr.vendor_id = ?
            ORDER BY vr.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $vendorId);
}

$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = [
        'vendor_review_id' => (int)$row['vendor_review_id'],
        'product_name' => $row['product_name'],
        'customer_name' => $row['customer_name'],
        'rating' => (int)$row['rating'],
        'comment' => $row['comment'] ?? '',
        'created_at' => $row['created_at']
    ];
}

$stmt->close();
$conn->close();

sendResponse(true, $reviews);
?>