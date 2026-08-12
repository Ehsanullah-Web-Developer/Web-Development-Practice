<?php
// change_admin_password.php
// Allow admin to change password securely

session_start();
header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';

// Authentication check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

// Get admin ID from session
$user_id = $_SESSION['user_id'];

// Get input data from POST request
$current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Validate all fields are provided
if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required'
    ]);
    exit;
}

// Check if new password matches confirm password
if ($new_password !== $confirm_password) {
    echo json_encode([
        'success' => false,
        'message' => 'New password and confirm password do not match'
    ]);
    exit;
}

// Validate password length
if (strlen($new_password) < 6) {
    echo json_encode([
        'success' => false,
        'message' => 'New password must be at least 6 characters long'
    ]);
    exit;
}

try {
    // Fetch current password hash from database
    $query = "SELECT password_hash FROM users WHERE user_id = ? AND user_type = 'admin'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if admin exists
    if (mysqli_num_rows($result) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Admin account not found'
        ]);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit;
    }
    
    $admin_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    // Verify current password
    if (!password_verify($current_password, $admin_data['password_hash'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Current password is incorrect'
        ]);
        mysqli_close($conn);
        exit;
    }
    
    // Hash new password
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Update password in database
    $update_query = "UPDATE users SET password_hash = ? WHERE user_id = ? AND user_type = 'admin'";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "si", $new_password_hash, $user_id);
    
    if (mysqli_stmt_execute($update_stmt)) {
        echo json_encode([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    } else {
        throw new Exception();
    }
    
    mysqli_stmt_close($update_stmt);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to change password'
    ]);
}

// Close database connection
mysqli_close($conn);
?>