<?php
// ==============================================
// File: get_products.php (with sale price and quantity support)
// ==============================================

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== PAGINATION PARAMETERS ==============
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$limit = 16;
$offset = ($page - 1) * $limit;

// ============== FETCH PRODUCTS WITH JOIN ==============
try {
    // Uses sale_price if available, otherwise regular_price
    // Uses quantity from product_stock table
    $sql = "SELECT 
                p.product_id as id,
                p.name,
                COALESCE(p.sale_price, p.regular_price) as price,
                p.status,
                MIN(pi.image_url) as image,
                COALESCE(ps.quantity, 0) as stock
            FROM products p
            LEFT JOIN product_images pi ON p.product_id = pi.product_id
            LEFT JOIN product_stock ps ON p.product_id = ps.product_id
            GROUP BY p.product_id, p.name, p.regular_price, p.sale_price, p.status, ps.quantity
            ORDER BY p.product_id ASC
            LIMIT ? OFFSET ?";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Database prepare error: " . $conn->error);
    }
    
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $products = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $price = is_numeric($row['price']) ? (int)$row['price'] : 0;
            
            // FIX: Extract just the filename from any path
            $imageName = $row['image'] !== null ? $row['image'] : "default-product.jpg";
            // Remove any directory path, get just the filename
            $imageName = basename($imageName);
            
            $product = array(
                "id" => (int)$row['id'],
                "name" => $row['name'],
                "price" => $price,
                "image" => $imageName,  // Now returns ONLY filename like "amdryzen97950x.jpg"
                "status" => $row['status'] !== null ? $row['status'] : "unknown",
                "stock" => (int)$row['stock']
            );
            
            $products[] = $product;
        }
    }
    
    echo json_encode($products);
    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode(array(
        "error" => true,
        "message" => "Database error: " . $e->getMessage()
    ));
}

$conn->close();
?>