<?php
/**
 * add_user_payment_method.php
 * 
 * This API endpoint allows logged-in users to add a new saved payment method.
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please Login First');
}

$userId = $_SESSION['user_id'];

// Get POST data
$inputData = json_decode(file_get_contents('php://input'), true);

if ($inputData === null) {
    $cardholderName = isset($_POST['cardholder_name']) ? trim($_POST['cardholder_name']) : '';
    $cardNumber = isset($_POST['card_number']) ? preg_replace('/\s+/', '', trim($_POST['card_number'])) : '';
    $expiryDate = isset($_POST['expiry_date']) ? trim($_POST['expiry_date']) : '';
    $cvv = isset($_POST['cvv']) ? trim($_POST['cvv']) : '';
    $isDefault = isset($_POST['is_default']) ? $_POST['is_default'] : 'off';
} else {
    $cardholderName = isset($inputData['cardholder_name']) ? trim($inputData['cardholder_name']) : '';
    $cardNumber = isset($inputData['card_number']) ? preg_replace('/\s+/', '', trim($inputData['card_number'])) : '';
    $expiryDate = isset($inputData['expiry_date']) ? trim($inputData['expiry_date']) : '';
    $cvv = isset($inputData['cvv']) ? trim($inputData['cvv']) : '';
    $isDefault = isset($inputData['is_default']) ? $inputData['is_default'] : 'off';
}

// Validate required fields
if (empty($cardholderName)) sendResponse(false, 'Cardholder name is required');
if (empty($cardNumber)) sendResponse(false, 'Card number is required');
if (empty($expiryDate)) sendResponse(false, 'Expiry date is required');
if (empty($cvv)) sendResponse(false, 'CVV is required');

// Validate card number
if (!ctype_digit($cardNumber)) {
    sendResponse(false, 'Card number must contain only digits');
}

$cardLength = strlen($cardNumber);
if ($cardLength < 13 || $cardLength > 19) {
    sendResponse(false, 'Invalid card number length');
}

// Determine card type
function getCardType($cardNumber) {
    $firstDigit = substr($cardNumber, 0, 1);
    $firstTwoDigits = substr($cardNumber, 0, 2);
    $firstFourDigits = substr($cardNumber, 0, 4);
    
    if ($firstDigit == '4') return 'Visa';
    if ($firstTwoDigits >= 51 && $firstTwoDigits <= 55) return 'Mastercard';
    if ($firstFourDigits >= 2221 && $firstFourDigits <= 2720) return 'Mastercard';
    if ($firstTwoDigits == '34' || $firstTwoDigits == '37') return 'American Express';
    if ($firstTwoDigits == '65' || $firstFourDigits == '6011') return 'Discover';
    return 'Credit Card';
}

$cardType = getCardType($cardNumber);
$cardLast4 = substr($cardNumber, -4);

// Validate expiry date
if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $expiryDate, $matches)) {
    sendResponse(false, 'Invalid expiry date format. Use MM/YY');
}

$expiryMonth = $matches[1];
$expiryYear = '20' . $matches[2];

// Check if card is expired
$currentYear = date('Y');
$currentMonth = date('m');

if ($expiryYear < $currentYear || ($expiryYear == $currentYear && $expiryMonth < $currentMonth)) {
    sendResponse(false, 'Card has expired');
}

// Validate CVV
if (!ctype_digit($cvv)) {
    sendResponse(false, 'CVV must contain only digits');
}
if (strlen($cvv) < 3 || strlen($cvv) > 4) {
    sendResponse(false, 'Invalid CVV length');
}

// Determine default flag
$isDefaultValue = ($isDefault === 'on' || $isDefault === true || $isDefault === 'true' || $isDefault === 1) ? 1 : 0;

// Start transaction
$conn->begin_transaction();

try {
    // If this is default, remove default from other methods
    if ($isDefaultValue == 1) {
        $updateStmt = $conn->prepare("UPDATE user_payment_methods SET is_default = 0 WHERE user_id = ?");
        if ($updateStmt) {
            $updateStmt->bind_param('i', $userId);
            $updateStmt->execute();
            $updateStmt->close();
        }
    }
    
    // Check if table has card_holder_name column
    $checkColumn = $conn->query("SHOW COLUMNS FROM user_payment_methods LIKE 'card_holder_name'");
    $hasCardHolderName = $checkColumn && $checkColumn->num_rows > 0;
    
    // Build insert query based on existing columns
    if ($hasCardHolderName) {
        $insertSql = "INSERT INTO user_payment_methods (user_id, card_type, card_last4, expiry_month, expiry_year, is_default, card_holder_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param('issssis', $userId, $cardType, $cardLast4, $expiryMonth, $expiryYear, $isDefaultValue, $cardholderName);
    } else {
        $insertSql = "INSERT INTO user_payment_methods (user_id, card_type, card_last4, expiry_month, expiry_year, is_default) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param('issssi', $userId, $cardType, $cardLast4, $expiryMonth, $expiryYear, $isDefaultValue);
    }
    
    if (!$insertStmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    
    if (!$insertStmt->execute()) {
        throw new Exception('Execute failed: ' . $insertStmt->error);
    }
    
    $insertStmt->close();
    $conn->commit();
    
    sendResponse(true, 'Payment method added successfully');
    
} catch (Exception $e) {
    $conn->rollback();
    error_log("Add payment method error: " . $e->getMessage());
    sendResponse(false, 'Unable to add payment method. Please try again.');
}

$conn->close();
?>