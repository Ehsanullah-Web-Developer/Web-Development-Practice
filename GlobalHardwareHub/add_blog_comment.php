<?php
// ==============================================
// File: add_blog_comment.php
// Description: API endpoint to add a comment to a blog post
// Returns: JSON response
// Usage: POST request with post_id and comment
// ==============================================

// Start session to access user data
session_start();

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== CHECK IF USER IS LOGGED IN ==============
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please login first to post a comment'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

// ============== CHECK REQUEST METHOD ==============
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. POST required.'
    ]);
    exit;
}

// ============== GET AND VALIDATE INPUT ==============
$postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

// Validate post_id
if ($postId <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid post ID'
    ]);
    exit;
}

// Validate comment is not empty
if (empty($comment)) {
    echo json_encode([
        'success' => false,
        'message' => 'Comment cannot be empty'
    ]);
    exit;
}

// Validate comment length (optional - minimum 3 characters)
if (strlen($comment) < 3) {
    echo json_encode([
        'success' => false,
        'message' => 'Comment must be at least 3 characters long'
    ]);
    exit;
}

// Validate comment length (optional - maximum 1000 characters)
if (strlen($comment) > 1000) {
    echo json_encode([
        'success' => false,
        'message' => 'Comment cannot exceed 1000 characters'
    ]);
    exit;
}

// ============== VERIFY BLOG POST EXISTS ==============
try {
    $checkStmt = $conn->prepare("SELECT post_id FROM blog_posts WHERE post_id = ?");
    $checkStmt->bind_param("i", $postId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Blog post not found'
        ]);
        $checkStmt->close();
        $conn->close();
        exit;
    }
    $checkStmt->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
    $conn->close();
    exit;
}

// ============== INSERT COMMENT INTO DATABASE ==============
try {
    // Prepare SQL query to insert comment
    $sql = "INSERT INTO blog_comments (post_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Database prepare error: " . $conn->error);
    }
    
    // Bind parameters (i = integer, s = string)
    $stmt->bind_param("iis", $postId, $userId, $comment);
    
    // Execute the query
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Comment added successfully'
        ]);
    } else {
        throw new Exception("Failed to insert comment");
    }
    
    // Close statement
    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to add comment. Please try again.'
    ]);
}

// Close database connection
$conn->close();
?>