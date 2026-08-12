<?php
// ==============================================
// File: get_user_addresses.php
// Description: API endpoint to fetch user-specific addresses
// Returns: JSON array of addresses for logged-in user
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
        'message' => 'Please login first'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

// ============== FETCH USER ADDRESSES FROM DATABASE ==============
try {
    // Prepare SQL query to fetch addresses for logged-in user
    // Order by is_default DESC (default address first), then by address_id DESC (newest first)
    $sql = "SELECT address_id, label, address_line1, address_line2, city, state, postal_code, country, is_default 
            FROM user_addresses 
            WHERE user_id = ? 
            ORDER BY is_default DESC, address_id DESC";
    
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Database prepare error: " . $conn->error);
    }
    
    // Bind user_id parameter
    $stmt->bind_param("i", $userId);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Build addresses array
    $addresses = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $addresses[] = array(
                "address_id" => (int)$row['address_id'],
                "label" => $row['label'],
                "address_line1" => $row['address_line1'],
                "address_line2" => $row['address_line2'] ?? "",
                "city" => $row['city'],
                "state" => $row['state'],
                "postal_code" => $row['postal_code'],
                "country" => $row['country'],
                "is_default" => (int)$row['is_default']
            );
        }
    }
    
    // Return success response with addresses
    echo json_encode([
        'success' => true,
        'data' => $addresses
    ]);
    
    // Close statement
    $stmt->close();
    
} catch (Exception $e) {
    // Return error message if something goes wrong
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
}

// Close database connection
$conn->close();
?>