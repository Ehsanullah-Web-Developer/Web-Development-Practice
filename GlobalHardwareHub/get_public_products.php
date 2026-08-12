<?php
// get_public_products.php - Public API for fetching products on homepage
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include database connection
require_once 'db_connect.php';

try {
    // Query to get all active products with their images
    $query = "SELECT 
                p.product_id as id,
                p.name,
                p.regular_price as price,
                p.sale_price,
                p.category,
                p.brand,
                (SELECT pi.image_url 
                 FROM product_images pi 
                 WHERE pi.product_id = p.product_id 
                 ORDER BY pi.sort_order ASC 
                 LIMIT 1) as image
              FROM products p
              WHERE p.status = 'active' OR p.status IS NULL
              ORDER BY p.created_at DESC";
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }
    
    $products = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine final price (use sale_price if available, otherwise regular_price)
        $price = $row['price'];
        if (!empty($row['sale_price']) && $row['sale_price'] > 0 && $row['sale_price'] < $row['price']) {
            $price = $row['sale_price'];
        }
        
        // Handle image URL
        $image = $row['image'];
        if (empty($image)) {
            $image = 'https://placehold.co/400x400/2563eb/white?text=' . urlencode($row['name']);
        }
        
        $products[] = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'price' => (float)$price,
            'category' => $row['category'],
            'brand' => $row['brand'],
            'image' => $image
        ];
    }
    
    echo json_encode($products);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to load products: ' . $e->getMessage()]);
}

mysqli_close($conn);
?>