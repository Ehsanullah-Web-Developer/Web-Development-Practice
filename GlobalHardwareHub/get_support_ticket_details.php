<?php
// get_support_ticket_details.php
// Fetch complete details of a specific support ticket

session_start();
header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';

// Admin authentication check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

// Get ticket ID from GET request
if (!isset($_GET['ticket_id']) || empty($_GET['ticket_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid ticket ID'
    ]);
    exit;
}

$ticket_id = (int)$_GET['ticket_id'];

try {
    // Fetch main ticket data with user information
    $ticket_query = "SELECT 
                        st.ticket_id,
                        st.user_id,
                        st.order_id,
                        st.subject,
                        st.category,
                        st.message,
                        st.attachment,
                        st.status,
                        st.created_at,
                        u.full_name as user_name,
                        u.email as user_email
                    FROM support_tickets st
                    INNER JOIN users u ON st.user_id = u.user_id
                    WHERE st.ticket_id = ?";
    
    $ticket_stmt = mysqli_prepare($conn, $ticket_query);
    mysqli_stmt_bind_param($ticket_stmt, "i", $ticket_id);
    mysqli_stmt_execute($ticket_stmt);
    $ticket_result = mysqli_stmt_get_result($ticket_stmt);
    
    // Check if ticket exists
    if (mysqli_num_rows($ticket_result) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Ticket not found'
        ]);
        mysqli_stmt_close($ticket_stmt);
        mysqli_close($conn);
        exit;
    }
    
    $ticket_data = mysqli_fetch_assoc($ticket_result);
    mysqli_stmt_close($ticket_stmt);
    
    // Format ticket data
    $ticket = [
        'ticket_id' => (int)$ticket_data['ticket_id'],
        'subject' => $ticket_data['subject'],
        'category' => $ticket_data['category'],
        'message' => $ticket_data['message'],
        'attachment' => $ticket_data['attachment'],
        'status' => $ticket_data['status'],
        'order_id' => $ticket_data['order_id'] ? (int)$ticket_data['order_id'] : null,
        'created_at' => $ticket_data['created_at'],
        'user_name' => $ticket_data['user_name'],
        'user_email' => $ticket_data['user_email']
    ];
    
    // Fetch all replies for this ticket
    $replies_query = "SELECT 
                        str.reply_id,
                        str.ticket_id,
                        str.user_id,
                        str.message,
                        str.created_at,
                        u.full_name as user_name
                    FROM support_ticket_replies str
                    INNER JOIN users u ON str.user_id = u.user_id
                    WHERE str.ticket_id = ?
                    ORDER BY str.created_at ASC";
    
    $replies_stmt = mysqli_prepare($conn, $replies_query);
    mysqli_stmt_bind_param($replies_stmt, "i", $ticket_id);
    mysqli_stmt_execute($replies_stmt);
    $replies_result = mysqli_stmt_get_result($replies_stmt);
    
    $replies = [];
    while ($reply = mysqli_fetch_assoc($replies_result)) {
        $replies[] = [
            'reply_id' => (int)$reply['reply_id'],
            'user_name' => $reply['user_name'],
            'message' => $reply['message'],
            'created_at' => $reply['created_at']
        ];
    }
    mysqli_stmt_close($replies_stmt);
    
    // Return success response
    echo json_encode([
        'success' => true,
        'ticket' => $ticket,
        'replies' => $replies
    ]);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load ticket details'
    ]);
}

// Close database connection
mysqli_close($conn);
?>