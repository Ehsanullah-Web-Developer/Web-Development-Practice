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

$user_id = $_SESSION['user_id'];
$status = isset($_GET['status']) ? trim($_GET['status']) : '';

// Build query with optional status filter
if (!empty($status)) {
    $sql = "SELECT ticket_id, subject, category, status, order_id, created_at 
            FROM support_tickets 
            WHERE user_id = ? AND status = ? 
            ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $status);
} else {
    $sql = "SELECT ticket_id, subject, category, status, order_id, created_at 
            FROM support_tickets 
            WHERE user_id = ? 
            ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

$tickets = [];
while ($row = $result->fetch_assoc()) {
    $tickets[] = $row;
}

echo json_encode([
    'success' => true,
    'tickets' => $tickets
]);

$stmt->close();
$conn->close();
?>