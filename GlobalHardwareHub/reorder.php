<?php
// Disable error display to prevent HTML output
error_reporting(0);
ini_set('display_errors', 0);

session_start();
header('Content-Type: application/json');

// Function to send JSON response and exit
function sendResponse($success, $message, $additional = []) {
    $response = array_merge(['success' => $success, 'message' => $message], $additional);
    echo json_encode($response);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, 'Please login first');
}

$user_id = $_SESSION['user_id'];

// Get JSON input from request body
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['order_id'])) {
    sendResponse(false, 'Order ID required');
}

$order_id = intval($input['order_id']);

if ($order_id <= 0) {
    sendResponse(false, 'Invalid Order ID');
}

// Include database connection
$db_path = __DIR__ . '/db_connect.php';
if (!file_exists($db_path)) {
    sendResponse(false, 'Database configuration file not found. Path: ' . $db_path);
}

require_once $db_path;

// Check if connection exists
if (!isset($conn) || $conn->connect_error) {
    sendResponse(false, 'Database connection failed: ' . ($conn->connect_error ?? 'Connection not established'));
}

// Verify the order belongs to this user (security check)
$verify_query = "SELECT order_id FROM orders WHERE order_id = ? AND user_id = ?";
$verify_stmt = $conn->prepare($verify_query);

if (!$verify_stmt) {
    sendResponse(false, 'Database prepare failed: ' . $conn->error);
}

$verify_stmt->bind_param("ii", $order_id, $user_id);
$verify_stmt->execute();
$verify_result = $verify_stmt->get_result();

if ($verify_result->num_rows === 0) {
    $verify_stmt->close();
    sendResponse(false, 'Order not found or does not belong to you');
}
$verify_stmt->close();

// Get order items from order_items table
$query = "SELECT product_id, quantity FROM order_items WHERE order_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    sendResponse(false, 'Failed to prepare order items query: ' . $conn->error);
}

$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    sendResponse(false, 'No items found in this order');
}

$success_count = 0;
$failed_items = [];

while ($item = $result->fetch_assoc()) {
    $product_id = $item['product_id'];
    $quantity = intval($item['quantity']);
    
    if ($quantity <= 0) {
        continue;
    }
    
    // Check if product already exists in cart
    $check_stmt = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    
    if (!$check_stmt) {
        $failed_items[] = $product_id;
        continue;
    }
    
    $check_stmt->bind_param("ii", $user_id, $product_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result && $check_result->num_rows > 0) {
        // Update existing cart item
        $existing = $check_result->fetch_assoc();
        $new_quantity = $existing['quantity'] + $quantity;
        
        $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
        if ($update_stmt) {
            $update_stmt->bind_param("ii", $new_quantity, $existing['cart_id']);
            if ($update_stmt->execute()) {
                $success_count++;
            } else {
                $failed_items[] = $product_id;
            }
            $update_stmt->close();
        } else {
            $failed_items[] = $product_id;
        }
    } else {
        // Insert new cart item
        $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        if ($insert_stmt) {
            $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
            if ($insert_stmt->execute()) {
                $success_count++;
            } else {
                $failed_items[] = $product_id;
            }
            $insert_stmt->close();
        } else {
            $failed_items[] = $product_id;
        }
    }
    $check_stmt->close();
}

$stmt->close();

// Check if cart was updated
if ($success_count > 0) {
    $message = "$success_count item(s) added to your cart successfully!";
    if (count($failed_items) > 0) {
        $message .= " Failed to add " . count($failed_items) . " item(s).";
    }
    sendResponse(true, $message, [
        'items_added' => $success_count,
        'failed_count' => count($failed_items)
    ]);
} else {
    sendResponse(false, 'Failed to add items to cart. Please try again.');
}
?>