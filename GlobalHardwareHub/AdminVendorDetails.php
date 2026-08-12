<?php
// AdminVendorDetails.php
session_start();
require_once 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: AdminLogin.php');
    exit;
}

$vendor_id = isset($_GET['vendor_id']) ? (int)$_GET['vendor_id'] : 0;

if ($vendor_id <= 0) {
    die("Invalid Vendor ID");
}

// Fetch vendor details
$vendor_query = "SELECT v.*, u.email, u.full_name as owner_name 
                 FROM vendors v
                 LEFT JOIN users u ON v.user_id = u.user_id
                 WHERE v.vendor_id = ?";
$stmt = mysqli_prepare($conn, $vendor_query);
mysqli_stmt_bind_param($stmt, "i", $vendor_id);
mysqli_stmt_execute($stmt);
$vendor_result = mysqli_stmt_get_result($stmt);
$vendor = mysqli_fetch_assoc($vendor_result);

if (!$vendor) {
    die("Vendor not found");
}

// Fetch vendor products
$products_query = "SELECT p.*, 
                   (SELECT image_url FROM product_images WHERE product_id = p.product_id LIMIT 1) as product_image
                   FROM products p
                   WHERE p.vendor_id = ?
                   ORDER BY p.created_at DESC";
$stmt = mysqli_prepare($conn, $products_query);
mysqli_stmt_bind_param($stmt, "i", $vendor_id);
mysqli_stmt_execute($stmt);
$products_result = mysqli_stmt_get_result($stmt);
$products = [];
while ($product = mysqli_fetch_assoc($products_result)) {
    $products[] = $product;
}
$total_products = count($products);

// Fetch vendor orders (orders containing this vendor's products)
$orders_query = "SELECT DISTINCT o.order_id, o.total_amount, o.status, o.created_at, u.full_name as customer_name
                 FROM orders o
                 INNER JOIN order_items oi ON o.order_id = oi.order_id
                 INNER JOIN users u ON o.user_id = u.user_id
                 WHERE oi.vendor_id = ?
                 ORDER BY o.created_at DESC";
$stmt = mysqli_prepare($conn, $orders_query);
mysqli_stmt_bind_param($stmt, "i", $vendor_id);
mysqli_stmt_execute($stmt);
$orders_result = mysqli_stmt_get_result($stmt);
$orders = [];
while ($order = mysqli_fetch_assoc($orders_result)) {
    $orders[] = $order;
}
$total_orders = count($orders);

// Fetch vendor reviews
$reviews_query = "SELECT vr.*, u.full_name as user_name, p.name as product_name
                  FROM vendor_reviews vr
                  LEFT JOIN users u ON vr.user_id = u.user_id
                  LEFT JOIN products p ON vr.product_id = p.product_id
                  WHERE vr.vendor_id = ?
                  ORDER BY vr.created_at DESC";
$stmt = mysqli_prepare($conn, $reviews_query);
mysqli_stmt_bind_param($stmt, "i", $vendor_id);
mysqli_stmt_execute($stmt);
$reviews_result = mysqli_stmt_get_result($stmt);
$reviews = [];
while ($review = mysqli_fetch_assoc($reviews_result)) {
    $reviews[] = $review;
}
$avg_rating = 0;
if (count($reviews) > 0) {
    $rating_sum = array_sum(array_column($reviews, 'rating'));
    $avg_rating = round($rating_sum / count($reviews), 1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Vendor Details | Global Hardware Hub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; padding: 2rem; }
        .container { max-width: 1400px; margin: 0 auto; }
        .card { background: white; border-radius: 24px; padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card h2 { font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e2e8f0; display: flex; align-items: center; gap: 8px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: white; border-radius: 20px; padding: 1rem; text-align: center; }
        .stat-number { font-size: 2rem; font-weight: 700; }
        .stat-label { font-size: 0.8rem; opacity: 0.9; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 40px; font-size: 0.7rem; font-weight: 600; }
        .status-active { background: #d1fae5; color: #065f46; }
        .status-inactive { background: #fee2e2; color: #dc2626; }
        .status-pending { background: #fef3c7; color: #b45309; }
        .status-delivered { background: #d1fae5; color: #065f46; }
        .status-shipped { background: #dbeafe; color: #1d4ed8; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
        th { background: #f8fafc; font-weight: 600; color: #475569; }
        .product-img { width: 40px; height: 40px; object-fit: cover; border-radius: 8px; }
        .btn-back { background: #2563eb; color: white; border: none; padding: 0.5rem 1rem; border-radius: 40px; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-back:hover { background: #1d4ed8; transform: translateY(-1px); }
        .stars { color: #fbbf24; letter-spacing: 2px; }
        .section-title { font-size: 1rem; font-weight: 600; margin: 1rem 0 0.5rem; color: #1e293b; }
        .info-row { display: flex; margin-bottom: 0.8rem; }
        .info-label { width: 120px; font-weight: 600; color: #475569; }
        .info-value { color: #1e293b; }
        @media (max-width: 768px) { body { padding: 1rem; } .table-responsive { overflow-x: auto; } }
    </style>
</head>
<body>
    <div class="container">
        <div style="margin-bottom: 1.5rem;">
            <a href="AdminDashboard.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>

        <!-- Vendor Info Card -->
        <div class="card">
            <h2><i class="fas fa-store"></i> Vendor Information</h2>
            <div class="info-row"><div class="info-label">Vendor Name:</div><div class="info-value"><?php echo htmlspecialchars($vendor['store_name']); ?></div></div>
            <div class="info-row"><div class="info-label">Owner Name:</div><div class="info-value"><?php echo htmlspecialchars($vendor['owner_name'] ?? 'N/A'); ?></div></div>
            <div class="info-row"><div class="info-label">Email:</div><div class="info-value"><?php echo htmlspecialchars($vendor['email']); ?></div></div>
            <div class="info-row"><div class="info-label">Phone:</div><div class="info-value"><?php echo htmlspecialchars($vendor['phone'] ?? 'N/A'); ?></div></div>
            <div class="info-row"><div class="info-label">Status:</div><div class="info-value"><span class="status-badge status-active">Active</span></div></div>
            <div class="info-row"><div class="info-label">Rating:</div><div class="info-value"><?php echo $avg_rating; ?> / 5 <?php echo renderStars($avg_rating); ?></div></div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card"><div class="stat-number"><?php echo $total_products; ?></div><div class="stat-label">Total Products</div></div>
            <div class="stat-card"><div class="stat-number"><?php echo $total_orders; ?></div><div class="stat-label">Total Orders</div></div>
            <div class="stat-card"><div class="stat-number"><?php echo count($reviews); ?></div><div class="stat-label">Total Reviews</div></div>
            <div class="stat-card"><div class="stat-number"><?php echo $avg_rating; ?></div><div class="stat-label">Avg Rating</div></div>
        </div>

        <!-- Products Section -->
        <div class="card">
            <h2><i class="fas fa-box"></i> Products (<?php echo $total_products; ?>)</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr><th>Image</th><th>Product Name</th><th>Price</th><th>Status</th><th>Stock</th></tr>
                    </thead>
                    <tbody>
                        <?php if (count($products) > 0): ?>
                            <?php foreach($products as $product): ?>
                            <tr>
                                <td><img class="product-img" src="<?php echo !empty($product['product_image']) ? htmlspecialchars($product['product_image']) : 'https://via.placeholder.com/40x40/2563eb/white?text=No+Img'; ?>" onerror="this.src='https://via.placeholder.com/40x40/ef4444/white?text=Error'"></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td>₹<?php echo number_format($product['regular_price'], 2); ?></td>
                                <td><span class="status-badge status-active"><?php echo $product['status']; ?></span></td>
                                <td><?php echo $product['stock_quantity'] ?? 'N/A'; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align:center;">No products found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Orders Section -->
        <div class="card">
            <h2><i class="fas fa-shopping-cart"></i> Orders (<?php echo $total_orders; ?>)</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr><th>Order ID</th><th>Customer</th><th>Date</th><th>Total</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php if (count($orders) > 0): ?>
                            <?php foreach($orders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['order_id']; ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                                <td><span class="status-badge status-<?php echo $order['status']; ?>"><?php echo ucfirst($order['status']); ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align:center;">No orders found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="card">
            <h2><i class="fas fa-star"></i> Customer Reviews (<?php echo count($reviews); ?>)</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr><th>Customer</th><th>Product</th><th>Rating</th><th>Review</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php if (count($reviews) > 0): ?>
                            <?php foreach($reviews as $review): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($review['user_name'] ?? 'Anonymous'); ?></td>
                                <td><?php echo htmlspecialchars($review['product_name'] ?? 'N/A'); ?></td>
                                <td><?php echo renderStars($review['rating']); ?> <?php echo $review['rating']; ?>/5</td>
                                <td><?php echo htmlspecialchars(substr($review['review_text'] ?? $review['comment'] ?? '', 0, 100)); ?></td>
                                <td><?php echo date('M d, Y', strtotime($review['created_at'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align:center;">No reviews found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function renderStars(rating) {
            const full = Math.floor(rating);
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += i <= full ? '★' : '☆';
            }
            return `<span class="stars">${stars}</span>`;
        }
    </script>
    <?php
    function renderStars($rating) {
        $full = floor($rating);
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $full ? '★' : '☆';
        }
        return '<span class="stars">' . $stars . '</span>';
    }
    ?>
</body>
</html>