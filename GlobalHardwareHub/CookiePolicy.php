<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | Cookie Policy</title>
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

    /* White text on dark navbar */
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

    /* Main Content */
    .policy-container {
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
      font-size: 2.4rem;
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
      margin-bottom: 1.5rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    /* A. Policy Section Hover Animation */
    .policy-section:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
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
      margin-bottom: 0.8rem;
    }

    .cookie-list {
      list-style: none;
      padding-left: 0;
    }

    .cookie-list li {
      padding: 0.8rem 0;
      border-bottom: 1px solid #E5E7EB;
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      transition: all 0.2s ease;
    }

    .cookie-list li:hover {
      background-color: #F9FAFB;
      transform: translateX(4px);
      padding-left: 0.5rem;
    }

    .cookie-list li:last-child {
      border-bottom: none;
    }

    .cookie-list li strong {
      min-width: 160px;
      color: #111827;
      font-weight: 700;
    }

    .consent-toggle {
      margin-top: 1rem;
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      align-items: center;
    }

    /* B. Button Hover Animation */
    .btn-consent {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 0.7rem 1.8rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.25s ease;
    }

    .btn-consent:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    .btn-reject {
      background: #F3F4F6;
      color: #374151;
      border: 1px solid #E5E7EB;
    }

    .btn-reject:hover {
      background: #E5E7EB;
      transform: translateY(-2px) scale(1.02);
    }

    .consent-status {
      background: #F3F4F6;
      padding: 0.5rem 1.2rem;
      border-radius: 60px;
      font-size: 0.85rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .consent-status:hover {
      transform: scale(1.02);
    }

    /* Cookie Banner */
    .cookie-banner {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: #FFFFFF;
      box-shadow: 0 -8px 25px rgba(0, 0, 0, 0.15);
      padding: 1.2rem 2rem;
      z-index: 1001;
      transform: translateY(0);
      transition: transform 0.3s ease;
      border-top: 1px solid #E5E7EB;
    }

    .cookie-banner.hidden {
      transform: translateY(100%);
    }

    .banner-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
    }

    .banner-text {
      flex: 1;
      color: #374151;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .banner-buttons {
      display: flex;
      gap: 1rem;
    }

    /* B. Button Hover Animation */
    .btn-accept,
    .btn-reject-banner {
      padding: 0.6rem 1.5rem;
      border-radius: 60px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.25s ease;
      border: none;
    }

    .btn-accept {
      background: var(--primary-gradient);
      color: white;
    }

    .btn-accept:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    .btn-reject-banner {
      background: #F3F4F6;
      color: #374151;
      border: 1px solid #E5E7EB;
    }

    .btn-reject-banner:hover {
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
      .page-title {
        font-size: 1.8rem;
      }

      .policy-section {
        padding: 1.2rem;
      }

      .banner-content {
        flex-direction: column;
        text-align: center;
      }

      .cookie-list li {
        flex-direction: column;
        gap: 0.3rem;
      }

      .cookie-list li strong {
        min-width: auto;
      }

      .consent-toggle {
        flex-direction: column;
        align-items: stretch;
      }

      .consent-status {
        text-align: center;
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
        <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQs</a></li>
        <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
        <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
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

  <main class="policy-container">
    <div class="breadcrumb">
      <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Cookie Policy</span>
    </div>
    <!-- H. Scroll Reveal - Page Title -->
    <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-cookie-bite"></i> Cookie Policy</h1>
    <div class="last-updated" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30"><i class="fas fa-calendar-alt"></i> Last updated: March 25, 2026</div>

    <!-- H. Scroll Reveal - Policy Sections -->
    <div class="policy-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="50">
      <h2><i class="fas fa-question-circle"></i> What are Cookies?</h2>
      <p>Cookies are small text files stored on your device (computer, tablet, or mobile) when you visit websites. They
        help websites remember your actions and preferences (like login, language, font size, and other display
        preferences) over a period of time, so you don't have to keep re-entering them whenever you come back to the
        site or browse from one page to another.</p>
    </div>

    <div class="policy-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="100">
      <h2><i class="fas fa-list"></i> Types of Cookies We Use</h2>
      <ul class="cookie-list">
        <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="50"><strong><i class="fas fa-shield-alt"></i> Necessary Cookies</strong> – Essential for the website to function
          properly. They enable core functionality like security, network management, and accessibility.</li>
        <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="100"><strong><i class="fas fa-sliders-h"></i> Functional Cookies</strong> – Remember your preferences (e.g.,
          language, region) to provide enhanced, personalized features.</li>
        <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="150"><strong><i class="fas fa-chart-line"></i> Analytics Cookies</strong> – Help us understand how visitors
          interact with our website by collecting and reporting information anonymously.</li>
        <li data-aos="fade-right" data-aos-duration="300" data-aos-delay="200"><strong><i class="fas fa-ad"></i> Advertising Cookies</strong> – Track your browsing habits to deliver
          targeted advertisements relevant to your interests.</li>
      </ul>
    </div>

    <div class="policy-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="150">
      <h2><i class="fas fa-search"></i> How We Use Cookies</h2>
      <p>We use cookies to improve your browsing experience, analyze site traffic, personalize content, and serve
        relevant advertisements. Cookies also help us understand which products and categories are most popular among
        our users, allowing us to enhance our computer hardware marketplace for you.</p>
    </div>

    <div class="policy-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="200">
      <h2><i class="fas fa-sliders-h"></i> Managing Cookies</h2>
      <p>You can control and manage cookies in various ways. Most browsers allow you to view, delete, or block cookies
        through their settings. Please note that disabling certain cookies may affect the functionality of our website.
      </p>
      <div class="consent-toggle" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30">
        <button id="acceptCookiesBtn" class="btn-consent"><i class="fas fa-check-circle"></i> Accept All
          Cookies</button>
        <button id="rejectCookiesBtn" class="btn-consent btn-reject"><i class="fas fa-times-circle"></i> Reject
          Non-Essential</button>
        <div id="consentStatus" class="consent-status"><i class="fas fa-info-circle"></i> Status: Not set</div>
      </div>
    </div>

    <div class="policy-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="250">
      <h2><i class="fas fa-globe"></i> Third-Party Cookies</h2>
      <p>We may also use third-party services (such as Google Analytics, social media platforms, and advertising
        networks) that place cookies on your device. These third parties have their own privacy policies, and we do not
        control their cookie settings. We recommend reviewing their respective policies for more information.</p>
    </div>

    <div class="policy-section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="300">
      <h2><i class="fas fa-hand-peace"></i> Your Consent</h2>
      <p>By continuing to use our website, you consent to the use of cookies as described in this Cookie Policy. You can
        change your preferences at any time using the toggle above or through your browser settings.</p>
    </div>
  </main>

  <!-- H. Scroll Reveal - Footer -->
  <footer class="footer" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50">
    <div class="footer-grid">
      <div class="footer-col">
        <h4>Quick Links 1</h4>
        <a href="PrivacyPolicy.php">Privacy Policy</a>
        <a href="TermsofService.php">Terms of Service</a>
        <a href="FAQ.php">FAQs</a>
        <a href="ShippingInfo.php">Shipping Info</a>
      </div>
      <div class="footer-col">
        <h4>Quick Links 2</h4>
        <a href="AddressBook.php">Address Book</a>
        <a href="Landing.php">Landing</a>
        <a href="Blog.php">Tech Blog</a>
        <a href="ContactUs.php">Contact Us</a>
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

  <!-- Cookie Consent Banner -->
  <div id="cookieBanner" class="cookie-banner">
    <div class="banner-content">
      <div class="banner-text">
        <i class="fas fa-cookie"></i> We use cookies to enhance your experience. By continuing to visit this site, you
        accept our use of cookies.
      </div>
      <div class="banner-buttons">
        <button id="bannerAccept" class="btn-accept"><i class="fas fa-check"></i> Accept</button>
        <button id="bannerReject" class="btn-reject-banner"><i class="fas fa-times"></i> Reject</button>
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

    // Mobile menu toggle
    const hamburger = document.getElementById("hamburgerBtn");
    const mobilePanel = document.getElementById("mobileMenuPanel");
    const overlay = document.getElementById("mobileOverlay");
    function openMobile() { mobilePanel.classList.add("open"); overlay.classList.add("show"); }
    function closeMobile() { mobilePanel.classList.remove("open"); overlay.classList.remove("show"); }
    hamburger?.addEventListener("click", openMobile);
    document.getElementById("closeMobileBtn")?.addEventListener("click", closeMobile);
    overlay?.addEventListener("click", closeMobile);

    // Cookie Consent Management
    let currentConsent = localStorage.getItem("cookieConsent");
    const banner = document.getElementById("cookieBanner");
    const consentStatusDiv = document.getElementById("consentStatus");

    function updateConsentStatusUI() {
      if (currentConsent === "accepted") {
        consentStatusDiv.innerHTML = '<i class="fas fa-check-circle"></i> Status: Cookies Accepted';
        consentStatusDiv.style.background = "#D1FAE5";
        consentStatusDiv.style.color = "#065F46";
      } else if (currentConsent === "rejected") {
        consentStatusDiv.innerHTML = '<i class="fas fa-times-circle"></i> Status: Non-Essential Cookies Rejected';
        consentStatusDiv.style.background = "#FEE2E2";
        consentStatusDiv.style.color = "#DC2626";
      } else {
        consentStatusDiv.innerHTML = '<i class="fas fa-minus-circle"></i> Status: No consent given';
        consentStatusDiv.style.background = "#F3F4F6";
        consentStatusDiv.style.color = "#374151";
      }
    }

    function setConsent(choice) {
      currentConsent = choice;
      localStorage.setItem("cookieConsent", choice);
      updateConsentStatusUI();

      if (banner) {
        banner.classList.add("hidden");
      }

      if (choice === "accepted") {
        console.log("Analytics and marketing cookies enabled (simulated)");
      } else if (choice === "rejected") {
        console.log("Only necessary cookies enabled (simulated)");
      }
    }

    if (currentConsent) {
      if (banner) banner.classList.add("hidden");
      updateConsentStatusUI();
    } else {
      if (banner) banner.classList.remove("hidden");
      updateConsentStatusUI();
    }

    const bannerAccept = document.getElementById("bannerAccept");
    const bannerReject = document.getElementById("bannerReject");

    if (bannerAccept) {
      bannerAccept.addEventListener("click", () => setConsent("accepted"));
    }
    if (bannerReject) {
      bannerReject.addEventListener("click", () => setConsent("rejected"));
    }

    const acceptCookiesBtn = document.getElementById("acceptCookiesBtn");
    const rejectCookiesBtn = document.getElementById("rejectCookiesBtn");

    if (acceptCookiesBtn) {
      acceptCookiesBtn.addEventListener("click", () => setConsent("accepted"));
    }
    if (rejectCookiesBtn) {
      rejectCookiesBtn.addEventListener("click", () => setConsent("rejected"));
    }

    // Back to Top Button
    const backToTopBtn = document.getElementById("backToTop");
    window.addEventListener("scroll", () => {
      if (window.scrollY > 300) {
        backToTopBtn.classList.add("show");
      } else {
        backToTopBtn.classList.remove("show");
      }
    });
    backToTopBtn.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });

    // Smooth scroll for any internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener("click", function (e) {
        const href = this.getAttribute("href");
        if (href !== "#" && href !== "#/") {
          const target = document.querySelector(href);
          if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: "smooth" });
          }
        }
      });
    });

    // Updated Cart icon click handler
    const cartIcon = document.querySelector('.cart-icon');
    if (cartIcon) {
      cartIcon.addEventListener("click", async () => {
        await checkUserSession();
        if (isUserLoggedIn) {
          window.location.href = "Cart.php";
        } else {
          alert("🛒 Please login to manage your cart");
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