<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['logged_in'])) {
    header("Location: Login.php");
    exit();
}

// Get user info from session
$user_id = $_SESSION['user_id'] ?? null;
$user_name = $_SESSION['user_name'] ?? $_SESSION['full_name'] ?? 'User';
$user_email = $_SESSION['user_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | My Account</title>
    <!-- Font Awesome for icons -->
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

        /* ========== HEADER - DARK NAVY ========== */
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
        }

        .nav-link i {
            color: #FFFFFF;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
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

        .hamburger:hover {
            color: var(--secondary);
        }

        /* Mobile Menu Panel */
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

        .mobile-nav-item {
            border-bottom: 1px solid #E5E7EB;
        }

        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 0;
            font-weight: 600;
            cursor: pointer;
            color: #111827;
        }

        .mobile-submenu {
            padding-left: 1rem;
            display: none;
            background: #F9FAFB;
        }

        .mobile-submenu.open {
            display: block;
        }

        .mobile-submenu a {
            display: block;
            padding: 0.6rem 0;
            text-decoration: none;
            color: #374151;
            font-size: 0.85rem;
        }

        .close-mobile {
            background: none;
            border: none;
            font-size: 1.8rem;
            float: right;
            cursor: pointer;
            color: #111827;
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
            transition: all 0.2s;
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
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: #CBD5E1;
        }

        /* Account Container */
        .account-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .dashboard {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        /* Sidebar - White Card */
        .sidebar {
            flex: 0 0 280px;
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 100px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .sidebar:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .sidebar h3 {
            font-size: 1rem;
            color: #111827;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #E5E7EB;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.7rem 0.8rem;
            text-decoration: none;
            color: #374151;
            border-radius: 16px;
            transition: 0.2s;
            font-weight: 500;
        }

        .sidebar-nav a i {
            width: 24px;
            color: #6B7280;
        }

        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: #EFF6FF;
            color: var(--primary);
        }

        .sidebar-nav a.active i {
            color: var(--primary);
        }

        .mobile-menu-btn {
            display: none;
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .main-content {
            flex: 1;
            min-width: 0;
        }

        /* Profile Header - White Card */
        .profile-header {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .profile-pic {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            background: #F3F4F6;
            border: 3px solid #E5E7EB;
        }

        .profile-info h2 {
            font-size: 1.3rem;
            color: #111827;
        }

        .profile-info p {
            color: #6B7280;
            font-size: 0.85rem;
        }

        .completion-bar {
            width: 200px;
            height: 6px;
            background: #E5E7EB;
            border-radius: 3px;
            margin-top: 0.5rem;
        }

        .completion-fill {
            height: 100%;
            background: var(--success);
            border-radius: 3px;
            width: 0%;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.8rem;
            color: #6B7280;
        }

        /* Recent Orders Section - White Card */
        .recent-orders {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .recent-orders:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .section-title {
            font-size: 1.1rem;
            color: #111827;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #E5E7EB;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        th, td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }

        th {
            color: #6B7280;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 60px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-delivered { background: #D1FAE5; color: #065F46; }
        .status-shipped { background: #FED7AA; color: #9B2C1D; }
        .status-processing { background: #DBEAFE; color: #1E40AF; }
        .status-pending { background: #F3F4F6; color: #374151; }
        .status-confirmed { background: #DBEAFE; color: #1E40AF; }
        .status-cancelled { background: #FEE2E2; color: #DC2626; }

        .btn-sm {
            background: #F3F4F6;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 500;
            margin: 0.2rem;
            transition: all 0.2s;
            color: #374151;
        }

        .btn-sm:hover {
            background: #E5E7EB;
            transform: translateY(-2px);
        }

        .btn-primary-sm {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-primary-sm:hover {
            background: var(--primary-dark);
        }

        /* Empty Section Add Link Styles */
        .empty-section {
            text-align: center;
            padding: 2rem;
            color: #6B7280;
        }

        .empty-section i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-section p {
            margin-bottom: 1rem;
        }

        .add-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-gradient);
            color: white;
            text-decoration: none;
            padding: 0.6rem 1.5rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .add-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        /* Address & Payment Cards */
        .address-card, .payment-card {
            background: #F9FAFB;
            border-radius: 20px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #E5E7EB;
            transition: all 0.2s;
        }

        .address-card:hover, .payment-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
        }

        .address-title, .payment-title {
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .address-details, .payment-details {
            color: #6B7280;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .address-actions, .payment-actions {
            margin-top: 0.5rem;
        }

        /* Wishlist Item */
        .wishlist-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #E5E7EB;
        }

        .wishlist-item:last-child {
            border-bottom: none;
        }

        .wishlist-product {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .wishlist-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 12px;
            background: #F3F4F6;
        }

        .empty-message {
            text-align: center;
            padding: 2rem;
            color: #6B7280;
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
            transition: all 0.2s;
            z-index: 99;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: var(--shadow-md);
            font-weight: 500;
        }

        .back-to-top.show {
            opacity: 1;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        /* Notification */
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--success);
            color: white;
            padding: 12px 24px;
            border-radius: 60px;
            z-index: 10000;
            font-size: 14px;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-weight: 500;
        }

        .notification.error {
            background: var(--danger);
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

        @media (max-width: 800px) {
            .nav-container {
                flex-direction: row;
                justify-content: space-between;
                padding: 0.8rem 1.2rem;
            }
            .nav-links {
                display: none;
            }
            .hamburger {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            .sidebar {
                display: none;
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                z-index: 999;
                margin: 0 1rem;
            }
            .sidebar.show {
                display: block;
            }
            .dashboard {
                flex-direction: column;
            }
            .wishlist-product {
                flex-direction: column;
                text-align: center;
            }
            .wishlist-item {
                flex-direction: column;
                gap: 1rem;
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
            <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
            <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
            <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
            <li class="nav-item"><a href="Cart.php" class="cart-icon"><i class="fas fa-shopping-cart"></i> Cart <span id="cartCountDisplay" class="cart-count">0</span></a></li>
            <li class="nav-item"><button id="authButton" class="auth-btn"><i class="fas fa-sign-out-alt"></i> Logout</button></li>
        </ul>
        
        <button class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></button>
    </div>
</header>

<div class="mobile-overlay" id="mobileOverlay"></div>
<div class="mobile-menu-panel" id="mobileMenuPanel">
    <button class="close-mobile" id="closeMobileBtn"><i class="fas fa-times"></i></button>
    <div id="mobileMenuContent"></div>
</div>

<div class="account-container">
    <button class="mobile-menu-btn" id="mobileMenuBtn"><i class="fas fa-bars"></i> Menu</button>
    <div class="dashboard">
        <aside class="sidebar" id="sidebar">
            <h3>My Account</h3>
            <ul class="sidebar-nav">
                <li><a href="#" data-section="overview"><i class="fas fa-chart-line"></i> Account Overview</a></li>
                <li><a href="#" data-section="orders"><i class="fas fa-box"></i> Orders</a></li>
                <li><a href="#" data-section="wishlist"><i class="fas fa-heart"></i> Wishlist</a></li>
                <li><a href="#" data-section="addresses"><i class="fas fa-map-marker-alt"></i> Addresses</a></li>
                <li><a href="#" data-section="payments"><i class="fas fa-credit-card"></i> Payment Methods</a></li>
                <li><a href="#" data-section="settings"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>

        <div class="main-content" id="mainContent">
            <div style="text-align:center; padding:2rem;"><i class="fas fa-spinner fa-pulse"></i> Loading...</div>
        </div>
    </div>
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
            <a href="WarrantyInfo.php">Warranty Info</a>
            <a href="Wishlist.php">Wishlist</a>
            <a href="Blog.php">Tech Blog</a>
            <a href="CookiePolicy.php">Cookie Policy</a>
        </div>
        <div class="footer-col">
            <h4>Contact</h4>
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
            <p>© 2026 Global Hardware Hub</p>
        </div>
    </div>
    <div class="copyright">Global Hardware Hub | The Ultimate Computer Hardware Marketplace</div>
</footer>

<button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i> Back to Top</button>

<script>
    // ========== SESSION AND CART FUNCTIONS ==========
    let isUserLoggedIn = false;
    let isCustomerRole = false;
    let currentUserId = null;

    async function checkUserSession() {
        try {
            const response = await fetch('check_session.php');
            const data = await response.json();
            
            if (data && data.user_id) {
                isUserLoggedIn = true;
                currentUserId = data.user_id;
                isCustomerRole = (data.user_role === 'customer');
                return true;
            } else {
                isUserLoggedIn = false;
                isCustomerRole = false;
                currentUserId = null;
                return false;
            }
        } catch (error) {
            console.error('Session check error:', error);
            isUserLoggedIn = false;
            return false;
        }
    }

    async function loadCartCountFromAPI() {
        const cartCountSpan = document.getElementById("cartCountDisplay");
        if (!cartCountSpan) return;
        
        const sessionValid = await checkUserSession();
        
        if (sessionValid && isCustomerRole) {
            try {
                const response = await fetch('get_cart_count.php');
                const data = await response.json();
                cartCountSpan.innerText = data.success ? data.cart_count : "0";
            } catch (error) {
                cartCountSpan.innerText = "0";
            }
        } else {
            cartCountSpan.innerText = "0";
        }
    }

    async function updateCartCount() {
        await loadCartCountFromAPI();
    }

    // ========== NOTIFICATION FUNCTION ==========
    function showNotification(message, isError = false) {
        const notification = document.createElement('div');
        notification.className = 'notification' + (isError ? ' error' : '');
        notification.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // ========== WISHLIST FUNCTIONS ==========
    window.addAllWishlistToCart = async function() {
        const addBtn = document.getElementById('addAllWishlistBtn');
        if (addBtn) {
            addBtn.disabled = true;
            addBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Adding...';
        }
        
        try {
            const response = await fetch('add_wishlist_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            });
            const data = await response.json();
            
            if (data.success) {
                showNotification(data.message);
                await updateCartCount();
                setTimeout(() => {
                    showSection('wishlist');
                }, 1500);
            } else {
                showNotification(data.message, true);
            }
        } catch (error) {
            console.error('Error adding wishlist to cart:', error);
            showNotification('Failed to add items to cart', true);
        } finally {
            if (addBtn) {
                addBtn.disabled = false;
                addBtn.innerHTML = '<i class="fas fa-cart-plus"></i> Add All to Cart';
            }
        }
    };

    window.addSingleWishlistItem = async function(productId) {
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Adding...';
        btn.disabled = true;
        
        try {
            const formData = new URLSearchParams();
            formData.append('product_id', productId);
            formData.append('quantity', 1);
            
            const response = await fetch('add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });
            const data = await response.json();
            
            if (data.success) {
                showNotification('Item added to cart!');
                await updateCartCount();
                btn.innerHTML = '✓ Added';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2000);
            } else {
                showNotification(data.message || 'Failed to add item', true);
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        } catch (error) {
            console.error('Add to cart error:', error);
            showNotification('Network error. Please try again.', true);
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    };

    // ========== REORDER FUNCTIONS ==========
    window.handleReorder = async function(orderId) {
        const reorderBtns = document.querySelectorAll(`.btn-sm[onclick*="handleReorder(${orderId})"]`);
        reorderBtns.forEach(btn => {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Adding...';
        });
        
        try {
            const formData = new URLSearchParams();
            formData.append('order_id', orderId);
            
            const response = await fetch('reorder_items.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });
            const data = await response.json();
            
            if (data.success) {
                showNotification(data.message);
                await updateCartCount();
                setTimeout(() => {
                    window.location.href = 'Checkout.php';
                }, 1500);
            } else {
                showNotification(data.message, true);
                reorderBtns.forEach(btn => {
                    btn.disabled = false;
                    btn.innerHTML = '🔄 Reorder';
                });
            }
        } catch (error) {
            console.error('Reorder error:', error);
            showNotification('Failed to reorder items', true);
            reorderBtns.forEach(btn => {
                btn.disabled = false;
                btn.innerHTML = '🔄 Reorder';
            });
        }
    };
    
    window.handleTrackOrder = function(orderId) {
        window.location.href = `OrderTracking.php?order_id=${orderId}`;
    };
    
    window.handleViewOrder = function(orderId) {
        window.location.href = `UserOrderDetails.php?order_id=${orderId}`;
    };

    let userProfileData = null;
    let dashboardCounts = null;

    // ============== API FUNCTIONS ==============
    
    async function checkLogin() {
        await checkUserSession();
        return { logged_in: isUserLoggedIn };
    }
    
    async function loadProfile() {
        try {
            const response = await fetch('get_user_profile.php');
            const data = await response.json();
            if (data.success) {
                userProfileData = data.data;
            }
            return data;
        } catch (error) {
            console.error('Load profile error:', error);
            return { success: false };
        }
    }
    
    async function loadDashboardCounts() {
        try {
            const response = await fetch('get_account_dashboard_counts.php');
            const data = await response.json();
            if (data.success) {
                dashboardCounts = data.counts;
            }
            return data;
        } catch (error) {
            console.error('Load counts error:', error);
            return { success: false };
        }
    }
    
    async function loadRecentOrders() {
        try {
            const response = await fetch('get_recent_user_orders.php');
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Load recent orders error:', error);
            return { success: false, orders: [] };
        }
    }
    
    async function loadAllOrders() {
        try {
            const response = await fetch('get_user_orders.php');
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Load all orders error:', error);
            return { success: false, orders: [] };
        }
    }
    
    async function loadWishlist() {
        try {
            const response = await fetch('get_user_wishlist.php');
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Load wishlist error:', error);
            return { success: false, wishlist: [] };
        }
    }
    
    async function loadAddresses() {
        try {
            const response = await fetch('get_user_addresses.php');
            const data = await response.json();
            
            if (data.success) {
                if (data.addresses && Array.isArray(data.addresses)) {
                    return { success: true, addresses: data.addresses };
                } else if (Array.isArray(data.data)) {
                    return { success: true, addresses: data.data };
                } else if (data.data && data.data.addresses && Array.isArray(data.data.addresses)) {
                    return { success: true, addresses: data.data.addresses };
                } else {
                    return { success: true, addresses: [] };
                }
            }
            return { success: false, addresses: [] };
        } catch (error) {
            console.error('Load addresses error:', error);
            return { success: false, addresses: [] };
        }
    }
    
    async function loadPaymentMethods() {
        try {
            const response = await fetch('get_user_payment_methods.php');
            const data = await response.json();
            
            if (data.success) {
                if (data.payment_methods && Array.isArray(data.payment_methods)) {
                    return { success: true, payment_methods: data.payment_methods };
                } else if (Array.isArray(data.data)) {
                    return { success: true, payment_methods: data.data };
                } else if (data.data && data.data.payment_methods && Array.isArray(data.data.payment_methods)) {
                    return { success: true, payment_methods: data.data.payment_methods };
                } else {
                    return { success: true, payment_methods: [] };
                }
            }
            return { success: false, payment_methods: [] };
        } catch (error) {
            console.error('Load payment methods error:', error);
            return { success: false, payment_methods: [] };
        }
    }
    
    // ============== HELPER FUNCTIONS ==============
    
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    }
    
    function getStatusClass(status) {
        const statusMap = {
            'pending': 'status-pending',
            'processing': 'status-processing',
            'confirmed': 'status-confirmed',
            'shipped': 'status-shipped',
            'delivered': 'status-delivered',
            'cancelled': 'status-cancelled'
        };
        return statusMap[status] || 'status-pending';
    }
    
    function calculateProfileCompletion(profileData) {
        const fields = ['user_id', 'full_name', 'email', 'phone', 'profile_image', 'date_of_birth'];
        let filledCount = 0;
        
        fields.forEach(field => {
            if (profileData[field] && profileData[field] !== 'null' && profileData[field] !== '') {
                filledCount++;
            }
        });
        
        return Math.round((filledCount / fields.length) * 100);
    }
    
    // ============== SECTION RENDERERS ==============
    
    function renderOverview(profile, counts, recentOrders) {
        const completion = calculateProfileCompletion(profile);
        const profileImage = profile.profile_image && profile.profile_image !== 'null' 
            ? profile.profile_image 
            : 'uploads/profile/default-avatar.png';
        
        let recentOrdersHtml = '';
        if (recentOrders.orders && recentOrders.orders.length > 0) {
            recentOrdersHtml = recentOrders.orders.map(order => `
                <tr>
                    <td>#${order.order_id}</td>
                    <td>${formatDate(order.date)}</td>
                    <td><span class="status-badge ${getStatusClass(order.status)}">${order.status}</span></td>
                    <td>₨${parseFloat(order.total_amount).toLocaleString()}</td>
                    <td>
                        <button class="btn-sm" onclick="handleReorder(${order.order_id})"><i class="fas fa-sync-alt"></i> Reorder</button>
                        <button class="btn-sm" onclick="handleTrackOrder(${order.order_id})"><i class="fas fa-map-marker-alt"></i> Track</button>
                    </td>
                </tr>
            `).join('');
        } else {
            recentOrdersHtml = '<tr><td colspan="5" style="text-align:center;">No recent orders found</td></tr>';
        }
        
        return `
            <div class="profile-header">
                <img class="profile-pic" src="${profileImage}" alt="Profile">
                <div class="profile-info">
                    <h2>${profile.full_name || 'User'}</h2>
                    <p>${profile.email || ''}</p>
                    <div class="completion-bar"><div class="completion-fill" style="width: ${completion}%"></div></div>
                    <p style="font-size:0.7rem; margin-top:0.2rem;">Profile ${completion}% complete</p>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card"><div class="stat-number">${counts.total_orders || 0}</div><div class="stat-label">Total Orders</div></div>
                <div class="stat-card"><div class="stat-number">${counts.wishlist_items || 0}</div><div class="stat-label">Wishlist Items</div></div>
                <div class="stat-card"><div class="stat-number">${counts.saved_addresses || 0}</div><div class="stat-label">Saved Addresses</div></div>
                <div class="stat-card"><div class="stat-number">${counts.payment_methods || 0}</div><div class="stat-label">Payment Methods</div></div>
            </div>

            <div class="recent-orders">
                <h3 class="section-title"><i class="fas fa-list-alt"></i> Recent Orders</h3>
                <div class="table-responsive">
                    <table>
                        <thead><tr><th>Order ID</th><th>Date</th><th>Status</th><th>Total</th><th>Actions</th></tr></thead>
                        <tbody>${recentOrdersHtml}</tbody>
                    </table>
                </div>
                <div style="margin-top: 1rem;">
                    <button class="btn-sm" onclick="window.location.href='ContactUs.php'"><i class="fas fa-envelope"></i> Contact Support</button>
                </div>
            </div>
        `;
    }
    
    function renderOrders(ordersData) {
        if (!ordersData.orders || ordersData.orders.length === 0) {
            return `<div class="recent-orders"><h3 class="section-title"><i class="fas fa-box"></i> All Orders</h3><div class="empty-message">No orders found</div></div>`;
        }
        
        const ordersHtml = ordersData.orders.map(order => `
            <tr>
                <td>#${order.order_id}</td>
                <td>${formatDate(order.date)}</td>
                <td><span class="status-badge ${getStatusClass(order.status)}">${order.status}</span></td>
                <td>₨${parseFloat(order.total_amount).toLocaleString()}</td>
                <td>
                    <button class="btn-sm" onclick="handleReorder(${order.order_id})"><i class="fas fa-sync-alt"></i> Reorder</button>
                    <button class="btn-sm" onclick="handleTrackOrder(${order.order_id})"><i class="fas fa-map-marker-alt"></i> Track</button>
                    <button class="btn-sm" onclick="handleViewOrder(${order.order_id})"><i class="fas fa-eye"></i> View Details</button>
                </td>
            </tr>
        `).join('');
        
        return `
            <div class="recent-orders">
                <h3 class="section-title"><i class="fas fa-box"></i> All Orders (${ordersData.orders.length})</h3>
                <div class="table-responsive">
                    <table>
                        <thead><tr><th>Order ID</th><th>Date</th><th>Status</th><th>Total</th><th>Actions</th></tr></thead>
                        <tbody>${ordersHtml}</tbody>
                    </table>
                </div>
            </div>
        `;
    }
    
    function renderWishlist(wishlistData) {
        let wishlistHtml = '';
        
        if (!wishlistData.wishlist || wishlistData.wishlist.length === 0) {
            wishlistHtml = '<div class="empty-message"><i class="fas fa-heart-broken"></i> Your wishlist is empty</div>';
        } else {
            wishlistHtml = wishlistData.wishlist.map(item => `
                <div class="wishlist-item">
                    <div class="wishlist-product">
                        <img class="wishlist-img" src="${item.image_url || 'uploads/products/placeholder.jpg'}" alt="${item.product_name}">
                        <div>
                            <strong>${item.product_name}</strong><br>
                            <span style="color:var(--primary); font-weight:600;">₨${parseFloat(item.price).toLocaleString()}</span>
                            <br><span class="status-badge status-${item.status}">${item.status}</span>
                        </div>
                    </div>
                    <div>
                        <button class="btn-sm btn-primary-sm" onclick="addSingleWishlistItem(${item.product_id})">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn-sm" onclick="window.location.href='ProductDetails.php?id=${item.product_id}'">
                            <i class="fas fa-eye"></i> View Product
                        </button>
                    </div>
                </div>
            `).join('');
        }
        
        const wishlistCount = wishlistData.wishlist ? wishlistData.wishlist.length : 0;
        
        return `
            <div class="recent-orders">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                    <h3 class="section-title" style="margin-bottom: 0;"><i class="fas fa-heart"></i> Wishlist (${wishlistCount} items)</h3>
                    ${wishlistCount > 0 ? `
                        <button id="addAllWishlistBtn" class="btn-sm" style="background: var(--primary); color: white; border: none;" onclick="addAllWishlistToCart()">
                            <i class="fas fa-cart-plus"></i> Add All to Cart
                        </button>
                    ` : ''}
                </div>
                ${wishlistHtml}
            </div>
        `;
    }
    
    function renderAddresses(addressesData) {
        // UPDATED: Stylish "Add" link when no addresses found
        if (!addressesData.addresses || addressesData.addresses.length === 0) {
            return `
                <div class="recent-orders">
                    <h3 class="section-title"><i class="fas fa-map-marker-alt"></i> Saved Addresses</h3>
                    <div class="empty-section">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>No saved addresses found.</p>
                        <a href="AddressBook.php" class="add-link">
                            <i class="fas fa-plus-circle"></i> Add New Address
                        </a>
                    </div>
                </div>
            `;
        }
        
        const addressesHtml = addressesData.addresses.map(addr => `
            <div class="address-card">
                <div class="address-title">
                    ${addr.address_title || 'Address'}
                    ${addr.is_default ? '<span style="background:var(--success); color:white; padding:2px 8px; border-radius:12px; font-size:10px; margin-left:8px;"><i class="fas fa-check"></i> Default</span>' : ''}
                </div>
                <div class="address-details">
                    ${addr.full_name ? `<strong>${addr.full_name}</strong><br>` : ''}
                    ${addr.address_line1 || addr.address || ''}${addr.address_line2 ? '<br>' + addr.address_line2 : ''}<br>
                    ${addr.city ? addr.city + ', ' : ''}${addr.state ? addr.state + ' ' : ''}${addr.postal_code || addr.zip_code || ''}<br>
                    ${addr.country || ''}<br>
                    ${addr.phone ? `📞 ${addr.phone}` : ''}
                </div>
                <div class="address-actions">
                    <button class="btn-sm" onclick="window.location.href='AddressBook.php'"><i class="fas fa-edit"></i> Edit</button>
                    <button class="btn-sm" onclick="window.location.href='AddressBook.php'"><i class="fas fa-trash-alt"></i> Delete</button>
                </div>
            </div>
        `).join('');
        
        return `
            <div class="recent-orders">
                <h3 class="section-title"><i class="fas fa-map-marker-alt"></i> Saved Addresses (${addressesData.addresses.length})</h3>
                ${addressesHtml}
                <div style="margin-top: 1rem;">
                    <a href="AddressBook.php" class="add-link" style="display: inline-flex;">
                        <i class="fas fa-plus-circle"></i> Add New Address
                    </a>
                </div>
            </div>
        `;
    }
    
    function renderPaymentMethods(paymentsData) {
        // UPDATED: Stylish "Add" link when no payment methods found
        if (!paymentsData.payment_methods || paymentsData.payment_methods.length === 0) {
            return `
                <div class="recent-orders">
                    <h3 class="section-title"><i class="fas fa-credit-card"></i> Payment Methods</h3>
                    <div class="empty-section">
                        <i class="fas fa-credit-card"></i>
                        <p>No saved payment methods found.</p>
                        <a href="PaymentMethods.php" class="add-link">
                            <i class="fas fa-plus-circle"></i> Add Payment Method
                        </a>
                    </div>
                </div>
            `;
        }
        
        const paymentsHtml = paymentsData.payment_methods.map(pm => `
            <div class="payment-card">
                <div class="payment-title">
                    ${pm.card_type || pm.method_type || pm.payment_type || 'Card'} 
                    ${pm.is_default ? '<span style="background:var(--success); color:white; padding:2px 8px; border-radius:12px; font-size:10px; margin-left:8px;"><i class="fas fa-check"></i> Default</span>' : ''}
                </div>
                <div class="payment-details">
                    ${pm.card_number ? `**** **** **** ${pm.card_number.slice(-4)}` : ''}
                    ${pm.last4 ? `**** **** **** ${pm.last4}` : ''}
                    ${pm.card_holder_name ? `<br>Cardholder: ${pm.card_holder_name}` : ''}
                    ${pm.expiry_month && pm.expiry_year ? `<br>Expires: ${pm.expiry_month}/${pm.expiry_year}` : ''}
                </div>
                <div class="payment-actions">
                    <button class="btn-sm" onclick="window.location.href='PaymentMethods.php'"><i class="fas fa-trash-alt"></i> Delete</button>
                </div>
            </div>
        `).join('');
        
        return `
            <div class="recent-orders">
                <h3 class="section-title"><i class="fas fa-credit-card"></i> Payment Methods (${paymentsData.payment_methods.length})</h3>
                ${paymentsHtml}
                <div style="margin-top: 1rem;">
                    <a href="PaymentMethods.php" class="add-link" style="display: inline-flex;">
                        <i class="fas fa-plus-circle"></i> Add Payment Method
                    </a>
                </div>
            </div>
        `;
    }
    
    function renderSettings() {
        return `
            <div class="recent-orders">
                <h3 class="section-title"><i class="fas fa-cog"></i> Account Settings</h3>
                <div class="address-card">
                    <div class="address-title"><i class="fas fa-user-edit"></i> Edit Profile</div>
                    <div class="address-details">Update your personal information including name, email, phone number, and date of birth.</div>
                    <div class="address-actions">
                        <button class="btn-sm" onclick="window.location.href='Profile.php'"><i class="fas fa-arrow-right"></i> Go to Profile</button>
                    </div>
                </div>
                <div class="address-card">
                    <div class="address-title"><i class="fas fa-lock"></i> Change Password</div>
                    <div class="address-details">Update your account password to keep your account secure.</div>
                    <div class="address-actions">
                        <button class="btn-sm" onclick="window.location.href='Profile.php?section=password'"><i class="fas fa-key"></i> Change Password</button>
                    </div>
                </div>
            </div>
        `;
    }
    
    // ============== SECTION CONTROLLER ==============
    
    let currentSection = 'overview';
    
    async function showSection(sectionName) {
        currentSection = sectionName;
        const mainContent = document.getElementById('mainContent');
        
        document.querySelectorAll('.sidebar-nav a[data-section]').forEach(link => {
            if (link.getAttribute('data-section') === sectionName) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
        
        mainContent.innerHTML = '<div style="text-align:center; padding:2rem;"><i class="fas fa-spinner fa-pulse"></i> Loading...</div>';
        
        try {
            switch(sectionName) {
                case 'overview':
                    const [profile, counts, recentOrders] = await Promise.all([
                        loadProfile(),
                        loadDashboardCounts(),
                        loadRecentOrders()
                    ]);
                    if (profile.success && counts.success) {
                        mainContent.innerHTML = renderOverview(profile.data, counts.counts, recentOrders);
                    } else {
                        mainContent.innerHTML = '<div class="recent-orders"><div class="empty-message">Failed to load dashboard data</div></div>';
                    }
                    break;
                    
                case 'orders':
                    const orders = await loadAllOrders();
                    mainContent.innerHTML = renderOrders(orders);
                    break;
                    
                case 'wishlist':
                    const wishlist = await loadWishlist();
                    mainContent.innerHTML = renderWishlist(wishlist);
                    break;
                    
                case 'addresses':
                    const addresses = await loadAddresses();
                    mainContent.innerHTML = renderAddresses(addresses);
                    break;
                    
                case 'payments':
                    const payments = await loadPaymentMethods();
                    mainContent.innerHTML = renderPaymentMethods(payments);
                    break;
                    
                case 'settings':
                    mainContent.innerHTML = renderSettings();
                    break;
                    
                default:
                    mainContent.innerHTML = '<div class="recent-orders"><div class="empty-message">Section not found</div></div>';
            }
        } catch (error) {
            console.error('Error loading section:', error);
            mainContent.innerHTML = '<div class="recent-orders"><div class="empty-message">Error loading data. Please try again.</div></div>';
        }
    }
    
    // ============== PAGE INITIALIZATION ==============
    
    async function initPage() {
        const loginStatus = await checkLogin();
        
        if (!loginStatus.logged_in) {
            alert('Please Login First');
            window.location.href = 'LogIn.php';
            return;
        }
        
        await showSection('overview');
    }
    
    // ============== EVENT LISTENERS ==============
    
    document.querySelectorAll('.sidebar-nav a[data-section]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const section = link.getAttribute('data-section');
            showSection(section);
            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.remove('show');
            }
        });
    });
    
    document.getElementById('logoutBtn')?.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = 'Logout.php';
    });
    
    document.getElementById('mobileMenuBtn')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
    
    document.querySelector('.cart-icon')?.addEventListener('click', async () => {
        await checkUserSession();
        if (isUserLoggedIn) {
            window.location.href = 'Cart.php';
        } else {
            alert('Please login to manage your cart');
            window.location.href = 'LogIn.php';
        }
    });
    
    document.getElementById('authButton')?.addEventListener('click', async () => {
        await checkUserSession();
        window.location.href = 'Logout.php';
    });
    
    const backBtn = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) backBtn.classList.add('show');
        else backBtn.classList.remove('show');
    });
    backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    
    async function renderMobileMenu() {
        await checkUserSession();
        const container = document.getElementById('mobileMenuContent');
        if (!container) return;
        
        const menuItems = [
            { title: 'Home', link: 'FYPHome.php' },
            { title: 'Products', submenu: ['Categories', 'Compare Products', 'Product Details', 'All Products'], links: ['Categories.php', 'CompareProducts.php', 'ProductDetails.php', 'Products1.php'] },
            { title: 'Vendors', submenu: ['Vendors List','Vendors Store','Vendors Setting','Vendors Dashboard','Vendors Products','Vendors Add Products','Vendors Edit Products','Vendors Reviews','Vendors Orders','Vendor Order Details'], links: ['Vendors.php','VendorsStore.php','VendorSettings.php','VendorDashboard.php','VendorProductsManagement.php','VendorAddProducts.php','VendorEditProducts.php','VendorReviews.php','VendorOrders.php','VendorOrderDetails.php'] },
            { title: 'Account', submenu: ['My Account','Profile','Orders','Order Details','Wishlist','Address Book','Payment Methods','Cart','Checkout','Checkout Shipping','Checkout Payment'], links: ['MyAccount.php','Profile.php','UserOrders.php','UserOrderDetails.php','Wishlist.php','AddressBook.php','PaymentMethods.php','Cart.php','Checkout.php','CheckoutShipping.php','CheckoutPayment.php'] },
            { title: 'Support', submenu: ['Contact','FAQ','Shipping Info','Warranty Info','Return Policy','Privacy Policy','Terms of Service','About Us','Cookie Policy'], links: ['ContactUs.php','FAQ.php','ShippingInfo.php','WarrantyInfo.php','ReturnPolicy.php','PrivacyPolicy.php','TermsofService.php','AboutUs.php','CookiePolicy.php'] },
            { title: 'Blog', link: 'Blog.php' },
            { title: 'Blog Details', link: 'BlogDetails.php' }
        ];
        
        let html = `<div style="margin-top:2rem;"><a href="Logout.php" class="auth-btn" style="width:100%; display:block; text-align:center;"><i class="fas fa-sign-out-alt"></i> ${isUserLoggedIn ? 'Logout' : 'Login'}</a></div><hr style="margin:1rem 0;">`;
        menuItems.forEach(item => {
            if (item.submenu) {
                html += `<div class="mobile-nav-item"><div class="mobile-nav-header" data-toggle="${item.title}">${item.title} <i class="fas fa-chevron-down"></i></div><div class="mobile-submenu" id="submenu-${item.title}">`;
                item.submenu.forEach((sub, idx) => { html += `<a href="${item.links[idx]}">${sub}</a>`; });
                html += `</div></div>`;
            } else {
                html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0;">${item.title}</a></div>`;
            }
        });
        container.innerHTML = html;
        
        document.querySelectorAll('.mobile-nav-header').forEach(header => {
            header.addEventListener('click', () => {
                const key = header.getAttribute('data-toggle');
                const sub = document.getElementById(`submenu-${key}`);
                if (sub) sub.classList.toggle('open');
            });
        });
    }
    
    const hamburger = document.getElementById('hamburgerBtn');
    const mobilePanel = document.getElementById('mobileMenuPanel');
    const mobileOverlay = document.getElementById('mobileOverlay');
    function openMobile() { mobilePanel.classList.add('open'); mobileOverlay.classList.add('show'); }
    function closeMobile() { mobilePanel.classList.remove('open'); mobileOverlay.classList.remove('show'); }
    hamburger?.addEventListener('click', openMobile);
    document.getElementById('closeMobileBtn')?.addEventListener('click', closeMobile);
    mobileOverlay?.addEventListener('click', closeMobile);
    
    // Initialize everything
    async function init() {
        await checkUserSession();
        await renderMobileMenu();
        await updateCartCount();
        await initPage();
    }
    
    init();
</script>
</body>
</html>