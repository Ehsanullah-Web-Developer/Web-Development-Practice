<?php
// update_ticket_status_admin.php
// Admin can update any ticket status

session_start();
header('Content-Type: application/json');

require_once 'db_connect.php';

// Admin authentication check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$ticket_id = isset($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';

if ($ticket_id <= 0 || empty($status)) {
    echo json_encode(['success' => false, 'message' => 'Ticket ID and status are required']);
    exit;
}

$allowed_status = ['Open', 'Pending', 'Resolved', 'Closed'];
if (!in_array($status, $allowed_status)) {
    echo json_encode(['success' => false, 'message' => 'Invalid status value']);
    exit;
}

try {
    // Update ticket status (NO user ownership check)
    $update_query = "UPDATE support_tickets SET status = ? WHERE ticket_id = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "si", $status, $ticket_id);
    
    if (mysqli_stmt_execute($update_stmt) && mysqli_stmt_affected_rows($update_stmt) > 0) {
        echo json_encode(['success' => true, 'message' => 'Ticket status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ticket not found']);
    }
    
    mysqli_stmt_close($update_stmt);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to update ticket status']);
}

mysqli_close($conn);
?>