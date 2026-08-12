<?php
session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

// Check login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please Login First']);
    exit;
}

$userId = $_SESSION['user_id'];

// Get payment_id
$inputData = json_decode(file_get_contents('php://input'), true);
$paymentId = isset($inputData['payment_id']) ? (int)$inputData['payment_id'] : 0;

if ($paymentId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid payment method ID']);
    exit;
}

// Update: Set all to 0 first, then set selected to 1
$conn->query("UPDATE user_payment_methods SET is_default = 0 WHERE user_id = $userId");
$conn->query("UPDATE user_payment_methods SET is_default = 1 WHERE payment_id = $paymentId AND user_id = $userId");

// Check if update worked
if ($conn->affected_rows > 0) {
    echo json_encode(['success' => true, 'message' => 'Default payment method updated']);
} else {
    echo json_encode(['success' => false, 'message' => 'Payment method not found. ID: ' . $paymentId]);
}

$conn->close();
?>