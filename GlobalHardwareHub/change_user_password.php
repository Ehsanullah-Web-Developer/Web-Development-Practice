<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if all POST fields are set
if (!isset($_POST['current_password']) || !isset($_POST['new_password']) || !isset($_POST['confirm_password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields"
    ]);
    exit;
}

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// STEP 1: Validate input
if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);
    exit;
}

if (strlen($new_password) < 6) {
    echo json_encode([
        "success" => false,
        "message" => "New password must be at least 6 characters long"
    ]);
    exit;
}

if ($new_password !== $confirm_password) {
    echo json_encode([
        "success" => false,
        "message" => "New password and confirm password do not match"
    ]);
    exit;
}

// STEP 2: Fetch current password hash from database
$sql = "SELECT password_hash FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
    $stmt->close();
    exit;
}

$user = $result->fetch_assoc();
$password_hash = $user['password_hash'];
$stmt->close();

// STEP 3: Verify current password
if (!password_verify($current_password, $password_hash)) {
    echo json_encode([
        "success" => false,
        "message" => "Current password is incorrect"
    ]);
    exit;
}

// STEP 4: Hash new password
$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

// STEP 5: Update password in database
$update_sql = "UPDATE users SET password_hash = ? WHERE user_id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("si", $new_password_hash, $user_id);

if ($update_stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Password changed successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to update password"
    ]);
}

$update_stmt->close();
$conn->close();
?>