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
$message = trim($_POST['message'] ?? '');

// Validate inputs
if ($ticket_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid ticket ID'
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

// Verify ticket belongs to user and get current status
$sql_check = "SELECT status FROM support_tickets WHERE ticket_id = ? AND user_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $ticket_id, $user_id);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Ticket not found or does not belong to you'
    ]);
    $stmt_check->close();
    $conn->close();
    exit;
}

$ticket = $result->fetch_assoc();
$current_status = $ticket['status'];
$stmt_check->close();

// Insert reply
$sql_reply = "INSERT INTO support_ticket_replies (ticket_id, user_id, message, created_at) 
              VALUES (?, ?, ?, NOW())";
$stmt_reply = $conn->prepare($sql_reply);
$stmt_reply->bind_param("iis", $ticket_id, $user_id, $message);

if (!$stmt_reply->execute()) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to add reply: ' . $conn->error
    ]);
    $stmt_reply->close();
    $conn->close();
    exit;
}
$stmt_reply->close();

// If ticket was closed, reopen it automatically
if ($current_status == 'Closed') {
    $sql_update = "UPDATE support_tickets SET status = 'Open' WHERE ticket_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $ticket_id);
    $stmt_update->execute();
    $stmt_update->close();
}

echo json_encode([
    'success' => true,
    'message' => 'Reply added successfully'
]);

$conn->close();
?>