<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts: Inter for modern typography -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: #F9FAFB;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR STYLES ========== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100%;
            background: linear-gradient(180deg, #0F2B4D 0%, #1A3A5F 100%);
            color: #EFF6FF;
            z-index: 100;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            scrollbar-width: thin;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-logo span,
        .sidebar.collapsed .sidebar-nav li span,
        .sidebar.collapsed .sidebar-footer span {
            display: none;
        }

        .sidebar.collapsed .sidebar-nav li a {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .sidebar-nav li a i {
            margin-right: 0;
            font-size: 1.3rem;
        }

        .sidebar-logo {
            padding: 28px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            margin-bottom: 24px;
        }

        .sidebar-logo h2 {
            font-size: 1.35rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.3px;
        }

        .sidebar-logo i {
            font-size: 1.6rem;
            color: #60A5FA;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0 16px;
        }

        .sidebar-nav li {
            margin-bottom: 6px;
        }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: rgba(239, 246, 255, 0.8);
            text-decoration: none;
            border-radius: 14px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .sidebar-nav li a i {
            width: 26px;
            margin-right: 14px;
            font-size: 1.15rem;
            transition: transform 0.2s;
        }

        .sidebar-nav li a:hover {
            background: rgba(96, 165, 250, 0.2);
            color: white;
            transform: translateX(4px);
        }

        .sidebar-nav li a:hover i {
            transform: scale(1.05);
        }

        .sidebar-nav li.active a {
            background: linear-gradient(95deg, #2563EB, #4F46E5);
            color: white;
            box-shadow: 0 6px 12px -6px rgba(37, 99, 235, 0.35);
        }

        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            padding: 16px 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer li {
            list-style: none;
        }

        .sidebar-footer li a {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: rgba(239, 246, 255, 0.8);
            text-decoration: none;
            border-radius: 14px;
            transition: all 0.2s;
        }

        .sidebar-footer li a i {
            width: 26px;
            margin-right: 14px;
        }

        .sidebar-footer li a:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #FCA5A5;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 260px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* ========== TOP NAVBAR ========== */
        .top-navbar {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(2px);
            padding: 0.9rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 99;
            border-bottom: 1px solid #E5E7EB;
        }

        .sidebar-toggle-btn {
            background: #F3F4F6;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: #1F2937;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-toggle-btn:hover {
            background: #E5E7EB;
            transform: scale(0.96);
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            font-size: 1.3rem;
            color: #4B5563;
            transition: color 0.2s;
            background: #F3F4F6;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        .notification-icon:hover {
            color: #2563EB;
            background: #EFF6FF;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #EF4444;
            color: white;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 30px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #F9FAFB;
            padding: 6px 16px 6px 8px;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid #E5E7EB;
        }

        .admin-info:hover {
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #2563EB, #4F46E5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .admin-name {
            font-weight: 600;
            color: #1F2937;
            font-size: 0.9rem;
        }

        /* ========== CONTENT SECTIONS ========== */
        .content-area {
            padding: 28px 32px;
        }

        .section {
            display: none;
            animation: fadeSlideUp 0.35s ease-out;
        }

        .section.active {
            display: block;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.75rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.25s ease;
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #2563EB, #4F46E5);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.12);
            border-color: #E0E7FF;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-icon {
            font-size: 2.2rem;
            color: #2563EB;
            opacity: 0.8;
        }

        .stat-title {
            color: #6B7280;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 600;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
        }

        /* Charts Row */
        .charts-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            text-align: center;
            border: 1px solid #F3F4F6;
        }

        .chart-card h3 {
            font-size: 1rem;
            color: #1F2937;
            margin-bottom: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .chart-image {
            width: 100%;
            max-height: 280px;
            object-fit: contain;
        }

        /* Tables */
        .table-container {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
            border: 1px solid #F0F2F5;
            overflow-x: auto;
        }

        .section-title {
            font-size: 1.35rem;
            margin-bottom: 1.5rem;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            letter-spacing: -0.2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #F0F2F5;
        }

        th {
            color: #4B5563;
            font-weight: 600;
            font-size: 0.85rem;
            background: #FCFDFE;
            letter-spacing: 0.3px;
        }

        tr {
            transition: background 0.2s;
        }

        tr:hover {
            background: #F9FAFB;
        }

        /* Status Badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
            letter-spacing: 0.3px;
        }

        .status-pending {
            background: #FEF3C7;
            color: #B45309;
        }

        .status-shipped {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .status-delivered {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-active {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-inactive {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .status-blocked {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .status-resolved {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-closed {
            background: #E5E7EB;
            color: #4B5563;
        }

        /* Buttons */
        .btn-table {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px 10px;
            border-radius: 10px;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .btn-edit {
            color: #2563EB;
        }

        .btn-edit:hover {
            background: #EFF6FF;
            transform: scale(1.05);
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
        }

        .btn-delete {
            color: #DC2626;
        }

        .btn-delete:hover {
            background: #FEF2F2;
            transform: scale(1.05);
        }

        .btn-view {
            background: #F3F4F6;
            color: #1F2937;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-view:hover {
            background: #2563EB;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px -6px #2563EB;
        }

        .product-img {
            width: 44px;
            height: 44px;
            background: #F3F4F6;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #E5E7EB;
        }

        .stars {
            color: #FBBF24;
            letter-spacing: 2px;
        }

        /* Settings Form */
        .settings-form {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            max-width: 680px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.03);
            border: 1px solid #F0F2F5;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.85rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.85rem 1rem;
            padding-right: 2.8rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
        }

        .form-group input:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            bottom: 14px;
            cursor: pointer;
            color: #9CA3AF;
            background: white;
            padding: 0 4px;
        }

        .btn-save {
            background: linear-gradient(95deg, #2563EB, #4F46E5);
            color: white;
            border: none;
            padding: 0.8rem 1.8rem;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 600;
            margin-right: 12px;
            transition: all 0.2s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -10px #2563EB;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(6px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 32px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            padding: 1.8rem;
            position: relative;
            animation: modalPop 0.25s ease-out;
            box-shadow: 0 32px 48px -16px rgba(0, 0, 0, 0.2);
        }

        @keyframes modalPop {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .close-modal {
            position: absolute;
            top: 18px;
            right: 22px;
            font-size: 26px;
            cursor: pointer;
            color: #9CA3AF;
            transition: 0.2s;
        }

        .close-modal:hover {
            color: #1F2937;
        }

        select.status-select {
            padding: 6px 12px;
            border-radius: 30px;
            border: 1px solid #E5E7EB;
            margin-left: 8px;
            font-size: 0.75rem;
            background: white;
            font-weight: 500;
        }

        /* Toast notifications */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1F2937;
            color: white;
            padding: 14px 28px;
            border-radius: 60px;
            z-index: 2000;
            animation: slideInRight 0.3s ease;
            font-weight: 500;
            font-size: 0.85rem;
            box-shadow: 0 12px 20px -10px rgba(0, 0, 0, 0.2);
        }

        .toast.success {
            background: #10B981;
        }

        .toast.error {
            background: #EF4444;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 200;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .charts-row {
                grid-template-columns: 1fr;
            }

            .content-area {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <h2><i class="fas fa-microchip"></i> <span>Global Hub</span></h2>
        </div>
        <ul class="sidebar-nav">
            <li data-section="dashboard"><a href="#"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li data-section="orders"><a href="#"><i class="fas fa-shopping-cart"></i> <span>Orders</span></a></li>
            <li data-section="products"><a href="#"><i class="fas fa-box"></i> <span>Products</span></a></li>
            <li data-section="users"><a href="#"><i class="fas fa-users"></i> <span>Users</span></a></li>
            <li data-section="vendors"><a href="#"><i class="fas fa-store"></i> <span>Vendors</span></a></li>
            <li data-section="reviews"><a href="#"><i class="fas fa-star"></i> <span>Reviews</span></a></li>
            <li data-section="tickets"><a href="#"><i class="fas fa-ticket-alt"></i> <span>Support Tickets</span></a>
            </li>
            <li data-section="settings"><a href="#"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
        </ul>
        <div class="sidebar-footer">
            <li style="list-style: none;" data-section="logout"><a href="#" id="logoutBtn"><i
                        class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
        </div>
    </div>

    <div class="main-content" id="mainContent">
        <div class="top-navbar">
            <button class="sidebar-toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <div class="navbar-right">
                <div class="notification-icon"><i class="fas fa-bell"></i><span class="notification-badge">3</span>
                </div>
                <div class="admin-info">
                    <div class="admin-avatar"><i class="fas fa-user-shield"></i></div><span class="admin-name"
                        id="adminNameDisplay">Admin Panel</span>
                </div>
            </div>
        </div>
        <div class="content-area">
            <!-- DASHBOARD SECTION -->
            <div id="dashboard-section" class="section active">
                <div class="stats-grid" id="statsGrid">
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-title">Total Users</span><i
                                class="fas fa-users stat-icon"></i></div>
                        <div class="stat-value" id="totalUsers">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-title">Total Orders</span><i
                                class="fas fa-shopping-cart stat-icon"></i></div>
                        <div class="stat-value" id="totalOrders">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-title">Total Products</span><i
                                class="fas fa-box stat-icon"></i></div>
                        <div class="stat-value" id="totalProducts">0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-title">Total Revenue</span><i
                                class="fas fa-dollar-sign stat-icon"></i></div>
                        <div class="stat-value" id="totalRevenue">$0</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header"><span class="stat-title">Pending Orders</span><i
                                class="fas fa-clock stat-icon"></i></div>
                        <div class="stat-value" id="pendingOrders">0</div>
                    </div>
                </div>
                <div class="charts-row">
                    <div class="chart-card">
                        <h3><i class="fas fa-chart-line"></i> Monthly Revenue Trend</h3><img src="chart1.jpg"
                            class="chart-image" alt="Revenue Chart">
                    </div>
                    <div class="chart-card">
                        <h3><i class="fas fa-chart-pie"></i> Order Status Distribution</h3><img src="chart4.jpg"
                            class="chart-image" alt="Status Chart">
                    </div>
                </div>
                <div class="charts-row">
                    <div class="chart-card">
                        <h3><i class="fas fa-chart-bar"></i> Top Selling Products</h3><img src="chart3.jpg"
                            class="chart-image" alt="Products Chart">
                    </div>
                    <div class="chart-card">
                        <h3><i class="fas fa-users"></i> User Growth (Last 6 Months)</h3><img src="chart2.jpg"
                            class="chart-image" alt="Growth Chart">
                    </div>
                </div>
                <div class="table-container">
                    <h3 style="margin-bottom: 1rem;">📋 Recent Orders</h3>
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Vendor</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="recentOrdersTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- ORDERS SECTION -->
            <div id="orders-section" class="section">
                <div class="section-title"><i class="fas fa-shopping-cart"></i> All Orders</div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Vendor Name</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="allOrdersTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- PRODUCTS SECTION -->
            <div id="products-section" class="section">
                <div class="section-title"><i class="fas fa-box"></i> Product Management</div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="productsTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- USERS SECTION -->
            <div id="users-section" class="section">
                <div class="section-title"><i class="fas fa-users"></i> User Management</div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="usersTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- VENDORS SECTION -->
            <div id="vendors-section" class="section">
                <div class="section-title"><i class="fas fa-store"></i> Vendor List</div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Vendor Name</th>
                                <th>Rating</th>
                                <th>Total Products</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="vendorsTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- REVIEWS SECTION -->
            <div id="reviews-section" class="section">
                <div class="section-title"><i class="fas fa-star"></i> Customer Reviews</div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>User</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="reviewsTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- TICKETS SECTION -->
            <div id="tickets-section" class="section">
                <div class="section-title"><i class="fas fa-ticket-alt"></i> Support Tickets</div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>Subject</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="ticketsTable"></tbody>
                    </table>
                </div>
            </div>

            <!-- SETTINGS SECTION -->
            <div id="settings-section" class="section">
                <div class="section-title"><i class="fas fa-cog"></i> Admin Settings</div>
                <div class="settings-form">
                    <div class="form-group"><label>Admin Name</label><input type="text" id="adminNameInput"></div>
                    <div class="form-group"><label>Email Address</label><input type="email" id="adminEmailInput"></div>
                    <div class="form-group"><label>Phone</label><input type="text" id="adminPhoneInput"></div>
                    <div class="form-group"><label>Current Password</label><input type="password"
                            id="currentPassword"><span class="password-toggle"
                            onclick="togglePassword('currentPassword')"><i class="fas fa-eye"></i></span></div>
                    <div class="form-group"><label>New Password</label><input type="password" id="newPassword"><span
                            class="password-toggle" onclick="togglePassword('newPassword')"><i
                                class="fas fa-eye"></i></span></div>
                    <div class="form-group"><label>Confirm Password</label><input type="password"
                            id="confirmPassword"><span class="password-toggle"
                            onclick="togglePassword('confirmPassword')"><i class="fas fa-eye"></i></span></div>
                    <button class="btn-save" id="saveSettingsBtn">Save Profile</button><button class="btn-save"
                        id="changePasswordBtn">Change Password</button>
                </div>
            </div>
        </div>
    </div>

    <div id="orderModal" class="modal">
        <div class="modal-content"><span class="close-modal">&times;</span>
            <h3>Order Details</h3>
            <div id="orderDetailsContent"></div>
        </div>
    </div>
    <div id="ticketModal" class="modal">
        <div class="modal-content"><span class="close-modal">&times;</span>
            <h3>Ticket Details & Reply</h3>
            <div id="ticketDetailsContent"></div><textarea id="replyMessage" placeholder="Write reply..." rows="3"
                style="width:100%;margin:10px 0; border-radius:16px; padding:10px; border:1px solid #E5E7EB;"></textarea><button
                id="sendReplyBtn" class="btn-save">Send Reply</button><select id="ticketStatusSelect"
                class="status-select">
                <option value="Open">Open</option>
                <option value="Pending">Pending</option>
                <option value="Resolved">Resolved</option>
                <option value="Closed">Closed</option>
            </select><button id="updateStatusBtn" class="btn-save" style="margin-top:10px;">Update Status</button>
        </div>
    </div>

    <script>
        // ==================== API FUNCTIONS ====================
        async function fetchAPI(url, options = {}) {
            try {
                const res = await fetch(url, options);
                return await res.json();
            } catch (e) {
                console.error(e);
                return { success: false, message: "Network error" };
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerText = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function getStatusClass(status) {
            const st = (status || '').toLowerCase();
            if (st === 'pending') return 'status-pending';
            if (st === 'shipped') return 'status-shipped';
            if (st === 'delivered') return 'status-delivered';
            if (st === 'active') return 'status-active';
            if (st === 'inactive') return 'status-inactive';
            if (st === 'blocked') return 'status-blocked';
            if (st === 'resolved') return 'status-resolved';
            if (st === 'closed') return 'status-closed';
            return 'status-pending';
        }

        function renderStars(rating) {
            const full = Math.floor(rating);
            let stars = '';
            for (let i = 1; i <= 5; i++) stars += i <= full ? '★' : '☆';
            return `<span class="stars">${stars}</span>`;
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

        // ==================== AUTH & DASHBOARD ====================
        async function checkAuth() {
            const res = await fetchAPI('get_admin_profile.php');
            if (!res.success) {
                window.location.href = 'AdminLogin.php';
            } else {
                document.getElementById('adminNameInput').value = res.profile.full_name;
                document.getElementById('adminEmailInput').value = res.profile.email;
                document.getElementById('adminPhoneInput').value = res.profile.phone || '';
                document.getElementById('adminNameDisplay').innerText = res.profile.full_name;
            }
        }

        async function loadDashboardStats() {
            const res = await fetchAPI('admin_dashboard_stats.php');
            if (res.success) {
                document.getElementById('totalUsers').innerText = res.stats.total_users;
                document.getElementById('totalOrders').innerText = res.stats.total_orders;
                document.getElementById('totalProducts').innerText = res.stats.total_products;
                document.getElementById('totalRevenue').innerText = '₹' + res.stats.total_revenue.toLocaleString();
                document.getElementById('pendingOrders').innerText = res.stats.pending_orders;
            }
        }

        // ==================== ORDERS ====================
        async function loadRecentOrders() {
            const res = await fetchAPI('get_recent_orders.php');
            if (res.success && res.orders && Array.isArray(res.orders)) {
                const sortedOrders = [...res.orders].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                let html = '';
                sortedOrders.forEach(o => {
                    const orderDate = o.created_at ? o.created_at.split(' ')[0] : 'N/A';
                    const amount = (typeof o.total_amount === 'number') ? o.total_amount.toLocaleString() : '0';
                    html += `<tr>
                        <td>#${o.order_id}</td>
                        <td>${escapeHtml(o.customer_name || 'Guest')}</td>
                        <td>${escapeHtml(o.vendor_name || 'N/A')}</td>
                        <td>₹${amount}</td>
                        <td><span class="status-badge ${getStatusClass(o.status)}">${o.status || 'Pending'}</span></td>
                        <td>${orderDate}</td>
                        <td><button class="btn-view" onclick="viewOrder(${o.order_id})">View</button></td>
                    </tr>`;
                });
                document.getElementById('recentOrdersTable').innerHTML = html;
            } else {
                document.getElementById('recentOrdersTable').innerHTML = '<tr><td colspan="7" style="text-align:center;">No recent orders found</td></tr>';
            }
        }

        window.viewOrder = function (orderId) {
            window.location.href = `AdminOrderDetails.php?order_id=${orderId}`;
        };

        async function loadAllOrders() {
            const res = await fetchAPI('get_all_orders.php');
            if (res.success && res.orders) {
                let html = '';
                res.orders.forEach(o => {
                    html += `<tr>
                        <td>#${o.order_id}</td>
                        <td>${escapeHtml(o.customer_name)}</td>
                        <td>${escapeHtml(o.vendor_name || 'N/A')}</td>
                        <td>₹${o.total_amount.toLocaleString()}</td>
                        <td><span class="status-badge ${getStatusClass(o.status)}">${o.status}</span></td>
                        <td>${o.created_at ? o.created_at.split(' ')[0] : 'N/A'}</td>
                        <td><button class="btn-view" onclick="viewOrder(${o.order_id})">View</button></td>
                    </tr>`;
                });
                document.getElementById('allOrdersTable').innerHTML = html;
            } else {
                document.getElementById('allOrdersTable').innerHTML = '<tr><td colspan="7" style="text-align:center;">No orders found</td></tr>';
            }
        }

        // ==================== PRODUCTS ====================
        async function loadProducts() {
            const res = await fetchAPI('get_all_products.php');
            if (res.success && res.products) {
                let html = '';
                res.products.forEach(p => {
                    let imgUrl = p.image_url;
                    if (!imgUrl || imgUrl === '' || imgUrl === 'uploads/products/default.png') {
                        imgUrl = 'https://via.placeholder.com/40x40/0a2b5e/ffffff?text=No+Img';
                    }
                    html += `<tr>
                        <td><img src="${imgUrl}" class="product-img" onerror="this.src='https://via.placeholder.com/40x40/ff4444/ffffff?text=Error'"></td>
                        <td><strong>${escapeHtml(p.product_name)}</strong></td>
                        <td>₹${p.price.toLocaleString()}</td>
                        <td><span class="status-badge ${getStatusClass(p.status)}">${p.status}</span></td>
                        <td>
                            <button class="btn-table btn-edit" onclick="editProductName(${p.product_id}, '${p.product_name.replace(/'/g, "\\'")}')" title="Edit Name"><i class="fas fa-edit"></i></button>
                            <button class="btn-table btn-edit" onclick="editProductPrice(${p.product_id}, ${p.price})" title="Edit Price" style="color:#10b981"><i class="fas fa-tag"></i></button>
                            <button class="btn-table btn-delete" onclick="deleteProduct(${p.product_id})" title="Delete"><i class="fas fa-trash"></i></button>
                            <select onchange="updateProductStatus(${p.product_id}, this.value)" class="status-select">
                                <option value="active" ${p.status === 'active' ? 'selected' : ''}>Active</option>
                                <option value="inactive" ${p.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                                <option value="out_of_stock" ${p.status === 'out_of_stock' ? 'selected' : ''}>Out of Stock</option>
                            </select>
                        </td>
                    </tr>`;
                });
                document.getElementById('productsTable').innerHTML = html;
            } else {
                document.getElementById('productsTable').innerHTML = '<tr><td colspan="5" style="text-align:center;">No products found</td></tr>';
            }
        }

        window.editProductName = async (id, currentName) => {
            const newName = prompt('Enter new product name:', currentName);
            if (newName && newName !== currentName) {
                const r = await fetchAPI('update_product_admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `product_id=${id}&name=${encodeURIComponent(newName)}`
                });
                if (r.success) {
                    showToast('Product name updated successfully', 'success');
                    loadProducts();
                    loadDashboardStats();
                } else {
                    showToast(r.message || 'Failed to update product name', 'error');
                }
            }
        };

        window.editProductPrice = async (id, currentPrice) => {
            const newPrice = prompt('Enter new product price (₹):', currentPrice);
            if (newPrice && !isNaN(newPrice) && parseFloat(newPrice) !== currentPrice) {
                const priceValue = parseFloat(newPrice);
                const r = await fetchAPI('update_product_admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `product_id=${id}&price=${priceValue}`
                });
                if (r.success) {
                    showToast(`Product price updated successfully!`, 'success');
                    await loadProducts();
                    await loadDashboardStats();
                } else {
                    showToast(r.message || 'Failed to update price', 'error');
                }
            } else if (newPrice && parseFloat(newPrice) === currentPrice) {
                alert('Price is the same. No changes made.');
            }
        };

        window.deleteProduct = async (id) => {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                const r = await fetchAPI('delete_product_admin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `product_id=${id}`
                });
                if (r.success) {
                    showToast('Product deleted successfully', 'success');
                    loadProducts();
                    loadDashboardStats();
                } else {
                    showToast(r.message || 'Failed to delete product', 'error');
                }
            }
        };

        window.updateProductStatus = async (id, status) => {
            const r = await fetchAPI('update_product_admin.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product_id=${id}&status=${status}`
            });
            if (r.success) {
                showToast('Product status updated', 'success');
                loadProducts();
            } else {
                showToast(r.message || 'Failed to update status', 'error');
            }
        };

        // ==================== USERS ====================
        async function loadUsers() {
            const res = await fetchAPI('get_all_users.php');
            if (res.success && res.users) {
                let html = '';
                res.users.forEach(u => {
                    html += `<tr>
                        <td>${u.user_id}</td>
                        <td>${escapeHtml(u.full_name)}</td>
                        <td>${u.email}</td>
                        <td>${u.role || 'customer'}</td>
                        <td><span class="status-badge ${getStatusClass(u.status || 'active')}">${u.status || 'active'}</span></td>
                        <td>
                            <select onchange="updateUserStatus(${u.user_id}, this.value)" class="status-select">
                                <option value="active" ${(u.status || 'active') === 'active' ? 'selected' : ''}>Active</option>
                                <option value="inactive" ${(u.status || 'active') === 'inactive' ? 'selected' : ''}>Inactive</option>
                                <option value="blocked" ${(u.status || 'active') === 'blocked' ? 'selected' : ''}>Blocked</option>
                            </select>
                        </td>
                    </tr>`;
                });
                document.getElementById('usersTable').innerHTML = html;
            } else {
                document.getElementById('usersTable').innerHTML = '<tr><td colspan="6" style="text-align:center;">No users found</td></tr>';
            }
        }

        window.updateUserStatus = async (id, status) => {
            const r = await fetchAPI('update_user_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `user_id=${id}&status=${status}`
            });
            if (r.success) {
                showToast('User status updated', 'success');
                loadUsers();
            } else {
                showToast(r.message || 'Failed to update user status', 'error');
            }
        };

        // ==================== VENDORS ====================
        // Updated loadVendors function
        async function loadVendors() {
            const res = await fetchAPI('get_vendors.php');
            console.log('Vendors API Response:', res);

            let vendors = [];
            if (res && Array.isArray(res)) {
                vendors = res;
            } else if (res && res.success && Array.isArray(res.data)) {
                vendors = res.data;
            } else if (res && res.vendors && Array.isArray(res.vendors)) {
                vendors = res.vendors;
            } else if (res && res.data && Array.isArray(res.data)) {
                vendors = res.data;
            }

            if (vendors.length > 0) {
                let html = '';
                vendors.forEach(v => {
                    html += `<tr>
                <td>${escapeHtml(v.store_name || v.vendor_name || 'N/A')}</td>
                <td>${renderStars(v.rating || 0)} ${v.rating || 0}</td>
                <td>${v.total_products || 0}</td>
                <td><span class="status-badge status-active">Active</span></td>
                <td><button class="btn-view" onclick="viewVendorDetails(${v.vendor_id})"><i class="fas fa-eye"></i> View Details</button></td>
            </tr>`;
                });
                document.getElementById('vendorsTable').innerHTML = html;
            } else {
                document.getElementById('vendorsTable').innerHTML = '<tr><td colspan="5" style="text-align:center">No vendors found</td></tr>';
            }
        }

        // New function to view vendor details
        window.viewVendorDetails = function (vendorId) {
            window.location.href = `AdminVendorDetails.php?vendor_id=${vendorId}`;
        };

        // ==================== REVIEWS ====================
        async function loadReviews() {
            const res = await fetchAPI('get_all_reviews.php');
            console.log('Reviews API Response:', res);

            // Handle different response formats
            let reviews = [];
            if (res && res.success && Array.isArray(res.reviews)) {
                reviews = res.reviews;
            } else if (res && Array.isArray(res)) {
                reviews = res;
            } else if (res && res.data && Array.isArray(res.data)) {
                reviews = res.data;
            }

            if (reviews.length > 0) {
                let html = '';
                reviews.forEach(r => {
                    html += `<tr>
                        <td>${escapeHtml(r.product_name)}</td>
                        <td>${escapeHtml(r.user_name)}</td>
                        <td>${renderStars(r.rating)} ${r.rating}/5</td>
                        <td>${escapeHtml(r.comment)}</td>
                        <td>${r.created_at ? r.created_at.split(' ')[0] : 'N/A'}</td>
                        <td><button class="btn-table btn-delete" onclick="deleteReview(${r.review_id})"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                });
                document.getElementById('reviewsTable').innerHTML = html;
            } else {
                document.getElementById('reviewsTable').innerHTML = '<tr><td colspan="6" style="text-align:center">No reviews found</td></tr>';
            }
        }

        window.deleteReview = async (id) => {
            if (confirm('Delete this review?')) {
                const r = await fetchAPI('delete_review.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `vendor_review_id=${id}`
                });
                if (r.success) {
                    showToast('Review deleted', 'success');
                    loadReviews();
                } else {
                    showToast(r.message || 'Failed to delete review', 'error');
                }
            }
        };

        // ==================== TICKETS ====================
        async function loadTickets() {
            const res = await fetchAPI('get_all_support_tickets.php');
            if (res.success && res.tickets) {
                let html = '';
                res.tickets.forEach(t => {
                    html += `<tr>
                        <td>#${t.ticket_id}</td>
                        <td>${escapeHtml(t.subject)}</td>
                        <td>${escapeHtml(t.user_name)}</td>
                        <td><span class="status-badge ${getStatusClass(t.status)}">${t.status}</span></td>
                        <td>${t.created_at.split(' ')[0]}</td>
                        <td><button class="btn-view" onclick="viewTicket(${t.ticket_id})">Reply</button></td>
                    </tr>`;
                });
                document.getElementById('ticketsTable').innerHTML = html;
            } else {
                document.getElementById('ticketsTable').innerHTML = '<tr><td colspan="6" style="text-align:center;">No tickets found</td></tr>';
            }
        }

        let currentTicketId = null;
        window.viewTicket = async (id) => {
            currentTicketId = id;
            const res = await fetchAPI(`get_support_ticket_details.php?ticket_id=${id}`);
            if (res.success) {
                document.getElementById('ticketDetailsContent').innerHTML = `<p><strong>Subject:</strong> ${escapeHtml(res.ticket.subject)}</p><p><strong>Category:</strong> ${res.ticket.category}</p><p><strong>Message:</strong> ${escapeHtml(res.ticket.message)}</p><p><strong>Status:</strong> ${res.ticket.status}</p><h4>Replies:</h4>${res.replies.map(r => `<p><strong>${escapeHtml(r.user_name)}:</strong> ${escapeHtml(r.message)} <small>(${r.created_at})</small></p>`).join('') || '<p>No replies yet</p>'}`;
                document.getElementById('ticketModal').style.display = 'flex';
                document.getElementById('replyMessage').value = '';
                document.getElementById('ticketStatusSelect').value = res.ticket.status;
            } else {
                alert('Ticket not found');
            }
        };

        document.getElementById('sendReplyBtn')?.addEventListener('click', async () => {
            const msg = document.getElementById('replyMessage').value;
            if (!msg) {
                alert('Please enter a reply');
                return;
            }
            const r = await fetchAPI('reply_support_ticket_admin.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `ticket_id=${currentTicketId}&message=${encodeURIComponent(msg)}`
            });
            if (r.success) {
                showToast('Reply sent', 'success');
                viewTicket(currentTicketId);
                document.getElementById('replyMessage').value = '';
            } else {
                showToast(r.message || 'Failed to send reply', 'error');
            }
        });

        document.getElementById('updateStatusBtn')?.addEventListener('click', async () => {
            const status = document.getElementById('ticketStatusSelect').value;
            const r = await fetchAPI('update_ticket_status_admin.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `ticket_id=${currentTicketId}&status=${status}`
            });
            if (r.success) {
                showToast('Status updated', 'success');
                viewTicket(currentTicketId);
                loadTickets();
            } else {
                showToast(r.message || 'Failed to update status', 'error');
            }
        });

        // ==================== SETTINGS ====================
        async function loadAdminProfile() {
            const res = await fetchAPI('get_admin_profile.php');
            if (res.success) {
                document.getElementById('adminNameInput').value = res.profile.full_name;
                document.getElementById('adminEmailInput').value = res.profile.email;
                document.getElementById('adminPhoneInput').value = res.profile.phone || '';
            }
        }

        document.getElementById('saveSettingsBtn')?.addEventListener('click', async () => {
            const name = document.getElementById('adminNameInput').value;
            const email = document.getElementById('adminEmailInput').value;
            const phone = document.getElementById('adminPhoneInput').value;
            if (!name || !email) {
                alert('Name and email are required');
                return;
            }
            const r = await fetchAPI('update_admin_settings.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `full_name=${encodeURIComponent(name)}&email=${email}&phone=${phone}`
            });
            if (r.success) {
                showToast('Profile updated successfully', 'success');
                loadAdminProfile();
                document.getElementById('adminNameDisplay').innerText = name;
            } else {
                showToast(r.message || 'Failed to update profile', 'error');
            }
        });

        document.getElementById('changePasswordBtn')?.addEventListener('click', async () => {
            const current = document.getElementById('currentPassword').value;
            const newp = document.getElementById('newPassword').value;
            const confirm = document.getElementById('confirmPassword').value;
            if (!current || !newp || !confirm) {
                alert('Please fill all password fields');
                return;
            }
            if (newp !== confirm) {
                alert('New passwords do not match');
                return;
            }
            const r = await fetchAPI('change_admin_password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `current_password=${current}&new_password=${newp}&confirm_password=${confirm}`
            });
            if (r.success) {
                showToast('Password changed successfully', 'success');
                document.getElementById('currentPassword').value = '';
                document.getElementById('newPassword').value = '';
                document.getElementById('confirmPassword').value = '';
            } else {
                showToast(r.message || 'Failed to change password', 'error');
            }
        });

        // ==================== SECTION NAVIGATION ====================
        const sections = {
            dashboard: 'dashboard-section',
            orders: 'orders-section',
            products: 'products-section',
            users: 'users-section',
            vendors: 'vendors-section',
            reviews: 'reviews-section',
            tickets: 'tickets-section',
            settings: 'settings-section'
        };

        function activateSection(sectionId) {
            Object.values(sections).forEach(s => document.getElementById(s).classList.remove('active'));
            document.getElementById(sections[sectionId]).classList.add('active');
            if (sectionId === 'orders') loadAllOrders();
            if (sectionId === 'products') loadProducts();
            if (sectionId === 'users') loadUsers();
            if (sectionId === 'vendors') loadVendors();
            if (sectionId === 'reviews') loadReviews();
            if (sectionId === 'tickets') loadTickets();
            if (sectionId === 'settings') loadAdminProfile();
            document.querySelectorAll('.sidebar-nav li').forEach(li => li.classList.remove('active'));
            const activeNav = document.querySelector(`.sidebar-nav li[data-section="${sectionId}"]`);
            if (activeNav) activeNav.classList.add('active');
        }

        document.querySelectorAll('.sidebar-nav li').forEach(li => {
            li.addEventListener('click', (e) => {
                e.preventDefault();
                const sec = li.getAttribute('data-section');
                if (sec && sections[sec]) activateSection(sec);
                if (sec === 'logout') { window.location.href = 'Logout.php'; }
                if (window.innerWidth <= 768) document.getElementById('sidebar').classList.remove('mobile-open');
            });
        });

        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) { logoutBtn.addEventListener('click', function (e) { e.preventDefault(); window.location.href = 'Logout.php'; }); }

        document.querySelectorAll('.close-modal').forEach(btn => { btn.onclick = function () { document.getElementById('orderModal').style.display = 'none'; document.getElementById('ticketModal').style.display = 'none'; }; });
        window.onclick = function (e) { if (e.target.classList.contains('modal')) { e.target.style.display = 'none'; } };
        document.getElementById('sidebarToggle').addEventListener('click', () => { document.getElementById('sidebar').classList.toggle('collapsed'); document.getElementById('mainContent').classList.toggle('expanded'); if (window.innerWidth <= 768) document.getElementById('sidebar').classList.toggle('mobile-open'); });

        // ==================== INITIALIZATION ====================
        (async function init() {
            await checkAuth();
            await loadDashboardStats();
            await loadRecentOrders();
            await loadAllOrders();
            await loadProducts();
            await loadUsers();
            await loadVendors();
            await loadReviews();
            await loadTickets();
            await loadAdminProfile();
        })();
    </script>
</body>

</html>