<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | Privacy Policy</title>
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

    .nav-link:hover {
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

    /* Main Layout */
    .privacy-wrapper {
      max-width: 1400px;
      margin: 0 auto;
      padding: 2rem 1.5rem;
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
    }

    /* Sidebar Navigation - White Card */
    .sidebar {
      flex: 0 0 300px;
      position: sticky;
      top: 100px;
      height: fit-content;
      background: #FFFFFF;
      border-radius: 32px;
      padding: 1.5rem;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    /* A. Sidebar Hover Animation */
    .sidebar:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
    }

    .sidebar h3 {
      font-size: 1.2rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 1rem;
      padding-bottom: 0.6rem;
      border-bottom: 2px solid #E5E7EB;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .sidebar-nav {
      list-style: none;
    }

    .sidebar-nav li {
      margin-bottom: 0.8rem;
    }

    .sidebar-nav a {
      text-decoration: none;
      color: #6B7280;
      font-weight: 500;
      transition: all 0.25s ease;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 0.5rem 0.75rem;
      border-radius: 16px;
    }

    .sidebar-nav a:hover {
      color: var(--primary);
      background: #F3F4F6;
      transform: translateX(4px);
    }

    /* Main Content */
    .main-content {
      flex: 1;
      min-width: 0;
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
      margin-bottom: 0.5rem;
    }

    .last-updated {
      color: rgba(255, 255, 255, 0.7);
      font-size: 0.85rem;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Policy Sections - White Cards */
    .policy-section {
      background: #FFFFFF;
      border-radius: 32px;
      padding: 2rem;
      margin-bottom: 2rem;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      scroll-margin-top: 100px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    /* A. Policy Section Hover Animation */
    .policy-section:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
    }

    .policy-section h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .policy-section h3 {
      font-size: 1.2rem;
      font-weight: 600;
      color: #111827;
      margin: 1rem 0 0.5rem;
    }

    .policy-section p {
      line-height: 1.7;
      color: #374151;
      margin-bottom: 1rem;
    }

    .bullet-list {
      list-style: none;
      padding-left: 0;
    }

    .bullet-list li {
      padding: 0.6rem 0;
      padding-left: 1.5rem;
      position: relative;
      color: #374151;
      line-height: 1.5;
      transition: transform 0.2s ease;
    }

    .bullet-list li:hover {
      transform: translateX(4px);
    }

    .bullet-list li::before {
      content: "▹";
      position: absolute;
      left: 0;
      color: var(--primary);
    }

    /* B. Button/Link Hover Animation */
    .cookie-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #F3F4F6;
      color: var(--primary);
      padding: 0.5rem 1.2rem;
      border-radius: 60px;
      text-decoration: none;
      font-weight: 600;
      margin-top: 0.5rem;
      transition: all 0.25s ease;
    }

    .cookie-link:hover {
      background: var(--primary);
      color: white;
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    .contact-email {
      background: #F3F4F6;
      padding: 1rem;
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-weight: 600;
      color: var(--primary);
      transition: all 0.25s ease;
    }

    .contact-email:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px -4px rgba(0, 0, 0, 0.1);
    }

    /* Cookie Modal */
    .cookie-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(4px);
      z-index: 2000;
      align-items: center;
      justify-content: center;
    }

    .cookie-modal.show {
      display: flex;
    }

    .modal-content {
      background: #FFFFFF;
      max-width: 520px;
      width: 90%;
      padding: 2rem;
      border-radius: 32px;
      box-shadow: var(--shadow-xl);
      text-align: center;
      animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .modal-content h3 {
      font-size: 1.4rem;
      color: #111827;
    }

    .modal-content p {
      margin: 1rem 0;
      color: #6B7280;
      line-height: 1.6;
    }

    .modal-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      margin-top: 1.5rem;
    }

    /* B. Modal Button Hover Animation */
    .modal-btn {
      padding: 0.7rem 1.8rem;
      border-radius: 60px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.25s ease;
    }

    .modal-btn-primary {
      background: var(--primary-gradient);
      color: white;
    }

    .modal-btn-primary:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    .modal-btn-secondary {
      background: #F3F4F6;
      color: #374151;
    }

    .modal-btn-secondary:hover {
      background: #E5E7EB;
      transform: translateY(-2px) scale(1.02);
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

    @media (max-width: 900px) {
      .privacy-wrapper {
        flex-direction: column;
      }

      .sidebar {
        position: relative;
        top: 0;
        width: 100%;
      }

      .policy-section {
        padding: 1.2rem;
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
        <li class="nav-item"><a href="FYPHome.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
        <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
        <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
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

  <div class="privacy-wrapper">
    <!-- H. Scroll Reveal - Sidebar -->
    <aside class="sidebar" data-aos="fade-right" data-aos-duration="600" data-aos-offset="100">
      <h3><i class="fas fa-book-open"></i> On this page</h3>
      <ul class="sidebar-nav">
        <li><a href="#acceptable-use"><i class="fas fa-gavel"></i> Acceptable Use Policy</a></li>
        <li><a href="#data-collection"><i class="fas fa-database"></i> Data Collection</a></li>
        <li><a href="#cookie-policy-section"><i class="fas fa-cookie-bite"></i> Cookie Policy</a></li>
        <li><a href="#contact-privacy"><i class="fas fa-envelope"></i> Privacy Concerns</a></li>
      </ul>
    </aside>

    <div class="main-content">
      <div class="breadcrumb">
        <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Privacy Policy</span>
      </div>
      <!-- H. Scroll Reveal - Page Title -->
      <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-shield-alt"></i> Privacy Policy</h1>
      <div class="last-updated" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30"><i class="fas fa-calendar-alt"></i> Last updated: March 25, 2026</div>

      <!-- H. Scroll Reveal - Policy Sections -->
      <section id="acceptable-use" class="policy-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="50">
        <h2><i class="fas fa-gavel"></i> Acceptable Use Policy</h2>
        <p>At Global Hardware Hub, we are committed to maintaining a safe, secure, and lawful environment for all users.
          By accessing our platform, you agree to the following terms:</p>
        <ul class="bullet-list">
          <li><strong>Permitted Use:</strong> You may browse, purchase computer hardware products, interact with
            vendors, and use our services for personal or business purposes in compliance with applicable laws.</li>
          <li><strong>Prohibited Use:</strong> You may not use the website to distribute malware, engage in fraudulent
            activities, harass others, or attempt to bypass security measures.</li>
          <li><strong>Account Integrity:</strong> You are responsible for maintaining the confidentiality of your
            account credentials and for all activities that occur under your account.</li>
          <li><strong>Content Guidelines:</strong> Any reviews, comments, or submissions must be respectful and free
            from offensive, illegal, or misleading content.</li>
          <li><strong>Enforcement:</strong> Violation of this policy may result in account suspension, termination, or
            legal action where applicable.</li>
        </ul>
      </section>

      <section id="data-collection" class="policy-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="100">
        <h2><i class="fas fa-database"></i> Data Collection Explanation</h2>
        <p>We collect certain information to provide and improve our services. All data is stored locally on your device
          or processed in accordance with this policy.</p>
        <ul class="bullet-list">
          <li><strong>Account Information:</strong> Full name, email address, phone number, and account type
            (buyer/vendor) are stored in your browser's localStorage to simulate authentication and personalization.
          </li>
          <li><strong>Order & Cart Data:</strong> Items added to cart, order history, and wishlist preferences are saved
            locally to enhance your shopping experience.</li>
          <li><strong>Usage Data:</strong> We may collect anonymized interaction data (via browser features) to
            understand how you navigate the marketplace, helping us improve layout and performance.</li>
          <li><strong>Device Information:</strong> Browser type, screen resolution, and operating system are used to
            ensure responsive design compatibility.</li>
          <li><strong>Data Storage:</strong> All personal data remains on your device using localStorage. No data is
            transmitted to external servers. You can clear your data anytime via browser settings.</li>
        </ul>
      </section>

      <section id="cookie-policy-section" class="policy-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="150">
        <h2><i class="fas fa-cookie-bite"></i> Cookie Policy</h2>
        <p>Cookies are small text files placed on your device to help us analyze site traffic, remember preferences, and
          improve your experience. We use necessary, functional, analytics, and advertising cookies to tailor content
          and offers.</p>
        <p>You have the option to accept or reject non-essential cookies. Your choice is stored in localStorage and you
          can change preferences at any time.</p>
        <a href="CookiePolicy.php" class="cookie-link"><i class="fas fa-external-link-alt"></i> Read Detailed Cookie
          Policy →</a>
        <button id="openCookieModalBtn" class="cookie-link" style="margin-left: 0.5rem;"><i
            class="fas fa-sliders-h"></i> Cookie Preferences</button>
      </section>

      <section id="contact-privacy" class="policy-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="200">
        <h2><i class="fas fa-envelope"></i> Contact for Privacy Concerns</h2>
        <p>If you have any questions about this Privacy Policy, your data, or wish to exercise your rights regarding
          personal information, please reach out to our privacy team.</p>
        <div class="contact-email">
          <i class="fas fa-envelope"></i> privacy@GlobalHardwareHub.com
        </div>
        <p style="margin-top: 1rem; font-size: 0.85rem;"><i class="fas fa-clock"></i> Typical response time: 24-48 hours
          on business days.</p>
        <p>You can also use our <a href="ContactUs.php"
            style="color:var(--primary); text-decoration:none; font-weight:600; transition: all 0.2s ease;" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='translateX(0)'">Contact Form <i
              class="fas fa-arrow-right"></i></a> for general inquiries.</p>
      </section>
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
        <a href="Categories.php">Categories</a>
        <a href="ShippingInfo.php">Shipping Info</a>
        <a href="Blog.php">Tech Blog</a>
        <a href="Landing.php">Landing</a>
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

  <div id="cookieModal" class="cookie-modal">
    <div class="modal-content">
      <h3><i class="fas fa-cookie-bite"></i> Cookie Preferences</h3>
      <p>We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. You
        can choose to accept all cookies or only necessary ones.</p>
      <div class="modal-buttons">
        <button id="modalAccept" class="modal-btn modal-btn-primary"><i class="fas fa-check"></i> Accept All</button>
        <button id="modalReject" class="modal-btn modal-btn-secondary"><i class="fas fa-times"></i> Reject
          Non-Essential</button>
      </div>
    </div>
  </div>

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

    // ============== LOGIN/LOGOUT FUNCTIONS ==========
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

    // ============== MOBILE MENU ==========
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

    // Smooth scroll for sidebar links
    document.querySelectorAll('.sidebar-nav a, .cookie-link[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href');
        if (targetId && targetId !== '#' && targetId.startsWith('#')) {
          e.preventDefault();
          const targetElement = document.querySelector(targetId);
          if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }
        }
      });
    });

    // Back to Top Button
    const backToTopBtn = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        backToTopBtn.classList.add('show');
      } else {
        backToTopBtn.classList.remove('show');
      }
    });
    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Cookie Modal Logic (Frontend-only)
    const modal = document.getElementById('cookieModal');
    const openModalBtn = document.getElementById('openCookieModalBtn');
    const modalAccept = document.getElementById('modalAccept');
    const modalReject = document.getElementById('modalReject');

    function closeModal() {
      modal.classList.remove('show');
    }

    function setCookieConsent(choice) {
      localStorage.setItem('cookieConsent', choice);
      closeModal();
      alert(`Cookie preference saved: ${choice === 'accepted' ? 'All cookies accepted' : 'Only necessary cookies enabled'}`);
    }

    if (openModalBtn) {
      openModalBtn.addEventListener('click', () => {
        modal.classList.add('show');
      });
    }

    modalAccept?.addEventListener('click', () => setCookieConsent('accepted'));
    modalReject?.addEventListener('click', () => setCookieConsent('rejected'));

    modal?.addEventListener('click', (e) => {
      if (e.target === modal) closeModal();
    });

    // Cart icon handler
    const cartIcon = document.querySelector('.cart-icon');
    if (cartIcon) {
      cartIcon.addEventListener('click', async () => {
        await checkUserSession();
        if (isUserLoggedIn) {
          window.location.href = "Cart.php";
        } else {
          alert('Please login to manage your cart');
          window.location.href = "LogIn.php";
        }
      });
    }

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