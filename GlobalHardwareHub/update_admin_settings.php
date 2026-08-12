<?php
// update_admin_settings.php
// Update admin profile details and password

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
$full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

// Validate required fields
if (empty($full_name) || empty($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'Full name and email are required'
    ]);
    exit;
}

try {
    // Start with profile update query
    $update_query = "UPDATE users SET full_name = ?, email = ?, phone = ? WHERE user_id = ? AND user_type = 'admin'";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sssi", $full_name, $email, $phone, $user_id);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception();
    }
    
    // Check if password update is requested
    if (!empty($new_password)) {
        // Validate current password
        $password_query = "SELECT password_hash FROM users WHERE user_id = ? AND user_type = 'admin'";
        $pass_stmt = mysqli_prepare($conn, $password_query);
        mysqli_stmt_bind_param($pass_stmt, "i", $user_id);
        mysqli_stmt_execute($pass_stmt);
        $pass_result = mysqli_stmt_get_result($pass_stmt);
        $user_data = mysqli_fetch_assoc($pass_result);
        
        if (!$user_data || !password_verify($current_password, $user_data['password_hash'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Current password is incorrect'
            ]);
            mysqli_stmt_close($pass_stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit;
        }
        mysqli_stmt_close($pass_stmt);
        
        // Check if new password and confirm password match
        if ($new_password !== $confirm_password) {
            echo json_encode([
                'success' => false,
                'message' => 'New password and confirm password do not match'
            ]);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit;
        }
        
        // Validate password length
        if (strlen($new_password) < 6) {
            echo json_encode([
                'success' => false,
                'message' => 'Password must be at least 6 characters long'
            ]);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit;
        }
        
        // Hash new password
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update password
        $password_update_query = "UPDATE users SET password_hash = ? WHERE user_id = ? AND user_type = 'admin'";
        $password_stmt = mysqli_prepare($conn, $password_update_query);
        mysqli_stmt_bind_param($password_stmt, "si", $password_hash, $user_id);
        
        if (!mysqli_stmt_execute($password_stmt)) {
            throw new Exception();
        }
        
        mysqli_stmt_close($password_stmt);
    }
    
    mysqli_stmt_close($stmt);
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Admin settings updated successfully'
    ]);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update admin settings'
    ]);
}

// Close database connection
mysqli_close($conn);
?>