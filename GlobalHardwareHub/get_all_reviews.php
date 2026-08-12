<?php
// get_all_reviews.php
// Fetch all customer reviews for admin reviews management

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
    // Fetch all reviews with product and user information
    $query = "SELECT 
                vr.vendor_review_id,
                vr.vendor_id,
                vr.user_id,
                vr.product_id,
                vr.rating,
                vr.comment,
                vr.created_at,
                u.full_name as user_name,
                p.name as product_name
              FROM vendor_reviews vr
              INNER JOIN users u ON vr.user_id = u.user_id
              INNER JOIN products p ON vr.product_id = p.product_id
              ORDER BY vr.created_at DESC";
    
    $result = mysqli_query($conn, $query);
    
    // Check if query was successful
    if (!$result) {
        throw new Exception();
    }
    
    $reviews = [];
    
    // Fetch all reviews
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = [
            'review_id' => (int)$row['vendor_review_id'],
            'product_name' => $row['product_name'],
            'user_name' => $row['user_name'],
            'rating' => (int)$row['rating'],
            'comment' => $row['comment'],
            'created_at' => $row['created_at']
        ];
    }
    
    // Return success response
    echo json_encode([
        'success' => true,
        'reviews' => $reviews
    ]);
    
} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load reviews'
    ]);
}

// Close database connection
mysqli_close($conn);
?>