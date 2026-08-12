<?php
/**
 * add_user_address.php
 * 
 * This API endpoint saves user address from checkout form into the database
 * Maps frontend form fields to database table columns
 * 
 * Frontend Fields:
 * - fullname
 * - phone_number
 * - address_line
 * - city
 * - postal_code
 * - country
 * - save_for_future (checkbox)
 * 
 * Database Table: user_addresses
 */

// Start session to check user login status
session_start();

// Include database connection
require_once 'db_connect.php';

// Set response header to JSON
header('Content-Type: application/json');

/**
 * Helper function to send JSON response and exit
 */
function sendResponse($success, $message, $addressId = null) {
    $response = [
        'success' => $success,
        'message' => $message
    ];
    
    if ($addressId !== null) {
        $response['address_id'] = $addressId;
    }
    
    echo json_encode($response);
    exit;
}

/**
 * STEP 1: Check if user is logged in
 */
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first to save address');
}

$userId = $_SESSION['user_id'];

/**
 * STEP 2: Get POST data from frontend form
 */
// Try to get from JSON first, then fallback to form data
$inputData = json_decode(file_get_contents('php://input'), true);

if ($inputData === null) {
    // Regular form POST
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $address_line = isset($_POST['address_line']) ? trim($_POST['address_line']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $postal_code = isset($_POST['postal_code']) ? trim($_POST['postal_code']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';
    $save_for_future = isset($_POST['save_for_future']) ? $_POST['save_for_future'] : 'off';
} else {
    // JSON data
    $fullname = isset($inputData['fullname']) ? trim($inputData['fullname']) : '';
    $phone_number = isset($inputData['phone_number']) ? trim($inputData['phone_number']) : '';
    $address_line = isset($inputData['address_line']) ? trim($inputData['address_line']) : '';
    $city = isset($inputData['city']) ? trim($inputData['city']) : '';
    $postal_code = isset($inputData['postal_code']) ? trim($inputData['postal_code']) : '';
    $country = isset($inputData['country']) ? trim($inputData['country']) : '';
    $save_for_future = isset($inputData['save_for_future']) ? $inputData['save_for_future'] : 'off';
}

/**
 * STEP 3: Validate required fields
 */
if (empty($fullname)) {
    sendResponse(false, 'Full name is required');
}

if (empty($phone_number)) {
    sendResponse(false, 'Phone number is required');
}

if (empty($address_line)) {
    sendResponse(false, 'Address line is required');
}

if (empty($city)) {
    sendResponse(false, 'City is required');
}

if (empty($postal_code)) {
    sendResponse(false, 'Postal code is required');
}

if (empty($country)) {
    sendResponse(false, 'Country is required');
}

/**
 * STEP 4: Map frontend fields to database fields
 * 
 * Mapping Rules:
 * - label = fullname
 * - address_line1 = address_line
 * - address_line2 = phone_number
 * - city = city
 * - state = 'Punjab' (or any default Pakistani province)
 * - postal_code = postal_code
 * - country = country
 * - is_default = 1 if checkbox checked, else 0
 */

// Determine if this should be default address
$isDefault = 0;
if ($save_for_future === 'on' || $save_for_future === true || $save_for_future === 'true' || $save_for_future === 1) {
    $isDefault = 1;
}

// List of Pakistani provinces (you can change this or make it dynamic)
$pakistaniProvinces = [
    'Punjab', 
    'Sindh', 
    'Khyber Pakhtunkhwa', 
    'Balochistan', 
    'Islamabad Capital Territory', 
    'Gilgit-Baltistan', 
    'Azad Kashmir'
];

// You can use a default province or try to detect from city
$state = 'Punjab'; // Default province

// Optional: Auto-detect province based on city
$cityLower = strtolower($city);
if (strpos($cityLower, 'karachi') !== false || strpos($cityLower, 'hyderabad') !== false || strpos($cityLower, 'sukkur') !== false) {
    $state = 'Sindh';
} elseif (strpos($cityLower, 'lahore') !== false || strpos($cityLower, 'multan') !== false || strpos($cityLower, 'faisalabad') !== false || strpos($cityLower, 'rawalpindi') !== false) {
    $state = 'Punjab';
} elseif (strpos($cityLower, 'peshawar') !== false || strpos($cityLower, 'abbottabad') !== false || strpos($cityLower, 'mardan') !== false) {
    $state = 'Khyber Pakhtunkhwa';
} elseif (strpos($cityLower, 'quetta') !== false) {
    $state = 'Balochistan';
} elseif (strpos($cityLower, 'islamabad') !== false) {
    $state = 'Islamabad Capital Territory';
}

/**
 * STEP 5: If this address is set as default, remove default flag from other addresses
 */
if ($isDefault == 1) {
    $updateSql = "UPDATE user_addresses SET is_default = 0 WHERE user_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    
    if ($updateStmt) {
        $updateStmt->bind_param('i', $userId);
        $updateStmt->execute();
        $updateStmt->close();
    }
}

/**
 * STEP 6: Insert the new address into database
 */
$insertSql = "INSERT INTO user_addresses (
    user_id, 
    label, 
    address_line1, 
    address_line2, 
    city, 
    state, 
    postal_code, 
    country, 
    is_default
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$insertStmt = $conn->prepare($insertSql);

if (!$insertStmt) {
    sendResponse(false, 'Database error. Please try again.');
}

// Bind parameters
$insertStmt->bind_param(
    'isssssssi',
    $userId,
    $fullname,          // label = fullname
    $address_line,      // address_line1 = address_line
    $phone_number,      // address_line2 = phone_number
    $city,              // city = city
    $state,             // state = province
    $postal_code,       // postal_code = postal_code
    $country,           // country = country
    $isDefault          // is_default = checkbox value
);

if ($insertStmt->execute()) {
    $addressId = $insertStmt->insert_id;
    $insertStmt->close();
    
    // Success response
    sendResponse(true, 'Address saved successfully', $addressId);
} else {
    $insertStmt->close();
    sendResponse(false, 'Failed to save address. Please try again.');
}

// Close database connection
$conn->close();
?>