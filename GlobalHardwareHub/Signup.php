<?php
// ============================================
// CRITICAL: session_start() MUST be at the VERY TOP
// No HTML, no echo, no whitespace before this!
// ============================================
session_start();

// Initialize CAPTCHA if not set
if (!isset($_SESSION['captcha_num1']) || !isset($_SESSION['captcha_num2'])) {
    $_SESSION['captcha_num1'] = rand(1, 10);
    $_SESSION['captcha_num2'] = rand(1, 10);
    $_SESSION['captcha_result'] = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
}

// Handle form submission
$error = '';
$success = '';
$full_name = '';
$email = '';
$phone = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'db_connect.php';
    
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $user_type = $_POST['account_type'] ?? 'buyer';
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    $terms = isset($_POST['terms']);
    $captcha_answer = trim($_POST['captcha_answer'] ?? '');
    
    $errors = [];
    
    // Validations
    if (empty($full_name)) {
        $errors['full_name'] = 'Full name is required';
    } elseif (strlen($full_name) < 3) {
        $errors['full_name'] = 'Full name must be at least 3 characters';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address';
    } else {
        $check_stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            $errors['email'] = 'This email is already registered';
        }
        $check_stmt->close();
    }
    
    if (empty($username)) {
        $username = explode('@', $email)[0];
        $username = preg_replace('/[^a-zA-Z0-9_]/', '', $username);
        $base_username = $username;
        $counter = 1;
        $check_stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
        while (true) {
            $check_stmt->bind_param("s", $username);
            $check_stmt->execute();
            $check_stmt->store_result();
            if ($check_stmt->num_rows == 0) break;
            $username = $base_username . $counter;
            $counter++;
        }
        $check_stmt->close();
    } else {
        $check_stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            $errors['username'] = 'Username already taken';
        }
        $check_stmt->close();
    }
    
    if (empty($phone)) {
        $errors['phone'] = 'Phone number is required';
    } elseif (!preg_match('/^[\+]?[(]?[0-9]{1,4}[)]?[-\s\.]?[(]?[0-9]{1,4}[)]?[-\s\.]?[0-9]{3,4}[-\s\.]?[0-9]{3,4}$/', $phone)) {
        $errors['phone'] = 'Enter a valid phone number';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $errors['password'] = 'Password must contain an uppercase letter';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $errors['password'] = 'Password must contain a number';
    }
    
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    if (!$terms) {
        $errors['terms'] = 'You must accept the Terms & Conditions';
    }
    
    if (empty($captcha_answer)) {
        $errors['captcha'] = 'CAPTCHA answer is required';
    } elseif ($captcha_answer != $_SESSION['captcha_result']) {
        $errors['captcha'] = 'Incorrect CAPTCHA answer';
    }
    
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $status = ($user_type === 'vendor') ? 'pending' : 'active';
        $created_at = date('Y-m-d H:i:s');
        
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, username, password_hash, phone, user_type, created_at, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $full_name, $email, $username, $password_hash, $phone, $user_type, $created_at, $status);
        
        if ($stmt->execute()) {
            if ($newsletter) {
                try {
                    $check_newsletter = $conn->prepare("SELECT subscriber_id FROM newsletter_subscribers WHERE email = ?");
                    $check_newsletter->bind_param("s", $email);
                    $check_newsletter->execute();
                    $check_newsletter->store_result();
                    if ($check_newsletter->num_rows == 0) {
                        $newsletter_stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email, created_at) VALUES (?, ?)");
                        $newsletter_stmt->bind_param("ss", $email, $created_at);
                        $newsletter_stmt->execute();
                        $newsletter_stmt->close();
                    }
                    $check_newsletter->close();
                } catch (Exception $e) {}
            }
            
            $success = "Registration successful! Redirecting to login...";
            $_POST = array();
            $full_name = $email = $phone = $username = '';
            $errors = array();
            
            $_SESSION['captcha_num1'] = rand(1, 10);
            $_SESSION['captcha_num2'] = rand(1, 10);
            $_SESSION['captcha_result'] = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
            
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'Login.php';
                }, 2000);
            </script>";
        } else {
            $error = "Registration failed: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Please fix the errors below";
        $_SESSION['captcha_num1'] = rand(1, 10);
        $_SESSION['captcha_num2'] = rand(1, 10);
        $_SESSION['captcha_result'] = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
    }
}

$captcha_num1 = $_SESSION['captcha_num1'];
$captcha_num2 = $_SESSION['captcha_num2'];
$captcha_question = "$captcha_num1 + $captcha_num2 = ?";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Create Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            /* G. Page Fade-In Animation */
            animation: pageFadeIn 0.5s ease-out;
        }

        @keyframes pageFadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            --secondary: #06B6D4;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--gray-200);
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0.8rem 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: var(--primary-gradient);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            font-weight: bold;
            transition: transform 0.2s ease;
        }

        .logo-icon:hover {
            transform: scale(1.05);
        }

        .logo-text .main {
            font-size: 1.35rem;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.3px;
        }

        .logo-text .tagline {
            font-size: 0.6rem;
            color: var(--gray-600);
            letter-spacing: 0.5px;
        }

        /* Main Container */
        .main-container {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
        }

        /* Split Layout */
        /* A. Signup Wrapper Hover Animation */
        .signup-wrapper {
            max-width: 1200px;
            width: 100%;
            display: flex;
            background: white;
            border-radius: 48px;
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            animation: fadeInUp 0.6s ease-out;
        }

        .signup-wrapper:hover {
            transform: translateY(-4px);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.25);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Left Side - Brand Section */
        .brand-section {
            flex: 1;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(37,99,235,0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .brand-content {
            position: relative;
            z-index: 1;
        }

        .brand-badge {
            display: inline-block;
            background: rgba(37,99,235,0.2);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(37,99,235,0.3);
            border-radius: 60px;
            padding: 0.3rem 1rem;
            font-size: 0.7rem;
            color: #60a5fa;
            font-weight: 600;
            margin-bottom: 2rem;
            transition: all 0.2s ease;
        }

        .brand-badge:hover {
            transform: translateY(-2px);
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: white;
        }

        .brand-title span {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .brand-desc {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .features-list {
            list-style: none;
            margin-top: 2rem;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
            color: #cbd5e1;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .features-list li:hover {
            transform: translateX(6px);
        }

        .features-list li i {
            color: var(--primary);
            font-size: 1rem;
            width: 24px;
        }

        .brand-footer {
            position: relative;
            z-index: 1;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .testimonial {
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }

        .testimonial:hover {
            transform: translateX(4px);
        }

        .testimonial-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .testimonial-text {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .testimonial-text strong {
            color: white;
        }

        /* Right Side - Form Section */
        .form-section {
            flex: 1;
            padding: 2.5rem;
            background: white;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--gray-600);
            font-size: 0.85rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.2rem;
            border-radius: 16px;
            margin-bottom: 1.8rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert i {
            font-size: 1.1rem;
        }
        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.8rem;
            letter-spacing: 0.3px;
        }

        .form-group label .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input,
        .form-group select {
            width: 100%;
            padding: 0.9rem 1rem;
            background: white;
            border: 1.5px solid var(--gray-200);
            border-radius: 14px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            outline: none;
            color: var(--gray-800);
            font-family: 'Inter', sans-serif;
            font-weight: 500;
        }

        .input-wrapper input:focus,
        .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-600);
            font-size: 1rem;
            transition: all 0.2s ease;
            padding: 6px;
            border-radius: 50%;
        }

        .toggle-password:hover {
            color: var(--primary);
            background: #eff6ff;
            transform: translateY(-50%) scale(1.05);
        }

        /* Password Strength */
        .password-strength {
            margin-top: 0.6rem;
        }
        .strength-bar {
            height: 4px;
            background: var(--gray-200);
            border-radius: 4px;
            overflow: hidden;
        }
        .strength-fill {
            height: 100%;
            width: 0%;
            transition: width 0.3s;
        }
        #strengthText {
            font-size: 0.65rem;
            margin-top: 0.3rem;
            display: inline-block;
            font-weight: 500;
        }

        /* Account Type */
        .account-type {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        /* C. Account Type Label Hover Animation */
        .account-type label {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            padding: 0.7rem 1rem;
            background: var(--gray-100);
            border-radius: 50px;
            border: 1.5px solid var(--gray-200);
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--gray-700);
            transition: all 0.25s ease;
        }
        .account-type label:hover {
            border-color: var(--primary);
            background: #eff6ff;
            color: var(--primary);
            transform: translateY(-2px) scale(1.02);
        }
        .account-type input[type="radio"] {
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
        }

        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin: 1rem 0;
            transition: all 0.2s ease;
        }
        .checkbox-group:hover {
            transform: translateX(4px);
        }
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
            border-radius: 5px;
        }
        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
            font-size: 0.8rem;
            color: var(--gray-700);
        }
        .checkbox-group label strong {
            color: var(--primary);
        }

        /* CAPTCHA */
        .captcha-box {
            background: var(--gray-100);
            padding: 0.9rem 1rem;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.8rem;
            border: 1.5px solid var(--gray-200);
            transition: all 0.2s ease;
        }
        .captcha-box:hover {
            border-color: var(--primary);
        }
        .captcha-question {
            font-weight: 800;
            color: var(--primary);
            font-size: 1.1rem;
        }
        .captcha-box input {
            width: 110px;
            padding: 0.7rem;
            background: white;
            border: 1.5px solid var(--gray-200);
            border-radius: 12px;
            text-align: center;
            color: var(--gray-800);
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .captcha-box input:focus {
            border-color: var(--primary);
            outline: none;
        }
        /* B. Refresh Button Hover Animation */
        #refreshCaptcha {
            padding: 0.6rem 1.2rem;
            cursor: pointer;
            background: var(--primary-gradient);
            color: white;
            font-size: 0.8rem;
            transition: all 0.25s ease;
            font-weight: 600;
            border: none;
            border-radius: 12px;
        }
        #refreshCaptcha:hover {
            transform: translateY(-2px) scale(1.02);
            opacity: 0.9;
            box-shadow: 0 4px 12px -4px rgba(37,99,235,0.4);
        }

        /* B. Submit Button Hover Animation */
        .signup-btn {
            width: 100%;
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            margin: 1.5rem 0 1rem;
            position: relative;
            overflow: hidden;
        }

        .signup-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .signup-btn:hover::before {
            left: 100%;
        }

        .signup-btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(37,99,235,0.4);
        }

        .login-link {
            text-align: center;
            font-size: 0.85rem;
            margin-top: 1rem;
            color: var(--gray-600);
        }
        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .login-link a:hover {
            text-decoration: underline;
            transform: translateX(2px);
        }

        .error-msg {
            color: #dc2626;
            font-size: 0.7rem;
            margin-top: 0.3rem;
            padding-left: 0.5rem;
        }
        small {
            color: var(--gray-600);
            font-size: 0.65rem;
            display: block;
            margin-top: 0.3rem;
            padding-left: 0.5rem;
        }

        @media (max-width: 900px) {
            .signup-wrapper {
                flex-direction: column;
                max-width: 550px;
            }
            .brand-section {
                padding: 2rem;
            }
            .brand-title {
                font-size: 1.8rem;
            }
            .features-list {
                margin-top: 1rem;
            }
            .brand-footer {
                margin-top: 1.5rem;
            }
        }

        @media (max-width: 600px) {
            .nav-container {
                padding: 0.8rem 1rem;
            }
            .logo-text .main {
                font-size: 1rem;
            }
            .form-section {
                padding: 1.8rem;
            }
            .account-type {
                flex-direction: column;
                gap: 0.5rem;
            }
            .account-type label {
                width: 100%;
            }
            .captcha-box {
                flex-direction: column;
                align-items: stretch;
            }
            .captcha-box input {
                width: 100%;
            }
            .brand-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="header">
    <div class="nav-container">
        <a href="index.php" class="logo">
            <div class="logo-icon"><i class="fas fa-microchip"></i></div>
            <div class="logo-text">
                <span class="main">Global Hardware Hub</span>
                <span class="tagline">Premium PC Components</span>
            </div>
        </a>
    </div>
</header>

<!-- Main Container -->
<div class="main-container">
    <!-- H. Scroll Reveal - Signup Wrapper -->
    <div class="signup-wrapper" data-aos="zoom-in" data-aos-duration="800" data-aos-offset="50">
        <!-- H. Scroll Reveal - Left Side Brand Section -->
        <div class="brand-section" data-aos="fade-right" data-aos-duration="600" data-aos-offset="50" data-aos-delay="50">
            <div class="brand-content">
                <div class="brand-badge">
                    <i class="fas fa-crown"></i> Trusted Since 2024
                </div>
                <h1 class="brand-title">
                    Join the <span>Hardware</span> Revolution
                </h1>
                <p class="brand-desc">
                    Create your account to access exclusive deals, track orders, 
                    and build your dream PC with our trusted vendors.
                </p>
                <ul class="features-list">
                    <li><i class="fas fa-check-circle"></i> 500+ Premium Products</li>
                    <li><i class="fas fa-check-circle"></i> 50+ Trusted Vendors</li>
                    <li><i class="fas fa-check-circle"></i> 24/7 Customer Support</li>
                    <li><i class="fas fa-check-circle"></i> Secure Payments & Fast Shipping</li>
                </ul>
            </div>
            <div class="brand-footer">
                <div class="testimonial">
                    <div class="testimonial-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="testimonial-text">
                        <strong>Alex Chen</strong><br>
                        "Best place for PC components! Fast delivery and great prices."
                    </div>
                </div>
            </div>
        </div>

        <!-- H. Scroll Reveal - Right Side Form Section -->
        <div class="form-section" data-aos="fade-left" data-aos-duration="600" data-aos-offset="50" data-aos-delay="100">
            <div class="form-header" data-aos="fade-up" data-aos-duration="400" data-aos-offset="30" data-aos-delay="50">
                <h2>Create Account</h2>
                <p>Get started with your free account</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error" data-aos="fade-up" data-aos-duration="300" data-aos-delay="80">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success" data-aos="fade-up" data-aos-duration="300" data-aos-delay="80">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="100">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" placeholder="Enter your full name">
                    <div class="error-msg"><?php echo $errors['full_name'] ?? ''; ?></div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="130">
                    <label>Email Address <span class="required">*</span></label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="you@example.com">
                    <div class="error-msg"><?php echo $errors['email'] ?? ''; ?></div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="160">
                    <label>Username (Optional)</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" placeholder="Choose a username">
                    <div class="error-msg"><?php echo $errors['username'] ?? ''; ?></div>
                    <small>Leave empty to auto-generate from email</small>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="190">
                    <label>Phone Number <span class="required">*</span></label>
                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>" placeholder="+1 234 567 8900">
                    <div class="error-msg"><?php echo $errors['phone'] ?? ''; ?></div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="220">
                    <label>Password <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Create a strong password">
                        <button type="button" class="toggle-password" data-target="password"><i class="fas fa-eye"></i></button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div id="strengthFill" class="strength-fill"></div>
                        </div>
                        <span id="strengthText">Enter password</span>
                    </div>
                    <div class="error-msg"><?php echo $errors['password'] ?? ''; ?></div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="250">
                    <label>Confirm Password <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password">
                        <button type="button" class="toggle-password" data-target="confirmPassword"><i class="fas fa-eye"></i></button>
                    </div>
                    <div class="error-msg"><?php echo $errors['confirm_password'] ?? ''; ?></div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="280">
                    <label>Account Type</label>
                    <div class="account-type">
                        <label>
                            <input type="radio" name="account_type" value="buyer" <?php echo (!isset($_POST['account_type']) || $_POST['account_type'] == 'buyer') ? 'checked' : ''; ?>> 👤 Buyer
                        </label>
                        <label>
                            <input type="radio" name="account_type" value="vendor" <?php echo (isset($_POST['account_type']) && $_POST['account_type'] == 'vendor') ? 'checked' : ''; ?>> 🏪 Vendor
                        </label>
                    </div>
                </div>

                <div class="checkbox-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="300">
                    <input type="checkbox" id="newsletter" name="newsletter" <?php echo isset($_POST['newsletter']) ? 'checked' : ''; ?>>
                    <label for="newsletter">Subscribe to newsletter for exclusive deals</label>
                </div>

                <div class="checkbox-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="320">
                    <input type="checkbox" id="terms" name="terms" <?php echo isset($_POST['terms']) ? 'checked' : ''; ?>>
                    <label for="terms">I agree to the <strong>Terms & Conditions</strong> <span class="required">*</span></label>
                </div>
                <div class="error-msg"><?php echo $errors['terms'] ?? ''; ?></div>

                <div class="form-group" data-aos="fade-up" data-aos-duration="300" data-aos-offset="30" data-aos-delay="340">
                    <label>CAPTCHA Verification <span class="required">*</span></label>
                    <div class="captcha-box">
                        <span class="captcha-question"><?php echo $captcha_question; ?></span>
                        <input type="text" name="captcha_answer" placeholder="Answer" autocomplete="off">
                        <button type="button" id="refreshCaptcha">⟳ Refresh</button>
                    </div>
                    <div class="error-msg"><?php echo $errors['captcha'] ?? ''; ?></div>
                </div>

                <button type="submit" class="signup-btn" data-aos="fade-up" data-aos-duration="400" data-aos-delay="370">Create Account</button>

                <div class="login-link" data-aos="fade-up" data-aos-duration="300" data-aos-delay="400">
                    Already have an account? <a href="Login.php">Log In here</a>
                </div>
            </form>
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

    // Password Strength Indicator
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');

    function checkPasswordStrength(pwd) {
        let strength = 0;
        if (pwd.length >= 6) strength++;
        if (pwd.length >= 10) strength++;
        if (/[A-Z]/.test(pwd)) strength++;
        if (/[0-9]/.test(pwd)) strength++;
        if (/[^A-Za-z0-9]/.test(pwd)) strength++;

        if (pwd.length === 0) return {level: 0, text: 'Enter password', color: '#6b7280'};
        if (strength <= 2) return {level: 33, text: 'Weak', color: '#ef4444'};
        if (strength <= 4) return {level: 66, text: 'Medium', color: '#f59e0b'};
        return {level: 100, text: 'Strong', color: '#10b981'};
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const result = checkPasswordStrength(this.value);
            strengthFill.style.width = result.level + '%';
            strengthFill.style.backgroundColor = result.color;
            strengthText.innerText = result.text;
            strengthText.style.color = result.color;
        });
    }

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            if (input) {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                const icon = this.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                }
            }
        });
    });

    // CAPTCHA refresh - reload page to get new numbers
    const refreshBtn = document.getElementById('refreshCaptcha');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.reload();
        });
    }
</script>
</body>
</html>