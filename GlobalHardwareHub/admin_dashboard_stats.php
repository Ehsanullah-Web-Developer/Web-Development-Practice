<?php
// admin_dashboard_stats.php
// Admin Dashboard Statistics API

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
    // Fetch total users
    $total_users_query = "SELECT COUNT(user_id) as total FROM users";
    $total_users_result = mysqli_query($conn, $total_users_query);
    $total_users = mysqli_fetch_assoc($total_users_result)['total'];
    
    // Fetch total orders
    $total_orders_query = "SELECT COUNT(order_id) as total FROM orders";
    $total_orders_result = mysqli_query($conn, $total_orders_query);
    $total_orders = mysqli_fetch_assoc($total_orders_result)['total'];
    
    // Fetch total products
    $total_products_query = "SELECT COUNT(product_id) as total FROM products";
    $total_products_result = mysqli_query($conn, $total_products_query);
    $total_products = mysqli_fetch_assoc($total_products_result)['total'];
    
    // Fetch total revenue
    $revenue_query = "SELECT SUM(total_amount) as total FROM orders";
    $revenue_result = mysqli_query($conn, $revenue_query);
    $revenue_data = mysqli_fetch_assoc($revenue_result);
    $total_revenue = $revenue_data['total'] !== null ? $revenue_data['total'] : 0;
    
    // Fetch pending orders count
    $pending_orders_query = "SELECT COUNT(order_id) as total FROM orders WHERE status = 'pending'";
    $pending_orders_result = mysqli_query($conn, $pending_orders_query);
    $pending_orders = mysqli_fetch_assoc($pending_orders_result)['total'];
    
    // Return success response
    echo json_encode([
        'success' => true,
        'stats' => [
            'total_users' => (int)$total_users,
            'total_orders' => (int)$total_orders,
            'total_products' => (int)$total_products,
            'total_revenue' => (float)$total_revenue,
            'pending_orders' => (int)$pending_orders
        ]
    ]);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load dashboard statistics'
    ]);
}

// Close database connection
mysqli_close($conn);
?>