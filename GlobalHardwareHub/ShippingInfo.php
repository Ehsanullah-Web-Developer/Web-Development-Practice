<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Shipping Information</title>
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

        /* Shipping Container */
        .shipping-container {
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
        /* A. Section Card Hover Animation */
        .section-card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.8rem;
            margin-bottom: 2rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            scroll-margin-top: 100px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .section-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }

        .section-card.highlight {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.3);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.3rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.2rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid #E5E7EB;
        }

        .section-icon {
            font-size: 1.6rem;
            transition: transform 0.3s ease;
        }

        .section-card:hover .section-icon {
            transform: scale(1.05);
        }

        /* Table Styles */
        .table-wrapper {
            overflow-x: auto;
        }

        .shipping-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 20px;
            overflow: hidden;
        }

        .shipping-table th,
        .shipping-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
            transition: background-color 0.2s ease;
        }

        .shipping-table th {
            background: #F9FAFB;
            color: #111827;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .shipping-table tr:hover td {
            background: #F9FAFB;
        }

        .delivery-date {
            color: var(--success);
            font-weight: 600;
        }

        /* Policy Content */
        .policy-content {
            line-height: 1.7;
            color: #374151;
        }

        .policy-content p {
            margin-bottom: 0.8rem;
        }

        .policy-content ul {
            margin-left: 1.5rem;
            margin-bottom: 0.8rem;
        }

        .policy-content li {
            margin-bottom: 0.3rem;
            transition: all 0.2s ease;
        }

        .policy-content li:hover {
            transform: translateX(4px);
        }

        .highlight-box {
            background: #F9FAFB;
            padding: 1rem 1.2rem;
            border-radius: 20px;
            margin-top: 1rem;
            border-left: 4px solid var(--primary);
            transition: all 0.2s ease;
        }

        .highlight-box:hover {
            transform: scale(1.02);
            background: #FFFFFF;
            box-shadow: var(--shadow-sm);
        }

        /* B. Tracking Link Hover Animation */
        .tracking-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
        }

        .tracking-link:hover {
            gap: 12px;
            text-decoration: underline;
            transform: translateX(4px);
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
            .shipping-table th,
            .shipping-table td {
                padding: 0.8rem;
                font-size: 0.85rem;
            }

            .section-title {
                font-size: 1.1rem;
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

    <div class="shipping-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Shipping Information</span>
        </div>
        <!-- H. Scroll Reveal - Page Title -->
        <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-truck-fast"></i> Shipping Information</h1>

        <!-- H. Scroll Reveal - Shipping Methods Card -->
        <div id="shipping-methods" class="section-card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="50">
            <div class="section-title">
                <span class="section-icon"><i class="fas fa-box"></i></span>
                <h2>Shipping Methods & Rates</h2>
            </div>
            <div class="table-wrapper">
                <table class="shipping-table">
                    <thead>
                        <tr>
                            <th>Shipping Method</th>
                            <th>Cost</th>
                            <th>Estimated Delivery Time</th>
                            <th>Delivery Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                            <td><strong><i class="fas fa-truck"></i> Standard Shipping</strong></td>
                            <td>Free on orders $99+ / $5.99</div>
                            <td>3-7 business days</div>
                            <td class="delivery-date" id="standardDate">Calculating...</div>
                        </tr>
                        <tr data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                            <td><strong><i class="fas fa-rocket"></i> Express Shipping</strong></div>
                            <td>$12.99</div>
                            <td>2-3 business days</div>
                            <td class="delivery-date" id="expressDate">Calculating...</div>
                        </tr>
                        <tr data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                            <td><strong><i class="fas fa-bolt"></i> Overnight Shipping</strong></div>
                            <td>$24.99</div>
                            <td>1 business day</div>
                            <td class="delivery-date" id="overnightDate">Calculating...</div>
                        </tr>
                        <tr data-aos="fade-up" data-aos-duration="300" data-aos-delay="200">
                            <td><strong><i class="fas fa-globe"></i> International Shipping</strong></div>
                            <td>Calculated at checkout</div>
                            <td>7-21 business days</div>
                            <td class="delivery-date">Varies by destination</div>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- H. Scroll Reveal - International Shipping Card -->
        <div id="international" class="section-card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="100">
            <div class="section-title">
                <span class="section-icon"><i class="fas fa-globe-americas"></i></span>
                <h2>International Shipping Policy</h2>
            </div>
            <div class="policy-content">
                <p data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">We ship to over 50 countries worldwide, including Canada, United Kingdom, Australia, Germany, France,
                    and many more.</p>
                <ul>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="80"><strong>Additional Fees:</strong> International shipping rates are calculated at checkout based
                        on destination and package weight.</li>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="110"><strong>Customs Duties & Taxes:</strong> Import duties, taxes, and customs clearance fees are
                        the responsibility of the customer and are not included in the shipping cost.</li>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="140"><strong>Delivery Delays:</strong> Customs processing may cause delays beyond our estimated
                        delivery times. We recommend checking your local customs policies before ordering.</li>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="170"><strong>Restricted Items:</strong> Some products may have shipping restrictions to certain
                        countries due to local regulations.</li>
                </ul>
                <div class="highlight-box" data-aos="fade-up" data-aos-duration="300" data-aos-delay="200">
                    <i class="fas fa-info-circle"></i> <strong>Note:</strong> International orders typically take 7-21
                    business days for delivery. Tracking information is provided for all international shipments.
                </div>
            </div>
        </div>

        <!-- H. Scroll Reveal - Order Processing Card -->
        <div id="processing" class="section-card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="150">
            <div class="section-title">
                <span class="section-icon"><i class="fas fa-hourglass-half"></i></span>
                <h2>Order Processing Time</h2>
            </div>
            <div class="policy-content">
                <p data-aos="fade-up" data-aos-duration="300" data-aos-delay="50"><strong>Processing Time:</strong> Orders are processed within 1-2 business days (Monday-Friday,
                    excluding holidays).</p>
                <ul>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="80"><strong>Cut-off Time:</strong> Orders placed before 2:00 PM EST are typically processed the same
                        business day.</li>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="110"><strong>Weekend Orders:</strong> Orders placed on Saturday or Sunday will be processed on the
                        following Monday.</li>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="140"><strong>Holiday Schedule:</strong> Processing may be delayed during major holidays. We'll post
                        announcements on our homepage.</li>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="170"><strong>High Volume Periods:</strong> During sales events, processing may take 2-3 business
                        days.</li>
                </ul>
                <div class="highlight-box" data-aos="fade-up" data-aos-duration="300" data-aos-delay="200">
                    <i class="fas fa-star"></i> <strong>Express & Overnight Shipping:</strong> Orders with expedited
                    shipping placed before cut-off time receive priority processing.
                </div>
            </div>
        </div>

        <!-- H. Scroll Reveal - Tracking Card -->
        <div id="tracking" class="section-card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="200">
            <div class="section-title">
                <span class="section-icon"><i class="fas fa-search"></i></span>
                <h2>Tracking Your Order</h2>
            </div>
            <div class="policy-content">
                <p data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">Once your order ships, you'll receive a confirmation email with tracking information. You can also
                    track your order directly on our website.</p>
                <ul>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="80"><strong>Tracking Email:</strong> Sent within 24 hours after your order ships. Check your spam
                        folder if you don't see it.</li>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="110"><strong>Tracking Updates:</strong> Allow 24-48 hours for tracking information to appear after
                        receiving the tracking number.</li>
                    <li data-aos="fade-right" data-aos-duration="200" data-aos-delay="140"><strong>Order Status:</strong> Log into your account to view real-time order status and tracking
                        details.</li>
                </ul>
                <div style="margin-top: 1rem;" data-aos="fade-up" data-aos-duration="300" data-aos-delay="170">
                    <a href="OrderTracking.php" class="tracking-link" id="trackingPageLink"><i
                            class="fas fa-map-marked-alt"></i> Track Your Order →</a>
                </div>
            </div>
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
                <a href="Blog.php">Tech Blog</a>
                <a href="Landing.php">Landing</a>
                <a href="TermsofService.php">Terms Of Service</a>
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
                { title: "Vendors", submenu: ["Vendors List", "Vendors Store", "Vendors Setting", "Vendors Dashboard", "Vendors Products", "Vendors Add Products", "Vendors Edit Products", "Vendors Reviews", "Vendors Orders", "Vendor Order Details"], links: ["Vendors.php", "VendorsStore.php", "VendorSettings.php", "VendorDashboard.php", "VendorProductsManagement.php", "VendorAddProducts.php", "VendorEditProducts.php", "VendorReviews.php", "VendorOrders.php", "VendorOrderDetails.php"] },
                { title: "Account", submenu: ["My Account", "Profile", "Orders", "Order Details", "Wishlist", "Address Book", "Payment Methods", "Cart", "Checkout", "Checkout Shipping", "Checkout Payment"], links: ["MyAccount.php", "Profile.php", "UserOrders.php", "UserOrderDetails.php", "Wishlist.php", "AddressBook.php", "PaymentMethods.php", "Cart.php", "Checkout.php", "CheckoutShipping.php", "CheckoutPayment.php"] },
                { title: "Support", submenu: ["Contact", "FAQ", "Shipping Info", "Warranty Info", "Return Policy", "Privacy Policy", "Terms of Service", "About Us", "Cookie Policy", "Order Tracking", "Support Ticket"], links: ["ContactUs.php", "FAQ.php", "ShippingInfo.php", "WarrantyInfo.php", "ReturnPolicy.php", "PrivacyPolicy.php", "TermsofService.php", "AboutUs.php", "CookiePolicy.php", "OrderTracking.php", "SupportTicket.php"] },
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

        // Calculate estimated delivery dates
        function calculateDeliveryDates() {
            const today = new Date();

            const standardDate = new Date(today);
            standardDate.setDate(today.getDate() + 5);
            const standardFormatted = standardDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            document.getElementById('standardDate').innerHTML = `Est. ${standardFormatted}`;

            const expressDate = new Date(today);
            expressDate.setDate(today.getDate() + 3);
            const expressFormatted = expressDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            document.getElementById('expressDate').innerHTML = `Est. ${expressFormatted}`;

            const overnightDate = new Date(today);
            overnightDate.setDate(today.getDate() + 1);
            if (overnightDate.getDay() === 0) overnightDate.setDate(today.getDate() + 2);
            if (overnightDate.getDay() === 6) overnightDate.setDate(today.getDate() + 3);
            const overnightFormatted = overnightDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            document.getElementById('overnightDate').innerHTML = `Est. ${overnightFormatted}`;
        }

        // Smooth scroll and highlight section
        function setupSmoothScroll() {
            const sections = ['shipping-methods', 'international', 'processing', 'tracking'];

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        document.querySelectorAll('.section-card').forEach(card => {
                            card.classList.remove('highlight');
                        });
                        entry.target.classList.add('highlight');
                    }
                });
            }, { threshold: 0.3 });

            sections.forEach(id => {
                const element = document.getElementById(id);
                if (element) observer.observe(element);
            });
        }

        // Back to Top Button
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // Tracking page link
        document.getElementById('trackingPageLink')?.addEventListener('click', (e) => {
                window.location.href = 'OrderTracking.php'
        });

        // Cart click
        document.querySelector('.cart-icon')?.addEventListener('click', async () => {
            await checkUserSession();
            if (isUserLoggedIn) {
                window.location.href = "Cart.php";
            } else {
                alert('Please login to manage your cart');
                window.location.href = "LogIn.php";
            }
        });
        
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href && href.startsWith('Home.php#')) {
                    e.preventDefault();
                    window.location.href = href;
                } else if (href === 'FYPHome.php') {
                    e.preventDefault();
                    window.location.href = 'FYPHome.php';
                }
            });
        });

        // ========== INITIALIZE PAGE ==========
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();
            calculateDeliveryDates();
            setupSmoothScroll();
        }
        
        init();
    </script>
</body>

</html>