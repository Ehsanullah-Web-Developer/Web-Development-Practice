<?php
// get_all_support_tickets.php
// Fetch all support tickets for admin support management

session_start();
header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';

// Admin authentication check
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

try {
    // Base query
    $query = "SELECT 
                st.ticket_id,
                st.user_id,
                st.order_id,
                st.subject,
                st.category,
                st.message,
                st.attachment,
                st.status,
                st.created_at,
                u.full_name as user_name
              FROM support_tickets st
              INNER JOIN users u ON st.user_id = u.user_id
              WHERE 1=1";
    
    // Optional filters
    $filters = [];
    $types = "";
    $params = [];
    
    // Filter by status if provided
    if (isset($_GET['status']) && !empty($_GET['status'])) {
        $query .= " AND st.status = ?";
        $filters[] = $_GET['status'];
        $types .= "s";
    }
    
    // Order by created date descending
    $query .= " ORDER BY st.created_at DESC";
    
    // Prepare and execute statement
    $stmt = mysqli_prepare($conn, $query);
    
    if (!empty($filters)) {
        mysqli_stmt_bind_param($stmt, $types, ...$filters);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if query was successful
    if (!$result) {
        throw new Exception();
    }
    
    $tickets = [];
    
    // Fetch all tickets
    while ($row = mysqli_fetch_assoc($result)) {
        $tickets[] = [
            'ticket_id' => (int)$row['ticket_id'],
            'subject' => $row['subject'],
            'user_name' => $row['user_name'],
            'status' => $row['status'],
            'created_at' => $row['created_at']
        ];
    }
    
    // Return success response
    echo json_encode([
        'success' => true,
        'tickets' => $tickets
    ]);
    
    // Close statement
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load support tickets'
    ]);
}

// Close database connection
mysqli_close($conn);
?>