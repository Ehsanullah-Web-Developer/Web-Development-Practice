<?php
// ==============================================
// File: get_comparison_products.php
// Description: API endpoint to fetch user-specific comparison products with full details
// Returns: JSON array of products for comparison
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
        'message' => 'Please login first'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

// ============== FETCH COMPARISON PRODUCTS FROM DATABASE ==============
try {
    // SQL query to fetch comparison products with product details and image
    // Join product_comparisons with products table
    // Left join with product_images to get one image per product (using MIN to get first image)
    $sql = "SELECT 
                p.product_id,
                p.name,
                p.description,
                p.regular_price,
                p.sale_price,
                p.status,
                MIN(pi.image_url) as image
            FROM product_comparisons pc
            INNER JOIN products p ON pc.product_id = p.product_id
            LEFT JOIN product_images pi ON p.product_id = pi.product_id
            WHERE pc.user_id = ?
            GROUP BY p.product_id, p.name, p.description, p.regular_price, p.sale_price, p.status
            ORDER BY pc.created_at DESC";
    
    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Database prepare error: " . $conn->error);
    }
    
    // Bind parameter (i = integer)
    $stmt->bind_param("i", $userId);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Build products array
    $products = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Determine price (use sale_price if available, otherwise regular_price)
            $price = $row['sale_price'] !== null && $row['sale_price'] > 0 
                    ? (float)$row['sale_price'] 
                    : (float)$row['regular_price'];
            
            $products[] = array(
                "product_id" => (int)$row['product_id'],
                "name" => $row['name'],
                "description" => $row['description'] ?? "",
                "regular_price" => (float)$row['regular_price'],
                "sale_price" => $row['sale_price'] !== null ? (float)$row['sale_price'] : null,
                "price" => $price,
                "status" => $row['status'] ?? "available",
                "image" => $row['image'] ?? "default-product.jpg"
            );
        }
    }
    
    // Return success response with products data
    echo json_encode([
        'success' => true,
        'data' => $products
    ]);
    
    // Close statement
    $stmt->close();
    
} catch (Exception $e) {
    // Return error message if something goes wrong (without exposing database details)
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
}

// Close database connection
$conn->close();
?>