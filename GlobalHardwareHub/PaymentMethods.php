<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Payment Methods</title>
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

        /* Payment Container */
        .payment-container {
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
            margin-bottom: 2rem;
        }

        /* Section Cards - White */
        .section-card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.8rem;
            margin-bottom: 2rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        /* A. Section Card Hover Animation */
        .section-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
            gap: 1.2rem;
            margin-top: 0.5rem;
        }

        .card-item {
            background: #F9FAFB;
            border-radius: 24px;
            padding: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border: 1px solid #E5E7EB;
        }

        .card-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            background: #FFFFFF;
            border-color: var(--primary);
        }

        .card-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-icon {
            font-size: 2rem;
            width: 50px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card-item:hover .card-icon {
            transform: scale(1.05);
        }

        .card-details h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #111827;
        }

        .card-number {
            font-family: monospace;
            font-size: 0.85rem;
            color: #6B7280;
        }

        .card-expiry {
            font-size: 0.75rem;
            color: #6B7280;
        }

        .default-badge {
            background: var(--success);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.2rem 0.7rem;
            border-radius: 60px;
            margin-left: 0.5rem;
        }

        .card-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* B. Button Hover Animation */
        .btn-icon {
            background: #FFFFFF;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.25s ease;
            color: #374151;
        }

        .btn-icon:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        /* Form Styles */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .form-group label {
            font-weight: 600;
            color: #374151;
            font-size: 0.85rem;
        }

        .form-group input {
            padding: 0.8rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
            background: #FFFFFF;
        }

        .form-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .cvv-wrapper {
            position: relative;
        }

        .cvv-tooltip {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: help;
            font-size: 1rem;
            color: #6B7280;
            transition: transform 0.2s ease;
        }

        .cvv-tooltip:hover {
            transform: translateY(-50%) scale(1.05);
        }

        .tooltip-text {
            visibility: hidden;
            position: absolute;
            bottom: 130%;
            right: 0;
            background: #1F2937;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 8px;
            font-size: 0.7rem;
            white-space: nowrap;
            z-index: 10;
        }

        .cvv-wrapper:hover .tooltip-text {
            visibility: visible;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin: 1rem 0;
        }

        .checkbox-group label {
            font-size: 0.85rem;
            color: #6B7280;
        }

        /* B. Button Hover Animation */
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.85rem 1.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.25s ease;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Payment History Table */
        .history-table {
            width: 100%;
            border-collapse: collapse;
        }

        .history-table th,
        .history-table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
            transition: background-color 0.2s ease;
        }

        .history-table tr:hover td {
            background-color: #F9FAFB;
        }

        .history-table th {
            color: #6B7280;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .status-completed {
            color: var(--success);
            font-weight: 600;
        }

        .status-pending {
            color: var(--warning);
            font-weight: 600;
        }

        .status-failed {
            color: var(--danger);
            font-weight: 600;
        }

        /* I. Skeleton Loader Animation - Enhanced Pulse/Shimmer */
        .skeleton-loader {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: shimmerPulse 1.5s infinite ease-in-out;
            border-radius: 24px;
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
            .cards-grid {
                grid-template-columns: 1fr;
            }

            .history-table {
                font-size: 0.75rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .section-card {
                padding: 1.2rem;
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

    <div class="payment-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="MyAccount.php">My Account</a> / <span>Payment
                Methods</span>
        </div>
        <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-credit-card"></i> Payment Methods</h1>

        <!-- H. Scroll Reveal - Saved Cards Section -->
        <div class="section-card" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="50">
            <h2 class="section-title"><i class="fas fa-credit-card" style="color: var(--primary);"></i> Saved Cards</h2>
            <div id="savedCardsContainer" class="cards-grid"></div>
        </div>

        <!-- H. Scroll Reveal - Add New Card Section -->
        <div class="section-card" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="100">
            <h2 class="section-title"><i class="fas fa-plus-circle" style="color: var(--primary);"></i> Add New Card
            </h2>
            <form id="addCardForm">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Cardholder Name</label>
                    <input type="text" id="cardName" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-credit-card"></i> Card Number</label>
                    <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Expiry Date (MM/YY)</label>
                        <input type="text" id="expiryDate" placeholder="MM/YY" maxlength="5">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> CVV</label>
                        <div class="cvv-wrapper">
                            <input type="password" id="cvv" placeholder="123" maxlength="4">
                            <span class="cvv-tooltip"><i class="fas fa-question-circle"></i><span class="tooltip-text">3
                                    or 4-digit security code</span></span>
                        </div>
                    </div>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="setDefault">
                    <label for="setDefault"><i class="fas fa-star"></i> Set as default payment method</label>
                </div>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Add Card</button>
            </form>
        </div>

        <!-- H. Scroll Reveal - Payment History Section -->
        <div class="section-card" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="150">
            <h2 class="section-title"><i class="fas fa-history" style="color: var(--primary);"></i> Payment History</h2>
            <div style="overflow-x: auto;">
                <table class="history-table" id="paymentHistoryTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="historyBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- H. Scroll Reveal - Footer -->
    <footer class="footer" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Quick Links 1</h4>
                <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="FAQ.php">FAQs</a>
                <a href="Landing.php">Landing</a>
            </div>
            <div class="footer-col">
                <h4>Quick Links 2</h4>
                <a href="Blog.php">Tech Blog</a>
                <a href="ShippingInfo.php">Shipping Information</a>
                <a href="CookiePolicy.php">Cookie Policy</a>
                <a href="WarrantyInfo.php">Warranty Info</a>
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

        // ============== HELPER FUNCTIONS ==============
        function showMessage(message, isError = false) {
            const popup = document.createElement('div');
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            popup.style.cssText = `
            position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%);
            background: ${isError ? '#ef4444' : '#10b981'}; color: white;
            padding: 0.8rem 1.5rem; border-radius: 60px; z-index: 1001;
            animation: fadeInOut 3s ease forwards; font-weight:500;
        `;
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

        function getCardIcon(cardType) {
            const type = (cardType || '').toLowerCase();
            if (type.includes('visa')) return '<i class="fab fa-cc-visa" style="color:#1a1f71;"></i>';
            if (type.includes('master')) return '<i class="fab fa-cc-mastercard" style="color:#eb001b;"></i>';
            if (type.includes('american') || type.includes('amex')) return '<i class="fab fa-cc-amex" style="color:#2e77bc;"></i>';
            if (type.includes('discover')) return '<i class="fab fa-cc-discover" style="color:#ff6000;"></i>';
            return '<i class="fas fa-credit-card" style="color:var(--primary);"></i>';
        }

        // ============== LOGIN CHECK ==============
        async function checkLoginAndRedirect() {
            await checkUserSession();
            if (!isUserLoggedIn) {
                const container = document.getElementById("savedCardsContainer");
                if (container) {
                    container.innerHTML = '<div class="skeleton-loader"><i class="fas fa-lock"></i> Please login first to view payment methods</div>';
                }
                const historyBody = document.getElementById("historyBody");
                if (historyBody) {
                    historyBody.innerHTML = '<tr><td colspan="5" style="text-align:center;"><i class="fas fa-lock"></i> Please login to view payment history</div></tr>';
                }
                const submitBtn = document.querySelector('#addCardForm button[type="submit"]');
                if (submitBtn) submitBtn.disabled = true;
                showMessage("Please login first to manage payment methods", true);
                setTimeout(() => {
                    window.location.href = "LogIn.php";
                }, 2000);
                return false;
            }
            return true;
        }

        // ============== LOAD PAYMENT METHODS ==============
        async function loadPaymentMethods() {
            await checkUserSession();
            if (!isUserLoggedIn) return;

            const container = document.getElementById("savedCardsContainer");
            container.innerHTML = '<div class="skeleton-loader"><i class="fas fa-spinner fa-pulse"></i> Loading payment methods...</div>';

            try {
                const response = await fetch('get_user_payment_methods.php');
                const result = await response.json();

                if (result.success && result.data && result.data.length > 0) {
                    container.innerHTML = result.data.map(method => {
                        const isDefault = (method.is_default == 1 || method.is_default === true);
                        const cardIcon = getCardIcon(method.card_type);

                        return `
                        <div class="card-item" data-id="${method.payment_id}" data-aos="fade-up" data-aos-duration="400" data-aos-delay="50">
                            <div class="card-info">
                                <div class="card-icon">${cardIcon}</div>
                                <div class="card-details">
                                    <h4><i class="fas fa-user"></i> ${escapeHtml(method.card_holder_name || 'Card Holder')}</h4>
                                    <div class="card-number"><i class="fas fa-credit-card"></i> •••• •••• •••• ${method.card_last4}</div>
                                    <div class="card-expiry"><i class="fas fa-calendar-alt"></i> Expires ${method.expiry_month}/${method.expiry_year}</div>
                                </div>
                                ${isDefault ? '<span class="default-badge"><i class="fas fa-check-circle"></i> Default</span>' : ''}
                            </div>
                            <div class="card-actions">
                                ${!isDefault ? `<button class="btn-icon set-default-btn" data-id="${method.payment_id}"><i class="fas fa-star"></i> Set Default</button>` : ''}
                                <button class="btn-icon delete-btn" data-id="${method.payment_id}"><i class="fas fa-trash-alt"></i> Delete</button>
                            </div>
                        </div>
                    `;
                    }).join('');

                    document.querySelectorAll('.set-default-btn').forEach(btn => {
                        btn.addEventListener('click', () => setDefaultPayment(parseInt(btn.dataset.id)));
                    });
                    document.querySelectorAll('.delete-btn').forEach(btn => {
                        btn.addEventListener('click', () => deletePaymentMethod(parseInt(btn.dataset.id)));
                    });
                    
                    // Refresh AOS for dynamically added elements
                    AOS.refresh();
                } else {
                    container.innerHTML = '<div style="text-align:center; padding:2rem; color:#6B7280;"><i class="fas fa-info-circle"></i> No saved payment methods found. Add a card above.</div>';
                }
            } catch (error) {
                console.error('Load payment methods error:', error);
                container.innerHTML = '<div style="text-align:center; padding:2rem; color:var(--danger);"><i class="fas fa-exclamation-circle"></i> Failed to load payment methods. Please refresh the page.</div>';
            }
        }

        // ============== ADD PAYMENT METHOD ==============
        async function addPaymentMethod(formData) {
            try {
                const response = await fetch('add_user_payment_method.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (result.success) {
                    showMessage('Payment method added successfully!');
                    document.getElementById('addCardForm').reset();
                    await loadPaymentMethods();
                    return true;
                } else {
                    showMessage(result.message || 'Failed to add payment method', true);
                    return false;
                }
            } catch (error) {
                console.error('Add payment method error:', error);
                showMessage('Failed to add payment method. Please try again.', true);
                return false;
            }
        }

        // ============== DELETE PAYMENT METHOD ==============
        async function deletePaymentMethod(paymentId) {
            if (!confirm('Are you sure you want to remove this payment method?')) return;

            try {
                const response = await fetch('delete_user_payment_method.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ payment_id: paymentId })
                });

                const result = await response.json();

                if (result.success) {
                    showMessage('Payment method deleted successfully!');
                    await loadPaymentMethods();
                } else {
                    showMessage(result.message || 'Failed to delete payment method', true);
                }
            } catch (error) {
                console.error('Delete payment method error:', error);
                showMessage('Failed to delete payment method. Please try again.', true);
            }
        }

        // ============== SET DEFAULT PAYMENT METHOD ==============
        async function setDefaultPayment(paymentId) {
            try {
                const response = await fetch('set_default_payment_method.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ payment_id: paymentId })
                });

                const result = await response.json();

                if (result.success) {
                    showMessage('Default payment method updated!');
                    await loadPaymentMethods();
                } else {
                    showMessage(result.message || 'Failed to set default payment method', true);
                }
            } catch (error) {
                console.error('Set default payment method error:', error);
                showMessage('Failed to update default payment method. Please try again.', true);
            }
        }

        // ============== LOAD PAYMENT HISTORY ==============
        async function loadPaymentHistory() {
            await checkUserSession();
            if (!isUserLoggedIn) return;

            const tbody = document.getElementById("historyBody");
            tbody.innerHTML = '<tr><td colspan="5"><div class="skeleton-loader"><i class="fas fa-spinner fa-pulse"></i> Loading payment history...</div></td></tr>';

            try {
                const response = await fetch('get_payment_history.php');
                const result = await response.json();

                if (result.success && result.data && result.data.length > 0) {
                    tbody.innerHTML = result.data.map((payment, index) => {
                        let statusClass = '';
                        let statusText = payment.payment_status || 'Pending';
                        if (statusText.toLowerCase() === 'completed') statusClass = 'status-completed';
                        else if (statusText.toLowerCase() === 'pending') statusClass = 'status-pending';
                        else if (statusText.toLowerCase() === 'failed') statusClass = 'status-failed';

                        return `
                        <tr data-aos="fade-up" data-aos-duration="300" data-aos-delay="${index * 30}">
                            <td>${escapeHtml(payment.order_id || payment.payment_id || 'N/A')}</td>
                            <td>${escapeHtml(payment.payment_date || payment.date || 'N/A')}</td>
                            <td>$${parseFloat(payment.amount || 0).toFixed(2)}</td>
                            <td>${escapeHtml(payment.payment_method || 'N/A')}</td>
                            <td class="${statusClass}"><i class="fas ${statusText.toLowerCase() === 'completed' ? 'fa-check-circle' : (statusText.toLowerCase() === 'pending' ? 'fa-clock' : 'fa-times-circle')}"></i> ${escapeHtml(statusText)}</td>
                        </tr>
                    `;
                    }).join('');
                    AOS.refresh();
                } else {
                    tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;"><i class="fas fa-history"></i> No payment history available</div></tr>';
                }
            } catch (error) {
                console.error('Load payment history error:', error);
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;"><i class="fas fa-exclamation-circle"></i> Failed to load payment history</div></tr>';
            }
        }

        // ============== FORM HANDLING ==============
        const cardNumberInput = document.getElementById("cardNumber");
        cardNumberInput?.addEventListener("input", (e) => {
            let value = e.target.value.replace(/\s/g, '');
            if (value.length > 16) value = value.slice(0, 16);
            let formatted = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) formatted += ' ';
                formatted += value[i];
            }
            e.target.value = formatted;
        });

        const expiryInput = document.getElementById("expiryDate");
        expiryInput?.addEventListener("input", (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            e.target.value = value;
        });

        const addCardForm = document.getElementById("addCardForm");
        addCardForm?.addEventListener("submit", async (e) => {
            e.preventDefault();

            const name = document.getElementById("cardName").value.trim();
            const cardNumberRaw = document.getElementById("cardNumber").value.replace(/\s/g, '');
            const expiry = document.getElementById("expiryDate").value.trim();
            const cvv = document.getElementById("cvv").value.trim();
            const setDefaultChecked = document.getElementById("setDefault").checked;

            if (!name) {
                showMessage("Please enter cardholder name", true);
                return;
            }
            if (!/^\d{13,16}$/.test(cardNumberRaw)) {
                showMessage("Please enter a valid card number (13-16 digits)", true);
                return;
            }
            if (!/^\d{2}\/\d{2}$/.test(expiry)) {
                showMessage("Please enter expiry date in MM/YY format", true);
                return;
            }
            if (!/^\d{3,4}$/.test(cvv)) {
                showMessage("Please enter a valid CVV (3-4 digits)", true);
                return;
            }

            const formData = {
                cardholder_name: name,
                card_number: cardNumberRaw,
                expiry_date: expiry,
                cvv: cvv,
                is_default: setDefaultChecked ? 'on' : 'off'
            };

            const btn = e.target.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Adding...';
            btn.disabled = true;

            await addPaymentMethod(formData);

            btn.innerHTML = originalText;
            btn.disabled = false;
        });

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

        // Cart click handler
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
        backBtn?.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // ============== INITIALIZE PAGE ==============
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();

            if (await checkLoginAndRedirect()) {
                await loadPaymentMethods();
                await loadPaymentHistory();
            }
        }

        init();
    </script>
</body>

</html>