<?php
/**
 * get_vendor_settings.php
 * 
 * This API fetches all settings for the logged-in vendor.
 * Returns store info, policies, payment, business, shipping, and notification settings.
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

$vendorId = $_SESSION['user_id'] - 10;
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied');
}

// 1. Get Store Settings
$storeSql = "SELECT store_name, logo_url, cover_image_url, description FROM vendor_settings WHERE vendor_id = ?";
$storeStmt = $conn->prepare($storeSql);
$storeStmt->bind_param('i', $vendorId);
$storeStmt->execute();
$storeResult = $storeStmt->get_result();
$storeSettings = $storeResult->fetch_assoc();
$storeStmt->close();

// 2. Get Policies
$policySql = "SELECT shipping_policy, return_policy, warranty_policy FROM vendor_policies WHERE vendor_id = ?";
$policyStmt = $conn->prepare($policySql);
$policyStmt->bind_param('i', $vendorId);
$policyStmt->execute();
$policyResult = $policyStmt->get_result();
$policies = $policyResult->fetch_assoc();
$policyStmt->close();

// 3. Get Payment Settings
$paymentSql = "SELECT payment_method, bank_name, account_title, account_number FROM vendor_payment_settings WHERE vendor_id = ?";
$paymentStmt = $conn->prepare($paymentSql);
$paymentStmt->bind_param('i', $vendorId);
$paymentStmt->execute();
$paymentResult = $paymentStmt->get_result();
$paymentSettings = $paymentResult->fetch_assoc();
$paymentStmt->close();

// 4. Get Business Info
$businessSql = "SELECT tax_id, business_address, city, country FROM vendor_business_info WHERE vendor_id = ?";
$businessStmt = $conn->prepare($businessSql);
$businessStmt->bind_param('i', $vendorId);
$businessStmt->execute();
$businessResult = $businessStmt->get_result();
$businessInfo = $businessResult->fetch_assoc();
$businessStmt->close();

// 5. Get Shipping Settings
$shippingSql = "SELECT default_shipping_method, available_methods, handling_time FROM vendor_shipping_settings WHERE vendor_id = ?";
$shippingStmt = $conn->prepare($shippingSql);
$shippingStmt->bind_param('i', $vendorId);
$shippingStmt->execute();
$shippingResult = $shippingStmt->get_result();
$shippingSettings = $shippingResult->fetch_assoc();
$shippingStmt->close();

// 6. Get Notification Settings
$notifySql = "SELECT email_notification, sms_notification, order_updates, promotions_offers FROM vendor_notification_settings WHERE vendor_id = ?";
$notifyStmt = $conn->prepare($notifySql);
$notifyStmt->bind_param('i', $vendorId);
$notifyStmt->execute();
$notifyResult = $notifyStmt->get_result();
$notificationSettings = $notifyResult->fetch_assoc();
$notifyStmt->close();

$conn->close();

$data = [
    'store' => $storeSettings ?: [],
    'policies' => $policies ?: [],
    'payment' => $paymentSettings ?: [],
    'business' => $businessInfo ?: [],
    'shipping' => $shippingSettings ?: [],
    'notifications' => $notificationSettings ?: []
];

sendResponse(true, $data);
?>