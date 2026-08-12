<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Verify Email</title>
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

        /* Verify Container */
        .verify-container {
            min-height: calc(100vh - 420px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }

        /* Verify Card - White */
        /* A. Verify Card Hover Animation */
        .verify-card {
            max-width: 520px;
            width: 100%;
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 2.5rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            text-align: center;
        }

        .verify-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
        }

        .verify-icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .verify-card:hover .verify-icon {
            transform: scale(1.05);
        }

        .verify-card h2 {
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #2563EB 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .instruction-text {
            color: #6B7280;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        /* Code Input Boxes */
        .code-inputs {
            display: flex;
            gap: 0.8rem;
            justify-content: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .code-input {
            width: 60px;
            height: 70px;
            text-align: center;
            font-size: 1.8rem;
            font-weight: 700;
            border: 2px solid #E5E7EB;
            border-radius: 20px;
            background: #FFFFFF;
            outline: none;
            transition: all 0.2s ease;
            color: #111827;
        }

        .code-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .code-input.error {
            border-color: var(--danger);
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-5px);
            }
            75% {
                transform: translateX(5px);
            }
        }

        /* Message Box */
        .message-box {
            padding: 0.8rem 1rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            display: none;
            font-weight: 500;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-box.success {
            background: #D1FAE5;
            color: #065F46;
            border: 1px solid #A7F3D0;
            display: block;
        }

        .message-box.error {
            background: #FEE2E2;
            color: #DC2626;
            border: 1px solid #FECACA;
            display: block;
        }

        /* Resend Section */
        .resend-section {
            margin: 1rem 0;
        }

        /* B. Resend Button Hover Animation */
        .resend-btn {
            background: none;
            border: none;
            color: var(--primary);
            font-weight: 600;
            cursor: pointer;
            font-size: 0.9rem;
            padding: 0.5rem;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .resend-btn:hover:not(:disabled) {
            color: var(--primary-dark);
            transform: translateX(4px) scale(1.02);
        }

        .resend-btn:disabled {
            color: #6B7280;
            cursor: not-allowed;
        }

        .timer-text {
            color: #6B7280;
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }

        /* B. Verify Button Hover Animation */
        .verify-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.9rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            width: 100%;
            transition: all 0.25s ease;
            margin-top: 0.5rem;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .verify-btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .verify-btn:disabled {
            background: #6B7280;
            cursor: not-allowed;
            transform: none;
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

        @media (max-width: 600px) {
            .code-input {
                width: 48px;
                height: 58px;
                font-size: 1.4rem;
            }

            .verify-card {
                padding: 1.5rem;
                margin: 0 1rem;
            }

            .verify-card h2 {
                font-size: 1.5rem;
            }

            .code-inputs {
                gap: 0.5rem;
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

    <div class="verify-container">
        <!-- H. Scroll Reveal - Verify Card -->
        <div class="verify-card" data-aos="zoom-in" data-aos-duration="600" data-aos-offset="50">
            <div class="verify-icon" data-aos="fade-up" data-aos-duration="400" data-aos-delay="50"><i class="fas fa-envelope-open-text"></i></div>
            <h2 data-aos="fade-up" data-aos-duration="400" data-aos-delay="100"><i class="fas fa-check-circle"></i> Verify Your Email</h2>
            <p class="instruction-text" data-aos="fade-up" data-aos-duration="400" data-aos-delay="150">Enter the 6-digit verification code sent to your email</p>

            <!-- H. Scroll Reveal - Code Inputs -->
            <div class="code-inputs" id="codeInputs" data-aos="fade-up" data-aos-duration="400" data-aos-delay="200">
                <input type="text" class="code-input" maxlength="1" inputmode="numeric" pattern="[0-9]" id="code1">
                <input type="text" class="code-input" maxlength="1" inputmode="numeric" pattern="[0-9]" id="code2">
                <input type="text" class="code-input" maxlength="1" inputmode="numeric" pattern="[0-9]" id="code3">
                <input type="text" class="code-input" maxlength="1" inputmode="numeric" pattern="[0-9]" id="code4">
                <input type="text" class="code-input" maxlength="1" inputmode="numeric" pattern="[0-9]" id="code5">
                <input type="text" class="code-input" maxlength="1" inputmode="numeric" pattern="[0-9]" id="code6">
            </div>

            <div id="messageBox" class="message-box" data-aos="fade-up" data-aos-duration="300" data-aos-delay="250"></div>

            <!-- H. Scroll Reveal - Resend Section -->
            <div class="resend-section" data-aos="fade-up" data-aos-duration="400" data-aos-delay="300">
                <button id="resendBtn" class="resend-btn"><i class="fas fa-paper-plane"></i> Resend Code</button>
                <div id="timerText" class="timer-text"></div>
            </div>

            <button id="verifyBtn" class="verify-btn" data-aos="fade-up" data-aos-duration="400" data-aos-delay="350"><i class="fas fa-check"></i> Verify Email</button>
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
                <a href="WarrantyInfo.php">Warranty Info</a>
                <a href="Wishlist.php">Wishlist</a>
                <a href="FAQ.php">FAQ</a>
                <a href="SupportTicket.php">Support Ticket</a>
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
                </div>
            </div>
            <div class="footer-col">
                <h4>Our Motto</h4>
                <p>⚡ Power Your Passion, Build Without Limits.</p>
                <p>© 2026 Global Hardware Hub – All rights reserved.</p>
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

        // Verification Code (static for demo)
        const CORRECT_CODE = "110058";

        const inputs = [
            document.getElementById("code1"),
            document.getElementById("code2"),
            document.getElementById("code3"),
            document.getElementById("code4"),
            document.getElementById("code5"),
            document.getElementById("code6")
        ];

        const messageBox = document.getElementById("messageBox");
        const verifyBtn = document.getElementById("verifyBtn");
        const resendBtn = document.getElementById("resendBtn");
        const timerText = document.getElementById("timerText");

        let countdown = 0;
        let countdownInterval = null;

        if (inputs[0]) inputs[0].focus();

        function handleInput(e, index) {
            const input = inputs[index];
            let value = e.target.value;

            if (value && !/^\d$/.test(value)) {
                input.value = "";
                return;
            }

            if (value && index < 5) {
                inputs[index + 1].focus();
            }

            checkAllFilled();
        }

        function handleKeydown(e, index) {
            const input = inputs[index];

            if (e.key === "Backspace" && !input.value && index > 0) {
                inputs[index - 1].focus();
                inputs[index - 1].value = "";
            }

            if (e.key === "v" && (e.ctrlKey || e.metaKey)) {
                setTimeout(() => {
                    const pastedText = inputs.map(i => i.value).join('');
                    if (pastedText.length === 6 && /^\d+$/.test(pastedText)) {
                        for (let i = 0; i < 6; i++) {
                            inputs[i].value = pastedText[i];
                        }
                        checkAllFilled();
                    }
                }, 10);
            }
        }

        function checkAllFilled() {
            const code = inputs.map(input => input.value).join('');
            if (code.length === 6) {
                verifyCode(code);
            } else {
                inputs.forEach(input => input.classList.remove("error"));
                messageBox.classList.remove("error", "success");
                messageBox.style.display = "none";
            }
        }

        function verifyCode(code) {
            if (code === CORRECT_CODE) {
                messageBox.className = "message-box success";
                messageBox.innerHTML = "<i class='fas fa-check-circle'></i> Email Verified Successfully! Redirecting to login...";
                messageBox.style.display = "block";

                localStorage.setItem("emailVerified", "true");

                inputs.forEach(input => input.disabled = true);
                verifyBtn.disabled = true;
                resendBtn.disabled = true;

                setTimeout(() => {
                    window.location.href = "LogIn.php";
                }, 2000);
            } else {
                messageBox.className = "message-box error";
                messageBox.innerHTML = "<i class='fas fa-exclamation-circle'></i> Invalid Verification Code. Please try again.";
                messageBox.style.display = "block";

                inputs.forEach(input => {
                    input.classList.add("error");
                    setTimeout(() => input.classList.remove("error"), 500);
                });

                inputs.forEach(input => input.value = "");
                if (inputs[0]) inputs[0].focus();
            }
        }

        function manualVerify() {
            const code = inputs.map(input => input.value).join('');
            if (code.length === 6) {
                verifyCode(code);
            } else {
                messageBox.className = "message-box error";
                messageBox.innerHTML = "<i class='fas fa-exclamation-circle'></i> Please enter all 6 digits of the verification code.";
                messageBox.style.display = "block";
            }
        }

        function startCountdown(seconds) {
            if (countdownInterval) clearInterval(countdownInterval);

            countdown = seconds;
            updateTimerDisplay();

            resendBtn.disabled = true;

            countdownInterval = setInterval(() => {
                countdown--;
                updateTimerDisplay();

                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    resendBtn.disabled = false;
                    timerText.innerHTML = "";
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            if (countdown > 0) {
                timerText.innerHTML = `<i class="fas fa-hourglass-half"></i> Resend available in ${countdown} seconds`;
            } else {
                timerText.innerHTML = "";
            }
        }

        function resendCode() {
            if (resendBtn.disabled) return;

            messageBox.className = "message-box success";
            messageBox.innerHTML = "<i class='fas fa-envelope'></i> A new verification code has been sent to your email!";
            messageBox.style.display = "block";

            inputs.forEach(input => {
                input.value = "";
                input.disabled = false;
            });
            if (inputs[0]) inputs[0].focus();

            verifyBtn.disabled = false;

            startCountdown(30);

            setTimeout(() => {
                if (messageBox.classList.contains("success")) {
                    messageBox.style.display = "none";
                }
            }, 3000);
        }

        inputs.forEach((input, index) => {
            if (input) {
                input.addEventListener("input", (e) => handleInput(e, index));
                input.addEventListener("keydown", (e) => handleKeydown(e, index));
                input.addEventListener("paste", (e) => {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text');
                    const numbers = pastedData.replace(/\D/g, '').slice(0, 6);
                    if (numbers.length) {
                        for (let i = 0; i < numbers.length && i < 6; i++) {
                            if (inputs[i]) inputs[i].value = numbers[i];
                        }
                        if (numbers.length === 6) {
                            checkAllFilled();
                        } else if (inputs[numbers.length]) {
                            inputs[numbers.length].focus();
                        }
                    }
                });
            }
        });

        verifyBtn.addEventListener("click", manualVerify);
        resendBtn.addEventListener("click", resendCode);

        startCountdown(30);

        // Back to Top Button
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
        }

        init();
    </script>
</body>

</html>