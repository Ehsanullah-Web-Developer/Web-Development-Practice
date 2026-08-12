<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

if (!$order_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
    exit();
}

try {
    // First verify the order belongs to this user
    $verify_stmt = $conn->prepare("SELECT order_id FROM orders WHERE order_id = ? AND user_id = ?");
    $verify_stmt->bind_param("ii", $order_id, $user_id);
    $verify_stmt->execute();
    if ($verify_stmt->get_result()->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Order not found']);
        exit();
    }
    $verify_stmt->close();
    
    // Get all items from the order
    $stmt = $conn->prepare("SELECT product_id, quantity FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orderItems = [];
    while ($row = $result->fetch_assoc()) {
        $orderItems[] = $row;
    }
    $stmt->close();
    
    if (empty($orderItems)) {
        echo json_encode(['success' => false, 'message' => 'No items found in this order']);
        exit();
    }
    
    $itemsAdded = 0;
    $errors = [];
    
    // Add each order item to cart
    foreach ($orderItems as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        
        // Check if product already exists in cart
        $check_stmt = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $check_stmt->bind_param("ii", $user_id, $product_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            // Update existing cart item
            $cart_item = $check_result->fetch_assoc();
            $new_quantity = $cart_item['quantity'] + $quantity;
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
            $update_stmt->bind_param("ii", $new_quantity, $cart_item['cart_id']);
            if ($update_stmt->execute()) {
                $itemsAdded++;
            } else {
                $errors[] = "Failed to update product ID: $product_id";
            }
            $update_stmt->close();
        } else {
            // Add new cart item
            $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
            if ($insert_stmt->execute()) {
                $itemsAdded++;
            } else {
                $errors[] = "Failed to add product ID: $product_id";
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
    
    if ($itemsAdded > 0) {
        echo json_encode([
            'success' => true,
            'message' => "$itemsAdded item(s) added to cart successfully! Redirecting to checkout...",
            'items_added' => $itemsAdded
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add items to cart',
            'errors' => $errors
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>