<?php
// update_product_status.php
// Update product status from admin dashboard

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
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';

// Validate inputs
if ($product_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Valid product ID is required'
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
$allowed_status = ['active', 'inactive', 'out_of_stock'];
if (!in_array($status, $allowed_status)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid status value. Allowed values: active, inactive, out_of_stock'
    ]);
    exit;
}

try {
    // Check if product exists
    $check_query = "SELECT product_id FROM products WHERE product_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $product_id);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    
    if (mysqli_stmt_num_rows($check_stmt) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Product not found'
        ]);
        mysqli_stmt_close($check_stmt);
        mysqli_close($conn);
        exit;
    }
    mysqli_stmt_close($check_stmt);
    
    // Update product status
    $update_query = "UPDATE products SET status = ? WHERE product_id = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "si", $status, $product_id);
    
    if (mysqli_stmt_execute($update_stmt)) {
        echo json_encode([
            'success' => true,
            'message' => 'Product status updated successfully'
        ]);
    } else {
        throw new Exception();
    }
    
    mysqli_stmt_close($update_stmt);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update product status'
    ]);
}

// Close database connection
mysqli_close($conn);
?>