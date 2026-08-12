<?php
// AdminOrderDetails.php
session_start();
require_once 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: AdminLogin.php');
    exit;
}

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

if ($order_id <= 0) {
    die("Invalid Order ID");
}

// Fetch order details with customer info (no user restriction for admin)
$query = "SELECT o.*, u.full_name as customer_name, u.email as customer_email, u.phone as customer_phone
          FROM orders o
          INNER JOIN users u ON o.user_id = u.user_id
          WHERE o.order_id = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);  // ← FIXED: Convert stmt to result
$order = mysqli_fetch_assoc($result);      // ← Now this works

if (!$order) {
    die("Order not found");
}

// Fetch order items with product images
$items_query = "SELECT oi.*, p.name as product_name, 
                (SELECT image_url FROM product_images WHERE product_id = p.product_id LIMIT 1) as product_image
                FROM order_items oi
                INNER JOIN products p ON oi.product_id = p.product_id
                WHERE oi.order_id = ?";
$items_stmt = mysqli_prepare($conn, $items_query);
mysqli_stmt_bind_param($items_stmt, "i", $order_id);
mysqli_stmt_execute($items_stmt);
$items_result = mysqli_stmt_get_result($items_stmt);
$items = [];
while ($item = mysqli_fetch_assoc($items_result)) {
    $items[] = $item;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order Details | Global Hardware Hub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; padding: 2rem; }
        .container { max-width: 1200px; margin: 0 auto; }
        .card { background: white; border-radius: 24px; padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card h2 { font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e2e8f0; display: flex; align-items: center; gap: 8px; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 40px; font-size: 0.7rem; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #b45309; }
        .status-processing { background: #c7d2fe; color: #3730a3; }
        .status-shipped { background: #dbeafe; color: #1d4ed8; }
        .status-delivered { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #dc2626; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        th { background: #f8fafc; font-weight: 600; color: #475569; }
        .product-cell { display: flex; align-items: center; gap: 12px; }
        .product-img { width: 50px; height: 50px; object-fit: cover; border-radius: 12px; background: #f1f5f9; border: 1px solid #e2e8f0; }
        .btn-back { background: #2563eb; color: white; border: none; padding: 0.5rem 1rem; border-radius: 40px; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-back:hover { background: #1d4ed8; transform: translateY(-1px); }
        .btn-print { background: #475569; }
        .btn-print:hover { background: #334155; }
        .info-row { display: flex; margin-bottom: 0.8rem; }
        .info-label { width: 120px; font-weight: 600; color: #475569; }
        .info-value { color: #1e293b; }
        .grand-total { font-size: 1.2rem; font-weight: 700; color: #2563eb; }
        .action-buttons { display: flex; gap: 1rem; margin-top: 1rem; flex-wrap: wrap; }
        @media (max-width: 768px) { body { padding: 1rem; } .info-label { width: 100px; } .product-cell { flex-direction: column; text-align: center; } }
    </style>
</head>
<body>
    <div class="container">
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <a href="AdminDashboard.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            <button class="btn-back btn-print" onclick="window.print()"><i class="fas fa-print"></i> Print Order</button>
        </div>

        <div class="card">
            <h2><i class="fas fa-receipt"></i> Order #<?php echo $order['order_id']; ?></h2>
            <div class="info-row"><div class="info-label">Order Date:</div><div class="info-value"><?php echo date('F j, Y, g:i a', strtotime($order['created_at'])); ?></div></div>
            <div class="info-row"><div class="info-label">Status:</div><div class="info-value">
                <span class="status-badge status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span>
            </div></div>
        </div>

        <div class="card">
            <h2><i class="fas fa-user"></i> Customer Information</h2>
            <div class="info-row"><div class="info-label">Full Name:</div><div class="info-value"><?php echo htmlspecialchars($order['customer_name']); ?></div></div>
            <div class="info-row"><div class="info-label">Email:</div><div class="info-value"><?php echo htmlspecialchars($order['customer_email']); ?></div></div>
            <div class="info-row"><div class="info-label">Phone:</div><div class="info-value"><?php echo htmlspecialchars($order['customer_phone'] ?? 'N/A'); ?></div></div>
        </div>

        <div class="card">
            <h2><i class="fas fa-box"></i> Order Items</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach($items as $item): 
                            $subtotal = $item['quantity'] * $item['price'];
                            $total += $subtotal;
                            $imageUrl = !empty($item['product_image']) ? htmlspecialchars($item['product_image']) : 'https://via.placeholder.com/50x50/2563eb/white?text=No+Image';
                        ?>
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <img class="product-img" src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" onerror="this.src='https://via.placeholder.com/50x50/ef4444/white?text=Error'">
                                    <span><?php echo htmlspecialchars($item['product_name']); ?></span>
                                </div>
                            </td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₹<?php echo number_format($item['price'], 2); ?></td>
                            <td>₹<?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right; font-weight:600;">Grand Total:</td>
                            <td class="grand-total">₹<?php echo number_format($total, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card">
            <h2><i class="fas fa-truck"></i> Shipping Information</h2>
            <?php
            // Fetch shipping address if exists
            $address_query = "SELECT * FROM user_addresses WHERE user_id = ? AND is_default = 1 LIMIT 1";
            $addr_stmt = mysqli_prepare($conn, $address_query);
            mysqli_stmt_bind_param($addr_stmt, "i", $order['user_id']);
            mysqli_stmt_execute($addr_stmt);
            $addr_result = mysqli_stmt_get_result($addr_stmt);
            $address = mysqli_fetch_assoc($addr_result);
            ?>
            <?php if($address): ?>
                <div class="info-row"><div class="info-label">Address:</div><div class="info-value"><?php echo htmlspecialchars($address['address_line1']); ?></div></div>
                <?php if($address['address_line2']): ?>
                <div class="info-row"><div class="info-label"></div><div class="info-value"><?php echo htmlspecialchars($address['address_line2']); ?></div></div>
                <?php endif; ?>
                <div class="info-row"><div class="info-label">City:</div><div class="info-value"><?php echo htmlspecialchars($address['city']); ?></div></div>
                <div class="info-row"><div class="info-label">Postal Code:</div><div class="info-value"><?php echo htmlspecialchars($address['postal_code']); ?></div></div>
                <div class="info-row"><div class="info-label">Country:</div><div class="info-value"><?php echo htmlspecialchars($address['country']); ?></div></div>
            <?php else: ?>
                <div class="info-value">No shipping address on file</div>
            <?php endif; ?>
        </div>

        <div class="action-buttons">
            <button class="btn-back" onclick="window.location.href='AdminDashboard.php'"><i class="fas fa-arrow-left"></i> Back to Dashboard</button>
            <button class="btn-back btn-print" onclick="window.print()"><i class="fas fa-print"></i> Print Order</button>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>