<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "User not logged in"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch wishlist items with product details and image
$sql = "SELECT 
            w.wishlist_id,
            w.product_id,
            w.created_at,
            p.name AS product_name,
            p.regular_price,
            p.sale_price,
            p.status,
            (SELECT pi.image_url 
             FROM product_images pi 
             WHERE pi.product_id = p.product_id 
             ORDER BY pi.sort_order ASC 
             LIMIT 1) AS image_url
        FROM wishlist w
        INNER JOIN products p ON w.product_id = p.product_id
        WHERE w.user_id = ?
        ORDER BY w.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$wishlist = [];

while ($row = $result->fetch_assoc()) {
    // Determine price (use sale_price if available, otherwise regular_price)
    $price = $row['regular_price'];
    if (!is_null($row['sale_price']) && $row['sale_price'] > 0) {
        $price = $row['sale_price'];
    }
    
    // Handle image URL (use placeholder if no image found)
    $image_url = $row['image_url'];
    if (empty($image_url)) {
        $image_url = "uploads/products/placeholder.jpg";
    }
    
    $wishlist[] = [
        "product_id" => (int)$row['product_id'],
        "product_name" => $row['product_name'],
        "price" => (float)$price,
        "image_url" => $image_url,
        "status" => $row['status']
    ];
}

$stmt->close();
$conn->close();

// Return success response with wishlist
echo json_encode([
    "success" => true,
    "wishlist" => $wishlist
]);
?>