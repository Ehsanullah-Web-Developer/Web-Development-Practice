<?php
session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

// Check login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$userId = $_SESSION['user_id'];
$vendorId = $userId - 10;

// Fixed query with proper JOINs
$sql = "SELECT 
            vr.vendor_review_id,
            vr.rating,
            vr.comment,
            vr.created_at,
            p.name as product_name,
            u.full_name as customer_name
        FROM vendor_reviews vr
        LEFT JOIN products p ON vr.product_id = p.product_id
        LEFT JOIN users u ON vr.user_id = u.user_id
        WHERE vr.vendor_id = ?
        ORDER BY vr.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $vendorId);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = [
        'vendor_review_id' => (int)$row['vendor_review_id'],
        'product_name' => $row['product_name'] ?: 'Product ID: ' . $row['product_id'],
        'customer_name' => $row['customer_name'] ?: 'User ID: ' . $row['user_id'],
        'rating' => (int)$row['rating'],
        'comment' => $row['comment'],
        'created_at' => $row['created_at']
    ];
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'data' => $reviews]);
?>