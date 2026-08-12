<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Warranty Information</title>
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

        /* Warranty Container */
        .warranty-container {
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

        /* Comparison Cards */
        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        /* A. Comparison Card Hover Animation */
        .comparison-card {
            background: #F9FAFB;
            border-radius: 24px;
            padding: 1.2rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .comparison-card:hover {
            transform: translateY(-6px);
            background: #FFFFFF;
            box-shadow: var(--shadow-md);
        }

        .comparison-card h3 {
            color: #111827;
            margin-bottom: 0.8rem;
        }

        .comparison-card p {
            color: #6B7280;
            line-height: 1.6;
            font-size: 0.85rem;
        }

        /* Table Styles */
        .table-wrapper {
            overflow-x: auto;
        }

        .warranty-table {
            width: 100%;
            border-collapse: collapse;
        }

        .warranty-table th,
        .warranty-table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }

        .warranty-table th {
            background: #F9FAFB;
            color: #111827;
            font-weight: 700;
        }

        /* Steps */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
            transform: translateY(-8px);
            background: #FFFFFF;
            box-shadow: var(--shadow-md);
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

        /* Exclusions List */
        .exclusions-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 0.8rem;
            list-style: none;
        }

        /* A. Exclusions List Item Hover Animation */
        .exclusions-list li {
            padding: 0.6rem;
            background: #F9FAFB;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            color: #374151;
        }

        .exclusions-list li:hover {
            background: #FFFFFF;
            transform: translateX(6px);
            box-shadow: var(--shadow-sm);
        }

        /* Contact Info */
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: space-between;
            margin-top: 0.5rem;
        }

        /* A. Contact Item Hover Animation */
        .contact-item {
            flex: 1;
            text-align: center;
            padding: 1rem;
            background: #F9FAFB;
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .contact-item:hover {
            background: #FFFFFF;
            transform: translateY(-5px);
            box-shadow: var(--shadow-sm);
        }

        /* Form */
        .claim-form {
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
        .form-group textarea,
        .form-group select {
            padding: 0.8rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
            background: #FFFFFF;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
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
            .contact-info {
                flex-direction: column;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .exclusions-list {
                grid-template-columns: 1fr;
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
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
                <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
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

    <div class="warranty-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Warranty Information</span>
        </div>
        <!-- H. Scroll Reveal - Page Title -->
        <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-shield-alt"></i> Warranty Information</h1>

        <!-- H. Scroll Reveal - Manufacturer vs Seller Warranty Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="50">
            <h2><i class="fas fa-balance-scale"></i> Manufacturer vs. Seller Warranty</h2>
            <div class="comparison-grid">
                <div class="comparison-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="50">
                    <h3><i class="fas fa-industry"></i> Manufacturer Warranty</h3>
                    <p>Covered by the original brand (Intel, NVIDIA, ASUS, etc.). Usually includes defects in materials
                        and workmanship. Duration varies by product (1-3 years). Claim directly with manufacturer or
                        through authorized service centers.</p>
                </div>
                <div class="comparison-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="100">
                    <h3><i class="fas fa-store"></i> Seller Warranty</h3>
                    <p>Provided by Global Hardware Hub or individual vendors. May cover additional services like
                        installation support, extended coverage, or faster replacement. Terms vary by seller. Contact
                        vendor for specific details.</p>
                </div>
            </div>
        </div>

        <!-- H. Scroll Reveal - Warranty Period Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="100">
            <h2><i class="fas fa-chart-bar"></i> Warranty Period by Category</h2>
            <div class="table-wrapper">
                <table class="warranty-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Warranty Period</th>
                            <th>Warranty Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-aos="fade-up" data-aos-duration="200" data-aos-delay="50">
                            <td>CPU</div>
                            <td>1-3 Years</div>
                            <td>Manufacturer</div>
                        </tr>
                        <tr data-aos="fade-up" data-aos-duration="200" data-aos-delay="80">
                            <td>GPU</div>
                            <td>1-3 Years</div>
                            <td>Manufacturer</div>
                        </tr>
                        <tr data-aos="fade-up" data-aos-duration="200" data-aos-delay="110">
                            <td>Motherboard</div>
                            <td>1-3 Years</div>
                            <td>Manufacturer</div>
                        </tr>
                        <tr data-aos="fade-up" data-aos-duration="200" data-aos-delay="140">
                            <td>Storage Devices</div>
                            <td>1-3 Years</div>
                            <td>Manufacturer</div>
                        </tr>
                        <tr data-aos="fade-up" data-aos-duration="200" data-aos-delay="170">
                            <td>Networking Devices</div>
                            <td>1 Year</div>
                            <td>Seller / Manufacturer</div>
                        </tr>
                        <tr data-aos="fade-up" data-aos-duration="200" data-aos-delay="200">
                            <td>Peripheral Devices</div>
                            <td>6 months - 1 Year</div>
                            <td>Seller</div>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- H. Scroll Reveal - Warranty Claim Process Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="150">
            <h2><i class="fas fa-step-forward"></i> Warranty Claim Process</h2>
            <div class="steps-grid">
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="50">
                    <div class="step-icon"><i class="fas fa-pen-alt"></i></div>
                    <div class="step-number">Step 1</div>
                    <div>Submit warranty claim with order details</div>
                </div>
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="100">
                    <div class="step-icon"><i class="fas fa-search"></i></div>
                    <div class="step-number">Step 2</div>
                    <div>Verification of warranty eligibility</div>
                </div>
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="150">
                    <div class="step-icon"><i class="fas fa-box"></i></div>
                    <div class="step-number">Step 3</div>
                    <div>Send product for inspection</div>
                </div>
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="200">
                    <div class="step-icon"><i class="fas fa-tools"></i></div>
                    <div class="step-number">Step 4</div>
                    <div>Repair or replacement processed</div>
                </div>
                <div class="step-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="250">
                    <div class="step-icon"><i class="fas fa-truck"></i></div>
                    <div class="step-number">Step 5</div>
                    <div>Product returned to customer</div>
                </div>
            </div>
        </div>

        <!-- H. Scroll Reveal - Warranty Exclusions Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="200">
            <h2><i class="fas fa-exclamation-triangle"></i> Warranty Exclusions</h2>
            <ul class="exclusions-list">
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="50"><i class="fas fa-hammer"></i> Physical damage (drops, cracks)</li>
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="80"><i class="fas fa-tint"></i> Water or liquid damage</li>
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="110"><i class="fas fa-fire"></i> Burnt components (overheating, power surge)</li>
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="140"><i class="fas fa-wrench"></i> Unauthorized repair or modification</li>
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="170"><i class="fas fa-tag"></i> Missing or tampered serial number</li>
                <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="200"><i class="fas fa-hourglass-end"></i> Expired warranty period</li>
            </ul>
        </div>

        <!-- H. Scroll Reveal - Warranty Support Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="250">
            <h2><i class="fas fa-headset"></i> Warranty Support</h2>
            <div class="contact-info">
                <div class="contact-item" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50"><i class="fas fa-envelope"
                        style="font-size:1.5rem; color:var(--primary);"></i><br><strong>Email</strong><br>warranty@GlobalHardwareHub.com
                </div>
                <div class="contact-item" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100"><i class="fas fa-phone-alt"
                        style="font-size:1.5rem; color:var(--primary);"></i><br><strong>Phone</strong><br>+1 (888)
                    776-8899</div>
                <div class="contact-item" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150"><i class="fas fa-clock"
                        style="font-size:1.5rem; color:var(--primary);"></i><br><strong>Support
                        Hours</strong><br>Mon-Fri: 9am-6pm EST</div>
            </div>
        </div>

        <!-- H. Scroll Reveal - Submit Warranty Claim Card -->
        <div class="card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="300">
            <h2><i class="fas fa-file-alt"></i> Submit Warranty Claim</h2>
            <form id="warrantyForm" class="claim-form" enctype="multipart/form-data">
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                    <label><i class="fas fa-hashtag"></i> Order ID *</label>
                    <input type="text" id="orderId" placeholder="e.g., ORD-1001 or just order number" required>
                </div>
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                    <label><i class="fas fa-microchip"></i> Product Name *</label>
                    <input type="text" id="productName" placeholder="e.g., Intel Core i9-14900K" required>
                </div>
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                    <label><i class="fas fa-barcode"></i> Serial Number *</label>
                    <input type="text" id="serialNumber" placeholder="Enter product serial number" required>
                </div>
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="200">
                    <label><i class="fas fa-comment"></i> Issue Description *</label>
                    <textarea id="issueDescription" rows="3" placeholder="Describe the issue in detail..."
                        required></textarea>
                </div>
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="250">
                    <label><i class="fas fa-camera"></i> Upload Image (Optional)</label>
                    <input type="file" id="imageUpload" name="upload_image" accept="image/*">
                    <span id="fileNamePreview" style="font-size:0.7rem; color:#6B7280;"></span>
                </div>
                <button type="submit" class="btn-primary" data-aos="fade-up" data-aos-duration="300" data-aos-delay="300"><i class="fas fa-paper-plane"></i> Submit Claim</button>
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
                <a href="VerifyEmail.php">Verify Email</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="Landing.php">Landing</a>
                <a href="FAQ.php">FAQ</a>
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
            <h3 style="margin: 0.8rem 0;">Claim Submitted!</h3>
            <p style="color: #6B7280;">Your warranty claim has been submitted. Our support team will contact you
                within 24-48 hours.</p>
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

        // Image file preview
        const imageUpload = document.getElementById('imageUpload');
        const fileNamePreview = document.getElementById('fileNamePreview');
        if (imageUpload) {
            imageUpload.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    fileNamePreview.innerHTML = `<i class="fas fa-file"></i> Selected: ${e.target.files[0].name}`;
                } else {
                    fileNamePreview.textContent = '';
                }
            });
        }

        // Modal functions
        const modal = document.getElementById('successModal');

        function showModal() {
            if (modal) modal.classList.add('show');
        }

        function closeModal() {
            if (modal) modal.classList.remove('show');
        }
        window.closeModal = closeModal;

        // ========== WARRANTY CLAIM SUBMISSION ==========
        const warrantyForm = document.getElementById('warrantyForm');

        async function submitWarrantyClaim(formData) {
            try {
                const response = await fetch('submit_warranty_claim.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    showModal();
                    warrantyForm.reset();
                    if (fileNamePreview) fileNamePreview.textContent = '';
                } else {
                    alert(result.message || 'Failed to submit warranty claim');
                }
            } catch (error) {
                console.error('Submit error:', error);
                alert('Failed to submit warranty claim. Please try again.');
            }
        }

        if (warrantyForm) {
            warrantyForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                await checkUserSession();
                
                if (!isUserLoggedIn) {
                    alert('Please login first to submit warranty claim');
                    window.location.href = 'LogIn.php';
                    return;
                }

                const orderId = document.getElementById('orderId').value.trim();
                const productName = document.getElementById('productName').value.trim();
                const serialNumber = document.getElementById('serialNumber').value.trim();
                const issueDescription = document.getElementById('issueDescription').value.trim();

                if (!orderId) { alert('Please enter Order ID'); return; }
                if (!productName) { alert('Please enter Product Name'); return; }
                if (!serialNumber) { alert('Please enter Serial Number'); return; }
                if (!issueDescription) { alert('Please describe the issue'); return; }

                const formData = new FormData();
                formData.append('order_id', orderId);
                formData.append('product_name', productName);
                formData.append('serial_number', serialNumber);
                formData.append('issue_description', issueDescription);

                const imageFile = document.getElementById('imageUpload').files[0];
                if (imageFile) {
                    formData.append('upload_image', imageFile);
                }

                const submitBtn = warrantyForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Submitting...';
                submitBtn.disabled = true;

                await submitWarrantyClaim(formData);

                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

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