<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// Function to send JSON response
function sendResponse($success, $message, $redirect_url = null) {
    $response = [
        'success' => $success,
        'message' => $message
    ];
    
    if ($redirect_url !== null) {
        $response['redirect_url'] = $redirect_url;
    }
    
    echo json_encode($response);
    exit;
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method');
}

// Get email from POST
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

// Step 1: Validate email
if (empty($email)) {
    sendResponse(false, 'Invalid email');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendResponse(false, 'Invalid email');
}

// Step 2: Check if user exists
$checkSql = "SELECT user_id FROM users WHERE email = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $checkStmt->close();
    sendResponse(false, 'Email not found');
}
$checkStmt->close();

// Step 3: Generate secure random token
$token = bin2hex(random_bytes(16));

// Step 4: Set expiry (current time + 1 hour)
$expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

// Step 5: Save token in database
$updateSql = "UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("sss", $token, $expiry, $email);

if ($updateStmt->execute()) {
    $updateStmt->close();
    $conn->close();
    
    // Step 6: Return success response with redirect URL
    $redirect_url = "ResetPassword.php?token=" . $token;
    sendResponse(true, 'Reset link generated', $redirect_url);
} else {
    $updateStmt->close();
    $conn->close();
    sendResponse(false, 'Failed to generate reset link. Please try again.');
}
?>