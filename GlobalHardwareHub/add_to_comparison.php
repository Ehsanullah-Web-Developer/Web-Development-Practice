<?php
// ==============================================
// File: add_to_comparison.php
// Description: API endpoint to add products to user's comparison list
// Returns: JSON response
// Usage: POST request with product_id
// ==============================================

// Start session to access user data
session_start();

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== CHECK IF USER IS LOGGED IN ==============
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Please login first to add products to comparison'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

// ============== CHECK REQUEST METHOD ==============
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. POST required.'
    ]);
    exit;
}

// ============== GET AND VALIDATE INPUT ==============
$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

// Validate product_id
if ($productId <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid product ID'
    ]);
    exit;
}

// ============== VERIFY PRODUCT EXISTS ==============
try {
    $checkProductStmt = $conn->prepare("SELECT product_id FROM products WHERE product_id = ?");
    $checkProductStmt->bind_param("i", $productId);
    $checkProductStmt->execute();
    $productResult = $checkProductStmt->get_result();
    
    if ($productResult->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Product not found'
        ]);
        $checkProductStmt->close();
        $conn->close();
        exit;
    }
    $checkProductStmt->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
    $conn->close();
    exit;
}

// ============== CHECK FOR DUPLICATE ==============
try {
    $checkStmt = $conn->prepare("SELECT comparison_id FROM product_comparisons WHERE user_id = ? AND product_id = ?");
    $checkStmt->bind_param("ii", $userId, $productId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Product already in comparison list'
        ]);
        $checkStmt->close();
        $conn->close();
        exit;
    }
    $checkStmt->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
    $conn->close();
    exit;
}

// ============== CHECK COMPARISON LIMIT (MAX 4 PRODUCTS) ==============
try {
    $limitStmt = $conn->prepare("SELECT COUNT(*) as count FROM product_comparisons WHERE user_id = ?");
    $limitStmt->bind_param("i", $userId);
    $limitStmt->execute();
    $limitResult = $limitStmt->get_result();
    $countData = $limitResult->fetch_assoc();
    $currentCount = $countData['count'];
    $limitStmt->close();
    
    // Set maximum comparison limit to 4 products
    $maxLimit = 4;
    
    if ($currentCount >= $maxLimit) {
        echo json_encode([
            'success' => false,
            'message' => "Comparison limit reached. Maximum $maxLimit products can be compared at once. Please remove an item before adding more."
        ]);
        $conn->close();
        exit;
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
    $conn->close();
    exit;
}

// ============== INSERT PRODUCT INTO COMPARISON ==============
try {
    // Prepare SQL query to insert into product_comparisons
    $sql = "INSERT INTO product_comparisons (user_id, product_id, created_at) VALUES (?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Database prepare error: " . $conn->error);
    }
    
    // Bind parameters (i = integer)
    $stmt->bind_param("ii", $userId, $productId);
    
    // Execute the query
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Product added to comparison list'
        ]);
    } else {
        throw new Exception("Failed to insert into comparison");
    }
    
    // Close statement
    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to add product to comparison. Please try again.'
    ]);
}

// Close database connection
$conn->close();
?>