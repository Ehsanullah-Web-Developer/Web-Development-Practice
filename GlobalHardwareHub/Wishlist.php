<?php
// ==============================================
// SINGLE FILE: Wishlist.php
// Contains: PHP Backend (Session + Database Wishlist) + HTML + CSS + JavaScript
// Frontend UI is 100% UNCHANGED (backend preserved)
// ==============================================

session_start();
require_once 'db_connect.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;
$userName = $isLoggedIn ? ($_SESSION['user_fullname'] ?? $_SESSION['user_email'] ?? 'User') : null;

// Handle AJAX requests for wishlist operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    header('Content-Type: application/json');

    // Check if user is logged in
    if (!$isLoggedIn) {
        echo json_encode(['success' => false, 'message' => 'Please login first']);
        exit;
    }

    $action = $_POST['action'] ?? '';
    $productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

    switch ($action) {
        case 'remove_item':
            if ($productId > 0) {
                $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
                $stmt->bind_param("ii", $userId, $productId);
                $stmt->execute();
                $stmt->close();
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
            }
            break;
        case 'add_to_wishlist':
            if ($productId > 0) {
                // Check if already exists
                $checkStmt = $conn->prepare("SELECT wishlist_id FROM wishlist WHERE user_id = ? AND product_id = ?");
                $checkStmt->bind_param("ii", $userId, $productId);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();

                if ($checkResult->num_rows > 0) {
                    echo json_encode(['success' => false, 'message' => 'Product already in wishlist']);
                } else {
                    $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
                    $stmt->bind_param("ii", $userId, $productId);
                    $stmt->execute();
                    $stmt->close();
                    echo json_encode(['success' => true, 'message' => 'Added to wishlist']);
                }
                $checkStmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
            }
            break;

        case 'add_all_to_cart':
            // Get all wishlist items and add to cart
            $stmt = $conn->prepare("SELECT product_id FROM wishlist WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $productId = $row['product_id'];
                // Check if item already exists in cart
                $checkStmt = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
                $checkStmt->bind_param("ii", $userId, $productId);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();

                if ($checkResult->num_rows > 0) {
                    // Update existing cart item
                    $cartItem = $checkResult->fetch_assoc();
                    $newQuantity = $cartItem['quantity'] + 1;
                    $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                    $updateStmt->bind_param("iii", $newQuantity, $userId, $productId);
                    $updateStmt->execute();
                    $updateStmt->close();
                } else {
                    // Insert new cart item
                    $insertStmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
                    $insertStmt->bind_param("ii", $userId, $productId);
                    $insertStmt->execute();
                    $insertStmt->close();
                }
                $checkStmt->close();
            }
            $stmt->close();
            echo json_encode(['success' => true, 'count' => $result->num_rows]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    exit;
}

// Fetch wishlist items for display
$wishlistItems = [];
if ($isLoggedIn) {
    $sql = "SELECT w.product_id, p.name, p.regular_price as price, MIN(pi.image_url) as image_url 
            FROM wishlist w 
            JOIN products p ON w.product_id = p.product_id 
            LEFT JOIN product_images pi ON p.product_id = pi.product_id 
            WHERE w.user_id = ? 
            GROUP BY w.product_id, p.name, p.regular_price
            ORDER BY w.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $wishlistItems[] = [
            'id' => $row['product_id'],
            'name' => $row['name'],
            'price' => (float) $row['price'],
            'image' => $row['image_url'] ?? 'default-product.jpg',
            'vendor' => 'Global Hardware Hub'
        ];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | My Wishlist</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
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
            /* G. Page Fade-In Animation */
            animation: pageFadeIn 0.5s ease-out;
        }

        @keyframes pageFadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Modern Color Scheme - Matching Logout.php */
        :root {
            --primary: #2563EB;
            --primary-dark: #1d4ed8;
            --primary-gradient: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            --secondary: #06B6D4;
            --secondary-gradient: linear-gradient(135deg, #06B6D4 0%, #0891b2 100%);
            --success: #10b981;
            --danger: #dc2626;
            --warning: #f59e0b;
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

        .logo img:hover {
            transform: scale(1.02);
        }

        /* White text on dark navbar */
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
            /* E. Navbar Underline - position relative for pseudo-element */
            position: relative;
        }

        .nav-link i {
            color: #FFFFFF;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
        }

        /* E. Animated Navbar Underline */
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--secondary);
            border-radius: 2px;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 70%;
        }

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
            border: 1px solid #E5E7EB;
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
            color: #6B7280;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .dropdown-menu a:hover {
            background: #F3F4F6;
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

        /* B. Button Hover Animation */
        .auth-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px) scale(1.02);
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

        .cart-icon i {
            font-size: 1.2rem;
            color: #FFFFFF;
        }

        .cart-icon:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .cart-icon:hover i {
            color: white;
        }

        .cart-count {
            background: var(--secondary);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 30px;
            margin-left: 4px;
            /* J. Cart Counter - transition for smooth updates */
            transition: transform 0.2s ease;
            display: inline-block;
        }

        /* J. Cart Counter Bounce Animation */
        @keyframes cartBounce {
            0% { transform: scale(1); }
            40% { transform: scale(1.35); }
            70% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }

        .cart-count-bounce {
            animation: cartBounce 0.35s ease-out;
        }

        .hamburger {
            display: none;
            font-size: 1.8rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #FFFFFF;
            transition: transform 0.2s ease;
        }

        .hamburger:hover {
            color: var(--secondary);
            transform: scale(1.05);
        }

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

        .mobile-menu-panel.open {
            left: 0;
        }

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

        .mobile-overlay.show {
            display: block;
        }

        .close-mobile {
            background: none;
            border: none;
            font-size: 1.8rem;
            float: right;
            cursor: pointer;
            color: #374151;
            transition: transform 0.2s ease;
        }

        .close-mobile:hover {
            transform: scale(1.1);
        }

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
            transition: all 0.2s ease;
        }

        .footer-col a:hover {
            color: #60A5FA;
            transform: translateX(4px);
        }

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

        .social-icons i:hover {
            color: #60A5FA;
            transform: translateY(-3px) scale(1.05);
        }

        .copyright {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: #CBD5E1;
        }

        /* Wishlist Container */
        .wishlist-container {
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

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFFFFF 0%, #c7d2fe 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1rem;
        }

        /* Wishlist Actions */
        .wishlist-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        /* B. Button Hover Animation */
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-secondary {
            background: #F3F4F6;
            color: #374151;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: #E5E7EB;
            transform: translateY(-2px) scale(1.02);
        }

        .share-btn {
            background: #F3F4F6;
            color: #374151;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }

        .share-btn:hover {
            background: #E5E7EB;
            transform: translateY(-2px) scale(1.02);
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.8rem;
            margin-bottom: 2rem;
        }

        /* A. Product Card Hover Animation */
        .product-card {
            background: #FFFFFF;
            border-radius: 28px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.25);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #F3F4F6;
            transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        /* D. Product Image Zoom Animation */
        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.2rem;
        }

        .product-name {
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.3rem;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0.3rem 0;
        }

        .vendor-name {
            font-size: 0.75rem;
            color: #6B7280;
            margin-bottom: 0.8rem;
        }

        .card-buttons {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        /* B. Button Hover Animation */
        .btn-cart {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 700;
            flex: 1;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-cart:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        .btn-remove {
            background: #FEE2E2;
            color: var(--danger);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 700;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-remove:hover {
            background: #FECACA;
            transform: translateY(-2px) scale(1.02);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .empty-state:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .empty-state h3 {
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #6B7280;
            margin-bottom: 1.5rem;
        }

        /* Recommended Section */
        .recommended-section {
            margin-top: 2rem;
        }

        .recommended-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .recommended-slider {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1rem;
        }

        /* A. Rec Card Hover Animation */
        .rec-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 1rem;
            border: 1px solid #E5E7EB;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .rec-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
            border-color: var(--primary);
        }

        .rec-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 16px;
            transition: transform 0.3s ease;
        }

        .rec-card:hover img {
            transform: scale(1.03);
        }

        .rec-card h4 {
            font-size: 0.9rem;
            font-weight: 600;
            margin: 0.8rem 0 0.3rem;
            color: #111827;
        }

        .rec-price {
            font-weight: 800;
            color: var(--primary);
            font-size: 1rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: #FFFFFF;
            max-width: 420px;
            width: 90%;
            border-radius: 32px;
            padding: 2rem;
            text-align: center;
            animation: modalFadeIn 0.3s ease;
            box-shadow: var(--shadow-xl);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .share-link {
            background: #F9FAFB;
            padding: 0.8rem;
            border-radius: 16px;
            margin: 1rem 0;
            word-break: break-all;
            color: #374151;
        }

        /* I. Skeleton Loader Animation */
        .skeleton-loader {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: shimmerPulse 1.5s infinite ease-in-out;
            border-radius: 28px;
        }

        @keyframes shimmerPulse {
            0% {
                background-position: 200% 0;
                opacity: 0.6;
            }
            50% {
                opacity: 1;
            }
            100% {
                background-position: -200% 0;
                opacity: 0.6;
            }
        }

        /* Back to Top */
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
            transition: all 0.2s ease;
            z-index: 99;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: var(--shadow-md);
        }

        .back-to-top.show {
            opacity: 1;
        }

        .back-to-top:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
            15% {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
            85% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
        }

        @media (max-width: 800px) {
            .nav-links {
                display: none;
            }

            .hamburger {
                display: block;
            }

            .nav-container {
                padding: 0.8rem 1.2rem;
            }
        }

        @media (max-width: 768px) {
            .wishlist-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.8rem;
            }
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
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
                <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span
                        id="cartCountDisplay" class="cart-count">0</span></li>
                <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i
                            class="fas fa-key"></i> <?php echo $isLoggedIn ? 'Logout' : 'Login'; ?></button></li>
            </ul>

            <button class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <button class="close-mobile" id="closeMobileBtn"
            style="background:none; border:none; font-size:1.8rem; float:right;"><i class="fas fa-times"></i></button>
        <div id="mobileMenuContent"></div>
    </div>

    <div class="wishlist-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="MyAccount.php">My Account</a> /
            <span>Wishlist</span>
        </div>
        <!-- H. Scroll Reveal - Page Title -->
        <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-heart" style="color: var(--danger);"></i> My Wishlist</h1>

        <div id="wishlistContainer" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="50"></div>
    </div>

    <!-- H. Scroll Reveal - Footer -->
    <footer class="footer" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50">
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
                <a href="Categories.php">Categories</a>
                <a href="CompareProducts.php">Compare Products</a>
                <a href="Vendors.php">Vendors</a>
                <a href="ShippingInfo.php">Shipping Info</a>
            </div>
            <div class="footer-col">
                <h4>Contact Info</h4>
                <p><i class="fas fa-phone-alt"></i> 03267322096</p>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
                <div class="social-icons">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-youtube"></i>
                    <i class="fab fa-linkedin-in"></i>
                </div>
            </div>
            <div class="footer-col">
                <h4>Our Motto</h4>
                <p>⚡ Power Your Passion, Build Without Limits.</p>
                <p style="margin-top: 1rem;">© 2026 Global Hardware Hub – All rights reserved.</p>
            </div>
        </div>
        <div class="copyright">
            <p>Global Hardware Hub | The Ultimate Computer Hardware Marketplace</p>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i> Top</button>

    <!-- Share Modal -->
    <div id="shareModal" class="modal">
        <div class="modal-content">
            <h3><i class="fas fa-share-alt"></i> Share Wishlist</h3>
            <p>Share this link with friends:</p>
            <div class="share-link" id="shareLink"></div>
            <button class="btn-primary" onclick="copyShareLink()"><i class="fas fa-copy"></i> Copy Link</button>
            <button class="btn-secondary" onclick="closeShareModal()" style="margin-top: 0.8rem;"><i
                    class="fas fa-times"></i> Close</button>
        </div>
    </div>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // H. Initialize AOS once globally
        AOS.init({
            duration: 600,
            once: true,
            offset: 80,
            disable: 'mobile'
        });

        // ========== CART COUNT FROM API ==========
        
        // Global session variables
        let isUserLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
        let isCustomerRole = false;
        let currentUserId = <?php echo json_encode($userId); ?>;

        // J. Cart Counter Animation Function
        function animateCartCounter() {
            const cartSpan = document.getElementById("cartCountDisplay");
            if (cartSpan) {
                cartSpan.classList.remove("cart-count-bounce");
                void cartSpan.offsetWidth;
                cartSpan.classList.add("cart-count-bounce");
                setTimeout(() => {
                    cartSpan.classList.remove("cart-count-bounce");
                }, 350);
            }
        }

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

        // Function to load cart count from API with animation trigger
        async function loadCartCountFromAPI() {
            const cartCountSpan = document.getElementById("cartCountDisplay");
            if (!cartCountSpan) return;
            
            const oldCount = parseInt(cartCountSpan.innerText) || 0;
            const sessionValid = await checkUserSession();
            
            if (sessionValid && isCustomerRole) {
                try {
                    const response = await fetch('get_cart_count.php');
                    const data = await response.json();
                    
                    if (data.success) {
                        const newCount = data.cart_count;
                        cartCountSpan.innerText = newCount;
                        // J. Trigger bounce animation if count changed
                        if (newCount !== oldCount) {
                            animateCartCounter();
                        }
                        console.log('Cart count loaded:', data.cart_count);
                    } else {
                        cartCountSpan.innerText = "0";
                    }
                } catch (error) {
                    console.error('Error loading cart count:', error);
                    cartCountSpan.innerText = "0";
                }
            } else {
                cartCountSpan.innerText = "0";
                console.log('Not showing cart count - logged in:', isUserLoggedIn, 'isCustomer:', isCustomerRole);
            }
        }

        async function updateCartCount() {
            await loadCartCountFromAPI();
        }

        // ============== PHP SESSION DATA ==============
        const initialWishlistItems = <?php echo json_encode($wishlistItems); ?>;

        // ============== CART FUNCTIONS (UPDATED) ==============
        async function addToCartBackend(productId, quantity = 1) {
            await checkUserSession();
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
                const response = await fetch('Cart.php', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const result = await response.json();
                return result.success;
            } catch (error) {
                console.error('Error adding to cart:', error);
                return false;
            }
        }

        // ============== WISHLIST BACKEND FUNCTIONS ==============
        async function removeFromWishlistBackend(productId) {
            const formData = new FormData();
            formData.append('action', 'remove_item');
            formData.append('product_id', productId);
            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const result = await response.json();
                return result.success;
            } catch (error) {
                console.error('Error removing from wishlist:', error);
                return false;
            }
        }

        async function addAllToCartBackend() {
            const formData = new FormData();
            formData.append('action', 'add_all_to_cart');
            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const result = await response.json();
                return result;
            } catch (error) {
                console.error('Error adding all to cart:', error);
                return { success: false };
            }
        }

        // ============== UI FUNCTIONS ==============
        function showPopup(message) {
            let popup = document.createElement('div');
            popup.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
            popup.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);background:#10b981;color:white;padding:12px 24px;border-radius:60px;z-index:10001;font-size:14px;animation:fadeInOut 3s ease;font-weight:500;';
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 3000);
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function (m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function getValidImage(product) {
            if (product.image && product.image.trim() !== "" && product.image !== "undefined" && product.image !== "default-product.jpg") {
                return product.image;
            }
            return "https://placehold.co/400x300/2563eb/white?text=Product";
        }

        // ============== RENDER FUNCTIONS ==============
        function renderWishlist() {
            let container = document.getElementById("wishlistContainer");
            if (!container) return;

            if (!isUserLoggedIn) {
                container.innerHTML = `
                <div class="empty-state">
                    <h3><i class="fas fa-lock"></i> Please Login First</h3>
                    <p>You need to be logged in to view your wishlist.</p>
                    <a href="LogIn.php"><button class="btn-primary"><i class="fas fa-sign-in-alt"></i> Login Now →</button></a>
                </div>`;
                return;
            }

            let wishlist = initialWishlistItems;

            if (wishlist.length === 0) {
                container.innerHTML = `
                <div class="empty-state">
                    <h3><i class="fas fa-heart-broken"></i> Your wishlist is empty</h3>
                    <p>Start adding your favorite computer hardware products to your wishlist!</p>
                    <a href="Products1.php"><button class="btn-primary"><i class="fas fa-shopping-cart"></i> Continue Shopping →</button></a>
                </div>
                <div class="recommended-section">
                    <h3 class="recommended-title"><i class="fas fa-star"></i> You May Also Like</h3>
                    <div class="recommended-slider" id="recommendedGrid"></div>
                </div>`;
                renderRecommended([]);
                return;
            }

            container.innerHTML = `
            <div class="wishlist-actions" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30">
                <button class="btn-primary" id="addAllToCartBtn"><i class="fas fa-shopping-cart"></i> Add All to Cart (${wishlist.length})</button>
                <button class="share-btn" id="shareWishlistBtn"><i class="fas fa-share-alt"></i> Share Wishlist</button>
            </div>
            <div class="products-grid" id="wishlistGrid" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50"></div>
            <div class="recommended-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="100">
                <h3 class="recommended-title"><i class="fas fa-star"></i> You May Also Like</h3>
                <div class="recommended-slider" id="recommendedGrid"></div>
            </div>`;

            let grid = document.getElementById("wishlistGrid");
            if (grid) {
                grid.innerHTML = wishlist.map((product, index) => `
                <div class="product-card" data-product-id="${product.id}" data-aos="fade-up" data-aos-duration="400" data-aos-delay="${index * 50}">
                    <img class="product-image" src="${getValidImage(product)}" alt="${escapeHtml(product.name)}" onerror="this.src='https://placehold.co/400x300/2563eb/white?text=Product'">
                    <div class="product-info">
                        <h3 class="product-name">${escapeHtml(product.name)}</h3>
                        <div class="product-price">PKR ${(product.price || 0).toFixed(2)}</div>
                        <div class="vendor-name"><i class="fas fa-store"></i> by ${escapeHtml(product.vendor || 'Global Hardware Hub')}</div>
                        <div class="card-buttons">
                            <button class="btn-cart" data-id="${product.id}" data-name="${escapeHtml(product.name).replace(/'/g, "\\'")}"><i class="fas fa-cart-plus"></i> Move to Cart</button>
                            <button class="btn-remove" data-id="${product.id}"><i class="fas fa-trash-alt"></i> Remove</button>
                        </div>
                    </div>
                </div>`).join('');

                document.querySelectorAll('.btn-remove').forEach(btn => {
                    btn.addEventListener('click', async (e) => {
                        e.stopPropagation();
                        let id = parseInt(btn.getAttribute('data-id'));
                        if (!isNaN(id)) {
                            if (await removeFromWishlistBackend(id)) {
                                window.location.reload();
                            } else {
                                showPopup("Failed to remove item");
                            }
                        }
                    });
                });

                document.querySelectorAll('.btn-cart').forEach(btn => {
                    btn.addEventListener('click', async (e) => {
                        e.stopPropagation();
                        let id = parseInt(btn.getAttribute('data-id'));
                        let name = btn.getAttribute('data-name');
                        if (!isNaN(id)) {
                            if (await addToCartBackend(id, 1)) {
                                if (await removeFromWishlistBackend(id)) {
                                    showPopup(`${name} moved to cart!`);
                                    window.location.reload();
                                }
                            } else {
                                showPopup("Failed to add to cart");
                            }
                        }
                    });
                });
            }

            document.getElementById("addAllToCartBtn")?.addEventListener("click", async () => {
                let result = await addAllToCartBackend();
                if (result.success) {
                    showPopup(`${result.count || 0} item(s) added to cart!`);
                    await updateCartCount();
                    window.location.reload();
                }
            });

            document.getElementById("shareWishlistBtn")?.addEventListener("click", shareWishlist);

            renderRecommended(wishlist);
            
            // Refresh AOS for dynamically added elements
            AOS.refresh();
        }

        const MASTER_PRODUCTS = [
            { id: 1, name: "Intel Core i9-14900K", price: 589.99, vendor: "CPU Galaxy", image: "intelcorei9-14900k.jpg" },
            { id: 2, name: "NVIDIA RTX 4070 Ti", price: 659.99, vendor: "GPU Masters", image: "geforcertx4070ti.jpg" },
            { id: 3, name: "Samsung 990 Pro 2TB", price: 169.99, vendor: "Storage World", image: "samsung990pro.jpg" },
            { id: 4, name: "AMD Ryzen 7 7800X3D", price: 449.99, vendor: "CPU Galaxy", image: "amdryzen77800x3d.jpg" }
        ];

        function renderRecommended(currentWishlist) {
            let wishlistIds = new Set(currentWishlist.map(p => p.id));
            let recommended = MASTER_PRODUCTS.filter(p => !wishlistIds.has(p.id)).slice(0, 4);
            let recContainer = document.getElementById("recommendedGrid");
            if (recContainer) {
                recContainer.innerHTML = recommended.map((p, index) => `
                <div class="rec-card" data-aos="fade-up" data-aos-duration="300" data-aos-delay="${index * 50}">
                    <img src="${getValidImage(p)}" alt="${escapeHtml(p.name)}" onerror="this.src='https://placehold.co/400x300/2563eb/white?text=Product'">
                    <h4>${escapeHtml(p.name)}</h4>
                    <div class="rec-price">PKR ${p.price.toFixed(2)}</div>
                    <button class="btn-cart" style="margin-top: 0.5rem; padding: 0.3rem 0.8rem;" data-rec-id="${p.id}"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                </div>`).join('');

                document.querySelectorAll('[data-rec-id]').forEach(btn => {
                    btn.addEventListener('click', async (e) => {
                        let prodId = parseInt(btn.getAttribute('data-rec-id'));
                        let product = MASTER_PRODUCTS.find(p => p.id === prodId);
                        if (product && await addToCartBackend(prodId, 1)) {
                            showPopup(`${product.name} added to cart!`);
                            await updateCartCount();
                        }
                    });
                });
                AOS.refresh();
            }
        }

        function shareWishlist() {
            let wishlist = initialWishlistItems;
            let shareUrl = `${window.location.origin}${window.location.pathname}`;
            document.getElementById("shareLink").innerText = shareUrl;
            document.getElementById("shareModal").classList.add("show");
        }

        function copyShareLink() {
            let linkText = document.getElementById("shareLink").innerText;
            navigator.clipboard.writeText(linkText);
            showPopup("Link copied to clipboard!");
            closeShareModal();
        }

        function closeShareModal() {
            document.getElementById("shareModal").classList.remove("show");
        }

        // ============== AUTH UI ==============
        function setAuthUI() {
            let authBtn = document.getElementById("authButton");
            if (authBtn) {
                authBtn.innerHTML = isUserLoggedIn ? '<i class="fas fa-sign-out-alt"></i> Logout' : '<i class="fas fa-sign-in-alt"></i> Login';
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

        // ============== MOBILE MENU ==========
        function renderMobileMenu() {
            let container = document.getElementById("mobileMenuContent");
            if (!container) return;
            let logged = isUserLoggedIn;
            let menuItems = [
                { title: "Home", link: "FYPHome.php" },
                { title: "Products", submenu: ["Categories", "Compare Products", "Product Details", "All Products"], links: ["Categories.php", "CompareProducts.php", "ProductDetails.php", "Products1.php"] },
                { title: "Vendors", submenu: ["Vendors List", "Vendors Store", "Vendors Setting", "Vendors Dashboard", "Vendors Products", "Vendors Add Products", "Vendors Edit Products", "Vendors Reviews", "Vendors Orders", "Vendor Order Details"], links: ["Vendors.php", "VendorsStore.php", "VendorsSetting.php", "VendorsDashboard.php", "VendorsProducts.php", "VendorsAddProducts.php", "VendorsEditProducts.php", "VendorsReviews.php", "VendorsOrders.php", "VendorOrderDetails.php"] },
                { title: "Account", submenu: ["My Account", "Profile", "Orders", "Order Details", "Wishlist", "Address Book", "Payment Methods", "Cart", "Checkout", "Checkout Shipping", "Checkout Payment"], links: ["MyAccount.php", "Profile.php", "UserOrders.php", "UserOrderDetails.php", "Wishlist.php", "AddressBook.php", "PaymentMethods.php", "Cart.php", "Checkout.php", "CheckoutShipping.php", "CheckoutPayment.php"] },
                { title: "Support", submenu: ["Contact", "FAQ", "Shipping Info", "Warranty Info", "Return Policy", "Privacy Policy", "Terms of Service", "About Us", "Cookie Policy"], links: ["ContactUs.php", "FAQ.php", "ShippingInfo.php", "WarrantyInfo.php", "ReturnPolicy.php", "PrivacyPolicy.php", "TermsofService.php", "AboutUs.php", "CookiePolicy.php"] },
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
                header.addEventListener("click", (e) => {
                    let key = header.getAttribute("data-toggle");
                    let sub = document.getElementById(`submenu-${key}`);
                    if (sub) sub.style.display = sub.style.display === "none" ? "block" : "none";
                });
            });
            let mobileAuth = document.getElementById("mobileAuthBtn");
            if (mobileAuth) mobileAuth.onclick = () => { handleAuthClick(); renderMobileMenu(); };
        }

        let hamburger = document.getElementById("hamburgerBtn");
        let mobilePanel = document.getElementById("mobileMenuPanel");
        let overlay = document.getElementById("mobileOverlay");
        function openMobile() { mobilePanel.classList.add("open"); overlay.classList.add("show"); }
        function closeMobile() { mobilePanel.classList.remove("open"); overlay.classList.remove("show"); }
        if (hamburger) hamburger.addEventListener("click", openMobile);
        document.getElementById("closeMobileBtn")?.addEventListener("click", closeMobile);
        if (overlay) overlay.addEventListener("click", closeMobile);

        // Back to Top
        let backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        if (backBtn) backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // Cart icon click
        document.querySelector('.cart-icon')?.addEventListener('click', async () => {
            await checkUserSession();
            if (!isUserLoggedIn) { alert('Please login to manage your cart'); window.location.href = "LogIn.php"; }
            else { window.location.href = "Cart.php"; }
        });

        // ========== INITIALIZE PAGE ==========
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();
            renderWishlist();
        }
        
        init();

        // Expose functions globally
        window.copyShareLink = copyShareLink;
        window.closeShareModal = closeShareModal;
        window.shareWishlist = shareWishlist;
    </script>
</body>

</html>