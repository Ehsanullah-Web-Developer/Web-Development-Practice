<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | Blog Post</title>
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Fonts: Inter (same as Logout.php) -->
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
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

    /* Header - White Theme */
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
      cursor: pointer;
      padding: 0.5rem 1rem;
      border-radius: 40px;
      position: relative;
    }

    .nav-link i {
      color: var(--text-muted);
    }

    .nav-link:hover,
    .nav-link.active {
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

    /* Footer - White Theme */
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

    /* Blog Container */
    .blog-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem 1.5rem;
    }

    .breadcrumb {
      margin-bottom: 1rem;
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

    .featured-image {
      width: 100%;
      border-radius: 32px;
      margin-bottom: 1.5rem;
      overflow: hidden;
      box-shadow: var(--shadow-md);
    }

    .featured-image img {
      width: 100%;
      height: auto;
      object-fit: cover;
      transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .featured-image:hover img {
      transform: scale(1.05);
    }

    .post-title {
      font-size: 2.4rem;
      font-weight: 700;
      font-family: 'Inter', sans-serif;
      color: white;
      margin-bottom: 0.5rem;
      letter-spacing: -0.3px;
    }

    .post-meta {
      display: flex;
      gap: 1.5rem;
      color: rgba(255, 255, 255, 0.8);
      font-size: 0.85rem;
      margin-bottom: 1rem;
      flex-wrap: wrap;
    }

    .post-meta i {
      margin-right: 4px;
      color: rgba(255, 255, 255, 0.9);
    }

    .post-category {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255, 255, 255, 0.2);
      color: white;
      font-size: 0.8rem;
      font-weight: 600;
      padding: 0.3rem 1.2rem;
      border-radius: 40px;
      margin-bottom: 1rem;
    }

    .post-content {
      line-height: 1.8;
      color: var(--text-dark);
      background: var(--card-bg);
      padding: 2rem;
      border-radius: 32px;
      margin: 1.5rem 0;
      box-shadow: var(--shadow-md);
    }

    .post-content p {
      margin-bottom: 1rem;
    }

    .post-content h2 {
      font-size: 1.6rem;
      margin: 1.5rem 0 1rem;
      color: var(--text-dark);
    }

    .post-content h3 {
      font-size: 1.3rem;
      margin: 1.2rem 0 0.8rem;
      color: var(--text-dark);
    }

    .post-content ul {
      margin: 1rem 0 1rem 2rem;
    }

    /* Social Share */
    .social-share {
      margin: 2rem 0;
      padding: 1rem 0;
      border-top: 1px solid var(--border-color);
      border-bottom: 1px solid var(--border-color);
    }

    .share-title {
      font-weight: 600;
      margin-bottom: 0.8rem;
      color: var(--text-dark);
      background: var(--card-bg);
      display: inline-block;
      padding: 0.3rem 1rem;
      border-radius: 40px;
    }

    .share-buttons {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .share-btn {
      padding: 0.5rem 1.3rem;
      border-radius: 60px;
      border: none;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .share-btn:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-md);
    }

    .share-fb {
      background: #1877f2;
      color: white;
    }

    .share-twitter {
      background: #1da1f2;
      color: white;
    }

    .share-linkedin {
      background: #0077b5;
      color: white;
    }

    .share-copy {
      background: #f1f5f9;
      color: var(--text-muted);
    }

    /* Comments Section - White Card */
    .comments-section {
      margin: 3rem 0;
      padding: 1.8rem;
      background: var(--card-bg);
      border-radius: 32px;
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-md);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .comments-section:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
      border-color: var(--primary);
    }

    .comments-section h3 {
      font-size: 1.4rem;
      color: var(--text-dark);
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .comment-form {
      margin-bottom: 2rem;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group textarea {
      width: 100%;
      padding: 1rem;
      border: 1.5px solid var(--border-color);
      border-radius: 20px;
      font-size: 0.9rem;
      font-family: inherit;
      transition: all 0.2s ease;
      resize: vertical;
      background: var(--card-bg-light);
      color: var(--text-dark);
    }

    .form-group textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-group textarea::placeholder {
      color: var(--text-light);
    }

    .submit-comment {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 0.7rem 1.8rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .submit-comment:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
      filter: brightness(1.05);
    }

    .comments-list {
      margin-top: 2rem;
    }

    .comment {
      padding: 1rem;
      border-bottom: 1px solid var(--border-color);
      margin-bottom: 1rem;
      transition: all 0.2s ease;
    }

    .comment:hover {
      background: var(--card-bg-light);
      border-radius: 20px;
      transform: translateX(4px);
    }

    .comment:last-child {
      border-bottom: none;
    }

    .comment-author {
      font-weight: 600;
      color: var(--primary);
    }

    .comment-date {
      font-size: 0.7rem;
      color: var(--text-light);
      margin-left: 0.5rem;
    }

    .comment-text {
      margin: 0.5rem 0;
      color: var(--text-muted);
      line-height: 1.5;
    }

    /* Not Found */
    .not-found {
      text-align: center;
      padding: 3rem;
      background: var(--card-bg);
      border-radius: 32px;
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-md);
    }

    .not-found h2 {
      color: var(--text-dark);
      margin: 1rem 0;
    }

    .not-found p {
      color: var(--text-muted);
    }

    /* Loading Spinner */
    .loading-spinner {
      text-align: center;
      padding: 3rem;
      color: var(--primary);
      font-size: 1.1rem;
      background: var(--card-bg);
      border-radius: 32px;
    }

    .loading-spinner i {
      margin-right: 8px;
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
      transform: translateY(-3px);
      filter: brightness(1.05);
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
        transform: translateX(-50%) translateY(0);
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
      .post-title {
        font-size: 1.8rem;
      }
      .share-buttons {
        flex-direction: column;
      }
      .share-btn {
        justify-content: center;
      }
      .comments-section {
        padding: 1.2rem;
      }
      .post-content {
        padding: 1.2rem;
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
        <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
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

  <div class="blog-container" id="blogContent">
    <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading blog post...</div>
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
        <a href="Products1.php">Products</a>
        <a href="Blog.php">Tech Blog</a>
        <a href="PrivacyPolicy.php">Privacy Policy</a>
        <a href="ResetPassword.php">Reset Password</a>
      </div>
      <div class="footer-col">
        <h4>Contact</h4>
        <p><i class="fas fa-phone-alt"></i> 03267322096</p>
        <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
        <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
        <div class="social-icons">
          <i class="fab fa-facebook-f"></i>
          <i class="fab fa-twitter"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-youtube"></i>
        </div>
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

  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
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
      let html = `<div style="margin-top:2rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%; background:linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color:white; border:none;">${logged ? "<i class='fas fa-sign-out-alt'></i> Logout" : "<i class='fas fa-sign-in-alt'></i> Login"}</button></div><hr style="margin:1rem 0; border-color:#e2e8f0;">`;
      menuItems.forEach(item => {
        if (item.submenu) {
          html += `<div class="mobile-nav-item"><div class="mobile-nav-header" data-toggle="${item.title}" style="display:flex; justify-content:space-between; padding:0.8rem 0; color:var(--text-dark); cursor:pointer;"><span>${item.title}</span> <i class="fas fa-chevron-down"></i></div><div class="mobile-submenu" id="submenu-${item.title}" style="padding-left:1rem; display:none;">`;
          item.submenu.forEach((sub, idx) => { html += `<a href="${item.links[idx]}" style="display:block; padding:0.6rem 0; color:var(--text-muted); text-decoration:none;">${sub}</a>`; });
          html += `</div></div>`;
        } else {
          html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0; color:var(--text-dark); text-decoration:none;">${item.title}</a></div>`;
        }
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

    document.querySelector('.cart-icon')?.addEventListener('click', async () => {
      await checkUserSession();
      if (!isUserLoggedIn) {
        alert('Please login to manage your cart');
        window.location.href = "LogIn.php";
      } else {
        window.location.href = "Cart.php";
      }
    });

    // ============== GLOBAL VARIABLES ==============
    let currentPost = null;
    let currentPostId = null;

    function escapeHtml(str) {
      if (!str) return '';
      return str.replace(/[&<>]/g, function (m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
      });
    }

    function formatDate(dateString) {
      if (!dateString) return "Unknown date";
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }

    function showToast(message, isError = false) {
      const toast = document.createElement('div');
      toast.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
      toast.style.cssText = `
      position: fixed;
      bottom: 80px;
      left: 50%;
      transform: translateX(-50%);
      background: ${isError ? '#dc2626' : '#10b981'};
      color: white;
      padding: 12px 24px;
      border-radius: 60px;
      z-index: 10001;
      font-size: 14px;
      animation: fadeInOut 3s ease;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      font-weight: 500;
    `;
      document.body.appendChild(toast);
      setTimeout(() => toast.remove(), 3000);
    }

    function getPostIdFromURL() {
      const urlParams = new URLSearchParams(window.location.search);
      let id = urlParams.get('id');
      if (id) return parseInt(id);
      const slug = urlParams.get('slug');
      if (slug) return slug;
      return null;
    }

    async function fetchBlogDetails() {
      const postId = getPostIdFromURL();

      if (!postId) {
        document.getElementById("blogContent").innerHTML = `
        <div class="not-found">
          <div style="font-size: 3rem;"><i class="fas fa-search"></i></div>
          <h2>No Post Selected</h2>
          <p>Please select a blog post to read.</p>
          <a href="Blog.php"><button class="submit-comment" style="margin-top:1rem;"><i class="fas fa-arrow-left"></i> Back to Blog</button></a>
        </div>
      `;
        return null;
      }

      try {
        let url;
        if (typeof postId === 'number') {
          url = `get_blog_details.php?id=${postId}`;
        } else {
          url = `get_blog_details.php?slug=${encodeURIComponent(postId)}`;
        }

        const response = await fetch(url);
        const result = await response.json();

        if (result.success && result.data) {
          currentPost = result.data;
          currentPostId = currentPost.post_id;
          return currentPost;
        } else {
          document.getElementById("blogContent").innerHTML = `
          <div class="not-found">
            <div style="font-size: 3rem;"><i class="fas fa-file-alt"></i></div>
            <h2>Post Not Found</h2>
            <p>The blog post you're looking for doesn't exist or has been removed.</p>
            <a href="Blog.php"><button class="submit-comment" style="margin-top:1rem;"><i class="fas fa-arrow-left"></i> Back to Blog</button></a>
          </div>
        `;
          return null;
        }
      } catch (error) {
        console.error("Error fetching blog details:", error);
        document.getElementById("blogContent").innerHTML = `
        <div class="not-found">
          <div style="font-size: 3rem;"><i class="fas fa-wifi"></i></div>
          <h2>Connection Error</h2>
          <p>Failed to load blog post. Please refresh the page.</p>
          <a href="Blog.php"><button class="submit-comment" style="margin-top:1rem;"><i class="fas fa-arrow-left"></i> Back to Blog</button></a>
        </div>
      `;
        return null;
      }
    }

    async function fetchComments(postId) {
      if (!postId) return [];

      try {
        const response = await fetch(`get_blog_comments.php?post_id=${postId}`);
        const result = await response.json();

        if (result.success && result.data) {
          return result.data;
        }
        return [];
      } catch (error) {
        console.error("Error fetching comments:", error);
        return [];
      }
    }

    async function addComment(postId, comment) {
      await checkUserSession();
      
      if (!isUserLoggedIn) {
        showToast("Please login to post a comment", true);
        setTimeout(() => {
          window.location.href = "LogIn.php";
        }, 1500);
        return false;
      }

      if (!comment || comment.trim() === "") {
        showToast("Please enter a comment", true);
        return false;
      }

      const formData = new FormData();
      formData.append('post_id', postId);
      formData.append('comment', comment);

      try {
        const response = await fetch('add_blog_comment.php', {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.success) {
          showToast(result.message);
          return true;
        } else {
          showToast(result.message, true);
          return false;
        }
      } catch (error) {
        console.error("Error adding comment:", error);
        showToast("Connection error. Please try again.", true);
        return false;
      }
    }

    function renderComments(comments, containerId) {
      const container = document.getElementById(containerId);
      if (!container) return;

      if (!comments || comments.length === 0) {
        container.innerHTML = '<p style="color:var(--text-muted); text-align:center;"><i class="fas fa-comments"></i> No comments yet. Be the first to comment!</p>';
        return;
      }

      container.innerHTML = comments.map((comment, index) => `
      <div class="comment" data-aos="fade-up" data-aos-duration="400" data-aos-delay="${index * 50}">
        <div>
          <span class="comment-author"><i class="fas fa-user-circle"></i> ${escapeHtml(comment.user_name)}</span>
          <span class="comment-date"><i class="fas fa-calendar-alt"></i> ${formatDate(comment.created_at)}</span>
        </div>
        <div class="comment-text">${escapeHtml(comment.comment)}</div>
      </div>
    `).join('');
      
      AOS.refresh();
    }

    async function renderPage() {
      const container = document.getElementById("blogContent");

      const post = await fetchBlogDetails();
      if (!post) return;

      const comments = await fetchComments(post.post_id);

      const wordCount = post.content ? post.content.replace(/<[^>]*>/g, '').split(/\s+/).length : 0;
      const readTime = Math.max(1, Math.ceil(wordCount / 200));

      container.innerHTML = `
      <div class="breadcrumb" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30">
        <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="Blog.php"><i class="fas fa-blog"></i> Blog</a> / <span>${escapeHtml(post.title)}</span>
      </div>
      
      <div class="featured-image" data-aos="zoom-in" data-aos-duration="600" data-aos-offset="50">
        <img src="${post.image_url || 'https://placehold.co/1200x600/667eea/ffffff?text=Blog+Post'}" alt="${escapeHtml(post.title)}" onerror="this.src='https://placehold.co/1200x600/667eea/ffffff?text=Blog'">
      </div>
      
      <div data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="50">
        <span class="post-category"><i class="fas fa-tag"></i> Blog Post</span>
        <h1 class="post-title">${escapeHtml(post.title)}</h1>
        <div class="post-meta">
          <span><i class="fas fa-user"></i> ${escapeHtml(post.author_name)}</span>
          <span><i class="fas fa-calendar-alt"></i> ${formatDate(post.created_at)}</span>
          <span><i class="fas fa-clock"></i> ${readTime} min read</span>
        </div>
      </div>
      
      <div class="post-content" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="100">
        ${post.content}
      </div>
      
      <div class="social-share" data-aos="fade-up" data-aos-duration="500" data-aos-offset="30" data-aos-delay="150">
        <div class="share-title"><i class="fas fa-share-alt"></i> Share this article:</div>
        <div class="share-buttons">
          <button class="share-btn share-fb" onclick="shareOnFacebook()"><i class="fab fa-facebook-f"></i> Facebook</button>
          <button class="share-btn share-twitter" onclick="shareOnTwitter()"><i class="fab fa-twitter"></i> Twitter</button>
          <button class="share-btn share-linkedin" onclick="shareOnLinkedIn()"><i class="fab fa-linkedin-in"></i> LinkedIn</button>
          <button class="share-btn share-copy" onclick="copyLink()"><i class="fas fa-link"></i> Copy Link</button>
        </div>
      </div>
      
      <div class="comments-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="200">
        <h3><i class="fas fa-comments"></i> Comments (${comments.length})</h3>
        <div class="comment-form">
          <div class="form-group">
            <textarea id="commentText" rows="3" placeholder="Share your thoughts..."></textarea>
          </div>
          <button class="submit-comment" id="submitCommentBtn"><i class="fas fa-paper-plane"></i> Post Comment</button>
        </div>
        <div class="comments-list" id="commentsList"></div>
      </div>
    `;

      renderComments(comments, "commentsList");

      document.getElementById("submitCommentBtn")?.addEventListener("click", async () => {
        const commentText = document.getElementById("commentText")?.value.trim();
        if (await addComment(post.post_id, commentText)) {
          document.getElementById("commentText").value = "";
          const newComments = await fetchComments(post.post_id);
          renderComments(newComments, "commentsList");
          const commentHeader = document.querySelector(".comments-section h3");
          if (commentHeader) {
            commentHeader.innerHTML = `<i class="fas fa-comments"></i> Comments (${newComments.length})`;
          }
        }
      });
    }

    function shareOnFacebook() {
      window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.href)}`, '_blank');
    }

    function shareOnTwitter() {
      window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(currentPost?.title || 'Check this out')}&url=${encodeURIComponent(window.location.href)}`, '_blank');
    }

    function shareOnLinkedIn() {
      window.open(`https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(window.location.href)}&title=${encodeURIComponent(currentPost?.title || '')}`, '_blank');
    }

    function copyLink() {
      navigator.clipboard.writeText(window.location.href);
      showToast("Link copied to clipboard!");
    }

    const backBtn = document.getElementById("backToTop");
    window.addEventListener("scroll", () => {
      if (window.scrollY > 300) backBtn.classList.add("show");
      else backBtn.classList.remove("show");
    });
    backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

    window.shareOnFacebook = shareOnFacebook;
    window.shareOnTwitter = shareOnTwitter;
    window.shareOnLinkedIn = shareOnLinkedIn;
    window.copyLink = copyLink;

    async function init() {
      await checkUserSession();
      setAuthUI();
      renderMobileMenu();
      await updateCartCount();
      renderPage();
    }
    
    init();
  </script>
</body>

</html>