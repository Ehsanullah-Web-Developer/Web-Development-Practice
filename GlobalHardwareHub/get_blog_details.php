<?php
// ==============================================
// File: get_blog_details.php
// Description: API endpoint to fetch a single blog post with full details
// Returns: JSON object of blog post
// Usage: get_blog_details.php?id=5 OR get_blog_details.php?slug=post-title
// ==============================================

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== GET AND VALIDATE INPUT ==============
// Check if either id or slug parameter is provided
$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if ($postId <= 0 && empty($slug)) {
    echo json_encode([
        'success' => false,
        'message' => 'Either post ID or slug is required'
    ]);
    exit;
}

// ============== FETCH SINGLE BLOG POST FROM DATABASE ==============
try {
    // Prepare SQL query based on input type
    if ($postId > 0) {
        // Fetch by post_id
        $sql = "SELECT 
                    bp.post_id,
                    bp.title,
                    bp.slug,
                    bp.content,
                    bp.image_url,
                    bp.author_id,
                    bp.created_at,
                    u.full_name as author_name
                FROM blog_posts bp
                INNER JOIN users u ON bp.author_id = u.user_id
                WHERE bp.post_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        
    } else {
        // Fetch by slug
        $sql = "SELECT 
                    bp.post_id,
                    bp.title,
                    bp.slug,
                    bp.content,
                    bp.image_url,
                    bp.author_id,
                    bp.created_at,
                    u.full_name as author_name
                FROM blog_posts bp
                INNER JOIN users u ON bp.author_id = u.user_id
                WHERE bp.slug = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $slug);
    }
    
    if (!$stmt) {
        throw new Exception("Database prepare error: " . $conn->error);
    }
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if post exists
    if ($result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Blog post not found'
        ]);
        $stmt->close();
        $conn->close();
        exit;
    }
    
    // Fetch blog post data
    $row = $result->fetch_assoc();
    
    // Build response data
    $post = array(
        "post_id" => (int)$row['post_id'],
        "title" => $row['title'],
        "slug" => $row['slug'],
        "content" => $row['content'],
        "author_id" => (int)$row['author_id'],
        "author_name" => $row['author_name'],
        "created_at" => $row['created_at'],
        "image_url" => $row['image_url'] ?? "default-blog.jpg"
    );
    
    // Return success response with post data
    echo json_encode([
        'success' => true,
        'data' => $post
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