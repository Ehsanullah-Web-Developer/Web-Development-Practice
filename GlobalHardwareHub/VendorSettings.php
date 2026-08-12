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
    <title>Global Hardware Hub | Vendor Settings</title>
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

        /* Settings Container */
        .settings-container {
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
        .settings-card {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.8rem;
            margin-bottom: 1.8rem;
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .settings-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .settings-card h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1.2rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.85rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* Image Upload */
        .image-upload {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .image-preview {
            width: 100px;
            height: 100px;
            border-radius: 20px;
            object-fit: cover;
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            transition: transform 0.2s;
        }

        .image-preview:hover {
            transform: scale(1.02);
        }

        .cover-preview {
            width: 200px;
            height: 100px;
        }

        .upload-btn {
            background: var(--gray-100);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .upload-btn:hover {
            background: var(--gray-200);
            transform: translateY(-2px);
        }

        /* Toggle Switch */
        .toggle-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.6rem 0;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 26px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray-200);
            transition: 0.3s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background: var(--primary-gradient);
        }

        input:checked+.toggle-slider:before {
            transform: translateX(26px);
        }

        /* Checkbox Group */
        .checkbox-group {
            display: flex;
            gap: 1.2rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
            color: var(--gray-700);
        }

        /* Buttons - Matching Logout.php */
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
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

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-save {
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
                transform: translateX(-50%) translateY(0);
            }
            100% {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
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
            .settings-container {
                padding: 1rem;
            }

            .row-2 {
                grid-template-columns: 1fr;
            }

            .settings-card {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .cover-preview {
                width: 100%;
                height: auto;
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
                <li class="nav-item"><a href="VendorDashboard.php" class="nav-link active">Vendor Dashboard</a></li>
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

    <div class="settings-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="VendorDashboard.php">Vendor
                Dashboard</a> / <span>Settings</span>
        </div>
        <h1 class="page-title"><i class="fas fa-cog"></i> Vendor Settings</h1>

        <!-- Store Information -->
        <div class="settings-card">
            <h2><i class="fas fa-store"></i> Store Information</h2>
            <div class="form-group">
                <label><i class="fas fa-tag"></i> Store Name</label>
                <input type="text" id="storeName" placeholder="Enter your store name">
            </div>
            <div class="form-group">
                <label><i class="fas fa-image"></i> Store Logo</label>
                <div class="image-upload">
                    <img id="logoPreview" class="image-preview"
                        src="https://placehold.co/100x100/2563eb/white?text=Logo">
                    <input type="file" id="logoUpload" accept="image/*" style="display:none">
                    <button type="button" class="upload-btn" onclick="document.getElementById('logoUpload').click()"><i
                            class="fas fa-upload"></i> Upload Logo</button>
                </div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-cover-image"></i> Cover Image</label>
                <div class="image-upload">
                    <img id="coverPreview" class="image-preview cover-preview"
                        src="https://placehold.co/200x100/2563eb/white?text=Cover">
                    <input type="file" id="coverUpload" accept="image/*" style="display:none">
                    <button type="button" class="upload-btn" onclick="document.getElementById('coverUpload').click()"><i
                            class="fas fa-upload"></i> Upload Cover</button>
                </div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-align-left"></i> Store Description</label>
                <textarea id="storeDescription" rows="4" placeholder="Describe your store..."></textarea>
            </div>
            <button class="btn-primary btn-save" data-section="store"><i class="fas fa-save"></i> Save Store
                Info</button>
        </div>

        <!-- Store Policies -->
        <div class="settings-card">
            <h2><i class="fas fa-file-alt"></i> Store Policies</h2>
            <div class="form-group">
                <label><i class="fas fa-truck"></i> Shipping Policy</label>
                <textarea id="shippingPolicy" rows="3" placeholder="Enter your shipping policy..."></textarea>
            </div>
            <div class="form-group">
                <label><i class="fas fa-undo-alt"></i> Return Policy</label>
                <textarea id="returnPolicy" rows="3" placeholder="Enter your return policy..."></textarea>
            </div>
            <div class="form-group">
                <label><i class="fas fa-shield-alt"></i> Warranty Policy</label>
                <textarea id="warrantyPolicy" rows="3" placeholder="Enter your warranty policy..."></textarea>
            </div>
            <button class="btn-primary btn-save" data-section="policies"><i class="fas fa-save"></i> Save
                Policies</button>
        </div>

        <!-- Payment Settings -->
        <div class="settings-card">
            <h2><i class="fas fa-credit-card"></i> Payment Settings</h2>
            <div class="form-group">
                <label><i class="fas fa-money-bill-wave"></i> Payment Method</label>
                <select id="paymentMethod">
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="easypaisa">EasyPaisa</option>
                    <option value="jazzcash">JazzCash</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>
            <div class="row-2">
                <div class="form-group">
                    <label><i class="fas fa-university"></i> Bank Name</label>
                    <input type="text" id="bankName" placeholder="Enter bank name">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Account Title</label>
                    <input type="text" id="accountTitle" placeholder="Account holder name">
                </div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-hashtag"></i> Account Number</label>
                <input type="text" id="accountNumber" placeholder="Enter account number">
            </div>
            <button class="btn-primary btn-save" data-section="payment"><i class="fas fa-save"></i> Save Payment
                Settings</button>
        </div>

        <!-- Business Information -->
        <div class="settings-card">
            <h2><i class="fas fa-building"></i> Business Information</h2>
            <div class="form-group">
                <label><i class="fas fa-id-card"></i> Tax ID / GST Number</label>
                <input type="text" id="taxId" placeholder="Enter tax ID">
            </div>
            <div class="form-group">
                <label><i class="fas fa-map-marker-alt"></i> Business Address</label>
                <input type="text" id="businessAddress" placeholder="Street address">
            </div>
            <div class="row-2">
                <div class="form-group">
                    <label><i class="fas fa-city"></i> City</label>
                    <input type="text" id="city" placeholder="City">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-globe"></i> Country</label>
                    <input type="text" id="country" placeholder="Country">
                </div>
            </div>
            <button class="btn-primary btn-save" data-section="business"><i class="fas fa-save"></i> Save Business
                Info</button>
        </div>

        <!-- Shipping Settings -->
        <div class="settings-card">
            <h2><i class="fas fa-truck-fast"></i> Shipping Settings</h2>
            <div class="form-group">
                <label><i class="fas fa-shipping-fast"></i> Default Shipping Method</label>
                <select id="defaultShippingMethod">
                    <option value="standard">Standard Shipping</option>
                    <option value="express">Express Shipping</option>
                    <option value="overnight">Overnight Shipping</option>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fas fa-check-square"></i> Available Shipping Methods</label>
                <div class="checkbox-group">
                    <label class="checkbox-label"><input type="checkbox" value="standard"> <i class="fas fa-truck"></i>
                        Standard Shipping</label>
                    <label class="checkbox-label"><input type="checkbox" value="express"> <i class="fas fa-rocket"></i>
                        Express Shipping</label>
                    <label class="checkbox-label"><input type="checkbox" value="overnight"> <i class="fas fa-bolt"></i>
                        Overnight Shipping</label>
                </div>
            </div>
            <div class="form-group">
                <label><i class="fas fa-clock"></i> Handling Time (days)</label>
                <input type="number" id="handlingTime" min="1" max="10" value="2">
            </div>
            <button class="btn-primary btn-save" data-section="shipping"><i class="fas fa-save"></i> Save Shipping
                Settings</button>
        </div>

        <!-- Notification Preferences -->
        <div class="settings-card">
            <h2><i class="fas fa-bell"></i> Notification Preferences</h2>
            <div class="toggle-group">
                <span><i class="fas fa-envelope"></i> Email Notifications</span>
                <label class="toggle-switch"><input type="checkbox" id="emailNotifications"><span
                        class="toggle-slider"></span></label>
            </div>
            <div class="toggle-group">
                <span><i class="fas fa-phone-alt"></i> SMS Notifications</span>
                <label class="toggle-switch"><input type="checkbox" id="smsNotifications"><span
                        class="toggle-slider"></span></label>
            </div>
            <div class="toggle-group">
                <span><i class="fas fa-shopping-cart"></i> Order Updates</span>
                <label class="toggle-switch"><input type="checkbox" id="orderUpdates"><span
                        class="toggle-slider"></span></label>
            </div>
            <div class="toggle-group">
                <span><i class="fas fa-gift"></i> Promotions & Offers</span>
                <label class="toggle-switch"><input type="checkbox" id="promotions"><span
                        class="toggle-slider"></span></label>
            </div>
            <button class="btn-primary btn-save" data-section="notifications"><i class="fas fa-save"></i> Save
                Notification Settings</button>
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
                <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="FAQ.php">FAQs</a>
                <a href="Blog.php">Tech Blog</a>
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
    <div id="popupMessage" class="popup"></div>

    <script>
        // Auto logout after 30 minutes of inactivity
        let inactivityTimer;
        const INACTIVITY_LIMIT = 30 * 60 * 1000; // 30 minutes

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                window.location.href = 'Logout.php';
            }, INACTIVITY_LIMIT);
        }

        function startInactivityTracking() {
            resetInactivityTimer();
            const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click', 'keydown'];
            events.forEach(event => {
                document.addEventListener(event, resetInactivityTimer);
            });
        }

        startInactivityTracking();

        // ============== HELPER FUNCTIONS ==============
        function showPopup(message, isError = false) {
            const popup = document.getElementById("popupMessage");
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            popup.style.background = isError ? "#dc2626" : "#10b981";
            popup.style.display = "block";
            setTimeout(() => {
                popup.style.display = "none";
            }, 3000);
        }

        async function apiCall(url, method, data = null, isFormData = false) {
            const options = { method: method };
            if (data) {
                if (isFormData) {
                    options.body = data;
                } else {
                    options.headers = { 'Content-Type': 'application/json' };
                    options.body = JSON.stringify(data);
                }
            }
            const response = await fetch(url, options);
            return await response.json();
        }

        // ============== LOAD ALL SETTINGS ==============
        async function loadAllSettings() {
            try {
                const result = await apiCall('get_vendor_settings.php', 'GET');
                if (result.success) {
                    const data = result.data;
                    if (data.store) {
                        document.getElementById('storeName').value = data.store.store_name || '';
                        document.getElementById('storeDescription').value = data.store.description || '';
                        if (data.store.logo_url) document.getElementById('logoPreview').src = data.store.logo_url;
                        if (data.store.cover_image_url) document.getElementById('coverPreview').src = data.store.cover_image_url;
                    }
                    if (data.policies) {
                        document.getElementById('shippingPolicy').value = data.policies.shipping_policy || '';
                        document.getElementById('returnPolicy').value = data.policies.return_policy || '';
                        document.getElementById('warrantyPolicy').value = data.policies.warranty_policy || '';
                    }
                    if (data.payment) {
                        document.getElementById('paymentMethod').value = data.payment.payment_method || 'bank_transfer';
                        document.getElementById('bankName').value = data.payment.bank_name || '';
                        document.getElementById('accountTitle').value = data.payment.account_title || '';
                        document.getElementById('accountNumber').value = data.payment.account_number || '';
                    }
                    if (data.business) {
                        document.getElementById('taxId').value = data.business.tax_id || '';
                        document.getElementById('businessAddress').value = data.business.business_address || '';
                        document.getElementById('city').value = data.business.city || '';
                        document.getElementById('country').value = data.business.country || '';
                    }
                    if (data.shipping) {
                        document.getElementById('defaultShippingMethod').value = data.shipping.default_shipping_method || 'standard';
                        document.getElementById('handlingTime').value = data.shipping.handling_time || 2;
                        if (data.shipping.available_methods) {
                            let methods = [];
                            try {
                                methods = JSON.parse(data.shipping.available_methods);
                            } catch (e) { methods = []; }
                            document.querySelectorAll('.checkbox-group input').forEach(cb => {
                                cb.checked = methods.includes(cb.value);
                            });
                        }
                    }
                    if (data.notifications) {
                        document.getElementById('emailNotifications').checked = data.notifications.email_notification == 1;
                        document.getElementById('smsNotifications').checked = data.notifications.sms_notification == 1;
                        document.getElementById('orderUpdates').checked = data.notifications.order_updates == 1;
                        document.getElementById('promotions').checked = data.notifications.promotions_offers == 1;
                    }
                } else {
                    showPopup(result.message || 'Failed to load settings', true);
                }
            } catch (error) {
                console.error('Load error:', error);
                showPopup('Failed to load settings', true);
            }
        }

        // ============== SAVE FUNCTIONS ==============
        async function saveStore() {
            const data = {
                store_name: document.getElementById('storeName').value,
                description: document.getElementById('storeDescription').value,
                logo_url: document.getElementById('logoPreview').src,
                cover_image_url: document.getElementById('coverPreview').src
            };
            const result = await apiCall('update_vendor_settings.php', 'POST', data);
            if (result.success) showPopup(result.message);
            else showPopup(result.message, true);
        }

        async function savePolicies() {
            const data = {
                shipping_policy: document.getElementById('shippingPolicy').value,
                return_policy: document.getElementById('returnPolicy').value,
                warranty_policy: document.getElementById('warrantyPolicy').value
            };
            const result = await apiCall('update_vendor_policies.php', 'POST', data);
            if (result.success) showPopup(result.message);
            else showPopup(result.message, true);
        }

        async function savePayment() {
            const data = {
                payment_method: document.getElementById('paymentMethod').value,
                bank_name: document.getElementById('bankName').value,
                account_title: document.getElementById('accountTitle').value,
                account_number: document.getElementById('accountNumber').value
            };
            const result = await apiCall('update_vendor_payment_settings.php', 'POST', data);
            if (result.success) showPopup(result.message);
            else showPopup(result.message, true);
        }

        async function saveBusiness() {
            const data = {
                tax_id: document.getElementById('taxId').value,
                business_address: document.getElementById('businessAddress').value,
                city: document.getElementById('city').value,
                country: document.getElementById('country').value
            };
            const result = await apiCall('update_vendor_business_info.php', 'POST', data);
            if (result.success) showPopup(result.message);
            else showPopup(result.message, true);
        }

        async function saveShipping() {
            const methods = [];
            document.querySelectorAll('.checkbox-group input:checked').forEach(cb => {
                methods.push(cb.value);
            });
            const data = {
                default_shipping_method: document.getElementById('defaultShippingMethod').value,
                available_methods: methods,
                handling_time: parseInt(document.getElementById('handlingTime').value)
            };
            const result = await apiCall('update_vendor_shipping_settings.php', 'POST', data);
            if (result.success) showPopup(result.message);
            else showPopup(result.message, true);
        }

        async function saveNotifications() {
            const data = {
                email_notification: document.getElementById('emailNotifications').checked ? 1 : 0,
                sms_notification: document.getElementById('smsNotifications').checked ? 1 : 0,
                order_updates: document.getElementById('orderUpdates').checked ? 1 : 0,
                promotions_offers: document.getElementById('promotions').checked ? 1 : 0
            };
            const result = await apiCall('update_vendor_notification_settings.php', 'POST', data);
            if (result.success) showPopup(result.message);
            else showPopup(result.message, true);
        }

        // ============== IMAGE UPLOADS ==============
        async function uploadImage(file, type) {
            const formData = new FormData();
            formData.append(type, file);
            const endpoint = type === 'logo' ? 'upload_vendor_logo.php' : 'upload_vendor_cover.php';
            const result = await apiCall(endpoint, 'POST', formData, true);
            if (result.success) {
                return result.image_url;
            } else {
                showPopup(result.message, true);
                return null;
            }
        }

        // ============== EVENT LISTENERS ==============
        document.getElementById('logoUpload').addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('logoPreview');
                const reader = new FileReader();
                reader.onload = (ev) => { preview.src = ev.target.result; };
                reader.readAsDataURL(file);
                const uploadedUrl = await uploadImage(file, 'logo');
                if (uploadedUrl) preview.src = uploadedUrl;
            }
        });

        document.getElementById('coverUpload').addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('coverPreview');
                const reader = new FileReader();
                reader.onload = (ev) => { preview.src = ev.target.result; };
                reader.readAsDataURL(file);
                const uploadedUrl = await uploadImage(file, 'cover');
                if (uploadedUrl) preview.src = uploadedUrl;
            }
        });

        document.querySelectorAll('.btn-save').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const section = btn.getAttribute('data-section');
                switch (section) {
                    case 'store': saveStore(); break;
                    case 'policies': savePolicies(); break;
                    case 'payment': savePayment(); break;
                    case 'business': saveBusiness(); break;
                    case 'shipping': saveShipping(); break;
                    case 'notifications': saveNotifications(); break;
                }
            });
        });

        // ============== CART & OTHER UI ==============
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const count = cart.reduce((sum, item) => sum + (item.quantity || 1), 0);
            const display = document.getElementById("cartCountDisplay");
            if (display) display.innerText = count;
        }
        updateCartCount();

        // Back to Top
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        // Mobile menu functions
        function renderMobileMenu() {
            const container = document.getElementById("mobileMenuContent");
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
            if (mobileAuth) mobileAuth.onclick = () => { window.location.href = 'Logout.php'; };
        }

        const hamburger = document.getElementById("hamburgerBtn");
        const mobilePanel = document.getElementById("mobileMenuPanel");
        const overlay = document.getElementById("mobileOverlay");
        function openMobile() { mobilePanel.classList.add("open"); overlay.classList.add("show"); }
        function closeMobile() { mobilePanel.classList.remove("open"); overlay.classList.remove("show"); }
        hamburger?.addEventListener("click", openMobile);
        document.getElementById("closeMobileBtn")?.addEventListener("click", closeMobile);
        overlay?.addEventListener("click", closeMobile);

        document.getElementById("authButton")?.addEventListener("click", () => { window.location.href = "Logout.php"; });

        renderMobileMenu();
        
        // Load settings when page loads
        loadAllSettings();
    </script>
</body>

</html>