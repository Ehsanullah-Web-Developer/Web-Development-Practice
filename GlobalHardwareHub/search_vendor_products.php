<?php
/**
 * search_vendor_products.php
 * 
 * This API endpoint allows logged-in vendors to search their products by name.
 * Returns products matching the search query.
 * 
 * Expected input: GET parameter 'query'
 * Expected output: JSON format with matching products
 */

// Start session to check user login status
session_start();

// Include database connection
require_once 'db_connect.php';

// Set response header to JSON
header('Content-Type: application/json');

/**
 * Helper function to send JSON response and exit
 */
function sendResponse($success, $data = null, $message = null) {
    $response = ['success' => $success];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    if ($message !== null) {
        $response['message'] = $message;
    }
    
    echo json_encode($response);
    exit;
}

/**
 * STEP 1: Check if user is logged in
 */
if (!isset($_SESSION['user_id'])) {
    sendResponse(false, null, 'Please login first');
}

$loggedInUserId = $_SESSION['user_id'];

/**
 * STEP 2: Map user_id to vendor_id
 * User IDs 11-18 correspond to vendor IDs 1-8
 * Formula: vendor_id = user_id - 10
 */
$vendorId = $loggedInUserId - 10;

// Validate that vendor_id is between 1 and 8
if ($vendorId < 1 || $vendorId > 8) {
    sendResponse(false, null, 'Access denied. Vendor account required.');
}

/**
 * STEP 3: Get search query from GET parameter
 */
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// If search query is empty, return empty array
if (empty($searchQuery)) {
    sendResponse(true, []);
}

/**
 * STEP 4: Build search query
 * Search by product name using LIKE (case insensitive)
 * Limit results to 20
 */
$sql = "SELECT 
            vp.vp_id,
            vp.product_id,
            p.name as product_name,
            pc.name as category_name,
            (SELECT image_url 
             FROM product_images 
             WHERE product_id = p.product_id 
             ORDER BY sort_order ASC 
             LIMIT 1) as image_url,
            COALESCE(p.stock_quantity, 0) as stock,
            p.status
        FROM vendor_products vp
        INNER JOIN products p ON vp.product_id = p.product_id
        LEFT JOIN product_categories pc ON p.category_id = pc.category_id
        WHERE vp.vendor_id = ? 
        AND p.name LIKE ?
        ORDER BY p.name ASC
        LIMIT 20";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    sendResponse(false, null, 'Unable to search products');
}

$searchParam = "%{$searchQuery}%";
$stmt->bind_param('is', $vendorId, $searchParam);
$stmt->execute();
$result = $stmt->get_result();

/**
 * STEP 5: Build products array
 */
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = [
        'vp_id' => (int)$row['vp_id'],
        'product_id' => (int)$row['product_id'],
        'product_name' => $row['product_name'],
        'category_name' => $row['category_name'] ?? 'Uncategorized',
        'image_url' => $row['image_url'] ?? '',
        'stock' => (int)$row['stock'],
        'status' => $row['status']
    ];
}

$stmt->close();
$conn->close();

/**
 * STEP 6: Return success response with products
 */
sendResponse(true, $products);
?>