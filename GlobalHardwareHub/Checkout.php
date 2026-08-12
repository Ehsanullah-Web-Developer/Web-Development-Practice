<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Stripe JS v3 - Load with defer for better performance -->
    <script src="https://js.stripe.com/v3/" defer></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
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
            scroll-behavior: smooth;
        }

        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            --secondary: #667eea;
            --success: #10b981;
            --danger: #dc2626;
            --warning: #f59e0b;
            --card-bg: #ffffff;
            --card-bg-light: #f8fafc;
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Optimized Loading Animation */
        .loading-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--border-color);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.2s infinite;
            border-radius: 8px;
        }

        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .skeleton-text { height: 16px; margin: 8px 0; border-radius: 4px; }
        .skeleton-title { height: 24px; width: 60%; margin-bottom: 16px; border-radius: 6px; }
        .skeleton-card { padding: 16px; background: var(--card-bg); border-radius: 28px; margin-bottom: 16px; border: 1px solid var(--border-color); }
        .skeleton-item { height: 50px; margin-bottom: 8px; border-radius: 8px; }

        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-lg);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
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

        .logo img:hover { transform: scale(1.02); }

        .nav-links {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            list-style: none;
            align-items: center;
            margin: 0;
            margin-left: auto;
        }

        .nav-item { position: relative; list-style: none; }

        .nav-link {
            text-decoration: none;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.2s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 40px;
        }

        .nav-link i { color: var(--text-muted); }
        .nav-link:hover, .nav-link.active { background: #eff6ff; color: var(--primary); }
        .nav-link:hover i { color: var(--primary); }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            min-width: 230px;
            padding: 0.6rem 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-12px);
            transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s;
            z-index: 1050;
            border: 1px solid var(--border-color);
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
            color: var(--text-muted);
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .dropdown-menu a:hover {
            background: #f1f5f9;
            color: var(--primary);
            padding-left: 1.6rem;
        }

        .auth-btn {
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            padding: 0.45rem 1.2rem;
            border-radius: 60px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            color: var(--text-dark);
        }

        .auth-btn:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
            border-color: transparent;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            color: var(--text-dark);
            text-decoration: none;
            background: #f1f5f9;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            font-weight: 600;
            border: 1px solid var(--border-color);
        }

        .cart-icon i { font-size: 1.1rem; }
        .cart-icon:hover {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }
        .cart-icon:hover i { color: white; }

        .cart-count {
            background: var(--danger);
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
            color: var(--text-dark);
            transition: 0.2s;
        }
        .hamburger:hover { color: var(--primary); transform: scale(1.05); }

        .mobile-menu-panel {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 340px;
            height: 100%;
            background: var(--card-bg);
            z-index: 2000;
            box-shadow: 2px 0 30px rgba(0, 0, 0, 0.2);
            transition: left 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            overflow-y: auto;
            padding: 1.5rem;
        }
        .mobile-menu-panel.open { left: 0; }
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1999;
            display: none;
        }
        .mobile-overlay.show { display: block; }

        .footer {
            background: var(--card-bg);
            color: var(--text-muted);
            padding: 3rem 2rem 1.5rem;
            margin-top: 4rem;
            border-top: 1px solid var(--border-color);
            border-radius: 32px 32px 0 0;
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
            color: var(--text-dark);
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
            color: var(--text-muted);
            text-decoration: none;
            margin-bottom: 0.6rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .footer-col a:hover { color: var(--primary); transform: translateX(4px); }
        .social-icons { display: flex; gap: 1rem; margin-top: 1rem; }
        .social-icons i {
            font-size: 1.4rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }
        .social-icons i:hover { color: var(--primary); transform: translateY(-3px); }
        .copyright {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .step {
            flex: 1;
            text-align: center;
            padding: 0.8rem;
            background: var(--card-bg);
            border-radius: 60px;
            color: var(--text-muted);
            font-weight: 600;
            border: 1px solid var(--border-color);
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .step.active {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            box-shadow: var(--shadow-md);
        }
        .step.completed {
            background: var(--success);
            color: white;
            border-color: transparent;
        }

        .checkout-layout {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        .left-section { flex: 1.5; min-width: 280px; }
        .right-section { flex: 1; min-width: 280px; }

        .card {
            background: var(--card-bg);
            border-radius: 28px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            transition: all 0.2s;
        }
        .card:hover {
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }
        .card h2 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid var(--border-color);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .addresses-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1rem;
            max-height: 350px;
            overflow-y: auto;
        }

        .address-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: var(--card-bg-light);
            border-radius: 20px;
            border: 2px solid transparent;
            transition: all 0.2s;
            cursor: pointer;
        }
        .address-card:hover { background: #e2e8f0; transform: translateX(4px); }
        .address-card.selected {
            border-color: var(--primary);
            background: var(--card-bg-light);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }
        .address-card .address-radio { margin-top: 2px; accent-color: var(--primary); }
        .address-details { flex: 1; font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; }
        .address-name {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
            font-size: 0.9rem;
        }
        .address-default-badge {
            display: inline-block;
            background: var(--success);
            color: white;
            font-size: 0.65rem;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 8px;
        }

        .no-address-message {
            text-align: center;
            padding: 2rem;
            color: var(--text-muted);
        }
        .no-address-message i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }
        .no-address-message a { color: var(--primary); text-decoration: none; font-weight: 600; }

        .form-group { margin-bottom: 1rem; }
        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
            font-family: inherit;
            background: var(--card-bg-light);
            color: var(--text-dark);
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        .order-items { max-height: 280px; overflow-y: auto; }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 0.7rem 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .order-item:last-child { border-bottom: none; }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem 0;
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .grand-total {
            font-weight: 800;
            font-size: 1.1rem;
            border-top: 2px solid var(--border-color);
            margin-top: 0.5rem;
            padding-top: 0.8rem;
            color: var(--text-dark);
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.9rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            width: 100%;
            transition: all 0.2s;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
            filter: brightness(1.05);
        }
        .btn-primary:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
            color: var(--text-muted);
        }

        .payment-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 10001;
        }
        .payment-modal-content {
            background: var(--card-bg);
            max-width: 480px;
            width: 90%;
            padding: 2rem;
            border-radius: 32px;
            box-shadow: var(--shadow-xl);
            animation: modalFadeIn 0.3s ease;
            border: 1px solid var(--border-color);
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .payment-modal-content h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-dark); }
        .modal-amount {
            font-size: 2.2rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin: 1rem 0;
        }
        .stripe-card-container {
            margin: 1.5rem 0;
            padding: 0.8rem;
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            transition: all 0.2s;
            background: var(--card-bg-light);
        }
        .stripe-card-container:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .modal-buttons { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .modal-buttons button {
            flex: 1;
            padding: 0.8rem;
            border-radius: 60px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .btn-modal-cancel { background: #f1f5f9; color: var(--text-muted); }
        .btn-modal-cancel:hover { background: #e2e8f0; transform: translateY(-2px); }
        .btn-modal-confirm { background: var(--primary-gradient); color: white; }
        .btn-modal-confirm:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4); }
        .btn-modal-confirm:disabled { opacity: 0.6; cursor: not-allowed; }
        .payment-error { color: var(--danger); font-size: 0.8rem; margin-top: 0.5rem; text-align: center; }

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
            font-weight: 600;
        }
        .back-to-top.show { opacity: 1; }
        .back-to-top:hover { transform: translateY(-3px); filter: brightness(1.05); }

        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateX(-50%) translateY(20px); }
            15% { opacity: 1; transform: translateX(-50%) translateY(0); }
            85% { opacity: 1; }
            100% { opacity: 0; transform: translateX(-50%) translateY(-20px); }
        }

        @media (max-width: 800px) {
            .nav-links { display: none; }
            .hamburger { display: block; }
            .nav-container { padding: 0.8rem 1.2rem; }
        }
        @media (max-width: 768px) {
            .step-indicator { flex-direction: column; }
            .step { padding: 0.5rem; }
            .row-2 { grid-template-columns: 1fr; gap: 0.5rem; }
            .card { padding: 1rem; }
        }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.2); }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.4); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.6); }
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
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
                <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span id="cartCountDisplay" class="cart-count">0</span></li>
                <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i class="fas fa-key"></i> Login</button></li>
            </ul>
            <button class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <button class="close-mobile" id="closeMobileBtn" style="background:none; border:none; font-size:1.8rem; float:right;"><i class="fas fa-times"></i></button>
        <div id="mobileMenuContent"></div>
    </div>

    <div class="checkout-container">
        <div class="step-indicator">
            <div class="step completed"><i class="fas fa-shopping-cart"></i> Cart</div>
            <div class="step active"><i class="fas fa-truck"></i> Shipping & Payment</div>
            <div class="step"><i class="fas fa-check-circle"></i> Confirmation</div>
        </div>

        <div id="loadingState">
            <div class="skeleton-card">
                <div class="skeleton skeleton-title"></div>
                <div class="skeleton skeleton-text" style="width: 80%;"></div>
                <div class="skeleton skeleton-text" style="width: 60%;"></div>
            </div>
            <div class="skeleton-card">
                <div class="skeleton skeleton-title" style="width: 40%;"></div>
                <div class="skeleton skeleton-text"></div>
                <div class="skeleton skeleton-text"></div>
            </div>
            <div class="skeleton-card">
                <div class="skeleton skeleton-title" style="width: 50%;"></div>
                <div class="skeleton skeleton-item"></div>
                <div class="skeleton skeleton-item"></div>
                <div class="skeleton skeleton-item"></div>
            </div>
        </div>

        <div id="checkoutContent" style="display: none;">
            <div class="checkout-layout">
                <div class="left-section">
                    <div class="card">
                        <h2><i class="fas fa-location-dot" style="color: var(--primary);"></i> Select Shipping Address</h2>
                        <div id="addressesListContainer">
                            <div class="addresses-list" id="addressesList"></div>
                        </div>
                        <div style="margin-top: 1rem; text-align: center;">
                            <a href="AddressBook.php" style="color: var(--primary); text-decoration: none; font-size: 0.85rem;">
                                <i class="fas fa-plus-circle"></i> Manage Addresses in Address Book
                            </a>
                        </div>
                    </div>

                    <div class="card">
                        <h2><i class="fas fa-pencil-alt" style="color: var(--primary);"></i> Order Notes (Optional)</h2>
                        <textarea id="orderNotes" rows="3" placeholder="Special instructions for delivery..." style="width:100%; padding:0.8rem; border:1.5px solid var(--border-color); border-radius:16px; font-family:inherit; resize:vertical; background:var(--card-bg-light); color:var(--text-dark);"></textarea>
                    </div>
                </div>

                <div class="right-section">
                    <div class="card">
                        <h2><i class="fas fa-receipt" style="color: var(--primary);"></i> Order Summary</h2>
                        <div id="orderItemsList" class="order-items"></div>
                        <div id="orderSummary"></div>
                        <button id="placeOrderBtn" class="btn-primary"><i class="fab fa-stripe"></i> Proceed to Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="paymentModal" class="payment-modal">
        <div class="payment-modal-content">
            <i class="fab fa-stripe" style="font-size: 3rem; background: linear-gradient(135deg, #635bff, #00d4ff); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: 0.5rem;"></i>
            <h3>Secure Payment</h3>
            <p style="color: var(--text-muted);">Enter your card details to complete payment</p>
            <div class="modal-amount" id="modalTotalAmount">PKR 0.00</div>
            <div id="cardElementContainer" class="stripe-card-container"></div>
            <div id="paymentError" class="payment-error"></div>
            <div class="modal-buttons">
                <button id="modalCancelBtn" class="btn-modal-cancel"><i class="fas fa-times"></i> Cancel</button>
                <button id="modalConfirmBtn" class="btn-modal-confirm"><i class="fas fa-lock"></i> Pay Now</button>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Quick Links</h4>
                <a href="AboutUs.php">About Us</a>
                <a href="ContactUs.php">Contact Support</a>
                <a href="OrderTracking.php">Track Order</a>
                <a href="ReturnPolicy.php">Return Policy</a>
            </div>
            <div class="footer-col">
                <h4>Resources</h4>
                <a href="AddressBook.php">Address Book</a>
                <a href="Blog.php">Tech Blog</a>
                <a href="FAQ.php">FAQ</a>
                <a href="TermsofService.php">Terms of Service</a>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p><i class="fas fa-phone-alt"></i> 03267322096</p>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
                <div class="social-icons"><i class="fab fa-facebook-f"></i> <i class="fab fa-twitter"></i> <i class="fab fa-instagram"></i> <i class="fab fa-youtube"></i></div>
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
        // Optimized Checkout Script - Fast Loading
        let stripe = null;
        let cardElement = null;
        let currentClientSecret = null;
        let isProcessingPayment = false;
        let isUserLoggedIn = false;
        let currentUserId = null;
        let cartSummary = null;
        let userAddresses = [];
        let selectedAddress = null;
        let currentSubtotal = 0;
        let isProcessing = false;
        let pendingOrderData = null;
        
        const stripePublishableKey = 'pk_test_51TZuSUIV7gn69ZmehAdUCq9OYt9WGjGXHzl4bpum03kwReULIrCzirUJQiM6DfkRZo32IGH98Q9D37sgPAbGrHUF00ZXRakUyz';

        function showAlert(message, isError = true) {
            const alertDiv = document.createElement('div');
            alertDiv.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            alertDiv.style.cssText = `
                position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
                background: ${isError ? '#dc2626' : '#10b981'}; color: white;
                padding: 12px 24px; border-radius: 60px; z-index: 10000;
                font-size: 14px; animation: fadeInOut 3s ease forwards; font-weight:500;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            `;
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Optimized session check with timeout
        async function checkUserSession() {
            try {
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 5000);
                const response = await fetch('check_session.php', { signal: controller.signal });
                clearTimeout(timeoutId);
                const data = await response.json();
                if (data && data.user_id) {
                    isUserLoggedIn = true;
                    currentUserId = data.user_id;
                } else {
                    isUserLoggedIn = false;
                    currentUserId = null;
                }
                return isUserLoggedIn;
            } catch (error) {
                console.error('Session check error:', error);
                isUserLoggedIn = false;
                return false;
            }
        }

        // Optimized cart count load
        async function loadCartCountFromAPI() {
            const cartCountSpan = document.getElementById("cartCountDisplay");
            if (!cartCountSpan) return;
            if (!isUserLoggedIn) {
                cartCountSpan.innerText = "0";
                return;
            }
            try {
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 5000);
                const response = await fetch('get_cart_count.php', { signal: controller.signal });
                clearTimeout(timeoutId);
                const data = await response.json();
                cartCountSpan.innerText = data.success ? data.cart_count : "0";
            } catch (error) {
                cartCountSpan.innerText = "0";
            }
        }

        // Parallel data loading for better performance
        async function loadCheckoutData() {
            const [cartResponse, addressesResponse] = await Promise.all([
                fetch('get_cart_summary.php').catch(() => ({ json: () => ({ success: false, data: { items: [], subtotal: 0 } }) })),
                fetch('get_user_addresses.php').catch(() => ({ json: () => ({ success: false, data: [] }) }))
            ]);
            
            const cartResult = await cartResponse.json();
            const addressesResult = await addressesResponse.json();
            
            cartSummary = cartResult.success && cartResult.data ? cartResult.data : { items: [], subtotal: 0 };
            currentSubtotal = cartSummary.subtotal || 0;
            userAddresses = addressesResult.success && addressesResult.data ? addressesResult.data : [];
            
            if (userAddresses.length > 0) {
                const defaultAddress = userAddresses.find(addr => addr.is_default == 1);
                selectedAddress = defaultAddress || userAddresses[0];
            }
        }

        function renderAddresses() {
            const container = document.getElementById("addressesList");
            if (!container) return;
            if (!userAddresses || userAddresses.length === 0) {
                container.innerHTML = `
                    <div class="no-address-message">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>No saved addresses found.</p>
                        <p><a href="AddressBook.php">Add an address</a> to continue with checkout.</p>
                    </div>
                `;
                return;
            }
            container.innerHTML = userAddresses.map(addr => `
                <div class="address-card ${selectedAddress && selectedAddress.address_id === addr.address_id ? 'selected' : ''}" data-address-id="${addr.address_id}">
                    <input type="radio" name="selectedAddress" value="${addr.address_id}" class="address-radio" ${selectedAddress && selectedAddress.address_id === addr.address_id ? 'checked' : ''}>
                    <div class="address-details">
                        <div class="address-name">
                            ${escapeHtml(addr.full_name || '')}
                            ${addr.is_default == 1 ? '<span class="address-default-badge"><i class="fas fa-check-circle"></i> Default</span>' : ''}
                        </div>
                        <div><i class="fas fa-map-marker-alt"></i> ${escapeHtml(addr.address_line1 || '')}, ${escapeHtml(addr.city || '')}, ${escapeHtml(addr.postal_code || '')}</div>
                        <div><i class="fas fa-phone"></i> ${escapeHtml(addr.phone || '')}</div>
                        <div><i class="fas fa-globe"></i> ${escapeHtml(addr.country || '')}</div>
                    </div>
                </div>
            `).join('');
            
            document.querySelectorAll('.address-card').forEach(card => {
                card.addEventListener('click', (e) => {
                    const addressId = parseInt(card.dataset.addressId);
                    selectedAddress = userAddresses.find(addr => addr.address_id === addressId);
                    document.querySelectorAll('.address-card').forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    const radio = card.querySelector('.address-radio');
                    if (radio) radio.checked = true;
                });
            });
        }

        function renderOrderItems() {
            const container = document.getElementById("orderItemsList");
            if (!cartSummary || !cartSummary.items || cartSummary.items.length === 0) {
                container.innerHTML = '<div style="text-align:center; padding:1rem; color:var(--text-muted);"><i class="fas fa-shopping-cart"></i> Your cart is empty</div>';
                return;
            }
            container.innerHTML = cartSummary.items.map(item => `
                <div class="order-item">
                    <span><i class="fas fa-box"></i> ${escapeHtml(item.name)} x${item.quantity}</span>
                    <span>PKR ${parseFloat(item.subtotal || (item.price * item.quantity)).toFixed(2)}</span>
                </div>
            `).join('');
        }

        function updateOrderSummaryDisplay() {
            const subtotal = currentSubtotal;
            const tax = subtotal * 0.09;
            let grandTotal = subtotal + tax;
            if (grandTotal < 0) grandTotal = 0;
            document.getElementById("orderSummary").innerHTML = `
                <div class="summary-row"><span>Subtotal</span><span>PKR ${subtotal.toFixed(2)}</span></div>
                <div class="summary-row"><span>Tax (9%)</span><span>PKR ${tax.toFixed(2)}</span></div>
                <div class="summary-row grand-total"><span>Grand Total</span><span>PKR ${grandTotal.toFixed(2)}</span></div>
            `;
            return grandTotal;
        }

        function initializeStripe() {
            if (stripePublishableKey && !stripe) {
                stripe = Stripe(stripePublishableKey);
            }
        }

        function createCardElement() {
            if (!stripe) return null;
            if (cardElement) return cardElement;
            const elements = stripe.elements();
            const style = {
                base: {
                    fontSize: '16px',
                    fontFamily: '"Inter", system-ui, -apple-system, sans-serif',
                    color: '#1e293b',
                    '::placeholder': { color: '#94a3b8' }
                },
                invalid: { color: '#dc2626', iconColor: '#dc2626' }
            };
            cardElement = elements.create('card', { style: style });
            const container = document.getElementById('cardElementContainer');
            if (container) {
                cardElement.mount('#cardElementContainer');
                cardElement.on('change', (event) => {
                    const errorDiv = document.getElementById('paymentError');
                    if (errorDiv) errorDiv.textContent = event.error ? event.error.message : '';
                });
            }
            return cardElement;
        }

        async function createPaymentIntent() {
            try {
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000);
                const response = await fetch('create_payment_init.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    signal: controller.signal
                });
                clearTimeout(timeoutId);
                const data = await response.json();
                if (data.success) {
                    currentClientSecret = data.clientSecret;
                    return { success: true, clientSecret: data.clientSecret, amount: data.amount };
                } else {
                    showAlert(data.message || 'Failed to initialize payment', true);
                    return { success: false, error: data.message };
                }
            } catch (error) {
                console.error('Error creating payment intent:', error);
                showAlert('Network error. Please try again.', true);
                return { success: false, error: error.message };
            }
        }

        async function confirmStripePayment(clientSecret, customerName) {
            if (clientSecret && clientSecret.startsWith('test_offline_')) {
                showAlert("Payment successful! (Test Mode)", false);
                return true;
            }
            if (!stripe || !cardElement) {
                showAlert('Payment system not initialized', true);
                return false;
            }
            try {
                const result = await stripe.confirmCardPayment(clientSecret, {
                    payment_method: { card: cardElement, billing_details: { name: customerName || 'Customer' } }
                });
                if (result.error) {
                    const errorDiv = document.getElementById('paymentError');
                    if (errorDiv) errorDiv.textContent = result.error.message;
                    showAlert(result.error.message, true);
                    return false;
                }
                return result.paymentIntent.status === 'succeeded';
            } catch (error) {
                console.error('Payment confirmation error:', error);
                showAlert('Payment failed. Please try again.', true);
                return false;
            }
        }

        async function openStripePaymentModal() {
            if (isProcessingPayment) return;
            if (!selectedAddress) {
                showAlert("Please select a shipping address", true);
                return;
            }
            if (!cartSummary || !cartSummary.items || cartSummary.items.length === 0) {
                showAlert("Your cart is empty", true);
                return;
            }
            const placeOrderBtn = document.getElementById("placeOrderBtn");
            const originalText = placeOrderBtn.innerHTML;
            placeOrderBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Initializing...';
            placeOrderBtn.disabled = true;
            const paymentIntentResult = await createPaymentIntent();
            placeOrderBtn.innerHTML = originalText;
            placeOrderBtn.disabled = false;
            if (!paymentIntentResult.success) return;
            createCardElement();
            const grandTotal = updateOrderSummaryDisplay();
            document.getElementById("modalTotalAmount").innerText = `PKR ${grandTotal.toFixed(2)}`;
            document.getElementById("paymentModal").style.display = "flex";
            document.getElementById("paymentError").textContent = "";
            pendingOrderData = {
                address_id: selectedAddress.address_id,
                full_name: selectedAddress.full_name,
                phone: selectedAddress.phone,
                address_line: selectedAddress.address_line1,
                city: selectedAddress.city,
                postal_code: selectedAddress.postal_code,
                country: selectedAddress.country,
                payment_method: "stripe",
                order_notes: document.getElementById("orderNotes").value || null,
                stripe_payment_intent_id: paymentIntentResult.clientSecret ? paymentIntentResult.clientSecret.split('_secret')[0] : null
            };
        }

        async function processStripePayment() {
            if (isProcessingPayment) return;
            if (!pendingOrderData) {
                showAlert("Order data missing. Please try again.", true);
                closePaymentModal();
                return;
            }
            const confirmBtn = document.getElementById("modalConfirmBtn");
            const originalText = confirmBtn.innerHTML;
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Processing...';
            confirmBtn.disabled = true;
            isProcessingPayment = true;
            try {
                const paymentSuccess = await confirmStripePayment(currentClientSecret, pendingOrderData.full_name);
                if (paymentSuccess) {
                    showAlert("Payment successful! Placing your order...", false);
                    closePaymentModal();
                    await executeOrderPlacement(pendingOrderData);
                } else {
                    confirmBtn.innerHTML = originalText;
                    confirmBtn.disabled = false;
                    isProcessingPayment = false;
                }
            } catch (error) {
                console.error('Payment processing error:', error);
                showAlert("Payment failed. Please try again.", true);
                confirmBtn.innerHTML = originalText;
                confirmBtn.disabled = false;
                isProcessingPayment = false;
            }
        }

        async function executeOrderPlacement(orderData) {
            if (isProcessing) return;
            isProcessing = true;
            try {
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 15000);
                const response = await fetch('place_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(orderData),
                    signal: controller.signal
                });
                clearTimeout(timeoutId);
                const result = await response.json();
                if (result.success) {
                    showAlert("Order placed successfully!", false);
                    window.location.href = `OrderConfirmation.php?order_id=${result.order_id}`;
                } else {
                    showAlert(result.message || "Failed to place order", true);
                    isProcessing = false;
                }
            } catch (error) {
                console.error('Order placement error:', error);
                showAlert("Failed to place order. Please contact support.", true);
                isProcessing = false;
            }
        }

        function closePaymentModal() {
            document.getElementById("paymentModal").style.display = "none";
            const errorDiv = document.getElementById("paymentError");
            if (errorDiv) errorDiv.textContent = "";
        }

        // UI Functions
        async function setAuthUI() {
            await checkUserSession();
            const authBtn = document.getElementById("authButton");
            if (!authBtn) return;
            authBtn.innerHTML = isUserLoggedIn ? '<i class="fas fa-sign-out-alt"></i> Logout' : '<i class="fas fa-sign-in-alt"></i> Login';
            renderMobileMenu();
        }

        function handleAuthClick() {
            if (isUserLoggedIn) window.location.href = "Logout.php";
            else window.location.href = "Login.php";
        }

        function renderMobileMenu() {
            const container = document.getElementById("mobileMenuContent");
            if (!container) return;
            const logged = isUserLoggedIn;
            const menuItems = [
                { title: "Home", link: "FYPHome.php" },
                { title: "Products", submenu: ["Categories", "Compare Products", "Product Details", "All Products"], links: ["Categories.php", "CompareProducts.php", "ProductDetails.php", "Products1.php"] },
                { title: "Vendors", submenu: ["Vendors", "Vendors List", "Vendors Store"], links: ["Vendors.php", "VendorsList.php", "VendorsStore.php"] },
                { title: "Account", submenu: ["My Account", "Profile", "Orders", "Wishlist", "Address Book", "Cart", "Checkout"], links: ["MyAccount.php", "Profile.php", "UserOrders.php", "Wishlist.php", "AddressBook.php", "Cart.php", "Checkout.php"] },
                { title: "Support", submenu: ["Contact", "FAQ", "Shipping Info", "Return Policy", "About Us"], links: ["ContactUs.php", "FAQ.php", "ShippingInfo.php", "ReturnPolicy.php", "AboutUs.php"] },
                { title: "Blog", link: "Blog.php" }
            ];
            let html = `<div style="margin-top:1rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color:white; border:none;">${logged ? "<i class='fas fa-sign-out-alt'></i> Logout" : "<i class='fas fa-sign-in-alt'></i> Login"}</button></div><hr style="margin:1rem 0; border-color:#e2e8f0;">`;
            menuItems.forEach(item => {
                if (item.submenu) {
                    html += `<div class="mobile-nav-item"><div class="mobile-nav-header" data-toggle="${item.title}" style="display:flex; justify-content:space-between; padding:0.8rem 0; color:var(--text-dark); cursor:pointer;"><span>${item.title}</span> <i class="fas fa-chevron-down"></i></div><div class="mobile-submenu" id="submenu-${item.title}" style="padding-left:1rem; display:none;">`;
                    item.submenu.forEach((sub, idx) => { html += `<a href="${item.links[idx]}" style="display:block; padding:0.6rem 0; color:var(--text-muted); text-decoration:none;">${sub}</a>`; });
                    html += `</div></div>`;
                } else { html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0; color:var(--text-dark); text-decoration:none;">${item.title}</a></div>`; }
            });
            container.innerHTML = html;
            document.querySelectorAll(".mobile-nav-header").forEach(header => {
                header.addEventListener("click", () => {
                    const key = header.getAttribute("data-toggle");
                    const sub = document.getElementById(`submenu-${key}`);
                    if (sub) sub.style.display = sub.style.display === "none" ? "block" : "none";
                });
            });
            const mobileAuth = document.getElementById("mobileAuthBtn");
            if (mobileAuth) mobileAuth.onclick = () => { handleAuthClick(); };
        }

        // Main initialization - optimized for speed
        async function init() {
            const loadingDiv = document.getElementById("loadingState");
            const contentDiv = document.getElementById("checkoutContent");
            loadingDiv.style.display = "block";
            contentDiv.style.display = "none";
            
            await checkUserSession();
            await setAuthUI();
            renderMobileMenu();
            await loadCartCountFromAPI();
            
            if (!isUserLoggedIn) {
                loadingDiv.innerHTML = `
                    <div style="max-width: 500px; margin: 0 auto; text-align: center; background:var(--card-bg); padding:2rem; border-radius:28px; box-shadow:var(--shadow-lg);">
                        <div style="font-size: 3rem;"><i class="fas fa-lock"></i></div>
                        <h3 style="margin-top:1rem; color:var(--text-dark);">Please Login to Continue</h3>
                        <p style="color:var(--text-muted); margin-top:0.5rem;">You need to be logged in to complete checkout.</p>
                        <a href="Login.php"><button class="btn-primary" style="width: auto; padding: 0.7rem 2rem; margin-top: 1rem;"><i class="fas fa-sign-in-alt"></i> Login Now</button></a>
                    </div>
                `;
                return;
            }
            
            try {
                await loadCheckoutData();
                renderAddresses();
                renderOrderItems();
                updateOrderSummaryDisplay();
                loadingDiv.style.display = "none";
                contentDiv.style.display = "block";
                initializeStripe();
            } catch (error) {
                console.error('Error loading checkout data:', error);
                loadingDiv.innerHTML = `
                    <div style="max-width: 500px; margin: 0 auto; text-align: center; background:var(--card-bg); padding:2rem; border-radius:28px; box-shadow:var(--shadow-lg);">
                        <div style="font-size: 3rem;"><i class="fas fa-exclamation-triangle"></i></div>
                        <h3 style="margin-top:1rem; color:var(--text-dark);">Failed to Load Checkout Data</h3>
                        <p style="color:var(--text-muted);">Please refresh the page and try again.</p>
                        <button onclick="location.reload()" class="btn-primary" style="width: auto; padding: 0.7rem 2rem; margin-top: 1rem;"><i class="fas fa-sync-alt"></i> Refresh Page</button>
                    </div>
                `;
            }
        }
        
        // Event Listeners
        document.getElementById("placeOrderBtn")?.addEventListener("click", openStripePaymentModal);
        document.getElementById("modalCancelBtn")?.addEventListener("click", closePaymentModal);
        document.getElementById("modalConfirmBtn")?.addEventListener("click", processStripePayment);
        window.addEventListener("click", (e) => { const modal = document.getElementById("paymentModal"); if (e.target === modal) closePaymentModal(); });
        document.querySelector('.cart-icon')?.addEventListener("click", () => { window.location.href = "Cart.php"; });
        document.getElementById("authButton")?.addEventListener("click", handleAuthClick);
        
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => { if (window.scrollY > 300) backBtn.classList.add("show"); else backBtn.classList.remove("show"); });
        backBtn?.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
        
        const hamburgerBtn = document.getElementById("hamburgerBtn");
        const mobileMenuPanel = document.getElementById("mobileMenuPanel");
        const mobileOverlay = document.getElementById("mobileOverlay");
        function openMobile() { mobileMenuPanel?.classList.add("open"); mobileOverlay?.classList.add("show"); }
        function closeMobile() { mobileMenuPanel?.classList.remove("open"); mobileOverlay?.classList.remove("show"); }
        hamburgerBtn?.addEventListener("click", openMobile);
        document.getElementById("closeMobileBtn")?.addEventListener("click", closeMobile);
        mobileOverlay?.addEventListener("click", closeMobile);
        
        // Start initialization
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    </script>
</body>

</html>