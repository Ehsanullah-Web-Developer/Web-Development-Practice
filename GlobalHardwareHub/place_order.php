<?php
session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

// Check login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please Login first']);
    exit;
}

$userId = $_SESSION['user_id'];

// Get POST data
$inputData = json_decode(file_get_contents('php://input'), true);
$addressId = isset($inputData['address_id']) ? (int)$inputData['address_id'] : 0;
$paymentMethod = isset($inputData['payment_method']) ? $inputData['payment_method'] : '';
$orderNotes = isset($inputData['order_notes']) ? $inputData['order_notes'] : '';

// Validate
if ($addressId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Shipping address required']);
    exit;
}

// Get cart items with vendor information (using prepared statement for security)
$cartQuery = "SELECT c.product_id, c.quantity, p.regular_price, p.sale_price, p.vendor_id 
              FROM cart c 
              JOIN products p ON c.product_id = p.product_id 
              WHERE c.user_id = ?";

$stmt = $conn->prepare($cartQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$cartResult = $stmt->get_result();

if (!$cartResult) {
    echo json_encode(['success' => false, 'message' => 'Cart query error: ' . $conn->error]);
    exit;
}

if ($cartResult->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Your cart is empty']);
    exit;
}

// Calculate total
$total = 0;
$items = [];
while($row = $cartResult->fetch_assoc()) {
    $price = ($row['sale_price'] > 0) ? $row['sale_price'] : $row['regular_price'];
    $total += $price * $row['quantity'];
    $items[] = $row;
}
$stmt->close();

// Insert order using prepared statement
// FIXED: Changed type string from "idsss" to "idssi" (i = integer, d = decimal, s = string)
// $total is float, so use "d" for double/decimal
$orderSql = "INSERT INTO orders (user_id, total_amount, payment_method, shipping_address_id, order_notes, status, created_at) 
             VALUES (?, ?, ?, ?, ?, 'pending', NOW())";

$stmt = $conn->prepare($orderSql);
$stmt->bind_param("idsis", $userId, $total, $paymentMethod, $addressId, $orderNotes);

if ($stmt->execute()) {
    $orderId = $conn->insert_id;
    $stmt->close();
    
    // Insert order items with actual vendor_id from product using prepared statement
    $itemSql = "INSERT INTO order_items (order_id, product_id, vendor_id, quantity, price) 
                VALUES (?, ?, ?, ?, ?)";
    
    $itemStmt = $conn->prepare($itemSql);
    
    foreach($items as $item) {
        $price = ($item['sale_price'] > 0) ? $item['sale_price'] : $item['regular_price'];
        $vendorId = $item['vendor_id']; // Get the actual vendor_id from product
        $productId = $item['product_id'];
        $quantity = $item['quantity'];
        
        // FIXED: Changed type string from "iiidd" to "iiidi" (i = integer, d = decimal)
        // quantity is integer, price is decimal
        $itemStmt->bind_param("iiidi", $orderId, $productId, $vendorId, $quantity, $price);
        $itemStmt->execute();
    }
    $itemStmt->close();
    
    // Clear cart using prepared statement
    $clearCartSql = "DELETE FROM cart WHERE user_id = ?";
    $clearStmt = $conn->prepare($clearCartSql);
    $clearStmt->bind_param("i", $userId);
    $clearStmt->execute();
    $clearStmt->close();
    
    echo json_encode(['success' => true, 'message' => 'Order placed successfully', 'order_id' => $orderId]);
} else {
    echo json_encode(['success' => false, 'message' => 'Order insert error: ' . $stmt->error]);
    $stmt->close();
}

$conn->close();
?>