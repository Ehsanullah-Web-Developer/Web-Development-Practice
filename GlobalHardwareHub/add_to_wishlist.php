<?php
session_start();

// Turn off error display for clean JSON
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';

$response = array();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $response['success'] = false;
    $response['message'] = 'Please login first';
    echo json_encode($response);
    exit;
}

// Check user role
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'customer') {
    $response['success'] = false;
    $response['message'] = 'Only customers can add to wishlist';
    echo json_encode($response);
    exit;
}

// Check if it's POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['success'] = false;
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

// Get product ID
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if ($product_id <= 0) {
    $response['success'] = false;
    $response['message'] = 'Invalid product ID';
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id'];

// Use the global $conn from db_connect.php
global $conn;

// Create wishlist table if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS wishlist (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_wishlist (user_id, product_id)
)";
$conn->query($createTable);

// Check if product already in wishlist
$check_sql = "SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $user_id, $product_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $response['success'] = false;
    $response['message'] = 'Product already in wishlist';
    echo json_encode($response);
    $check_stmt->close();
    exit;
}
$check_stmt->close();

// Insert into wishlist
$insert_sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("ii", $user_id, $product_id);

if ($insert_stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Added to wishlist successfully';
} else {
    $response['success'] = false;
    $response['message'] = 'Failed to add to wishlist';
}

echo json_encode($response);

$insert_stmt->close();
?>