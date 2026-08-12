<?php
// delete_review.php
// Allow admin to delete customer reviews

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

// Get review ID from POST request
$review_id = isset($_POST['vendor_review_id']) ? (int)$_POST['vendor_review_id'] : 0;

// Validate review ID
if ($review_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Review ID is required'
    ]);
    exit;
}

try {
    // Check if review exists before deleting
    $check_query = "SELECT vendor_review_id FROM vendor_reviews WHERE vendor_review_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $review_id);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
    
    if (mysqli_stmt_num_rows($check_stmt) == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Review not found'
        ]);
        mysqli_stmt_close($check_stmt);
        mysqli_close($conn);
        exit;
    }
    mysqli_stmt_close($check_stmt);
    
    // Delete the review
    $delete_query = "DELETE FROM vendor_reviews WHERE vendor_review_id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($delete_stmt, "i", $review_id);
    
    if (mysqli_stmt_execute($delete_stmt)) {
        echo json_encode([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    } else {
        throw new Exception();
    }
    
    mysqli_stmt_close($delete_stmt);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to delete review'
    ]);
}

// Close database connection
mysqli_close($conn);
?>