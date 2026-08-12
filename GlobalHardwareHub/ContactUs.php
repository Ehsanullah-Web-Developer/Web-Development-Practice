<?php
// Start session to check user login status
session_start();

// Include database connection
require_once 'db_connect.php';

// Initialize variables for form submission
$formSubmitted = false;
$formError = false;
$errorMessage = '';

// Get user login status from session (will be used with check_session.php for consistency)
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if user is logged in
  if (!isset($_SESSION['user_id'])) {
    $formError = true;
    $errorMessage = 'Please login first to send a message';
  } else {
    $userId = $_SESSION['user_id'];

    // Get and sanitize form data
    $name = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Validate required fields
    $errors = [];

    if (empty($name)) {
      $errors[] = 'Full name is required';
    }

    if (empty($email)) {
      $errors[] = 'Email address is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'Please enter a valid email address';
    }

    if (empty($message)) {
      $errors[] = 'Message is required';
    }

    // Map subject values for better readability
    $subjectMap = [
      'general' => 'General Inquiry',
      'orders' => 'Order Issue',
      'returns' => 'Returns & Refunds',
      'products' => 'Product Question',
      'vendors' => 'Vendor Support',
      'other' => 'Other'
    ];

    $subjectText = isset($subjectMap[$subject]) ? $subjectMap[$subject] : ucfirst($subject);

    // If no errors, insert into database (without order_number column)
    if (empty($errors)) {
      $insertSql = "INSERT INTO contact_messages (user_id, name, email, subject, message, status, created_at) 
                         VALUES (?, ?, ?, ?, ?, 'unread', NOW())";

      $stmt = $conn->prepare($insertSql);

      if ($stmt) {
        $stmt->bind_param('issss', $userId, $name, $email, $subjectText, $message);

        if ($stmt->execute()) {
          $formSubmitted = true;
        } else {
          $formError = true;
          $errorMessage = 'Failed to send message. Please try again.';
        }

        $stmt->close();
      } else {
        $formError = true;
        $errorMessage = 'Failed to send message. Please try again.';
      }
    } else {
      $formError = true;
      $errorMessage = implode(', ', $errors);
    }
  }
}

// Don't close connection here - will be used by the page
// $conn->close(); - Keep connection open
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Global Hardware Hub | Contact Us</title>
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

    /* Contact Container */
    .contact-container {
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
      margin-bottom: 2rem;
    }

    /* Two Column Layout */
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
      .contact-grid {
        grid-template-columns: 1fr;
      }
    }

    /* Form Card - White */
    /* A. Form Card Hover Animation */
    .form-card {
      background: #FFFFFF;
      border-radius: 32px;
      padding: 2rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .form-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
    }

    .form-card h2 {
      font-size: 1.4rem;
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
      padding: 0.85rem;
      border: 1.5px solid #E5E7EB;
      border-radius: 20px;
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
      padding: 0.9rem 2rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 700;
      width: 100%;
      transition: all 0.25s ease;
      font-size: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 0.5rem;
    }

    .submit-btn:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    .success-message {
      background: #D1FAE5;
      color: #065F46;
      padding: 1rem;
      border-radius: 20px;
      margin-bottom: 1rem;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    /* Info Cards - White */
    /* A. Info Card Hover Animation */
    .info-card {
      background: #FFFFFF;
      border-radius: 32px;
      padding: 2rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .info-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
    }

    .info-card h2 {
      font-size: 1.4rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .info-detail {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      margin-bottom: 1rem;
      padding: 0.5rem 0;
      transition: all 0.2s ease;
    }

    .info-detail:hover {
      transform: translateX(4px);
    }

    .info-icon {
      font-size: 1.5rem;
      min-width: 45px;
      color: var(--primary);
    }

    .info-text p {
      color: #6B7280;
      line-height: 1.5;
    }

    .info-text strong {
      color: #111827;
    }

    .hours {
      margin-top: 0.3rem;
      color: #6B7280;
      font-size: 0.85rem;
    }

    /* Live Chat Button */
    /* B. Live Chat Button Hover Animation */
    .live-chat-btn {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 1rem 1.5rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 700;
      width: 100%;
      margin-bottom: 1.5rem;
      transition: all 0.25s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-size: 1rem;
    }

    .live-chat-btn:hover {
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
    }

    /* Quick Links Card - White */
    /* A. Quick Links Card Hover Animation */
    .quick-links-card {
      background: #FFFFFF;
      border-radius: 32px;
      padding: 1.8rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    .quick-links-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
    }

    .quick-links-card h3 {
      font-size: 1.2rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* C. FAQ Link Hover Animation */
    .faq-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 0.7rem 0;
      color: var(--primary);
      text-decoration: none;
      transition: all 0.25s ease;
      border-bottom: 1px solid #E5E7EB;
    }

    .faq-link:last-child {
      border-bottom: none;
    }

    .faq-link:hover {
      color: var(--primary-dark);
      transform: translateX(8px);
    }

    .ticket-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-top: 1rem;
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: all 0.25s ease;
    }

    .ticket-link:hover {
      gap: 12px;
      color: var(--primary-dark);
    }

    /* Modal */
    .modal {
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

    .modal.show {
      display: flex;
    }

    .modal-content {
      background: #FFFFFF;
      max-width: 420px;
      width: 90%;
      border-radius: 32px;
      padding: 1.8rem;
      text-align: center;
      animation: modalFadeIn 0.3s ease;
      box-shadow: var(--shadow-xl);
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

    .chat-window {
      background: #F3F4F6;
      padding: 1rem;
      border-radius: 20px;
      margin: 1rem 0;
      height: 220px;
      overflow-y: auto;
    }

    .chat-input {
      display: flex;
      gap: 0.5rem;
      margin-top: 0.8rem;
    }

    .chat-input input {
      flex: 1;
      padding: 0.75rem;
      border: 1.5px solid #E5E7EB;
      border-radius: 60px;
      font-size: 0.85rem;
      background: #FFFFFF;
      transition: all 0.2s ease;
    }

    .chat-input input:focus {
      outline: none;
      border-color: var(--primary);
    }

    .chat-input button {
      background: var(--primary-gradient);
      color: white;
      border: none;
      padding: 0.75rem 1.2rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .chat-input button:hover {
      transform: translateY(-2px) scale(1.02);
    }

    .close-modal {
      margin-top: 1rem;
      background: #F3F4F6;
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 60px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.25s ease;
      color: #374151;
    }

    .close-modal:hover {
      background: #E5E7EB;
      transform: translateY(-2px) scale(1.02);
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
      .form-card,
      .info-card,
      .quick-links-card {
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
        <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
        <li class="nav-item"><a href="ContactUs.php" class="nav-link active"><i class="fas fa-envelope"></i> Contact Us</a></li>
        <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
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

  <div class="contact-container">
    <div class="breadcrumb">
      <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <span>Contact Us</span>
    </div>
    <!-- H. Scroll Reveal - Page Title -->
    <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-headset"></i> Contact Us</h1>

    <div class="contact-grid">
      <!-- H. Scroll Reveal - Contact Form Card -->
      <div class="form-card" data-aos="fade-right" data-aos-duration="600" data-aos-offset="50" data-aos-delay="50">
        <h2><i class="fas fa-paper-plane" style="color: var(--primary);"></i> Send us a message</h2>
        <div id="formSuccessMessage" style="display: none;"></div>
        <?php if ($formSubmitted && !$formError): ?>
          <div class="success-message" id="serverSuccessMessage"><i class="fas fa-check-circle"></i> ✅ Your message has
            been sent! We'll respond within 24 hours.</div>
        <?php endif; ?>
        <?php if ($formError && !empty($errorMessage)): ?>
          <div class="success-message" style="background: #FEE2E2; color: #DC2626;" id="serverErrorMessage"><i
              class="fas fa-exclamation-circle"></i> ❌ <?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
        <form id="contactForm" method="POST" action="">
          <div class="form-group">
            <label><i class="fas fa-user"></i> Full Name *</label>
            <input type="text" id="fullName" name="fullName" placeholder="Enter your full name">
            <div id="nameError" class="error-msg"></div>
          </div>
          <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email Address *</label>
            <input type="email" id="email" name="email" placeholder="you@example.com">
            <div id="emailError" class="error-msg"></div>
          </div>
          <div class="form-group">
            <label><i class="fas fa-hashtag"></i> Order Number (Optional)</label>
            <input type="text" id="orderNumber" name="orderNumber" placeholder="e.g., NB-12345">
          </div>
          <div class="form-group">
            <label><i class="fas fa-tag"></i> Subject *</label>
            <select id="subject" name="subject">
              <option value="general">General Inquiry</option>
              <option value="orders">Order Issue</option>
              <option value="returns">Returns & Refunds</option>
              <option value="products">Product Question</option>
              <option value="vendors">Vendor Support</option>
              <option value="other">Other</option>
            </select>
            <div id="subjectError" class="error-msg"></div>
          </div>
          <div class="form-group">
            <label><i class="fas fa-comment"></i> Message *</label>
            <textarea id="message" name="message" rows="5" placeholder="How can we help you?"></textarea>
            <div id="messageError" class="error-msg"></div>
          </div>
          <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> Send Message</button>
        </form>
      </div>

      <!-- Right Column -->
      <div>
        <!-- H. Scroll Reveal - Contact Information Card -->
        <div class="info-card" data-aos="fade-left" data-aos-duration="600" data-aos-offset="50" data-aos-delay="100">
          <h2><i class="fas fa-address-card" style="color: var(--primary);"></i> Contact Information</h2>
          <div class="info-detail" data-aos="fade-up" data-aos-duration="400" data-aos-delay="120">
            <div class="info-icon"><i class="fas fa-envelope"></i></div>
            <div class="info-text">
              <p><strong>Email</strong><br>ehsanullah7400@gmail.com<br>qasimMushtaq893@gmail.com</p>
            </div>
          </div>
          <div class="info-detail" data-aos="fade-up" data-aos-duration="400" data-aos-delay="140">
            <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
            <div class="info-text">
              <p><strong>Phone</strong><br>03267322096<br>03167400544</p>
            </div>
          </div>
          <div class="info-detail" data-aos="fade-up" data-aos-duration="400" data-aos-delay="160">
            <div class="info-icon"><i class="fas fa-clock"></i></div>
            <div class="info-text">
              <p><strong>Business Hours</strong></p>
              <div class="hours"><i class="fas fa-calendar-week"></i> Monday - Friday: 9:00 AM - 6:00 PM EST</div>
              <div class="hours"><i class="fas fa-calendar-day"></i> Saturday: 10:00 AM - 4:00 PM EST</div>
              <div class="hours"><i class="fas fa-calendar-times"></i> Sunday: Closed</div>
            </div>
          </div>
        </div>

        <!-- H. Scroll Reveal - Live Chat Button -->
        <button id="liveChatBtn" class="live-chat-btn" data-aos="zoom-in" data-aos-duration="400" data-aos-delay="200"><i class="fas fa-comment-dots"></i> Live Chat with Support</button>

        <!-- H. Scroll Reveal - FAQ Quick Links Card -->
        <div class="quick-links-card" data-aos="fade-left" data-aos-duration="600" data-aos-offset="50" data-aos-delay="150">
          <h3><i class="fas fa-question-circle" style="color: var(--primary);"></i> Quick Answers</h3>
          <a href="ShippingInfo.php" class="faq-link" data-faq="shipping"><i class="fas fa-truck"></i> Shipping
            Policy</a>
          <a href="ReturnPolicy.php" class="faq-link" data-faq="returns"><i class="fas fa-undo-alt"></i> Returns &
            Refunds</a>
          <a href="PaymentMethods.php" class="faq-link" data-faq="payment"><i class="fas fa-credit-card"></i> Payment
            Methods</a>
          <a href="WarrantyInfo.php" class="faq-link" data-faq="warranty"><i class="fas fa-shield-alt"></i> Warranty
            Information</a>
          <a href="Vendors.php" class="faq-link" data-faq="vendor"><i class="fas fa-store"></i> Become a Vendor</a>
          <a href="SupportTicket.php" class="ticket-link" id="trackTicketBtn"><i class="fas fa-ticket-alt"></i> Track
            Your Support Ticket →</a>
        </div>
      </div>
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
        <a href="Categories.php">Categories</a>
        <a href="Blog.php">Tech Blog</a>
        <a href="FAQ.php">FAQ</a>
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

  <!-- Live Chat Modal -->
  <div id="chatModal" class="modal">
    <div class="modal-content">
      <h3><i class="fas fa-comment-dots" style="color: var(--primary);"></i> Live Chat Support</h3>
      <div id="chatMessages" class="chat-window">
        <div style="text-align:center; color:#6B7280;"><i class="fas fa-smile-wink"></i> 👋 Hi there! How can we
          help you today?</div>
      </div>
      <div class="chat-input">
        <input type="text" id="chatInput" placeholder="Type your message...">
        <button id="sendChatBtn"><i class="fas fa-paper-plane"></i> Send</button>
      </div>
      <button class="close-modal" id="closeChatModal"><i class="fas fa-times"></i> Close</button>
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

    // Auto-hide server messages after 5 seconds
    setTimeout(() => {
      const serverSuccess = document.getElementById("serverSuccessMessage");
      const serverError = document.getElementById("serverErrorMessage");
      if (serverSuccess) serverSuccess.style.display = "none";
      if (serverError) serverError.style.display = "none";
    }, 5000);

    // Form Validation & Submission (Frontend validation only - backend handles actual insert)
    const form = document.getElementById("contactForm");
    const successDiv = document.getElementById("formSuccessMessage");

    function validateEmail(email) {
      return /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/.test(email);
    }

    form.addEventListener("submit", (e) => {
      let isValid = true;

      const fullName = document.getElementById("fullName").value.trim();
      const email = document.getElementById("email").value.trim();
      const message = document.getElementById("message").value.trim();

      if (!fullName) {
        document.getElementById("nameError").innerText = "Full name is required";
        isValid = false;
      } else {
        document.getElementById("nameError").innerText = "";
      }

      if (!email) {
        document.getElementById("emailError").innerText = "Email address is required";
        isValid = false;
      } else if (!validateEmail(email)) {
        document.getElementById("emailError").innerText = "Please enter a valid email address";
        isValid = false;
      } else {
        document.getElementById("emailError").innerText = "";
      }

      if (!message) {
        document.getElementById("messageError").innerText = "Message is required";
        isValid = false;
      } else {
        document.getElementById("messageError").innerText = "";
      }

      if (!isValid) {
        e.preventDefault();
      }
    });

    // Live Chat Modal
    const chatModal = document.getElementById("chatModal");
    const liveChatBtn = document.getElementById("liveChatBtn");
    const closeChatModal = document.getElementById("closeChatModal");
    const sendChatBtn = document.getElementById("sendChatBtn");
    const chatInput = document.getElementById("chatInput");
    const chatMessages = document.getElementById("chatMessages");

    liveChatBtn.addEventListener("click", () => {
      chatModal.classList.add("show");
    });

    closeChatModal.addEventListener("click", () => {
      chatModal.classList.remove("show");
    });

    sendChatBtn.addEventListener("click", () => {
      const msg = chatInput.value.trim();
      if (msg) {
        const userMsg = document.createElement("div");
        userMsg.style.textAlign = "right";
        userMsg.style.margin = "5px 0";
        userMsg.style.background = "var(--primary)";
        userMsg.style.color = "white";
        userMsg.style.padding = "8px 12px";
        userMsg.style.borderRadius = "18px";
        userMsg.style.maxWidth = "80%";
        userMsg.style.float = "right";
        userMsg.style.clear = "both";
        userMsg.innerHTML = '<i class="fas fa-user"></i> ' + msg;
        chatMessages.appendChild(userMsg);

        setTimeout(() => {
          const replyMsg = document.createElement("div");
          replyMsg.style.textAlign = "left";
          replyMsg.style.margin = "5px 0";
          replyMsg.style.background = "white";
          replyMsg.style.padding = "8px 12px";
          replyMsg.style.borderRadius = "18px";
          replyMsg.style.maxWidth = "80%";
          replyMsg.style.border = "1px solid #E5E7EB";
          replyMsg.style.clear = "both";
          replyMsg.innerHTML = '<i class="fas fa-headset"></i> Support: Thanks for reaching out! A representative will assist you shortly.';
          chatMessages.appendChild(replyMsg);
          chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 500);

        chatInput.value = "";
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }
    });

    chatInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") sendChatBtn.click();
    });

    // FAQ Quick Links - show alert with info
    document.querySelectorAll(".faq-link").forEach(link => {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        const faqType = link.getAttribute("data-faq");
        let message = "";
        switch (faqType) {
          case "shipping":
            message = "📦 Shipping Policy: Free shipping on orders over $99. Standard delivery 3-7 business days.";
            break;
          case "returns":
            message = "🔄 Returns & Refunds: 30-day return policy for unopened products. Contact support to initiate.";
            break;
          case "payment":
            message = "💳 Payment Methods: We accept Visa, MasterCard, Amex, PayPal, Apple Pay, and Google Pay.";
            break;
          case "warranty":
            message = "🔧 Warranty: All products include manufacturer warranty (1-3 years). Extended warranty available.";
            break;
          case "vendor":
            message = "🏪 Become a Vendor: Visit our Vendor Registration page to apply. No listing fees, competitive commission.";
            break;
          default:
            message = "Visit our FAQ page for more information.";
        }
        alert(message);
      });
    });

    // Track Ticket Button
    document.getElementById("trackTicketBtn").addEventListener("click", (e) => {
      e.preventDefault();
      alert("🔍 Ticket Tracking: Please check your email for support ticket status or login to your account to view open tickets.");
    });

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

    // Updated Cart icon handler
    const cartIcon = document.querySelector('.cart-icon');
    if (cartIcon) {
      cartIcon.addEventListener('click', async () => {
        await checkUserSession();
        if (isUserLoggedIn) {
          window.location.href = "Cart.php";
        } else {
          alert('🛒 Please login to manage your cart');
          window.location.href = "LogIn.php";
        }
      });
    }

    // Close modal when clicking outside
    window.addEventListener("click", (e) => {
      if (e.target === chatModal) {
        chatModal.classList.remove("show");
      }
    });

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