<?php
// get_all_users.php
// Fetch all users for admin user management

session_start();
header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';

// Admin authentication check
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

try {
    // Base query
    $query = "SELECT 
            user_id,
            full_name,
            email,
            user_type,
            status,
            created_at
          FROM users
          WHERE 1=1";
    
    // Optional filters
    $filters = [];
    $types = "";
    $params = [];
    
    // Filter by user_type if provided
    if (isset($_GET['user_type']) && !empty($_GET['user_type'])) {
        $query .= " AND user_type = ?";
        $filters[] = $_GET['user_type'];
        $types .= "s";
    }
    
    // Order by created date descending
    $query .= " ORDER BY created_at DESC";
    
    // Prepare and execute statement
    $stmt = mysqli_prepare($conn, $query);
    
    if (!empty($filters)) {
        mysqli_stmt_bind_param($stmt, $types, ...$filters);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if query was successful
    if (!$result) {
        throw new Exception();
    }
    
    $users = [];
    
    // Fetch all users
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = [
            'user_id' => (int)$row['user_id'],
            'full_name' => $row['full_name'],
            'email' => $row['email'],
            'role' => $row['user_type'],
            'status' => $row['status'] ?? 'active',
            'created_at' => $row['created_at']
        ];
    }
    
    // Return success response
    echo json_encode([
        'success' => true,
        'users' => $users
    ]);
    
    // Close statement
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load users'
    ]);
}

// Close database connection
mysqli_close($conn);
?>