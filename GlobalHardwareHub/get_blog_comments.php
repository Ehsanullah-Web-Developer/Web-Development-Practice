<?php
// ==============================================
// File: get_blog_comments.php
// Description: API endpoint to fetch all comments for a specific blog post
// Returns: JSON array of comments
// Usage: get_blog_comments.php?post_id=5
// ==============================================

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== GET AND VALIDATE POST ID ==============
// Check if post_id parameter is provided
if (!isset($_GET['post_id']) || empty($_GET['post_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Post ID is required'
    ]);
    exit;
}

// Get post_id from URL and validate it's an integer
$postId = (int)$_GET['post_id'];

// Validate that post_id is positive
if ($postId <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid post ID'
    ]);
    exit;
}

// ============== FETCH COMMENTS FROM DATABASE ==============
try {
    // Prepare SQL query to fetch comments with user names
    // Join blog_comments with users table to get commenter's full name
    // Order by created_at ASC (oldest comments first)
    $sql = "SELECT 
                bc.comment_id,
                bc.post_id,
                bc.user_id,
                bc.comment,
                bc.created_at,
                u.full_name as user_name
            FROM blog_comments bc
            INNER JOIN users u ON bc.user_id = u.user_id
            WHERE bc.post_id = ?
            ORDER BY bc.created_at ASC";
    
    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Database prepare error: " . $conn->error);
    }
    
    // Bind parameter (i = integer)
    $stmt->bind_param("i", $postId);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Build comments array
    $comments = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $comments[] = array(
                "comment_id" => (int)$row['comment_id'],
                "post_id" => (int)$row['post_id'],
                "user_id" => (int)$row['user_id'],
                "user_name" => $row['user_name'],
                "comment" => $row['comment'],
                "created_at" => $row['created_at']
            );
        }
    }
    
    // Return success response with comments data
    echo json_encode([
        'success' => true,
        'data' => $comments
    ]);
    
    // Close statement
    $stmt->close();
    
} catch (Exception $e) {
    // Return error message if something goes wrong
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
}

// Close database connection
$conn->close();
?>