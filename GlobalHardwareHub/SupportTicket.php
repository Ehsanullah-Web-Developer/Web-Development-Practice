<?php
session_start();
// Check if user is logged in, redirect to login if not
if (!isset($_SESSION['user_id'])) {
  header("Location: LogIn.php");
  exit;
}
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | Support Tickets</title>
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

    /* Tickets Container */
    .tickets-container {
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

    /* Filter Bar */
    .filter-bar {
      display: flex;
      gap: 1rem;
      margin-bottom: 2rem;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
    }

    .filter-group {
      display: flex;
      gap: 0.8rem;
      flex-wrap: wrap;
    }

    /* C. Filter Button Hover Animation */
    .filter-btn {
      background: #FFFFFF;
      border: 1px solid #E5E7EB;
      padding: 0.5rem 1.2rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.25s ease;
      color: #374151;
      box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    }

    .filter-btn:hover,
    .filter-btn.active {
      background: var(--primary-gradient);
      color: white;
      border-color: transparent;
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
    }

    /* Create Ticket Card - White */
    /* A. Create Ticket Card Hover Animation */
    .create-ticket-card {
      background: #FFFFFF;
      border-radius: 32px;
      padding: 1.8rem;
      margin-bottom: 2rem;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .create-ticket-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
    }

    .create-ticket-card h2 {
      font-size: 1.3rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.4rem;
      font-weight: 600;
      color: #374151;
      font-size: 0.85rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 0.8rem;
      border: 1.5px solid #E5E7EB;
      border-radius: 16px;
      font-size: 0.95rem;
      outline: none;
      transition: all 0.2s ease;
      font-family: inherit;
      background: #FFFFFF;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .file-input {
      padding: 0.5rem 0;
    }

    .error-msg {
      color: var(--danger);
      font-size: 0.7rem;
      margin-top: 0.25rem;
      display: block;
    }

    /* B. Submit Button Hover Animation */
    .submit-btn {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 0.8rem 2rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 700;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .submit-btn:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    /* Tickets List */
    .tickets-list {
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
    }

    /* A. Ticket Card Hover Animation */
    .ticket-card {
      background: #FFFFFF;
      border-radius: 28px;
      padding: 1.5rem;
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .ticket-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
    }

    .ticket-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      margin-bottom: 0.8rem;
    }

    .ticket-id {
      font-weight: 700;
      color: var(--primary);
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .ticket-status {
      padding: 0.25rem 1rem;
      border-radius: 60px;
      font-size: 0.7rem;
      font-weight: 700;
    }

    .status-open {
      background: #D1FAE5;
      color: #065F46;
    }

    .status-pending {
      background: #FED7AA;
      color: #9B2C1D;
    }

    .status-resolved {
      background: #DBEAFE;
      color: var(--primary);
    }

    .status-closed {
      background: #F3F4F6;
      color: #374151;
    }

    .ticket-subject {
      font-size: 1rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 0.5rem;
    }

    .ticket-meta {
      display: flex;
      gap: 1.5rem;
      font-size: 0.75rem;
      color: #6B7280;
      margin-bottom: 1rem;
      flex-wrap: wrap;
    }

    .ticket-actions {
      display: flex;
      gap: 0.8rem;
      flex-wrap: wrap;
      margin-top: 0.5rem;
    }

    /* B. Action Button Hover Animation */
    .btn-action {
      background: #F3F4F6;
      border: none;
      padding: 0.4rem 1rem;
      border-radius: 60px;
      cursor: pointer;
      font-size: 0.75rem;
      font-weight: 600;
      transition: all 0.25s ease;
      color: #374151;
    }

    .btn-action:hover {
      background: #E5E7EB;
      transform: translateY(-2px) scale(1.02);
    }

    .btn-view {
      background: var(--primary-gradient);
      color: white;
    }

    .btn-view:hover {
      background: var(--primary-dark);
      box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
    }

    /* Ticket Details Expandable */
    .ticket-details {
      margin-top: 1.2rem;
      padding-top: 1rem;
      border-top: 1px solid #E5E7EB;
      display: none;
    }

    .ticket-details.show {
      display: block;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .ticket-message {
      background: #F9FAFB;
      padding: 1rem;
      border-radius: 20px;
      margin-bottom: 1rem;
      transition: all 0.2s ease;
    }

    .ticket-message:hover {
      transform: scale(1.01);
    }

    .replies-section {
      margin: 1rem 0;
    }

    .reply-item {
      background: #F9FAFB;
      padding: 0.8rem 1rem;
      border-radius: 16px;
      margin-bottom: 0.8rem;
      border-left: 3px solid var(--primary);
      transition: all 0.2s ease;
    }

    .reply-item:hover {
      transform: translateX(4px);
      background: #FFFFFF;
      box-shadow: var(--shadow-sm);
    }

    .reply-meta {
      font-size: 0.7rem;
      color: #6B7280;
      margin-bottom: 0.3rem;
    }

    .reply-text {
      color: #374151;
    }

    .reply-form {
      margin-top: 1rem;
    }

    .reply-form textarea {
      width: 100%;
      padding: 0.8rem;
      border: 1.5px solid #E5E7EB;
      border-radius: 16px;
      margin-bottom: 0.5rem;
      font-family: inherit;
      background: #FFFFFF;
      transition: all 0.2s ease;
    }

    .reply-form textarea:focus {
      border-color: var(--primary);
      outline: none;
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
      .ticket-header {
        flex-direction: column;
        gap: 0.5rem;
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

  <!-- Modal Popup HTML -->
  <div id="modalOverlay" class="modal-overlay">
    <div class="modal-container">
      <div class="modal-header">
        <button class="modal-close" id="modalCloseBtn"><i class="fas fa-times"></i></button>
        <div class="modal-icon" id="modalIcon"><i class="fas fa-check-circle"></i></div>
        <h3 id="modalTitle">Success</h3>
      </div>
      <div class="modal-body">
        <p id="modalMessage">Operation completed successfully!</p>
      </div>
      <div class="modal-footer">
        <button class="modal-btn" id="modalConfirmBtn">Got it! <i class="fas fa-arrow-right"></i></button>
      </div>
    </div>
  </div>

  <div class="tickets-container">
    <div class="breadcrumb">
      <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="MyAccount.php">My Account</a> /
      <span>Support Tickets</span>
    </div>
    <!-- H. Scroll Reveal - Page Title -->
    <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-ticket-alt"></i> Support Tickets</h1>

    <!-- H. Scroll Reveal - Filter Bar -->
    <div class="filter-bar" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30" data-aos-delay="50">
      <div class="filter-group">
        <button class="filter-btn active" data-filter="all"><i class="fas fa-list"></i> All Tickets</button>
        <button class="filter-btn" data-filter="Open"><i class="fas fa-envelope-open-text"></i> Open</button>
        <button class="filter-btn" data-filter="Closed"><i class="fas fa-check-circle"></i> Closed</button>
      </div>
    </div>

    <!-- H. Scroll Reveal - Create Ticket Card -->
    <div class="create-ticket-card" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="100">
      <h2><i class="fas fa-plus-circle"></i> Create New Support Ticket</h2>
      <form id="ticketForm">
        <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
          <label><i class="fas fa-heading"></i> Subject *</label>
          <input type="text" id="subject" placeholder="Brief description of your issue">
          <div id="subjectError" class="error-msg"></div>
        </div>
        <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
          <label><i class="fas fa-hashtag"></i> Order Number (Optional)</label>
          <input type="text" id="orderNumber" placeholder="e.g., #NB-12345">
        </div>
        <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
          <label><i class="fas fa-folder"></i> Category *</label>
          <select id="category">
            <option value="Orders">Orders & Delivery</option>
            <option value="Shipping">Shipping Issues</option>
            <option value="Returns">Returns & Refunds</option>
            <option value="Products">Product Questions</option>
            <option value="Vendors">Vendor Support</option>
          </select>
        </div>
        <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="200">
          <label><i class="fas fa-comment"></i> Message *</label>
          <textarea id="message" rows="4" placeholder="Describe your issue in detail..."></textarea>
          <div id="messageError" class="error-msg"></div>
        </div>
        <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-delay="250">
          <label><i class="fas fa-paperclip"></i> Attach File (Optional)</label>
          <input type="file" id="attachment" class="file-input">
          <div id="fileNamePreview" style="font-size:0.7rem; color:#6B7280; margin-top:0.2rem;"></div>
        </div>
        <button type="submit" class="submit-btn" data-aos="fade-up" data-aos-duration="300" data-aos-delay="300"><i class="fas fa-paper-plane"></i> Submit Ticket</button>
      </form>
    </div>

    <!-- H. Scroll Reveal - Tickets List -->
    <h2 style="font-size:1.3rem; font-weight:700; margin-bottom:1rem; color:#FFFFFF;" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150"><i
        class="fas fa-list-ul"></i> Your Tickets</h2>
    <div id="ticketsList" class="tickets-list" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50" data-aos-delay="200"></div>
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
        <a href="CompareProducts.php">Compare Products</a>
        <a href="ContactUs.php">Contact Us</a>
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

    // ========== BEAUTIFUL MODAL FUNCTION ==========
    function showModal(title, message, iconClass = 'fa-check-circle') {
      const modal = document.getElementById('modalOverlay');
      const modalIcon = document.getElementById('modalIcon');
      const modalTitle = document.getElementById('modalTitle');
      const modalMessage = document.getElementById('modalMessage');
      
      modalIcon.innerHTML = `<i class="fas ${iconClass}"></i>`;
      modalTitle.textContent = title;
      modalMessage.textContent = message;
      
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

    // Global session variables
    let isUserLoggedIn = true; // User is logged in due to PHP check at top
    let isCustomerRole = false;
    let currentUserId = <?php echo json_encode($user_id); ?>;

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

    // ============== Helper Functions ==============
    let currentFilter = "all";
    let allTickets = [];

    function formatDate(dateString) {
      if (!dateString) return 'N/A';
      let date = new Date(dateString);
      return date.toLocaleString();
    }

    function escapeHtml(str) {
      if (!str) return '';
      str = String(str);
      return str.replace(/[&<>]/g, function (m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
      });
    }

    function getStatusClass(status) {
      if (status === 'Open') return 'status-open';
      if (status === 'Closed') return 'status-closed';
      return 'status-pending';
    }

    async function loadTickets() {
      const container = document.getElementById('ticketsList');
      container.innerHTML = '<div class="skeleton-loader"><i class="fas fa-spinner fa-pulse"></i> Loading tickets...</div>';
      
      try {
        let url = 'get_user_tickets.php';
        if (currentFilter !== 'all') {
          url += '?status=' + encodeURIComponent(currentFilter);
        }

        const response = await fetch(url, {
          credentials: 'same-origin'
        });
        const data = await response.json();

        if (data.success) {
          allTickets = data.tickets;
          renderTickets();
        } else {
          console.error('Failed to load tickets:', data.message);
          container.innerHTML = '<div style="text-align:center; padding:2rem; color:#6B7280;"><i class="fas fa-exclamation-circle"></i> Failed to load tickets. Please try again.</div>';
        }
      } catch (error) {
        console.error('Error loading tickets:', error);
        container.innerHTML = '<div style="text-align:center; padding:2rem; color:#6B7280;"><i class="fas fa-wifi"></i> Error loading tickets. Please check your connection.</div>';
      }
    }

    function renderTickets() {
      const container = document.getElementById('ticketsList');

      if (allTickets.length === 0) {
        container.innerHTML = '<div style="text-align:center; padding:2rem; color:#6B7280;"><i class="fas fa-inbox"></i> No tickets found. Create your first support ticket above.</div>';
        return;
      }

      container.innerHTML = allTickets.map((ticket, index) => `
      <div class="ticket-card" data-id="${ticket.ticket_id}" data-aos="fade-up" data-aos-duration="400" data-aos-delay="${index * 50}">
        <div class="ticket-header">
          <span class="ticket-id"><i class="fas fa-hashtag"></i> #${ticket.ticket_id}</span>
          <span class="ticket-status ${getStatusClass(ticket.status)}"><i class="fas ${ticket.status === 'Open' ? 'fa-circle' : (ticket.status === 'Closed' ? 'fa-check-circle' : 'fa-clock')}"></i> ${ticket.status.toUpperCase()}</span>
        </div>
        <div class="ticket-subject">${escapeHtml(ticket.subject)}</div>
        <div class="ticket-meta">
          <span><i class="fas fa-folder"></i> ${escapeHtml(ticket.category)}</span>
          <span><i class="fas fa-calendar-alt"></i> Created: ${formatDate(ticket.created_at)}</span>
          ${ticket.order_id ? `<span><i class="fas fa-shopping-cart"></i> Order #${escapeHtml(ticket.order_id)}</span>` : ''}
        </div>
        <div class="ticket-actions">
          <button class="btn-action btn-view" onclick="toggleDetails(${ticket.ticket_id})"><i class="fas fa-eye"></i> View Details</button>
          ${ticket.status !== 'Closed' ? `<button class="btn-action" onclick="updateTicketStatus(${ticket.ticket_id}, 'Closed')"><i class="fas fa-lock"></i> Close Ticket</button>` : `<button class="btn-action" onclick="updateTicketStatus(${ticket.ticket_id}, 'Open')"><i class="fas fa-undo-alt"></i> Reopen Ticket</button>`}
        </div>
        <div id="details-${ticket.ticket_id}" class="ticket-details">
          <div class="ticket-message">
            <strong><i class="fas fa-envelope"></i> Original Message:</strong><br>
            <div id="message-content-${ticket.ticket_id}">Loading...</div>
          </div>
          <div class="replies-section">
            <strong><i class="fas fa-reply-all"></i> Replies:</strong>
            <div id="replies-content-${ticket.ticket_id}">Loading...</div>
          </div>
          <div class="reply-form">
            <textarea id="reply-${ticket.ticket_id}" rows="2" placeholder="Write your reply..."></textarea>
            <button class="btn-action" onclick="addReply(${ticket.ticket_id})"><i class="fas fa-paper-plane"></i> Post Reply</button>
          </div>
        </div>
      </div>
    `).join('');
      
      // Refresh AOS for dynamically added elements
      AOS.refresh();
    }

    window.toggleDetails = async function (ticketId) {
      const detailsDiv = document.getElementById(`details-${ticketId}`);

      if (detailsDiv.classList.contains('show')) {
        detailsDiv.classList.remove('show');
        return;
      }

      const messageDiv = document.getElementById(`message-content-${ticketId}`);
      if (messageDiv && messageDiv.innerHTML === 'Loading...') {
        await loadTicketDetails(ticketId);
      }

      detailsDiv.classList.add('show');
    };

    async function loadTicketDetails(ticketId) {
      try {
        const response = await fetch(`get_ticket_details.php?ticket_id=${ticketId}`, {
          credentials: 'same-origin'
        });
        const data = await response.json();

        if (data.success) {
          const messageDiv = document.getElementById(`message-content-${ticketId}`);
          if (messageDiv) {
            messageDiv.innerHTML = escapeHtml(data.ticket.message);
          }

          const repliesDiv = document.getElementById(`replies-content-${ticketId}`);
          if (repliesDiv) {
            if (data.replies && data.replies.length > 0) {
              repliesDiv.innerHTML = data.replies.map(reply => `
              <div class="reply-item">
                <div class="reply-meta"><i class="fas ${reply.user_id === currentUserId ? 'fa-user' : 'fa-headset'}"></i> ${reply.user_id === currentUserId ? 'You' : 'Support'} • ${formatDate(reply.created_at)}</div>
                <div class="reply-text">${escapeHtml(reply.message)}</div>
              </div>
            `).join('');
            } else {
              repliesDiv.innerHTML = '<p style="color:#6B7280; padding:0.5rem;"><i class="fas fa-comment-slash"></i> No replies yet.</p>';
            }
          }
        } else {
          console.error('Failed to load ticket details:', data.message);
          const messageDiv = document.getElementById(`message-content-${ticketId}`);
          if (messageDiv) {
            messageDiv.innerHTML = 'Failed to load message content.';
          }
        }
      } catch (error) {
        console.error('Error loading ticket details:', error);
        const messageDiv = document.getElementById(`message-content-${ticketId}`);
        if (messageDiv) {
          messageDiv.innerHTML = 'Error loading content.';
        }
      }
    }

    window.addReply = async function (ticketId) {
      const replyTextarea = document.getElementById(`reply-${ticketId}`);
      const message = replyTextarea.value.trim();

      if (!message) {
        showModal('Missing Information', 'Please enter a reply message.', 'fa-exclamation-circle');
        return;
      }

      try {
        const formData = new URLSearchParams();
        formData.append('ticket_id', ticketId);
        formData.append('message', message);

        const response = await fetch('reply_support_ticket.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: formData,
          credentials: 'same-origin'
        });

        const data = await response.json();

        if (data.success) {
          showModal('Reply Added!', 'Your reply has been posted successfully.', 'fa-check-circle');
          replyTextarea.value = '';
          await loadTicketDetails(ticketId);
          await loadTickets();
        } else {
          showModal('Error', 'Failed to add reply: ' + data.message, 'fa-exclamation-circle');
        }
      } catch (error) {
        console.error('Error adding reply:', error);
        showModal('Error', 'Error adding reply. Please try again.', 'fa-exclamation-circle');
      }
    };

    window.updateTicketStatus = async function (ticketId, newStatus) {
      try {
        const formData = new URLSearchParams();
        formData.append('ticket_id', ticketId);
        formData.append('status', newStatus);

        const response = await fetch('update_ticket_status.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: formData,
          credentials: 'same-origin'
        });

        const data = await response.json();

        if (data.success) {
          const statusMessage = newStatus === 'Closed' ? 'Ticket has been closed successfully!' : 'Ticket has been reopened successfully!';
          showModal('Status Updated', statusMessage, 'fa-check-circle');
          await loadTickets();
        } else {
          showModal('Error', 'Failed to update status: ' + data.message, 'fa-exclamation-circle');
        }
      } catch (error) {
        console.error('Error updating status:', error);
        showModal('Error', 'Error updating status. Please try again.', 'fa-exclamation-circle');
      }
    };

    document.getElementById('ticketForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const subject = document.getElementById('subject').value.trim();
      const orderNumber = document.getElementById('orderNumber').value.trim();
      const category = document.getElementById('category').value;
      const message = document.getElementById('message').value.trim();
      const attachment = document.getElementById('attachment').files[0];

      let isValid = true;
      if (!subject) {
        document.getElementById('subjectError').innerText = 'Subject is required';
        isValid = false;
      } else {
        document.getElementById('subjectError').innerText = '';
      }

      if (!message) {
        document.getElementById('messageError').innerText = 'Message is required';
        isValid = false;
      } else {
        document.getElementById('messageError').innerText = '';
      }

      if (!isValid) return;

      try {
        const formData = new URLSearchParams();
        formData.append('subject', subject);
        if (orderNumber) formData.append('order_id', orderNumber.replace('#', ''));
        formData.append('category', category);
        formData.append('message', message);
        if (attachment) formData.append('attachment', attachment.name);

        const response = await fetch('create_support_ticket.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: formData,
          credentials: 'same-origin'
        });

        const data = await response.json();

        if (data.success) {
          showModal('Ticket Submitted!', 'Your support ticket has been submitted successfully. Our team will get back to you soon.', 'fa-check-circle');
          document.getElementById('ticketForm').reset();
          document.getElementById('fileNamePreview').innerText = '';
          await loadTickets();
        } else {
          showModal('Error', 'Failed to create ticket: ' + data.message, 'fa-exclamation-circle');
        }
      } catch (error) {
        console.error('Error creating ticket:', error);
        showModal('Error', 'Error creating ticket. Please try again.', 'fa-exclamation-circle');
      }
    });

    document.getElementById('attachment').addEventListener('change', (e) => {
      const file = e.target.files[0];
      const preview = document.getElementById('fileNamePreview');
      if (file) {
        preview.innerHTML = `<i class="fas fa-file"></i> Selected: ${file.name}`;
      } else {
        preview.innerText = '';
      }
    });

    document.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentFilter = btn.getAttribute('data-filter');
        loadTickets();
      });
    });

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

    // Cart click handler
    const cartIcon = document.querySelector('.cart-icon');
    if (cartIcon) {
      cartIcon.addEventListener('click', async () => {
        await checkUserSession();
        if (isUserLoggedIn) {
          window.location.href = "Cart.php";
        } else {
          showModal('Login Required', 'Please login to manage your cart.', 'fa-exclamation-circle');
          setTimeout(() => {
            closeModal();
            window.location.href = "LogIn.php";
          }, 1500);
        }
      });
    }

    // Auth button handler
    document.getElementById('authButton').addEventListener('click', async () => {
      await checkUserSession();
      window.location.href = 'Logout.php';
    });

    // Mobile menu render
    function renderMobileMenu() {
      const container = document.getElementById("mobileMenuContent");
      if (!container) return;

      const menuItems = [
        { title: "Home", link: "FYPHome.php" },
        { title: "Products", submenu: ["Categories", "Compare Products", "Product Details", "All Products"], links: ["Categories.php", "CompareProducts.php", "ProductDetails.php", "Products1.php"] },
        { title: "Vendors", submenu: ["Vendors List", "Vendors Store", "Vendors Setting", "Vendors Dashboard", "Vendors Products", "Vendors Add Products", "Vendors Reviews", "Vendors Orders"], links: ["Vendors.php", "VendorsStore.php", "VendorSettings.php", "VendorDashboard.php", "VendorProductsManagement.php", "VendorAddProducts.php", "VendorReviews.php", "VendorOrders.php"] },
        { title: "Account", submenu: ["My Account", "Profile", "Orders", "Wishlist", "Address Book", "Payment Methods", "Cart", "Checkout", "Log In", "Log Out", "Sign Up"], links: ["MyAccount.php", "Profile.php", "UserOrders.php", "Wishlist.php", "AddressBook.php", "PaymentMethods.php", "Cart.php", "Checkout.php", "LogIn.php", "Logout.php", "Signup.php"] },
        { title: "Support", submenu: ["Contact", "FAQ", "Shipping Info", "Warranty Info", "Return Policy", "Privacy Policy", "Terms of Service", "About Us"], links: ["ContactUs.php", "FAQ.php", "ShippingInfo.php", "WarrantyInfo.php", "ReturnPolicy.php", "PrivacyPolicy.php", "TermsofService.php", "AboutUs.php"] },
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

    // ========== INITIALIZE PAGE ==========
    async function init() {
      await checkUserSession();
      renderMobileMenu();
      await updateCartCount();
      loadTickets();
    }

    init();
  </script>
</body>

</html>