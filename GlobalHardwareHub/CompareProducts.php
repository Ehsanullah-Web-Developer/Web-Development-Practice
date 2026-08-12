<?php
// This file now uses get_comparison_products.php backend API
// Comparison products are fetched dynamically from database
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Compare Products</title>
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
            /* E. Navbar Underline - position relative for pseudo-element */
            position: relative;
        }

        .nav-link i { color: #FFFFFF; }
        .nav-link:hover, .nav-link.active { background: rgba(255, 255, 255, 0.1); color: #FFFFFF; }

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
        .hamburger:hover { color: var(--secondary); transform: scale(1.05); }

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

        .social-icons i:hover { color: #60A5FA; transform: translateY(-3px) scale(1.05); }

        .copyright {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: #CBD5E1;
        }

        /* Compare Container */
        .compare-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .page-title {
            font-size: 2.4rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFFFFF 0%, #c7d2fe 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .limit-message {
            color: #FFFFFF;
            font-size: 0.85rem;
            margin-bottom: 2rem;
            background: rgba(255, 255, 255, 0.2);
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            backdrop-filter: blur(4px);
            transition: all 0.2s ease;
        }

        .limit-message:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.3);
        }

        /* Comparison Table */
        .compare-wrapper {
            overflow-x: auto;
            background: #FFFFFF;
            border-radius: 32px;
            margin-bottom: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        /* A. Compare Wrapper Hover Animation */
        .compare-wrapper:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }

        .compare-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .compare-table th,
        .compare-table td {
            padding: 1.2rem;
            text-align: center;
            border-bottom: 1px solid #E5E7EB;
            vertical-align: middle;
            transition: background-color 0.2s ease;
        }

        .compare-table tr:hover td {
            background-color: #F9FAFB;
        }

        .compare-table th {
            background: #F9FAFB;
            font-weight: 700;
            color: #111827;
            width: 180px;
            font-size: 0.9rem;
        }

        .product-cell {
            min-width: 240px;
        }

        .product-image {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 0.8rem;
            transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: var(--shadow-sm);
        }

        /* D. Product Image Zoom Animation */
        .product-image:hover {
            transform: scale(1.05);
        }

        .product-name {
            font-weight: 700;
            margin: 0.8rem 0;
            color: #111827;
            font-size: 1rem;
        }

        .product-price {
            font-weight: 800;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .stock-badge {
            display: inline-block;
            padding: 0.25rem 1rem;
            border-radius: 60px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .in-stock {
            background: #D1FAE5;
            color: #065F46;
        }

        .out-stock {
            background: #FEE2E2;
            color: #DC2626;
        }

        /* B. Button Hover Animation */
        .btn-remove {
            background: #FEE2E2;
            color: #DC2626;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 0.5rem;
            transition: all 0.25s ease;
        }

        .btn-remove:hover {
            background: #DC2626;
            color: white;
            transform: translateY(-2px) scale(1.02);
        }

        /* B. Button Hover Animation */
        .btn-cart {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
            transition: all 0.25s ease;
        }

        .btn-cart:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .stars {
            color: #fbbf24;
            font-size: 0.8rem;
            letter-spacing: 2px;
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
            margin: 1rem 0 0.5rem;
            color: #111827;
        }

        /* I. Skeleton Loader Animation - Enhanced Pulse/Shimmer */
        .loading-spinner {
            text-align: center;
            padding: 3rem;
            color: var(--primary);
            font-size: 1rem;
            background: #FFFFFF;
            border-radius: 32px;
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: shimmerPulse 1.5s infinite ease-in-out;
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

        /* B. Button Hover Animation */
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 60px;
            cursor: pointer;
            margin-top: 1rem;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        /* B. Button Hover Animation */
        .clear-btn {
            background: #F3F4F6;
            color: #374151;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 60px;
            cursor: pointer;
            margin-bottom: 1rem;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .clear-btn:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px) scale(1.02);
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
            transition: all 0.2s ease;
            z-index: 99;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: var(--shadow-md);
        }

        .back-to-top.show { opacity: 1; }
        .back-to-top:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4); }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateX(-50%) translateY(20px); }
            15% { opacity: 1; transform: translateX(-50%) translateY(0); }
            85% { opacity: 1; }
            100% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
        }

        @media (max-width: 800px) {
            .nav-links { display: none; }
            .hamburger { display: block; }
            .nav-container { padding: 0.8rem 1.2rem; }
        }

        @media (max-width: 768px) {
            .page-title { font-size: 1.8rem; }
            .compare-table th, .compare-table td { padding: 0.8rem; }
            .product-image { width: 100px; height: 100px; }
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
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
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

    <div class="compare-container">
        <!-- H. Scroll Reveal - Page Title -->
        <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-chart-simple"></i> Compare Products</h1>
        <div class="limit-message" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30"><i class="fas fa-info-circle"></i> You can compare up to 4 products</div>

        <div id="compareContent" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="50">
            <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading comparison products...</div>
        </div>
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
                <a href="AddressBook.php">Address Book</a>
                <a href="Landing.php">Landing</a>
                <a href="PaymentMethods.php">Payment Methods</a>
                <a href="PrivacyPolicy.php">Privacy Policy</a>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p><i class="fas fa-phone-alt"></i> 03267322096</p>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
                <div class="social-icons"><i class="fab fa-facebook-f"></i><i class="fab fa-twitter"></i><i
                        class="fab fa-instagram"></i><i class="fab fa-youtube"></i></div>
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
        let isUserLoggedIn = false;
        let isCustomerRole = false;
        let currentUserId = null;

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
            }
        }

        async function updateCartCount() {
            await loadCartCountFromAPI();
        }

        // ========== LOGIN/LOGOUT FUNCTIONS ==========
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

        // ========== MOBILE MENU ==========
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

        // ========== CART FUNCTIONS ==========
        async function addToCartBackend(productId, quantity = 1) {
            await checkUserSession();
            if (!isUserLoggedIn) {
                alert("Please Login First");
                window.location.href = "LogIn.php";
                return false;
            }
            const formData = new FormData();
            formData.append('action', 'add_to_cart');
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            try {
                const response = await fetch('Cart.php', {
                    method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData
                });
                const result = await response.json();
                return result.success;
            } catch (error) { console.error('Error:', error); return false; }
        }

        async function removeFromComparison(productId) {
            const formData = new FormData();
            formData.append('product_id', productId);
            try {
                const response = await fetch('remove_from_comparison.php', { method: 'POST', body: formData });
                const result = await response.json();
                return result.success;
            } catch (error) { console.error('Error:', error); return false; }
        }

        function showToast(message, isError = false) {
            const toast = document.createElement('div');
            toast.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            toast.style.cssText = `
                position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%);
                background: ${isError ? '#ef4444' : '#10b981'}; color: white;
                padding: 12px 24px; border-radius: 60px; z-index: 10001;
                font-size: 14px; animation: fadeInOut 3s ease; font-weight:500;
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        // ============== FETCH COMPARISON PRODUCTS ==============
        let comparisonData = [];

        async function fetchComparisonProducts() {
            const container = document.getElementById("compareContent");

            try {
                const response = await fetch('get_comparison_products.php');
                const result = await response.json();

                if (!result.success) {
                    if (result.message === 'Please login first') {
                        container.innerHTML = `<div class="empty-state"><div style="font-size: 3rem;"><i class="fas fa-lock"></i></div><h3>Please Login First</h3><p>You need to be logged in to view and manage your comparison list.</p><a href="LogIn.php"><button class="btn-primary"><i class="fas fa-sign-in-alt"></i> Login Now →</button></a></div>`;
                    } else {
                        container.innerHTML = `<div class="empty-state"><div style="font-size: 3rem;"><i class="fas fa-exclamation-triangle"></i></div><h3>Error Loading Products</h3><p>${result.message || 'Failed to load comparison products'}</p><button onclick="location.reload()" class="btn-primary"><i class="fas fa-sync-alt"></i> Refresh Page</button></div>`;
                    }
                    return;
                }

                comparisonData = result.data || [];

                if (comparisonData.length === 0) {
                    container.innerHTML = `<div class="empty-state"><div style="font-size: 3rem;"><i class="fas fa-chart-simple"></i></div><h3>No products to compare</h3><p>Add products from the product page to see comparison.</p><a href="Products1.php"><button class="btn-primary"><i class="fas fa-store"></i> Go to Products →</button></a></div>`;
                    return;
                }

                renderComparisonTable(comparisonData);

            } catch (error) {
                console.error("Fetch error:", error);
                container.innerHTML = `<div class="empty-state"><div style="font-size: 3rem;"><i class="fas fa-wifi"></i></div><h3>Connection Error</h3><p>Failed to load comparison products. Please check your connection.</p><button onclick="location.reload()" class="btn-primary"><i class="fas fa-sync-alt"></i> Refresh Page</button></div>`;
            }
        }

        function highlightDifferences(values) {
            if (values.length < 2) return '';
            const allSame = values.every(v => v === values[0]);
            return allSame ? '' : 'highlight';
        }

        function getStockStatus(productStatus) {
            if (productStatus === "active") {
                return { text: "In Stock", class: "in-stock", icon: "fa-check-circle" };
            } else {
                return { text: "Out of Stock", class: "out-stock", icon: "fa-times-circle" };
            }
        }

        function renderComparisonTable(products) {
            const container = document.getElementById("compareContent");

            const comparisonRows = [
                { label: "Product Image", icon: "fa-image" },
                { label: "Product Name", icon: "fa-microchip" },
                { label: "Price", icon: "fa-tag" },
                { label: "Availability", icon: "fa-box" },
                { label: "Description", icon: "fa-align-left" },
                { label: "Action", icon: "fa-cart-plus" }
            ];

            let tableHtml = `<div class="compare-wrapper"><table class="compare-table">`;
            tableHtml += `<thead><tr>`;
            tableHtml += `<th width="180"><i class="fas fa-list"></i> Features</th>`;
            for (let p of products) {
                tableHtml += `<th class="product-cell">
                    <img class="product-image" src="${p.image && p.image !== 'default-product.jpg' ? p.image : 'https://placehold.co/140x140/2563eb/white?text=Product'}" 
                         alt="${escapeHtml(p.name)}" 
                         onerror="this.src='https://placehold.co/140x140/2563eb/white?text=Product'">
                    <div class="product-name">${escapeHtml(p.name)}</div>
                    <button class="btn-remove" onclick="removeProduct(${p.product_id})"><i class="fas fa-trash-alt"></i> Remove</button>
                </th>`;
            }
            tableHtml += `<tr></thead><tbody>`;

            for (let row of comparisonRows) {
                tableHtml += `<tr>`;
                tableHtml += `<th><i class="fas ${row.icon}"></i> ${row.label}</th>`;
                
                for (let p of products) {
                    let cellContent = '';
                    
                    switch(row.label) {
                        case "Product Image":
                            cellContent = `<img class="product-image" src="${p.image && p.image !== 'default-product.jpg' ? p.image : 'https://placehold.co/140x140/2563eb/white?text=Product'}" 
                                            alt="${escapeHtml(p.name)}" 
                                            onerror="this.src='https://placehold.co/140x140/2563eb/white?text=Product'" style="width:100px; height:100px; margin:0 auto;">`;
                            break;
                        case "Product Name":
                            cellContent = `<div style="font-weight:700; color:#111827;">${escapeHtml(p.name)}</div>`;
                            break;
                        case "Price":
                            cellContent = `<div class="product-price">PKR ${parseFloat(p.price).toFixed(2)}</div>`;
                            if (p.sale_price && p.sale_price < p.regular_price) {
                                cellContent += `<div style="font-size:0.7rem;"><del>PKR ${parseFloat(p.regular_price).toFixed(2)}</del></div>`;
                            }
                            break;
                        case "Availability":
                            const stockInfo = getStockStatus(p.status);
                            cellContent = `<span class="stock-badge ${stockInfo.class}"><i class="fas ${stockInfo.icon}"></i> ${stockInfo.text}</span>`;
                            break;
                        case "Description":
                            cellContent = `<div style="font-size:0.85rem; line-height:1.5; color:#6B7280;">${escapeHtml(p.description || 'No description available')}</div>`;
                            break;
                        case "Action":
                            const stockInfoAction = getStockStatus(p.status);
                            const isInStock = stockInfoAction.text === "In Stock";
                            const disabledAttr = !isInStock ? 'disabled style="opacity:0.5; cursor:not-allowed;"' : '';
                            const buttonText = isInStock ? '<i class="fas fa-shopping-cart"></i> Add to Cart' : '<i class="fas fa-times-circle"></i> Out of Stock';
                            cellContent = `<button class="btn-cart" onclick="addToCartFromCompare(${p.product_id}, '${escapeHtml(p.name).replace(/'/g, "\\'")}', ${parseFloat(p.price)})" ${disabledAttr}>${buttonText}</button>`;
                            break;
                    }
                    
                    tableHtml += `<td class="product-cell">${cellContent}</td>`;
                }
                tableHtml += `</tr>`;
            }

            tableHtml += `</tbody></table></div>`;
            tableHtml += `<div style="text-align: center; margin-top: 1rem;"><button class="clear-btn" onclick="clearAllComparison()"><i class="fas fa-trash-alt"></i> Clear All Products</button></div>`;

            container.innerHTML = tableHtml;
            
            // Refresh AOS for dynamically added elements
            AOS.refresh();
        }

        async function removeProduct(productId) {
            if (await removeFromComparison(productId)) {
                showToast("Product removed from comparison");
                await fetchComparisonProducts();
            } else {
                showToast("Failed to remove product", true);
            }
        }

        async function clearAllComparison() {
            if (confirm("Remove all products from comparison?")) {
                for (let product of comparisonData) {
                    await removeFromComparison(product.product_id);
                }
                await fetchComparisonProducts();
                showToast("All products removed from comparison");
            }
        }

        async function addToCartFromCompare(productId, productName, productPrice) {
            if (await addToCartBackend(productId)) {
                showToast(`${productName} added to cart!`);
                await updateCartCount();
            } else {
                showToast("Failed to add to cart", true);
            }
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

        // Back to Top
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => backBtn.classList.toggle("show", window.scrollY > 300));
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // Cart click
        document.querySelector('.cart-icon')?.addEventListener('click', async () => {
            await checkUserSession();
            if (!isUserLoggedIn) {
                alert("Please login first to view your cart");
                window.location.href = "LogIn.php";
            } else {
                window.location.href = "Cart.php";
            }
        });

        // Make functions global
        window.removeProduct = removeProduct;
        window.clearAllComparison = clearAllComparison;
        window.addToCartFromCompare = addToCartFromCompare;

        // ========== INITIALIZE PAGE ==========
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();
            await fetchComparisonProducts();
        }
        
        init();
    </script>
</body>

</html>