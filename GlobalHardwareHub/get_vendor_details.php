<?php
// get_vendor_details.php
// Fetch complete details of a specific vendor

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

// Get vendor ID from GET request
if (!isset($_GET['vendor_id']) || empty($_GET['vendor_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Vendor ID is required'
    ]);
    exit;
}

$vendor_id = (int)$_GET['vendor_id'];

try {
    // Fetch vendor data with user information
    $vendor_query = "SELECT 
                        v.vendor_id,
                        v.user_id,
                        v.store_name,
                        v.logo_url,
                        v.rating,
                        v.store_email,
                        v.store_phone,
                        v.store_address,
                        v.created_at,
                        u.full_name as owner_name,
                        u.email as user_email
                    FROM vendors v
                    INNER JOIN users u ON v.user_id = u.user_id
                    WHERE v.vendor_id = ?";
    
    $vendor_stmt = mysqli_prepare($conn, $vendor_query);
    mysqli_stmt_bind_param($vendor_stmt, "i", $vendor_id);
    mysqli_stmt_execute($vendor_stmt);
    $vendor_result = mysqli_stmt_get_result($vendor_stmt);
    
    // Check if vendor exists
    if (mysqli_num_rows($vendor_result) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Vendor not found'
        ]);
        mysqli_stmt_close($vendor_stmt);
        mysqli_close($conn);
        exit;
    }
    
    $vendor_data = mysqli_fetch_assoc($vendor_result);
    mysqli_stmt_close($vendor_stmt);
    
    // Fetch total products count for this vendor
    $products_query = "SELECT COUNT(vp_id) as total_products FROM vendor_products WHERE vendor_id = ?";
    $products_stmt = mysqli_prepare($conn, $products_query);
    mysqli_stmt_bind_param($products_stmt, "i", $vendor_id);
    mysqli_stmt_execute($products_stmt);
    $products_result = mysqli_stmt_get_result($products_stmt);
    $products_data = mysqli_fetch_assoc($products_result);
    $total_products = (int)$products_data['total_products'];
    mysqli_stmt_close($products_stmt);
    
    // Format response
    $vendor = [
        'vendor_id' => (int)$vendor_data['vendor_id'],
        'store_name' => $vendor_data['store_name'],
        'owner_name' => $vendor_data['owner_name'],
        'email' => $vendor_data['store_email'],
        'phone' => $vendor_data['store_phone'],
        'address' => $vendor_data['store_address'],
        'rating' => $vendor_data['rating'] ? (float)$vendor_data['rating'] : 0,
        'total_products' => $total_products,
        'logo_url' => $vendor_data['logo_url'],
        'created_at' => $vendor_data['created_at']
    ];
    
    // Return success response
    echo json_encode([
        'success' => true,
        'vendor' => $vendor
    ]);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load vendor details'
    ]);
}

// Close database connection
mysqli_close($conn);
?>