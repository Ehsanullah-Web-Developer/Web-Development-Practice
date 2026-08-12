<?php
session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $message, $data = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($data) $response['data'] = $data;
    echo json_encode($response);
    exit;
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please Login first');
}

// Get promo code
$inputData = json_decode(file_get_contents('php://input'), true);
$promoCode = isset($inputData['promo_code']) ? trim($inputData['promo_code']) : '';
$subtotal = isset($inputData['subtotal']) ? (float)$inputData['subtotal'] : 0;

if (empty($promoCode)) {
    sendResponse(false, 'Please enter a promo code');
}

// Find coupon in your table
$sql = "SELECT * FROM coupons WHERE code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $promoCode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    sendResponse(false, 'Invalid promo code');
}

$coupon = $result->fetch_assoc();
$currentDate = date('Y-m-d H:i:s');

// Check start date
if ($coupon['start_date'] && $currentDate < $coupon['start_date']) {
    sendResponse(false, 'Promo code is not yet active');
}

// Check end date (using your column name end_date after renaming)
if ($coupon['end_date'] && $currentDate > $coupon['end_date']) {
    sendResponse(false, 'Promo code has expired');
}

// Check usage limit
if ($coupon['usage_limit'] > 0) {
    $usedSql = "SELECT COUNT(*) as used_count FROM orders WHERE coupon_code = ?";
    $usedStmt = $conn->prepare($usedSql);
    $usedStmt->bind_param('s', $promoCode);
    $usedStmt->execute();
    $usedResult = $usedStmt->get_result();
    $usedCount = $usedResult->fetch_assoc()['used_count'];
    $usedStmt->close();
    
    if ($usedCount >= $coupon['usage_limit']) {
        sendResponse(false, 'Promo code usage limit reached');
    }
}

// Calculate discount (using your 'discount' column)
$discountAmount = (float)$coupon['discount'];

// Ensure discount doesn't exceed subtotal
if ($discountAmount > $subtotal) {
    $discountAmount = $subtotal;
}

$grandTotal = $subtotal - $discountAmount;

sendResponse(true, 'Promo code applied successfully', [
    'code' => $coupon['code'],
    'discount_amount' => round($discountAmount, 2),
    'subtotal' => round($subtotal, 2),
    'grand_total' => round($grandTotal, 2)
]);

$conn->close();
?>