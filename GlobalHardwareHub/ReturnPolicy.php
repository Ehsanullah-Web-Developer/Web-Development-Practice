<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Return & Refund Policy</title>
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

        /* Policy Container */
        .policy-container {
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

        /* Cards - White */
        /* A. Card Hover Animation */
        .card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }

        .card h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Return Banner - White Card with Gradient Text */
        /* F. Hero Entrance Animation */
        @keyframes heroFadeSlideUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .return-banner {
            background: #FFFFFF;
            text-align: center;
            padding: 2rem;
            border-radius: 32px;
            margin-bottom: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            animation: heroFadeSlideUp 0.6s ease-out;
        }

        .return-banner:hover {
            transform: translateY(-4px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }

        .return-banner h3 {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1e293b 0%, #2563EB 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .return-banner p {
            color: #6B7280;
        }

        /* Conditions List */
        .conditions-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            list-style: none;
        }

        /* A. Conditions List Item Hover Animation */
        .conditions-list li {
            padding: 0.8rem;
            background: #F9FAFB;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            color: #374151;
        }

        .conditions-list li:hover {
            background: #FFFFFF;
            transform: translateX(6px);
            box-shadow: var(--shadow-sm);
            border-left: 3px solid var(--primary);
        }

        /* Steps Grid */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }

        /* A. Step Card Hover Animation */
        .step-card {
            text-align: center;
            padding: 1.2rem;
            background: #F9FAFB;
            border-radius: 24px;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .step-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
            background: #FFFFFF;
        }

        .step-icon {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            transition: transform 0.3s ease;
        }

        .step-card:hover .step-icon {
            transform: scale(1.05);
        }

        .step-number {
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.3rem;
        }

        /* Timeline Info */
        .timeline-info {
            background: #F9FAFB;
            padding: 1rem 1.2rem;
            border-radius: 20px;
            margin-top: 0.5rem;
            transition: all 0.2s ease;
        }

        .timeline-info:hover {
            transform: scale(1.02);
            background: #FFFFFF;
            box-shadow: var(--shadow-sm);
        }

        .timeline-info p {
            margin-bottom: 0.3rem;
            color: #6B7280;
        }

        /* Shipping Card */
        .shipping-card {
            background: #F9FAFB;
            padding: 1rem 1.2rem;
            border-radius: 20px;
            text-align: center;
            color: #374151;
            transition: all 0.2s ease;
        }

        .shipping-card:hover {
            transform: scale(1.02);
            background: #FFFFFF;
            box-shadow: var(--shadow-sm);
        }

        /* Form */
        .return-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
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

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.8rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
            background: #FFFFFF;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* B. Button Hover Animation */
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.8rem 1.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.25s ease;
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
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
            .return-banner h3 {
                font-size: 1.4rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .conditions-list li {
                font-size: 0.85rem;
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

    <div class="policy-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Return Policy</span>
        </div>
        <!-- H. Scroll Reveal - Page Title -->
        <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-undo-alt"></i> Return & Refund Policy</h1>

        <!-- H. Scroll Reveal - Return Banner -->
        <div class="return-banner" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="50">
            <h3><i class="fas fa-calendar-day"></i> 30-Day Return Window</h3>
            <p>You have 30 days from the date of delivery to request a return for eligible items.</p>
        </div>

        <!-- H. Scroll Reveal - Conditions Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="100">
            <h2><i class="fas fa-clipboard-list"></i> Conditions for Return</h2>
            <ul class="conditions-list">
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="50"><i class="fas fa-box"></i> Item must be unused and in original condition</li>
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="100"><i class="fas fa-gift"></i> Item must be in original packaging with all accessories</li>
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="150"><i class="fas fa-receipt"></i> Receipt or proof of purchase required</li>
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="200"><i class="fas fa-exclamation-triangle"></i> Some items are non-returnable (damaged by user, clearance items, opened software)</li>
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="250"><i class="fas fa-microchip"></i> Custom-built PCs may have different return terms</li>
            </ul>
        </div>

        <!-- H. Scroll Reveal - Return Process Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="150">
            <h2><i class="fas fa-step-forward"></i> Return Process</h2>
            <div class="steps-grid">
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="50">
                    <div class="step-icon"><i class="fas fa-pen-alt"></i></div>
                    <div class="step-number">Step 1</div>
                    <div>Submit return request via form below</div>
                </div>
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="100">
                    <div class="step-icon"><i class="fas fa-clock"></i></div>
                    <div class="step-number">Step 2</div>
                    <div>Wait for approval (1-2 business days)</div>
                </div>
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="150">
                    <div class="step-icon"><i class="fas fa-truck"></i></div>
                    <div class="step-number">Step 3</div>
                    <div>Ship the product back securely</div>
                </div>
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="200">
                    <div class="step-icon"><i class="fas fa-search"></i></div>
                    <div class="step-number">Step 4</div>
                    <div>Inspection by our team (3-5 business days)</div>
                </div>
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="250">
                    <div class="step-icon"><i class="fas fa-dollar-sign"></i></div>
                    <div class="step-number">Step 5</div>
                    <div>Refund issued to original payment method</div>
                </div>
            </div>
        </div>

        <!-- H. Scroll Reveal - Refund Timeline Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="200">
            <h2><i class="fas fa-hourglass-half"></i> Refund Timeline</h2>
            <div class="timeline-info" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                <p><i class="fas fa-check-circle"></i> <strong>Inspection Time:</strong> 3-5 business days after we receive your return</p>
                <p><i class="fas fa-credit-card"></i> <strong>Refund Processing:</strong> 5-10 business days after approval</p>
                <p><i class="fas fa-chart-line"></i> <strong>Payment Method Differences:</strong> Credit cards (5-7 days), PayPal (3-5 days), Bank transfers (7-10 days)</p>
                <p style="margin-top: 0.5rem; color: var(--primary);"><i class="fas fa-envelope"></i> You will receive email confirmation at each stage of the process.</p>
            </div>
        </div>

        <!-- H. Scroll Reveal - Return Shipping Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="250">
            <h2><i class="fas fa-truck-fast"></i> Return Shipping Responsibility</h2>
            <div class="shipping-card" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                <p><strong><i class="fas fa-check-circle" style="color: var(--success);"></i> Free Returns:</strong> For defective items or seller errors, we cover return shipping costs.</p>
                <p style="margin-top: 0.5rem;"><strong><i class="fas fa-user"></i> Customer Responsible:</strong> For change of mind returns, customer pays return shipping. Original shipping charges are non-refundable.</p>
                <p style="margin-top: 0.5rem;"><i class="fas fa-shield-alt"></i> We recommend using a trackable shipping method. Global Hardware Hub is not responsible for lost returns.</p>
            </div>
        </div>

        <!-- H. Scroll Reveal - Return Request Form Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="300">
            <h2><i class="fas fa-file-alt"></i> Submit Return Request</h2>
            <form id="returnForm" class="return-form">
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                    <label><i class="fas fa-hashtag"></i> Order ID *</label>
                    <input type="text" id="orderId" placeholder="e.g., ORD-1001" required>
                </div>
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                    <label><i class="fas fa-microchip"></i> Product Name *</label>
                    <input type="text" id="productName" placeholder="Enter the product name" required>
                </div>
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                    <label><i class="fas fa-question-circle"></i> Reason for Return *</label>
                    <select id="returnReason" required>
                        <option value="">Select a reason</option>
                        <option value="defective">Defective / Not working</option>
                        <option value="wrong_item">Wrong item received</option>
                        <option value="damaged">Damaged in shipping</option>
                        <option value="change_mind">Changed my mind</option>
                        <option value="not_as_described">Not as described</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="200">
                    <label><i class="fas fa-comment"></i> Additional Message (Optional)</label>
                    <textarea id="returnMessage" rows="3" placeholder="Provide any additional details..."></textarea>
                </div>
                <button type="submit" class="btn-primary" data-aos="fade-up" data-aos-duration="300" data-aos-delay="250"><i class="fas fa-paper-plane"></i> Submit Return Request</button>
            </form>
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
                <a href="FAQ.php">FAQ</a>
                <a href="Blog.php">Tech Blog</a>
                <a href="UserOrders.php">Bulk Orders</a>
                <a href="CompareProducts.php">Compare Products</a>
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

    <div id="successModal" class="modal">
        <div class="modal-content">
            <i class="fas fa-check-circle" style="font-size: 3rem; color: var(--success);"></i>
            <h3 style="margin: 0.8rem 0;">Return Request Submitted!</h3>
            <p style="color: #6B7280;">Your return request has been submitted. Our support team will contact you
                within 1-2 business days with approval and shipping instructions.</p>
            <button class="btn-primary" onclick="closeModal()" style="margin-top: 1rem;"><i class="fas fa-times"></i>
                Close</button>
        </div>
    </div>

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
                { title: "Account", submenu: ["My Account", "Profile", "Orders", "Order Details", "Wishlist", "Address Book", "Payment Methods", "Cart", "Checkout", "Checkout Shipping", "Checkout Payment", "Order Confirmation"], links: ["MyAccount.php", "Profile.php", "UserOrders.php", "UserOrderDetails.php", "Wishlist.php", "AddressBook.php", "PaymentMethods.php", "Cart.php", "Checkout.php", "CheckoutShipping.php", "CheckoutPayment.php", "OrderConfirmation.php"] },
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

        // Form validation and modal
        const returnForm = document.getElementById('returnForm');
        const modal = document.getElementById('successModal');

        function showModal() {
            modal.classList.add('show');
        }

        function closeModal() {
            modal.classList.remove('show');
        }
        window.closeModal = closeModal;

        returnForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            await checkUserSession();

            if (!isUserLoggedIn) {
                alert('Please login first to submit a return request');
                window.location.href = "LogIn.php";
                return;
            }

            const orderId = document.getElementById('orderId').value.trim();
            const productName = document.getElementById('productName').value.trim();
            const returnReason = document.getElementById('returnReason').value;

            let isValid = true;

            if (!orderId) {
                alert('Please enter Order ID');
                isValid = false;
            } else if (!productName) {
                alert('Please enter Product Name');
                isValid = false;
            } else if (!returnReason) {
                alert('Please select a reason for return');
                isValid = false;
            }

            if (isValid) {
                const returns = JSON.parse(localStorage.getItem('returnRequests')) || [];
                returns.push({
                    orderId,
                    productName,
                    reason: returnReason,
                    message: document.getElementById('returnMessage').value,
                    date: new Date().toISOString(),
                    userId: currentUserId
                });
                localStorage.setItem('returnRequests', JSON.stringify(returns));

                showModal();
                returnForm.reset();
            }
        });

        // Back to Top Button
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

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

        // ========== INITIALIZE PAGE ==========
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();
        }

        init();
    </script>
</body>

</html>