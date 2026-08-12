<?php
/**
 * get_cart_summary.php
 * 
 * This API endpoint fetches the logged-in user's cart items from the database
 * and returns a complete cart summary including items, subtotals, and totals.
 * 
 * Expected output: JSON format for checkout page integration
 */

// Start session to access user login information
session_start();

// Include database connection
require_once 'db_connect.php';

// Set response header to JSON
header('Content-Type: application/json');

/**
 * Check if user is logged in
 * If not logged in, return error response and stop execution
 */
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please Login First'
    ]);
    exit;
}

// Get logged-in user ID
$userId = $_SESSION['user_id'];

/**
 * Prepare SQL query to fetch cart items with product details, vendor_id, and images
 */
$sql = "
    SELECT 
        c.cart_id,
        c.user_id,
        c.product_id,
        c.quantity,
        p.name,
        p.regular_price,
        p.sale_price,
        p.status,
        p.vendor_id,
        (
            SELECT image_url 
            FROM product_images 
            WHERE product_id = p.product_id 
            ORDER BY sort_order ASC 
            LIMIT 1
        ) AS image_url
    FROM cart c
    INNER JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?
";

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare($sql);

if (!$stmt) {
    // Database error occurred - don't expose details for security
    echo json_encode([
        'success' => false,
        'message' => 'Unable to fetch cart items. Please try again later.'
    ]);
    exit;
}

$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

// Initialize cart items array and summary variables
$items = [];
$subtotal = 0;
$totalItems = 0;

/**
 * Process each cart item
 * Calculate price (sale_price takes priority over regular_price)
 * Calculate item subtotal and accumulate totals
 */
while ($row = $result->fetch_assoc()) {
    // Determine the effective price for this product
    $price = 0;
    if (!empty($row['sale_price']) && $row['sale_price'] > 0) {
        $price = (float)$row['sale_price'];
    } else {
        $price = (float)$row['regular_price'];
    }
    
    $quantity = (int)$row['quantity'];
    $itemSubtotal = $price * $quantity;
    $vendorId = (int)$row['vendor_id'];
    
    // Build item object with vendor_id
    $item = [
        'cart_id' => (int)$row['cart_id'],
        'product_id' => (int)$row['product_id'],
        'name' => $row['name'],
        'image' => $row['image_url'] ?? '',
        'price' => $price,
        'quantity' => $quantity,
        'subtotal' => $itemSubtotal,
        'status' => $row['status'] ?? 'active',
        'vendor_id' => $vendorId
    ];
    
    // Add item to items array
    $items[] = $item;
    
    // Accumulate totals
    $subtotal += $itemSubtotal;
    $totalItems += $quantity;
}

// Close the prepared statement
$stmt->close();

// Close database connection
$conn->close();

/**
 * Prepare and return the final JSON response
 */
$response = [
    'success' => true,
    'data' => [
        'items' => $items,
        'subtotal' => $subtotal,
        'total_items' => $totalItems,
        'grand_total' => $subtotal
    ]
];

echo json_encode($response);
?>