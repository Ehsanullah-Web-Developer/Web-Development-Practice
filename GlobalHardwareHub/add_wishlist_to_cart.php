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

try {
    // Get all wishlist items - Note: wishlist table may not have quantity column
    $stmt = $conn->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $wishlistItems = [];
    while ($row = $result->fetch_assoc()) {
        $wishlistItems[] = $row;
    }
    $stmt->close();
    
    if (empty($wishlistItems)) {
        echo json_encode(['success' => false, 'message' => 'Your wishlist is empty']);
        exit();
    }
    
    $itemsAdded = 0;
    $errors = [];
    
    // Add each wishlist item to cart (default quantity = 1)
    foreach ($wishlistItems as $item) {
        $product_id = $item['product_id'];
        $quantity = 1; // Default quantity since wishlist may not have quantity column
        
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
            'message' => "$itemsAdded item(s) added to cart successfully!",
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