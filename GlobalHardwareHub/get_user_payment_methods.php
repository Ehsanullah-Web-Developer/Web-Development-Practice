<?php
/**
 * get_user_payment_methods.php (Fixed Version)
 * 
 * This version only uses columns that exist in your database table
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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please Login First');
}

$userId = (int)$_SESSION['user_id']; // Sanitize user ID

// Validate user ID is positive
if ($userId <= 0) {
    sendResponse(false, null, 'Invalid user session. Please login again.');
}

// Fetch payment methods - ONLY use columns that exist in your table
$sql = "SELECT 
            payment_id,
            card_type,
            card_last4,
            expiry_month,
            expiry_year,
            is_default
        FROM user_payment_methods 
        WHERE user_id = ? 
        ORDER BY is_default DESC, payment_id DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    sendResponse(false, null, 'Unable to fetch payment methods. Please try again later.');
}

$stmt->bind_param('i', $userId);

if (!$stmt->execute()) {
    sendResponse(false, null, 'Unable to fetch payment methods. Please try again later.');
}

$result = $stmt->get_result();
$paymentMethods = [];

while ($row = $result->fetch_assoc()) {
    // Build payment method array with only available fields
    $method = [
        'payment_id' => (int)$row['payment_id'],
        'card_type' => $row['card_type'],
        'card_last4' => $row['card_last4'],
        'expiry_month' => $row['expiry_month'],
        'expiry_year' => (int)$row['expiry_year'],
        'is_default' => (int)$row['is_default'],
        'expiry_formatted' => $row['expiry_month'] . '/' . $row['expiry_year'],
        'card_masked' => '**** **** **** ' . $row['card_last4']
    ];
    
    $paymentMethods[] = $method;
}

$stmt->close();
$conn->close();

sendResponse(true, $paymentMethods);
?>