<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Vendor Dashboard</title>
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

        /* Dashboard Container */
        .dashboard-container {
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

        /* KPI Cards - White Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .kpi-card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .kpi-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .kpi-info h3 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-800);
            margin-bottom: 0.2rem;
        }

        .kpi-desc {
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        .kpi-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        /* Chart Section - White Card */
        .chart-section {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .chart-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .chart-header h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chart-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .chart-btn {
            background: var(--gray-100);
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .chart-btn.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        .chart-btn:hover:not(.active) {
            background: var(--gray-200);
            transform: translateY(-2px);
        }

        /* Section Card - White Card */
        .section-card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Table */
        .orders-table {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        th {
            color: var(--gray-600);
            font-weight: 700;
            font-size: 0.85rem;
            background: var(--gray-100);
        }

        tr:hover {
            background: var(--gray-100);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0.25rem 0.9rem;
            border-radius: 60px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .status-pending {
            background: #fed7aa;
            color: #9b2c1d;
        }

        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-shipped {
            background: #c7d2fe;
            color: #3730a3;
        }

        .status-delivered {
            background: #d1fae5;
            color: #065f46;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background: #fee2e2;
            color: var(--danger);
        }

        .btn-sm {
            background: var(--gray-100);
            border: none;
            padding: 0.3rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-sm:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .product-card {
            background: var(--gray-100);
            border-radius: 24px;
            padding: 1rem;
            text-align: center;
            transition: all 0.2s;
            border: 1px solid var(--gray-200);
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
            background: white;
            border-color: var(--primary);
        }

        .product-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 0.5rem;
        }

        .product-name {
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.3rem;
        }

        .product-stats {
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        /* Alerts */
        .alert-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 1rem;
            background: #fff5f5;
            border-left: 3px solid var(--danger);
            margin-bottom: 0.5rem;
            border-radius: 16px;
            transition: all 0.2s;
        }

        .alert-item.medium {
            background: #fff7ed;
            border-left-color: var(--warning);
        }

        .alert-item:hover {
            transform: translateX(4px);
        }

        /* Reviews */
        .review-item {
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.3rem;
        }

        .review-rating {
            color: var(--warning);
        }

        .review-text {
            color: var(--gray-600);
            margin-bottom: 0.3rem;
            font-size: 0.85rem;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray-600);
        }

        /* Custom Beautiful Modal Styles */
        .custom-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(6px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease;
        }

        .custom-modal.active {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: white;
            border-radius: 48px;
            width: 90%;
            max-width: 460px;
            overflow: hidden;
            box-shadow: 0 40px 60px -20px rgba(0, 0, 0, 0.4);
            animation: slideUp 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            transform-origin: center;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: scale(0.96) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            padding: 1.5rem 1.8rem;
            text-align: center;
        }

        .modal-header i {
            font-size: 3rem;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.8rem;
            border-radius: 60px;
            margin-bottom: 0.8rem;
            display: inline-block;
        }

        .modal-header h3 {
            color: white;
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.3px;
        }

        .modal-body {
            padding: 2rem 1.8rem 1.5rem;
            text-align: center;
        }

        .modal-body p {
            font-size: 1.05rem;
            color: var(--gray-700);
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .modal-body .highlight-text {
            background: #eff6ff;
            color: var(--primary-dark);
            font-weight: 600;
            padding: 0.2rem 0.5rem;
            border-radius: 40px;
            display: inline-block;
            font-size: 0.9rem;
        }

        .modal-footer {
            padding: 0 1.8rem 2rem 1.8rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .modal-btn {
            border: none;
            padding: 0.7rem 1.6rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .modal-btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .modal-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        }

        .modal-btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .modal-btn-secondary:hover {
            background: var(--gray-200);
            transform: translateY(-2px);
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
            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            table,
            .orders-table {
                font-size: 0.8rem;
            }

            .page-title {
                font-size: 1.8rem;
            }
            
            .modal-content {
                max-width: 90%;
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

    <div class="dashboard-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Vendor Dashboard</span>
        </div>
        <h1 class="page-title"><i class="fas fa-chalkboard-user"></i> Vendor Dashboard</h1>

        <div class="kpi-grid" id="kpiGrid"></div>

        <div class="chart-section">
            <div class="chart-header">
                <h2><i class="fas fa-chart-line" style="color: var(--primary);"></i> Sales Overview</h2>
                <div class="chart-buttons">
                    <button class="chart-btn" data-period="daily"><i class="fas fa-calendar-day"></i> Daily</button>
                    <button class="chart-btn active" data-period="weekly"><i class="fas fa-calendar-week"></i>
                        Weekly</button>
                    <button class="chart-btn" data-period="monthly"><i class="fas fa-calendar-alt"></i> Monthly</button>
                </div>
            </div>
            <canvas id="salesChart" width="800" height="300" style="width:100%; height:300px;"></canvas>
        </div>

        <div class="section-card">
            <h2 class="section-title"><i class="fas fa-list-alt"></i> Recent Orders</h2>
            <div class="orders-table">
                <table id="ordersTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                    <tbody id="ordersBody"></tbody>
                </table>
            </div>
        </div>

        <div class="section-card">
            <h2 class="section-title"><i class="fas fa-trophy"></i> Top Selling Products</h2>
            <div id="topProductsGrid" class="products-grid"></div>
        </div>

        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="section-card">
                <h2 class="section-title"><i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i> Low
                    Stock Alerts</h2>
                <div id="lowStockList"></div>
            </div>
            <div class="section-card">
                <h2 class="section-title"><i class="fas fa-star" style="color: var(--warning);"></i> Recent Reviews</h2>
                <div id="reviewsList"></div>
            </div>
        </div>
    </div>

    <!-- Beautiful Custom Modal -->
    <div id="restockModal" class="custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-store"></i>
                <h3>Restock Product</h3>
            </div>
            <div class="modal-body">
                <p>🛒 <strong>Go to Edit Products page</strong> to restock this product.</p>
                <p style="font-size: 0.85rem; margin-top: 8px;">Manage inventory, update quantities, and keep your store running smoothly.</p>
                <div style="margin-top: 12px;">
                    <span class="highlight-text"><i class="fas fa-arrow-right"></i> Vendor Products → Edit</span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" id="closeModalBtn"><i class="fas fa-times"></i> Cancel</button>
                <button class="modal-btn modal-btn-primary" id="goToEditProductsBtn"><i class="fas fa-edit"></i> Go to Edit Products</button>
            </div>
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

    <script>
        // ============== VENDOR SESSION CHECK ==============
        // PHP session already verified vendor at top of page

        // ============== MODAL MANAGEMENT ==============
        const modal = document.getElementById('restockModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const goToEditBtn = document.getElementById('goToEditProductsBtn');

        function showRestockModal() {
            if (modal) {
                modal.classList.add('active');
            }
        }

        function hideModal() {
            if (modal) {
                modal.classList.remove('active');
            }
        }

        // Close modal on cancel or clicking outside
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', hideModal);
        }
        if (goToEditBtn) {
            goToEditBtn.addEventListener('click', () => {
                // Redirect to Vendor Products Management page (Edit Products page)
                window.location.href = 'VendorProductsManagement.php';
            });
        }
        // Click outside modal content to close
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    hideModal();
                }
            });
        }

        // Global restock handler that shows beautiful modal instead of alert
        window.handleRestockClick = function(productName) {
            showRestockModal();
        };

        // ============== HELPER FUNCTIONS ==============
        function showMessage(containerId, message, isError = false) {
            const container = document.getElementById(containerId);
            if (container) {
                container.innerHTML = `<div class="empty-state"><i class="fas fa-info-circle"></i> ${message}</div>`;
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

        function renderStars(rating) {
            if (!rating || rating === 0) return "☆☆☆☆☆";
            const fullStars = Math.floor(rating);
            const halfStar = rating % 1 >= 0.5;
            let stars = "";
            for (let i = 0; i < fullStars; i++) stars += "★";
            if (halfStar) stars += "½";
            for (let i = stars.length; i < 5; i++) stars += "☆";
            return stars;
        }

        // ============== LOAD DASHBOARD STATS ==============
        async function loadDashboardStats() {
            try {
                const response = await fetch('get_vendor_dashboard_stats.php');
                const result = await response.json();
                if (result.success && result.data) {
                    const stats = result.data;
                    const kpiGrid = document.getElementById('kpiGrid');
                    kpiGrid.innerHTML = `
                    <div class="kpi-card"><div><div class="kpi-info"><h3><i class="fas fa-chart-line"></i> Total Sales</h3><div class="kpi-value">PKR ${stats.total_sales.toLocaleString()}</div><div class="kpi-desc">Lifetime revenue</div></div></div><div class="kpi-icon"></div></div>
                    <div class="kpi-card"><div><div class="kpi-info"><h3><i class="fas fa-clock"></i> Pending Orders</h3><div class="kpi-value">${stats.pending_orders}</div><div class="kpi-desc">Need attention</div></div></div><div class="kpi-icon"><i class="fas fa-box"></i></div></div>
                    <div class="kpi-card"><div><div class="kpi-info"><h3><i class="fas fa-boxes"></i> Total Products</h3><div class="kpi-value">${stats.total_products}</div><div class="kpi-desc">Active listings</div></div></div><div class="kpi-icon"><i class="fas fa-microchip"></i></div></div>
                    <div class="kpi-card"><div><div class="kpi-info"><h3><i class="fas fa-star"></i> Avg Rating</h3><div class="kpi-value">${stats.avg_rating} ★</div><div class="kpi-desc">Customer satisfaction</div></div></div><div class="kpi-icon"><i class="fas fa-star"></i></div></div>
                `;
                } else {
                    console.error('Stats error:', result.message);
                }
            } catch (error) {
                console.error('Fetch stats error:', error);
            }
        }

        // ============== LOAD RECENT ORDERS ==============
        async function loadRecentOrders() {
            try {
                const response = await fetch('get_vendor_recent_orders.php');
                const result = await response.json();
                const tbody = document.getElementById('ordersBody');
                if (result.success && result.data && result.data.length > 0) {
                    tbody.innerHTML = result.data.map(order => `
                    <tr>
                        <td>#${order.order_id}</td>
                        <td><i class="fas fa-user"></i> ${escapeHtml(order.customer_name)}</td>
                        <td><i class="fas fa-box"></i> ${order.total_items}</td>
                        <td>PKR ${order.total_amount.toFixed(2)}</td>
                        <td><span class="status-badge status-${order.status.toLowerCase()}"><i class="fas ${order.status.toLowerCase() === 'delivered' ? 'fa-check-circle' : (order.status.toLowerCase() === 'cancelled' ? 'fa-times-circle' : 'fa-clock')}"></i> ${order.status}</span></td>
                        <td><button class="btn-sm" onclick="viewOrder(${order.order_id})"><i class="fas fa-eye"></i> View</button></td>
                    </tr>
                `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="empty-state"><i class="fas fa-inbox"></i> No recent orders found</td></tr>';
                }
            } catch (error) {
                console.error('Fetch orders error:', error);
                document.getElementById('ordersBody').innerHTML = '<tr><td colspan="6" class="empty-state"><i class="fas fa-exclamation-circle"></i> Failed to load orders</td></tr>';
            }
        }

        // ============== LOAD TOP PRODUCTS ==============
        async function loadTopProducts() {
            try {
                const response = await fetch('get_vendor_top_products.php');
                const result = await response.json();
                const container = document.getElementById('topProductsGrid');
                if (result.success && result.data && result.data.length > 0) {
                    container.innerHTML = result.data.map(product => `
                    <div class="product-card">
                        <img src="${product.image_url || 'https://placehold.co/200x120/2563eb/white?text=Product'}" alt="${escapeHtml(product.product_name)}" onerror="this.src='https://placehold.co/200x120/2563eb/white?text=Product'">
                        <div class="product-name"><i class="fas fa-microchip"></i> ${escapeHtml(product.product_name)}</div>
                        <div class="product-stats"><i class="fas fa-chart-simple"></i> ${product.total_sold} units sold</div>
                        <div class="product-stats"> PKR ${product.total_revenue.toLocaleString()} revenue</div>
                    </div>
                `).join('');
                } else {
                    container.innerHTML = '<div class="empty-state"><i class="fas fa-box-open"></i> No top selling products found</div>';
                }
            } catch (error) {
                console.error('Fetch top products error:', error);
                document.getElementById('topProductsGrid').innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-circle"></i> Failed to load top products</div>';
            }
        }

        // ============== LOAD LOW STOCK PRODUCTS ==============
        async function loadLowStockProducts() {
            try {
                const response = await fetch('get_vendor_low_stock_products.php');
                const result = await response.json();
                const container = document.getElementById('lowStockList');
                if (result.success && result.data && result.data.length > 0) {
                    container.innerHTML = result.data.map(product => {
                        const alertClass = product.stock_quantity <= 1 ? '' : 'medium';
                        return `
                        <div class="alert-item ${alertClass}">
                            <div><strong><i class="fas fa-box"></i> ${escapeHtml(product.product_name)}</strong><br><i class="fas fa-cubes"></i> Stock: ${product.stock_quantity} units (${product.stock_status})</div>
                            <button class="btn-sm" onclick="handleRestockClick('${escapeHtml(product.product_name)}')"><i class="fas fa-plus"></i> Restock</button>
                        </div>
                    `;
                    }).join('');
                } else {
                    container.innerHTML = '<div class="empty-state"><i class="fas fa-check-circle"></i> All products have sufficient stock</div>';
                }
            } catch (error) {
                console.error('Fetch low stock error:', error);
                document.getElementById('lowStockList').innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-circle"></i> Failed to load low stock alerts</div>';
            }
        }

        // ============== LOAD RECENT REVIEWS ==============
        async function loadRecentReviews() {
            try {
                const response = await fetch('get_vendor_recent_reviews.php');
                const result = await response.json();
                const container = document.getElementById('reviewsList');
                if (result.success && result.data && result.data.length > 0) {
                    container.innerHTML = result.data.map(review => `
                    <div class="review-item" data-id="${review.vendor_review_id}">
                        <div class="review-header">
                            <strong><i class="fas fa-user-circle"></i> ${escapeHtml(review.customer_name)}</strong>
                            <div class="review-rating"><i class="fas fa-star"></i> ${renderStars(review.rating)} (${review.rating})</div>
                        </div>
                        <div class="review-text"><i class="fas fa-quote-left"></i> "${escapeHtml(review.comment)}"</div>
                        <div style="font-size:0.7rem; color:var(--gray-600);"><i class="fas fa-calendar-alt"></i> ${new Date(review.created_at).toLocaleDateString()}</div>
                    </div>
                `).join('');
                } else {
                    container.innerHTML = '<div class="empty-state"><i class="fas fa-comment-slash"></i> No recent reviews found</div>';
                }
            } catch (error) {
                console.error('Fetch reviews error:', error);
                document.getElementById('reviewsList').innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-circle"></i> Failed to load reviews</div>';
            }
        }

        // ============== VIEW ORDER FUNCTION ==============
        window.viewOrder = function (orderId) {
            window.location.href = `VendorOrderDetails.php?order_id=${orderId}`;
        };

        // ============== SALES CHART ==============
        let currentPeriod = "weekly";
        let chart;
        const salesData = {
            daily: { labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], values: [1200, 1900, 1700, 2100, 2800, 3200, 2900] },
            weekly: { labels: ["Week 1", "Week 2", "Week 3", "Week 4"], values: [8500, 10200, 11800, 13400] },
            monthly: { labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"], values: [32000, 35400, 41200, 38900, 45600, 48500] }
        };

        function initChart() {
            const ctx = document.getElementById("salesChart").getContext("2d");
            const data = salesData[currentPeriod];
            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Sales ($)',
                        data: data.values,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.05)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { position: 'top' } }
                }
            });
        }

        document.querySelectorAll(".chart-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                document.querySelectorAll(".chart-btn").forEach(b => b.classList.remove("active"));
                btn.classList.add("active");
                currentPeriod = btn.getAttribute("data-period");
                initChart();
            });
        });

        // ============== LOGOUT FUNCTIONALITY ==============
        function handleLogout() {
            window.location.href = "Logout.php";
        }
        const logoutBtn = document.getElementById("authButton");
        if (logoutBtn) logoutBtn.addEventListener("click", handleLogout);

        // ============== MOBILE MENU ==============
        function renderMobileMenu() {
            const container = document.getElementById("mobileMenuContent");
            if (!container) return;
            const logged = true;
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
            if (mobileAuth) mobileAuth.onclick = () => { window.location.href = "Logout.php"; };
        }

        const hamburger = document.getElementById("hamburgerBtn");
        const mobilePanel = document.getElementById("mobileMenuPanel");
        const overlay = document.getElementById("mobileOverlay");
        function openMobile() { mobilePanel.classList.add("open"); overlay.classList.add("show"); }
        function closeMobile() { mobilePanel.classList.remove("open"); overlay.classList.remove("show"); }
        hamburger?.addEventListener("click", openMobile);
        document.getElementById("closeMobileBtn")?.addEventListener("click", closeMobile);
        overlay?.addEventListener("click", closeMobile);

        // Back to Top
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        if (backBtn) backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // Load Chart.js
        const scriptElem = document.createElement('script');
        scriptElem.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js';
        scriptElem.onload = () => { initChart(); };
        document.head.appendChild(scriptElem);

        // ============== INITIALIZE DASHBOARD ==============
        async function initDashboard() {
            renderMobileMenu();
            await loadDashboardStats();
            await loadRecentOrders();
            await loadTopProducts();
            await loadLowStockProducts();
            await loadRecentReviews();
        }
        initDashboard();
    </script>
</body>

</html>