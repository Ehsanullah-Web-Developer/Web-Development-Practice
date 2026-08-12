<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | Frequently Asked Questions</title>
  <!-- Font Awesome 6 (Free Icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Fonts: Inter + Poppins for headings -->
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Poppins:wght@600;700;800&display=swap"
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

    /* ========== MODERN COLOR SCHEME - Matching Logout.php ========== */
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

    /* ========== HEADER - DARK NAVY ========== */
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
      object-fit: contain;
      transition: transform 0.2s ease;
    }

    .logo img:hover {
      transform: scale(1.02);
    }

    /* Desktop Navigation - White text */
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
      background: transparent;
      border: none;
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

    /* Mobile */
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

    /* ========== FOOTER - DARK NAVY ========== */
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

    /* ========== MAIN FAQ STYLES (MODERN UI) ========== */
    .faq-container {
      max-width: 1100px;
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
      font-size: 2.4rem;
      font-weight: 700;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #FFFFFF 0%, #c7d2fe 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-bottom: 1.8rem;
      letter-spacing: -0.3px;
    }

    /* Search Box */
    .search-section {
      margin-bottom: 2rem;
    }

    /* C. Search Box Hover Animation */
    .search-box {
      display: flex;
      gap: 0.8rem;
      max-width: 750px;
      margin-bottom: 1.5rem;
    }

    .search-box input {
      flex: 1;
      padding: 0.9rem 1.3rem;
      border: 1.5px solid #E5E7EB;
      border-radius: 60px;
      font-size: 0.95rem;
      outline: none;
      transition: all 0.2s ease;
      background: #FFFFFF;
    }

    .search-box input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .search-box button {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 0 2rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.25s ease;
      box-shadow: var(--shadow-sm);
    }

    .search-box button:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    /* NEW REFRESH BUTTON STYLES */
    .refresh-btn {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.3);
      padding: 0 1.5rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.25s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.95rem;
    }

    .refresh-btn:hover {
      background: var(--primary-gradient);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
      border-color: transparent;
    }

    .refresh-btn i {
      font-size: 1rem;
    }

    /* Category Tabs */
    .category-tabs {
      display: flex;
      flex-wrap: wrap;
      gap: 0.8rem;
      margin-bottom: 2rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      padding-bottom: 0.8rem;
    }

    /* C. Tab Button Hover Animation */
    .tab-btn {
      background: transparent;
      border: none;
      padding: 0.6rem 1.4rem;
      cursor: pointer;
      font-weight: 500;
      color: rgba(255, 255, 255, 0.7);
      transition: all 0.25s ease;
      border-radius: 60px;
      font-size: 0.9rem;
    }

    .tab-btn:hover {
      color: #FFFFFF;
      background: rgba(255, 255, 255, 0.1);
      transform: translateY(-2px);
    }

    .tab-btn.active {
      background: var(--primary-gradient);
      color: white;
      box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
    }

    /* FAQ Accordion - White Cards */
    .faq-section {
      margin-bottom: 2rem;
    }

    /* A. FAQ Item Hover Animation */
    .faq-item {
      background: #FFFFFF;
      border-radius: 28px;
      margin-bottom: 1rem;
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .faq-item:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
    }

    .faq-question {
      padding: 1.3rem 1.8rem;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      color: #111827;
      transition: background 0.2s;
    }

    .faq-question:hover {
      background: #FAFCFF;
    }

    .faq-question .icon {
      font-size: 1rem;
      transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      color: var(--primary);
    }

    .faq-answer {
      max-height: 0;
      padding: 0 1.8rem;
      overflow: hidden;
      transition: max-height 0.35s ease-out, padding 0.3s ease;
      background: #FFFFFF;
      border-top: 1px solid transparent;
      color: #374151;
      line-height: 1.65;
    }

    .faq-item.active .faq-answer {
      max-height: 600px;
      padding: 1rem 1.8rem 1.4rem;
      border-top-color: #E5E7EB;
    }

    .faq-item.active .faq-question .icon {
      transform: rotate(180deg);
    }

    /* Contact Support Card */
    /* A. Contact Support Card Hover Animation */
    .contact-support {
      text-align: center;
      margin-top: 2.5rem;
      padding: 2rem;
      background: #FFFFFF;
      border-radius: 32px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .contact-support:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
    }

    .contact-support p {
      color: #111827;
      font-weight: 500;
    }

    /* B. Contact Link Button Hover Animation */
    .contact-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--primary-gradient);
      color: white;
      text-decoration: none;
      padding: 0.8rem 2rem;
      border-radius: 60px;
      font-weight: 600;
      transition: all 0.25s ease;
      margin-top: 0.8rem;
      box-shadow: var(--shadow-sm);
    }

    .contact-link:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

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
      font-weight: 500;
      box-shadow: var(--shadow-md);
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .back-to-top.show {
      opacity: 1;
    }

    .back-to-top:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    /* I. Skeleton Loader Animation - Enhanced Pulse/Shimmer */
    .loading-spinner {
      text-align: center;
      padding: 2.5rem;
      color: var(--primary);
      font-size: 1rem;
      background: #FFFFFF;
      border-radius: 28px;
      background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
      background-size: 200% 100%;
      animation: shimmerPulse 1.5s infinite ease-in-out;
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

    .no-results {
      text-align: center;
      padding: 2.5rem;
      color: #6B7280;
      background: #FFFFFF;
      border-radius: 28px;
    }

    /* Responsive */
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

      .page-title {
        font-size: 1.8rem;
      }

      .faq-question {
        padding: 1rem;
        font-size: 0.95rem;
      }
      
      .search-box {
        max-width: 100%;
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
        <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
        <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
        <li class="nav-item"><a href="FAQ.php" class="nav-link active"><i class="fas fa-question-circle"></i> FAQ</a></li>
        <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span id="cartCountDisplay"
            class="cart-count">0</span></li>
        <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i class="fas fa-key"></i>
            Login</button></li>
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

  <div class="faq-container">
    <div class="breadcrumb"><a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="MyAccount.php">My
        Account</a> / <span>FAQ</span></div>
    <!-- H. Scroll Reveal - Page Title -->
    <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-question-circle"></i> Frequently Asked Questions</h1>
    <div class="search-section">
      <!-- H. Scroll Reveal - Search Box with Refresh Button -->
      <div class="search-box" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30" data-aos-delay="50">
        <input type="text" id="searchInput" placeholder="Search FAQs...">
        <button id="searchBtn"><i class="fas fa-search"></i> Search</button>
        <!-- NEW REFRESH BUTTON ADDED HERE -->
        <button id="refreshBtn" class="refresh-btn"><i class="fas fa-sync-alt"></i> Refresh</button>
      </div>
    </div>
    <!-- H. Scroll Reveal - Category Tabs -->
    <div class="category-tabs" id="categoryTabs" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30" data-aos-delay="100">
      <button class="tab-btn active" data-category="all">All Questions</button>
    </div>
    <!-- H. Scroll Reveal - FAQ Container -->
    <div id="faqContainer" class="faq-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="150">
      <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading FAQs...</div>
    </div>
    <!-- H. Scroll Reveal - Contact Support Card -->
    <div class="contact-support" data-aos="zoom-in" data-aos-duration="500" data-aos-offset="30" data-aos-delay="200">
      <p><i class="fas fa-life-ring"></i> Still have questions? We're here to help!</p>
      <a href="ContactUs.php" class="contact-link"><i class="fas fa-envelope"></i> Contact Support</a>
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
        <a href="AddressBook.php">Address Book</a>
        <a href="Landing.php">Landing</a>
        <a href="Blog.php">Tech Blog</a>
        <a href="Landing.php">Landing</a>
      </div>
      <div class="footer-col">
        <h4>Contact Info</h4>
        <p><i class="fas fa-phone-alt"></i> 03267322096</p>
        <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
        <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
        <div class="social-icons"><i class="fab fa-facebook-f"></i><i class="fab fa-twitter"></i><i
            class="fab fa-instagram"></i><i class="fab fa-youtube"></i><i class="fab fa-linkedin-in"></i></div>
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
      if (authBtn) {
        if (isUserLoggedIn) {
          authBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
        } else {
          authBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login';
        }
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

    // Updated cart icon handler
    document.querySelector('.cart-icon')?.addEventListener('click', async () => {
      await checkUserSession();
      if (!isUserLoggedIn) {
        alert('Please login to manage your cart');
        window.location.href = "LogIn.php";
      } else {
        window.location.href = "Cart.php";
      }
    });

    // ========== MOBILE MENU ==========
    function renderMobileMenu() {
      const container = document.getElementById("mobileMenuContent");
      if (!container) return;
      const logged = isUserLoggedIn;
      const menuItems = [
        { title: "Home", link: "FYPHome.php" },
        { title: "Products", submenu: ["Categories", "Compare Products", "Product Details", "All Products"], links: ["Categories.php", "CompareProducts.php", "ProductDetails.php", "Products1.php"] },
        { title: "Vendors", submenu: ["Vendors List", "Vendors Store", "Vendors Setting", "Vendors Dashboard", "Vendors Products", "Vendors Add Products", "Vendors Edit Products", "Vendors Reviews", "Vendors Orders"], links: ["Vendors.php", "VendorsStore.php", "VendorsSetting.php", "VendorsDashboard.php", "VendorsProducts.php", "VendorsAddProducts.php", "VendorsEditProducts.php", "VendorsReviews.php", "VendorsOrders.php"] },
        { title: "Account", submenu: ["My Account", "Profile", "Orders", "Wishlist", "Address Book", "Payment Methods", "Cart", "Checkout"], links: ["MyAccount.php", "Profile.php", "UserOrders.php", "Wishlist.php", "AddressBook.php", "PaymentMethods.php", "Cart.php", "Checkout.php"] },
        { title: "Support", submenu: ["Contact", "FAQ", "Shipping Info", "Return Policy", "Privacy Policy", "Terms of Service", "About Us"], links: ["ContactUs.php", "FAQ.php", "ShippingInfo.php", "ReturnPolicy.php", "PrivacyPolicy.php", "TermsofService.php", "AboutUs.php"] },
        { title: "Blog", link: "Blog.php" }
      ];
      let html = `<div style="margin-top:1rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%;">${logged ? "<i class='fas fa-sign-out-alt'></i> Logout" : "<i class='fas fa-sign-in-alt'></i> Login"}</button></div><hr style="margin:1rem 0;">`;
      menuItems.forEach(item => {
        if (item.submenu) {
          html += `<div class="mobile-nav-item"><div class="mobile-nav-header" data-toggle="${item.title}" style="display:flex;justify-content:space-between;padding:0.8rem 0;"><span>${item.title}</span> <i class="fas fa-chevron-down"></i></div><div class="mobile-submenu" id="submenu-${item.title}" style="padding-left:1rem;display:none;">`;
          item.submenu.forEach((sub, idx) => html += `<a href="${item.links[idx]}" style="display:block;padding:0.5rem 0;">${sub}</a>`);
          html += `</div></div>`;
        } else html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0;">${item.title}</a></div>`;
      });
      container.innerHTML = html;
      document.querySelectorAll(".mobile-nav-header").forEach(header => {
        header.addEventListener("click", () => {
          const key = header.getAttribute("data-toggle");
          const sub = document.getElementById(`submenu-${key}`);
          if (sub) sub.style.display = sub.style.display === "none" ? "block" : "none";
        });
      });
      document.getElementById("mobileAuthBtn")?.addEventListener("click", () => { handleAuthClick(); renderMobileMenu(); });
    }

    const hamburger = document.getElementById("hamburgerBtn"), mobilePanel = document.getElementById("mobileMenuPanel"), overlay = document.getElementById("mobileOverlay");
    if (hamburger) hamburger.onclick = () => { mobilePanel.classList.add("open"); overlay.classList.add("show"); };
    document.getElementById("closeMobileBtn")?.addEventListener("click", () => { mobilePanel.classList.remove("open"); overlay.classList.remove("show"); });
    if (overlay) overlay.onclick = () => { mobilePanel.classList.remove("open"); overlay.classList.remove("show"); };

    // ========== FAQ DYNAMIC LOGIC ==========
    let faqData = [], currentCategory = "all", currentSearch = "", activeAccordionId = null;
    async function fetchFAQs() {
      const container = document.getElementById("faqContainer");
      container.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading FAQs...</div>';
      try {
        const response = await fetch('get_faq.php');
        const data = await response.json();
        if (data.error || !data.length) { container.innerHTML = '<div class="no-results"><i class="fas fa-exclamation-circle"></i> No FAQs available.</div>'; return []; }
        return data;
      } catch (e) { container.innerHTML = '<div class="no-results">❌ Connection error. Please refresh.</div>'; return []; }
    }
    function extractCategories(faqs) {
      let cats = new Set(["all"]);
      faqs.forEach(f => f.category && cats.add(f.category));
      return Array.from(cats);
    }
    function renderCategoryTabs(cats) {
      const tabsDiv = document.getElementById("categoryTabs");
      if (!tabsDiv) return;
      tabsDiv.innerHTML = cats.map(c => `<button class="tab-btn ${currentCategory === c ? 'active' : ''}" data-category="${c}">${c === 'all' ? 'All Questions' : c}</button>`).join('');
      document.querySelectorAll('.tab-btn').forEach(btn => btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentCategory = btn.dataset.category;
        activeAccordionId = null;
        renderFAQs();
      }));
    }
    function getFilteredFAQs() {
      let filtered = [...faqData];
      if (currentCategory !== "all") filtered = filtered.filter(f => f.category === currentCategory);
      if (currentSearch.trim()) {
        let s = currentSearch.toLowerCase();
        filtered = filtered.filter(f => f.question.toLowerCase().includes(s) || f.answer.toLowerCase().includes(s));
      }
      return filtered;
    }
    window.toggleAccordion = function (id) {
      const item = document.querySelector(`.faq-item[data-id="${id}"]`);
      if (!item) return;
      if (activeAccordionId === id) { item.classList.remove('active'); activeAccordionId = null; }
      else {
        if (activeAccordionId) document.querySelector(`.faq-item[data-id="${activeAccordionId}"]`)?.classList.remove('active');
        item.classList.add('active');
        activeAccordionId = id;
      }
    };
    function renderFAQs() {
      const filtered = getFilteredFAQs(), container = document.getElementById("faqContainer");
      if (!filtered.length) { container.innerHTML = '<div class="no-results"><i class="fas fa-search"></i> No matching FAQs found.</div>'; return; }
      container.innerHTML = filtered.map((f, index) => `
      <div class="faq-item" data-id="${f.faq_id}" data-aos="fade-up" data-aos-duration="400" data-aos-delay="${index * 50}">
        <div class="faq-question" onclick="toggleAccordion(${f.faq_id})">
          <span><i class="fas fa-question-circle" style="color:#2563EB; margin-right:10px;"></i>${escapeHtml(f.question)}</span>
          <span class="icon"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div class="faq-answer">${escapeHtml(f.answer)}</div>
      </div>
    `).join('');
      if (activeAccordionId && filtered.some(f => f.faq_id === activeAccordionId)) document.querySelector(`.faq-item[data-id="${activeAccordionId}"]`)?.classList.add('active');
      
      // Refresh AOS for dynamically added elements
      AOS.refresh();
    }
    function escapeHtml(str) { return str.replace(/[&<>]/g, function (m) { if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; return m; }); }

    // --- REFRESH FUNCTION: Reloads the page to default state ---
    function refreshPage() {
      window.location.reload();
    }

    async function initFAQPage() {
      faqData = await fetchFAQs();
      if (faqData.length) { renderCategoryTabs(extractCategories(faqData)); renderFAQs(); }
      document.getElementById("searchBtn")?.addEventListener("click", () => { currentSearch = document.getElementById("searchInput").value; activeAccordionId = null; renderFAQs(); });
      document.getElementById("searchInput")?.addEventListener("keypress", e => { if (e.key === "Enter") { currentSearch = e.target.value; activeAccordionId = null; renderFAQs(); } });
      
      // --- REFRESH BUTTON EVENT LISTENER ---
      document.getElementById("refreshBtn")?.addEventListener("click", refreshPage);
    }

    const backBtn = document.getElementById("backToTop");
    window.addEventListener("scroll", () => backBtn.classList.toggle("show", window.scrollY > 300));
    backBtn?.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

    // ========== INITIALIZE PAGE ==========
    async function init() {
      await checkUserSession();
      setAuthUI();
      renderMobileMenu();
      await updateCartCount();
      await initFAQPage();
    }

    init();
  </script>
</body>

</html>