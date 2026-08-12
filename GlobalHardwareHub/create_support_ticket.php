<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please login first'
    ]);
    exit;
}

// Get POST data
$subject = trim($_POST['subject'] ?? '');
$order_id = !empty($_POST['order_id']) ? (int)$_POST['order_id'] : null;
$category = trim($_POST['category'] ?? '');
$message = trim($_POST['message'] ?? '');
$attachment = isset($_POST['attachment']) ? trim($_POST['attachment']) : null;

// Validate required fields
if (empty($subject)) {
    echo json_encode([
        'success' => false,
        'message' => 'Subject is required'
    ]);
    exit;
}

if (empty($category)) {
    echo json_encode([
        'success' => false,
        'message' => 'Category is required'
    ]);
    exit;
}

if (empty($message)) {
    echo json_encode([
        'success' => false,
        'message' => 'Message is required'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Insert ticket into database
$sql = "INSERT INTO support_tickets (user_id, order_id, subject, category, message, attachment, status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, 'Open', NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iissss", $user_id, $order_id, $subject, $category, $message, $attachment);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Ticket created successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to create ticket: ' . $conn->error
    ]);
}

$stmt->close();
$conn->close();
?>