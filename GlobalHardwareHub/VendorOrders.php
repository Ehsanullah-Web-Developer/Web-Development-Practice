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
    <title>Global Hardware Hub | Vendor Orders</title>
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

        /* Orders Container */
        .orders-container {
            max-width: 1400px;
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

        /* Filter Section - White Card */
        .filter-section {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .filter-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .search-box {
            display: flex;
            gap: 0.5rem;
            flex: 1;
            min-width: 250px;
        }

        .search-box input {
            flex: 1;
            padding: 0.7rem 1rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 60px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .filter-dropdown {
            padding: 0.7rem 1rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 60px;
            background: white;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .filter-dropdown:focus {
            outline: none;
            border-color: var(--primary);
        }

        /* Table Container - White Card */
        .table-container {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1rem;
            overflow-x: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .table-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .orders-table th,
        .orders-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .orders-table th {
            color: var(--gray-600);
            font-weight: 700;
            font-size: 0.85rem;
            background: var(--gray-100);
        }

        .orders-table tr:hover {
            background: var(--gray-100);
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0.3rem 0.9rem;
            border-radius: 60px;
            font-size: 0.7rem;
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

        /* Status Dropdown */
        .status-select {
            padding: 0.4rem 0.8rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 60px;
            background: white;
            cursor: pointer;
            font-size: 0.75rem;
            margin-right: 0.5rem;
            transition: all 0.2s;
        }

        .status-select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn-view {
            background: var(--gray-100);
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-view:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--gray-600);
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
            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                width: 100%;
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
                <li class="nav-item"><a href="VendorDashboard.php" class="nav-link active">Vendor Dashboard</a></li>
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

    <div class="orders-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="VendorDashboard.php">Vendor
                Dashboard</a> / <span>Orders</span>
        </div>
        <h1 class="page-title"><i class="fas fa-box"></i> Vendor Orders</h1>

        <div class="filter-section">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="🔍 Search by Order ID...">
            </div>
            <select id="statusFilter" class="filter-dropdown">
                <option value="all">All Orders</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="table-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>Items Count</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody"></tbody>
            </table>
            <div id="emptyState" class="empty-state" style="display: none;"><i class="fas fa-inbox"></i> No orders found
                matching your criteria.</div>
        </div>
    </div>

    <footer class="footer">
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
                <a href="CompareProducts.php">Compare Products</a>
                <a href="AddressBook.php">Address Book</a>
                <a href="Blog.php">Tech Blog</a>
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

    <script>
        // ============== GLOBAL VARIABLES ==============
        let allOrders = [];
        let currentSearch = "";
        let currentStatusFilter = "all";

        // ============== HELPER FUNCTIONS ==============
        function showMessage(message, isError = false) {
            const popup = document.createElement('div');
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            popup.style.cssText = `
            position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
            background: ${isError ? '#ef4444' : '#10b981'}; color: white;
            padding: 12px 24px; border-radius: 60px; z-index: 10000;
            font-size: 14px; animation: fadeInOut 3s ease forwards; font-weight:500;
        `;
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 3000);
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }

        function getStatusClass(status) {
            const statusMap = {
                'pending': 'status-pending',
                'confirmed': 'status-confirmed',
                'processing': 'status-processing',
                'shipped': 'status-shipped',
                'delivered': 'status-delivered',
                'cancelled': 'status-cancelled'
            };
            return statusMap[status] || 'status-pending';
        }

        function getStatusText(status) {
            const statusMap = {
                'pending': 'Pending',
                'confirmed': 'Confirmed',
                'processing': 'Processing',
                'shipped': 'Shipped',
                'delivered': 'Delivered',
                'cancelled': 'Cancelled'
            };
            return statusMap[status] || status;
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

        // Format currency to PKR - THIS IS THE FIXED FUNCTION
        function formatCurrency(amount) {
            if (!amount && amount !== 0) return 'PKR 0.00';
            // Remove any existing currency symbols and convert to number
            let numericAmount = amount.toString().replace(/[^0-9.-]/g, '');
            let parsedAmount = parseFloat(numericAmount);
            if (isNaN(parsedAmount)) parsedAmount = 0;
            return `PKR ${parsedAmount.toFixed(2)}`;
        }

        // ============== API CALLS ==============
        async function loadOrders() {
            try {
                let url = 'get_vendor_orders.php';
                const params = [];
                if (currentStatusFilter !== 'all') {
                    params.push(`status=${currentStatusFilter}`);
                }
                if (currentSearch.trim()) {
                    params.push(`search=${currentSearch.trim()}`);
                }
                if (params.length > 0) {
                    url += '?' + params.join('&');
                }
                const response = await fetch(url);
                const result = await response.json();
                if (result.success) {
                    allOrders = result.data;
                    renderOrders();
                } else {
                    console.error('Load orders error:', result.message);
                    showMessage(result.message || 'Failed to load orders', true);
                    allOrders = [];
                    renderOrders();
                }
            } catch (error) {
                console.error('Fetch error:', error);
                showMessage('Failed to load orders', true);
                allOrders = [];
                renderOrders();
            }
        }

        async function updateOrderStatus(orderId, newStatus) {
            try {
                const response = await fetch('update_order_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order_id: orderId, status: newStatus })
                });
                const result = await response.json();
                if (result.success) {
                    showMessage(`Order #${orderId} status updated to ${getStatusText(newStatus)}`);
                    await loadOrders();
                } else {
                    showMessage(result.message || 'Failed to update status', true);
                    await loadOrders();
                }
            } catch (error) {
                console.error('Update status error:', error);
                showMessage('Failed to update order status', true);
            }
        }

        function viewOrderDetails(orderId) {
            window.location.href = `VendorOrderDetails.php?order_id=${orderId}`;
        }

        // ============== RENDER FUNCTIONS - FIXED CURRENCY TO PKR ==============
        function renderOrders() {
            const tbody = document.getElementById("ordersTableBody");
            const emptyState = document.getElementById("emptyState");
            if (!tbody) return;
            if (allOrders.length === 0) {
                tbody.innerHTML = "";
                emptyState.style.display = "block";
                return;
            }
            emptyState.style.display = "none";
            tbody.innerHTML = allOrders.map(order => {
                // Format the amount to PKR - THIS IS THE KEY FIX
                const formattedAmount = formatCurrency(order.total_amount);
                return `
                <tr data-id="${order.order_id}">
                    <td><strong><i class="fas fa-hashtag"></i> #${order.order_id}</strong></td>
                    <td><i class="fas fa-calendar-alt"></i> ${formatDate(order.created_at)}</div></td>
                    <td><i class="fas fa-user"></i> ${escapeHtml(order.customer_name)}</div></td>
                    <td><i class="fas fa-boxes"></i> ${order.total_items}</div></td>
                    <td>${formattedAmount}</div></td>
                    <td>
                        <span class="status-badge ${getStatusClass(order.status)}"><i class="fas ${getStatusIcon(order.status)}"></i> ${getStatusText(order.status)}</span>
                     </div></td>
                    <td>
                        <select class="status-select" data-id="${order.order_id}" data-status="${order.status}">
                            <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="confirmed" ${order.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                            <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Processing</option>
                            <option value="shipped" ${order.status === 'shipped' ? 'selected' : ''}>Shipped</option>
                            <option value="delivered" ${order.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                            <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                        </select>
                        <button class="btn-view" data-id="${order.order_id}"><i class="fas fa-eye"></i> View Details</button>
                     </div></td>
                <tr>
            `}).join('');
            
            document.querySelectorAll('.status-select').forEach(select => {
                select.removeEventListener('change', handleStatusChange);
                select.addEventListener('change', handleStatusChange);
            });
            document.querySelectorAll('.btn-view').forEach(btn => {
                btn.removeEventListener('click', handleViewDetails);
                btn.addEventListener('click', handleViewDetails);
            });
        }

        function getStatusIcon(status) {
            const icons = {
                'pending': 'fa-clock',
                'confirmed': 'fa-check-circle',
                'processing': 'fa-cogs',
                'shipped': 'fa-truck',
                'delivered': 'fa-box-open',
                'cancelled': 'fa-times-circle'
            };
            return icons[status] || 'fa-info-circle';
        }

        function handleStatusChange(e) {
            e.stopPropagation();
            const orderId = this.getAttribute('data-id');
            const newStatus = this.value;
            updateOrderStatus(orderId, newStatus);
        }

        function handleViewDetails(e) {
            const orderId = this.getAttribute('data-id');
            viewOrderDetails(orderId);
        }

        // ============== FILTER & SEARCH ==============
        function setupSearch() {
            const searchInput = document.getElementById("searchInput");
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    currentSearch = e.target.value;
                    loadOrders();
                });
            }
        }

        function setupFilter() {
            const filterSelect = document.getElementById("statusFilter");
            if (filterSelect) {
                filterSelect.addEventListener('change', (e) => {
                    currentStatusFilter = e.target.value;
                    loadOrders();
                });
            }
        }

        // ============== LOGIN / LOGOUT ==============
        function setAuthUI() {
            const authBtn = document.getElementById('authButton');
            if (authBtn) authBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
            renderMobileMenu();
        }

        function handleAuthClick() { window.location.href = 'Logout.php'; }
        document.getElementById('authButton')?.addEventListener('click', handleAuthClick);

        // ============== MOBILE MENU ==============
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

        // Update cart count
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

        // Cart click
        document.querySelector('.cart-icon')?.addEventListener('click', () => {
            window.location.href = "Cart.php";
        });

        // Back to Top
        const backBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) backBtn.classList.add('show');
            else backBtn.classList.remove('show');
        });
        backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        async function init() {
            setAuthUI();
            renderMobileMenu();
            setupSearch();
            setupFilter();
            await loadOrders();
        }
        init();
    </script>
</body>

</html>