<?php
// reply_support_ticket_admin.php
// Admin can reply to any support ticket

session_start();
header('Content-Type: application/json');

require_once 'db_connect.php';

// Admin authentication check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$ticket_id = isset($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : 0;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if ($ticket_id <= 0 || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Ticket ID and message are required']);
    exit;
}

try {
    // Check if ticket exists (NO user ownership check)
    $check_query = "SELECT ticket_id FROM support_tickets WHERE ticket_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $ticket_id);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    
    if (mysqli_stmt_num_rows($check_stmt) == 0) {
        echo json_encode(['success' => false, 'message' => 'Ticket not found']);
        mysqli_stmt_close($check_stmt);
        mysqli_close($conn);
        exit;
    }
    mysqli_stmt_close($check_stmt);
    
    // Add reply as admin
    $admin_id = $_SESSION['user_id'];
    $insert_query = "INSERT INTO support_ticket_replies (ticket_id, user_id, message, created_at) VALUES (?, ?, ?, NOW())";
    $insert_stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($insert_stmt, "iis", $ticket_id, $admin_id, $message);
    
    if (mysqli_stmt_execute($insert_stmt)) {
        echo json_encode(['success' => true, 'message' => 'Reply added successfully']);
    } else {
        throw new Exception();
    }
    
    mysqli_stmt_close($insert_stmt);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to add reply']);
}

mysqli_close($conn);
?>