<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | About Us</title>
  <!-- Font Awesome 6 (Free Icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Fonts: Inter (same as Logout.php) -->
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap"
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
      /* THEME CHANGE: Logout.php gradient background */
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      scroll-behavior: smooth;
      animation: pageFadeIn 0.5s ease-out;
    }

    @keyframes pageFadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }

    /* ========== THEME: Logout.php Color Scheme ========== */
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

    /* ========== HEADER - THEME MATCH ========== */
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
      object-fit: contain;
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

    .nav-link {
      text-decoration: none;
      font-weight: 500;
      color: var(--text-dark);
      transition: all 0.2s ease;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      gap: 6px;
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 0.5rem 1rem;
      border-radius: 40px;
      position: relative;
    }

    .nav-link i {
      color: var(--text-muted);
    }

    .nav-link:hover {
      background: #eff6ff;
      color: var(--primary);
    }

    .nav-link:hover i {
      color: var(--primary);
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: var(--primary);
      border-radius: 2px;
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }

    .nav-link:hover::after {
      width: 70%;
    }

    .nav-link.active {
      color: var(--primary);
    }

    .nav-link.active::after {
      width: 70%;
      background: var(--primary);
    }

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

    .cart-icon i {
      font-size: 1.1rem;
    }

    .cart-icon:hover {
      background: var(--primary-gradient);
      color: white;
      transform: translateY(-2px);
      border-color: transparent;
    }

    .cart-icon:hover i {
      color: white;
    }

    .cart-count {
      background: var(--danger);
      color: white;
      font-size: 0.7rem;
      font-weight: bold;
      padding: 2px 8px;
      border-radius: 30px;
      margin-left: 4px;
      transition: transform 0.2s ease;
      display: inline-block;
    }

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
      color: var(--text-dark);
      transition: transform 0.2s ease;
    }

    .hamburger:hover {
      color: var(--primary);
      transform: scale(1.05);
    }

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

    .mobile-menu-panel.open {
      left: 0;
    }

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

    .mobile-overlay.show {
      display: block;
    }

    .close-mobile {
      background: none;
      border: none;
      font-size: 1.8rem;
      float: right;
      cursor: pointer;
      color: var(--text-dark);
      transition: transform 0.2s ease;
    }

    .close-mobile:hover {
      transform: scale(1.1);
    }

    /* ========== FOOTER - THEME MATCH ========== */
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
      transition: all 0.2s ease;
    }

    .footer-col a:hover {
      color: var(--primary);
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
      color: var(--text-muted);
      transition: all 0.2s ease;
    }

    .social-icons i:hover {
      color: var(--primary);
      transform: translateY(-3px) scale(1.05);
    }

    .copyright {
      text-align: center;
      margin-top: 2.5rem;
      padding-top: 1rem;
      border-top: 1px solid var(--border-color);
      font-size: 0.8rem;
      color: var(--text-light);
    }

    /* ========== ABOUT PAGE MAIN STYLES (White Cards Theme) ========== */
    .about-container {
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
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    .breadcrumb a:hover {
      text-decoration: underline;
    }

    .breadcrumb span {
      color: rgba(255, 255, 255, 0.9);
    }

    .page-title {
      font-size: 2.6rem;
      font-weight: 700;
      font-family: 'Inter', sans-serif;
      color: white;
      margin-bottom: 2rem;
      letter-spacing: -0.3px;
    }

    .page-title i {
      margin-right: 10px;
    }

    /* Story Section - White Card */
    .story-section {
      display: flex;
      gap: 2.5rem;
      margin-bottom: 3rem;
      flex-wrap: wrap;
      background: var(--card-bg);
      border-radius: 32px;
      padding: 2rem;
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-lg);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .story-section:hover {
      box-shadow: var(--shadow-xl);
      transform: translateY(-4px);
      border-color: var(--primary);
    }

    .story-text {
      flex: 1;
    }

    .story-text h2 {
      font-size: 1.9rem;
      color: var(--text-dark);
      margin-bottom: 1rem;
      font-weight: 700;
    }

    .story-text p {
      line-height: 1.7;
      color: var(--text-muted);
      margin-bottom: 1rem;
    }

    .story-image {
      flex: 1;
      overflow: hidden;
      border-radius: 24px;
    }

    .story-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 24px;
      transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .story-image:hover img {
      transform: scale(1.05);
    }

    /* Mission & Vision Cards - White */
    .mission-vision {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .mv-card {
      background: var(--card-bg);
      border-radius: 28px;
      padding: 2rem;
      text-align: center;
      border: 1px solid var(--border-color);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: var(--shadow-md);
    }

    .mv-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-xl);
      border-color: var(--primary);
    }

    .mv-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
      color: var(--primary);
      transition: transform 0.3s ease;
    }

    .mv-card:hover .mv-icon {
      transform: scale(1.05);
    }

    .mv-card h3 {
      font-size: 1.6rem;
      color: var(--text-dark);
      margin-bottom: 1rem;
      font-weight: 600;
    }

    .mv-card p {
      color: var(--text-muted);
      line-height: 1.6;
    }

    /* Team Section */
    .team-section {
      margin-bottom: 3rem;
    }

    .section-title {
      font-size: 2rem;
      font-weight: 700;
      color: white;
      margin-bottom: 2rem;
      text-align: center;
      position: relative;
    }

    .section-title:after {
      content: '';
      display: block;
      width: 70px;
      height: 3px;
      background: white;
      margin: 0.8rem auto 0;
      border-radius: 3px;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 2rem;
    }

    .team-card {
      background: var(--card-bg);
      border-radius: 28px;
      overflow: hidden;
      text-align: center;
      border: 1px solid var(--border-color);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: var(--shadow-md);
    }

    .team-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-xl);
      border-color: var(--primary);
    }

    .team-card img {
      width: 100%;
      height: 280px;
      object-fit: cover;
      transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .team-card:hover img {
      transform: scale(1.05);
    }

    .team-card-content {
      padding: 1.5rem;
    }

    .team-card h3 {
      font-size: 1.3rem;
      color: var(--text-dark);
      margin-bottom: 0.3rem;
      font-weight: 700;
    }

    .team-position {
      color: var(--primary);
      font-weight: 600;
      margin-bottom: 0.8rem;
      font-size: 0.85rem;
    }

    .team-bio {
      color: var(--text-muted);
      font-size: 0.9rem;
      line-height: 1.5;
    }

    /* Trust Badges - White Card */
    .trust-section {
      margin-bottom: 3rem;
      padding: 2rem;
      background: var(--card-bg);
      border-radius: 32px;
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-md);
    }

    .trust-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      text-align: center;
    }

    .trust-item {
      padding: 1rem;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      border-radius: 20px;
    }

    .trust-item:hover {
      transform: translateY(-4px);
      background: #f8fafc;
      box-shadow: var(--shadow-md);
    }

    .trust-icon {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
      color: var(--primary);
    }

    .trust-item h4 {
      color: var(--text-dark);
      margin-bottom: 0.3rem;
      font-weight: 600;
    }

    .trust-item p {
      color: var(--text-muted);
      font-size: 0.85rem;
    }

    /* Statistics Section - White */
    .stats-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
      padding: 2rem;
      background: var(--card-bg);
      border-radius: 32px;
      border: 1px solid var(--border-color);
      text-align: center;
      box-shadow: var(--shadow-md);
    }

    .stat-card {
      padding: 1rem;
      transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      border-radius: 20px;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      background: #f8fafc;
    }

    .stat-number {
      font-size: 2.8rem;
      font-weight: 800;
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-bottom: 0.5rem;
    }

    .stat-label {
      color: var(--text-muted);
      font-weight: 500;
    }

    /* Contact Information - White Card */
    .contact-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
      padding: 2rem;
      background: var(--card-bg);
      border-radius: 32px;
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-md);
    }

    .contact-card {
      text-align: center;
      padding: 1rem;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      border-radius: 20px;
    }

    .contact-card:hover {
      background: #f8fafc;
      transform: translateY(-5px);
    }

    .contact-icon {
      font-size: 2rem;
      margin-bottom: 0.8rem;
      color: var(--primary);
      transition: transform 0.3s ease;
    }

    .contact-card:hover .contact-icon {
      transform: scale(1.05);
    }

    .contact-card h4 {
      color: var(--text-dark);
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .contact-card p {
      color: var(--text-muted);
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }
    ::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.2);
    }
    ::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.4);
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.6);
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
      font-weight: 600;
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
      filter: brightness(1.05);
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
        font-size: 1.9rem;
      }
      .story-section {
        flex-direction: column;
      }
      .section-title {
        font-size: 1.6rem;
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
        <li class="nav-item"><a href="AboutUs.php" class="nav-link active"><i class="fas fa-info-circle"></i> About Us</a></li>
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

  <div class="about-container">
    <div class="breadcrumb">
      <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>About Us</span>
    </div>
    <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-info-circle"></i> About Global Hardware Hub</h1>

    <div class="story-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="50">
      <div class="story-text">
        <h2>Our Story</h2>
        <p>Founded in 2020, Global Hardware Hub emerged from a simple idea: create the ultimate destination for computer
          hardware enthusiasts, professionals, and gamers. What started as a small community-driven marketplace has
          grown into one of the most trusted platforms for genuine PC components, peripherals, and accessories.</p>
        <p>Our journey began when our founders, passionate PC builders themselves, recognized the need for a reliable
          marketplace where buyers could connect directly with verified vendors offering authentic products at
          competitive prices. Today, Global Hardware Hub serves thousands of customers worldwide, partnering with
          top-tier hardware manufacturers and independent sellers.</p>
        <p>We've facilitated over 50,000 successful transactions, built a community of 200+ trusted vendors, and
          continue to innovate with features like our PC Builder Tool, price comparison engine, and expert-led tech
          tutorials.</p>
      </div>
      <div class="story-image">
        <img src="images/groupPic.jpg" alt="Global Hardware Hub Team">
      </div>
    </div>

    <div class="mission-vision" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="100">
      <div class="mv-card" data-aos="zoom-in" data-aos-duration="500">
        <div class="mv-icon"><i class="fas fa-bullseye"></i></div>
        <h3>Our Mission</h3>
        <p>To democratize access to premium computer hardware by creating a transparent, secure, and user-friendly
          marketplace that connects passionate builders with trusted vendors, while providing expert guidance and
          unparalleled customer support.</p>
      </div>
      <div class="mv-card" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="100">
        <div class="mv-icon"><i class="fas fa-eye"></i></div>
        <h3>Our Vision</h3>
        <p>To become the world's most trusted ecosystem for computer hardware enthusiasts, where innovation meets
          reliability, and every builder can bring their dream configuration to life without compromise.</p>
      </div>
    </div>

    <div class="team-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="150">
      <h2 class="section-title">Meet Our Leadership</h2>
      <div class="team-grid">
        <div class="team-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="50"><img src="Sarah.jpg" alt="Sarah Johnson">
          <div class="team-card-content">
            <h3>Sarah Johnson</h3>
            <div class="team-position">CEO & Co-Founder</div>
            <div class="team-bio">20+ years in tech retail, former hardware engineer at Intel. Passionate about building
              accessible tech ecosystems.</div>
          </div>
        </div>
        <div class="team-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="100"><img src="micheal.jpg" alt="Michael Chen">
          <div class="team-card-content">
            <h3>Michael Chen</h3>
            <div class="team-position">CTO & Co-Founder</div>
            <div class="team-bio">Full-stack architect and PC modding enthusiast. Leads platform innovation and vendor
              integration.</div>
          </div>
        </div>
        <div class="team-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="150"><img src="alex.jpg" alt="David Rodriguez">
          <div class="team-card-content">
            <h3>David Rodriguez</h3>
            <div class="team-position">Head of Vendor Relations</div>
            <div class="team-bio">Former distribution manager, ensures quality partnerships and authentic product
              sourcing.</div>
          </div>
        </div>
        <div class="team-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="200"><img src="elena.jpg" alt="Emily Wong">
          <div class="team-card-content">
            <h3>Emily Wong</h3>
            <div class="team-position">Customer Experience Director</div>
            <div class="team-bio">Advocate for user-centric design and support excellence. PC builder and content
              creator.</div>
          </div>
        </div>
      </div>
    </div>

    <div class="trust-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="200">
      <div class="trust-grid">
        <div class="trust-item" data-aos="fade-right" data-aos-duration="400" data-aos-delay="50">
          <div class="trust-icon"><i class="fas fa-lock"></i></div>
          <h4>Secure Payments</h4>
          <p>256-bit SSL encryption</p>
        </div>
        <div class="trust-item" data-aos="fade-up" data-aos-duration="400" data-aos-delay="100">
          <div class="trust-icon"><i class="fas fa-file-alt"></i></div>
          <h4>Warranty Available</h4>
          <p>Manufacturer backed</p>
        </div>
        <div class="trust-item" data-aos="fade-up" data-aos-duration="400" data-aos-delay="150">
          <div class="trust-icon"><i class="fas fa-check-circle"></i></div>
          <h4>Authentic Products</h4>
          <p>100% genuine hardware</p>
        </div>
        <div class="trust-item" data-aos="fade-left" data-aos-duration="400" data-aos-delay="200">
          <div class="trust-icon"><i class="fas fa-truck-fast"></i></div>
          <h4>Fast Delivery</h4>
          <p>Free shipping over $99</p>
        </div>
      </div>
    </div>

    <div class="stats-section" id="statsSection" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="250">
      <div class="stat-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="50">
        <div class="stat-number" id="vendorsCount">0</div>
        <div class="stat-label">Trusted Vendors</div>
      </div>
      <div class="stat-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="100">
        <div class="stat-number" id="productsCount">0</div>
        <div class="stat-label">Total Products</div>
      </div>
      <div class="stat-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="150">
        <div class="stat-number" id="customersCount">0</div>
        <div class="stat-label">Customers Served</div>
      </div>
      <div class="stat-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="200">
        <div class="stat-number" id="ordersCount">0</div>
        <div class="stat-label">Orders Completed</div>
      </div>
    </div>

    <div class="contact-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="300">
      <div class="contact-card" data-aos="fade-right" data-aos-duration="400" data-aos-delay="50">
        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
        <h4>Email Us</h4>
        <p>support@GlobalHardwareHub.com</p>
        <p>vendors@GlobalHardwareHub.com</p>
      </div>
      <div class="contact-card" data-aos="fade-up" data-aos-duration="400" data-aos-delay="100">
        <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
        <h4>Call Us</h4>
        <p>+1 (888) 776-8899</p>
        <p>Mon-Fri, 9am-6pm EST</p>
      </div>
      <div class="contact-card" data-aos="fade-up" data-aos-duration="400" data-aos-delay="150">
        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
        <h4>Visit Us</h4>
        <p>123 Tech Hub Boulevard</p>
        <p>Silicon Valley, CA 94025</p>
      </div>
      <div class="contact-card" data-aos="fade-left" data-aos-duration="400" data-aos-delay="200">
        <div class="contact-icon"><i class="fas fa-clock"></i></div>
        <h4>Business Hours</h4>
        <p>Monday - Friday: 9am - 6pm</p>
        <p>Saturday: 10am - 4pm</p>
      </div>
    </div>
  </div>

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
        <a href="Landing.php">Landing</a>
        <a href="ShippingInfo.php">Shipping Info</a>
        <a href="WarrantyInfo.php">Warranty Info</a>
        <a href="PaymentMethods.php">Payment Methods</a>
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
    AOS.init({
      duration: 600,
      once: true,
      offset: 80,
      disable: 'mobile'
    });

    let isUserLoggedIn = false;
    let isCustomerRole = false;
    let currentUserId = null;

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

    document.querySelector('.cart-icon')?.addEventListener('click', async () => {
      await checkUserSession();
      if (!isUserLoggedIn) {
        alert('Please login to manage your cart');
        window.location.href = "LogIn.php";
      } else {
        window.location.href = "Cart.php";
      }
    });

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
        { title: "Blog", link: "Blog.php" }, { title: "Blog Details", link: "BlogDetails.php" }
      ];
      let html = `<div style="margin-top:1rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%; background:linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color:white; border:none;">${logged ? "<i class='fas fa-sign-out-alt'></i> Logout" : "<i class='fas fa-sign-in-alt'></i> Login"}</button></div><hr style="margin:1rem 0; border-color:#e2e8f0;">`;
      menuItems.forEach(item => {
        if (item.submenu) {
          html += `<div class="mobile-nav-item"><div class="mobile-nav-header" data-toggle="${item.title}" style="display:flex;justify-content:space-between;padding:0.8rem 0; color:var(--text-dark); cursor:pointer;"><span>${item.title}</span> <i class="fas fa-chevron-down"></i></div><div class="mobile-submenu" id="submenu-${item.title}" style="padding-left:1rem;display:none;">`;
          item.submenu.forEach((sub, idx) => html += `<a href="${item.links[idx]}" style="display:block; padding:0.6rem 0; color:var(--text-muted); text-decoration:none;">${sub}</a>`);
          html += `</div></div>`;
        } else html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0; color:var(--text-dark); text-decoration:none;">${item.title}</a></div>`;
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

    function animateCounter(elementId, targetValue, duration = 2000) {
      const element = document.getElementById(elementId);
      if (!element) return;
      let startTime = null;
      function animation(currentTime) {
        if (!startTime) startTime = currentTime;
        const progress = Math.min((currentTime - startTime) / duration, 1);
        element.textContent = Math.floor(progress * targetValue).toLocaleString();
        if (progress < 1) requestAnimationFrame(animation);
        else element.textContent = targetValue.toLocaleString();
      }
      requestAnimationFrame(animation);
    }

    const statsSection = document.getElementById('statsSection');
    let animated = false;
    function checkAndAnimate() {
      if (animated || !statsSection) return;
      const rect = statsSection.getBoundingClientRect();
      if (rect.top < window.innerHeight - 100 && rect.bottom > 0) {
        animated = true;
        animateCounter('vendorsCount', 248, 1800);
        animateCounter('productsCount', 8750, 2000);
        animateCounter('customersCount', 28450, 2200);
        animateCounter('ordersCount', 52180, 2400);
      }
    }
    window.addEventListener('scroll', checkAndAnimate);
    window.addEventListener('load', checkAndAnimate);

    const backToTopBtn = document.getElementById("backToTop");
    window.addEventListener("scroll", () => backToTopBtn.classList.toggle("show", window.scrollY > 300));
    backToTopBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

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