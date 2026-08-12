<?php
// ==============================================
// SINGLE FILE: Cart.php
// Contains: PHP Backend (Session + Database Cart) + HTML + CSS + JavaScript
// ==============================================

session_start();
require_once 'db_connect.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;

// Handle AJAX requests for cart operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    header('Content-Type: application/json');
    
    // Check if user is logged in
    if (!$isLoggedIn) {
        echo json_encode(['success' => false, 'message' => 'Please login first']);
        exit;
    }
    
    $action = $_POST['action'] ?? '';
    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    switch ($action) {
        case 'add_to_cart':
            if ($productId > 0 && $quantity > 0) {
                // Check if item already exists in cart
                $stmt = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param("ii", $userId, $productId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    // Update existing item
                    $row = $result->fetch_assoc();
                    $newQuantity = $row['quantity'] + $quantity;
                    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                    $stmt->bind_param("iii", $newQuantity, $userId, $productId);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    // Insert new item
                    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    $stmt->bind_param("iii", $userId, $productId, $quantity);
                    $stmt->execute();
                    $stmt->close();
                }
                echo json_encode(['success' => true, 'message' => 'Product added to cart']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
            }
            break;
            
        case 'update_quantity':
            if ($productId > 0) {
                if ($quantity <= 0) {
                    // Remove item if quantity is 0 or less
                    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
                    $stmt->bind_param("ii", $userId, $productId);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    // Check if item exists
                    $stmt = $conn->prepare("SELECT cart_id FROM cart WHERE user_id = ? AND product_id = ?");
                    $stmt->bind_param("ii", $userId, $productId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        // Update existing item
                        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                        $stmt->bind_param("iii", $quantity, $userId, $productId);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
            }
            break;
            
        case 'remove_item':
            if ($productId > 0) {
                $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param("ii", $userId, $productId);
                $stmt->execute();
                $stmt->close();
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
            }
            break;
            
        case 'get_cart':
            // Return cart data as JSON with vendor_id from products table
            $cartItems = [];
            $sql = "SELECT p.product_id, p.name, p.regular_price as price, p.vendor_id, MIN(pi.image_url) as image, c.quantity 
                    FROM cart c 
                    JOIN products p ON c.product_id = p.product_id 
                    LEFT JOIN product_images pi ON p.product_id = pi.product_id 
                    WHERE c.user_id = ? 
                    GROUP BY p.product_id, p.name, p.regular_price, p.vendor_id, c.quantity
                    ORDER BY c.cart_id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $cartItems[] = [
                    'id' => $row['product_id'],
                    'name' => $row['name'],
                    'price' => (float)$row['price'],
                    'image' => $row['image'] ?? 'default-product.jpg',
                    'quantity' => (int)$row['quantity'],
                    'vendor_id' => (int)$row['vendor_id']
                ];
            }
            $stmt->close();
            
            echo json_encode(['success' => true, 'cart' => $cartItems]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    exit;
}

// Fetch cart items for initial display with vendor_id
$cartItems = [];
$subtotal = 0;

if ($isLoggedIn) {
    $sql = "SELECT p.product_id, p.name, p.regular_price as price, p.vendor_id, MIN(pi.image_url) as image, c.quantity 
            FROM cart c 
            JOIN products p ON c.product_id = p.product_id 
            LEFT JOIN product_images pi ON p.product_id = pi.product_id 
            WHERE c.user_id = ? 
            GROUP BY p.product_id, p.name, p.regular_price, p.vendor_id, c.quantity
            ORDER BY c.cart_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = [
            'id' => $row['product_id'],
            'name' => $row['name'],
            'price' => (float)$row['price'],
            'image' => $row['image'] ?? 'default-product.jpg',
            'quantity' => (int)$row['quantity'],
            'vendor_id' => (int)$row['vendor_id']
        ];
        $subtotal += (float)$row['price'] * (int)$row['quantity'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Shopping Cart</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #1e293b;
            scroll-behavior: smooth;
        }

        :root {
            --primary: #2563EB;
            --primary-dark: #1d4ed8;
            --primary-gradient: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            --secondary: #06B6D4;
            --secondary-gradient: linear-gradient(135deg, #06B6D4 0%, #0891b2 100%);
            --success: #10b981;
            --danger: #dc2626;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            --dark-nav: #0F172A;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Header - Dark Navy matching Logout.php */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #0F172A;
            backdrop-filter: blur(0);
            box-shadow: var(--shadow-lg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0.8rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo img {
            height: 52px;
            width: auto;
            transition: transform 0.2s ease;
        }
        .logo img:hover { transform: scale(1.02); }

        .nav-links {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            list-style: none;
            align-items: center;
            margin: 0;
            margin-left: auto;
        }

        .nav-item {
            position: relative;
            list-style: none;
        }

        /* White text on dark navbar */
        .nav-link {
            text-decoration: none;
            font-weight: 500;
            color: #FFFFFF;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 60px;
        }

        .nav-link i { color: #FFFFFF; }

        .nav-link:hover, .nav-link.active { background: rgba(255, 255, 255, 0.1); color: #FFFFFF; }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            min-width: 230px;
            padding: 0.6rem 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-12px);
            transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s;
            z-index: 1050;
            border: 1px solid var(--gray-200);
        }

        .nav-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            display: block;
            padding: 0.65rem 1.3rem;
            text-decoration: none;
            color: var(--gray-600);
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .dropdown-menu a:hover {
            background: var(--gray-100);
            color: var(--primary);
            padding-left: 1.6rem;
        }

        .auth-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 0.45rem 1.2rem;
            border-radius: 60px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            color: #FFFFFF;
        }

        .auth-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            color: #FFFFFF;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.4rem 1rem;
            border-radius: 60px;
            font-weight: 500;
        }
        .cart-icon i { font-size: 1.2rem; color: #FFFFFF; }
        .cart-icon:hover { background: var(--primary); color: white; transform: translateY(-2px); }
        .cart-icon:hover i { color: white; }

        .cart-count {
            background: var(--secondary);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 30px;
            margin-left: 4px;
        }

        .hamburger {
            display: none;
            font-size: 1.8rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #FFFFFF;
            transition: 0.2s;
        }
        .hamburger:hover { color: var(--secondary); }

        .mobile-menu-panel {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 340px;
            height: 100%;
            background: #FFFFFF;
            z-index: 2000;
            box-shadow: 2px 0 30px rgba(0, 0, 0, 0.15);
            transition: left 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            overflow-y: auto;
            padding: 1.5rem;
        }
        .mobile-menu-panel.open { left: 0; }
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(2px);
            z-index: 1999;
            display: none;
        }
        .mobile-overlay.show { display: block; }

        /* Footer - Dark Navy matching Logout.php */
        .footer {
            background: #0F172A;
            color: #CBD5E1;
            padding: 3rem 2rem 1.5rem;
            margin-top: 4rem;
        }
        .footer-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2.5rem;
        }
        .footer-col h4 {
            margin-bottom: 1.2rem;
            color: #FFFFFF;
            font-size: 1.1rem;
            font-weight: 600;
            position: relative;
            display: inline-block;
        }
        .footer-col h4:after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 35px;
            height: 2px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }
        .footer-col a {
            display: block;
            color: #CBD5E1;
            text-decoration: none;
            margin-bottom: 0.6rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .footer-col a:hover { color: #60A5FA; transform: translateX(4px); }
        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        .social-icons i {
            font-size: 1.4rem;
            cursor: pointer;
            color: #CBD5E1;
            transition: all 0.2s ease;
        }
        .social-icons i:hover { color: #60A5FA; transform: translateY(-3px); }
        .copyright {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: #CBD5E1;
        }

        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .breadcrumb {
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
        }
        .breadcrumb a {
            color: #FFFFFF;
            text-decoration: none;
        }
        .breadcrumb a:hover { text-decoration: underline; }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFFFFF 0%, #c7d2fe 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 2rem;
        }

        .cart-layout {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        .cart-items-section { flex: 2; min-width: 280px; }
        .summary-section { flex: 1; min-width: 280px; }

        .cart-table {
            background: #FFFFFF;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .cart-table:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }
        .cart-header {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 0.8fr;
            background: #F9FAFB;
            padding: 1rem 1.2rem;
            font-weight: 600;
            color: #6B7280;
            font-size: 0.85rem;
            border-bottom: 1px solid #E5E7EB;
        }
        .cart-item {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr 0.8fr;
            align-items: center;
            padding: 1.2rem;
            border-bottom: 1px solid #E5E7EB;
            transition: background 0.2s;
        }
        .cart-item:last-child { border-bottom: none; }
        .cart-item:hover { background: #F9FAFB; }

        .product-info {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 16px;
            background: #F3F4F6;
            transition: transform 0.2s;
        }
        .product-img:hover { transform: scale(1.05); }
        .product-details h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #111827;
        }
        .product-price {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .qty-btn {
            background: #F3F4F6;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.2s;
        }
        .qty-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        .qty-input {
            width: 55px;
            text-align: center;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 0.4rem;
            font-weight: 500;
        }

        .item-total {
            font-weight: 700;
            color: #111827;
            font-size: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.8rem;
        }
        .btn-icon {
            background: #F3F4F6;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.2s;
        }
        .btn-icon:hover {
            background: var(--danger);
            color: white;
            transform: scale(1.05);
        }

        .summary-card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }
        .summary-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid #E5E7EB;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            font-size: 0.9rem;
            color: #6B7280;
        }
        .grand-total {
            font-weight: 800;
            font-size: 1.1rem;
            border-top: 2px solid #E5E7EB;
            margin-top: 0.5rem;
            padding-top: 0.8rem;
            color: #111827;
        }

        .promo-group {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .promo-group input {
            flex: 1;
            padding: 0.7rem 1rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 60px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .promo-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.85rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            width: 100%;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }
        .btn-secondary {
            background: #F3F4F6;
            color: #374151;
            border: none;
            padding: 0.7rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-secondary:hover {
            background: #E5E7EB;
            transform: translateY(-2px);
        }

        .continue-shopping {
            text-align: center;
            margin-top: 1.5rem;
        }
        .continue-shopping a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s;
        }
        .continue-shopping a:hover { gap: 10px; }

        .empty-cart {
            text-align: center;
            padding: 3rem;
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
        .empty-cart h3 {
            margin: 1rem 0 0.5rem;
            color: #111827;
        }

        .suggested-products {
            margin-top: 2rem;
        }
        .suggested-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #FFFFFF;
        }
        .suggested-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
        }
        .suggested-card {
            background: #FFFFFF;
            border-radius: 20px;
            padding: 1rem;
            text-align: center;
            transition: all 0.2s;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }
        .suggested-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }
        .suggested-card img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 14px;
        }
        .suggested-card h4 {
            font-size: 0.85rem;
            margin: 0.5rem 0;
            color: #111827;
        }

        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 60px;
            padding: 0.7rem 1.3rem;
            cursor: pointer;
            opacity: 0;
            transition: all 0.2s;
            z-index: 99;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: var(--shadow-md);
        }
        .back-to-top.show { opacity: 1; }
        .back-to-top:hover { transform: translateY(-3px); box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4); }

        @media (max-width: 800px) {
            .nav-links { display: none; }
            .hamburger { display: block; }
            .nav-container { padding: 0.8rem 1.2rem; }
        }
        @media (max-width: 768px) {
            .cart-header { display: none; }
            .cart-item {
                grid-template-columns: 1fr;
                gap: 1rem;
                text-align: center;
            }
            .product-info { flex-direction: column; text-align: center; }
            .quantity-selector { justify-content: center; }
            .action-buttons { justify-content: center; }
            .page-title { font-size: 1.8rem; }
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <img src="Logo.jpg" alt="Global Hardware Hub Logo">
            </div>
            
            <ul class="nav-links" id="desktopNav">
                <li class="nav-item"><a href="FYPHome.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
                <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
                <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span id="cartCountDisplay" class="cart-count">0</span></li>
                <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i class="fas fa-key"></i> <?php echo $isLoggedIn ? 'Logout' : 'Login'; ?></button></li>
            </ul>
            
            <button class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <button class="close-mobile" id="closeMobileBtn" style="background:none; border:none; font-size:1.8rem; float:right;"><i class="fas fa-times"></i></button>
        <div id="mobileMenuContent"></div>
    </div>

    <div class="cart-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Shopping Cart</span>
        </div>
        <h1 class="page-title"><i class="fas fa-shopping-cart"></i> Shopping Cart</h1>

        <div id="cartContent"></div>
    </div>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Quick Links 1</h4>
                <a href="AboutUs.php">About Us</a>
                <a href="ContactUs.php">Contact Support</a>
                <a href="OrderTracking.php">Track Order</a>
                <a href="ReturnPolicy.php">Return Policy</a>
            </div>
            <div class="footer-col">
                <h4>Quick Links 2</h4>
                <a href="Landing.php">Landing</a>
                <a href="Blog.php">Tech Blog</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="SupportTicket.php">Support Tickets</a>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p><i class="fas fa-phone-alt"></i> 03267322096</p>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
                <div class="social-icons"><i class="fab fa-facebook-f"></i><i class="fab fa-twitter"></i><i class="fab fa-instagram"></i><i class="fab fa-youtube"></i></div>
            </div>
            <div class="footer-col">
                <h4>Motto</h4>
                <p>⚡ Power Your Passion, Build Without Limits.</p>
                <p>© 2026 Global Hardware Hub</p>
            </div>
        </div>
        <div class="copyright">Global Hardware Hub | The Ultimate Computer Hardware Marketplace</div>
    </footer>

    <button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i> Top</button>

    <script>
        // ============== SESSION CHECK FROM API ==============
        let isUserLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
        let isCustomerRole = false;
        let currentUserId = <?php echo json_encode($userId); ?>;

        // Function to check session and user role using your check_session.php API
        async function checkUserSession() {
            try {
                const response = await fetch('check_session.php');
                const data = await response.json();
                
                if (data && data.user_id) {
                    isUserLoggedIn = true;
                    currentUserId = data.user_id;
                    isCustomerRole = (data.user_role === 'customer');
                    console.log('User logged in:', data.user_id, 'Role:', data.user_role);
                    return true;
                } else {
                    isUserLoggedIn = false;
                    isCustomerRole = false;
                    currentUserId = null;
                    console.log('No user logged in');
                    return false;
                }
            } catch (error) {
                console.error('Session check error:', error);
                isUserLoggedIn = false;
                isCustomerRole = false;
                return false;
            }
        }

        // Function to load cart count from API
        async function loadCartCountFromAPI() {
            const cartCountSpan = document.getElementById("cartCountDisplay");
            if (!cartCountSpan) return;
            
            const sessionValid = await checkUserSession();
            
            if (sessionValid && isCustomerRole) {
                try {
                    const response = await fetch('get_cart_count.php');
                    const data = await response.json();
                    
                    if (data.success) {
                        cartCountSpan.innerText = data.cart_count;
                        console.log('Cart count loaded:', data.cart_count);
                        return data.cart_count;
                    } else {
                        cartCountSpan.innerText = "0";
                        return 0;
                    }
                } catch (error) {
                    console.error('Error loading cart count:', error);
                    cartCountSpan.innerText = "0";
                    return 0;
                }
            } else {
                cartCountSpan.innerText = "0";
                return 0;
            }
        }

        // ============== PHP SESSION DATA ==============
        const initialCartItems = <?php echo json_encode($cartItems); ?>;
        
        // ============== GLOBAL VARIABLES ==============
        let cart = [];
        let promoApplied = false;
        let discountPercent = 0;
        let shippingCost = 0;
        
        const sampleProducts = [
            { id: 1, name: "Intel Core i9-14900K", price: 589.99, image: "intelcorei9-14900k.jpg" },
            { id: 2, name: "NVIDIA RTX 4070 Ti", price: 659.99, image: "nvidia4070ti.jpg" },
            { id: 3, name: "Samsung 990 Pro 2TB", price: 169.99, image: "samsung990pro.jpg" }
        ];
        
        // ============== LOGIN / LOGOUT ==============
        function setAuthUI() {
            const authBtn = document.getElementById("authButton");
            if (!authBtn) return;
            if (isUserLoggedIn) {
                authBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
            } else {
                authBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login';
            }
            renderMobileMenu();
        }
        
        function handleAuthClick() {
            if (isUserLoggedIn) {
                window.location.href = "Logout.php";
            } else {
                window.location.href = "LogIn.php";
            }
        }
        
        document.getElementById("authButton")?.addEventListener("click", handleAuthClick);
        
        // ============== MOBILE MENU ==============
        function renderMobileMenu() {
            const container = document.getElementById("mobileMenuContent");
            if (!container) return;
            const logged = isUserLoggedIn;
            const menuItems = [
                { title: "Home", link: "FYPHome.php" },
                { title: "Products", submenu: ["Categories", "Compare Products", "Product Details", "All Products"], links: ["Categories.php", "CompareProducts.php", "ProductDetails.php", "Products1.php"] },
                { title: "Vendors", submenu: ["Vendors List","Vendors Store","Vendors Setting","Vendors Dashboard","Vendors Products","Vendors Add Products","Vendors Edit Products","Vendors Reviews","Vendors Orders","Vendor Order Details"], links: ["Vendors.php","VendorsStore.php","VendorsSetting.php","VendorsDashboard.php","VendorsProducts.php","VendorsAddProducts.php","VendorsEditProducts.php","VendorsReviews.php","VendorsOrders.php","VendorOrderDetails.php"] },
                { title: "Account", submenu: ["My Account","Profile","Orders","Order Details","Wishlist","Address Book","Payment Methods","Cart","Checkout","Checkout Shipping","Checkout Payment"], links: ["MyAccount.php","Profile.php","UserOrders.php","UserOrderDetails.php","Wishlist.php","AddressBook.php","PaymentMethods.php","Cart.php","Checkout.php","CheckoutShipping.php","CheckoutPayment.php"] },
                { title: "Support", submenu: ["Contact","FAQ","Shipping Info","Warranty Info","Return Policy","Privacy Policy","Terms of Service","About Us","Cookie Policy"], links: ["ContactUs.php","FAQ.php","ShippingInfo.php","WarrantyInfo.php","ReturnPolicy.php","PrivacyPolicy.php","TermsofService.php","AboutUs.php","CookiePolicy.php"] },
                { title: "Blog", link: "Blog.php" },
                { title: "Blog Details", link: "BlogDetails.php" }
            ];
            let html = `<div style="margin-top:2rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%;">${logged ? "<i class='fas fa-sign-out-alt'></i> Logout" : "<i class='fas fa-sign-in-alt'></i> Login"}</button></div><hr style="margin:1rem 0;">`;
            menuItems.forEach(item => {
                if (item.submenu) {
                    html += `<div class="mobile-nav-item"><div class="mobile-nav-header" data-toggle="${item.title}" style="display:flex; justify-content:space-between; padding:0.8rem 0;"><span>${item.title}</span> <i class="fas fa-chevron-down"></i></div><div class="mobile-submenu" id="submenu-${item.title}" style="padding-left:1rem; display:none;">`;
                    item.submenu.forEach((sub, idx) => { html += `<a href="${item.links[idx]}">${sub}</a>`; });
                    html += `</div></div>`;
                } else {
                    html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0;">${item.title}</a></div>`;
                }
            });
            container.innerHTML = html;
            document.querySelectorAll(".mobile-nav-header").forEach(header => {
                header.addEventListener("click", () => {
                    const key = header.getAttribute("data-toggle");
                    const sub = document.getElementById(`submenu-${key}`);
                    if (sub) sub.style.display = sub.style.display === "none" ? "block" : "none";
                });
            });
            const mobileAuth = document.getElementById("mobileAuthBtn");
            if (mobileAuth) mobileAuth.onclick = () => { handleAuthClick(); renderMobileMenu(); };
        }
        
        const hamburger = document.getElementById("hamburgerBtn");
        const mobilePanel = document.getElementById("mobileMenuPanel");
        const overlay = document.getElementById("mobileOverlay");
        function openMobile() { mobilePanel.classList.add("open"); overlay.classList.add("show"); }
        function closeMobile() { mobilePanel.classList.remove("open"); overlay.classList.remove("show"); }
        hamburger?.addEventListener("click", openMobile);
        document.getElementById("closeMobileBtn")?.addEventListener("click", closeMobile);
        overlay?.addEventListener("click", closeMobile);
        
        // ============== BACKEND CART API ==============
        async function addToCartBackend(productId, quantity = 1) {
            if (!isUserLoggedIn) {
                alert("Please login first to add items to cart");
                window.location.href = "LogIn.php";
                return false;
            }
            const formData = new FormData();
            formData.append('action', 'add_to_cart');
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            try {
                const response = await fetch(window.location.href, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const result = await response.json();
                return result.success;
            } catch (error) { console.error('Error:', error); return false; }
        }
        
        async function updateCartQuantity(productId, quantity) {
            if (!isUserLoggedIn) return false;
            const formData = new FormData();
            formData.append('action', 'update_quantity');
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            try {
                const response = await fetch(window.location.href, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const result = await response.json();
                return result.success;
            } catch (error) { console.error('Error:', error); return false; }
        }
        
        async function removeCartItem(productId) {
            if (!isUserLoggedIn) return false;
            const formData = new FormData();
            formData.append('action', 'remove_item');
            formData.append('product_id', productId);
            try {
                const response = await fetch(window.location.href, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const result = await response.json();
                return result.success;
            } catch (error) { console.error('Error:', error); return false; }
        }
        
        async function loadCartFromBackend() {
            if (!isUserLoggedIn) { cart = []; return; }
            const formData = new FormData();
            formData.append('action', 'get_cart');
            try {
                const response = await fetch(window.location.href, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const result = await response.json();
                if (result.success) {
                    cart = result.cart;
                    console.log('Cart loaded with vendor_ids:', cart);
                } else {
                    cart = [];
                }
            } catch (error) { cart = []; }
        }
        
        // ============== CART CALCULATION ==============
        function calculateSubtotal() { return cart.reduce((sum, item) => sum + (item.price * (item.quantity || 1)), 0); }
        function calculateDiscount(subtotal) { return promoApplied ? subtotal * (discountPercent / 100) : 0; }
        function calculateTax(subtotal) { return subtotal * 0.09; }
        function calculateGrandTotal() { const subtotal = calculateSubtotal(); const discount = calculateDiscount(subtotal); const tax = calculateTax(subtotal - discount); return subtotal - discount + tax + shippingCost; }
        
        function updateTotals() {
            const subtotal = calculateSubtotal();
            const discount = calculateDiscount(subtotal);
            const tax = calculateTax(subtotal - discount);
            const grandTotal = calculateGrandTotal();
            const subtotalEl = document.getElementById("cartSubtotal");
            const discountEl = document.getElementById("cartDiscount");
            const taxEl = document.getElementById("cartTax");
            const shippingEl = document.getElementById("cartShipping");
            const grandTotalEl = document.getElementById("cartGrandTotal");
            if (subtotalEl) subtotalEl.innerText = `PKR ${subtotal.toFixed(2)}`;
            if (discountEl && promoApplied) discountEl.innerText = `-PKR ${discount.toFixed(2)}`;
            if (taxEl) taxEl.innerText = `PKR ${tax.toFixed(2)}`;
            if (shippingEl) shippingEl.innerText = `PKR ${shippingCost.toFixed(2)}`;
            if (grandTotalEl) grandTotalEl.innerText = `PKR ${grandTotal.toFixed(2)}`;
            updateCartCount();
        }
        
        async function updateCartCount() {
            await loadCartCountFromAPI();
        }
        
        // ============== RENDER CART ==============
        async function renderCart() {
            const container = document.getElementById("cartContent");
            await loadCartFromBackend();
            
            if (!isUserLoggedIn) {
                container.innerHTML = `<div class="empty-cart"><div style="font-size: 3rem;"><i class="fas fa-lock"></i></div><h3>Please Login to View Your Cart</h3><p>You need to be logged in to access your shopping cart.</p><a href="LogIn.php"><button class="btn-primary" style="width: auto; padding: 0.7rem 2rem;"><i class="fas fa-sign-in-alt"></i> Login Now</button></a></div>`;
                return;
            }
            
            if (cart.length === 0) {
                container.innerHTML = `<div class="empty-cart"><div style="font-size: 3rem;"><i class="fas fa-shopping-cart"></i></div><h3>Your cart is empty</h3><p>Looks like you haven't added any items yet.</p><a href="Products1.php"><button class="btn-primary" style="width: auto; padding: 0.7rem 2rem;"><i class="fas fa-store"></i> Continue Shopping</button></a></div><div class="suggested-products"><h3 class="suggested-title"><i class="fas fa-star"></i> You May Also Like</h3><div class="suggested-grid" id="suggestedGrid"></div></div>`;
                renderSuggested();
                return;
            }
        
            const itemsHtml = cart.map((item, index) => `<div class="cart-item" data-product-id="${item.id}" data-index="${index}"><div class="product-info"><img class="product-img" src="${item.image}" alt="${escapeHtml(item.name)}" onerror="this.src='https://placehold.co/80x80/2563eb/white?text=Product'"><div class="product-details"><h4>${escapeHtml(item.name)}</h4><div class="product-price">PKR ${(item.price || 0).toFixed(2)}</div></div></div><div class="quantity-selector"><button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">-</button><input type="text" class="qty-input" value="${item.quantity || 1}" readonly><button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button></div><div class="item-total">PKR ${((item.price || 0) * (item.quantity || 1)).toFixed(2)}</div><div class="action-buttons"><button class="btn-icon" onclick="saveForLater(${item.id})" title="Save for later"><i class="fas fa-bookmark"></i></button><button class="btn-icon" onclick="removeItem(${item.id})" title="Remove"><i class="fas fa-trash-alt"></i></button></div></div>`).join('');
        
            container.innerHTML = `<div class="cart-layout"><div class="cart-items-section"><div class="cart-table"><div class="cart-header"><div>Product</div><div>Quantity</div><div>Total</div><div>Actions</div></div>${itemsHtml}</div><div class="continue-shopping"><a href="Products1.php"><i class="fas fa-arrow-left"></i> Continue Shopping</a></div></div><div class="summary-section"><div class="summary-card"><h3><i class="fas fa-receipt"></i> Price Summary</h3><div class="summary-row"><span>Subtotal</span><span id="cartSubtotal">PKR 0.00</span></div><div class="summary-row"><span>Shipping</span><span id="cartShipping">PKR 0.00</span></div><div class="summary-row"><span>Tax (9%)</span><span id="cartTax">PKR 0.00</span></div><div class="summary-row" id="discountRow" style="display:none;"><span>Discount</span><span id="cartDiscount">-PKR 0.00</span></div><div class="summary-row grand-total"><span>Grand Total</span><span id="cartGrandTotal">PKR 0.00</span></div></div><div class="summary-card"><h3><i class="fas fa-ticket-alt"></i> Promo Code</h3><div class="promo-group"><input type="text" id="promoInput" placeholder="Enter code (SAVE10)"><button class="btn-secondary" id="applyPromoBtn" style="width: auto; padding: 0.6rem 1rem;">Apply</button></div><div id="promoMessage" style="font-size:0.7rem; color:#10b981;"></div></div><button id="checkoutBtn" class="btn-primary"><i class="fas fa-credit-card"></i> Proceed to Checkout →</button></div></div>`;
        
            updateTotals();
            document.getElementById("applyPromoBtn")?.addEventListener("click", applyPromo);
            document.getElementById("checkoutBtn")?.addEventListener("click", () => { if (cart.length === 0) alert("Your cart is empty"); else window.location.href = "Checkout.php"; });
            if (promoApplied) { const discountRow = document.getElementById("discountRow"); const promoInput = document.getElementById("promoInput"); if (discountRow) discountRow.style.display = "flex"; if (promoInput) promoInput.disabled = true; }
        }
        
        window.updateQuantity = async function(productId, delta) {
            const itemIndex = cart.findIndex(item => item.id === productId);
            if (itemIndex === -1) return;
            const currentQty = cart[itemIndex].quantity || 1;
            const newQty = currentQty + delta;
            if (newQty < 1) {
                if (await removeCartItem(productId)) { cart.splice(itemIndex, 1); renderCart(); }
            } else {
                if (await updateCartQuantity(productId, newQty)) { cart[itemIndex].quantity = newQty; renderCart(); }
            }
        };
        
        window.removeItem = async function(productId) {
            const item = cart.find(item => item.id === productId);
            if (item && confirm(`Remove "${item.name}" from cart?`)) {
                if (await removeCartItem(productId)) { cart = cart.filter(item => item.id !== productId); renderCart(); }
            }
        };
        
        window.saveForLater = function(productId) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                const savedKey = `saved_items`;
                let savedItems = JSON.parse(localStorage.getItem(savedKey)) || [];
                savedItems.push(item);
                localStorage.setItem(savedKey, JSON.stringify(savedItems));
                removeItem(productId);
                alert(`"${item.name}" saved for later`);
            }
        };
        
        function renderSuggested() {
            const grid = document.getElementById("suggestedGrid");
            if (!grid) return;
            grid.innerHTML = sampleProducts.map(p => `<div class="suggested-card"><img src="${p.image}" alt="${p.name}" onerror="this.src='https://placehold.co/180x100/2563eb/white?text=Product'"><h4>${escapeHtml(p.name)}</h4><div>PKR ${p.price.toFixed(2)}</div><button class="btn-secondary" style="margin-top:0.5rem;" onclick="addToCartFromSuggest(${p.id})"><i class="fas fa-cart-plus"></i> Add to Cart</button></div>`).join('');
        }
        
        window.addToCartFromSuggest = async function(productId) {
            if (!isUserLoggedIn) { alert("Please login first to add items to cart"); window.location.href = "LogIn.php"; return; }
            const product = sampleProducts.find(p => p.id === productId);
            if (product) {
                if (await addToCartBackend(product.id, 1)) { await loadCartFromBackend(); renderCart(); alert(`${product.name} added to cart!`); }
                else alert("Failed to add item to cart");
            }
        };
        
        function applyPromo() {
            const code = document.getElementById("promoInput").value.trim().toUpperCase();
            if (code === "SAVE10" && !promoApplied) {
                promoApplied = true; discountPercent = 10;
                document.getElementById("promoMessage").innerHTML = "✅ Promo code applied! 10% discount";
                document.getElementById("discountRow").style.display = "flex";
                document.getElementById("promoInput").disabled = true;
                updateTotals();
            } else if (promoApplied) document.getElementById("promoMessage").innerHTML = "❌ Promo already applied";
            else document.getElementById("promoMessage").innerHTML = "❌ Invalid promo code";
        }
        
        function escapeHtml(str) { if (!str) return ''; return str.replace(/[&<>]/g, m => m==='&'?'&amp;':m==='<'?'&lt;':'&gt;'); }
        
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => backBtn.classList.toggle("show", window.scrollY > 300));
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
        
        document.querySelector('.cart-icon')?.addEventListener('click', () => { window.location.href = "Cart.php"; });
        
        // ============== INITIALIZE ==============
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await loadCartCountFromAPI();
            await renderCart();
        }
        
        init();
        
        window.addToCartFromSuggest = addToCartFromSuggest;
        window.updateQuantity = updateQuantity;
        window.removeItem = removeItem;
        window.saveForLater = saveForLater;
    </script>
</body>
</html>