<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | Tech Blog</title>
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

    /* Blog Layout */
    .blog-layout {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .blog-main {
      flex: 3;
      min-width: 0;
    }

    .blog-sidebar {
      flex: 1;
      min-width: 280px;
    }

    /* Search & Filter - White Theme */
    .search-filter {
      margin-bottom: 2rem;
    }

    .search-box {
      display: flex;
      gap: 0.8rem;
      margin-bottom: 1.5rem;
    }

    .search-box input {
      flex: 1;
      padding: 0.9rem 1.3rem;
      border: 1.5px solid var(--border-color);
      border-radius: 60px;
      font-size: 0.95rem;
      outline: none;
      transition: all 0.2s ease;
      background: var(--card-bg);
      font-family: inherit;
      color: var(--text-dark);
    }

    .search-box input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .search-box input::placeholder {
      color: var(--text-light);
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
      transform: translateY(-2px);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
      filter: brightness(1.05);
    }

    /* --- NEW REFRESH BUTTON STYLES --- */
    .refresh-btn {
      background: #f1f5f9;
      color: var(--text-dark);
      border: 1px solid var(--border-color);
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

    .filter-tabs {
      display: flex;
      flex-wrap: wrap;
      gap: 0.8rem;
      margin-bottom: 1.5rem;
    }

    .filter-btn {
      background: var(--card-bg);
      border: 1px solid var(--border-color);
      padding: 0.6rem 1.4rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 500;
      color: var(--text-muted);
      transition: all 0.25s ease;
      font-size: 0.9rem;
    }

    .filter-btn:hover {
      background: #f1f5f9;
      color: var(--primary);
      transform: translateY(-2px);
    }

    .filter-btn.active {
      background: var(--primary-gradient);
      color: white;
      border-color: transparent;
      box-shadow: var(--shadow-sm);
    }

    /* Blog Grid */
    .blog-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 2rem;
      margin-bottom: 2rem;
    }

    /* Blog Cards - White Theme */
    .blog-card {
      background: var(--card-bg);
      border-radius: 28px;
      overflow: hidden;
      border: 1px solid var(--border-color);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      cursor: pointer;
      box-shadow: var(--shadow-md);
    }

    .blog-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-xl);
      border-color: var(--primary);
    }

    .blog-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .blog-card:hover img {
      transform: scale(1.05);
    }

    .blog-card-content {
      padding: 1.5rem;
    }

    .blog-category {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: #eff6ff;
      color: var(--primary);
      font-size: 0.7rem;
      font-weight: 600;
      padding: 0.25rem 0.8rem;
      border-radius: 40px;
      margin-bottom: 0.8rem;
    }

    .blog-card h3 {
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: var(--text-dark);
      line-height: 1.4;
    }

    .blog-meta {
      display: flex;
      gap: 1rem;
      font-size: 0.75rem;
      color: var(--text-light);
      margin-bottom: 0.8rem;
    }

    .blog-excerpt {
      color: var(--text-muted);
      line-height: 1.6;
      margin-bottom: 1rem;
      font-size: 0.85rem;
    }

    .read-more {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.85rem;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.25s ease;
    }

    .read-more:hover {
      gap: 10px;
      color: var(--primary-dark);
    }

    /* Pagination - White Theme */
    .pagination {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.8rem;
      flex-wrap: wrap;
      margin-top: 2rem;
    }

    .page-btn {
      background: var(--card-bg);
      border: 1px solid var(--border-color);
      padding: 0.6rem 1.2rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.25s ease;
      color: var(--text-muted);
    }

    .page-btn:hover {
      background: #f1f5f9;
      color: var(--primary);
      transform: translateY(-2px);
    }

    .page-btn.active {
      background: var(--primary-gradient);
      color: white;
      border-color: transparent;
    }

    .page-btn:disabled {
      opacity: 0.5;
      cursor: not-allowed;
      transform: none;
    }

    /* Sidebar Widgets - White Theme */
    .sidebar-widget {
      background: var(--card-bg);
      border-radius: 28px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-md);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .sidebar-widget:hover {
      box-shadow: var(--shadow-lg);
      transform: translateY(-4px);
      border-color: var(--primary);
    }

    .sidebar-widget h3 {
      margin-bottom: 1rem;
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--text-dark);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .category-list {
      list-style: none;
    }

    .category-list li {
      padding: 0.6rem 0;
      cursor: pointer;
      color: var(--text-muted);
      transition: all 0.25s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      border-bottom: 1px solid var(--border-color);
    }

    .category-list li:last-child {
      border-bottom: none;
    }

    .category-list li:hover {
      color: var(--primary);
      transform: translateX(8px);
    }

    .tag-cloud {
      display: flex;
      flex-wrap: wrap;
      gap: 0.6rem;
    }

    .tag {
      background: #f1f5f9;
      padding: 0.35rem 1rem;
      border-radius: 60px;
      font-size: 0.75rem;
      color: var(--text-muted);
      transition: all 0.25s ease;
      cursor: pointer;
    }

    .tag:hover {
      background: var(--primary-gradient);
      color: white;
      transform: translateY(-2px);
    }

    /* Loading Spinner */
    .loading-spinner {
      text-align: center;
      padding: 3rem;
      color: var(--primary);
      font-size: 1rem;
      grid-column: 1 / -1;
      background: var(--card-bg);
      border-radius: 28px;
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
      .blog-layout {
        flex-direction: column;
      }
      .blog-grid {
        grid-template-columns: 1fr;
      }
      .page-title {
        font-size: 1.9rem;
      }
      .search-box {
        flex-direction: column;
      }
      .search-box button {
        padding: 0.8rem;
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

  <div class="blog-container">
    <div class="breadcrumb">
      <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Blog</span>
    </div>
    <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-pen-fancy"></i> Tech Blog</h1>

    <div class="blog-layout">
      <div class="blog-main">
        <div class="search-filter">
          <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search articles by title or content...">
            <button id="searchBtn"><i class="fas fa-search"></i> Search</button>
            <!-- NEW REFRESH BUTTON ADDED HERE -->
            <button id="refreshBtn" class="refresh-btn"><i class="fas fa-sync-alt"></i> Refresh</button>
          </div>
          <div class="filter-tabs" id="filterTabs">
            <button class="filter-btn active" data-category="all">All Posts</button>
            <button class="filter-btn" data-category="News"><i class="fas fa-newspaper"></i> News</button>
            <button class="filter-btn" data-category="Tutorials"><i class="fas fa-graduation-cap"></i>
              Tutorials</button>
            <button class="filter-btn" data-category="Product Reviews"><i class="fas fa-star"></i> Product
              Reviews</button>
            <button class="filter-btn" data-category="Announcement"><i class="fas fa-bullhorn"></i>
              Announcement</button>
          </div>
        </div>

        <div id="blogGrid" class="blog-grid">
          <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading blog posts...</div>
        </div>
        <div id="pagination" class="pagination"></div>
      </div>

      <aside class="blog-sidebar">
        <div class="sidebar-widget" data-aos="fade-left" data-aos-duration="500" data-aos-offset="50" data-aos-delay="50">
          <h3><i class="fas fa-folder-open"></i> Categories</h3>
          <ul class="category-list" id="categoryList">
            <li data-cat="all"><i class="fas fa-circle" style="font-size: 0.4rem;"></i> All Posts</li>
            <li data-cat="News"><i class="fas fa-newspaper"></i> News</li>
            <li data-cat="Tutorials"><i class="fas fa-graduation-cap"></i> Tutorials</li>
            <li data-cat="Product Reviews"><i class="fas fa-star"></i> Product Reviews</li>
            <li data-cat="Announcement"><i class="fas fa-bullhorn"></i> Announcement</li>
          </ul>
        </div>
        <div class="sidebar-widget" data-aos="fade-left" data-aos-duration="500" data-aos-offset="50" data-aos-delay="100">
          <h3><i class="fas fa-tags"></i> Popular Tags</h3>
          <div class="tag-cloud">
            <span class="tag">#PCBuilding</span>
            <span class="tag">#GPU</span>
            <span class="tag">#CPU</span>
            <span class="tag">#Gaming</span>
            <span class="tag">#RAM</span>
            <span class="tag">#Motherboard</span>
          </div>
        </div>
      </aside>
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
        <a href="PrivacyPolicy.php">Privacy Policy</a>
        <a href="TermsofService.php">Terms of Service</a>
        <a href="FAQ.php">FAQs</a>
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

    const cartIcon = document.querySelector('.cart-icon');
    if (cartIcon) {
      cartIcon.addEventListener('click', async () => {
        await checkUserSession();
        if (!isUserLoggedIn) {
          alert('Please login to manage your cart');
          window.location.href = "LogIn.php";
        } else {
          window.location.href = "Cart.php";
        }
      });
    }

    // ============== DYNAMIC BLOG POSTS FROM BACKEND ==============
    let blogPosts = [];
    let currentCategory = "all";
    let currentSearch = "";
    let currentPage = 1;
    const postsPerPage = 6;

    function formatDate(dateString) {
      if (!dateString) return "Unknown date";
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    }

    function getExcerpt(content, maxLength = 120) {
      if (!content) return "";
      const plainText = content.replace(/<[^>]*>/g, '');
      if (plainText.length <= maxLength) return plainText;
      return plainText.substring(0, maxLength) + "...";
    }

    function getCategoryFromPost(post) {
      if (post.category) return post.category;
      const content = (post.title + " " + post.content).toLowerCase();
      if (content.includes("review")) return "Product Reviews";
      if (content.includes("tutorial") || content.includes("guide") || content.includes("how to")) return "Tutorials";
      if (content.includes("announce") || content.includes("launch")) return "Announcement";
      if (content.includes("news")) return "News";
      return "General";
    }

    async function fetchBlogPosts() {
      const grid = document.getElementById("blogGrid");
      grid.innerHTML = '<div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading blog posts...</div>';

      try {
        const response = await fetch('get_blog_posts.php');
        const result = await response.json();

        if (result.success && result.data) {
          blogPosts = result.data.map(post => ({
            id: post.post_id,
            title: post.title,
            slug: post.slug,
            content: post.content,
            excerpt: getExcerpt(post.content),
            image: post.image_url || "https://placehold.co/600x400/667eea/ffffff?text=Blog+Post",
            author: post.author_name,
            date: formatDate(post.created_at),
            category: post.category || getCategoryFromPost(post)
          }));

          renderPosts();
        } else {
          console.error("API Error:", result.message);
          grid.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-exclamation-circle"></i> Failed to load blog posts. Please try again later.</div>';
        }

      } catch (error) {
        console.error("Fetch error:", error);
        grid.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-wifi"></i> Connection error. Please refresh the page.</div>';
      }
    }

    function filterPosts() {
      let filtered = [...blogPosts];
      if (currentCategory !== "all") {
        filtered = filtered.filter(post => post.category === currentCategory);
      }
      if (currentSearch.trim() !== "") {
        const searchLower = currentSearch.toLowerCase();
        filtered = filtered.filter(post =>
          post.title.toLowerCase().includes(searchLower) ||
          post.excerpt.toLowerCase().includes(searchLower) ||
          (post.content && post.content.toLowerCase().includes(searchLower))
        );
      }
      return filtered;
    }

    function renderPosts() {
      const filtered = filterPosts();
      const totalPages = Math.ceil(filtered.length / postsPerPage);
      const startIndex = (currentPage - 1) * postsPerPage;
      const postsToShow = filtered.slice(startIndex, startIndex + postsPerPage);

      const grid = document.getElementById("blogGrid");
      if (postsToShow.length === 0) {
        grid.innerHTML = `<div style="text-align: center; padding: 3rem; color: var(--text-muted); background: var(--card-bg); border-radius: 28px;"><i class="fas fa-search"></i> No posts found matching your criteria.</div>`;
      } else {
        grid.innerHTML = postsToShow.map((post, index) => `
        <div class="blog-card" data-aos="fade-up" data-aos-duration="400" data-aos-delay="${index * 50}">
          <img src="${escapeHtml(post.image)}" alt="${escapeHtml(post.title)}" onerror="this.src='https://placehold.co/600x400/667eea/ffffff?text=Blog'">
          <div class="blog-card-content">
            <span class="blog-category"><i class="fas fa-tag"></i> ${escapeHtml(post.category)}</span>
            <h3>${escapeHtml(post.title)}</h3>
            <div class="blog-meta">
              <span><i class="fas fa-user"></i> ${escapeHtml(post.author)}</span>
              <span><i class="fas fa-calendar-alt"></i> ${post.date}</span>
            </div>
            <p class="blog-excerpt">${escapeHtml(post.excerpt)}</p>
            <a href="BlogDetails.php?slug=${post.slug}" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      `).join('');
      }

      renderPagination(totalPages);
      AOS.refresh();
    }

    function renderPagination(totalPages) {
      const paginationDiv = document.getElementById("pagination");
      if (totalPages <= 1) {
        paginationDiv.innerHTML = "";
        return;
      }

      let paginationHTML = `
      <button class="page-btn" id="prevPage" ${currentPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left"></i> Previous</button>
    `;

      for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `
        <button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>
      `;
      }

      paginationHTML += `
      <button class="page-btn" id="nextPage" ${currentPage === totalPages ? 'disabled' : ''}>Next <i class="fas fa-chevron-right"></i></button>
    `;

      paginationDiv.innerHTML = paginationHTML;

      document.querySelectorAll('[data-page]').forEach(btn => {
        btn.addEventListener('click', () => {
          currentPage = parseInt(btn.getAttribute('data-page'));
          renderPosts();
          window.scrollTo({ top: 400, behavior: 'smooth' });
        });
      });

      document.getElementById("prevPage")?.addEventListener('click', () => {
        if (currentPage > 1) {
          currentPage--;
          renderPosts();
          window.scrollTo({ top: 400, behavior: 'smooth' });
        }
      });

      document.getElementById("nextPage")?.addEventListener('click', () => {
        if (currentPage < totalPages) {
          currentPage++;
          renderPosts();
          window.scrollTo({ top: 400, behavior: 'smooth' });
        }
      });
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

    // --- REFRESH FUNCTION: Reloads the page to default state ---
    function refreshPage() {
      window.location.reload();
    }

    document.getElementById("searchBtn")?.addEventListener('click', () => {
      currentSearch = document.getElementById("searchInput").value;
      currentPage = 1;
      renderPosts();
    });

    document.getElementById("searchInput")?.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        currentSearch = e.target.value;
        currentPage = 1;
        renderPosts();
      }
    });

    // --- REFRESH BUTTON EVENT LISTENER ---
    document.getElementById("refreshBtn")?.addEventListener('click', refreshPage);

    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentCategory = btn.getAttribute('data-category');
        currentPage = 1;
        renderPosts();
      });
    });

    document.querySelectorAll('#categoryList li').forEach(item => {
      item.addEventListener('click', () => {
        const cat = item.getAttribute('data-cat');
        currentCategory = cat;
        currentPage = 1;

        document.querySelectorAll('.filter-btn').forEach(btn => {
          if (btn.getAttribute('data-category') === cat) {
            btn.classList.add('active');
          } else {
            btn.classList.remove('active');
          }
        });

        renderPosts();
      });
    });

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

    async function init() {
      await checkUserSession();
      setAuthUI();
      renderMobileMenu();
      await updateCartCount();
      fetchBlogPosts();
    }

    init();
  </script>
</body>

</html>