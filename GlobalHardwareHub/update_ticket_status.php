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
$ticket_id = isset($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : 0;
$status = trim($_POST['status'] ?? '');

// Validate inputs
if ($ticket_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
    exit;
}

// Allowed status values
$allowed_statuses = ['Open', 'Closed'];

if (!in_array($status, $allowed_statuses)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Verify ticket belongs to user
$sql_check = "SELECT ticket_id FROM support_tickets WHERE ticket_id = ? AND user_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $ticket_id, $user_id);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
    $stmt_check->close();
    $conn->close();
    exit;
}
$stmt_check->close();

// Update ticket status
$sql_update = "UPDATE support_tickets SET status = ? WHERE ticket_id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("si", $status, $ticket_id);

if ($stmt_update->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Ticket status updated'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update status'
    ]);
}

$stmt_update->close();
$conn->close();
?>