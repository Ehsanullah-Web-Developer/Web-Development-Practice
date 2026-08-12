<?php
/**
 * update_vendor_notification_settings.php
 * 
 * This API updates notification preferences for the logged-in vendor.
 * Updates: email_notification, sms_notification, order_updates, promotions_offers
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
    $emailNotification = isset($_POST['email_notification']) ? (int)$_POST['email_notification'] : 1;
    $smsNotification = isset($_POST['sms_notification']) ? (int)$_POST['sms_notification'] : 0;
    $orderUpdates = isset($_POST['order_updates']) ? (int)$_POST['order_updates'] : 1;
    $promotionsOffers = isset($_POST['promotions_offers']) ? (int)$_POST['promotions_offers'] : 1;
} else {
    $emailNotification = isset($inputData['email_notification']) ? (int)$inputData['email_notification'] : 1;
    $smsNotification = isset($inputData['sms_notification']) ? (int)$inputData['sms_notification'] : 0;
    $orderUpdates = isset($inputData['order_updates']) ? (int)$inputData['order_updates'] : 1;
    $promotionsOffers = isset($inputData['promotions_offers']) ? (int)$inputData['promotions_offers'] : 1;
}

// Validate values (must be 0 or 1)
$emailNotification = ($emailNotification == 1) ? 1 : 0;
$smsNotification = ($smsNotification == 1) ? 1 : 0;
$orderUpdates = ($orderUpdates == 1) ? 1 : 0;
$promotionsOffers = ($promotionsOffers == 1) ? 1 : 0;

// Update vendor_notification_settings table
$sql = "UPDATE vendor_notification_settings 
        SET email_notification = ?, sms_notification = ?, order_updates = ?, promotions_offers = ?, updated_at = NOW() 
        WHERE vendor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('iiiii', $emailNotification, $smsNotification, $orderUpdates, $promotionsOffers, $vendorId);

if ($stmt->execute()) {
    $stmt->close();
    sendResponse(true, 'Notification preferences updated successfully');
} else {
    $stmt->close();
    sendResponse(false, 'Failed to update notification preferences');
}

$conn->close();
?>