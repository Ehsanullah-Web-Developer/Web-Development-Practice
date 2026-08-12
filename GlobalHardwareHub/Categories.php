<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Categories</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts: Inter (same as Logout.php) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            /* THEME CHANGE: Logout.php gradient background */
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            scroll-behavior: smooth;
        }

        /* ========== THEME: Logout.php Color Scheme ========== */
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            --secondary: #667eea;
            --success: #10b981;
            --danger: #dc2626;
            --warning: #f59e0b;
            --card-bg: #ffffff;
            --card-bg-light: #f8fafc;
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Header - White Theme */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-lg);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
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

        .nav-link {
            text-decoration: none;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.2s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 40px;
        }

        .nav-link i {
            color: var(--text-muted);
        }

        .nav-link:hover,
        .nav-link.active {
            background: #eff6ff;
            color: var(--primary);
        }

        .nav-link:hover i {
            color: var(--primary);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            min-width: 230px;
            padding: 0.6rem 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-12px);
            transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s;
            z-index: 1050;
            border: 1px solid var(--border-color);
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
            color: var(--text-muted);
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .dropdown-menu a:hover {
            background: #f1f5f9;
            color: var(--primary);
            padding-left: 1.6rem;
        }

        .auth-btn {
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            padding: 0.45rem 1.2rem;
            border-radius: 60px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            color: var(--text-dark);
        }

        .auth-btn:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
            border-color: transparent;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            color: var(--text-dark);
            text-decoration: none;
            background: #f1f5f9;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            font-weight: 600;
            border: 1px solid var(--border-color);
        }

        .cart-icon i {
            font-size: 1.1rem;
        }

        .cart-icon:hover {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        .cart-icon:hover i {
            color: white;
        }

        .cart-count {
            background: var(--danger);
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
            color: var(--text-dark);
            transition: 0.2s;
        }

        .hamburger:hover {
            color: var(--primary);
            transform: scale(1.05);
        }

        .mobile-menu-panel {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 340px;
            height: 100%;
            background: var(--card-bg);
            z-index: 2000;
            box-shadow: 2px 0 30px rgba(0, 0, 0, 0.2);
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
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1999;
            display: none;
        }

        .mobile-overlay.show {
            display: block;
        }

        /* Main Container */
        .categories-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .breadcrumb {
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb span {
            color: rgba(255, 255, 255, 0.9);
        }

        .page-title {
            font-size: 2.4rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: white;
            margin-bottom: 0.5rem;
        }

        .page-title i {
            margin-right: 10px;
        }

        .page-description {
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        /* Categories Grid */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.8rem;
            margin-bottom: 3rem;
        }

        .category-card {
            background: var(--card-bg);
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            cursor: pointer;
            box-shadow: var(--shadow-md);
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .category-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .category-card:hover .category-image {
            transform: scale(1.05);
        }

        .category-content {
            padding: 1.4rem;
            text-align: center;
        }

        .category-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .category-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .shop-now-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.6rem 1.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .shop-now-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
            filter: brightness(1.05);
        }

        /* Section Title */
        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: white;
            margin: 2rem 0 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.8rem;
            margin-bottom: 2rem;
        }

        .product-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 1.2rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .product-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 16px;
            background: var(--card-bg-light);
            transition: transform 0.3s;
        }

        .product-card:hover .product-img {
            transform: scale(1.02);
        }

        .product-name {
            font-weight: 700;
            margin: 0.8rem 0 0.3rem;
            font-size: 1rem;
            color: var(--text-dark);
        }

        .product-brand {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .product-price {
            font-weight: 800;
            color: var(--primary);
            font-size: 1.1rem;
            margin: 0.4rem 0;
        }

        .stars {
            color: #fbbf24;
            font-size: 0.8rem;
            margin: 0.3rem 0;
        }

        .stock-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.7rem;
            border-radius: 40px;
            display: inline-block;
            margin: 0.3rem 0;
            font-weight: 500;
        }

        .in-stock {
            background: #d1fae5;
            color: #065f46;
        }

        .low-stock {
            background: #fed7aa;
            color: #92400e;
        }

        .out-stock {
            background: #fee2e2;
            color: #991b1b;
        }

        .product-actions {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
            margin-top: 0.8rem;
        }

        .btn-cart {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            flex: 1;
            transition: all 0.2s;
        }

        .btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            filter: brightness(1.05);
        }

        .btn-compare {
            background: #f1f5f9;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            padding: 0.4rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 500;
            flex: 1;
            transition: all 0.2s;
        }

        .btn-compare:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
        }

        .wishlist-icon {
            cursor: pointer;
            font-size: 1.2rem;
            transition: transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            color: var(--text-light);
        }

        .wishlist-icon:hover {
            transform: scale(1.1);
            color: var(--danger);
        }

        .wishlist-icon.active {
            color: var(--danger);
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.8rem;
            margin: 2rem 0;
        }

        .feature-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 1.8rem;
            text-align: center;
            border: 1px solid var(--border-color);
            transition: all 0.2s;
            box-shadow: var(--shadow-md);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 0.8rem;
            color: var(--primary);
        }

        .feature-title {
            font-weight: 700;
            margin-bottom: 0.4rem;
            color: var(--text-dark);
        }

        .feature-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Newsletter Section */
        .newsletter-section {
            background: var(--primary-gradient);
            border-radius: 32px;
            padding: 2.5rem;
            text-align: center;
            margin: 2rem 0;
            box-shadow: var(--shadow-lg);
        }

        .newsletter-section h3 {
            color: white;
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
        }

        .newsletter-section p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1.2rem;
        }

        .newsletter-form {
            display: flex;
            gap: 0.8rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .newsletter-form input {
            padding: 0.9rem 1.5rem;
            border: none;
            border-radius: 60px;
            width: 300px;
            outline: none;
            font-size: 0.9rem;
            background: #FFFFFF;
        }

        .newsletter-form input:focus {
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
        }

        .newsletter-form button {
            background: #f59e0b;
            color: #1f2937;
            border: none;
            padding: 0.9rem 2rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s;
        }

        .newsletter-form button:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Footer - White Theme */
        .footer {
            background: var(--card-bg);
            color: var(--text-muted);
            padding: 3rem 2rem 1.5rem;
            margin-top: 4rem;
            border-top: 1px solid var(--border-color);
            border-radius: 32px 32px 0 0;
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
            color: var(--text-dark);
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
            color: var(--text-muted);
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
            color: var(--text-muted);
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
            border-top: 1px solid var(--border-color);
            font-size: 0.8rem;
            color: var(--text-light);
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
            font-weight: 600;
        }

        .back-to-top.show {
            opacity: 1;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            filter: brightness(1.05);
        }

        .loading-spinner {
            text-align: center;
            padding: 3rem;
            color: var(--primary);
            font-size: 1rem;
            grid-column: 1 / -1;
            background: var(--card-bg);
            border-radius: 28px;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.2);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.6);
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
                transform: translateX(-50%) translateY(0);
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
            .products-grid {
                grid-template-columns: 1fr;
            }
            .categories-grid {
                grid-template-columns: 1fr;
            }
            .page-title {
                font-size: 1.8rem;
            }
            .section-title {
                font-size: 1.4rem;
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

    <div class="categories-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Categories</span>
        </div>
        <h1 class="page-title"><i class="fas fa-th-large"></i> Shop by Category</h1>
        <p class="page-description"><i class="fas fa-microchip"></i> Browse our extensive collection of computer
            hardware components. Find exactly what you need for your next build.</p>

        <div class="categories-grid" id="categoriesGrid">
            <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading categories...</div>
        </div>

        <h2 class="section-title"><i class="fas fa-star" style="color: #fbbf24;"></i> Featured Products</h2>
        <div id="featuredProducts" class="products-grid">
            <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading products...</div>
        </div>

        <h2 class="section-title"><i class="fas fa-gem"></i> Why Choose Global Hardware Hub?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-truck-fast"></i></div>
                <div class="feature-title">Fast Shipping</div>
                <div class="feature-desc">Free shipping on orders over $99</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-lock"></i></div>
                <div class="feature-title">Secure Payment</div>
                <div class="feature-desc">256-bit SSL encryption</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-file-certificate"></i></div>
                <div class="feature-title">Warranty</div>
                <div class="feature-desc">1-3 years manufacturer warranty</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-headset"></i></div>
                <div class="feature-title">24/7 Support</div>
                <div class="feature-desc">Expert assistance anytime</div>
            </div>
        </div>

        <div class="newsletter-section">
            <h3><i class="fas fa-envelope"></i> Stay Updated!</h3>
            <p>Subscribe to get exclusive deals and new product alerts</p>
            <div class="newsletter-form">
                <input type="email" id="newsletterEmail" placeholder="Enter your email address">
                <button id="subscribeBtn"><i class="fas fa-paper-plane"></i> Subscribe</button>
            </div>
            <div id="newsletterMsg" style="color:rgba(255,255,255,0.9); font-size:0.8rem; margin-top:0.8rem;"></div>
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
                <a href="CompareProducts.php">Compare Products</a>
                <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="Wishlist.php">Wishlist</a>
                <a href="WarrantyInfo.php">Warranty Info</a>
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

    <script>
        // ========== CART COUNT FROM API ==========
        
        // Global session variables
        let isUserLoggedIn = false;
        let isCustomerRole = false;
        let currentUserId = null;
        
        // Wishlist tracking set
        let userWishlist = new Set();

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

        async function loadUserWishlist() {
            if (!isUserLoggedIn || !isCustomerRole) return;
            try {
                const response = await fetch('get_wishlist.php');
                const data = await response.json();
                if (data.success && data.wishlist) {
                    userWishlist.clear();
                    data.wishlist.forEach(item => {
                        userWishlist.add(item.product_id);
                    });
                    console.log('Wishlist loaded:', Array.from(userWishlist));
                }
            } catch (error) {
                console.error('Error loading wishlist:', error);
            }
        }

        async function updateCartCount() {
            await loadCartCountFromAPI();
        }

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
            let html = `<div style="margin-top:2rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%; background:linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color:white; border:none;">${logged ? "<i class='fas fa-sign-out-alt'></i> Logout" : "<i class='fas fa-sign-in-alt'></i> Login"}</button></div><hr style="margin:1rem 0; border-color:#e2e8f0;">`;
            menuItems.forEach(item => {
                if (item.submenu) {
                    html += `<div class="mobile-nav-item"><div class="mobile-nav-header" data-toggle="${item.title}" style="display:flex; justify-content:space-between; padding:0.8rem 0; color:var(--text-dark); cursor:pointer;"><span>${item.title}</span> <i class="fas fa-chevron-down"></i></div><div class="mobile-submenu" id="submenu-${item.title}" style="padding-left:1rem; display:none;">`;
                    item.submenu.forEach((sub, idx) => { html += `<a href="${item.links[idx]}" style="display:block; padding:0.6rem 0; color:var(--text-muted); text-decoration:none;">${sub}</a>`; });
                    html += `</div></div>`;
                } else {
                    html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0; color:var(--text-dark); text-decoration:none;">${item.title}</a></div>`;
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
                const response = await fetch('Cart.php', { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const result = await response.json();
                return result.success;
            } catch (error) { console.error('Error:', error); return false; }
        }

        // FIXED: Updated wishlist function with proper "already present" message
        async function addToWishlistBackend(productId) {
            await checkUserSession();
            if (!isUserLoggedIn) {
                alert("Please Login First");
                window.location.href = "LogIn.php";
                return false;
            }
            
            // Check if product already exists in wishlist (client-side check)
            if (userWishlist.has(productId)) {
                showToast("Product already present in wishlist", true);
                return false;
            }
            
            const formData = new FormData();
            formData.append('action', 'add_to_wishlist');
            formData.append('product_id', productId);
            try {
                const response = await fetch('Wishlist.php', { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const result = await response.json();
                
                if (result.success) {
                    userWishlist.add(productId);
                    return true;
                } else {
                    // If backend says it already exists, add to local set as well
                    if (result.message && (result.message.includes('already') || result.message.includes('exists'))) {
                        userWishlist.add(productId);
                        showToast("Product already present in wishlist", true);
                        return false;
                    }
                    showToast(result.message || "Failed to add to wishlist", true);
                    return false;
                }
            } catch (error) { 
                console.error('Error:', error); 
                showToast("Connection error. Please try again.", true);
                return false; 
            }
        }

        async function addToCompare(productId, productName) {
            await checkUserSession();
            if (!isUserLoggedIn) {
                alert("Please login first to add products to comparison");
                window.location.href = "LogIn.php";
                return;
            }
            const formData = new FormData();
            formData.append('product_id', productId);
            try {
                const response = await fetch('add_to_comparison.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    showToast(`${productName} added to comparison list!`);
                    const btn = document.querySelector(`.btn-compare[data-product-id="${productId}"]`);
                    if (btn) {
                        const originalText = btn.innerHTML;
                        btn.innerHTML = '✓ Added';
                        btn.style.background = '#10b981';
                        btn.style.color = 'white';
                        setTimeout(() => {
                            btn.innerHTML = originalText;
                            btn.style.background = '#f1f5f9';
                            btn.style.color = 'var(--text-muted)';
                        }, 2000);
                    }
                } else {
                    showToast(result.message || "Failed to add to comparison", true);
                }
            } catch (error) { console.error('Error:', error); showToast("Connection error. Please try again.", true); }
        }

        async function addToCart(product) {
            if (await addToCartBackend(product.id)) {
                showToast(`${product.name} added to cart!`);
                await updateCartCount();
            } else {
                showToast("Failed to add to cart", true);
            }
        }

        async function buyNow(product) {
            if (await addToCartBackend(product.id)) {
                showToast(`${product.name} added to cart! Proceeding to checkout...`);
                window.location.href = "Checkout.php";
            } else {
                showToast("Failed to add to cart", true);
            }
        }

        // FIXED: Updated toggleWishlist to show proper message
        async function toggleWishlist(productId) {
            const result = await addToWishlistBackend(productId);
            if (result) { 
                showToast("Added to wishlist!");
                // Update wishlist icon appearance if exists
                const wishlistIcon = document.querySelector(`.wishlist-icon[data-product-id="${productId}"]`);
                if (wishlistIcon) {
                    wishlistIcon.classList.add('active');
                    wishlistIcon.innerHTML = '<i class="fas fa-heart" style="color:#dc2626;"></i>';
                }
            }
        }

        function showToast(message, isError = false) {
            const toast = document.createElement('div');
            toast.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            toast.style.cssText = `position:fixed; bottom:80px; left:50%; transform:translateX(-50%); background:${isError ? '#dc2626' : '#10b981'}; color:white; padding:12px 24px; border-radius:60px; z-index:10001; font-size:14px; animation:fadeInOut 3s ease; box-shadow:0 4px 12px rgba(0,0,0,0.2); font-weight:500;`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        async function fetchCategories() {
            const grid = document.getElementById("categoriesGrid");
            try {
                const response = await fetch('get_categories.php');
                const categories = await response.json();
                if (categories.error) { grid.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-exclamation-circle"></i> Failed to load categories</div>'; return; }
                if (!categories || categories.length === 0) { grid.innerHTML = '<div class="loading-spinner">No categories available</div>'; return; }
                renderCategories(categories);
            } catch (error) { grid.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-wifi"></i> Connection error loading categories</div>'; }
        }

        function renderCategories(categories) {
            const grid = document.getElementById("categoriesGrid");
            const categoriesHTML = categories.map(cat => {
                const imageUrl = cat.image_url && cat.image_url !== "default-category.jpg" ? cat.image_url : "https://placehold.co/600x400/667eea/ffffff?text=" + encodeURIComponent(cat.name);
                const icon = getCategoryIcon(cat.name);
                return `<div class="category-card" onclick="goToCategory('${escapeHtml(cat.name)}')"><img class="category-image" src="${imageUrl}" alt="${escapeHtml(cat.name)}" onerror="this.src='https://placehold.co/600x400/667eea/ffffff?text=${encodeURIComponent(cat.name)}'"><div class="category-content"><div class="category-name">${icon} ${escapeHtml(cat.name)}</div><div class="category-desc">${escapeHtml(cat.description || 'Shop now for best deals')}</div><button class="shop-now-btn">Shop Now <i class="fas fa-arrow-right"></i></button></div></div>`;
            }).join('');
            grid.innerHTML = categoriesHTML;
        }

        function getCategoryIcon(categoryName) {
            const icons = { 'CPU': '🖥️', 'GPU': '🎮', 'Graphics Cards': '🎮', 'Motherboards': '🔌', 'Storage': '💾', 'Storage Devices': '💾', 'Networking': '🌐', 'Networking Devices': '🌐', 'Peripherals': '⌨️', 'Peripheral Devices': '⌨️', 'Mobile Parts': '📱', 'Laptop Parts': '💻' };
            return icons[categoryName] || '📦';
        }

        async function fetchProducts() {
            const container = document.getElementById("featuredProducts");
            try {
                const response = await fetch('get_products.php?page=1');
                const products = await response.json();
                if (products.error) { container.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-exclamation-circle"></i> Failed to load products</div>'; return; }
                if (!products || products.length === 0) { container.innerHTML = '<div class="loading-spinner">No products available</div>'; return; }
                renderProducts(products.slice(0, 8));
            } catch (error) { container.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-wifi"></i> Connection error loading products</div>'; }
        }

        function renderProducts(products) {
            const container = document.getElementById("featuredProducts");
            const productsHTML = products.map(product => {
                const isInWishlist = userWishlist.has(product.id);
                const wishlistIconClass = isInWishlist ? 'wishlist-icon active' : 'wishlist-icon';
                const wishlistIconHtml = isInWishlist ? '<i class="fas fa-heart" style="color:#dc2626;"></i>' : '<i class="far fa-heart"></i>';
                const stockClass = product.stock > 10 ? 'in-stock' : (product.stock > 0 ? 'low-stock' : 'out-stock');
                const stockText = product.stock > 10 ? 'In Stock' : (product.stock > 0 ? `Only ${product.stock} left` : 'Out of Stock');
                const imageUrl = product.image && product.image !== "default-product.jpg" ? product.image : "https://placehold.co/300x200/667eea/ffffff?text=Product";
                const rating = (3.5 + Math.random() * 1.5).toFixed(1);
                return `<div class="product-card"><img class="product-img" src="${imageUrl}" alt="${escapeHtml(product.name)}" onerror="this.src='https://placehold.co/300x200/667eea/ffffff?text=Product'"><div class="product-name">${escapeHtml(product.name)}</div><div class="product-brand"><i class="fas fa-building"></i> Global Hardware Hub</div><div class="product-price">PKR ${product.price.toFixed(2)}</div><div class="stars">${renderStars(parseFloat(rating))} (${rating})</div><div><span class="stock-badge ${stockClass}"><i class="fas ${product.stock > 0 ? 'fa-check-circle' : 'fa-times-circle'}"></i> ${stockText}</span></div><div class="product-actions"><button class="btn-cart" onclick="addToCart({id:${product.id}, name:'${escapeHtml(product.name).replace(/'/g, "\\'")}', price:${product.price}, image:'${imageUrl}'})"><i class="fas fa-cart-plus"></i> Add to Cart</button><button class="btn-compare" data-product-id="${product.id}" onclick="addToCompare(${product.id}, '${escapeHtml(product.name).replace(/'/g, "\\'")}')"><i class="fas fa-chart-simple"></i> Compare</button><span class="${wishlistIconClass}" data-product-id="${product.id}" onclick="toggleWishlist(${product.id})">${wishlistIconHtml}</span></div></div>`;
            }).join('');
            container.innerHTML = productsHTML;
        }

        function renderStars(rating) {
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            let stars = '';
            for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star"></i>';
            if (hasHalfStar) stars += '<i class="fas fa-star-half-alt"></i>';
            for (let i = stars.length / 3; i < 5; i++) stars += '<i class="far fa-star"></i>';
            return stars;
        }

        window.goToCategory = function (categoryName) {
            window.location.href = `Products1.php?category=${encodeURIComponent(categoryName)}`;
        };

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function (m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        document.getElementById("subscribeBtn").addEventListener("click", () => {
            const email = document.getElementById("newsletterEmail").value.trim();
            const msgDiv = document.getElementById("newsletterMsg");
            const emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
            if (!email) { msgDiv.innerHTML = "❌ Please enter your email address"; msgDiv.style.color = "#fecaca"; }
            else if (!emailRegex.test(email)) { msgDiv.innerHTML = "❌ Please enter a valid email address"; msgDiv.style.color = "#fecaca"; }
            else { msgDiv.innerHTML = "✅ Subscribed successfully! Thank you."; msgDiv.style.color = "#d1fae5"; document.getElementById("newsletterEmail").value = ""; setTimeout(() => msgDiv.innerHTML = "", 3000); }
        });

        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => backBtn.classList.toggle("show", window.scrollY > 300));
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        document.querySelector('.cart-icon')?.addEventListener('click', async () => {
            await checkUserSession();
            if (!isUserLoggedIn) { alert("Please login first to view your cart"); window.location.href = "LogIn.php"; }
            else { window.location.href = "Cart.php"; }
        });

        window.addToCart = addToCart;
        window.buyNow = buyNow;
        window.toggleWishlist = toggleWishlist;
        window.addToCompare = addToCompare;
        window.goToCategory = goToCategory;

        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();
            await loadUserWishlist();
            fetchCategories();
            fetchProducts();
        }
        
        init();
    </script>
</body>

</html>