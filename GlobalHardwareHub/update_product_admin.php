<?php
// update_product_admin.php
// Update product name, price, or status from admin dashboard

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

// Validate product ID
if ($product_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Valid product ID is required'
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
    
    // Update product name
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Product name cannot be empty']);
            exit;
        }
        $update_query = "UPDATE products SET name = ? WHERE product_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "si", $name, $product_id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            echo json_encode(['success' => true, 'message' => 'Product name updated successfully']);
        } else {
            throw new Exception();
        }
        mysqli_stmt_close($update_stmt);
    }
    
    // Update product price
    elseif (isset($_POST['price'])) {
        $price = (float)$_POST['price'];
        if ($price < 0) {
            echo json_encode(['success' => false, 'message' => 'Price cannot be negative']);
            exit;
        }
        $update_query = "UPDATE products SET regular_price = ? WHERE product_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "di", $price, $product_id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            echo json_encode(['success' => true, 'message' => 'Product price updated successfully']);
        } else {
            throw new Exception();
        }
        mysqli_stmt_close($update_stmt);
    }
    
    // Update product status
    elseif (isset($_POST['status'])) {
        $status = trim($_POST['status']);
        $allowed_status = ['active', 'inactive', 'out_of_stock'];
        
        if (!in_array($status, $allowed_status)) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid status. Allowed: active, inactive, out_of_stock'
            ]);
            exit;
        }
        
        $update_query = "UPDATE products SET status = ? WHERE product_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "si", $status, $product_id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            echo json_encode(['success' => true, 'message' => 'Product status updated successfully']);
        } else {
            throw new Exception();
        }
        mysqli_stmt_close($update_stmt);
    }
    
    else {
        echo json_encode([
            'success' => false,
            'message' => 'No update field provided (name, price, or status required)'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update product. Please try again.'
    ]);
}

// Close database connection
mysqli_close($conn);
?>