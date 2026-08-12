<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Product Details</title>
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

        .nav-link:hover {
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

        /* Product Container */
        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .breadcrumb {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1.5rem;
        }

        .breadcrumb a {
            color: #FFFFFF;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* I. Skeleton Loader Animation - Enhanced Pulse/Shimmer */
        .loading {
            text-align: center;
            padding: 4rem;
            font-size: 1.2rem;
            color: #FFFFFF;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 32px;
            background: linear-gradient(90deg, rgba(0,0,0,0.2) 25%, rgba(0,0,0,0.35) 50%, rgba(0,0,0,0.2) 75%);
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

        .not-found {
            text-align: center;
            padding: 3rem;
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .not-found h2 {
            color: var(--danger);
            margin-bottom: 1rem;
        }

        /* Product Layout */
        .product-layout {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .gallery-section {
            flex: 1;
            min-width: 280px;
        }

        .main-image {
            background: #FFFFFF;
            border-radius: 32px;
            overflow: hidden;
            margin-bottom: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .main-image:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .main-image img {
            width: 100%;
            height: 400px;
            object-fit: contain;
            background: #F3F4F6;
            transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        /* D. Product Image Zoom Animation */
        .main-image:hover img {
            transform: scale(1.05);
        }

        .thumbnails {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 16px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease;
            background: #FFFFFF;
        }

        .thumbnail.active {
            border-color: var(--primary);
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        .thumbnail:hover {
            transform: scale(1.05);
        }

        .info-section {
            flex: 1;
            min-width: 300px;
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.8rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .info-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .product-title {
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #2563EB 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .product-brand {
            color: #6B7280;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .product-category {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #F3F4F6;
            padding: 0.25rem 1rem;
            border-radius: 60px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .price-container {
            display: flex;
            align-items: baseline;
            gap: 1rem;
            flex-wrap: wrap;
            margin: 1rem 0;
        }

        .current-price {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
        }

        .old-price {
            font-size: 1.2rem;
            color: #6B7280;
            text-decoration: line-through;
        }

        .discount-badge {
            background: var(--danger);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .stock-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0.3rem 1rem;
            border-radius: 60px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .in-stock {
            background: #D1FAE5;
            color: #065F46;
        }

        .low-stock {
            background: #FED7AA;
            color: #9B2C1D;
        }

        .out-stock {
            background: #FEE2E2;
            color: var(--danger);
        }

        .sku-text {
            font-size: 0.8rem;
            color: #6B7280;
            margin-bottom: 1rem;
        }

        .rating-stars {
            color: #fbbf24;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .rating-count {
            color: #6B7280;
            font-size: 0.8rem;
            margin-left: 0.3rem;
        }

        .short-description {
            color: #374151;
            line-height: 1.6;
            margin: 1rem 0;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1rem 0;
        }

        .quantity-selector label {
            font-weight: 600;
            color: #374151;
        }

        .quantity-input {
            width: 70px;
            padding: 0.5rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 12px;
            text-align: center;
            font-size: 1rem;
            background: #FFFFFF;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin: 1.5rem 0;
        }

        /* B. Button Hover Animation */
        .btn-cart,
        .btn-buy,
        .btn-wishlist,
        .btn-compare {
            padding: 0.8rem 1.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.25s ease;
            border: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-cart {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-cart:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-buy {
            background: var(--success);
            color: white;
        }

        .btn-buy:hover {
            background: #059669;
            transform: translateY(-2px) scale(1.02);
        }

        .btn-wishlist {
            background: #FFFFFF;
            color: var(--danger);
            border: 1.5px solid #FEE2E2;
        }

        .btn-wishlist:hover {
            background: #FEE2E2;
            transform: translateY(-2px) scale(1.02);
        }

        .btn-wishlist.active {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }

        .btn-compare {
            background: #374151;
            color: white;
        }

        .btn-compare:hover {
            background: #1F2937;
            transform: translateY(-2px) scale(1.02);
        }

        /* Specs Section - White Card */
        .specs-section {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.8rem;
            margin-bottom: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .specs-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .specs-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #111827;
        }

        .specs-table {
            width: 100%;
            border-collapse: collapse;
        }

        .specs-table td {
            padding: 0.8rem;
            border-bottom: 1px solid #E5E7EB;
        }

        .specs-table td:first-child {
            font-weight: 700;
            width: 200px;
            color: #111827;
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

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                visibility: hidden;
            }
        }

        .custom-toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--success);
            color: white;
            padding: 12px 24px;
            border-radius: 60px;
            z-index: 10001;
            font-size: 14px;
            animation: slideUp 0.3s ease, fadeOut 0.3s ease 2.5s forwards;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            pointer-events: none;
            font-weight: 500;
        }

        .custom-toast.error {
            background: var(--danger);
        }

        .custom-toast.info {
            background: #3b82f6;
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
            .product-layout {
                flex-direction: column;
            }
            .product-title {
                font-size: 1.5rem;
            }
            .action-buttons {
                gap: 0.5rem;
            }
            .btn-cart,
            .btn-buy,
            .btn-wishlist,
            .btn-compare {
                padding: 0.6rem 1.2rem;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <img src="Logo.jpg" alt="Global Hardware Hub"
                    onerror="this.src='https://placehold.co/200x60/2563eb/white?text=GHH'">
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

    <div class="product-container" id="productContainer">
        <div class="loading"><i class="fas fa-spinner fa-pulse"></i> Loading product details...</div>
    </div>

    <!-- H. Scroll Reveal - Footer -->
    <footer class="footer" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Quick Links</h4>
                <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="FAQ.php">FAQs</a>
                <a href="PaymentMethods.php">Payment Methods</a>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <a href="Blog.php">Tech Blog</a>
                <a href="WarrantyInfo.php">Warranty Info</a>
                <a href="OrderTracking.php">Track Order</a>
                <a href="ReturnPolicy.php">Return Policy</a>
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

        // ========== SESSION AND CART FUNCTIONS ==========

        let isUserLoggedIn = false;
        let isCustomerRole = false;
        let currentUserId = null;
        let sessionChecked = false;

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

        async function checkUserSession() {
            if (sessionChecked) return isUserLoggedIn;

            try {
                const response = await fetch('check_session.php');
                const data = await response.json();

                if (data && data.user_id) {
                    isUserLoggedIn = true;
                    currentUserId = data.user_id;
                    isCustomerRole = (data.user_role === 'customer');
                    console.log('User logged in:', data.user_id, 'Role:', data.user_role);
                } else {
                    isUserLoggedIn = false;
                    isCustomerRole = false;
                    currentUserId = null;
                    console.log('No user logged in');
                }
                sessionChecked = true;
                return isUserLoggedIn;
            } catch (error) {
                console.error('Session check error:', error);
                isUserLoggedIn = false;
                isCustomerRole = false;
                sessionChecked = true;
                return false;
            }
        }

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

        function showToastMessage(message, type = 'success') {
            const existingToast = document.querySelector('.custom-toast');
            if (existingToast) existingToast.remove();

            const toast = document.createElement('div');
            toast.className = 'custom-toast';
            if (type === 'error') toast.classList.add('error');
            if (type === 'info') toast.classList.add('info');
            toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle')}"></i> ${message}`;
            document.body.appendChild(toast);
            setTimeout(() => {
                if (toast && toast.remove) toast.remove();
            }, 3000);
        }

        async function addToCart(product, quantity = 1) {
            await checkUserSession();

            if (!isUserLoggedIn) {
                showToastMessage("Please login first to add items to cart", 'error');
                setTimeout(() => {
                    window.location.href = "LogIn.php";
                }, 1500);
                return false;
            }

            if (!isCustomerRole) {
                showToastMessage("Only customers can add items to cart. Vendors and admins cannot purchase products.", 'error');
                return false;
            }

            if (!product || !product.id) {
                showToastMessage("Unable to add product to cart", 'error');
                return false;
            }

            const formData = new FormData();
            formData.append('action', 'add_to_cart');
            formData.append('product_id', product.id);
            formData.append('quantity', quantity);

            try {
                const response = await fetch('Cart.php', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showToastMessage(`${product.name} added to cart!`, 'success');
                    await updateCartCount();
                    return true;
                } else {
                    showToastMessage(result.message || "Failed to add to cart", 'error');
                    return false;
                }
            } catch (error) {
                console.error("Error adding to cart:", error);
                showToastMessage("Connection error. Please try again.", 'error');
                return false;
            }
        }

        async function buyNow(product, quantity = 1) {
            const added = await addToCart(product, quantity);
            if (added) {
                window.location.href = "Checkout.php";
            }
        }

        function getProductIdFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id');
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

        let currentProduct = null;

        async function fetchAndRenderProduct() {
            const productId = getProductIdFromURL();
            const container = document.getElementById("productContainer");

            if (!productId) {
                container.innerHTML = `<div class="not-found"><h2><i class="fas fa-exclamation-triangle"></i> No Product Selected</h2><p>Please go to the Products page and click "View Details" on any product.</p><a href="Products1.php"><button class="btn-cart" style="margin-top:1rem; cursor:pointer;"><i class="fas fa-arrow-left"></i> Go to Products Page</button></a></div>`;
                return;
            }

            try {
                const response = await fetch(`get_product_details.php?id=${productId}`);
                const product = await response.json();

                if (product.error) {
                    container.innerHTML = `<div class="not-found"><h2><i class="fas fa-exclamation-triangle"></i> ${product.message || "Product Not Found"}</h2><p>The product you're looking for doesn't exist or has been removed.</p><a href="Products1.php"><button class="btn-cart" style="margin-top:1rem; cursor:pointer;"><i class="fas fa-store"></i> Browse Products</button></a></div>`;
                    return;
                }

                currentProduct = {
                    id: product.product_id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    stock: product.stock
                };

                renderProductDetails(product);
                setupWishlistButton(product);
                setupCartButtons();
                setupCompareButton();

            } catch (error) {
                console.error("Fetch error:", error);
                container.innerHTML = `<div class="not-found"><h2><i class="fas fa-wifi"></i> Connection Error</h2><p>Failed to load product details. Please check your connection and try again.</p><button onclick="location.reload()" class="btn-cart" style="margin-top:1rem; cursor:pointer;"><i class="fas fa-sync-alt"></i> Refresh Page</button></div>`;
            }
        }

        function renderProductDetails(product) {
            const container = document.getElementById("productContainer");

            let stockClass = 'in-stock';
            let stockText = 'In Stock';

            if (product.stock <= 0) {
                stockClass = 'out-stock';
                stockText = 'Out of Stock';
            } else if (product.stock <= 10) {
                stockClass = 'low-stock';
                stockText = `Only ${product.stock} left`;
            }

            let statusDisplay = product.status || 'available';
            let statusText = statusDisplay === 'available' ? 'Available' : 'Currently Unavailable';

            let specsHtml = `
                <tr><td><i class="fas fa-microchip"></i> Product Name</td><td>${escapeHtml(product.name)}</td></tr>
                <tr><td><i class="fas fa-barcode"></i> Product ID</td><td>${product.product_id}</td></tr>
                <tr><td><i class="fas fa-tag"></i> Price</td><td>PKR ${product.price.toFixed(2)}</td></tr>
                <tr><td><i class="fas fa-boxes"></i> Stock Availability</td><td>${product.stock} units</td></tr>
                <tr><td><i class="fas fa-info-circle"></i> Status</td><td>${statusText}</td></tr>
                <tr><td><i class="fas fa-folder"></i> Category</td><td>Computer Hardware</td></tr>`;

            container.innerHTML = `
            <div class="breadcrumb">
                <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="Products1.php"><i class="fas fa-box"></i> Products</a> / <span>${escapeHtml(product.name)}</span>
            </div>
            <!-- H. Scroll Reveal - Product Layout -->
            <div class="product-layout" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50">
                <div class="gallery-section" data-aos="fade-right" data-aos-duration="600" data-aos-delay="100">
                    <div class="main-image">
                        <img id="mainImage" src="${product.image}" alt="${escapeHtml(product.name)}" onerror="this.src='https://placehold.co/600x400/2563eb/white?text=${escapeHtml(product.name).substring(0, 20)}'">
                    </div>
                    <div class="thumbnails">
                        <img class="thumbnail active" src="${product.image}" onclick="changeMainImage('${product.image}')" onerror="this.src='https://placehold.co/80x80/2563eb/white?text=Product'">
                    </div>
                </div>
                <div class="info-section" data-aos="fade-left" data-aos-duration="600" data-aos-delay="150">
                    <h1 class="product-title">${escapeHtml(product.name)}</h1>
                    <div class="product-brand"><i class="fas fa-building"></i> Brand: Global Hardware Hub</div>
                    <div class="product-category"><i class="fas fa-microchip"></i> Hardware Component</div>
                    <div class="rating-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <span class="rating-count">(4.5/5 based on customer reviews)</span>
                    </div>
                    <div class="price-container">
                        <span class="current-price">PKR ${product.price.toFixed(2)}</span>
                    </div>
                    <div class="stock-status ${stockClass}"><i class="fas ${product.stock > 0 ? 'fa-check-circle' : 'fa-times-circle'}"></i> ${stockText}</div>
                    <div class="sku-text"><i class="fas fa-hashtag"></i> Product ID: ${product.product_id}</div>
                    <p class="short-description">${escapeHtml(product.description || 'No description available for this product.')}</p>
                    <div class="quantity-selector">
                        <label><i class="fas fa-arrows-alt"></i> Quantity:</label>
                        <input type="number" id="quantityInput" class="quantity-input" value="1" min="1" max="${product.stock > 0 ? product.stock : 1}" ${product.stock <= 0 ? 'disabled' : ''}>
                    </div>
                    <div class="action-buttons">
                        <button class="btn-cart" id="addToCartBtn" ${product.stock <= 0 ? 'disabled style="opacity:0.5; cursor:not-allowed;"' : ''}><i class="fas fa-cart-plus"></i> Add to Cart</button>
                        <button class="btn-wishlist" id="wishlistBtn"><i class="far fa-heart"></i> Wishlist</button>
                        <button class="btn-compare" id="compareBtn" data-product-id="${product.product_id}"><i class="fas fa-chart-simple"></i> Compare</button>
                    </div>
                </div>
            </div>
            <!-- H. Scroll Reveal - Specs Section -->
            <div class="specs-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="30" data-aos-delay="100">
                <h2 class="specs-title"><i class="fas fa-list-ul"></i> Product Specifications</h2>
                <table class="specs-table" style="width: 100%; border-collapse: collapse;">${specsHtml}</table>
            </div>`;
            
            // Refresh AOS for dynamically added elements
            AOS.refresh();
        }

        function setupCartButtons() {
            const addToCartBtn = document.getElementById("addToCartBtn");
            if (addToCartBtn) {
                addToCartBtn.addEventListener("click", async () => {
                    if (!currentProduct) return;
                    if (currentProduct.stock <= 0) {
                        showToastMessage("This product is out of stock!", 'error');
                        return;
                    }
                    const qty = parseInt(document.getElementById("quantityInput")?.value || 1);
                    await addToCart(currentProduct, qty);
                });
            }
        }

        window.changeMainImage = function (src) {
            const mainImage = document.getElementById("mainImage");
            const thumbnails = document.querySelectorAll(".thumbnail");
            if (mainImage) {
                mainImage.src = src;
                thumbnails.forEach(thumb => {
                    thumb.classList.remove("active");
                    if (thumb.src === src) {
                        thumb.classList.add("active");
                    }
                });
            }
        };

        function setupWishlistButton(product) {
            setTimeout(async function () {
                let wishlistBtn = document.getElementById("wishlistBtn");
                if (!wishlistBtn) return;

                await checkUserSession();

                function getWishlistKey() {
                    if (!isUserLoggedIn || !currentUserId) return null;
                    return "wishlist_" + currentUserId.toString().replace(/[^a-zA-Z0-9]/g, '_');
                }

                function getUserWishlist() {
                    let key = getWishlistKey();
                    if (!key) return [];
                    try { return JSON.parse(localStorage.getItem(key) || "[]"); } catch (e) { return []; }
                }

                function saveUserWishlist(wishlist) {
                    let key = getWishlistKey();
                    if (key) localStorage.setItem(key, JSON.stringify(wishlist));
                }

                function updateWishlistButton() {
                    let wishlist = getUserWishlist();
                    let exists = wishlist.some(item => item.id === product.product_id);
                    if (exists) {
                        wishlistBtn.classList.add('active');
                        wishlistBtn.innerHTML = '<i class="fas fa-heart"></i> Wishlist';
                    } else {
                        wishlistBtn.classList.remove('active');
                        wishlistBtn.innerHTML = '<i class="far fa-heart"></i> Wishlist';
                    }
                }

                wishlistBtn.onclick = async function (e) {
                    e.preventDefault();

                    await checkUserSession();

                    if (!isUserLoggedIn) {
                        showToastMessage("Please login to add to wishlist", 'error');
                        setTimeout(() => { window.location.href = "LogIn.php"; }, 1500);
                        return;
                    }

                    let wishlist = getUserWishlist();
                    let exists = wishlist.some(item => item.id === product.product_id);

                    if (exists) {
                        wishlist = wishlist.filter(item => item.id !== product.product_id);
                        saveUserWishlist(wishlist);
                        showToastMessage(`💔 "${product.name}" removed from wishlist`, 'info');
                    } else {
                        wishlist.push({
                            id: product.product_id,
                            name: product.name,
                            price: product.price,
                            image: product.image || "https://placehold.co/300x200/2563eb/white?text=Product"
                        });
                        saveUserWishlist(wishlist);
                        showToastMessage(`❤️ "${product.name}" added to wishlist!`, 'success');
                    }
                    updateWishlistButton();
                };

                updateWishlistButton();
            }, 500);
        }

        function setupCompareButton() {
            const compareBtn = document.getElementById("compareBtn");
            if (!compareBtn) return;
            compareBtn.removeEventListener("click", handleCompareClick);
            compareBtn.addEventListener("click", handleCompareClick);
        }

        async function handleCompareClick(event) {
            const button = event.currentTarget;
            const productId = button.getAttribute("data-product-id");

            await checkUserSession();

            if (!isUserLoggedIn) {
                showToastMessage("Please login to add to comparison", 'error');
                setTimeout(() => { window.location.href = "LogIn.php"; }, 1500);
                return;
            }

            if (!productId) {
                showToastMessage("Invalid product ID", 'error');
                return;
            }

            try {
                const response = await fetch("add_to_comparison.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ product_id: parseInt(productId) })
                });

                const result = await response.json();

                if (result.success) {
                    showToastMessage(result.message || "Product added to comparison", 'success');
                } else {
                    showToastMessage(result.message || "Failed to add product to comparison", 'error');
                }
            } catch (error) {
                console.error("Compare API error:", error);
                showToastMessage("Failed to add product to comparison. Please try again.", 'error');
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

        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        document.querySelector('.cart-icon')?.addEventListener('click', async () => {
            await checkUserSession();
            if (isUserLoggedIn) {
                window.location.href = "Cart.php";
            } else {
                showToastMessage("Please login first to view your cart", 'error');
                setTimeout(() => { window.location.href = "LogIn.php"; }, 1500);
            }
        });

        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();
            fetchAndRenderProduct();
        }

        init();
    </script>
</body>

</html>