<?php
// get_recent_orders.php
session_start();
header('Content-Type: application/json');

require_once 'db_connect.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Vendor mapping
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
    $query = "SELECT 
                o.order_id,
                o.user_id,
                o.total_amount,
                o.status,
                o.created_at,
                u.full_name as customer_name
              FROM orders o
              INNER JOIN users u ON o.user_id = u.user_id
              ORDER BY o.created_at DESC
              LIMIT 5";
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        throw new Exception(mysqli_error($conn));
    }
    
    $orders = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $orderId = $row['order_id'];
        
        // Get vendor names for this order
        $vendorQuery = "SELECT DISTINCT oi.vendor_id 
                        FROM order_items oi 
                        WHERE oi.order_id = $orderId";
        
        $vendorResult = mysqli_query($conn, $vendorQuery);
        
        $vendorNames = [];
        if ($vendorResult && mysqli_num_rows($vendorResult) > 0) {
            while ($vendorRow = mysqli_fetch_assoc($vendorResult)) {
                $vendorId = $vendorRow['vendor_id'];
                if (isset($vendorMapping[$vendorId])) {
                    $vendorNames[] = $vendorMapping[$vendorId];
                }
            }
        }
        
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
    
} catch (Exception $e) {
    error_log("get_recent_orders.php error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Failed to load recent orders']);
}

mysqli_close($conn);
?>