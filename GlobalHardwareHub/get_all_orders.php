<?php
// get_all_orders.php - Improved version
session_start();
header('Content-Type: application/json');

require_once 'db_connect.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Same vendor mapping as working API
$vendorMapping = [
    1 => 'Saad Malik',
    2 => 'TechCore Admin',
    3 => 'NextGen Admin',
    4 => 'PrimeMotherboards Admin',
    5 => 'PeripheralWorld Admin',
    6 => 'NetlinkNetworking Admin',
    7 => 'UltraStorage Admin',
    8 => 'MobileFix Admin',
    9 => 'LaptopCare Admin'
];

try {
    $baseQuery = "SELECT 
                    o.order_id,
                    o.user_id,
                    o.total_amount,
                    o.status,
                    o.created_at,
                    u.full_name as customer_name
                  FROM orders o
                  INNER JOIN users u ON o.user_id = u.user_id
                  WHERE 1=1";
    
    $filters = [];
    $types = "";
    $params = [];
    
    if (isset($_GET['status']) && !empty($_GET['status'])) {
        $baseQuery .= " AND o.status = ?";
        $filters[] = $_GET['status'];
        $types .= "s";
    }
    
    if (isset($_GET['customer_name']) && !empty($_GET['customer_name'])) {
        $baseQuery .= " AND u.full_name LIKE ?";
        $filters[] = "%" . $_GET['customer_name'] . "%";
        $types .= "s";
    }
    
    $baseQuery .= " ORDER BY o.created_at DESC";
    
    $stmt = mysqli_prepare($conn, $baseQuery);
    
    if (!empty($filters)) {
        mysqli_stmt_bind_param($stmt, $types, ...$filters);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        throw new Exception(mysqli_error($conn));  // Fixed: Added error message
    }
    
    $orders = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $orderId = $row['order_id'];
        
        // Get distinct vendor IDs for this order
        $vendorQuery = "SELECT DISTINCT vendor_id FROM order_items WHERE order_id = ?";
        $vendorStmt = mysqli_prepare($conn, $vendorQuery);
        mysqli_stmt_bind_param($vendorStmt, "i", $orderId);
        mysqli_stmt_execute($vendorStmt);
        $vendorResult = mysqli_stmt_get_result($vendorStmt);
        
        $vendorNames = [];
        while ($vendorRow = mysqli_fetch_assoc($vendorResult)) {
            $vendorId = $vendorRow['vendor_id'];
            if (isset($vendorMapping[$vendorId])) {
                $vendorNames[] = $vendorMapping[$vendorId];
            }
        }
        mysqli_stmt_close($vendorStmt);
        
        $orders[] = [
            'order_id' => (int)$row['order_id'],
            'customer_name' => $row['customer_name'],
            'vendor_name' => !empty($vendorNames) ? implode(', ', $vendorNames) : 'N/A',
            'total_amount' => (float)$row['total_amount'],
            'status' => $row['status'],
            'created_at' => $row['created_at']
        ];
    }
    
    echo json_encode(['success' => true, 'orders' => $orders]);
    mysqli_stmt_close($stmt);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load orders: ' . $e->getMessage()
    ]);
}

mysqli_close($conn);
?>