<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Order Confirmation</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">
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

        /* Confirmation Container */
        .confirmation-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Success Section */
        .success-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .success-icon {
            font-size: 4rem;
            background: var(--success);
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 20px -6px rgba(16, 185, 129, 0.4);
        }

        .success-section h1 {
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #2563EB 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .order-number {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            background: #EFF6FF;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 0.4rem 1.2rem;
            border-radius: 60px;
            margin-top: 0.5rem;
        }

        /* Cards - White */
        .card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        th,
        td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }

        th {
            color: #6B7280;
            font-weight: 600;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            background: #F3F4F6;
            border-radius: 10px;
        }

        .product-name {
            font-weight: 600;
            color: #111827;
        }

        .product-sku {
            font-size: 0.7rem;
            color: #6B7280;
        }

        /* Summary */
        .summary-box {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .summary-table {
            width: 280px;
        }

        .summary-table td {
            padding: 0.5rem;
            border-bottom: none;
        }

        .summary-table td:last-child {
            text-align: right;
        }

        .grand-total {
            font-weight: 800;
            font-size: 1rem;
            border-top: 2px solid #E5E7EB;
            color: #111827;
        }

        /* Address Grid */
        .address-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
        }

        .address-item {
            font-size: 0.85rem;
            line-height: 1.6;
            color: #6B7280;
        }

        .address-item strong {
            color: #111827;
        }

        .delivery-date {
            background: #F3F4F6;
            padding: 0.8rem 1.2rem;
            border-radius: 20px;
            text-align: center;
            margin-top: 0.5rem;
            color: #374151;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.8rem;
            border-radius: 60px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-pending {
            background: #FEF3C7;
            color: #D97706;
        }

        .status-processing {
            background: #DBEAFE;
            color: var(--primary);
        }

        .status-completed {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: var(--danger);
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.75rem 1.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary {
            background: #F3F4F6;
            color: #374151;
            border: none;
            padding: 0.75rem 1.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        /* Share Dropdown */
        .share-dropdown {
            position: relative;
            display: inline-block;
        }

        .share-menu {
            display: none;
            position: absolute;
            bottom: 100%;
            left: 0;
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
            min-width: 170px;
            z-index: 10;
            margin-bottom: 0.5rem;
            border: 1px solid #E5E7EB;
        }

        .share-menu.show {
            display: block;
            animation: slideUp 0.2s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .share-menu button {
            display: block;
            width: 100%;
            padding: 0.6rem;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            border-radius: 12px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .share-menu button:hover {
            background: #F3F4F6;
            color: var(--primary);
        }

        .email-message {
            background: #F3F4F6;
            padding: 0.8rem 1.2rem;
            border-radius: 20px;
            text-align: center;
            font-size: 0.85rem;
            color: #374151;
        }

        .loading-spinner {
            text-align: center;
            padding: 2rem;
            color: var(--primary);
        }

        .error-message {
            text-align: center;
            padding: 2rem;
            color: var(--danger);
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
        }

        .back-to-top.show {
            opacity: 1;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
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
            .summary-box {
                justify-content: flex-start;
            }

            .product-cell {
                flex-direction: column;
                align-items: flex-start;
            }

            .success-section h1 {
                font-size: 1.4rem;
            }

            .btn-group {
                gap: 0.75rem;
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
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span
                        id="cartCountDisplay" class="cart-count">0</span></li>
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

    <div class="confirmation-container">
        <div class="success-section">
            <div class="success-icon"><i class="fas fa-check"></i></div>
            <h1>Thank you! Your order has been placed successfully.</h1>
            <div class="order-number" id="orderNumber"><i class="fas fa-receipt"></i> Loading...</div>
        </div>

        <div class="card">
            <h2><i class="fas fa-list-alt" style="color: var(--primary);"></i> Order Summary</h2>
            <div class="table-responsive">
                <table id="orderItemsTable">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="orderItemsBody"></tbody>
                </table>
            </div>
            <div class="summary-box" id="summaryBox"></div>
        </div>

        <div class="card" id="paymentDetailsCard">
            <h2><i class="fas fa-credit-card" style="color: var(--primary);"></i> Payment Details</h2>
            <div id="paymentDetails"></div>
        </div>

        <div class="card">
            <h2><i class="fas fa-location-dot" style="color: var(--primary);"></i> Shipping Address</h2>
            <div id="shippingAddress" class="address-grid"></div>
        </div>

        <div class="card" id="deliveryCard">
            <h2><i class="fas fa-truck-fast" style="color: var(--primary);"></i> Estimated Delivery</h2>
            <div id="deliveryInfo" class="delivery-date"></div>
        </div>

        <div class="card">
            <div class="email-message" id="emailMessage"><i class="fas fa-envelope"></i> Loading confirmation details...
            </div>
        </div>

        <div class="btn-group">
            <button class="btn-primary" id="continueShoppingBtn"><i class="fas fa-shopping-bag"></i> Continue
                Shopping</button>
            <button class="btn-secondary" id="viewOrderBtn"><i class="fas fa-file-invoice"></i> View Order
                Details</button>
            <div class="share-dropdown">
                <button class="btn-secondary" id="shareBtn"><i class="fas fa-share-alt"></i> Share Purchase</button>
                <div class="share-menu" id="shareMenu">
                    <button id="copyLinkBtn"><i class="fas fa-copy"></i> Copy Link</button>
                    <button id="facebookShareBtn"><i class="fab fa-facebook-f"></i> Share on Facebook</button>
                    <button id="twitterShareBtn"><i class="fab fa-twitter"></i> Share on Twitter</button>
                </div>
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
                <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="FAQ.php">FAQs</a>
                <a href="PaymentMethods.php">Payment Methods</a>
            </div>
            <div class="footer-col">
                <h4>Contact Info</h4>
                <p><i class="fas fa-phone-alt"></i> 03267322096</p>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
                <div class="social-icons"><i class="fab fa-facebook-f"></i><i class="fab fa-twitter"></i><i
                        class="fab fa-instagram"></i><i class="fab fa-youtube"></i></div>
            </div>
            <div class="footer-col">
                <h4>Our Motto</h4>
                <p>⚡ Power Your Passion, Build Without Limits.</p>
                <p>© 2026 Global Hardware Hub</p>
            </div>
        </div>
        <div class="copyright">Global Hardware Hub | The Ultimate Computer Hardware Marketplace</div>
    </footer>

    <button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i> Top</button>

    <script>
        // ========== CART COUNT FROM API ==========

        // Global session variables
        let isUserLoggedIn = false;
        let isCustomerRole = false;
        let currentUserId = null;

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

        // ============== GLOBAL VARIABLES ==============
        let orderData = null;
        let currentOrderId = null;

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

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function getStatusBadgeClass(status) {
            const statusLower = (status || '').toLowerCase();
            if (statusLower === 'pending') return 'status-pending';
            if (statusLower === 'processing') return 'status-processing';
            if (statusLower === 'completed' || statusLower === 'delivered') return 'status-completed';
            if (statusLower === 'cancelled') return 'status-cancelled';
            return 'status-pending';
        }

        function getStatusText(status) {
            const statusLower = (status || '').toLowerCase();
            if (statusLower === 'pending') return 'Pending';
            if (statusLower === 'processing') return 'Processing';
            if (statusLower === 'completed') return 'Completed';
            if (statusLower === 'delivered') return 'Delivered';
            if (statusLower === 'cancelled') return 'Cancelled';
            return status || 'Pending';
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

        // ============== GET ORDER ID FROM URL ==============
        function getOrderIdFromURL() {
            const params = new URLSearchParams(window.location.search);
            const orderId = params.get('order_id');

            if (!orderId || isNaN(orderId) || parseInt(orderId) <= 0) {
                showAlert('Invalid Order ID', true);
                setTimeout(() => {
                    window.location.href = 'Checkout.php';
                }, 2000);
                return null;
            }
            return parseInt(orderId);
        }

        // ============== FETCH ORDER DATA ==============
        async function fetchOrderData(orderId) {
            try {
                const response = await fetch(`get_order_confirmation.php?order_id=${orderId}`);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.message || 'Failed to load order');
                }

                return result;
            } catch (error) {
                console.error('Fetch error:', error);
                throw error;
            }
        }

        // ============== RENDER FUNCTIONS ==============
        function renderOrderNumber(order) {
            const orderNumberEl = document.getElementById('orderNumber');
            const statusClass = getStatusBadgeClass(order.status);
            const statusText = getStatusText(order.status);
            orderNumberEl.innerHTML = `<i class="fas fa-receipt"></i> Order #${order.order_id} <span class="status-badge ${statusClass}">${statusText}</span>`;
        }

        function renderOrderItems(items) {
            const tbody = document.getElementById('orderItemsBody');

            if (!items || items.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; color:#6B7280;"><i class="fas fa-inbox"></i> No order items found</div></tr>';
                return 0;
            }

            let subtotal = 0;

            tbody.innerHTML = items.map(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                return `
                <tr>
                    <td>
                        <div class="product-cell">
                            <img src="${escapeHtml(item.image_url || 'placeholder.jpg')}" alt="${escapeHtml(item.name)}" class="product-img" onerror="this.src='https://placehold.co/50x50/2563eb/white?text=Product'">
                            <div>
                                <div class="product-name">${escapeHtml(item.name)}</div>
                                <div class="product-sku"><i class="fas fa-barcode"></i> SKU: ${escapeHtml(item.sku || 'N/A')}</div>
                                <div class="product-sku"><i class="fas fa-store"></i> Vendor ID: ${item.vendor_id || 1}</div>
                            </div>
                        </div>
                     </div>
                    <td>${item.quantity}</div>
                    <td>PKR ${parseFloat(item.price).toFixed(2)}</div>
                    <td>PKR ${itemTotal.toFixed(2)}</div>
                </tr>
            `;
            }).join('');

            return subtotal;
        }

        function renderOrderSummary(order, subtotal) {
            const summaryBox = document.getElementById('summaryBox');
            const tax = parseFloat(order.total_amount) - subtotal;

            let summaryHtml = `
            <table class="summary-table">
                <tr><td class="info-label">Subtotal:</div><td>$${subtotal.toFixed(2)}</div></tr>
                <tr><td class="info-label">Tax:</div><td>$${tax.toFixed(2)}</div></tr>
        `;

            if (order.coupon_code) {
                summaryHtml += `<tr><td class="info-label">Coupon (${escapeHtml(order.coupon_code)}):</div><td>-$0.00</div></tr>`;
            }

            summaryHtml += `
                <tr class="grand-total"><td><strong>Grand Total:</strong></td><td><strong>$${parseFloat(order.total_amount).toFixed(2)}</strong></div></tr>
            </table>
        `;

            summaryBox.innerHTML = summaryHtml;
        }

        function renderPaymentDetails(payment, order) {
            const container = document.getElementById('paymentDetails');
            const card = document.getElementById('paymentDetailsCard');

            if (!payment && !order.payment_method) {
                card.style.display = 'none';
                return;
            }

            card.style.display = 'block';

            const paymentMethod = payment?.payment_method || order.payment_method || 'N/A';
            const paymentAmount = payment?.amount || order.total_amount;
            const paymentStatus = payment?.status || 'Pending';
            const paymentDate = payment?.created_at || order.created_at;

            container.innerHTML = `
            <div class="address-grid">
                <div class="address-item">
                    <strong><i class="fas fa-credit-card"></i> Payment Method:</strong><br>
                    ${escapeHtml(paymentMethod)}
                </div>
                <div class="address-item">
                    <strong><i class="fas fa-dollar-sign"></i> Amount Paid:</strong><br>
                    $${parseFloat(paymentAmount).toFixed(2)}
                </div>
                <div class="address-item">
                    <strong><i class="fas fa-chart-line"></i> Payment Status:</strong><br>
                    <span class="status-badge ${getStatusBadgeClass(paymentStatus)}">${getStatusText(paymentStatus)}</span>
                </div>
                <div class="address-item">
                    <strong><i class="fas fa-calendar"></i> Payment Date:</strong><br>
                    ${formatDate(paymentDate)}
                </div>
            </div>
        `;
        }

        function renderShippingAddress() {
            const container = document.getElementById('shippingAddress');
            container.innerHTML = `
            <div class="address-item">
                <i class="fas fa-info-circle"></i>
                <p>Shipping address details are available in your order details.</p>
                <p style="margin-top: 0.5rem;">Click "View Order Details" below to see full shipping information.</p>
            </div>
        `;
        }

        function renderDeliveryInfo(order) {
            const container = document.getElementById('deliveryInfo');
            const card = document.getElementById('deliveryCard');

            if (!order.created_at) {
                card.style.display = 'none';
                return;
            }

            card.style.display = 'block';

            const orderDate = new Date(order.created_at);
            const minDelivery = new Date(orderDate);
            minDelivery.setDate(orderDate.getDate() + 5);
            const maxDelivery = new Date(orderDate);
            maxDelivery.setDate(orderDate.getDate() + 10);

            container.innerHTML = `
            <i class="fas fa-calendar-week"></i> <strong>Standard Shipping</strong><br>
            Estimated Delivery: ${minDelivery.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })} - ${maxDelivery.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}
        `;
        }

        function renderEmailMessage() {
            const container = document.getElementById('emailMessage');
            container.innerHTML = `<i class="fas fa-envelope"></i> A confirmation email has been sent to <strong>your registered email address</strong> with your order details.`;
        }

        function showLoading() {
            const tbody = document.getElementById('orderItemsBody');
            tbody.innerHTML = '<tr><td colspan="4" class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading order details...</div></tr>';
        }

        function showError(message) {
            const tbody = document.getElementById('orderItemsBody');
            tbody.innerHTML = `<tr><td colspan="4" class="error-message"><i class="fas fa-exclamation-circle"></i> ${escapeHtml(message)}</div></td>`;
            showAlert(message, true);
        }

        // ============== MAIN LOAD FUNCTION ==============
        async function loadOrderConfirmation() {
            currentOrderId = getOrderIdFromURL();
            if (!currentOrderId) return;

            showLoading();

            try {
                const response = await fetchOrderData(currentOrderId);

                if (response.success) {
                    orderData = response;

                    renderOrderNumber(response.order);
                    const subtotal = renderOrderItems(response.items);
                    renderOrderSummary(response.order, subtotal);
                    renderPaymentDetails(response.payment, response.order);
                    renderShippingAddress();
                    renderDeliveryInfo(response.order);
                    renderEmailMessage();
                } else {
                    showError(response.message || 'Unable to load order details');
                }
            } catch (error) {
                console.error('Load order error:', error);
                showError('Unable to load order details. Please try again.');
            }
        }

        // ============== BUTTON EVENT HANDLERS ==============
        function setupEventListeners() {
            document.getElementById('continueShoppingBtn').addEventListener('click', () => {
                window.location.href = 'Products1.php';
            });

            document.getElementById('viewOrderBtn').addEventListener('click', () => {
                if (currentOrderId) {
                    window.location.href = `UserOrderDetails.php?order_id=${currentOrderId}`;
                } else {
                    showAlert('Order details not available', true);
                }
            });

            const shareBtn = document.getElementById('shareBtn');
            const shareMenu = document.getElementById('shareMenu');

            shareBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                shareMenu.classList.toggle('show');
            });

            document.addEventListener('click', (e) => {
                if (!shareBtn.contains(e.target) && !shareMenu.contains(e.target)) {
                    shareMenu.classList.remove('show');
                }
            });

            document.getElementById('copyLinkBtn').addEventListener('click', () => {
                const link = `${window.location.origin}${window.location.pathname}?order_id=${currentOrderId}`;
                navigator.clipboard.writeText(link);
                showAlert('Order link copied to clipboard!', false);
                shareMenu.classList.remove('show');
            });

            document.getElementById('facebookShareBtn').addEventListener('click', () => {
                const url = encodeURIComponent(`${window.location.origin}${window.location.pathname}?order_id=${currentOrderId}`);
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
                shareMenu.classList.remove('show');
            });

            document.getElementById('twitterShareBtn').addEventListener('click', () => {
                const url = encodeURIComponent(`${window.location.origin}${window.location.pathname}?order_id=${currentOrderId}`);
                const text = encodeURIComponent(`I just placed an order on Global Hardware Hub! 🛒`);
                window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
                shareMenu.classList.remove('show');
            });
        }

        // ============== LOGIN/LOGOUT FUNCTIONS ==============
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

        // Cart icon click
        document.querySelector('.cart-icon')?.addEventListener('click', async () => {
            await checkUserSession();
            if (isUserLoggedIn) {
                window.location.href = "Cart.php";
            } else {
                alert('Please login to manage your cart');
                window.location.href = "LogIn.php";
            }
        });

        // Back to Top
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // ========== INITIALIZE PAGE ==========
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();
            setupEventListeners();
            loadOrderConfirmation();
        }

        init();
    </script>
</body>

</html>
