<?php
/**
 * update_vendor_payment_settings.php
 * 
 * This API updates payment settings for the logged-in vendor.
 * Updates: payment_method, bank_name, account_title, account_number
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
    $paymentMethod = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';
    $bankName = isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '';
    $accountTitle = isset($_POST['account_title']) ? trim($_POST['account_title']) : '';
    $accountNumber = isset($_POST['account_number']) ? trim($_POST['account_number']) : '';
} else {
    $paymentMethod = isset($inputData['payment_method']) ? trim($inputData['payment_method']) : '';
    $bankName = isset($inputData['bank_name']) ? trim($inputData['bank_name']) : '';
    $accountTitle = isset($inputData['account_title']) ? trim($inputData['account_title']) : '';
    $accountNumber = isset($inputData['account_number']) ? trim($inputData['account_number']) : '';
}

// Validate
if (empty($paymentMethod)) {
    sendResponse(false, 'Payment method is required');
}

// Update vendor_payment_settings table
$sql = "UPDATE vendor_payment_settings 
        SET payment_method = ?, bank_name = ?, account_title = ?, account_number = ?, updated_at = NOW() 
        WHERE vendor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssi', $paymentMethod, $bankName, $accountTitle, $accountNumber, $vendorId);

if ($stmt->execute()) {
    $stmt->close();
    sendResponse(true, 'Payment settings updated successfully');
} else {
    $stmt->close();
    sendResponse(false, 'Failed to update payment settings');
}

$conn->close();
?>