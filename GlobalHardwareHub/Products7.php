<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Products Page 1</title>
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

        /* Products Layout */
        .products-layout {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            display: flex;
            gap: 2rem;
        }

        /* Filter Sidebar - White Card */
        .filter-sidebar {
            width: 280px;
            flex-shrink: 0;
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 100px;
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .filter-sidebar:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .filter-title {
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

        .filter-group {
            margin-bottom: 1.5rem;
        }

        .filter-group label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .filter-select,
        .filter-input {
            width: 100%;
            padding: 0.7rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 16px;
            font-size: 0.85rem;
            background: #FFFFFF;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-select:focus,
        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .price-range {
            display: flex;
            gap: 0.8rem;
        }

        .price-range .filter-input {
            width: 50%;
        }

        .filter-buttons {
            display: flex;
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .btn-apply {
            flex: 1;
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.7rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        /* B. Button Hover Animation */
        .btn-apply:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-reset {
            flex: 1;
            background: #F3F4F6;
            color: #374151;
            border: none;
            padding: 0.7rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        /* B. Button Hover Animation */
        .btn-reset:hover {
            background: #E5E7EB;
            transform: translateY(-2px) scale(1.02);
        }

        /* Products Main */
        .products-main {
            flex: 1;
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
            font-size: 2rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFFFFF 0%, #c7d2fe 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.8rem;
        }

        /* A. Product Card Hover Animation */
        .product-card {
            background: #FFFFFF;
            border-radius: 28px;
            padding: 1.2rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.25);
        }

        /* D. Product Image Zoom Animation */
        .product-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 20px;
            background: #F3F4F6;
            transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .product-card:hover .product-img {
            transform: scale(1.05);
        }

        .product-name {
            font-weight: 700;
            margin: 0.8rem 0 0.3rem;
            font-size: 0.95rem;
            color: #111827;
        }

        .product-category {
            font-size: 0.7rem;
            color: #6B7280;
            margin-bottom: 0.3rem;
        }

        .product-price {
            font-weight: 800;
            color: var(--primary);
            font-size: 1.1rem;
            margin: 0.4rem 0;
        }

        .product-actions {
            display: flex;
            gap: 0.6rem;
            margin-top: 0.8rem;
            flex-wrap: wrap;
        }

        /* B. Button Hover Animation */
        .btn-cart {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.45rem 0.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            flex: 1;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-cart:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        /* B. Button Hover Animation */
        .btn-details {
            background: #F3F4F6;
            color: #374151;
            border: none;
            padding: 0.45rem 0.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            flex: 1;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-details:hover {
            background: #E5E7EB;
            transform: translateY(-2px) scale(1.02);
        }

        /* B. Button Hover Animation */
        .btn-wishlist {
            background: #FEF2F2;
            color: var(--danger);
            border: 1px solid #FECACA;
            padding: 0.45rem 0.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            flex: 1;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
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

        /* B. Button Hover Animation */
        .btn-compare {
            background: #F3F4F6;
            color: #374151;
            border: 1px solid #E5E7EB;
            padding: 0.45rem 0.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            flex: 1;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-compare:hover {
            background: #E5E7EB;
            transform: translateY(-2px) scale(1.02);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.8rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        /* B. Button Hover Animation */
        .page-btn {
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            padding: 0.6rem 1.2rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            color: #374151;
            transition: all 0.2s ease;
        }

        .page-btn:hover {
            background: #F3F4F6;
            transform: translateY(-2px) scale(1.02);
        }

        .page-btn.active {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* I. Skeleton Loader Animation - Enhanced Pulse/Shimmer */
        .loading-spinner {
            text-align: center;
            padding: 3rem;
            color: var(--primary);
            font-size: 1rem;
            grid-column: 1 / -1;
            background: #FFFFFF;
            border-radius: 28px;
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

        .no-products {
            text-align: center;
            padding: 3rem;
            color: #6B7280;
            font-size: 1rem;
            grid-column: 1 / -1;
            background: #FFFFFF;
            border-radius: 28px;
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

        @media (max-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .products-layout {
                flex-direction: column;
            }
            .filter-sidebar {
                width: 100%;
                position: static;
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
            .products-grid {
                grid-template-columns: 1fr;
            }
            .page-title {
                font-size: 1.6rem;
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

    <div class="products-layout">
        <!-- H. Scroll Reveal - Filter Sidebar -->
        <aside class="filter-sidebar" data-aos="fade-right" data-aos-duration="600" data-aos-offset="100">
            <div class="filter-title"><i class="fas fa-sliders-h"></i> Filter Products</div>

            <div class="filter-group">
                <label><i class="fas fa-tag"></i> Category</label>
                <select id="filterCategory" class="filter-select">
                    <option value="">All Categories</option>
                    <option value="CPU">CPU</option>
                    <option value="GPU">GPU</option>
                    <option value="Motherboard">Motherboard</option>
                    <option value="networking_devices">Networking Devices</option>
                    <option value="storage_devices">Storage Devices</option>
                    <option value="peripheral_devices">Peripheral Devices</option>
                    <option value="laptop_parts">Laptop Parts</option>
                    <option value="mobile_parts">Mobile Parts</option>
                </select>
            </div>

            <div class="filter-group">
                <label><i class="fas fa-building"></i> Brand</label>
                <select id="filterBrand" class="filter-select">
                    <option value="">All Brands</option>
                    <option value="hp">HP</option>
                    <option value="dell">Dell</option>
                    <option value="lenovo">Lenovo</option>
                    <option value="asus">ASUS</option>
                    <option value="amd">AMD</option>
                    <option value="nvidia">NVIDIA</option>
                    <option value="samsung">Samsung</option>
                    <option value="kingston">Kingston</option>
                    <option value="seagate">Seagate</option>
                    <option value="crucial">Crucial</option>
                </select>
            </div>

            <div class="filter-group">
                <label><i class="fas fa-dollar-sign"></i> Price Range</label>
                <div class="price-range">
                    <input type="number" id="filterMinPrice" class="filter-input" placeholder="Min $" min="0" step="1">
                    <input type="number" id="filterMaxPrice" class="filter-input" placeholder="Max $" min="0" step="1">
                </div>
            </div>

            <div class="filter-buttons">
                <button id="applyFilterBtn" class="btn-apply" style="display: none;"><i class="fas fa-check"></i> Apply
                    Filters</button>
                <button id="resetFilterBtn" class="btn-reset"><i class="fas fa-redo-alt"></i> Reset</button>
            </div>
        </aside>

        <main class="products-main">
            <div class="breadcrumb"><a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Products</span>
            </div>
            <h1 class="page-title"><i class="fas fa-microchip"></i> All Products</h1>
            <!-- H. Scroll Reveal - Products Grid with AOS container -->
            <div class="products-grid" id="productsGrid" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50">
                <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading products...</div>
            </div>
            <div class="pagination" id="paginationContainer" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30"></div>
        </main>
    </div>

    <!-- H. Scroll Reveal - Footer -->
    <footer class="footer" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Quick Links 1</h4>
                <a href="AboutUs.php">About Us</a>
                <a href="ContactUs.php">Contact Support</a>
                <a href="SupportTicket.php">Support Ticket</a>
                <a href="ReturnPolicy.php">Return Policy</a>
            </div>
            <div class="footer-col">
                <h4>Quick Links 2</h4>
                <a href="ShippingInfo.php">Shipping Info</a>
                <a href="Blog.php">Tech Blog</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="AddressBook.php">Address Book</a>
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
                console.log('Not showing cart count - logged in:', isUserLoggedIn, 'isCustomer:', isCustomerRole);
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

        // ========== ADD TO CART FUNCTION WITH ROLE CHECK ==========
        async function addToCart(product) {
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
            formData.append('quantity', 1);

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

        // ========== ADD TO COMPARE FUNCTION ==========
        async function addToCompare(productId, productName) {
            await checkUserSession();

            if (!isUserLoggedIn) {
                showToastMessage("Please login first to add products to comparison", 'error');
                setTimeout(() => {
                    window.location.href = "LogIn.php";
                }, 1500);
                return;
            }

            const formData = new FormData();
            formData.append('product_id', productId);

            try {
                const response = await fetch('add_to_comparison.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showToastMessage(`${productName} added to comparison list!`, 'success');
                    const btn = document.querySelector(`.btn-compare[data-product-id="${productId}"]`);
                    if (btn) {
                        const originalText = btn.innerHTML;
                        btn.innerHTML = '✓ Added';
                        btn.style.background = '#10b981';
                        btn.style.color = 'white';
                        setTimeout(() => {
                            btn.innerHTML = originalText;
                            btn.style.background = '#F3F4F6';
                            btn.style.color = '#374151';
                        }, 2000);
                    }
                } else {
                    showToastMessage(result.message || "Failed to add to comparison", 'error');
                }
            } catch (error) {
                console.error('Error adding to compare:', error);
                showToastMessage("Connection error. Please try again.", 'error');
            }
        }

        // ========== ADD TO WISHLIST FUNCTION ==========
        async function addToWishlist(productId, productName, productPrice, productImage) {
            await checkUserSession();

            if (!isUserLoggedIn) {
                showToastMessage("Please login first to add to wishlist", 'error');
                setTimeout(() => {
                    window.location.href = "LogIn.php";
                }, 1500);
                return false;
            }

            const formData = new FormData();
            formData.append('action', 'add_to_wishlist');
            formData.append('product_id', productId);

            try {
                const response = await fetch('Wishlist.php', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showToastMessage(`${productName} added to wishlist!`, 'success');
                    const btn = document.querySelector(`.wishlistBtn[data-product-id="${productId}"]`);
                    if (btn) {
                        btn.classList.add('active');
                        btn.innerHTML = '❤️ Wishlist';
                    }
                    return true;
                } else if (result.message && result.message.includes('already')) {
                    showToastMessage(`${productName} is already in your wishlist!`, 'info');
                    return false;
                } else {
                    showToastMessage(result.message || "Failed to add to wishlist", 'error');
                    return false;
                }
            } catch (error) {
                console.error("Error adding to wishlist:", error);
                showToastMessage("Connection error. Please try again.", 'error');
                return false;
            }
        }

        // ========== REMOVE FROM WISHLIST FUNCTION ==========
        async function removeFromWishlist(productId, productName) {
            await checkUserSession();

            if (!isUserLoggedIn) {
                return false;
            }

            const formData = new FormData();
            formData.append('action', 'remove_item');
            formData.append('product_id', productId);

            try {
                const response = await fetch('Wishlist.php', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showToastMessage(`${productName} removed from wishlist`, 'info');
                    const btn = document.querySelector(`.wishlistBtn[data-product-id="${productId}"]`);
                    if (btn) {
                        btn.classList.remove('active');
                        btn.innerHTML = '♡ Wishlist';
                    }
                    return true;
                }
                return false;
            } catch (error) {
                console.error("Error removing from wishlist:", error);
                return false;
            }
        }

        // ========== TOAST MESSAGE FUNCTION ==========
        function showToastMessage(message, type = 'success') {
            const existingToast = document.querySelector('.custom-toast');
            if (existingToast) existingToast.remove();

            const toast = document.createElement('div');
            toast.className = 'custom-toast';
            toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle')}"></i> ${message}`;

            let bgColor = '#10b981';
            if (type === 'error') bgColor = '#ef4444';
            if (type === 'info') bgColor = '#3b82f6';

            toast.style.cssText = `
                position: fixed;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                background: ${bgColor};
                color: white;
                padding: 12px 24px;
                border-radius: 60px;
                font-size: 14px;
                font-weight: 500;
                z-index: 10001;
                animation: slideUp 0.3s ease, fadeOut 0.3s ease 2.5s forwards;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                pointer-events: none;
            `;

            document.body.appendChild(toast);
            setTimeout(() => {
                if (toast && toast.remove) toast.remove();
            }, 3000);
        }

        function viewDetails(productId) {
            window.location.href = `ProductDetails.php?id=${productId}`;
        }

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

        // ========== LIVE AJAX FILTERING ==========
        let currentPage = 1;
        let totalPages = 1;
        let debounceTimer = null;
        let isFiltering = false;

        function getFilters() {
            const category = document.getElementById('filterCategory')?.value || '';
            const brand = document.getElementById('filterBrand')?.value || '';
            const minPrice = document.getElementById('filterMinPrice')?.value || '';
            const maxPrice = document.getElementById('filterMaxPrice')?.value || '';
            return { category, brand, minPrice, maxPrice };
        }

        function buildApiUrl(page, filters) {
            let url = `get_filtered_products.php?page=${page}&limit=12`;
            if (filters.category && filters.category !== '') {
                url += `&category=${encodeURIComponent(filters.category)}`;
            }
            if (filters.brand && filters.brand !== '') {
                url += `&brand=${encodeURIComponent(filters.brand)}`;
            }
            if (filters.minPrice && filters.minPrice !== '') {
                url += `&min_price=${parseFloat(filters.minPrice)}`;
            }
            if (filters.maxPrice && filters.maxPrice !== '') {
                url += `&max_price=${parseFloat(filters.maxPrice)}`;
            }
            return url;
        }

        async function fetchProducts(page = 1, showLoading = true) {
            if (isFiltering) return;

            const grid = document.getElementById("productsGrid");
            if (showLoading) {
                grid.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading products...</div>';
            }

            const filters = getFilters();
            const apiUrl = buildApiUrl(page, filters);

            try {
                isFiltering = true;
                const response = await fetch(apiUrl);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success === false || data.error) {
                    console.error("API Error:", data.message);
                    grid.innerHTML = `<div class="no-products"><i class="fas fa-exclamation-circle"></i> Error loading products: ${data.message || 'Unknown error'}</div>`;
                    return;
                }

                const products = data.products || [];
                currentPage = data.pagination?.current_page || page;
                totalPages = data.pagination?.total_pages || 1;

                if (!products || products.length === 0) {
                    grid.innerHTML = `<div class="no-products"><i class="fas fa-search"></i> No products found matching your criteria.</div>`;
                } else {
                    renderProducts(products);
                    await loadWishlistStatus();
                }

                renderPagination();

            } catch (error) {
                console.error("Fetch error:", error);
                grid.innerHTML = `<div class="no-products"><i class="fas fa-wifi"></i> Failed to load products. Please check if server is running.</div>`;
            } finally {
                isFiltering = false;
            }
        }

        function renderPagination() {
            const paginationContainer = document.getElementById("paginationContainer");
            if (!paginationContainer) return;

            if (totalPages <= 1) {
                paginationContainer.innerHTML = '';
                return;
            }

            let paginationHtml = '';
            const maxVisible = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
            let endPage = Math.min(totalPages, startPage + maxVisible - 1);

            if (endPage - startPage < maxVisible - 1) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }

            if (startPage > 1) {
                paginationHtml += `<button class="page-btn" data-page="1">1</button>`;
                if (startPage > 2) paginationHtml += `<button class="page-btn disabled">...</button>`;
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) paginationHtml += `<button class="page-btn disabled">...</button>`;
                paginationHtml += `<button class="page-btn" data-page="${totalPages}">${totalPages}</button>`;
            }

            paginationContainer.innerHTML = paginationHtml;

            document.querySelectorAll('.page-btn[data-page]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const pageNum = parseInt(btn.getAttribute('data-page'));
                    if (!isNaN(pageNum) && pageNum !== currentPage) {
                        currentPage = pageNum;
                        fetchProducts(currentPage, true);
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                });
            });
        }

        async function loadWishlistStatus() {
            if (!isUserLoggedIn) return;
            try {
                document.querySelectorAll('.wishlistBtn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.innerHTML = '<i class="far fa-heart"></i> Wishlist';
                });
            } catch (error) {
                console.error("Error loading wishlist status:", error);
            }
        }

        function renderProducts(products) {
            const grid = document.getElementById("productsGrid");
            
            // Add AOS fade-up with staggered delay for each product
            const productsHTML = products.map((product, index) => {
                const escapedName = product.name.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const imageUrl = product.image_url && product.image_url !== "default-product.jpg" && product.image_url !== "placeholder.jpg"
                    ? product.image_url
                    : "https://placehold.co/300x200/2563eb/white?text=Product";

                return `
                    <div class="product-card" data-product-id="${product.product_id}" data-aos="fade-up" data-aos-duration="400" data-aos-delay="${(index % 12) * 50}">
                        <img class="product-img" src="${imageUrl}" alt="${product.name}" onerror="this.src='https://placehold.co/300x200/2563eb/white?text=Product'">
                        <div class="product-name">${escapeHtml(product.name)}</div>
                        <div class="product-category"><i class="fas fa-folder"></i> ${escapeHtml(product.category || 'Hardware')}</div>
                        <div class="product-price">PKR ${typeof product.price === 'number' ? product.price.toFixed(2) : product.price}</div>
                        <div class="product-actions">
                            <button class="btn-cart" onclick="addToCart({id:${product.product_id}, name:'${escapedName}', price:${product.price}, image:'${imageUrl}'})"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                            <button class="btn-compare" data-product-id="${product.product_id}" onclick="addToCompare(${product.product_id}, '${escapedName}')"><i class="fas fa-chart-simple"></i> Compare</button>
                            <button class="btn-wishlist wishlistBtn" data-product-id="${product.product_id}" data-product-name="${escapedName}" data-product-price="${product.price}" data-product-image="${imageUrl}"><i class="far fa-heart"></i> Wishlist</button>
                            <button class="btn-details" onclick="viewDetails(${product.product_id})"><i class="fas fa-eye"></i> View Details</button>
                        </div>
                    </div>
                `;
            }).join('');

            grid.innerHTML = productsHTML;
            attachWishlistEvents();
            // Refresh AOS for dynamically added elements
            AOS.refresh();
        }

        function attachWishlistEvents() {
            document.querySelectorAll('.wishlistBtn').forEach(btn => {
                const newBtn = btn.cloneNode(true);
                btn.parentNode.replaceChild(newBtn, btn);

                newBtn.onclick = async function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const productId = parseInt(this.getAttribute('data-product-id'));
                    const productName = this.getAttribute('data-product-name');
                    const productPrice = parseFloat(this.getAttribute('data-product-price'));
                    const productImage = this.getAttribute('data-product-image');
                    const isActive = this.classList.contains('active');

                    if (isActive) {
                        await removeFromWishlist(productId, productName);
                    } else {
                        await addToWishlist(productId, productName, productPrice, productImage);
                    }
                };
            });
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

        function triggerLiveFilter() {
            if (debounceTimer) {
                clearTimeout(debounceTimer);
            }
            debounceTimer = setTimeout(() => {
                currentPage = 1;
                fetchProducts(1, true);
            }, 500);
        }

        function resetFilters() {
            const categorySelect = document.getElementById('filterCategory');
            const brandSelect = document.getElementById('filterBrand');
            const minPriceInput = document.getElementById('filterMinPrice');
            const maxPriceInput = document.getElementById('filterMaxPrice');

            if (categorySelect) categorySelect.value = '';
            if (brandSelect) brandSelect.value = '';
            if (minPriceInput) minPriceInput.value = '';
            if (maxPriceInput) maxPriceInput.value = '';

            currentPage = 1;
            fetchProducts(1, true);
        }

        // Back to Top
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // Cart click
        document.querySelector('.cart-icon')?.addEventListener('click', async () => {
            await checkUserSession();
            if (!isUserLoggedIn) {
                showToastMessage("Please login first to view your cart", 'error');
                window.location.href = "LogIn.php";
            } else {
                window.location.href = "Cart.php";
            }
        });

        // Make functions global
        window.addToCart = addToCart;
        window.addToCompare = addToCompare;
        window.viewDetails = viewDetails;
        window.addToWishlist = addToWishlist;
        window.removeFromWishlist = removeFromWishlist;

        // ========== INITIALIZE PAGE ==========
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();

            const resetBtn = document.getElementById('resetFilterBtn');
            if (resetBtn) resetBtn.addEventListener('click', resetFilters);

            const categorySelect = document.getElementById('filterCategory');
            const brandSelect = document.getElementById('filterBrand');
            const minPriceInput = document.getElementById('filterMinPrice');
            const maxPriceInput = document.getElementById('filterMaxPrice');

            if (categorySelect) categorySelect.addEventListener('change', triggerLiveFilter);
            if (brandSelect) brandSelect.addEventListener('change', triggerLiveFilter);
            if (minPriceInput) minPriceInput.addEventListener('input', triggerLiveFilter);
            if (maxPriceInput) maxPriceInput.addEventListener('input', triggerLiveFilter);

            const authBtn = document.getElementById("authButton");
            if (authBtn) authBtn.addEventListener("click", handleAuthClick);

            fetchProducts(1, true);
        }

        init();
    </script>
</body>

</html>