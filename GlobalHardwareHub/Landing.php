<?php
// This file now uses get_categories.php and get_vendors.php backend APIs
// Categories and Vendors are fetched dynamically from database
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | Computer Hardware Marketplace</title>
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

    /* Hero - White Card with Gradient Text */
    @keyframes heroFadeSlideUp {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero {
      background: #FFFFFF;
      margin: 2rem auto;
      max-width: 1300px;
      border-radius: 32px;
      padding: 5rem 2rem;
      text-align: center;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      animation: heroFadeSlideUp 0.6s ease-out;
    }

    .hero:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.3);
    }

    .hero-content {
      max-width: 800px;
      margin: 0 auto;
    }

    .hero h1 {
      font-size: 3.2rem;
      font-weight: 800;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #1e293b 0%, #2563EB 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-bottom: 1rem;
    }

    .hero p {
      font-size: 1.2rem;
      color: #475569;
      margin-bottom: 2rem;
    }

    .btn-group {
      display: flex;
      gap: 1.2rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-primary,
    .btn-secondary {
      padding: 0.9rem 2rem;
      border-radius: 60px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.25s ease;
      border: none;
      font-size: 1rem;
    }

    .btn-primary {
      background: var(--primary-gradient);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    .btn-secondary {
      background: transparent;
      color: var(--primary);
      border: 1.5px solid var(--primary);
    }

    .btn-secondary:hover {
      background: rgba(37, 99, 235, 0.05);
      border-color: var(--primary);
      transform: translateY(-2px) scale(1.02);
    }

    /* Sections */
    .section {
      max-width: 1300px;
      margin: 5rem auto;
      padding: 0 2rem;
    }

    .section-title {
      text-align: center;
      font-size: 2rem;
      font-weight: 700;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #1e293b 0%, #2563EB 100%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-bottom: 2.5rem;
      position: relative;
    }

    .section-title:after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: var(--primary-gradient);
      margin: 0.8rem auto 0;
      border-radius: 3px;
    }

    /* Props Grid - White Cards */
    .props-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 2rem;
    }

    .prop-card {
      background: #FFFFFF;
      padding: 2rem 1rem;
      text-align: center;
      border-radius: 32px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .prop-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.25);
    }

    .prop-icon {
      font-size: 2.8rem;
      margin-bottom: 1rem;
      transition: transform 0.3s ease;
    }

    .prop-card:hover .prop-icon {
      transform: scale(1.05);
    }

    .prop-card h3 {
      margin-bottom: 0.6rem;
      font-weight: 700;
      color: #111827;
    }

    .prop-card p {
      color: #6B7280;
      font-size: 0.9rem;
    }

    /* Trust Badges */
    .trust-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1.5rem;
      background: #FFFFFF;
      padding: 2rem 1.5rem;
      border-radius: 48px;
      margin: 2rem 0;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .trust-grid:hover {
      transform: translateY(-2px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
    }

    .trust-item {
      display: flex;
      align-items: center;
      gap: 0.8rem;
      font-weight: 600;
      background: #F3F4F6;
      padding: 0.6rem 1.5rem;
      border-radius: 60px;
      box-shadow: var(--shadow-sm);
      color: #374151;
      transition: all 0.2s ease;
    }

    .trust-item:hover {
      transform: translateY(-2px) scale(1.02);
      background: #E5E7EB;
    }

    /* Vendor Grid */
    .vendor-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
      gap: 2rem;
      margin-top: 1rem;
    }

    .vendor-card {
      background: #FFFFFF;
      border-radius: 28px;
      padding: 1.8rem 1rem;
      text-align: center;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .vendor-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.25);
    }

    .vendor-logo {
      width: 80px;
      height: 80px;
      object-fit: contain;
      margin: 0 auto 1rem;
      background: #F3F4F6;
      border-radius: 50%;
      padding: 0.5rem;
      transition: transform 0.3s ease;
    }

    .vendor-card:hover .vendor-logo {
      transform: scale(1.05);
    }

    .stars {
      color: #fbbf24;
      letter-spacing: 2px;
      margin: 0.5rem 0;
    }

    /* Categories Grid - 4 per row */
    .category-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 2rem;
    }

    .category-card {
      background: #FFFFFF;
      border-radius: 28px;
      overflow: hidden;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .category-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.25);
    }

    .category-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      background: #F3F4F6;
      transition: transform 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .category-card:hover img {
      transform: scale(1.05);
    }

    .category-card h4 {
      text-align: center;
      padding: 1rem 0.5rem 0.5rem;
      font-weight: 700;
      margin: 0;
      color: #111827;
    }

    .category-shop-btn {
      display: block;
      width: calc(100% - 2rem);
      margin: 0 1rem 1.2rem 1rem;
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 0.6rem 0;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.8rem;
      transition: all 0.25s ease;
      text-align: center;
    }

    .category-shop-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    /* Testimonial Slider */
    .testimonial-slider {
      background: #FFFFFF;
      border-radius: 32px;
      padding: 2rem 1rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .testimonial-slider:hover {
      transform: translateY(-2px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
    }

    .slider-container {
      position: relative;
      max-width: 800px;
      margin: auto;
      overflow: hidden;
      min-height: 300px;
    }

    .testimonial-track {
      display: flex;
      transition: transform 0.4s ease-in-out;
    }

    .testimonial-card {
      flex: 0 0 100%;
      text-align: center;
      padding: 1.5rem;
      background: #FFFFFF;
      border-radius: 28px;
      margin: 0 0.5rem;
      transition: all 0.3s ease;
    }

    .testimonial-card:hover {
      transform: scale(1.02);
    }

    .customer-img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 1rem;
      border: 3px solid var(--primary);
      transition: transform 0.3s ease;
    }

    .customer-img:hover {
      transform: scale(1.05);
    }

    .slider-buttons {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .slider-btn {
      background: #F3F4F6;
      border: none;
      font-size: 1.2rem;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
      transition: all 0.25s ease;
      color: #374151;
    }

    .slider-btn:hover {
      background: var(--primary);
      color: white;
      transform: scale(1.05);
    }

    /* CTA Section */
    .cta-section {
      background: var(--primary-gradient);
      border-radius: 32px;
      padding: 3rem 2rem;
      text-align: center;
      color: white;
      margin: 3rem auto;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      transition: all 0.3s ease;
    }

    .cta-section:hover {
      transform: translateY(-2px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.3);
    }

    .cta-section h2 {
      font-size: 2rem;
      margin-bottom: 1.5rem;
    }

    .cta-form {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      justify-content: center;
    }

    .cta-form input {
      padding: 0.9rem 1.5rem;
      border-radius: 60px;
      border: none;
      width: 300px;
      font-size: 1rem;
      outline: none;
      background: white;
      transition: all 0.2s ease;
    }

    .cta-form input:focus {
      box-shadow: 0 0 0 2px var(--secondary);
      transform: scale(1.02);
    }

    .cta-form button {
      background: white;
      color: var(--primary);
      border: none;
      font-weight: 700;
    }

    .cta-form button:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(255, 255, 255, 0.4);
    }

    /* Loading Spinner */
    .loading-spinner {
      text-align: center;
      padding: 2rem;
      color: var(--primary);
      font-size: 1rem;
      grid-column: 1 / -1;
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

    /* ========== BEAUTIFUL MODAL POPUP STYLES ========== */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(8px);
      z-index: 10000;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .modal-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .modal-container {
      background: #FFFFFF;
      border-radius: 32px;
      max-width: 450px;
      width: 90%;
      overflow: hidden;
      transform: scale(0.9);
      transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 50px 80px -30px rgba(0, 0, 0, 0.4);
    }

    .modal-overlay.active .modal-container {
      transform: scale(1);
    }

    .modal-header {
      background: var(--primary-gradient);
      padding: 1.5rem;
      text-align: center;
      position: relative;
    }

    .modal-header .modal-icon {
      font-size: 3rem;
      color: white;
      margin-bottom: 0.5rem;
    }

    .modal-header h3 {
      color: white;
      font-size: 1.5rem;
      font-weight: 700;
      margin: 0;
    }

    .modal-close {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: rgba(255, 255, 255, 0.2);
      border: none;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      cursor: pointer;
      color: white;
      font-size: 1rem;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .modal-close:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: scale(1.05);
    }

    .modal-body {
      padding: 1.5rem;
      text-align: center;
    }

    .modal-body p {
      color: var(--gray-600);
      font-size: 1rem;
      line-height: 1.6;
      margin-bottom: 1rem;
    }

    .modal-body .highlight {
      background: #EFF6FF;
      color: var(--primary);
      padding: 0.5rem 1rem;
      border-radius: 60px;
      font-size: 0.9rem;
      font-weight: 600;
      display: inline-block;
      margin-top: 0.5rem;
    }

    .modal-footer {
      padding: 1rem 1.5rem 1.5rem;
      text-align: center;
    }

    .modal-btn {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 0.7rem 2rem;
      border-radius: 60px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .modal-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    @media (max-width: 1100px) {
      .category-grid {
        grid-template-columns: repeat(3, 1fr);
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
      .hero h1 {
        font-size: 2rem;
      }
      .section-title {
        font-size: 1.6rem;
      }
      .category-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
      }
    }

    @media (max-width: 500px) {
      .category-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

  <header class="header" id="mainHeader">
    <div class="nav-container">
      <div class="logo">
        <img src="Logo.jpg" alt="Global Hardware Hub Logo"
          onerror="this.src='https://placehold.co/200x60/2563eb/white?text=GHH'">
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

  <main>
    <!-- Hero Section -->
    <section id="home" class="hero" data-aos="fade-up" data-aos-duration="800" data-aos-offset="50">
      <div class="hero-content">
        <h1><i class="fas fa-microchip"></i> Build Your Dream PC With the Best Hardware</h1>
        <p>Top-tier CPUs, GPUs, motherboards — from trusted vendors. One-stop shop for enthusiasts & builders.</p>
        <div class="btn-group">
          <button class="btn-primary" id="shopNowBtn"><i class="fas fa-shopping-cart"></i> Shop Now</button>
          <button class="btn-secondary" id="signupHeroBtn"><i class="fas fa-user-plus"></i> Sign Up</button>
        </div>
      </div>
    </section>

    <!-- Why Buy Section -->
    <div class="section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="50">
      <h2 class="section-title"><i class="fas fa-gem"></i> Why Buy From Us</h2>
      <div class="props-grid">
        <div class="prop-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="50">
          <div class="prop-icon"><i class="fas fa-tag"></i></div>
          <h3>Best Prices</h3>
          <p>Price match guarantee & bulk deals</p>
        </div>
        <div class="prop-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="100">
          <div class="prop-icon"><i class="fas fa-certificate"></i></div>
          <h3>Genuine Products</h3>
          <p>100% authentic, manufacturer warranty</p>
        </div>
        <div class="prop-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="150">
          <div class="prop-icon"><i class="fas fa-truck-fast"></i></div>
          <h3>Fast Delivery</h3>
          <p>Same-day dispatch, express shipping</p>
        </div>
        <div class="prop-card" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="200">
          <div class="prop-icon"><i class="fas fa-headset"></i></div>
          <h3>Customer Support</h3>
          <p>24/7 expert assistance</p>
        </div>
      </div>
    </div>

    <!-- Trust Badges -->
    <div class="section" data-aos="fade-up" data-aos-duration="500" data-aos-offset="30" data-aos-delay="100">
      <div class="trust-grid">
        <div class="trust-item"><i class="fas fa-lock"></i> Secure Payment</div>
        <div class="trust-item"><i class="fas fa-file-alt"></i> Warranty Available</div>
        <div class="trust-item"><i class="fas fa-shield-alt"></i> Authentic Products</div>
        <div class="trust-item"><i class="fas fa-undo-alt"></i> Easy Returns</div>
      </div>
    </div>

    <!-- Vendors Section -->
    <div class="section" id="vendors" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="150">
      <h2 class="section-title"><i class="fas fa-store"></i> Featured Vendors</h2>
      <div class="vendor-grid" id="vendorContainer">
        <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading vendors...</div>
      </div>
    </div>

    <!-- Categories Section - 4 per row -->
    <div class="section" id="categories-section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="200">
      <h2 class="section-title"><i class="fas fa-th-large"></i> Popular Categories</h2>
      <div class="category-grid" id="categoryContainer">
        <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading categories...</div>
      </div>
    </div>

    <!-- Testimonials Section -->
    <div class="section" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="250">
      <h2 class="section-title"><i class="fas fa-star"></i> What Our Customers Say</h2>
      <div class="testimonial-slider">
        <div class="slider-container">
          <div class="testimonial-track" id="testimonialTrack"></div>
        </div>
        <div class="slider-buttons">
          <button class="slider-btn" id="prevSlide"><i class="fas fa-chevron-left"></i></button>
          <button class="slider-btn" id="nextSlide"><i class="fas fa-chevron-right"></i></button>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="section" id="signup" data-aos="zoom-in" data-aos-duration="600" data-aos-offset="50" data-aos-delay="300">
      <div class="cta-section">
        <h2><i class="fas fa-envelope"></i> Join Now and Get Exclusive Deals</h2>
        <div class="cta-form">
          <input type="email" id="ctaEmail" placeholder="Your email address" autocomplete="email">
          <button class="btn-primary" id="ctaSignupBtn"><i class="fas fa-paper-plane"></i> Sign Up</button>
        </div>
        <div id="emailError" class="error-msg"></div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50">
    <div class="footer-grid">
      <div class="footer-col">
        <h4>Quick Links</h4>
        <a href="CompareProducts.php"> Compare Products</a>
        <a href="AddressBook.php">Address Book</a>
        <a href="Categories.php">Categories</a>
        <a href="ReturnPolicy.php">Return Policy</a>
      </div>
      <div class="footer-col">
        <h4>Resources</h4>
        <a href="PrivacyPolicy.php">Privacy Policy</a>
        <a href="TermsofService.php">Terms of Service</a>
        <a href="FAQ.php">FAQs</a>
        <a href="PaymentMethods.php">Payment Methods</a>
      </div>
      <div class="footer-col">
        <h4>Connect</h4>
        <div class="social-icons">
          <i class="fab fa-facebook-f"></i>
          <i class="fab fa-twitter"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-youtube"></i>
          <i class="fab fa-linkedin-in"></i>
        </div>
        <p><i class="fas fa-phone-alt"></i> 03267322096</p>
        <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
        <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
      </div>
      <div class="footer-col">
        <h4>Global Hardware Hub Motto</h4>
        <p>⚡ Power Your Passion, Build Beyond Limits.</p>
      </div>
    </div>
    <div class="copyright">
      <i class="fas fa-copyright"></i> 2026 Global Hardware Hub — All trademarks belong to their respective owners. All
      rights reserved.
    </div>
  </footer>

  <button class="back-to-top" id="backToTopBtn"><i class="fas fa-arrow-up"></i> Back to Top</button>

  <!-- Modal Popup HTML -->
  <div id="modalOverlay" class="modal-overlay">
    <div class="modal-container">
      <div class="modal-header">
        <button class="modal-close" id="modalCloseBtn"><i class="fas fa-times"></i></button>
        <div class="modal-icon" id="modalIcon"><i class="fas fa-store"></i></div>
        <h3 id="modalTitle">Visit Store</h3>
      </div>
      <div class="modal-body">
        <p id="modalMessage">You are about to visit the vendor's online store.</p>
        <span class="highlight" id="modalHighlight">https://example.com</span>
      </div>
      <div class="modal-footer">
        <button class="modal-btn" id="modalConfirmBtn">Got it! <i class="fas fa-arrow-right"></i></button>
      </div>
    </div>
  </div>

  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    // Initialize AOS
    AOS.init({
      duration: 600,
      once: true,
      offset: 80,
      disable: 'mobile'
    });

    // ========== MODAL FUNCTION ==========
    function showModal(title, message, highlightText, iconClass = 'fa-store') {
      const modal = document.getElementById('modalOverlay');
      const modalIcon = document.getElementById('modalIcon');
      const modalTitle = document.getElementById('modalTitle');
      const modalMessage = document.getElementById('modalMessage');
      const modalHighlight = document.getElementById('modalHighlight');
      
      modalIcon.innerHTML = `<i class="fas ${iconClass}"></i>`;
      modalTitle.textContent = title;
      modalMessage.textContent = message;
      modalHighlight.textContent = highlightText;
      
      modal.classList.add('active');
    }

    function closeModal() {
      const modal = document.getElementById('modalOverlay');
      modal.classList.remove('active');
    }

    document.getElementById('modalCloseBtn')?.addEventListener('click', closeModal);
    document.getElementById('modalConfirmBtn')?.addEventListener('click', closeModal);
    document.getElementById('modalOverlay')?.addEventListener('click', (e) => {
      if (e.target === document.getElementById('modalOverlay')) closeModal();
    });

    // ========== CART COUNT FROM API ==========

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
          return true;
        } else {
          isUserLoggedIn = false;
          isCustomerRole = false;
          currentUserId = null;
          return false;
        }
      } catch (error) {
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
            if (newCount !== oldCount) animateCartCounter();
          } else {
            cartCountSpan.innerText = "0";
          }
        } catch (error) {
          cartCountSpan.innerText = "0";
        }
      } else {
        cartCountSpan.innerText = "0";
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

    const cartIcon = document.querySelector('.cart-icon');
    if (cartIcon) {
      cartIcon.addEventListener('click', async () => {
        await checkUserSession();
        if (isUserLoggedIn) {
          window.location.href = "Cart.php";
        } else {
          showModal('Login Required', 'Please login first to view your cart.', 'Redirecting to login page...', 'fa-sign-in-alt');
          setTimeout(() => {
            closeModal();
            window.location.href = "LogIn.php";
          }, 1500);
        }
      });
    }

    // Hero Section Button Redirects
    document.getElementById('shopNowBtn')?.addEventListener('click', () => {
      window.location.href = "Products1.php";
    });
    document.getElementById('signupHeroBtn')?.addEventListener('click', () => {
      window.location.href = "Signup.php";
    });

    // Back to top
    const backBtn = document.getElementById('backToTopBtn');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 400) backBtn.classList.add('show');
      else backBtn.classList.remove('show');
    });
    backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    // ========== FETCH CATEGORIES ==========
    async function fetchCategories() {
      const container = document.getElementById('categoryContainer');
      try {
        const response = await fetch('get_categories.php');
        const categories = await response.json();
        if (categories.error) { container.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-exclamation-circle"></i> Failed to load categories</div>'; return; }
        if (!categories || categories.length === 0) { container.innerHTML = '<div class="loading-spinner">No categories available</div>'; return; }
        renderCategories(categories);
      } catch (error) { container.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-wifi"></i> Connection error loading categories</div>'; }
    }

    function renderCategories(categories) {
      const container = document.getElementById('categoryContainer');
      const categoriesHTML = categories.map((category, index) => {
        const imageUrl = category.image_url && category.image_url !== "default-category.jpg" ? category.image_url : "https://placehold.co/600x400/2563eb/white?text=" + encodeURIComponent(category.name);
        return `<div class="category-card" data-category="${category.name}" data-aos="fade-up" data-aos-duration="400" data-aos-delay="${index * 50}">
          <img src="${imageUrl}" alt="${category.name}" loading="lazy" onerror="this.onerror=null; this.src='https://placehold.co/600x400/2563eb/white?text=${encodeURIComponent(category.name)}';">
          <h4>${escapeHtml(category.name)}</h4>
          <button class="category-shop-btn" data-category-name="${escapeHtml(category.name)}">Shop Now <i class="fas fa-arrow-right"></i></button>
        </div>`;
      }).join('');
      container.innerHTML = categoriesHTML;
      
      document.querySelectorAll('.category-shop-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          window.location.href = "Products1.php";
        });
      });
      
      document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', (e) => {
          if (!e.target.classList.contains('category-shop-btn') && !e.target.parentElement?.classList.contains('category-shop-btn')) {
            window.location.href = "Products1.php";
          }
        });
      });
      AOS.refresh();
    }

    // ========== FETCH VENDORS ==========
    async function fetchVendors() {
      const container = document.getElementById('vendorContainer');
      try {
        const response = await fetch('get_vendors.php');
        const vendors = await response.json();
        if (vendors.error) { container.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-exclamation-circle"></i> Failed to load vendors</div>'; return; }
        if (!vendors || vendors.length === 0) { container.innerHTML = '<div class="loading-spinner">No vendors available</div>'; return; }
        renderVendors(vendors);
      } catch (error) { container.innerHTML = '<div class="loading-spinner" style="color:#dc2626;"><i class="fas fa-wifi"></i> Connection error loading vendors</div>'; }
    }

    function renderVendors(vendors) {
      const container = document.getElementById('vendorContainer');
      const vendorsHTML = vendors.map((vendor, index) => {
        const logoUrl = vendor.logo_url && vendor.logo_url !== "default-vendor-logo.jpg" ? vendor.logo_url : "https://placehold.co/80x80/dfe6f0/3a4b6e?text=Store";
        const rating = vendor.rating || 0;
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        let starsHtml = '';
        for (let i = 0; i < fullStars; i++) starsHtml += '<i class="fas fa-star"></i>';
        if (hasHalfStar) starsHtml += '<i class="fas fa-star-half-alt"></i>';
        for (let i = starsHtml.length / 3; i < 5; i++) starsHtml += '<i class="far fa-star"></i>';
        const storeName = escapeHtml(vendor.store_name);
        const vendorUrl = storeName.toLowerCase().replace(/\s+/g, '').replace(/[^a-z0-9]/g, '');
        return `<div class="vendor-card" data-aos="fade-up" data-aos-duration="400" data-aos-delay="${index * 50}">
          <img class="vendor-logo" src="${logoUrl}" alt="${storeName}" onerror="this.src='https://placehold.co/80x80/dfe6f0/3a4b6e?text=Store'">
          <h3>${storeName}</h3>
          <div class="stars">${starsHtml} ${rating.toFixed(1)}</div>
          <button class="btn-secondary visit-store-btn" style="margin-top:0.8rem; padding:0.5rem 1rem; font-size:0.8rem;" data-vendor-name="${storeName}" data-vendor-url="${vendorUrl}">Visit Store</button>
        </div>`;
      }).join('');
      container.innerHTML = vendorsHTML;
      
      document.querySelectorAll('.visit-store-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          const vendorName = btn.getAttribute('data-vendor-name');
          const vendorUrl = btn.getAttribute('data-vendor-url');
          const fullUrl = `https://${vendorUrl}.com`;
          showModal('Visit Store', `You are about to visit ${vendorName}'s online store.`, fullUrl, 'fa-store');
        });
      });
      AOS.refresh();
    }

    function escapeHtml(str) { if (!str) return ''; return str.replace(/[&<>]/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m])); }

    // ========== TESTIMONIAL SLIDER ==========
    const testimonials = [
      { name: "Elena K.", img: "elena.jpg", text: "Best platform for PC parts! Found a rare GPU and price was unbeatable.", rating: 5 },
      { name: "Marcus T.", img: "alex.jpg", text: "Vendors are legit, fast shipping, genuine Ryzen CPU. 10/10", rating: 5 },
      { name: "Robert L.", img: "robert.jpg", text: "Excellent customer support and easy returns. My go-to store.", rating: 4 },
      { name: "James W.", img: "John.jpg", text: "Massive selection of motherboards and peripherals. Great UI.", rating: 5 },
      { name: "Linda C.", img: "Sarah.jpg", text: "Trustworthy and secure payment, warranty added automatically.", rating: 4.5 }
    ];
    let currentIdx = 0;
    function buildTestimonialSlider() {
      const track = document.getElementById('testimonialTrack');
      if (!track) return;
      track.innerHTML = testimonials.map(t => `<div class="testimonial-card"><img class="customer-img" src="${t.img}" alt="${t.name}" onerror="this.src='https://placehold.co/80x80/dfe6f0/3a4b6e?text=User'"><h4>${t.name}</h4><div class="stars">${'<i class="fas fa-star"></i>'.repeat(Math.floor(t.rating))}${t.rating % 1 ? '<i class="fas fa-star-half-alt"></i>' : ''}</div><p>“${t.text}”</p></div>`).join('');
      updateSlider();
    }
    function updateSlider() { const track = document.getElementById('testimonialTrack'); if (track) track.style.transform = `translateX(-${currentIdx * 100}%)`; }
    function nextSlide() { currentIdx = (currentIdx + 1) % testimonials.length; updateSlider(); }
    function prevSlide() { currentIdx = (currentIdx - 1 + testimonials.length) % testimonials.length; updateSlider(); }
    buildTestimonialSlider();
    document.getElementById('nextSlide')?.addEventListener('click', nextSlide);
    document.getElementById('prevSlide')?.addEventListener('click', prevSlide);
    let autoSlide = setInterval(() => { nextSlide(); }, 6000);
    const sliderArea = document.querySelector('.testimonial-slider');
    sliderArea?.addEventListener('mouseenter', () => clearInterval(autoSlide));
    sliderArea?.addEventListener('mouseleave', () => { autoSlide = setInterval(() => nextSlide(), 6000); });

    // ========== EMAIL SIGNUP WITH MODAL ==========
    function validateEmail(email) { const re = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/; return re.test(String(email).toLowerCase()); }
    const ctaBtn = document.getElementById('ctaSignupBtn');
    const emailInput = document.getElementById('ctaEmail');
    const errorSpan = document.getElementById('emailError');
    
    function handleSignup() {
      const email = emailInput.value.trim();
      if (!validateEmail(email)) { 
        errorSpan.innerText = '❌ Please enter a valid email address (e.g., name@domain.com)'; 
        return; 
      }
      errorSpan.innerText = '';
      showModal('Welcome Aboard!', 'You have successfully subscribed to our exclusive deals newsletter.', email, 'fa-envelope');
      emailInput.value = '';
      setTimeout(() => {
        closeModal();
      }, 2000);
    }
    
    ctaBtn.addEventListener('click', handleSignup);
    emailInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') handleSignup(); });

    // ========== INITIALIZE PAGE ==========
    async function init() {
      await checkUserSession();
      setAuthUI();
      renderMobileMenu();
      await updateCartCount();
      await fetchCategories();
      await fetchVendors();
    }

    init();
  </script>
</body>

</html>