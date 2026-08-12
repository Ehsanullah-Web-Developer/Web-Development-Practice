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

// Get ticket_id from GET request
$ticket_id = isset($_GET['ticket_id']) ? (int)$_GET['ticket_id'] : 0;

if ($ticket_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid ticket ID'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch ticket details - verify ownership
$sql = "SELECT ticket_id, subject, category, message, status, order_id, created_at 
        FROM support_tickets 
        WHERE ticket_id = ? AND user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $ticket_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Ticket not found'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$ticket = $result->fetch_assoc();

// Fetch replies for this ticket
$sql_replies = "SELECT reply_id, user_id, message, created_at 
                FROM support_ticket_replies 
                WHERE ticket_id = ? 
                ORDER BY created_at ASC";

$stmt_replies = $conn->prepare($sql_replies);
$stmt_replies->bind_param("i", $ticket_id);
$stmt_replies->execute();
$replies_result = $stmt_replies->get_result();

$replies = [];
while ($reply = $replies_result->fetch_assoc()) {
    $replies[] = $reply;
}

echo json_encode([
    'success' => true,
    'ticket' => $ticket,
    'replies' => $replies
]);

$stmt->close();
$stmt_replies->close();
$conn->close();
?>