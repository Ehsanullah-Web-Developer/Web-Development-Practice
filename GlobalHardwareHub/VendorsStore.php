<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Vendor Store</title>
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

        /* Modern Color Scheme */
        :root {
            --primary: #2563EB;
            --primary-dark: #1d4ed8;
            --primary-gradient: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            --secondary: #06B6D4;
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

        /* Header - Dark Navy */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #0F172A;
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

        /* Footer */
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

        /* Store Container */
        .store-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Vendor Header */
        .vendor-header {
            background: #FFFFFF;
            border-radius: 32px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .vendor-header:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.3);
        }

        .cover-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: var(--primary-gradient);
        }

        .vendor-profile {
            padding: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: flex-start;
            position: relative;
            margin-top: -50px;
        }

        .vendor-logo {
            width: 110px;
            height: 110px;
            border-radius: 24px;
            border: 4px solid #FFFFFF;
            background: #FFFFFF;
            object-fit: cover;
            box-shadow: var(--shadow-md);
            transition: transform 0.2s;
        }

        .vendor-logo:hover {
            transform: scale(1.02);
        }

        .vendor-info {
            flex: 1;
        }

        .vendor-info h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.3rem;
        }

        .vendor-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.5rem 0;
        }

        .stars {
            color: #fbbf24;
        }

        .vendor-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-outline {
            background: #FFFFFF;
            border: 1.5px solid var(--primary);
            color: var(--primary);
            padding: 0.5rem 1.2rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        /* Store Sections */
        .store-section {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .store-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1e293b;
        }

        .policies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .policy-card {
            background: #F8FAFC;
            padding: 1rem;
            border-radius: 20px;
            transition: all 0.2s;
        }

        .policy-card:hover {
            background: #FFFFFF;
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
        }

        /* Tabs - Fixed styling */
        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #E5E7EB;
            flex-wrap: wrap;
        }

        .tab-btn {
            background: none;
            border: none;
            padding: 0.5rem 1.2rem;
            cursor: pointer;
            font-weight: 600;
            color: #6B7280;
            transition: all 0.2s;
            position: relative;
            border-radius: 60px;
        }

        .tab-btn:hover {
            color: var(--primary);
            background: #EFF6FF;
        }

        .tab-btn.active {
            color: var(--primary);
            background: #EFF6FF;
        }

        .tab-btn.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary);
        }

        /* Product Grid - 4 cards per row */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .product-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 1rem;
            border: 1px solid #E5E7EB;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .product-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 16px;
            background: #F3F4F6;
        }

        .product-name {
            font-weight: 700;
            margin: 0.8rem 0 0.3rem;
            color: #1e293b;
            font-size: 1rem;
        }

        .product-price {
            font-weight: 800;
            color: var(--primary);
            font-size: 1.1rem;
            margin: 0.3rem 0;
        }

        .stock-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.8rem;
            border-radius: 60px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin: 0.3rem 0;
        }

        .in-stock {
            background: #D1FAE5;
            color: #065F46;
        }

        .low-stock {
            background: #FEF3C7;
            color: #B45309;
        }

        .out-stock {
            background: #FEE2E2;
            color: var(--danger);
        }

        .product-stats {
            font-size: 0.7rem;
            color: var(--gray-500);
            margin: 0.3rem 0;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Reviews */
        .reviews-grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .review-card {
            padding: 1rem;
            background: #F8FAFC;
            border-radius: 20px;
            transition: all 0.2s;
        }

        .review-card:hover {
            background: #FFFFFF;
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
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
            0% { opacity: 0; transform: translateX(-50%) translateY(20px); }
            15% { opacity: 1; transform: translateX(-50%) translateY(0); }
            85% { opacity: 1; }
            100% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
        }

        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
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

        @media (max-width: 600px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
            .vendor-profile {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .vendor-actions {
                justify-content: center;
            }
            .tabs {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="nav-container">
            <div class="logo"><img src="Logo.jpg" alt="Global Hardware Hub"></div>
            <ul class="nav-links" id="desktopNav">
                <li class="nav-item"><a href="VendorDashboard.php" class="nav-link">Vendor Dashboard</a></li>
                <li class="nav-item"><a href="VendorSettings.php" class="nav-link">Vendor Settings</a></li>
                <li class="nav-item"><a href="VendorAddProducts.php" class="nav-link">Vendor Add Products</a></li>
                <li class="nav-item"><a href="VendorProductsManagement.php" class="nav-link">Vendor Products</a></li>
                <li class="nav-item"><a href="VendorOrders.php" class="nav-link">Vendor Orders</a></li>
                <li class="nav-item"><a href="VendorReviews.php" class="nav-link">Vendor Reviews</a></li>
                <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i class="fas fa-key"></i> Logout</button></li>
            </ul>
            <button class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <button class="close-mobile" id="closeMobileBtn" style="background:none; border:none; font-size:1.8rem; float:right;"><i class="fas fa-times"></i></button>
        <div id="mobileMenuContent"></div>
    </div>

    <div class="store-container">
        <div class="vendor-header">
            <img class="cover-image" id="storeCover" src="vendorCoverImage1.jpg" alt="Cover">
            <div class="vendor-profile">
                <img class="vendor-logo" id="storeLogo" src="vendorLogoCPU.jpg" alt="Logo">
                <div class="vendor-info">
                    <h1 id="storeName">Loading...</h1>
                    <div class="vendor-rating">
                        <div class="stars" id="vendorStars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <span id="reviewCount">Loading...</span>
                    </div>
                    <p id="storeDescription">Loading...</p>
                </div>
                <div class="vendor-actions">
                    <button id="followBtn" class="btn-outline"><i class="fas fa-star"></i> Follow Store</button>
                    <button id="contactBtn" class="btn-primary"><i class="fas fa-envelope"></i> Contact Vendor</button>
                </div>
            </div>
        </div>

        <div class="store-section">
            <h2 class="section-title"><i class="fas fa-clipboard-list"></i> Store Policies</h2>
            <div class="policies-grid">
                <div class="policy-card"><i class="fas fa-truck"></i> <strong>Shipping</strong><br>Free shipping on orders $100+ | 3-5 business days</div>
                <div class="policy-card"><i class="fas fa-undo-alt"></i> <strong>Returns</strong><br>30-day hassle-free returns | Unopened products</div>
                <div class="policy-card"><i class="fas fa-shield-alt"></i> <strong>Warranty</strong><br>3-year manufacturer warranty on all products</div>
            </div>
        </div>

        <div class="store-section">
            <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Store Location</h2>
            <p id="storeAddress"><strong>Loading...</strong><br>Loading...</p>
            <img id="storeMap" src="storeLocation.jpg" alt="Store Location" style="width:100%; height:150px; border-radius:20px; margin-top:0.5rem; object-fit:cover; background:#F3F4F6;">
        </div>

        <div class="store-section">
            <div class="tabs">
                <button class="tab-btn active" data-tab="all"><i class="fas fa-list"></i> All Products</button>
                <button class="tab-btn" data-tab="bestsellers"><i class="fas fa-trophy"></i> Best Sellers</button>
                <button class="tab-btn" data-tab="new"><i class="fas fa-sparkle"></i> New Arrivals</button>
            </div>
            <div id="productsGrid" class="product-grid"></div>
        </div>

        <div class="store-section">
            <h2 class="section-title"><i class="fas fa-star"></i> Customer Reviews</h2>
            <div id="reviewsGrid" class="reviews-grid"></div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col"><h4>Quick Links 1</h4>
            <a href="Categories.php">Categories</a>
            <a href="Landing.php">Landing</a>
            <a href="TermsofService.php">Terms of Service</a>
            <a href="CookiePolicy.php">Cookie Policy</a></div>
            <div class="footer-col"><h4>Quick Links 2</h4>
            <a href="ShippingInfo.php">Shipping Info</a>
            <a href="UserOrders.php">Orders</a>
            <a href="PaymentMethods.php">Payment Methods</a>
            <a href="AddressBook.php">Address Book</a></div>
            <div class="footer-col"><h4>Contact</h4><p><i class="fas fa-phone-alt"></i> 03267322096</p><p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p><p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p><div class="social-icons"><i class="fab fa-facebook-f"></i><i class="fab fa-twitter"></i><i class="fab fa-instagram"></i></div></div>
            <div class="footer-col"><h4>Motto</h4><p>⚡ Power Your Passion, Build Without Limits.</p><p>© 2026 Global Hardware Hub</p></div>
        </div>
        <div class="copyright">Global Hardware Hub | The Ultimate Computer Hardware Marketplace</div>
    </footer>

    <button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i> Top</button>

    <div id="contactModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-envelope" style="font-size: 2.5rem; color: var(--primary);"></i>
            <h3 style="margin: 0.8rem 0;">Contact Vendor</h3>
            <p id="modalEmail">Loading...</p>
            <p id="modalPhone">Loading...</p>
            <p><i class="fas fa-clock"></i> Response within 2 hours</p>
            <button onclick="closeModal()" class="btn-primary" style="margin-top:1rem;"><i class="fas fa-times"></i> Close</button>
        </div>
    </div>

    <script>
        let allProducts = [];
        let storeData = null;
        let currentTab = "all";

        function showMessage(message, isError = false) {
            const popup = document.createElement('div');
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            popup.style.cssText = `position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: ${isError ? '#ef4444' : '#10b981'}; color: white; padding: 12px 24px; border-radius: 60px; z-index: 10000; font-size: 14px; animation: fadeInOut 3s ease forwards; font-weight: 500;`;
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 3000);
        }

        function renderStars(rating) {
            const fullStars = Math.floor(rating || 0);
            let stars = '';
            for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star"></i>';
            for (let i = fullStars; i < 5; i++) stars += '<i class="far fa-star"></i>';
            return stars;
        }

        function formatDate(dateString) {
            if (!dateString) return 'Recent';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
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

        // Load Store Details
        async function loadStoreDetails() {
            try {
                const response = await fetch('get_vendor_store_details.php');
                const result = await response.json();
                if (result.success && result.data) {
                    storeData = result.data;
                    document.getElementById('storeName').innerText = storeData.store_name || 'Vendor Store';
                    document.getElementById('storeDescription').innerText = storeData.description || 'No description available';
                    document.getElementById('vendorStars').innerHTML = renderStars(storeData.rating || 0);
                    const reviewCount = storeData.review_count || 0;
                    document.getElementById('reviewCount').innerHTML = `(${storeData.rating || 0}) · ${reviewCount} reviews`;
                    document.getElementById('storeCover').src = storeData.cover_image_url && storeData.cover_image_url !== '' ? storeData.cover_image_url : 'https://placehold.co/1200x200/2563eb/white?text=Store+Cover';
                    document.getElementById('storeLogo').src = storeData.logo_url && storeData.logo_url !== '' ? storeData.logo_url : 'https://placehold.co/110x110/2563eb/white?text=Logo';
                    const addressText = `${storeData.address || ''}, ${storeData.city || ''}, ${storeData.state || ''}, ${storeData.country || 'Pakistan'}`;
                    document.getElementById('storeAddress').innerHTML = `<strong><i class="fas fa-store"></i> ${storeData.store_name || 'Store'}</strong><br>${addressText}`;
                    document.getElementById('modalEmail').innerHTML = `<i class="fas fa-envelope"></i> Email: ${storeData.email || 'N/A'}`;
                    document.getElementById('modalPhone').innerHTML = `<i class="fas fa-phone-alt"></i> Phone: ${storeData.phone || 'N/A'}`;
                } else {
                    showMessage(result.message || 'Failed to load store details', true);
                }
            } catch (error) {
                console.error('Store details error:', error);
            }
        }

        // Load Products using get_vendor_products.php API
        async function loadProducts() {
            try {
                const response = await fetch('get_vendor_products.php');
                const result = await response.json();
                if (result.success && result.data) {
                    allProducts = result.data;
                    renderProducts();
                } else {
                    console.error('Products error:', result.message);
                    allProducts = [];
                    renderProducts();
                }
            } catch (error) {
                console.error('Products error:', error);
                allProducts = [];
                renderProducts();
            }
        }

        function filterProductsByTab() {
            let filtered = [...allProducts];
            if (currentTab === "bestsellers") {
                filtered = [...filtered].sort((a, b) => (b.total_sold || 0) - (a.total_sold || 0));
            } else if (currentTab === "new") {
                filtered = [...filtered].sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));
            }
            return filtered;
        }

        function getStockStatus(stock) {
            if (stock > 10) return { class: 'in-stock', text: 'In Stock' };
            if (stock > 0) return { class: 'low-stock', text: `Only ${stock} left` };
            return { class: 'out-stock', text: 'Out of Stock' };
        }

        function renderProducts() {
            const products = filterProductsByTab();
            const grid = document.getElementById("productsGrid");
            if (!grid) return;
            if (products.length === 0) {
                grid.innerHTML = '<div style="text-align:center; padding:2rem; color:#6B7280; grid-column:1/-1;"><i class="fas fa-box-open"></i> No products found</div>';
                return;
            }
            grid.innerHTML = products.map(p => {
                const price = p.price ? parseFloat(p.price).toFixed(2) : '0.00';
                const stockStatus = getStockStatus(p.stock_quantity || 0);
                return `
                <div class="product-card">
                    <img class="product-image" src="${p.image_url || 'https://placehold.co/260x160/2563eb/white?text=Product'}" alt="${escapeHtml(p.product_name)}" onerror="this.src='https://placehold.co/260x160/2563eb/white?text=Product'">
                    <div class="product-name">${escapeHtml(p.product_name)}</div>
                    <div class="product-price">PKR ${price}</div>
                    <div class="stars" style="font-size:0.7rem">${renderStars(p.avg_rating || 4.0)}</div>
                    <span class="stock-badge ${stockStatus.class}">
                        <i class="fas ${p.stock_quantity > 0 ? 'fa-check-circle' : 'fa-times-circle'}"></i> 
                        ${stockStatus.text}
                    </span>
                    <div class="product-stats"><i class="fas fa-chart-line"></i> ${p.total_sold || 0} units sold</div>
                </div>
            `;
            }).join('');
        }

        // Load Reviews
        async function loadReviews() {
            try {
                const response = await fetch('get_vendor_recent_reviews.php');
                const result = await response.json();
                const reviewsDiv = document.getElementById("reviewsGrid");
                if (!reviewsDiv) return;
                if (result.success && result.data && result.data.length > 0) {
                    reviewsDiv.innerHTML = result.data.map(r => `
                        <div class="review-card">
                            <div><strong><i class="fas fa-user-circle"></i> ${escapeHtml(r.customer_name || 'Anonymous')}</strong> <span class="stars">${renderStars(r.rating || 0)}</span> <span style="font-size:0.7rem; color:#6B7280;"><i class="fas fa-calendar-alt"></i> ${formatDate(r.created_at)}</span></div>
                            <p style="margin-top:0.3rem;">"${escapeHtml(r.comment || 'No comment provided')}"</p>
                        </div>
                    `).join('');
                } else {
                    reviewsDiv.innerHTML = '<div style="text-align:center; padding:2rem; color:#6B7280;"><i class="fas fa-comment-slash"></i> No reviews yet</div>';
                }
            } catch (error) {
                console.error('Reviews error:', error);
                document.getElementById("reviewsGrid").innerHTML = '<div style="text-align:center; padding:2rem; color:#6B7280;"><i class="fas fa-comment-slash"></i> No reviews yet</div>';
            }
        }

        // Event Listeners
        function setupEventListeners() {
            document.querySelectorAll(".tab-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
                    btn.classList.add("active");
                    currentTab = btn.dataset.tab;
                    renderProducts();
                });
            });
            document.getElementById("followBtn")?.addEventListener("click", () => showMessage("Store followed!"));
            document.getElementById("contactBtn")?.addEventListener("click", () => document.getElementById("contactModal").classList.add("show"));
        }

        function closeModal() {
            document.getElementById("contactModal").classList.remove("show");
        }

        // Mobile Menu
        function renderMobileMenu() {
            const container = document.getElementById('mobileMenuContent');
            if (!container) return;
            const menuItems = [
                { title: "Vendor Dashboard", link: "VendorDashboard.php" },
                { title: "Vendor Settings", link: "VendorSettings.php" },
                { title: "Add Products", link: "VendorAddProducts.php" },
                { title: "My Products", link: "VendorProductsManagement.php" },
                { title: "Orders", link: "VendorOrders.php" },
                { title: "Reviews", link: "VendorReviews.php" }
            ];
            let html = `<div style="margin-top:2rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%;"><i class="fas fa-sign-out-alt"></i> Logout</button></div><hr style="margin:1rem 0;">`;
            menuItems.forEach(item => { html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0; text-decoration:none; color:#374151;">${item.title}</a></div>`; });
            container.innerHTML = html;
            document.getElementById("mobileAuthBtn")?.addEventListener("click", () => window.location.href = "Logout.php");
        }

        document.getElementById('authButton')?.addEventListener('click', () => window.location.href = 'Logout.php');
        const hamburger = document.getElementById('hamburgerBtn');
        const mobilePanel = document.getElementById('mobileMenuPanel');
        const overlay = document.getElementById('mobileOverlay');
        function openMobile() { mobilePanel.classList.add('open'); overlay.classList.add('show'); }
        function closeMobile() { mobilePanel.classList.remove('open'); overlay.classList.remove('show'); }
        hamburger?.addEventListener('click', openMobile);
        document.getElementById('closeMobileBtn')?.addEventListener('click', closeMobile);
        overlay?.addEventListener('click', closeMobile);
        const backBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', () => { if (window.scrollY > 300) backBtn.classList.add('show'); else backBtn.classList.remove('show'); });
        backBtn?.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        window.closeModal = closeModal;

        async function init() {
            renderMobileMenu();
            setupEventListeners();
            await loadStoreDetails();
            await loadProducts();
            await loadReviews();
        }
        init();
    </script>
</body>

</html>