<?php
// ==============================================
// File: get_blog_posts.php
// Description: API endpoint to fetch all blog posts with author names
// Returns: JSON array of blog posts
// ==============================================

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== FETCH BLOG POSTS FROM DATABASE ==============
try {
    // SQL query to fetch blog posts with author full_name
    // Join blog_posts with users table to get author name
    $sql = "SELECT 
                bp.post_id,
                bp.title,
                bp.slug,
                bp.content,
                bp.author_id,
                bp.created_at,
                bp.image_url,
                u.full_name as author_name
            FROM blog_posts bp
            INNER JOIN users u ON bp.author_id = u.user_id
            ORDER BY bp.created_at DESC";
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    $posts = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = array(
                "post_id" => (int)$row['post_id'],
                "title" => $row['title'],
                "slug" => $row['slug'],
                "content" => $row['content'],
                "author_id" => (int)$row['author_id'],
                "author_name" => $row['author_name'],
                "created_at" => $row['created_at'],
                "image_url" => $row['image_url'] ?? "default-blog.jpg"
            );
        }
    }
    
    // Return success response with posts data
    echo json_encode([
        'success' => true,
        'data' => $posts
    ]);
    
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