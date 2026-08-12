<?php
// delete_product_admin.php
// Admin can delete any product with all related records

session_start();
header('Content-Type: application/json');

require_once 'db_connect.php';

// Admin authentication check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Valid product ID required']);
    exit;
}

try {
    // Check if product exists
    $check_query = "SELECT product_id, name FROM products WHERE product_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $product_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) == 0) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        mysqli_stmt_close($check_stmt);
        mysqli_close($conn);
        exit;
    }
    mysqli_stmt_close($check_stmt);
    
    // Disable foreign key checks
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");
    
    // 1. Delete from order_items
    $delete_order_items = "DELETE FROM order_items WHERE product_id = ?";
    $order_stmt = mysqli_prepare($conn, $delete_order_items);
    mysqli_stmt_bind_param($order_stmt, "i", $product_id);
    mysqli_stmt_execute($order_stmt);
    mysqli_stmt_close($order_stmt);
    
    // 2. Delete from cart
    $delete_cart = "DELETE FROM cart WHERE product_id = ?";
    $cart_stmt = mysqli_prepare($conn, $delete_cart);
    mysqli_stmt_bind_param($cart_stmt, "i", $product_id);
    mysqli_stmt_execute($cart_stmt);
    mysqli_stmt_close($cart_stmt);
    
    // 3. Delete from wishlist
    $delete_wishlist = "DELETE FROM wishlist WHERE product_id = ?";
    $wishlist_stmt = mysqli_prepare($conn, $delete_wishlist);
    mysqli_stmt_bind_param($wishlist_stmt, "i", $product_id);
    mysqli_stmt_execute($wishlist_stmt);
    mysqli_stmt_close($wishlist_stmt);
    
    // 4. Delete from product_images
    $delete_images = "DELETE FROM product_images WHERE product_id = ?";
    $img_stmt = mysqli_prepare($conn, $delete_images);
    mysqli_stmt_bind_param($img_stmt, "i", $product_id);
    mysqli_stmt_execute($img_stmt);
    mysqli_stmt_close($img_stmt);
    
    // 5. Delete from vendor_products
    $delete_vendor_product = "DELETE FROM vendor_products WHERE product_id = ?";
    $vp_stmt = mysqli_prepare($conn, $delete_vendor_product);
    mysqli_stmt_bind_param($vp_stmt, "i", $product_id);
    mysqli_stmt_execute($vp_stmt);
    mysqli_stmt_close($vp_stmt);
    
    // 6. Delete from vendor_reviews
    $delete_reviews = "DELETE FROM vendor_reviews WHERE product_id = ?";
    $review_stmt = mysqli_prepare($conn, $delete_reviews);
    mysqli_stmt_bind_param($review_stmt, "i", $product_id);
    mysqli_stmt_execute($review_stmt);
    mysqli_stmt_close($review_stmt);
    
    // 7. Finally delete the product
    $delete_query = "DELETE FROM products WHERE product_id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($delete_stmt, "i", $product_id);
    
    if (mysqli_stmt_execute($delete_stmt)) {
        echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);
    } else {
        throw new Exception(mysqli_error($conn));
    }
    
    mysqli_stmt_close($delete_stmt);
    
    // Re-enable foreign key checks
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
    
} catch (Exception $e) {
    // Re-enable foreign key checks on error too
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
    echo json_encode(['success' => false, 'message' => 'Failed to delete product: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>