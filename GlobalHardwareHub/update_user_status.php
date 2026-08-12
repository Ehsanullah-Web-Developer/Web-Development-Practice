<?php
// update_user_status.php
// Update user account status (active/inactive/blocked) from admin dashboard

session_start();
header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';

// Admin authentication check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

// Get input data from POST request
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';

// Validate inputs
if ($user_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Valid user ID is required'
    ]);
    exit;
}

if (empty($status)) {
    echo json_encode([
        'success' => false,
        'message' => 'Status is required'
    ]);
    exit;
}

// Validate allowed status values
$allowed_status = ['active', 'inactive', 'blocked'];
if (!in_array($status, $allowed_status)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid status value. Allowed values: active, inactive, blocked'
    ]);
    exit;
}

// Prevent admin from changing own status
if ($user_id == $_SESSION['user_id']) {
    echo json_encode([
        'success' => false,
        'message' => 'You cannot change your own account status'
    ]);
    exit;
}

try {
    // Check if user exists
    $check_query = "SELECT user_id FROM users WHERE user_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $user_id);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    
    if (mysqli_stmt_num_rows($check_stmt) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'User not found'
        ]);
        mysqli_stmt_close($check_stmt);
        mysqli_close($conn);
        exit;
    }
    mysqli_stmt_close($check_stmt);
    
    // First add status column if it doesn't exist
    $alter_query = "SHOW COLUMNS FROM users LIKE 'status'";
    $alter_result = mysqli_query($conn, $alter_query);
    if (mysqli_num_rows($alter_result) == 0) {
        mysqli_query($conn, "ALTER TABLE users ADD COLUMN status VARCHAR(20) DEFAULT 'active'");
    }
    
    // Update user status
    $update_query = "UPDATE users SET status = ? WHERE user_id = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "si", $status, $user_id);
    
    if (mysqli_stmt_execute($update_stmt)) {
        echo json_encode([
            'success' => true,
            'message' => 'User status updated successfully'
        ]);
    } else {
        throw new Exception();
    }
    
    mysqli_stmt_close($update_stmt);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update user status'
    ]);
}

// Close database connection
mysqli_close($conn);
?>