<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * reset_password.php
 * Endpoint for users to reset their password using a valid token
 * Returns JSON response only
 */

header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Use POST.'
    ]);
    exit;
}

// STEP 1: VALIDATE INPUT
$token = isset($_POST['token']) ? trim($_POST['token']) : '';
$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

// Check if token is empty
if (empty($token)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input'
    ]);
    exit;
}

// Check if new password is empty
if (empty($new_password)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid input'
    ]);
    exit;
}

// Check password length
if (strlen($new_password) < 6) {
    echo json_encode([
        'success' => false,
        'message' => 'Password must be at least 6 characters'
    ]);
    exit;
}

// STEP 2: FIND USER BY TOKEN
$sql = "SELECT user_id, reset_token, reset_token_expiry FROM users WHERE reset_token = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $conn->close();
    echo json_encode([
        'success' => false,
        'message' => 'Invalid or expired token'
    ]);
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// STEP 3: CHECK EXPIRY
$current_time = time();
$expiry_time = strtotime($user['reset_token_expiry']);

if (!$expiry_time || $current_time > $expiry_time) {
    $conn->close();
    echo json_encode([
        'success' => false,
        'message' => 'Token expired'
    ]);
    exit;
}

// STEP 4: HASH PASSWORD
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// STEP 5: UPDATE PASSWORD AND CLEAR TOKEN
$update_sql = "UPDATE users SET password_hash = ?, reset_token = NULL, reset_token_expiry = NULL WHERE user_id = ?";
$update_stmt = $conn->prepare($update_sql);

if (!$update_stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $conn->error
    ]);
    exit;
}

$update_stmt->bind_param("si", $hashed_password, $user['user_id']);

if ($update_stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Password reset successful'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to reset password'
    ]);
}

$update_stmt->close();
$conn->close();
?>