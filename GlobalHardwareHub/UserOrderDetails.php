<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Hardware Hub | Order Details</title>
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

        /* Main Container */
        .container {
            max-width: 1000px;
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
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFFFFF 0%, #c7d2fe 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1.5rem;
        }

        /* Cards - White */
        .card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid #E5E7EB;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Timeline */
        .timeline {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .step {
            flex: 1;
            text-align: center;
            font-size: 0.75rem;
        }

        .step-icon {
            width: 45px;
            height: 45px;
            background: #F3F4F6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        .step.completed .step-icon {
            background: var(--success);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .step.active .step-icon {
            background: var(--primary);
            color: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
        }

        .step-label {
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
        }

        .step-date {
            font-size: 0.65rem;
            color: #6B7280;
        }

        .cancelled-badge {
            background: var(--danger);
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 60px;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0.8rem;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .info-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #111827;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        th,
        td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }

        th {
            color: #6B7280;
            font-weight: 600;
        }

        .product-img {
            width: 50px;
            height: 50px;
            background: #F3F4F6;
            border-radius: 12px;
            object-fit: cover;
        }

        /* Summary */
        .summary-box {
            display: flex;
            justify-content: flex-end;
        }

        .summary-table {
            width: 280px;
        }

        .summary-table td {
            padding: 6px;
            border-bottom: none;
        }

        .summary-table td:last-child {
            text-align: right;
        }

        .grand-total {
            font-weight: 800;
            border-top: 2px solid #E5E7EB;
            color: #111827;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 60px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-secondary {
            background: #F3F4F6;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #E5E7EB;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #FEE2E2;
            color: var(--danger);
        }

        .btn-danger:hover {
            background: #FECACA;
            transform: translateY(-2px);
        }

        .not-found {
            text-align: center;
            padding: 3rem;
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .not-found h2 {
            color: var(--danger);
            margin-bottom: 1rem;
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
            .timeline {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .step {
                display: flex;
                align-items: center;
                gap: 12px;
                text-align: left;
                width: 100%;
            }

            .step-icon {
                margin: 0;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .card {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <img src="Logo.jpg" alt="Global Hardware Hub">
            </div>

            <ul class="nav-links" id="desktopNav">
                <li class="nav-item"><a href="FYPHome.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
                <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span id="cartCount"
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

    <div class="container" id="orderDetailsContainer"></div>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Quick Links</h4>
                <a href="AboutUs.php">About Us</a>
                <a href="ContactUs.php">Contact</a>
                <a href="OrderTracking.php">Track Order</a>
                <a href="ReturnPolicy.php">Return Policy</a>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="FAQ.php">FAQs</a>
                <a href="PaymentMethods.php">Payment Methods</a>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p><i class="fas fa-phone-alt"></i> 03267322096</p>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
                <div class="social-icons"><i class="fab fa-facebook-f"></i> <i class="fab fa-twitter"></i> <i
                        class="fab fa-instagram"></i></div>
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

        // Function to load cart count from API
        async function loadCartCountFromAPI() {
            const cartCountSpan = document.getElementById("cartCount");
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

        async function updateCartCount() {
            await loadCartCountFromAPI();
        }

        // ============== GLOBAL VARIABLES ==============
        let orderData = null;
        let currentOrderId = null;

        // ============== HELPER FUNCTIONS ==============
        function showMessage(message, isError = false) {
            const popup = document.createElement('div');
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            popup.style.cssText = `
            position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%);
            background: ${isError ? '#ef4444' : '#10b981'}; color: white;
            padding: 0.8rem 1.5rem; border-radius: 60px; z-index: 1001;
            animation: fadeInOut 3s ease forwards;
            font-size: 14px; font-weight: 500;
        `;
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 3000);
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
        }

        // ========== LOGIN CHECK ==========
        async function checkLoginAndRedirect() {
            await checkUserSession();
            if (!isUserLoggedIn) {
                showMessage("Please login to view order details", true);
                setTimeout(() => {
                    window.location.href = "LogIn.php";
                }, 2000);
                return false;
            }
            return true;
        }

        // ========== GET ORDER ID FROM URL ==========
        function getOrderIdFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            const orderId = urlParams.get('order_id');
            if (!orderId || isNaN(orderId) || parseInt(orderId) <= 0) {
                return null;
            }
            return parseInt(orderId);
        }

        // ========== FETCH ORDER DETAILS ==========
        async function fetchOrderDetails(orderId) {
            try {
                const response = await fetch(`get_order_details.php?order_id=${orderId}`);
                const result = await response.json();
                if (!result.success) {
                    throw new Error(result.message || 'Failed to load order details');
                }
                return result.order;
            } catch (error) {
                console.error('Fetch error:', error);
                throw error;
            }
        }

        // ========== RENDER TIMELINE ==========
        function renderTimeline(order) {
            const steps = ["ordered", "confirmed", "shipped", "delivered"];
            const stepNames = { ordered: "Ordered", confirmed: "Confirmed", shipped: "Shipped", delivered: "Delivered" };
            const stepIcons = { ordered: '<i class="fas fa-shopping-cart"></i>', confirmed: '<i class="fas fa-check-circle"></i>', shipped: '<i class="fas fa-truck"></i>', delivered: '<i class="fas fa-box-open"></i>' };

            const orderDate = order.created_at;
            const paymentDate = order.payment?.payment_date;
            const currentStatus = (order.status || '').toLowerCase();

            let timelineData = {
                ordered: orderDate,
                confirmed: paymentDate || null,
                shipped: null,
                delivered: null
            };

            let html = `<div class="timeline">`;
            for (let step of steps) {
                let completed = timelineData[step] !== null && timelineData[step] !== undefined;
                let active = !completed && step === currentStatus;
                let stepDate = timelineData[step] ? formatDate(timelineData[step]) : (active ? 'In Progress' : 'Pending');

                html += `
                <div class="step ${completed ? 'completed' : ''} ${active ? 'active' : ''}">
                    <div class="step-icon">${stepIcons[step]}</div>
                    <div class="step-label">${stepNames[step]}</div>
                    <div class="step-date"><i class="fas fa-calendar-alt"></i> ${stepDate}</div>
                </div>
            `;
            }
            html += `</div>`;

            if (currentStatus === "cancelled") {
                html = `<div class="cancelled-badge"><i class="fas fa-times-circle"></i> ORDER CANCELLED</div>` + html;
            }
            return html;
        }

        function renderOrderInfo(order) {
            return `
            <div><div class="info-label"><i class="fas fa-hashtag"></i> Order ID</div><div class="info-value">#${order.order_id}</div></div>
            <div><div class="info-label"><i class="fas fa-calendar-alt"></i> Order Date</div><div class="info-value">${formatDate(order.created_at)}</div></div>
            <div><div class="info-label"><i class="fas fa-chart-line"></i> Order Status</div><div class="info-value">${order.status || 'Pending'}</div></div>
            <div><div class="info-label"><i class="fas fa-credit-card"></i> Payment Method</div><div class="info-value">${order.payment_method || 'N/A'}</div></div>
            ${order.coupon_code ? `<div><div class="info-label"><i class="fas fa-ticket-alt"></i> Coupon Applied</div><div class="info-value">${order.coupon_code}</div></div>` : ''}
            ${order.order_notes ? `<div><div class="info-label"><i class="fas fa-sticky-note"></i> Order Notes</div><div class="info-value">${order.order_notes}</div></div>` : ''}
        `;
        }

        function renderOrderItems(items) {
            if (!items || items.length === 0) {
                return '<tr><td colspan="5" style="text-align:center; color:#6B7280;"><i class="fas fa-box-open"></i> No items found in this order</div></tr>';
            }

            let rows = "";
            for (let item of items) {
                const imageUrl = item.image_url || 'https://placehold.co/50x50/2563eb/white?text=Product';
                rows += `
                <tr>
                    <td><img class="product-img" src="${imageUrl}" alt="${item.name}" onerror="this.src='https://placehold.co/50x50/2563eb/white?text=Product'"></div>
                    <td>
                        <div><strong>${escapeHtml(item.name)}</strong></div>
                        <div style="font-size:0.7rem; color:#6B7280;"><i class="fas fa-barcode"></i> SKU: ${escapeHtml(item.sku || 'N/A')}</div>
                        <div style="font-size:0.7rem; color:#6B7280;"><i class="fas fa-store"></i> Vendor ID: ${item.vendor_id || 1}</div>
                    </div></div>
                    <td>PKR ${parseFloat(item.price).toFixed(2)}</div></div>
                    <td><i class="fas fa-times"></i> ${item.quantity}</div></div>
                    <td>PKR  ${(item.price * item.quantity).toFixed(2)}</div></div>
                </tr>
            `;
            }
            return rows;
        }

        function renderPriceSummary(order, items) {
            let subtotal = 0;
            for (let item of items) {
                subtotal += item.price * item.quantity;
            }
            const total = parseFloat(order.total_amount);
            const tax = parseFloat((total - subtotal).toFixed(2));

            let summaryHtml = `
            <table class="summary-table">
                <tr><td><i class="fas fa-receipt"></i> Subtotal</div><td>PKR ${subtotal.toFixed(2)}</div></tr>
                <tr><td class="info-label"><i class="fas fa-chart-line"></i> Tax</div><td>PKR ${tax.toFixed(2)}</div></tr>
        `;

            if (order.coupon_code) {
                const discount = subtotal + tax - total;
                summaryHtml += `<tr><td class="info-label"><i class="fas fa-ticket-alt"></i> Discount (${escapeHtml(order.coupon_code)})</div><td>-$${Math.abs(discount).toFixed(2)}</div></tr>`;
            }

            summaryHtml += `
                <tr class="grand-total"><td> <strong>Total</strong></div><td><strong>PKR ${total.toFixed(2)}</strong></div></tr>
            </table>
        `;
            return summaryHtml;
        }

        function renderShippingAddress(address) {
            if (!address) {
                return `<div class="info-value"><i class="fas fa-info-circle"></i> No shipping address available</div>`;
            }
            return `
            <div><div class="info-value"><strong>${escapeHtml(address.full_name || 'N/A')}</strong></div></div>
            <div><div class="info-value"><i class="fas fa-location-dot"></i> ${escapeHtml(address.address_line1 || '')}</div></div>
            ${address.address_line2 ? `<div><div class="info-value">${escapeHtml(address.address_line2)}</div></div>` : ''}
            <div><div class="info-value">${escapeHtml(address.city || '')}, ${escapeHtml(address.state || '')} ${escapeHtml(address.postal_code || '')}</div></div>
            <div><div class="info-value">${escapeHtml(address.country || '')}</div></div>
            ${address.phone ? `<div><div class="info-value"><i class="fas fa-phone-alt"></i> ${escapeHtml(address.phone)}</div></div>` : ''}
        `;
        }

        function renderPaymentDetails(payment, order) {
            if (!payment) {
                return `
                <div><div class="info-label"><i class="fas fa-credit-card"></i> Payment Method</div><div class="info-value">${order.payment_method || 'N/A'}</div></div>
                <div><div class="info-label"><i class="fas fa-dollar-sign"></i> Amount Paid</div><div class="info-value">PKR ${parseFloat(order.total_amount).toFixed(2)}</div></div>
                <div><div class="info-label"><i class="fas fa-chart-line"></i> Payment Status</div><div class="info-value">Pending</div></div>
            `;
            }
            return `
            <div><div class="info-label"><i class="fas fa-credit-card"></i> Payment Method</div><div class="info-value">${escapeHtml(payment.payment_method || order.payment_method || 'N/A')}</div></div>
            <div><div class="info-label"><i class="fas fa-dollar-sign"></i> Amount Paid</div><div class="info-value">PKR ${parseFloat(payment.amount || order.total_amount).toFixed(2)}</div></div>
            <div><div class="info-label"><i class="fas fa-chart-line"></i> Payment Status</div><div class="info-value">${payment.status || 'Pending'}</div></div>
            <div><div class="info-label"><i class="fas fa-calendar"></i> Payment Date</div><div class="info-value">${payment.payment_date ? formatDate(payment.payment_date) : 'N/A'}</div></div>
        `;
        }

        function renderActions(order) {
            let btns = "";
            btns += `<button class="btn btn-secondary" onclick="window.location.href='UserOrders.php'"><i class="fas fa-arrow-left"></i> Back to Orders</button>`;
            btns += `<button class="btn btn-primary" onclick="downloadInvoice()"><i class="fas fa-download"></i> Download Invoice</button>`;
            const statusLower = (order.status || '').toLowerCase();
            if (statusLower !== 'cancelled' && statusLower !== 'completed' && statusLower !== 'delivered') {
                btns += `<button class="btn btn-danger" onclick="cancelOrder(${order.order_id})"><i class="fas fa-times-circle"></i> Cancel Order</button>`;
            }
            return btns;
        }

        window.cancelOrder = async function (orderId) {
            const confirmed = confirm("Are you sure you want to cancel this order?");
            if (!confirmed) return;
            try {
                const response = await fetch('cancel_user_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order_id: orderId })
                });
                const result = await response.json();
                if (result.success) {
                    showMessage("Order cancelled successfully!");
                    setTimeout(() => {
                        window.location.href = "UserOrders.php";
                    }, 1500);
                } else {
                    showMessage(result.message || "Failed to cancel order", true);
                }
            } catch (error) {
                console.error('Cancel order error:', error);
                showMessage("Failed to cancel order. Please try again.", true);
            }
        };

        window.downloadInvoice = function () {
            if (!orderData) {
                showMessage("Order data not available", true);
                return;
            }
            let itemsTotal = 0;
            let itemsHtml = "";
            for (let item of orderData.items) {
                const itemTotal = item.price * item.quantity;
                itemsTotal += itemTotal;
                itemsHtml += `<li>${escapeHtml(item.name)} x ${item.quantity} - $${itemTotal.toFixed(2)}</li>`;
            }
            let invoiceHtml = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Invoice #${orderData.order_id}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 2rem; }
                    .header { text-align: center; margin-bottom: 2rem; }
                    .invoice-details { margin-bottom: 2rem; }
                    table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
                    th, td { padding: 0.5rem; text-align: left; border-bottom: 1px solid #ddd; }
                    .total { text-align: right; font-size: 1.2rem; font-weight: bold; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>Global Hardware Hub</h1>
                    <p>Official Invoice</p>
                </div>
                <div class="invoice-details">
                    <p><strong>Order ID:</strong> #${orderData.order_id}</p>
                    <p><strong>Order Date:</strong> ${formatDate(orderData.created_at)}</p>
                    <p><strong>Order Status:</strong> ${orderData.status}</p>
                    <p><strong>Payment Method:</strong> ${orderData.payment_method || 'N/A'}</p>
                </div>
                <h3>Items</h3>
                <ul>${itemsHtml}</ul>
                <div class="total">
                    <p>Subtotal: $${itemsTotal.toFixed(2)}</p>
                    <p>Total Amount: PKR ${parseFloat(orderData.total_amount).toFixed(2)}</p>
                </div>
                ${orderData.shipping_address ? `
                <h3>Shipping Address</h3>
                <p>${escapeHtml(orderData.shipping_address.full_name || '')}<br>
                ${escapeHtml(orderData.shipping_address.address_line1 || '')}<br>
                ${orderData.shipping_address.city ? escapeHtml(orderData.shipping_address.city) + ', ' : ''}
                ${orderData.shipping_address.state ? escapeHtml(orderData.shipping_address.state) + ' ' : ''}
                ${orderData.shipping_address.postal_code ? escapeHtml(orderData.shipping_address.postal_code) : ''}<br>
                ${escapeHtml(orderData.shipping_address.country || '')}</p>
                ` : ''}
                <p style="text-align: center; margin-top: 2rem;">Thank you for shopping at Global Hardware Hub!</p>
            </body>
            </html>
        `;
            let win = window.open();
            win.document.write(invoiceHtml);
            win.print();
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

        function renderCompletePage(order) {
            const container = document.getElementById("orderDetailsContainer");
            container.innerHTML = `
            <div class="breadcrumb">
                <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="UserOrders.php">My Orders</a> / Order Details
            </div>
            <h1 class="page-title"><i class="fas fa-file-invoice"></i> Order Details</h1>
            
            <div class="card">
                <h2><i class="fas fa-chart-line"></i> Order Status</h2>
                ${renderTimeline(order)}
            </div>
            
            <div class="card">
                <h2><i class="fas fa-info-circle"></i> Order Information</h2>
                <div class="info-grid">
                    ${renderOrderInfo(order)}
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-shopping-cart"></i> Items Ordered</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr><th></th><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                            ${renderOrderItems(order.items)}
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-calculator"></i> Price Breakdown</h2>
                <div class="summary-box">
                    ${renderPriceSummary(order, order.items)}
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-location-dot"></i> Shipping Address</h2>
                <div class="info-grid">
                    ${renderShippingAddress(order.shipping_address)}
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-credit-card"></i> Payment Details</h2>
                <div class="info-grid">
                    ${renderPaymentDetails(order.payment, order)}
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-tools"></i> Actions</h2>
                <div class="btn-group">
                    ${renderActions(order)}
                </div>
            </div>
        `;
        }

        function showErrorState(message) {
            const container = document.getElementById("orderDetailsContainer");
            container.innerHTML = `
            <div class="not-found">
                <div style="font-size: 3rem;"><i class="fas fa-search"></i></div>
                <h2>Order Not Found</h2>
                <p>${message}</p>
                <a href="UserOrders.php"><button class="btn btn-primary" style="margin-top:1rem;"><i class="fas fa-arrow-left"></i> View My Orders</button></a>
            </div>
        `;
        }

        function showLoadingState() {
            const container = document.getElementById("orderDetailsContainer");
            container.innerHTML = `
            <div class="not-found">
                <div style="font-size: 3rem;"><i class="fas fa-spinner fa-pulse"></i></div>
                <h2>Loading Order Details...</h2>
                <p>Please wait while we fetch your order information.</p>
            </div>
        `;
        }

        async function loadOrderDetails() {
            if (!await checkLoginAndRedirect()) return;
            currentOrderId = getOrderIdFromURL();
            if (!currentOrderId) {
                showErrorState("Invalid Order ID");
                return;
            }
            showLoadingState();
            try {
                orderData = await fetchOrderDetails(currentOrderId);
                renderCompletePage(orderData);
            } catch (error) {
                console.error('Load order error:', error);
                showErrorState(error.message || "Unable to load order details");
            }
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

        // Back to top
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 200) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // ========== INITIALIZE PAGE ==========
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();
            loadOrderDetails();
        }

        init();
    </script>
</body>

</html>
