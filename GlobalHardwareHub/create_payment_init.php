<?php
// create_payment_init.php - OFFLINE TEST MODE
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

require_once 'db_connect.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT SUM(c.quantity * p.regular_price) as total 
          FROM cart c 
          JOIN products p ON c.product_id = p.product_id 
          WHERE c.user_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total = $row['total'] ?? 0;
$stmt->close();

if ($total <= 0) {
    echo json_encode(['success' => false, 'message' => 'Your cart is empty']);
    exit;
}

$tax = $total * 0.09;
$grand_total = $total + $tax;

// RETURN SUCCESS WITHOUT CALLING STRIPE (TEST MODE)
echo json_encode([
    'success' => true,
    'clientSecret' => 'test_offline_' . time(),
    'amount' => $grand_total,
    'offline_mode' => true,
    'message' => 'Test mode - Payment simulated'
]);
?>