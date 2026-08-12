<?php
/**
 * delete_user_payment_method.php (Enhanced Version)
 * 
 * Returns more detailed response including whether a new default was set
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $message, $data = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please Login First');
}

$userId = $_SESSION['user_id'];

// Get payment_id
$inputData = json_decode(file_get_contents('php://input'), true);
$paymentId = isset($inputData['payment_id']) ? (int)$inputData['payment_id'] : (isset($_POST['payment_id']) ? (int)$_POST['payment_id'] : 0);

if ($paymentId <= 0) {
    sendResponse(false, 'Invalid payment method');
}

// Verify ownership and get method details
$checkSql = "SELECT payment_id, is_default, card_type, card_last4 FROM user_payment_methods WHERE payment_id = ? AND user_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param('ii', $paymentId, $userId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $checkStmt->close();
    sendResponse(false, 'Payment method not found');
}

$paymentMethod = $checkResult->fetch_assoc();
$isDefault = $paymentMethod['is_default'];
$checkStmt->close();

$newDefaultSet = false;
$newDefaultId = null;

$conn->begin_transaction();

try {
    // Handle default reassignment if needed
    if ($isDefault == 1) {
        // Count remaining payment methods
        $countSql = "SELECT COUNT(*) as total FROM user_payment_methods WHERE user_id = ? AND payment_id != ?";
        $countStmt = $conn->prepare($countSql);
        $countStmt->bind_param('ii', $userId, $paymentId);
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalRemaining = $countResult->fetch_assoc()['total'];
        $countStmt->close();
        
        // If there are other methods, set the oldest one as default
        if ($totalRemaining > 0) {
            $otherSql = "SELECT payment_id FROM user_payment_methods WHERE user_id = ? AND payment_id != ? ORDER BY payment_id ASC LIMIT 1";
            $otherStmt = $conn->prepare($otherSql);
            $otherStmt->bind_param('ii', $userId, $paymentId);
            $otherStmt->execute();
            $otherResult = $otherStmt->get_result();
            
            if ($otherResult->num_rows > 0) {
                $otherMethod = $otherResult->fetch_assoc();
                $newDefaultId = $otherMethod['payment_id'];
                
                $updateSql = "UPDATE user_payment_methods SET is_default = 1 WHERE payment_id = ? AND user_id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param('ii', $newDefaultId, $userId);
                $updateStmt->execute();
                $updateStmt->close();
                $newDefaultSet = true;
            }
            $otherStmt->close();
        }
    }
    
    // Delete the payment method
    $deleteSql = "DELETE FROM user_payment_methods WHERE payment_id = ? AND user_id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param('ii', $paymentId, $userId);
    $deleteStmt->execute();
    $deleteStmt->close();
    
    $conn->commit();
    
    // Prepare response data
    $responseData = [];
    if ($newDefaultSet && $newDefaultId) {
        $responseData['new_default_id'] = $newDefaultId;
        $responseData['message_detail'] = 'A new default payment method has been automatically assigned.';
    }
    
    sendResponse(true, 'Payment method deleted successfully', $responseData);
    
} catch (Exception $e) {
    $conn->rollback();
    error_log("Delete payment method error: " . $e->getMessage());
    sendResponse(false, 'Unable to delete payment method. Please try again.');
}

$conn->close();
?>