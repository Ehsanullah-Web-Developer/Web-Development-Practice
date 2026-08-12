<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

// Get and sanitize input parameters
$category = isset($_GET['category']) ? trim($_GET['category']) : null;
$brand = isset($_GET['brand']) ? trim($_GET['brand']) : null;
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;

// Validate pagination parameters
if ($page < 1) $page = 1;
if ($limit < 1) $limit = 12;
$offset = ($page - 1) * $limit;

// Base query with effective price calculation
$base_query = "FROM products p 
               INNER JOIN product_categories pc ON p.category_id = pc.category_id
               LEFT JOIN (
                   SELECT product_id, MIN(sort_order) as min_sort
                   FROM product_images
                   GROUP BY product_id
               ) img_sort ON p.product_id = img_sort.product_id
               LEFT JOIN product_images pi ON p.product_id = pi.product_id 
                   AND pi.sort_order = img_sort.min_sort
               WHERE p.status = 'active'";

// Build WHERE conditions dynamically
$where_conditions = [];
$params = [];
$types = "";

if ($category !== null && $category !== '') {
    $where_conditions[] = "pc.name = ?";
    $params[] = $category;
    $types .= "s";
}

if ($brand !== null && $brand !== '') {
    $where_conditions[] = "p.name LIKE ?";
    $params[] = "%" . $brand . "%";
    $types .= "s";
}

if ($min_price !== null && $min_price > 0) {
    $where_conditions[] = "(CASE 
                              WHEN p.sale_price IS NOT NULL AND p.sale_price > 0 
                              THEN p.sale_price 
                              ELSE p.regular_price 
                          END) >= ?";
    $params[] = $min_price;
    $types .= "d";
}

if ($max_price !== null && $max_price > 0) {
    $where_conditions[] = "(CASE 
                              WHEN p.sale_price IS NOT NULL AND p.sale_price > 0 
                              THEN p.sale_price 
                              ELSE p.regular_price 
                          END) <= ?";
    $params[] = $max_price;
    $types .= "d";
}

// Add conditions to query
if (!empty($where_conditions)) {
    $base_query .= " AND " . implode(" AND ", $where_conditions);
}

// Get total count for pagination
$count_query = "SELECT COUNT(DISTINCT p.product_id) as total " . $base_query;
$stmt = $conn->prepare($count_query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$count_result = $stmt->get_result();
$total_products = $count_result->fetch_assoc()['total'];
$stmt->close();

// Calculate pagination
$total_pages = ceil($total_products / $limit);

// Main query to fetch products
$select_query = "SELECT 
                    p.product_id,
                    p.name,
                    pc.name as category,
                    CASE 
                        WHEN p.sale_price IS NOT NULL AND p.sale_price > 0 
                        THEN p.sale_price 
                        ELSE p.regular_price 
                    END as price,
                    COALESCE(pi.image_url, 'placeholder.jpg') as image_url
                 " . $base_query . "
                 ORDER BY p.product_id DESC
                 LIMIT ? OFFSET ?";

// Add limit and offset to parameters
$params[] = $limit;
$params[] = $offset;
$types .= "ii";

$stmt = $conn->prepare($select_query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Fetch products
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = [
        'product_id' => (int)$row['product_id'],
        'name' => $row['name'],
        'category' => $row['category'],
        'price' => (float)$row['price'],
        'image_url' => $row['image_url']
    ];
}
$stmt->close();

// Return JSON response
echo json_encode([
    'success' => true,
    'products' => $products,
    'pagination' => [
        'current_page' => $page,
        'total_pages' => $total_pages,
        'total_products' => (int)$total_products
    ]
]);

$conn->close();
?>