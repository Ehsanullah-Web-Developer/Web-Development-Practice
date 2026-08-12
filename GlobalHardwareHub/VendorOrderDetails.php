<?php
// Start session to check vendor login
session_start();

// Check if vendor is logged in (user_id between 11-18)
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] < 11 || $_SESSION['user_id'] > 18) {
    header('Location: LogIn.php');
    exit;
}

$vendorId = $_SESSION['user_id'];
$vendorName = $_SESSION['user_fullname'] ?? 'Vendor';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Vendor Order Details</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Poppins:wght@600;700&display=swap"
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
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            --success: #10b981;
            --danger: #dc2626;
            --warning: #f59e0b;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
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
            box-shadow: var(--shadow-lg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0.9rem 2rem;
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
            border: 1px solid var(--gray-200);
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
            color: var(--gray-600);
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .dropdown-menu a:hover {
            background: var(--gray-100);
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
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            transition: transform 0.2s ease;
            color: #FFFFFF;
        }

        .cart-icon:hover {
            transform: scale(1.05);
            color: var(--primary);
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -16px;
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 7px;
            border-radius: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
            background: white;
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

        /* Order Container */
        .order-container {
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

        /* Cards - White cards matching Logout.php */
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
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .info-item {
            padding: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }

        .info-value {
            color: var(--gray-800);
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Timeline */
        .timeline {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .timeline-step {
            flex: 1;
            text-align: center;
            position: relative;
            min-width: 100px;
        }

        .step-icon {
            width: 45px;
            height: 45px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.8rem;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        .timeline-step.completed .step-icon {
            background: var(--success);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .timeline-step.active .step-icon {
            background: var(--primary);
            color: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
        }

        .step-label {
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.3rem;
        }

        .step-date {
            font-size: 0.7rem;
            color: var(--gray-600);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .items-table th {
            color: var(--gray-600);
            font-weight: 700;
            font-size: 0.85rem;
            background: var(--gray-100);
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 12px;
            background: var(--gray-100);
        }

        /* Summary */
        .summary {
            display: flex;
            justify-content: flex-end;
        }

        .summary-table {
            width: 340px;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 0.6rem;
        }

        .summary-table td:last-child {
            text-align: right;
        }

        .grand-total {
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--gray-800);
            border-top: 2px solid var(--gray-200);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0.3rem 1rem;
            border-radius: 60px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .status-pending {
            background: #e2e8f0;
            color: #475569;
        }

        .status-confirmed {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-processing {
            background: #c7d2fe;
            color: #3730a3;
        }

        .status-shipped {
            background: #fed7aa;
            color: #9b2c1d;
        }

        .status-delivered {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background: #fee2e2;
            color: var(--danger);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.85rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.7rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .status-select {
            padding: 0.6rem;
            border-radius: 60px;
        }

        /* Buttons */
        .btn-primary,
        .btn-secondary,
        .btn-success {
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-primary:hover,
        .btn-secondary:hover,
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        .btn-success:hover {
            box-shadow: 0 4px 12px -4px rgba(16, 185, 129, 0.4);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        /* Popup */
        .popup {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background: var(--success);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 60px;
            z-index: 1001;
            display: none;
            animation: fadeInOut 3s ease forwards;
            font-weight: 500;
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

        /* Back to Top - Matching Logout.php */
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
            10% {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
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
            }

            .timeline-step {
                text-align: left;
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .step-icon {
                margin: 0;
            }

            .summary {
                justify-content: flex-start;
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
                <li class="nav-item"><a href="VendorsStore.php" class="nav-link">Vendor Store</a></li>
                <li class="nav-item"><a href="VendorSettings.php" class="nav-link">Vendor Settings</a></li>
                <li class="nav-item"><a href="VendorAddProducts.php" class="nav-link">Vendor Add Products</a></li>
                <li class="nav-item"><a href="VendorProductsManagement.php" class="nav-link">Vendor Products</a></li>
                <li class="nav-item"><a href="VendorOrders.php" class="nav-link">Vendor Orders</a></li>
                <li class="nav-item"><a href="VendorReviews.php" class="nav-link">Vendor Reviews</a></li>
                <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i
                            class="fas fa-key"></i> Logout</button></li>
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

    <div class="order-container" id="orderDetailsContainer"></div>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Quick Links 1</h4>
                 <a href="Categories.php">Categories</a>
                <a href="Landing.php">Landing</a>
                <a href="CompareProducts.php">Compare Products</a>
                <a href="PaymentMethods.php">Payment Methods</a>
            </div>
            <div class="footer-col">
                <h4>Quick Links 2</h4>
                 <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="FAQ.php">FAQs</a>
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
                <p>© 2026 Global Hardware Hub</p>
            </div>
        </div>
        <div class="copyright">Global Hardware Hub | The Ultimate Computer Hardware Marketplace</div>
    </footer>

    <button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i> Top</button>
    <div id="popupMessage" class="popup"></div>

    <script>
        // ============== GLOBAL VARIABLES (100% UNCHANGED) ==============
        let orderData = null;
        let currentOrderId = null;

        // ============== HELPER FUNCTIONS (100% UNCHANGED) ==============
        function showPopup(message, isError = false) {
            const popup = document.getElementById("popupMessage");
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            popup.style.background = isError ? "#dc2626" : "#10b981";
            popup.style.display = "block";
            setTimeout(() => {
                popup.style.display = "none";
            }, 3000);
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }

        function getStatusClass(status) {
            const classes = {
                pending: "status-pending",
                confirmed: "status-confirmed",
                processing: "status-processing",
                shipped: "status-shipped",
                delivered: "status-delivered",
                cancelled: "status-cancelled"
            };
            return classes[status] || "status-pending";
        }

        function getStatusIndex(status) {
            const steps = ["pending", "confirmed", "processing", "shipped", "delivered"];
            const index = steps.indexOf(status);
            return index === -1 ? 0 : index;
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

        // ============== GET ORDER ID FROM URL (100% UNCHANGED) ==============
        function getOrderIdFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('order_id');
        }

        // ============== FETCH ORDER DETAILS (100% UNCHANGED) ==============
        async function fetchOrderDetails() {
            const orderId = getOrderIdFromURL();
            if (!orderId) {
                showNotFound("Invalid Order ID");
                return;
            }
            currentOrderId = orderId;
            try {
                const response = await fetch(`get_vendor_order_details.php?order_id=${orderId}`);
                const result = await response.json();
                if (result.success) {
                    orderData = result.data;
                    renderOrderDetails();
                } else {
                    showNotFound(result.message || "Order not found");
                }
            } catch (error) {
                console.error('Fetch error:', error);
                showNotFound("Failed to load order details");
            }
        }

        // ============== UPDATE ORDER STATUS (100% UNCHANGED) ==============
        async function updateOrderStatus(newStatus) {
            try {
                const response = await fetch('update_order_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order_id: currentOrderId, status: newStatus })
                });
                const result = await response.json();
                if (result.success) {
                    showPopup(`✅ Order status updated to ${newStatus.toUpperCase()}`);
                    await fetchOrderDetails();
                } else {
                    showPopup(result.message || 'Failed to update status', true);
                }
            } catch (error) {
                console.error('Update error:', error);
                showPopup('Failed to update order status', true);
            }
        }

        function showNotFound(message) {
            const container = document.getElementById("orderDetailsContainer");
            container.innerHTML = `
            <div class="not-found">
                <div style="font-size: 3rem;"><i class="fas fa-search"></i></div>
                <h2>Order Not Found</h2>
                <p>${escapeHtml(message)}</p>
                <a href="VendorOrders.php"><button class="btn-primary" style="margin-top:1rem;"><i class="fas fa-arrow-left"></i> Back to Orders</button></a>
            </div>
        `;
        }

        function markAsShipped() {
            const trackingNum = document.getElementById("trackingNumber")?.value.trim();
            const shippingCo = document.getElementById("shippingCompany")?.value;
            if (!trackingNum) {
                showPopup("⚠️ Please enter a tracking number", true);
                return;
            }
            if (!shippingCo) {
                showPopup("⚠️ Please select a shipping company", true);
                return;
            }
            updateOrderStatus("shipped");
        }

        function generateShippingLabel() {
            const trackingNum = document.getElementById("trackingNumber")?.value.trim() || "TRK-" + Math.random().toString(36).substring(2, 10).toUpperCase();
            const shippingCo = document.getElementById("shippingCompany")?.value || "UPS";
            if (!document.getElementById("trackingNumber")?.value.trim()) {
                const trackingInput = document.getElementById("trackingNumber");
                if (trackingInput) trackingInput.value = trackingNum;
            }
            if (!document.getElementById("shippingCompany")?.value) {
                const companySelect = document.getElementById("shippingCompany");
                if (companySelect) companySelect.value = shippingCo;
            }
            showPopup(`🏷️ Shipping label generated for ${shippingCo}\nTracking: ${trackingNum}`);
        }

        function downloadInvoice() {
            if (!orderData) return;
            const total = orderData.total_amount;
            let itemsHtml = "";
            orderData.items.forEach(item => {
                itemsHtml += `<tr><td>${escapeHtml(item.product_name)}</td><td>${item.sku || 'N/A'}</td><td>${item.quantity}</td><td>$${item.price.toFixed(2)}</td><td>$${item.subtotal.toFixed(2)}</td></tr>`;
            });
            const invoiceHtml = `<!DOCTYPE html><html><head><title>Invoice #${orderData.order_id}</title><style>body{font-family:sans-serif;padding:2rem;}.invoice{max-width:800px;margin:0 auto;}.header{text-align:center;margin-bottom:2rem;}table{width:100%;border-collapse:collapse;margin:1rem 0;}th,td{padding:0.5rem;text-align:left;border-bottom:1px solid #ddd;}.total{font-size:1.2rem;font-weight:bold;text-align:right;}</style></head><body><div class="invoice"><div class="header"><h1>Global Hardware Hub Invoice</h1><p>Order ID: #${orderData.order_id}</p><p>Date: ${formatDate(orderData.created_at)}</p></div><h3>Customer Information</h3><p>${escapeHtml(orderData.customer.name)}<br>${escapeHtml(orderData.customer.email)}<br>${escapeHtml(orderData.customer.phone)}</p><h3>Order Items</h3><table><thead><tr><th>Product</th><th>SKU</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>${itemsHtml}</tbody></table><h3>Summary</h3><p>Subtotal: $${(total - (total * 0.05)).toFixed(2)}<br>Platform Fee (5%): $${(total * 0.05).toFixed(2)}<br><strong>Grand Total: $${total.toFixed(2)}</strong></p><p>Thank you for shopping at Global Hardware Hub!</p></div></body></html>`;
            const win = window.open();
            win.document.write(invoiceHtml);
            win.document.close();
            win.print();
            showPopup("📄 Invoice generated successfully!");
        }

        // ============== RENDER ORDER DETAILS (100% UNCHANGED LOGIC) ==============
        function renderOrderDetails() {
            if (!orderData) return;
            const container = document.getElementById("orderDetailsContainer");
            const statusSteps = ["pending", "confirmed", "processing", "shipped", "delivered"];
            const stepLabels = { pending: "Pending", confirmed: "Confirmed", processing: "Processing", shipped: "Shipped", delivered: "Delivered" };
            const stepIcons = { pending: '<i class="fas fa-clock"></i>', confirmed: '<i class="fas fa-check-circle"></i>', processing: '<i class="fas fa-cogs"></i>', shipped: '<i class="fas fa-truck"></i>', delivered: '<i class="fas fa-box-open"></i>' };
            const currentIndex = getStatusIndex(orderData.status);

            let timelineHtml = `<div class="timeline">`;
            for (let i = 0; i < statusSteps.length; i++) {
                const step = statusSteps[i];
                const isCompleted = i < currentIndex;
                const isActive = i === currentIndex;
                timelineHtml += `
                <div class="timeline-step ${isCompleted ? 'completed' : ''} ${isActive ? 'active' : ''}">
                    <div class="step-icon">${stepIcons[step]}</div>
                    <div class="step-label">${stepLabels[step]}</div>
                    <div class="step-date"><i class="fas fa-calendar-alt"></i> ${isCompleted ? 'Completed' : (isActive ? 'In Progress' : 'Pending')}</div>
                </div>
            `;
            }
            timelineHtml += `</div>`;

            let itemsHtml = "";
            orderData.items.forEach(item => {
                const imgUrl = item.image_url || 'https://placehold.co/50x50/2563eb/white?text=Product';
                itemsHtml += `
                <tr>
                    <td><img class="product-img" src="${imgUrl}" alt="${escapeHtml(item.product_name)}" onerror="this.src='https://placehold.co/50x50/2563eb/white?text=Product'"></td>
                    <td><strong><i class="fas fa-microchip"></i> ${escapeHtml(item.product_name)}</strong></td>
                    <td><i class="fas fa-barcode"></i> ${item.sku || 'N/A'}</div></td>
                    <td><i class="fas fa-times"></i> ${item.quantity}</div></td>
                    <td> PKR ${item.price.toFixed(2)}</div></td>
                    <td> PKR ${item.subtotal.toFixed(2)}</div></td>
                </tr>
            `;
            });

            const platformFee = orderData.total_amount * 0.05;
            const vendorTotal = orderData.vendor_total || (orderData.total_amount - platformFee);

            container.innerHTML = `
            <div class="breadcrumb">
                <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="VendorOrders.php">Vendor Orders</a> / Order Details
            </div>
            <h1 class="page-title"><i class="fas fa-file-invoice"></i> Order Details</h1>
            
            <div class="card">
                <h2><i class="fas fa-chart-line"></i> Order Status Timeline</h2>
                ${timelineHtml}
            </div>
            
            <div class="card">
                <h2><i class="fas fa-info-circle"></i> Order Information</h2>
                <div class="info-grid">
                    <div class="info-item"><div class="info-label"><i class="fas fa-hashtag"></i> Order ID</div><div class="info-value">#${orderData.order_id}</div></div>
                    <div class="info-item"><div class="info-label"><i class="fas fa-calendar-alt"></i> Order Date</div><div class="info-value">${formatDate(orderData.created_at)}</div></div>
                    <div class="info-item"><div class="info-label"><i class="fas fa-credit-card"></i> Payment Method</div><div class="info-value">${escapeHtml(orderData.payment_method)}</div></div>
                    <div class="info-item"><div class="info-label"><i class="fas fa-chart-line"></i> Order Status</div><div class="info-value"><span class="status-badge ${getStatusClass(orderData.status)}"><i class="fas ${orderData.status === 'delivered' ? 'fa-check-circle' : (orderData.status === 'cancelled' ? 'fa-times-circle' : 'fa-clock')}"></i> ${orderData.status.toUpperCase()}</span></div></div>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-user"></i> Customer Information</h2>
                <div class="info-grid">
                    <div class="info-item"><div class="info-label"><i class="fas fa-user"></i> Customer Name</div><div class="info-value">${escapeHtml(orderData.customer.name)}</div></div>
                    <div class="info-item"><div class="info-label"><i class="fas fa-envelope"></i> Email</div><div class="info-value">${escapeHtml(orderData.customer.email)}</div></div>
                    <div class="info-item"><div class="info-label"><i class="fas fa-phone-alt"></i> Phone Number</div><div class="info-value">${escapeHtml(orderData.customer.phone)}</div></div>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-shopping-cart"></i> Ordered Items</h2>
                <div class="table-container">
                    <table class="items-table">
                        <thead>
                            <tr><th>Image</th><th>Product Name</th><th>SKU</th><th>Quantity</th><th>Price</th><th>Total</th></tr>
                        </thead>
                        <tbody>${itemsHtml}</tbody>
                    </table>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-calculator"></i> Order Summary</h2>
                <div class="summary">
                    <table class="summary-table">
                        <tr><td><i class="fas fa-receipt"></i> Subtotal:</td><td>PKR ${(orderData.total_amount - platformFee).toFixed(2)}</td></tr>
                        <tr><td><i class="fas fa-percent"></i> Platform Fee (5%):</td><td>PKR ${platformFee.toFixed(2)}</td></tr>
                        <tr class="grand-total"><td> <strong>Grand Total:</strong></td><td><strong>PKR ${orderData.total_amount.toFixed(2)}</strong></td></tr>
                        <tr style="border-top: 2px solid var(--gray-200);"><td><i class="fas fa-chart-line"></i> <strong>Your Earnings:</strong></td><td><strong>PKR ${vendorTotal.toFixed(2)}</strong></td></tr>
                    </table>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-cog"></i> Order Actions</h2>
                <div class="form-group">
                    <label><i class="fas fa-sync-alt"></i> Update Order Status</label>
                    <select id="statusSelect" class="status-select" style="width: auto;">
                        <option value="pending" ${orderData.status === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="confirmed" ${orderData.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                        <option value="processing" ${orderData.status === 'processing' ? 'selected' : ''}>Processing</option>
                        <option value="shipped" ${orderData.status === 'shipped' ? 'selected' : ''}>Shipped</option>
                        <option value="delivered" ${orderData.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                        <option value="cancelled" ${orderData.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                    </select>
                </div>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-truck"></i> Shipping Information</h2>
                <div class="info-grid">
                    <div class="form-group">
                        <label><i class="fas fa-qrcode"></i> Tracking Number</label>
                        <input type="text" id="trackingNumber" placeholder="Enter tracking number">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-shipping-fast"></i> Shipping Company</label>
                        <select id="shippingCompany">
                            <option value="">Select Carrier</option>
                            <option value="UPS">UPS</option>
                            <option value="FedEx">FedEx</option>
                            <option value="USPS">USPS</option>
                            <option value="DHL">DHL</option>
                        </select>
                    </div>
                </div>
                <div class="action-buttons">
                    <button id="generateLabelBtn" class="btn-secondary"><i class="fas fa-tag"></i> Generate Shipping Label</button>
                    <button id="markShippedBtn" class="btn-success"><i class="fas fa-check-circle"></i> Mark as Shipped</button>
                    <button id="printInvoiceBtn" class="btn-primary"><i class="fas fa-print"></i> Print Invoice</button>
                </div>
            </div>
        `;

            document.getElementById("statusSelect")?.addEventListener("change", (e) => {
                updateOrderStatus(e.target.value);
            });
            document.getElementById("markShippedBtn")?.addEventListener("click", markAsShipped);
            document.getElementById("generateLabelBtn")?.addEventListener("click", generateShippingLabel);
            document.getElementById("printInvoiceBtn")?.addEventListener("click", downloadInvoice);
        }

        // ============== LOGIN / LOGOUT (100% UNCHANGED) ==============
        function setAuthUI() {
            const authBtn = document.getElementById('authButton');
            if (authBtn) authBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
            renderMobileMenu();
        }

        function handleAuthClick() { window.location.href = 'Logout.php'; }
        document.getElementById('authButton')?.addEventListener('click', handleAuthClick);

        // ============== MOBILE MENU (100% UNCHANGED) ==============
        function renderMobileMenu() {
            const container = document.getElementById('mobileMenuContent');
            if (!container) return;
            const menuItems = [
                { title: "Home", link: "FYPHome.php" },
                { title: "Products", submenu: ["Categories", "Compare Products", "Product Details", "All Products"], links: ["Categories.php", "CompareProducts.php", "ProductDetails.php", "Products1.php"] },
                { title: "Vendors", submenu: ["Vendors List", "Vendors Store", "Vendors Setting", "Vendors Dashboard", "Vendors Products", "Vendors Add Products", "Vendors Edit Products", "Vendors Reviews", "Vendors Orders", "Vendor Order Details"], links: ["Vendors.php", "VendorsStore.php", "VendorsSetting.php", "VendorsDashboard.php", "VendorsProducts.php", "VendorsAddProducts.php", "VendorsEditProducts.php", "VendorsReviews.php", "VendorsOrders.php", "VendorOrderDetails.php"] },
                { title: "Account", submenu: ["My Account", "Profile", "Orders", "Order Details", "Wishlist", "Address Book", "Payment Methods", "Cart", "Checkout", "Checkout Shipping", "Checkout Payment"], links: ["MyAccount.php", "Profile.php", "UserOrders.php", "UserOrderDetails.php", "Wishlist.php", "AddressBook.php", "PaymentMethods.php", "Cart.php", "Checkout.php", "CheckoutShipping.php", "CheckoutPayment.php"] },
                { title: "Support", submenu: ["Contact", "FAQ", "Shipping Info", "Warranty Info", "Return Policy", "Privacy Policy", "Terms of Service", "About Us", "Cookie Policy"], links: ["ContactUs.php", "FAQ.php", "ShippingInfo.php", "WarrantyInfo.php", "ReturnPolicy.php", "PrivacyPolicy.php", "TermsofService.php", "AboutUs.php", "CookiePolicy.php"] },
                { title: "Blog", link: "Blog.php" },
                { title: "Blog Details", link: "BlogDetails.php" }
            ];
            let html = `<div style="margin-top:2rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%;"><i class="fas fa-sign-out-alt"></i> Logout</button></div><hr style="margin:1rem 0;">`;
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

        const hamburger = document.getElementById('hamburgerBtn');
        const mobilePanel = document.getElementById('mobileMenuPanel');
        const overlay = document.getElementById('mobileOverlay');
        function openMobile() { mobilePanel.classList.add('open'); overlay.classList.add('show'); }
        function closeMobile() { mobilePanel.classList.remove('open'); overlay.classList.remove('show'); }
        hamburger?.addEventListener('click', openMobile);
        document.getElementById('closeMobileBtn')?.addEventListener('click', closeMobile);
        overlay?.addEventListener('click', closeMobile);

        async function updateCartCount() {
            try {
                const response = await fetch('get_cart_summary.php');
                const result = await response.json();
                if (result.success && result.data) {
                    const count = result.data.total_items || 0;
                    document.getElementById('cartCountDisplay').innerText = count;
                }
            } catch (error) {
                console.error('Cart count error:', error);
            }
        }
        updateCartCount();

        document.querySelector('.cart-icon')?.addEventListener('click', () => {
            window.location.href = "Cart.php";
        });

        const backBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) backBtn.classList.add('show');
            else backBtn.classList.remove('show');
        });
        backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        async function init() {
            setAuthUI();
            renderMobileMenu();
            await fetchOrderDetails();
        }
        init();
    </script>
</body>

</html>