<?php
// ==============================================
// File: get_product_details.php
// Description: API endpoint to fetch single product details with image and stock
// Returns: JSON object of product details
// Usage: get_product_details.php?id=5
// ==============================================

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== GET AND VALIDATE PRODUCT ID ==============
// Check if id parameter is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(array(
        "error" => true,
        "message" => "Product ID is required"
    ));
    exit;
}

// Get product_id from URL and validate it's an integer
$product_id = (int)$_GET['id'];

// Validate that product_id is positive
if ($product_id <= 0) {
    echo json_encode(array(
        "error" => true,
        "message" => "Invalid product ID"
    ));
    exit;
}

// ============== FETCH SINGLE PRODUCT WITH JOIN ==============
try {
    // SQL query with JOINs to get product, image, and stock data
    // Using LEFT JOIN to ensure product is shown even without image or stock
    // Using MIN to get the first image if multiple exist
    $sql = "SELECT 
                p.product_id,
                p.name,
                p.regular_price as price,
                p.description,
                p.status,
                MIN(pi.image_url) as image,
                COALESCE(ps.quantity, 0) as stock
            FROM products p
            LEFT JOIN product_images pi ON p.product_id = pi.product_id
            LEFT JOIN product_stock ps ON p.product_id = ps.product_id
            WHERE p.product_id = ?
            GROUP BY p.product_id, p.name, p.regular_price, p.description, p.status, ps.quantity";
    
    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Database prepare error: " . $conn->error);
    }
    
    // Bind parameter (i = integer)
    $stmt->bind_param("i", $product_id);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // ============== BUILD RESPONSE ARRAY ==============
    if ($result->num_rows > 0) {
        // Fetch product data
        $row = $result->fetch_assoc();
        
        // Convert price to integer if it's numeric
        $price = is_numeric($row['price']) ? (int)$row['price'] : 0;
        
        // Build product object
        $product = array(
            "product_id" => (int)$row['product_id'],
            "name" => $row['name'],
            "price" => $price,
            "description" => $row['description'] !== null ? $row['description'] : "",
            "status" => $row['status'] !== null ? $row['status'] : "unknown",
            "image" => $row['image'] !== null ? $row['image'] : "default-product.jpg",
            "stock" => (int)$row['stock']
        );
        
        // Return success response
        echo json_encode($product);
        
    } else {
        // Product not found
        echo json_encode(array(
            "error" => true,
            "message" => "Product not found"
        ));
    }
    
    // Close statement
    $stmt->close();
    
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