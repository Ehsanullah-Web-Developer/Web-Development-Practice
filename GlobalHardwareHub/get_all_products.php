<?php
// get_all_products.php
// Fetch all products for admin product management

session_start();
header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';


try {
    // Base query - Get products with their first image (lowest sort_order)
    $query = "SELECT 
                p.product_id,
                p.name,
                p.regular_price,
                p.sale_price,
                p.status,
                p.created_at,
                (SELECT pi.image_url 
                 FROM product_images pi 
                 WHERE pi.product_id = p.product_id 
                 ORDER BY pi.sort_order ASC 
                 LIMIT 1) as image_url
              FROM products p
              WHERE 1=1";

    // Optional filters
    $filters = [];
    $types = "";
    $params = [];

    // Filter by status if provided
    if (isset($_GET['status']) && !empty($_GET['status'])) {
        $query .= " AND p.status = ?";
        $filters[] = $_GET['status'];
        $types .= "s";
    }

    // Filter by product name if provided
    if (isset($_GET['product_name']) && !empty($_GET['product_name'])) {
        $query .= " AND p.name LIKE ?";
        $filters[] = "%" . $_GET['product_name'] . "%";
        $types .= "s";
    }

    // Order by created date descending
    $query .= " ORDER BY p.created_at DESC";

    // Prepare and execute statement
    $stmt = mysqli_prepare($conn, $query);

    if (!empty($filters)) {
        mysqli_stmt_bind_param($stmt, $types, ...$filters);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if query was successful
    if (!$result) {
        throw new Exception();
    }

    $products = [];
    $default_image = "uploads/products/default.png";

    // Fetch all products
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine final price
        // Determine final price - ALWAYS use regular_price for admin panel
        $price = (float) $row['regular_price'];

        // Set image URL or use default
        $image_url = $row['image_url'];
        if (empty($image_url)) {
            $image_url = $default_image;
        }

        $products[] = [
            'product_id' => (int) $row['product_id'],
            'product_name' => $row['name'],
            'image_url' => $image_url,
            'price' => $price,
            'status' => $row['status'],
            'created_at' => $row['created_at']
        ];
    }

    // Return success response
    echo json_encode([
        'success' => true,
        'products' => $products
    ]);

    // Close statement
    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    // Error handling
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load products'
    ]);
}

// Close database connection
mysqli_close($conn);
?>