<?php
// get_admin_profile.php
// Fetch logged-in admin profile data

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

try {
    // Fetch admin data from users table
    $query = "SELECT 
                user_id,
                full_name,
                email,
                phone,
                user_type,
                created_at
              FROM users
              WHERE user_id = ? AND user_type = 'admin'";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if admin exists
    if (mysqli_num_rows($result) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Admin profile not found'
        ]);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit;
    }
    
    // Fetch admin data
    $admin_data = mysqli_fetch_assoc($result);
    
    // Return success response
    echo json_encode([
        'success' => true,
        'profile' => [
            'user_id' => (int)$admin_data['user_id'],
            'full_name' => $admin_data['full_name'],
            'email' => $admin_data['email'],
            'phone' => $admin_data['phone'],
            'created_at' => $admin_data['created_at']
        ]
    ]);
    
    // Close statement
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load admin profile'
    ]);
}

// Close database connection
mysqli_close($conn);
?>