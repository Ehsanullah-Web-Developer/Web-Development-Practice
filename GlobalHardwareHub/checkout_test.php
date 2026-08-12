<?php
session_start();
// Check if user is logged in for the PHP side
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Stripe JS v3 -->
    <script src="https://js.stripe.com/v3/"></script>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Poppins:wght@600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            scroll-behavior: smooth;
        }

        /* Modern Color Scheme */
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Header */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow-md);
            border-bottom: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0.9rem 2rem;
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

        .nav-links {
            display: flex;
            gap: 1.8rem;
            flex-wrap: wrap;
            list-style: none;
            align-items: center;
            margin: 0;
        }

        .nav-item {
            position: relative;
            list-style: none;
        }

        .nav-link {
            text-decoration: none;
            font-weight: 500;
            color: var(--gray-700);
            transition: all 0.2s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            padding: 0.5rem 0;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary);
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
            background: var(--gray-100);
            border: none;
            padding: 0.45rem 1.2rem;
            border-radius: 40px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            color: var(--gray-700);
        }

        .auth-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            transition: transform 0.2s ease;
            color: var(--gray-700);
            text-decoration: none;
        }

        .cart-icon:hover {
            transform: scale(1.05);
            color: var(--primary);
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -16px;
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 7px;
            border-radius: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .hamburger {
            display: none;
            font-size: 1.8rem;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-700);
            transition: 0.2s;
        }

        .hamburger:hover {
            color: var(--primary);
        }

        .mobile-menu-panel {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 340px;
            height: 100%;
            background: white;
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

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-top: 1px solid var(--gray-200);
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
            color: var(--gray-800);
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
            color: var(--gray-600);
            text-decoration: none;
            margin-bottom: 0.6rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .footer-col a:hover {
            color: var(--primary);
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
            color: var(--gray-600);
            transition: all 0.2s ease;
        }

        .social-icons i:hover {
            color: var(--primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-200);
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        /* Checkout Container */
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Step Indicator */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .step {
            flex: 1;
            text-align: center;
            padding: 0.8rem;
            background: white;
            border-radius: 60px;
            color: var(--gray-600);
            font-weight: 600;
            border: 1px solid var(--gray-200);
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .step.active {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            box-shadow: var(--shadow-md);
        }

        .step.completed {
            background: var(--success);
            color: white;
            border-color: transparent;
        }

        /* Layout */
        .checkout-layout {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .left-section {
            flex: 1.5;
            min-width: 280px;
        }

        .right-section {
            flex: 1;
            min-width: 280px;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 28px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card h2 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid var(--gray-200);
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Address Card */
        .addresses-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .address-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: var(--gray-100);
            border-radius: 20px;
            border: 1px solid var(--gray-200);
            transition: all 0.2s;
        }

        .address-card:hover {
            border-color: var(--primary);
            background: white;
        }

        .address-details {
            flex: 1;
            font-size: 0.85rem;
            color: var(--gray-600);
            line-height: 1.5;
        }

        .address-name {
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 4px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.3rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin: 0.8rem 0;
        }

        .checkbox-group label {
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        /* Option Items */
        .option-group {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .option-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--gray-100);
            border-radius: 20px;
            border: 1px solid var(--gray-200);
            cursor: pointer;
            transition: all 0.2s;
        }

        .option-item:hover {
            background: white;
            border-color: var(--primary);
            transform: translateX(4px);
        }

        .option-item.selected {
            border-color: var(--primary);
            background: #eff6ff;
        }

        /* Promo Code */
        .promo-group {
            display: flex;
            gap: 0.8rem;
        }

        .promo-group input {
            flex: 1;
            padding: 0.75rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 60px;
            font-size: 0.85rem;
        }

        .promo-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Order Items */
        .order-items {
            max-height: 280px;
            overflow-y: auto;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 0.7rem 0;
            border-bottom: 1px solid var(--gray-200);
            font-size: 0.85rem;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .grand-total {
            font-weight: 800;
            font-size: 1.1rem;
            border-top: 2px solid var(--gray-200);
            margin-top: 0.5rem;
            padding-top: 0.8rem;
            color: var(--gray-800);
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.9rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            width: 100%;
            transition: all 0.2s;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:disabled {
            background: var(--gray-600);
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
            border: none;
            padding: 0.7rem 1.2rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: var(--gray-200);
            transform: translateY(-2px);
        }

        .guest-message {
            background: #fef3c7;
            padding: 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            text-align: center;
            margin-bottom: 1rem;
            color: #92400e;
        }

        .guest-message a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .guest-message a:hover {
            text-decoration: underline;
        }

        /* Stripe Payment Modal */
        .payment-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 10001;
        }

        .payment-modal-content {
            background: white;
            max-width: 480px;
            width: 90%;
            padding: 2rem;
            border-radius: 32px;
            box-shadow: var(--shadow-xl);
            animation: modalFadeIn 0.3s ease;
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

        .payment-modal-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--gray-800);
        }

        .modal-amount {
            font-size: 2.2rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin: 1rem 0;
        }

        /* Stripe Card Element styling */
        .stripe-card-container {
            margin: 1.5rem 0;
            padding: 0.8rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 16px;
            transition: all 0.2s;
        }

        .stripe-card-container:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .modal-buttons button {
            flex: 1;
            padding: 0.8rem;
            border-radius: 60px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-modal-cancel {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .btn-modal-cancel:hover {
            background: var(--gray-200);
            transform: translateY(-2px);
        }

        .btn-modal-confirm {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-modal-confirm:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-modal-confirm:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .payment-error {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 0.5rem;
            text-align: center;
        }

        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 50px;
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

        .back-to-top.show {
            opacity: 1;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
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
            .step-indicator {
                flex-direction: column;
            }
            .step {
                padding: 0.5rem;
            }
            .row-2 {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            .card {
                padding: 1rem;
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
                <li class="nav-item"><span class="nav-link"><i class="fas fa-box"></i> Products </span>
                    <div class="dropdown-menu"><a href="Categories.php">Categories</a><a
                            href="CompareProducts.php">Compare Products</a><a href="ProductDetails.php">Product
                            Details</a><a href="Products1.php">All Products</a></div>
                </li>
                <li class="nav-item"><span class="nav-link"><i class="fas fa-store"></i> Vendors </span>
                    <div class="dropdown-menu"><a href="Vendors.php">Vendors</a><a href="VendorsList.php">Vendors
                            List</a><a href="VendorsStore.php">Vendors Store</a><a href="VendorSettings.php">Vendors
                            Setting</a><a href="VendorDashboard.php">Vendors Dashboard</a><a
                            href="VendorProductsManagement.php">Vendors Products</a><a
                            href="VendorAddProducts.php">Vendors Add Products</a><a href="VendorReviews.php">Vendors
                            Reviews</a><a href="VendorOrders.php">Vendors Orders</a><a
                            href="VendorOrderDetails.php">Vendor Order Details</a></div>
                </li>
                <li class="nav-item"><span class="nav-link"><i class="fas fa-user"></i> Account </span>
                    <div class="dropdown-menu"><a href="MyAccount.php">My Account</a><a href="Profile.php">Profile</a><a
                            href="UserOrders.php">Orders</a><a href="UserOrderDetails.php">Order Details</a><a
                            href="Wishlist.php">Wishlist</a><a href="AddressBook.php">Address Book</a><a
                            href="PaymentMethods.php">Payment Methods</a><a href="Cart.php">Cart</a><a
                            href="Checkout.php">Checkout</a><a href="LogIn.php">Log In</a><a href="Logout.php">Log
                            Out</a><a href="Signup.php">Sign Up</a></div>
                </li>
                <li class="nav-item"><span class="nav-link"><i class="fas fa-headset"></i> Support </span>
                    <div class="dropdown-menu"><a href="ContactUs.php">Contact</a><a href="FAQ.php">FAQ</a><a
                            href="ShippingInfo.php">Shipping Info</a><a href="WarrantyInfo.php">Warranty Info</a><a
                            href="ReturnPolicy.php">Return Policy</a><a href="PrivacyPolicy.php">Privacy Policy</a><a
                            href="TermsofService.php">Terms of Service</a><a href="AboutUs.php">About Us</a><a
                            href="CookiePolicy.php">Cookie Policy</a><a href="VerifyEmail.php">Verify Email</a><a
                            href="Forgot.php">Forgot Password</a><a href="ResetPassword.php">Reset Password</a><a
                            href="OrderTracking.php">Order Tracking</a><a href="SupportTicket.php">Support Ticket</a>
                    </div>
                </li>
                <li class="nav-item"><a href="Blog.php" class="nav-link"><i class="fas fa-blog"></i> Blog</a></li>
                <li class="nav-item"><a href="BlogDetails.php" class="nav-link"><i class="fas fa-newspaper"></i> Blog
                        Details</a></li>
                <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span id="cartCountDisplay"
                        class="cart-count">0</span></li>
                <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i
                            class="fas fa-key"></i> Login</button></li>
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

    <div class="checkout-container">
        <div class="step-indicator">
            <div class="step completed"><i class="fas fa-shopping-cart"></i> Cart</div>
            <div class="step active"><i class="fas fa-truck"></i> Shipping & Payment</div>
            <div class="step"><i class="fas fa-check-circle"></i> Confirmation</div>
        </div>

        <div class="checkout-layout">
            <div class="left-section">
                <div class="card">
                    <h2><i class="fas fa-location-dot" style="color: var(--primary);"></i> Shipping Address</h2>
                    <div id="guestMessage" class="guest-message"><i class="fas fa-info-circle"></i> <a href="#"
                            id="loginLink">Login</a> or <a href="#" id="registerLink">Register</a> to save your address
                        for future orders</div>
                    <div id="addressesList" class="addresses-list"></div>
                    <div id="newAddressForm" style="margin-top:1rem;">
                        <h3 style="font-size:0.9rem; font-weight:600; margin-bottom:0.8rem; color:var(--gray-800);"><i
                                class="fas fa-plus-circle"></i> Add New Address</h3>
                        <div class="row-2">
                            <div class="form-group"><input type="text" id="fullName" placeholder="Full Name *"></div>
                            <div class="form-group"><input type="tel" id="phone" placeholder="Phone Number *"></div>
                        </div>
                        <div class="form-group"><input type="text" id="addressLine" placeholder="Address Line *"></div>
                        <div class="row-2">
                            <div class="form-group"><input type="text" id="city" placeholder="City *"></div>
                            <div class="form-group"><input type="text" id="postalCode" placeholder="Postal Code *">
                            </div>
                        </div>
                        <div class="form-group">
                            <select id="country">
                                <option value="Pakistan">Pakistan</option>
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="United Kingdom">United Kingdom</option>
                            </select>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="saveAddressCheckbox">
                            <label><i class="fas fa-save"></i> Save this address for future</label>
                        </div>
                        <button id="addAddressBtn" class="btn-secondary" style="width:100%;"><i class="fas fa-plus"></i>
                            Add Address</button>
                    </div>
                </div>

                <div class="card">
                    <h2><i class="fas fa-truck-fast" style="color: var(--primary);"></i> Shipping Method</h2>
                    <div id="shippingOptions" class="option-group"></div>
                </div>

                <div class="card">
                    <h2><i class="fas fa-credit-card" style="color: var(--primary);"></i> Payment Method</h2>
                    <div id="paymentOptions" class="option-group"></div>
                </div>

                <div class="card">
                    <h2><i class="fas fa-ticket-alt" style="color: var(--primary);"></i> Promo Code</h2>
                    <div class="promo-group">
                        <input type="text" id="promoCode" placeholder="Enter promo code">
                        <button id="applyPromoBtn" class="btn-secondary"><i class="fas fa-gift"></i> Apply</button>
                    </div>
                    <div id="promoMessage" style="font-size:0.75rem; margin-top:0.5rem; color:var(--success);"></div>
                </div>

                <div class="card">
                    <h2><i class="fas fa-pencil-alt" style="color: var(--primary);"></i> Order Notes</h2>
                    <textarea id="orderNotes" rows="2" placeholder="Special instructions for delivery..."
                        style="width:100%; padding:0.8rem; border:1.5px solid var(--gray-200); border-radius:16px; font-family:inherit; resize:vertical;"></textarea>
                </div>
            </div>

            <div class="right-section">
                <div class="card">
                    <h2><i class="fas fa-receipt" style="color: var(--primary);"></i> Order Summary</h2>
                    <div id="orderItemsList" class="order-items"></div>
                    <div id="orderSummary"></div>
                    <button id="placeOrderBtn" class="btn-primary"><i class="fab fa-stripe"></i> Pay with Stripe</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stripe Payment Modal -->
    <div id="paymentModal" class="payment-modal">
        <div class="payment-modal-content">
            <i class="fab fa-stripe"
                style="font-size: 3rem; background: linear-gradient(135deg, #635bff, #00d4ff); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: 0.5rem;"></i>
            <h3>Secure Payment</h3>
            <p style="color: var(--gray-600);">Enter your card details to complete payment</p>
            <div class="modal-amount" id="modalTotalAmount">$0.00</div>
            
            <!-- Stripe Card Element -->
            <div id="cardElementContainer" class="stripe-card-container"></div>
            <div id="paymentError" class="payment-error"></div>
            
            <div class="modal-buttons">
                <button id="modalCancelBtn" class="btn-modal-cancel"><i class="fas fa-times"></i> Cancel</button>
                <button id="modalConfirmBtn" class="btn-modal-confirm"><i class="fas fa-lock"></i> Pay Now</button>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Quick Links</h4>
                <a href="AboutUs.php">About Us</a>
                <a href="ContactUs.php">Contact Support</a>
                <a href="OrderTracking.php">Track Order</a>
                <a href="ReturnPolicy.php">Return Policy</a>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <a href="AddressBook.php">Address Book</a>
                <a href="Blog.php">Tech Blog</a>
                <a href="Forgot.php">Forgot Password</a>
                <a href="FAQ.php">FAQ</a>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p><i class="fas fa-phone-alt"></i> 03267322096</p>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
                <div class="social-icons"><i class="fab fa-facebook-f"></i> <i class="fab fa-twitter"></i> <i
                        class="fab fa-instagram"></i> <i class="fab fa-youtube"></i></div>
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
        // ========== STRIPE INTEGRATION ==========
        let stripe = null;
        let cardElement = null;
        let currentClientSecret = null;
        let isProcessingPayment = false;
        
        // IMPORTANT: Replace with your Stripe Publishable Key
        // Get from: https://dashboard.stripe.com/apikeys
        const stripePublishableKey = 'pk_test_51TZuSUIV7gn69ZmehAdUCq9OYt9WGjGXHzl4bpum03kwReULIrCzirUJQiM6DfkRZo32IGH98Q9D37sgPAbGrHUF00ZXRakUyz'; // ← REPLACE THIS
        
        // ========== NEW: CART COUNT FROM API (Using check_session.php) ==========
        
        // Global session variables
        let isUserLoggedIn = false;
        let isCustomerRole = false;
        let currentUserId = null;

        // Function to check session and user role using your check_session.php API
        async function checkUserSession() {
            try {
                const response = await fetch('check_session.php');
                const data = await response.json();
                
                // Your API returns user_id directly when logged in
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
            
            // First check if user is logged in and has customer role
            const sessionValid = await checkUserSession();
            
            if (sessionValid && isCustomerRole) {
                // User is logged in and is customer - fetch cart count from API
                try {
                    const response = await fetch('get_cart_count.php');
                    const data = await response.json();
                    
                    if (data.success) {
                        cartCountSpan.innerText = data.cart_count;
                        console.log('Cart count loaded:', data.cart_count);
                    } else {
                        cartCountSpan.innerText = "0";
                    }
                } catch (error) {
                    console.error('Error loading cart count:', error);
                    cartCountSpan.innerText = "0";
                }
            } else {
                // User is not logged in or not customer - show 0
                cartCountSpan.innerText = "0";
                console.log('Not showing cart count - logged in:', isUserLoggedIn, 'isCustomer:', isCustomerRole);
            }
        }

        // Update cart count function
        async function updateCartCountFromAPI() {
            await loadCartCountFromAPI();
        }

        // ============== GLOBAL VARIABLES ==============
        let savedAddresses = [];
        let selectedAddressId = null;
        let shippingMethods = [];
        let selectedShippingId = null;
        let paymentMethods = [];
        let selectedPaymentId = null;
        let cartSummary = null;
        let appliedDiscount = 0;
        let appliedPromoCode = null;
        let currentSubtotal = 0;
        let currentShippingCost = 0;
        let isProcessing = false;

        const defaultPaymentMethods = [
            { payment_id: "cod", card_type: "Cash on Delivery", card_last4: "", expiry_month: "", expiry_year: "", is_default: 0 },
            { payment_id: "bank", card_type: "Bank Transfer", card_last4: "", expiry_month: "", expiry_year: "", is_default: 0 },
            { payment_id: "easypaisa", card_type: "EasyPaisa / JazzCash", card_last4: "", expiry_month: "", expiry_year: "", is_default: 0 }
        ];

        // ============== HELPER FUNCTIONS ==============
        function showAlert(message, isError = true) {
            const alertDiv = document.createElement('div');
            alertDiv.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            alertDiv.style.cssText = `
                position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
                background: ${isError ? '#ef4444' : '#10b981'}; color: white;
                padding: 12px 24px; border-radius: 60px; z-index: 10000;
                font-size: 14px; animation: fadeInOut 3s ease forwards; font-weight:500;
            `;
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
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

        // ============== STRIPE FUNCTIONS ==============
        function initializeStripe() {
            if (stripePublishableKey && stripePublishableKey !== 'pk_test_51TZuSUIV7gn69ZmehAdUCq9OYt9WGjGXHzl4bpum03kwReULIrCzirUJQiM6DfkRZo32IGH98Q9D37sgPAbGrHUF00ZXRakUyz') {
                stripe = Stripe(stripePublishableKey);
                console.log('Stripe initialized');
            } else {
                console.warn('Please set your Stripe publishable key');
            }
        }

        function createCardElement() {
            if (!stripe) return null;
            
            const elements = stripe.elements();
            const style = {
                base: {
                    fontSize: '16px',
                    fontFamily: '"Inter", system-ui, -apple-system, sans-serif',
                    color: '#1e293b',
                    '::placeholder': {
                        color: '#94a3b8'
                    }
                },
                invalid: {
                    color: '#ef4444',
                    iconColor: '#ef4444'
                }
            };
            
            cardElement = elements.create('card', { style: style });
            const container = document.getElementById('cardElementContainer');
            if (container) {
                cardElement.mount('#cardElementContainer');
                
                cardElement.on('change', (event) => {
                    const errorDiv = document.getElementById('paymentError');
                    if (event.error) {
                        errorDiv.textContent = event.error.message;
                    } else {
                        errorDiv.textContent = '';
                    }
                });
            }
            return cardElement;
        }

        async function createPaymentIntent() {
            try {
                const response = await fetch('create_payment_init.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                
                if (data.success) {
                    currentClientSecret = data.clientSecret;
                    return { success: true, clientSecret: data.clientSecret, amount: data.amount };
                } else {
                    showAlert(data.message || 'Failed to initialize payment', true);
                    return { success: false, error: data.message };
                }
            } catch (error) {
                console.error('Error creating payment intent:', error);
                showAlert('Network error. Please try again.', true);
                return { success: false, error: error.message };
            }
        }

        async function confirmStripePayment(clientSecret, orderData) {
            if (!stripe || !cardElement) {
                showAlert('Payment system not initialized', true);
                return false;
            }
            
            try {
                const result = await stripe.confirmCardPayment(clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: orderData.customer_name || 'Customer',
                        }
                    }
                });
                
                if (result.error) {
                    const errorDiv = document.getElementById('paymentError');
                    errorDiv.textContent = result.error.message;
                    showAlert(result.error.message, true);
                    return false;
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        console.log('Payment succeeded!');
                        return true;
                    }
                    return false;
                }
            } catch (error) {
                console.error('Payment confirmation error:', error);
                showAlert('Payment failed. Please try again.', true);
                return false;
            }
        }

        // ============== ADDRESS FUNCTIONS ==============
        async function checkLoginAndRedirect() {
            await checkUserSession();
            if (!isUserLoggedIn) {
                const addressContainer = document.getElementById("addressesList");
                const shippingContainer = document.getElementById("shippingOptions");
                const paymentContainer = document.getElementById("paymentOptions");
                const placeOrderBtn = document.getElementById("placeOrderBtn");

                if (addressContainer) addressContainer.innerHTML = '<div style="text-align:center; padding:1rem; color:#dc2626;"><i class="fas fa-exclamation-triangle"></i> Please login to view addresses</div>';
                if (shippingContainer) shippingContainer.innerHTML = '<div style="text-align:center; padding:1rem; color:#dc2626;"><i class="fas fa-exclamation-triangle"></i> Please login to continue</div>';
                if (paymentContainer) paymentContainer.innerHTML = '<div style="text-align:center; padding:1rem; color:#dc2626;"><i class="fas fa-exclamation-triangle"></i> Please login to continue</div>';
                if (placeOrderBtn) placeOrderBtn.disabled = true;
                showAlert("Please login first to continue checkout", true);
                return false;
            }
            return true;
        }

        async function loadAddresses() {
            await checkUserSession();
            if (!isUserLoggedIn) return;
            try {
                const response = await fetch('get_user_addresses.php');
                const result = await response.json();
                if (result.success && result.data) savedAddresses = result.data;
                else savedAddresses = [];
                renderAddresses();
            } catch (error) {
                savedAddresses = [];
                renderAddresses();
            }
        }

        function renderAddresses() {
            const container = document.getElementById("addressesList");
            if (!savedAddresses || savedAddresses.length === 0) {
                container.innerHTML = '<div style="text-align:center; padding:0.8rem; color:var(--gray-600);"><i class="fas fa-info-circle"></i> No saved addresses. Add a new address below.</div>';
                selectedAddressId = null;
                return;
            }
            container.innerHTML = savedAddresses.map(addr => `
                <div class="address-card" data-address-id="${addr.address_id}">
                    <input type="radio" name="selectedAddress" value="${addr.address_id}" ${selectedAddressId === addr.address_id ? 'checked' : ''}>
                    <div class="address-details">
                        <div class="address-name"><i class="fas fa-user"></i> ${escapeHtml(addr.full_name || 'Address')}</div>
                        <div><i class="fas fa-map-marker-alt"></i> ${escapeHtml(addr.address_line1 || '')}, ${escapeHtml(addr.city || '')}, ${escapeHtml(addr.postal_code || '')}, ${escapeHtml(addr.country || '')}</div>
                        <div><i class="fas fa-phone"></i> ${escapeHtml(addr.phone || '')}</div>
                        ${addr.is_default ? '<span style="color:#10b981; font-size:0.7rem;"><i class="fas fa-check-circle"></i> Default</span>' : ''}
                    </div>
                </div>
            `).join('');
            const defaultAddr = savedAddresses.find(addr => addr.is_default === 1);
            if (defaultAddr && !selectedAddressId) selectedAddressId = defaultAddr.address_id;
            else if (savedAddresses.length > 0 && !selectedAddressId) selectedAddressId = savedAddresses[0].address_id;
            if (selectedAddressId) {
                const radio = document.querySelector(`input[name="selectedAddress"][value="${selectedAddressId}"]`);
                if (radio) radio.checked = true;
            }
            document.querySelectorAll('input[name="selectedAddress"]').forEach(radio => {
                radio.addEventListener('change', (e) => { selectedAddressId = parseInt(e.target.value); });
            });
        }

        async function addNewAddress() {
            await checkUserSession();
            if (!isUserLoggedIn) { showAlert("Please login first to save address", true); window.location.href = "LogIn.php"; return; }
            const fullName = document.getElementById("fullName").value.trim();
            const phone = document.getElementById("phone").value.trim();
            const addressLine = document.getElementById("addressLine").value.trim();
            const city = document.getElementById("city").value.trim();
            const postalCode = document.getElementById("postalCode").value.trim();
            const country = document.getElementById("country").value;
            const saveForFuture = document.getElementById("saveAddressCheckbox").checked;
            if (!fullName || !phone || !addressLine || !city || !postalCode) { showAlert("Please fill all required fields", true); return; }
            try {
                const response = await fetch('add_user_address.php', {
                    method: 'POST', headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ fullname: fullName, phone_number: phone, address_line: addressLine, city: city, postal_code: postalCode, country: country, save_for_future: saveForFuture ? 'on' : 'off' })
                });
                const result = await response.json();
                if (result.success) {
                    showAlert("Address saved successfully!", false);
                    document.getElementById("fullName").value = "";
                    document.getElementById("phone").value = "";
                    document.getElementById("addressLine").value = "";
                    document.getElementById("city").value = "";
                    document.getElementById("postalCode").value = "";
                    document.getElementById("saveAddressCheckbox").checked = false;
                    await loadAddresses();
                } else { showAlert(result.message || "Failed to save address", true); }
            } catch (error) { showAlert("Failed to save address. Please try again.", true); }
        }

        // ============== SHIPPING FUNCTIONS ==============
        async function loadShippingMethods() {
            try {
                const response = await fetch('get_shipping_methods.php');
                const result = await response.json();
                if (result.success && result.data && result.data.length > 0) shippingMethods = result.data;
                else shippingMethods = [
                    { shipping_id: 1, method_name: "Standard Delivery", cost: 5.99, estimated_date: "3-5 Days" },
                    { shipping_id: 2, method_name: "Express Delivery", cost: 12.99, estimated_date: "1-2 Days" }
                ];
                if (shippingMethods.length > 0 && !selectedShippingId) {
                    selectedShippingId = shippingMethods[0].shipping_id;
                    currentShippingCost = shippingMethods[0].cost;
                }
                renderShippingOptions();
            } catch (error) {
                shippingMethods = [
                    { shipping_id: 1, method_name: "Standard Delivery", cost: 5.99, estimated_date: "3-5 Days" },
                    { shipping_id: 2, method_name: "Express Delivery", cost: 12.99, estimated_date: "1-2 Days" }
                ];
                selectedShippingId = 1;
                currentShippingCost = 5.99;
                renderShippingOptions();
            }
        }

        function renderShippingOptions() {
            const container = document.getElementById("shippingOptions");
            if (!shippingMethods || shippingMethods.length === 0) { container.innerHTML = '<div style="padding:0.8rem; color:var(--gray-600);"><i class="fas fa-info-circle"></i> No shipping methods available</div>'; return; }
            container.innerHTML = shippingMethods.map(method => `
                <div class="option-item ${selectedShippingId === method.shipping_id ? 'selected' : ''}" data-shipping-id="${method.shipping_id}">
                    <input type="radio" name="shipping" value="${method.shipping_id}" ${selectedShippingId === method.shipping_id ? 'checked' : ''}>
                    <div style="flex:1"><div><strong><i class="fas fa-truck"></i> ${escapeHtml(method.method_name)}</strong></div><div style="font-size:0.7rem; color:var(--gray-600);"><i class="fas fa-calendar-alt"></i> Est. delivery: ${escapeHtml(method.estimated_date)}</div></div>
                    <div><strong>$${parseFloat(method.cost).toFixed(2)}</strong></div>
                </div>
            `).join('');
            document.querySelectorAll('#shippingOptions .option-item').forEach(opt => {
                opt.addEventListener('click', () => {
                    selectedShippingId = parseInt(opt.dataset.shippingId);
                    const selectedMethod = shippingMethods.find(m => m.shipping_id === selectedShippingId);
                    currentShippingCost = selectedMethod ? parseFloat(selectedMethod.cost) : 0;
                    renderShippingOptions();
                    updateOrderSummaryDisplay();
                });
            });
        }

        // ============== PAYMENT FUNCTIONS ==============
        async function loadPaymentMethods() {
            await checkUserSession();
            if (!isUserLoggedIn) return;
            try {
                const response = await fetch('get_user_payment_methods.php');
                const result = await response.json();
                if (result.success && result.data && result.data.length > 0) paymentMethods = result.data;
                else paymentMethods = [...defaultPaymentMethods];
                const defaultMethod = paymentMethods.find(m => m.is_default === 1);
                if (defaultMethod && !selectedPaymentId) selectedPaymentId = defaultMethod.payment_id;
                else if (paymentMethods.length > 0 && !selectedPaymentId) selectedPaymentId = paymentMethods[0].payment_id;
                renderPaymentOptions();
            } catch (error) {
                paymentMethods = [...defaultPaymentMethods];
                selectedPaymentId = "cod";
                renderPaymentOptions();
            }
        }

        function renderPaymentOptions() {
            const container = document.getElementById("paymentOptions");
            if (!paymentMethods || paymentMethods.length === 0) { container.innerHTML = '<div style="padding:0.8rem; color:var(--gray-600);"><i class="fas fa-info-circle"></i> No payment methods available</div>'; return; }
            container.innerHTML = paymentMethods.map(method => {
                let displayName = method.card_type;
                if (method.card_last4) displayName = `${method.card_type} •••• ${method.card_last4}`;
                if (method.expiry_month && method.expiry_year) displayName += ` (${method.expiry_month}/${method.expiry_year})`;
                let icon = '<i class="fas fa-credit-card"></i>';
                if (method.card_type === "Cash on Delivery") icon = '<i class="fas fa-money-bill-wave"></i>';
                if (method.card_type === "Bank Transfer") icon = '<i class="fas fa-university"></i>';
                if (method.card_type === "EasyPaisa / JazzCash") icon = '<i class="fas fa-mobile-alt"></i>';
                return `<div class="option-item ${selectedPaymentId === (method.payment_id || method.id) ? 'selected' : ''}" data-payment-id="${method.payment_id || method.id}">
                    <input type="radio" name="payment" value="${method.payment_id || method.id}" ${selectedPaymentId === (method.payment_id || method.id) ? 'checked' : ''}>
                    <div><strong>${icon} ${escapeHtml(displayName)}</strong></div>
                    ${method.is_default ? '<span style="color:#10b981; font-size:0.7rem;"><i class="fas fa-check-circle"></i> Default</span>' : ''}
                </div>`;
            }).join('');
            document.querySelectorAll('#paymentOptions .option-item').forEach(opt => {
                opt.addEventListener('click', () => { selectedPaymentId = opt.dataset.paymentId; renderPaymentOptions(); });
            });
        }

        // ============== CART FUNCTIONS ==============
        async function loadCartSummary() {
            try {
                const response = await fetch('get_cart_summary.php');
                const result = await response.json();
                if (result.success && result.data) {
                    cartSummary = result.data;
                    currentSubtotal = cartSummary.subtotal || 0;
                    renderOrderItems();
                    updateOrderSummaryDisplay();
                } else {
                    cartSummary = { items: [], subtotal: 0 };
                    renderOrderItems();
                    updateOrderSummaryDisplay();
                }
            } catch (error) {
                cartSummary = { items: [], subtotal: 0 };
                renderOrderItems();
                updateOrderSummaryDisplay();
            }
        }

        function renderOrderItems() {
            const container = document.getElementById("orderItemsList");
            if (!cartSummary || !cartSummary.items || cartSummary.items.length === 0) {
                container.innerHTML = '<div style="text-align:center; padding:1rem; color:var(--gray-600);"><i class="fas fa-shopping-cart"></i> Your cart is empty</div>';
                return;
            }
            container.innerHTML = cartSummary.items.map(item => `<div class="order-item"><span><i class="fas fa-box"></i> ${escapeHtml(item.name)} x${item.quantity}</span><span>$${parseFloat(item.subtotal || (item.price * item.quantity)).toFixed(2)}</span></div>`).join('');
        }

        function updateOrderSummaryDisplay() {
            const subtotal = currentSubtotal;
            const shippingCost = currentShippingCost;
            const tax = subtotal * 0.09;
            const discount = appliedDiscount;
            let grandTotal = subtotal + shippingCost + tax - discount;
            if (grandTotal < 0) grandTotal = 0;
            document.getElementById("orderSummary").innerHTML = `
                <div class="summary-row"><span>Subtotal</span><span>$${subtotal.toFixed(2)}</span></div>
                <div class="summary-row"><span>Shipping</span><span>$${shippingCost.toFixed(2)}</span></div>
                <div class="summary-row"><span>Tax (9%)</span><span>$${tax.toFixed(2)}</span></div>
                ${discount > 0 ? `<div class="summary-row"><span>Discount</span><span>-$${discount.toFixed(2)}</span></div>` : ''}
                <div class="summary-row grand-total"><span>Grand Total</span><span>$${grandTotal.toFixed(2)}</span></div>
            `;
            return grandTotal;
        }

        async function applyPromoCode() {
            const code = document.getElementById("promoCode").value.trim().toUpperCase();
            if (!code) { showAlert("Please enter a promo code", true); return; }
            try {
                const response = await fetch('apply_promo_code.php', {
                    method: 'POST', headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ promo_code: code, subtotal: currentSubtotal })
                });
                const result = await response.json();
                if (result.success && result.data) {
                    appliedDiscount = result.data.discount_amount || 0;
                    appliedPromoCode = code;
                    document.getElementById("promoMessage").innerHTML = `<i class="fas fa-check-circle"></i> ${result.message} You saved $${appliedDiscount.toFixed(2)}`;
                    updateOrderSummaryDisplay();
                } else {
                    document.getElementById("promoMessage").innerHTML = `<i class="fas fa-times-circle"></i> ${result.message}`;
                    appliedDiscount = 0;
                    appliedPromoCode = null;
                    updateOrderSummaryDisplay();
                }
            } catch (error) { showAlert("Failed to apply promo code", true); }
        }

        // ============== ORDER PLACEMENT WITH STRIPE ==============
        async function openStripePaymentModal() {
            await checkUserSession();
            if (isProcessingPayment) return;
            if (!isUserLoggedIn) { showAlert("Please login first to place order", true); window.location.href = "LogIn.php"; return; }
            if (!selectedAddressId) { showAlert("Please select a shipping address", true); return; }
            if (!selectedShippingId) { showAlert("Please select a shipping method", true); return; }
            if (!cartSummary || !cartSummary.items || cartSummary.items.length === 0) { showAlert("Your cart is empty", true); return; }

            // Create payment intent first
            const paymentIntentResult = await createPaymentIntent();
            if (!paymentIntentResult.success) {
                return;
            }
            
            // Create card element if not exists
            if (!cardElement) {
                createCardElement();
            }
            
            const grandTotal = updateOrderSummaryDisplay();
            document.getElementById("modalTotalAmount").innerText = `$${grandTotal.toFixed(2)}`;
            document.getElementById("paymentModal").style.display = "flex";
            document.getElementById("paymentError").textContent = "";
            
            // Store order data for after payment
            window.pendingOrderData = {
                address_id: selectedAddressId,
                payment_method: "stripe",
                shipping_method_id: selectedShippingId,
                promo_code: appliedPromoCode || null,
                order_notes: document.getElementById("orderNotes").value || null,
                stripe_payment_intent_id: paymentIntentResult.clientSecret ? paymentIntentResult.clientSecret.split('_secret')[0] : null
            };
        }

        async function processStripePayment() {
            if (isProcessingPayment) return;
            
            const confirmBtn = document.getElementById("modalConfirmBtn");
            const originalText = confirmBtn.innerHTML;
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Processing...';
            confirmBtn.disabled = true;
            isProcessingPayment = true;
            
            try {
                // Get customer name from selected address
                const selectedAddress = savedAddresses.find(addr => addr.address_id === selectedAddressId);
                const customerName = selectedAddress ? selectedAddress.full_name : 'Customer';
                
                const paymentSuccess = await confirmStripePayment(currentClientSecret, {
                    customer_name: customerName
                });
                
                if (paymentSuccess) {
                    showAlert("Payment successful! Placing your order...", false);
                    closePaymentModal();
                    
                    // Place the order after successful payment
                    await executeOrderPlacement(window.pendingOrderData);
                } else {
                    confirmBtn.innerHTML = originalText;
                    confirmBtn.disabled = false;
                    isProcessingPayment = false;
                }
            } catch (error) {
                console.error('Payment processing error:', error);
                showAlert("Payment failed. Please try again.", true);
                confirmBtn.innerHTML = originalText;
                confirmBtn.disabled = false;
                isProcessingPayment = false;
            }
        }

        async function executeOrderPlacement(orderData) {
            if (isProcessing) return;
            isProcessing = true;
            
            try {
                const response = await fetch('place_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(orderData)
                });
                const result = await response.json();

                if (result.success) {
                    showAlert("Order placed successfully!", false);
                    localStorage.removeItem("cart");
                    window.location.href = `OrderConfirmation.php?order_id=${result.order_id}`;
                } else {
                    showAlert(result.message || "Failed to place order", true);
                    isProcessing = false;
                }
            } catch (error) {
                showAlert("Failed to place order. Please contact support.", true);
                isProcessing = false;
            }
        }

        function closePaymentModal() {
            document.getElementById("paymentModal").style.display = "none";
            const errorDiv = document.getElementById("paymentError");
            if (errorDiv) errorDiv.textContent = "";
        }

        // ============== AUTH FUNCTIONS ==============
        async function setAuthUI() {
            await checkUserSession();
            const authBtn = document.getElementById("authButton");
            if (!authBtn) return;
            authBtn.innerHTML = isUserLoggedIn ? '<i class="fas fa-sign-out-alt"></i> Logout' : '<i class="fas fa-sign-in-alt"></i> Login';
            renderMobileMenu();
        }

        function handleAuthClick() {
            if (isUserLoggedIn) {
                window.location.href = "Logout.php";
            } else {
                window.location.href = "LogIn.php";
            }
        }

        // ============== MOBILE MENU ==============
        function renderMobileMenu() {
            const container = document.getElementById("mobileMenuContent");
            if (!container) return;
            const logged = isUserLoggedIn;
            const menuItems = [
                { title: "Home", link: "FYPHome.php" },
                { title: "Products", submenu: ["Categories", "Compare Products", "Product Details", "All Products"], links: ["Categories.php", "CompareProducts.php", "ProductDetails.php", "Products1.php"] },
                { title: "Vendors", submenu: ["Vendors List", "Vendors Store", "Vendors Setting", "Vendors Dashboard", "Vendors Products", "Vendors Add Products", "Vendors Reviews", "Vendors Orders"], links: ["Vendors.php", "VendorsStore.php", "VendorSettings.php", "VendorDashboard.php", "VendorProductsManagement.php", "VendorAddProducts.php", "VendorReviews.php", "VendorOrders.php"] },
                { title: "Account", submenu: ["My Account", "Profile", "Orders", "Wishlist", "Address Book", "Payment Methods", "Cart", "Checkout"], links: ["MyAccount.php", "Profile.php", "UserOrders.php", "Wishlist.php", "AddressBook.php", "PaymentMethods.php", "Cart.php", "Checkout.php"] },
                { title: "Support", submenu: ["Contact", "FAQ", "Shipping Info", "Return Policy", "Privacy Policy", "Terms of Service"], links: ["ContactUs.php", "FAQ.php", "ShippingInfo.php", "ReturnPolicy.php", "TermsofService.php"] },
                { title: "Blog", link: "Blog.php" },
                { title: "Blog Details", link: "BlogDetails.php" }
            ];
            let html = `<div style="margin-top:1rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%;">${logged ? "<i class='fas fa-sign-out-alt'></i> Logout" : "<i class='fas fa-sign-in-alt'></i> Login"}</button></div><hr style="margin:1rem 0;">`;
            menuItems.forEach(item => {
                if (item.submenu) {
                    html += `<div class="mobile-nav-item"><div class="mobile-nav-header" data-toggle="${item.title}" style="display:flex; justify-content:space-between; padding:0.8rem 0;"><span>${item.title}</span> <i class="fas fa-chevron-down"></i></div><div class="mobile-submenu" id="submenu-${item.title}" style="padding-left:1rem; display:none;">`;
                    item.submenu.forEach((sub, idx) => { html += `<a href="${item.links[idx]}">${sub}</a>`; });
                    html += `</div></div>`;
                } else { html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0;">${item.title}</a></div>`; }
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

        // ============== EVENT LISTENERS ==============
        document.getElementById("addAddressBtn")?.addEventListener("click", addNewAddress);
        document.getElementById("applyPromoBtn")?.addEventListener("click", applyPromoCode);
        document.getElementById("placeOrderBtn")?.addEventListener("click", openStripePaymentModal);
        document.getElementById("modalCancelBtn")?.addEventListener("click", closePaymentModal);
        document.getElementById("modalConfirmBtn")?.addEventListener("click", processStripePayment);
        window.addEventListener("click", (e) => { const modal = document.getElementById("paymentModal"); if (e.target === modal) closePaymentModal(); });
        document.getElementById("loginLink")?.addEventListener("click", (e) => { e.preventDefault(); window.location.href = "LogIn.php"; });
        document.getElementById("registerLink")?.addEventListener("click", (e) => { e.preventDefault(); window.location.href = "Signup.php"; });
        document.querySelector('.cart-icon')?.addEventListener('click', () => { window.location.href = "Cart.php"; });

        // Back to top
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => { if (window.scrollY > 300) backBtn.classList.add("show"); else backBtn.classList.remove("show"); });
        backBtn?.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // Auth button
        document.getElementById("authButton")?.addEventListener("click", handleAuthClick);

        // Mobile menu
        const hamburgerBtn = document.getElementById("hamburgerBtn");
        const mobileMenuPanel = document.getElementById("mobileMenuPanel");
        const mobileOverlay = document.getElementById("mobileOverlay");
        function openMobile() { mobileMenuPanel?.classList.add("open"); mobileOverlay?.classList.add("show"); }
        function closeMobile() { mobileMenuPanel?.classList.remove("open"); mobileOverlay?.classList.remove("show"); }
        hamburgerBtn?.addEventListener("click", openMobile);
        document.getElementById("closeMobileBtn")?.addEventListener("click", closeMobile);
        mobileOverlay?.addEventListener("click", closeMobile);

        // ============== INITIALIZE PAGE ==============
        async function init() {
            // Initialize Stripe
            initializeStripe();
            
            await checkUserSession();
            await setAuthUI();
            renderMobileMenu();
            await updateCartCountFromAPI();
            if (!await checkLoginAndRedirect()) return;
            await loadAddresses();
            await loadShippingMethods();
            await loadPaymentMethods();
            await loadCartSummary();
        }
        init();
    </script>
</body>

</html>