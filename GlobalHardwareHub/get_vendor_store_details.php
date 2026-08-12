<?php
/**
 * get_vendor_store_details.php
 * 
 * This API returns store details for the logged-in vendor.
 * Combines data from vendors table and vendor_settings table.
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

$userId = $_SESSION['user_id'];
$vendorId = $userId - 10;

if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied. Vendor account required.');
}

// Get store details from vendors table
$vendorSql = "SELECT 
                vendor_id,
                store_name,
                logo_url,
                cover_image_url,
                description,
                rating,
                store_address,
                store_city,
                store_state,
                store_country,
                store_phone,
                store_email,
                map_image_url,
                founded_year,
                created_at
            FROM vendors 
            WHERE vendor_id = ?";

$vendorStmt = $conn->prepare($vendorSql);
$vendorStmt->bind_param('i', $vendorId);
$vendorStmt->execute();
$vendorResult = $vendorStmt->get_result();

if ($vendorResult->num_rows === 0) {
    $vendorStmt->close();
    sendResponse(false, null, 'Store not found');
}

$store = $vendorResult->fetch_assoc();
$vendorStmt->close();

// Get updated settings from vendor_settings table (these override vendor table data)
$settingsSql = "SELECT store_name, logo_url, cover_image_url, description FROM vendor_settings WHERE vendor_id = ?";
$settingsStmt = $conn->prepare($settingsSql);
$settingsStmt->bind_param('i', $vendorId);
$settingsStmt->execute();
$settingsResult = $settingsStmt->get_result();

if ($settingsResult->num_rows > 0) {
    $settings = $settingsResult->fetch_assoc();
    // Override with updated settings if they exist
    if (!empty($settings['store_name'])) $store['store_name'] = $settings['store_name'];
    if (!empty($settings['logo_url'])) $store['logo_url'] = $settings['logo_url'];
    if (!empty($settings['cover_image_url'])) $store['cover_image_url'] = $settings['cover_image_url'];
    if (!empty($settings['description'])) $store['description'] = $settings['description'];
}
$settingsStmt->close();

// Get product count
$productSql = "SELECT COUNT(*) as total_products FROM vendor_products WHERE vendor_id = ?";
$productStmt = $conn->prepare($productSql);
$productStmt->bind_param('i', $vendorId);
$productStmt->execute();
$productResult = $productStmt->get_result();
$productCount = $productResult->fetch_assoc()['total_products'];
$productStmt->close();

$conn->close();

// Prepare response
$storeData = [
    'vendor_id' => (int)$store['vendor_id'],
    'store_name' => $store['store_name'] ?? 'Vendor Store',
    'logo_url' => $store['logo_url'] ?? 'default-logo.jpg',
    'cover_image_url' => $store['cover_image_url'] ?? 'default-cover.jpg',
    'description' => $store['description'] ?? '',
    'rating' => (float)($store['rating'] ?? 0),
    'address' => $store['store_address'] ?? '',
    'city' => $store['store_city'] ?? '',
    'state' => $store['store_state'] ?? '',
    'country' => $store['store_country'] ?? 'Pakistan',
    'phone' => $store['store_phone'] ?? '',
    'email' => $store['store_email'] ?? '',
    'map_image_url' => $store['map_image_url'] ?? 'map-placeholder.jpg',
    'founded_year' => $store['founded_year'] ?? date('Y') - 2,
    'total_products' => (int)$productCount,
    'member_since' => date('Y', strtotime($store['created_at'] ?? 'now'))
];

sendResponse(true, $storeData);
?>