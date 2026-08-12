<?php
/**
 * get_vendor_recent_reviews.php (Enhanced Version)
 * 
 * Includes additional validation and error handling
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

$loggedInUserId = $_SESSION['user_id'];

// Validate user_id is numeric
if (!is_numeric($loggedInUserId) || $loggedInUserId <= 0) {
    sendResponse(false, null, 'Invalid user session');
}

// Map user_id to vendor_id
$vendorId = $loggedInUserId - 10;

// Validate vendor_id range
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied. This account is not a vendor.');
}

// Optional: Verify vendor exists in vendors table
$vendorCheckSql = "SELECT vendor_id FROM vendors WHERE vendor_id = ?";
$vendorCheckStmt = $conn->prepare($vendorCheckSql);
$vendorCheckStmt->bind_param('i', $vendorId);
$vendorCheckStmt->execute();
$vendorCheckResult = $vendorCheckStmt->get_result();

if ($vendorCheckResult->num_rows === 0) {
    $vendorCheckStmt->close();
    sendResponse(false, null, 'Vendor not found');
}
$vendorCheckStmt->close();

// Fetch recent reviews
$sql = "SELECT 
            vr.vendor_review_id,
            vr.rating,
            vr.comment,
            vr.created_at,
            COALESCE(u.full_name, 'Anonymous Customer') as customer_name
        FROM vendor_reviews vr
        LEFT JOIN users u ON vr.user_id = u.user_id
        WHERE vr.vendor_id = ?
        ORDER BY vr.created_at DESC
        LIMIT 10";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    sendResponse(false, null, 'Unable to fetch reviews');
}

$stmt->bind_param('i', $vendorId);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = [
        'vendor_review_id' => (int)$row['vendor_review_id'],
        'customer_name' => htmlspecialchars($row['customer_name'], ENT_QUOTES, 'UTF-8'),
        'rating' => (int)$row['rating'],
        'comment' => htmlspecialchars($row['comment'] ?? '', ENT_QUOTES, 'UTF-8'),
        'created_at' => $row['created_at']
    ];
}

$stmt->close();
$conn->close();

sendResponse(true, $reviews);
?>