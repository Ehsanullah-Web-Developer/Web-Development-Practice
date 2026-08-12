<?php
// Start session to check login
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: LogIn.php');
  exit;
}

$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | Track Your Order</title>
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

    /* Tracking Container */
    .tracking-container {
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

    /* Search Section - White Card */
    /* A. Search Section Hover Animation */
    .search-section {
      background: #FFFFFF;
      border-radius: 32px;
      padding: 2rem;
      margin-bottom: 2rem;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .search-section:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
    }

    .search-box {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      align-items: center;
    }

    .search-box input {
      flex: 1;
      padding: 0.9rem 1.2rem;
      border: 1.5px solid #E5E7EB;
      border-radius: 60px;
      font-size: 0.95rem;
      outline: none;
      transition: all 0.2s ease;
    }

    .search-box input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* B. Button Hover Animation */
    .search-box button {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 0.9rem 2rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 700;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .search-box button:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    .error-msg {
      color: var(--danger);
      font-size: 0.85rem;
      margin-top: 0.8rem;
    }

    /* Order Details Card - White */
    .order-details {
      background: #FFFFFF;
      border-radius: 32px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      display: none;
      transition: all 0.3s ease;
    }

    .order-details:hover {
      transform: translateY(-2px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
    }

    .order-details.show {
      display: block;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Timeline */
    .timeline-section {
      margin-bottom: 2rem;
    }

    .timeline-title {
      font-size: 1.2rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .timeline {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      position: relative;
      margin: 2rem 0;
    }

    .timeline-step {
      flex: 1;
      text-align: center;
      position: relative;
      min-width: 100px;
      transition: all 0.3s ease;
    }

    .step-icon {
      width: 45px;
      height: 45px;
      background: #F3F4F6;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 0.8rem;
      font-size: 1.3rem;
      transition: all 0.3s ease;
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
      font-weight: 600;
      margin-bottom: 0.3rem;
      color: #374151;
    }

    .step-date {
      font-size: 0.7rem;
      color: #6B7280;
    }

    .cancelled-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--danger);
      color: white;
      padding: 0.4rem 1.2rem;
      border-radius: 60px;
      font-size: 0.85rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    /* Info Grid */
    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
      padding: 1rem 0;
    }

    /* A. Info Card Hover Animation */
    .info-card {
      background: #F9FAFB;
      padding: 1.2rem;
      border-radius: 20px;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      border: 1px solid #E5E7EB;
    }

    .info-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-md);
      border-color: var(--primary);
    }

    .info-card h4 {
      color: #111827;
      margin-bottom: 0.8rem;
      font-size: 1rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .info-card p {
      color: #6B7280;
      margin-bottom: 0.3rem;
      font-size: 0.85rem;
    }

    /* Items Table */
    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
    }

    .items-table th,
    .items-table td {
      padding: 0.8rem;
      text-align: left;
      border-bottom: 1px solid #E5E7EB;
    }

    .items-table th {
      color: #374151;
      font-weight: 600;
    }

    .product-cell {
      display: flex;
      align-items: center;
      gap: 0.8rem;
    }

    /* D. Product Image Zoom Animation */
    .product-img {
      width: 50px;
      height: 50px;
      background: #F3F4F6;
      border-radius: 12px;
      object-fit: cover;
      transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .product-img:hover {
      transform: scale(1.08);
    }

    .total-amount {
      text-align: right;
      font-size: 1.2rem;
      font-weight: 800;
      color: var(--primary);
      padding-top: 1rem;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      margin-top: 1.5rem;
    }

    /* B. Action Button Hover Animation */
    .action-btn {
      padding: 0.7rem 1.5rem;
      border-radius: 60px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-view {
      background: var(--primary-gradient);
      color: white;
    }

    .btn-view:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    .action-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }

    /* I. Skeleton Loader Animation */
    .skeleton-loader {
      text-align: center;
      padding: 2rem;
      background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
      background-size: 200% 100%;
      animation: shimmerPulse 1.5s infinite ease-in-out;
      border-radius: 28px;
    }

    @keyframes shimmerPulse {
      0% {
        background-position: 200% 0;
        opacity: 0.6;
      }
      50% {
        opacity: 1;
      }
      100% {
        background-position: -200% 0;
        opacity: 0.6;
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
        gap: 1rem;
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

      .page-title {
        font-size: 1.8rem;
      }

      .search-section {
        padding: 1.2rem;
      }
    }
  </style>
</head>

<body>

  <header class="header">
    <div class="nav-container">
      <div class="logo">
        <img src="Logo.jpg" alt="GlobalHardwareHub Logo">
      </div>

      <ul class="nav-links" id="desktopNav">
        <li class="nav-item"><a href="FYPHome.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
        <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
        <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
        <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span id="cartCountDisplay"
            class="cart-count">0</span></li>
        <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i class="fas fa-key"></i>
            Logout</button></li>
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

  <div class="tracking-container">
    <div class="breadcrumb">
      <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="MyAccount.php">My Account</a> / <a
        href="UserOrders.php">Orders</a> / <span>Track Order</span>
    </div>
    <!-- H. Scroll Reveal - Page Title -->
    <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-map-marked-alt"></i> Track Your Order</h1>

    <!-- H. Scroll Reveal - Search Section -->
    <div class="search-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="50">
      <div class="search-box">
        <input type="text" id="orderIdInput" placeholder="Enter Order ID (e.g., 1001)">
        <button id="trackBtn"><i class="fas fa-search"></i> Track Order</button>
      </div>
      <div id="searchError" class="error-msg"></div>
    </div>

    <!-- H. Scroll Reveal - Order Details -->
    <div id="orderDetails" class="order-details" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="100"></div>
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
        <a href="Blog.php">Tech Blog</a>
        <a href="UserOrders.php">Bulk Orders</a>
        <a href="AboutUs.php">About Us</a>
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
    let isUserLoggedIn = true; // User is logged in due to PHP check at top
    let isCustomerRole = false;
    let currentUserId = <?php echo json_encode($userId); ?>;

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

    // ============== GLOBAL VARIABLES ==============
    let currentOrderData = null;

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
      if (!dateString) return 'Pending';
      const date = new Date(dateString);
      return date.toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    }

    function formatDateOnly(dateString) {
      if (!dateString) return 'Pending';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
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

    // ============== API CALL ==============
    async function trackOrder() {
      const orderId = document.getElementById("orderIdInput").value.trim();
      const errorDiv = document.getElementById("searchError");
      const container = document.getElementById("orderDetails");

      if (!orderId) {
        errorDiv.innerText = "Please enter an Order ID";
        container.classList.remove("show");
        return;
      }

      errorDiv.innerText = "";
      container.classList.remove("show");

      try {
        const response = await fetch(`track_order.php?order_id=${orderId}`);
        const result = await response.json();

        if (result.success) {
          currentOrderData = result;
          renderOrderDetails();
        } else {
          errorDiv.innerText = result.message || "Order not found. Please check your Order ID.";
          showMessage(result.message || "Order not found", true);
        }
      } catch (error) {
        console.error("Track order error:", error);
        errorDiv.innerText = "Failed to load order details. Please try again.";
        showMessage("Failed to load order details", true);
      }
    }

    // ============== RENDER FUNCTIONS ==============
    function renderOrderDetails() {
      if (!currentOrderData || !currentOrderData.order) return;

      const order = currentOrderData.order;
      const timeline = currentOrderData.timeline;
      const shippingAddress = currentOrderData.shipping_address;
      const items = currentOrderData.items || [];
      const viewDetailsUrl = currentOrderData.view_details_url;

      const steps = ["ordered", "confirmed", "shipped", "out_for_delivery", "delivered"];
      const stepLabels = {
        ordered: "Ordered",
        confirmed: "Confirmed",
        shipped: "Shipped",
        out_for_delivery: "Out for Delivery",
        delivered: "Delivered"
      };
      const stepIcons = {
        ordered: '<i class="fas fa-shopping-cart"></i>',
        confirmed: '<i class="fas fa-check-circle"></i>',
        shipped: '<i class="fas fa-truck"></i>',
        out_for_delivery: '<i class="fas fa-truck-fast"></i>',
        delivered: '<i class="fas fa-box-open"></i>'
      };

      const isCancelled = order.status === "cancelled";

      let timelineHtml = `<div class="timeline-section"><div class="timeline-title"><i class="fas fa-chart-line"></i> Order Status Timeline</div>`;
      if (isCancelled) {
        timelineHtml += `<div class="cancelled-badge"><i class="fas fa-times-circle"></i> Order Cancelled</div>`;
      }
      timelineHtml += `<div class="timeline">`;

      for (let i = 0; i < steps.length; i++) {
        const step = steps[i];
        const stepData = timeline[step];
        const isCompleted = stepData && stepData.status === "completed";
        const isActive = stepData && stepData.status === "active";
        const stepDate = stepData && stepData.datetime ? formatDate(stepData.datetime) : "Pending";

        timelineHtml += `
        <div class="timeline-step ${isCompleted ? 'completed' : ''} ${isActive ? 'active' : ''}">
          <div class="step-icon">${stepIcons[step]}</div>
          <div class="step-label">${stepLabels[step]}</div>
          <div class="step-date"><i class="fas fa-calendar-alt"></i> ${stepDate}</div>
        </div>
      `;
      }
      timelineHtml += `</div>`;

      if (!isCancelled && currentOrderData.estimated_delivery) {
        timelineHtml += `<div style="margin-top:1rem; padding:0.8rem 1.2rem; background:#F3F4F6; border-radius:20px; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-calendar-week" style="color:var(--primary);"></i>
        <strong>📅 Estimated Delivery:</strong> ${formatDateOnly(currentOrderData.estimated_delivery)}
      </div>`;
      }
      timelineHtml += `</div>`;

      let itemsHtml = `<table class="items-table"><thead><tr><th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>`;

      items.forEach((item, index) => {
        const imageUrl = item.image_url && item.image_url !== 'placeholder.jpg' ? item.image_url : 'https://placehold.co/50x50/2563eb/white?text=Product';
        itemsHtml += `
        <tr>
          <td>
            <div class="product-cell">
              <img class="product-img" src="${imageUrl}" alt="${escapeHtml(item.product_name)}" onerror="this.src='https://placehold.co/50x50/2563eb/white?text=Product'">
              <span>${escapeHtml(item.product_name)}</span>
            </div>
          </td>
          <td>${item.quantity}</td>
          <td>PKR ${parseFloat(item.price).toFixed(2)}</td>
          <td>PKR ${parseFloat(item.subtotal || (item.price * item.quantity)).toFixed(2)}</td>
        </tr>
      `;
      });

      itemsHtml += `</tbody></table>`;
      itemsHtml += `<div class="total-amount"><i class="fas fa-rupee-sign"></i> Total: PKR ${parseFloat(order.total_amount).toFixed(2)}</div>`;

      let addressHtml = '';
      if (shippingAddress) {
        const addressLine = `${shippingAddress.address_line1 || ''} ${shippingAddress.address_line2 || ''}`.trim();
        addressHtml = `
        <div class="info-grid">
          <div class="info-card">
            <h4><i class="fas fa-info-circle"></i> Order Information</h4>
            <p><strong>Order ID:</strong> #${order.order_id}</p>
            <p><strong>Order Date:</strong> ${formatDate(order.order_date)}</p>
            <p><strong>Payment Method:</strong> ${escapeHtml(order.payment_method || 'N/A')}</p>
          </div>
          <div class="info-card">
            <h4><i class="fas fa-location-dot"></i> Shipping Address</h4>
            <p>${escapeHtml(shippingAddress.label || '')}</p>
            <p>${escapeHtml(addressLine)}</p>
            <p>${escapeHtml(shippingAddress.city || '')}${shippingAddress.state ? ', ' + escapeHtml(shippingAddress.state) : ''} ${escapeHtml(shippingAddress.postal_code || '')}</p>
            <p>${escapeHtml(shippingAddress.country || '')}</p>
          </div>
          <div class="info-card">
            <h4><i class="fas fa-credit-card"></i> Billing Address</h4>
            <p>Same as shipping address</p>
          </div>
        </div>
      `;
      }

      let actionsHtml = `<div class="action-buttons">`;
      actionsHtml += `<button class="action-btn btn-view" id="viewDetailsBtn"><i class="fas fa-eye"></i> View Full Details</button>`;
      actionsHtml += `</div>`;

      const container = document.getElementById("orderDetails");
      container.innerHTML = `
      ${timelineHtml}
      ${addressHtml}
      <h3 style="margin:1.5rem 0 1rem; display:flex; align-items:center; gap:8px;"><i class="fas fa-box"></i> Order Items</h3>
      ${itemsHtml}
      ${actionsHtml}
    `;
      container.classList.add("show");

      const viewDetailsBtn = document.getElementById("viewDetailsBtn");
      if (viewDetailsBtn && viewDetailsUrl) {
        viewDetailsBtn.addEventListener("click", () => {
          window.location.href = viewDetailsUrl;
        });
      }
    }

    // ============== LOGIN/LOGOUT FUNCTIONS ==============
    function setAuthUI() {
      const authBtn = document.getElementById('authButton');
      if (authBtn) authBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
      renderMobileMenu();
    }

    function handleAuthClick() {
      window.location.href = 'Logout.php';
    }

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

    // Back to Top
    const backBtn = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) backBtn.classList.add('show');
      else backBtn.classList.remove('show');
    });
    backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    // ============== EVENT LISTENERS ==============
    document.getElementById("trackBtn")?.addEventListener("click", trackOrder);
    document.getElementById("orderIdInput")?.addEventListener("keypress", (e) => {
      if (e.key === "Enter") trackOrder();
    });

    // ============== INITIALIZE PAGE ==============
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