<?php
// ==============================================
// File: get_categories.php
// Description: API endpoint to fetch all product categories
// Returns: JSON array of categories
// ==============================================

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== FETCH CATEGORIES FROM DATABASE ==============
try {
    // Simple SELECT query to fetch all categories
    $sql = "SELECT category_id, name, description, image_url FROM product_categories ORDER BY name ASC";
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    $categories = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = array(
                "category_id" => (int)$row['category_id'],
                "name" => $row['name'],
                "description" => $row['description'] ?? "",
                "image_url" => $row['image_url'] ?? "default-category.jpg"
            );
        }
    }
    
    // Return categories as JSON
    echo json_encode($categories);
    
} catch (Exception $e) {
    // Return error message if something goes wrong
    echo json_encode(array(
        "error" => true,
        "message" => "Database error: " . $e->getMessage()
    ));
}

// Close database connection
$conn->close();
?>