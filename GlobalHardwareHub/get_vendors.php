<?php
// ==============================================
// File: get_vendors.php
// Description: API endpoint to fetch all vendors with product count
// Returns: JSON array of vendors
// ==============================================

// Include database connection
require_once 'db_connect.php';

// Set header to return JSON response
header('Content-Type: application/json');

// ============== FETCH VENDORS FROM DATABASE ==============
try {
    // Query with product count
    $sql = "SELECT 
                v.vendor_id, 
                v.store_name, 
                v.logo_url, 
                v.cover_image_url, 
                v.description, 
                v.rating,
                COUNT(vp.vp_id) AS total_products
            FROM vendors v
            LEFT JOIN vendor_products vp ON v.vendor_id = vp.vendor_id
            GROUP BY v.vendor_id
            ORDER BY v.rating DESC, v.vendor_id ASC";
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    $vendors = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $vendors[] = array(
                "vendor_id" => (int)$row['vendor_id'],
                "store_name" => $row['store_name'],
                "logo_url" => $row['logo_url'] ?? "default-vendor-logo.jpg",
                "cover_image_url" => $row['cover_image_url'] ?? "default-cover.jpg",
                "description" => $row['description'] ?? "",
                "rating" => $row['rating'] !== null ? (float)$row['rating'] : 0.0,
                "total_products" => (int)$row['total_products']
            );
        }
    }
    
    // Return vendors as JSON (direct array as your frontend expects)
    echo json_encode($vendors, JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    // Return error message
    echo json_encode(array(
        "error" => true,
        "message" => "Database error: " . $e->getMessage()
    ));
}

// Close database connection
$conn->close();
?>