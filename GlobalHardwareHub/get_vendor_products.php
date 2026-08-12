<?php
/**
 * get_vendor_products.php (Fixed Version - Includes price AND stock quantity from product_stock)
 */

session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

function sendResponse($success, $data = null, $message = null) {
    $response = ['success' => $success];
    if ($data !== null) $response['data'] = $data;
    if ($message !== null) $response['message'] = $message;
    echo json_encode($response);
    exit;
}

// Check login
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please login first');
}

// Map to vendor_id
$vendorId = $_SESSION['user_id'] - 10;
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied. Vendor account required.');
}

// Get filter parameters
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : 'all';
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query - INCLUDING regular_price AND stock from product_stock
$sql = "SELECT 
            vp.vp_id,
            vp.product_id,
            p.name as product_name,
            pc.name as category_name,
            p.regular_price,
            (SELECT image_url FROM product_images WHERE product_id = p.product_id ORDER BY sort_order ASC LIMIT 1) as image_url,
            p.status,
            COALESCE(ps.quantity, 0) AS stock
        FROM vendor_products vp
        INNER JOIN products p ON vp.product_id = p.product_id
        LEFT JOIN product_categories pc ON p.category_id = pc.category_id
        LEFT JOIN product_stock ps ON vp.product_id = ps.product_id AND vp.vendor_id = ps.vendor_id
        WHERE vp.vendor_id = ?";

if ($statusFilter !== 'all') {
    $sql .= " AND p.status = ?";
}
if (!empty($searchTerm)) {
    $sql .= " AND p.name LIKE ?";
}
$sql .= " ORDER BY vp.vp_id DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    sendResponse(false, null, 'Unable to fetch products');
}

// Bind parameters
if ($statusFilter !== 'all' && !empty($searchTerm)) {
    $searchParam = "%{$searchTerm}%";
    $stmt->bind_param('iss', $vendorId, $statusFilter, $searchParam);
} elseif ($statusFilter !== 'all') {
    $stmt->bind_param('is', $vendorId, $statusFilter);
} elseif (!empty($searchTerm)) {
    $searchParam = "%{$searchTerm}%";
    $stmt->bind_param('is', $vendorId, $searchParam);
} else {
    $stmt->bind_param('i', $vendorId);
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = [
        'vp_id' => (int)$row['vp_id'],
        'product_id' => (int)$row['product_id'],
        'product_name' => $row['product_name'],
        'category_name' => $row['category_name'] ?? 'Uncategorized',
        'regular_price' => (float)($row['regular_price'] ?? 0),
        'image_url' => $row['image_url'] ?? '',
        'status' => $row['status'],
        'stock' => (int)$row['stock']
    ];
}

$stmt->close();
$conn->close();

sendResponse(true, $products);
?>