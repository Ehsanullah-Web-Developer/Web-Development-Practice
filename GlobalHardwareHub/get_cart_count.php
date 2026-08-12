<?php
session_start();
header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false, 
        'message' => 'Please login to view your cart',
        'redirect' => 'login.php'
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Get total cart count (sum of all quantities for this user)
    $stmt = $conn->prepare("SELECT SUM(quantity) as total_items FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // If cart is empty, result will be NULL, so set to 0
    $cart_count = $row['total_items'] ?? 0;
    
    echo json_encode([
        'success' => true,
        'cart_count' => (int)$cart_count,
        'user_id' => $user_id,
        'message' => 'Cart count retrieved successfully'
    ]);
    
    $stmt->close();
    
} catch(Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error fetching cart: ' . $e->getMessage()
    ]);
}

$conn->close();
?>