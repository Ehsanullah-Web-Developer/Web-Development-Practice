<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | My Orders</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
        }

        /* Modern Color Scheme */
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

        /* Header Animation */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #0F172A;
            backdrop-filter: blur(0);
            box-shadow: var(--shadow-lg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
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
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .logo img:hover {
            transform: scale(1.05) rotate(2deg);
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
            color: #FFFFFF;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 60px;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--secondary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::before {
            width: 70%;
        }

        .nav-link i {
            color: #FFFFFF;
            transition: transform 0.3s ease;
        }

        .nav-link:hover i {
            transform: translateY(-2px);
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
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
            transition: all 0.3s ease;
        }

        .dropdown-menu a:hover {
            background: #F3F4F6;
            color: var(--primary);
            padding-left: 1.6rem;
            transform: translateX(5px);
        }

        .auth-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 0.45rem 1.2rem;
            border-radius: 60px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            font-size: 0.85rem;
            color: #FFFFFF;
        }

        .auth-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px) scale(1.05);
            box-shadow: var(--shadow-sm);
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
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
            transition: transform 0.3s ease;
        }

        .cart-icon:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px) scale(1.05);
        }

        .cart-icon:hover i {
            color: white;
            transform: rotate(10deg);
        }

        .cart-count {
            background: var(--secondary);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 30px;
            margin-left: 4px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .hamburger {
            display: none;
            font-size: 1.8rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #FFFFFF;
            transition: all 0.3s ease;
        }

        .hamburger:hover {
            color: var(--secondary);
            transform: rotate(90deg);
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
            transition: left 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
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
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .mobile-overlay.show {
            display: block;
        }

        /* Footer Animation */
        .footer {
            background: #0F172A;
            color: #CBD5E1;
            padding: 3rem 2rem 1.5rem;
            margin-top: 4rem;
            animation: fadeInUp 0.8s ease-out;
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
            transition: width 0.3s ease;
        }

        .footer-col:hover h4:after {
            width: 70px;
        }

        .footer-col a {
            display: block;
            color: #CBD5E1;
            text-decoration: none;
            margin-bottom: 0.6rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .footer-col a:hover {
            color: #60A5FA;
            transform: translateX(8px);
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
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .social-icons i:hover {
            color: #60A5FA;
            transform: translateY(-5px) scale(1.2);
        }

        .copyright {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: #CBD5E1;
        }

        /* Orders Container */
        .orders-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Breadcrumb Animation */
        .breadcrumb {
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
            animation: fadeInLeft 0.6s ease-out;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .breadcrumb a {
            color: #FFFFFF;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
            padding-left: 5px;
        }

        /* Page Title Animation */
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFFFFF 0%, #c7d2fe 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1.5rem;
            animation: glowPulse 2s ease-in-out infinite, slideInRight 0.6s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes glowPulse {

            0%,
            100% {
                text-shadow: 0 0 0px rgba(255, 255, 255, 0);
            }

            50% {
                text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            }
        }

        /* Filters Section Animation */
        .filters-section {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.7s ease-out;
        }

        .filters-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .filter-group label {
            font-weight: 600;
            color: #374151;
            font-size: 0.8rem;
            transition: color 0.3s ease;
        }

        .filter-group:hover label {
            color: var(--primary);
        }

        .filter-group input,
        .filter-group select {
            padding: 0.7rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.3s ease;
            background: #FFFFFF;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            transform: scale(1.02);
        }

        .filter-group input:hover,
        .filter-group select:hover {
            border-color: var(--primary);
        }

        .btn-filter,
        .btn-refresh {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.7rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            position: relative;
            overflow: hidden;
        }

        .btn-refresh {
            background: #4B5563;
        }

        .btn-refresh:hover {
            background: var(--primary-gradient);
        }

        .btn-filter::before,
        .btn-refresh::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-filter:hover::before,
        .btn-refresh:hover::before {
            left: 100%;
        }

        .btn-filter:hover,
        .btn-refresh:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-filter:active,
        .btn-refresh:active {
            transform: translateY(0);
        }

        .action-buttons-group {
            display: flex;
            gap: 0.8rem;
        }

        /* Orders List */
        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        /* Order Card Animation */
        .order-card {
            background: #FFFFFF;
            border-radius: 28px;
            padding: 1.2rem;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            animation: cardFloat 0.6s ease-out backwards;
            position: relative;
            overflow: hidden;
        }

        .order-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .order-card:hover::before {
            left: 100%;
        }

        @keyframes cardFloat {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .order-card:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }

        /* Stagger animation for order cards */
        .orders-list .order-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .orders-list .order-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .orders-list .order-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .orders-list .order-card:nth-child(4) {
            animation-delay: 0.2s;
        }

        .orders-list .order-card:nth-child(5) {
            animation-delay: 0.25s;
        }

        .orders-list .order-card:nth-child(6) {
            animation-delay: 0.3s;
        }

        .orders-list .order-card:nth-child(7) {
            animation-delay: 0.35s;
        }

        .orders-list .order-card:nth-child(8) {
            animation-delay: 0.4s;
        }

        .orders-list .order-card:nth-child(9) {
            animation-delay: 0.45s;
        }

        .orders-list .order-card:nth-child(10) {
            animation-delay: 0.5s;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-bottom: 0.8rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #E5E7EB;
        }

        .order-id {
            font-weight: 700;
            color: #111827;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s ease;
        }

        .order-card:hover .order-id {
            color: var(--primary);
        }

        .order-date {
            color: #6B7280;
            font-size: 0.8rem;
        }

        /* Status Badge Animation */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0.3rem 1rem;
            border-radius: 60px;
            font-size: 0.7rem;
            font-weight: 700;
            transition: all 0.3s ease;
            animation: badgePop 0.4s ease-out;
        }

        @keyframes badgePop {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .status-pending {
            background: #FED7AA;
            color: #9B2C1D;
        }

        .status-processing {
            background: #C7D2FE;
            color: #3730A3;
        }

        .status-shipped {
            background: #DBEAFE;
            color: var(--primary);
        }

        .status-delivered {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: var(--danger);
        }

        .order-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .order-summary {
            color: #6B7280;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        .order-card:hover .order-summary {
            color: #4B5563;
        }

        .order-actions {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        /* Button Animations */
        .btn-action {
            background: #F3F4F6;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            color: #374151;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            position: relative;
            overflow: hidden;
        }

        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.05), transparent);
            transition: left 0.4s ease;
        }

        .btn-action:hover::before {
            left: 100%;
        }

        .btn-action:hover {
            background: #E5E7EB;
            transform: translateY(-2px) scale(1.02);
        }

        .btn-action:active {
            transform: translateY(0);
        }

        .btn-reorder {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-reorder:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        /* Empty State Animation */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            animation: fadeInScale 0.5s ease-out;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .empty-state h3 {
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .empty-state a .btn-action {
            margin-top: 1rem;
        }

        /* Back to Top Animation */
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
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 99;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: var(--shadow-md);
        }

        .back-to-top.show {
            opacity: 1;
            animation: bounceIn 0.5s ease-out;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .back-to-top:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.5);
        }

        /* Loading Animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        /* Toast Notification Animation */
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
            .order-header {
                flex-direction: column;
            }

            .order-details {
                flex-direction: column;
                align-items: flex-start;
            }

            .filters-grid {
                grid-template-columns: 1fr;
            }

            .page-title {
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
                <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About
                        Us</a></li>
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact
                        Us</a></li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a>
                </li>
                <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span
                        id="cartCountDisplay" class="cart-count">0</span></li>
                <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i
                            class="fas fa-key"></i> Login</button></li>
            </ul>

            <button class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <button class="close-mobile" id="closeMobileBtn"
            style="background:none; border:none; font-size:1.8rem; float:right; cursor:pointer; transition:transform 0.3s;"><i
                class="fas fa-times"></i></button>
        <div id="mobileMenuContent"></div>
    </div>

    <!-- Modal Popup HTML -->
    <div id="modalOverlay" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <button class="modal-close" id="modalCloseBtn"><i class="fas fa-times"></i></button>
                <div class="modal-icon" id="modalIcon"><i class="fas fa-sync-alt"></i></div>
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

    <div class="orders-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="MyAccount.php">My Account</a> /
            <span>Orders</span>
        </div>
        <h1 class="page-title"><i class="fas fa-box"></i> My Orders</h1>

        <div class="filters-section" data-aos="fade-up" data-aos-duration="800">
            <div class="filters-grid">
                <div class="filter-group">
                    <label><i class="fas fa-filter"></i> Order Status</label>
                    <select id="statusFilter">
                        <option value="all">All Orders</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-search"></i> Order ID</label>
                    <input type="text" id="searchInput" placeholder="Search by Order ID...">
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-calendar-alt"></i> From Date</label>
                    <input type="date" id="startDate">
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-calendar-alt"></i> To Date</label>
                    <input type="date" id="endDate">
                </div>
                <div class="filter-group">
                    <div class="action-buttons-group">
                        <button id="applyFiltersBtn" class="btn-filter"><i class="fas fa-check"></i> Apply
                            Filters</button>
                        <button id="refreshBtn" class="btn-refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="ordersList" class="orders-list"></div>
    </div>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col" data-aos="fade-up" data-aos-delay="100">
                <h4>Quick Links 1</h4>
                <a href="CookiePolicy.php">Cookie Policy</a>
                <a href="ContactUs.php">Contact Support</a>
                <a href="WarrantyInfo.php">Warranty Info</a>
                <a href="ReturnPolicy.php">Return Policy</a>
            </div>
            <div class="footer-col" data-aos="fade-up" data-aos-delay="200">
                <h4>Quick Links 2</h4>
                <a href="AddressBook.php">Address Book</a>
                <a href="AboutUs.php">About Us</a>
                <a href="Blog.php">Tech Blog</a>
                <a href="VerifyEmail.php">Verify Email</a>
            </div>
            <div class="footer-col" data-aos="fade-up" data-aos-delay="300">
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
            <div class="footer-col" data-aos="fade-up" data-aos-delay="400">
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

    <!-- AOS Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
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
        let isUserLoggedIn = false;
        let isCustomerRole = false;
        let currentUserId = null;

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

        // Function to load cart count from API
        async function loadCartCountFromAPI() {
            const cartCountSpan = document.getElementById("cartCountDisplay");
            if (!cartCountSpan) return;

            const sessionValid = await checkUserSession();

            if (sessionValid && isCustomerRole) {
                try {
                    const response = await fetch('get_cart_count.php');
                    const data = await response.json();

                    if (data.success) {
                        cartCountSpan.innerText = data.cart_count;
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

        // ============== GLOBAL VARIABLES ==========
        let allOrders = [];
        let currentFilters = {
            status: "all",
            search: "",
            startDate: "",
            endDate: ""
        };

        // ============== HELPER FUNCTIONS ==========
        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }

        function getStatusClass(status) {
            const statusLower = (status || '').toLowerCase();
            const classes = {
                pending: "status-pending",
                processing: "status-processing",
                shipped: "status-shipped",
                completed: "status-delivered",
                delivered: "status-delivered",
                cancelled: "status-cancelled"
            };
            return classes[statusLower] || "status-pending";
        }

        function getStatusText(status) {
            const statusLower = (status || '').toLowerCase();
            const texts = {
                pending: "Pending",
                processing: "Processing",
                shipped: "Shipped",
                completed: "Delivered",
                delivered: "Delivered",
                cancelled: "Cancelled"
            };
            return texts[statusLower] || status || "Pending";
        }

        // ========== LOGIN CHECK ==========
        async function isUserLoggedInCheck() {
            await checkUserSession();
            return isUserLoggedIn;
        }

        // ========== API CALLS ==========
        async function fetchOrderCounts() {
            if (!isUserLoggedIn) return;
            try {
                const response = await fetch('get_order_counts.php');
                const result = await response.json();
                if (result.success && result.counts) {
                    console.log('Order counts:', result.counts);
                }
            } catch (error) {
                console.error('Fetch order counts error:', error);
            }
        }

        async function fetchUserOrders() {
            if (!isUserLoggedIn) return [];
            try {
                const response = await fetch('get_user_orders.php');
                const result = await response.json();
                console.log('API Response:', result);
                if (result.success && result.orders) {
                    allOrders = result.orders;
                    return allOrders;
                } else {
                    console.error('Fetch orders error:', result.message);
                    allOrders = [];
                    return [];
                }
            } catch (error) {
                console.error('Fetch orders error:', error);
                allOrders = [];
                return [];
            }
        }

        function getFilteredOrders() {
            let filtered = [...allOrders];

            if (currentFilters.status !== "all") {
                filtered = filtered.filter(order =>
                    order.status && order.status.toLowerCase() === currentFilters.status.toLowerCase()
                );
            }

            if (currentFilters.search.trim()) {
                const searchLower = currentFilters.search.toLowerCase();
                filtered = filtered.filter(order =>
                    order.order_id && order.order_id.toString().toLowerCase().includes(searchLower)
                );
            }

            if (currentFilters.startDate) {
                const start = new Date(currentFilters.startDate);
                start.setHours(0, 0, 0, 0);
                filtered = filtered.filter(order => {
                    const orderDate = new Date(order.created_at);
                    return orderDate >= start;
                });
            }

            if (currentFilters.endDate) {
                const end = new Date(currentFilters.endDate);
                end.setHours(23, 59, 59, 999);
                filtered = filtered.filter(order => {
                    const orderDate = new Date(order.created_at);
                    return orderDate <= end;
                });
            }

            filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            return filtered;
        }

        window.cancelOrder = async function (orderId) {
            const confirmed = confirm(`Are you sure you want to cancel order #${orderId}?`);
            if (!confirmed) return;

            const btn = event.currentTarget;
            btn.style.transform = 'scale(0.95)';

            try {
                const response = await fetch('cancel_user_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order_id: orderId })
                });
                const result = await response.json();
                if (result.success) {
                    showModal('Order Cancelled', 'Your order has been cancelled successfully!', 'fa-check-circle');
                    await refreshOrders();
                } else {
                    showModal('Error', result.message || 'Failed to cancel order', 'fa-exclamation-circle');
                    btn.style.transform = 'scale(1)';
                }
            } catch (error) {
                console.error('Cancel order error:', error);
                showModal('Error', 'Failed to cancel order. Please try again.', 'fa-exclamation-circle');
                btn.style.transform = 'scale(1)';
            }
        };

        // FIXED: Reorder function - adds items to cart and redirects to checkout
        window.reorderOrder = async function (orderId) {
            const btn = event.currentTarget;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Adding...';
            btn.disabled = true;

            try {
                const response = await fetch('reorder.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ order_id: orderId })
                });

                // Check if response is OK
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }

                const result = await response.json();

                if (result.success) {
                    await updateCartCount();
                    showModal('Reorder Successful!', result.message + ' Redirecting to checkout...', 'fa-check-circle');
                    setTimeout(() => {
                        window.location.href = 'Checkout.php';
                    }, 1500);
                } else {
                    showModal('Reorder Failed', result.message || 'Failed to add items to cart', 'fa-exclamation-circle');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            } catch (error) {
                console.error('Reorder error:', error);
                showModal('Error', 'Failed to reorder. Please try again. Error: ' + error.message, 'fa-exclamation-circle');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        };

        window.viewOrderDetails = function (orderId) {
            const btn = event.currentTarget;
            btn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                window.location.href = `UserOrderDetails.php?order_id=${orderId}`;
            }, 150);
        };

        window.trackOrder = function (orderId) {
            const btn = event.currentTarget;
            btn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                window.location.href = `OrderTracking.php?order_id=${orderId}`;
            }, 150);
        };

        function renderOrders() {
            const filtered = getFilteredOrders();
            const container = document.getElementById("ordersList");

            if (!container) return;

            if (filtered.length === 0) {
                container.innerHTML = `
                <div class="empty-state" data-aos="fade-up" data-aos-duration="600">
                    <h3><i class="fas fa-inbox"></i> No orders found</h3>
                    <p>Try adjusting your filters or start shopping!</p>
                    <a href="Products1.php"><button class="btn-action" style="margin-top: 1rem;"><i class="fas fa-shopping-cart"></i> Continue Shopping</button></a>
                </div>
            `;
                return;
            }

            container.innerHTML = filtered.map((order, index) => `
            <div class="order-card" data-aos="fade-up" data-aos-delay="${index * 50}" data-aos-duration="600">
                <div class="order-header">
                    <div>
                        <span class="order-id"><i class="fas fa-hashtag"></i> ${order.order_id}</span>
                        <span class="order-date"><i class="fas fa-calendar-alt"></i> ${formatDate(order.created_at)}</span>
                    </div>
                    <span class="status-badge ${getStatusClass(order.status)}"><i class="fas ${order.status && order.status.toLowerCase() === 'delivered' ? 'fa-check-circle' : (order.status && order.status.toLowerCase() === 'cancelled' ? 'fa-times-circle' : 'fa-clock')}"></i> ${getStatusText(order.status)}</span>
                </div>
                <div class="order-details">
                    <div class="order-summary">
                        <i class="fas fa-box"></i> <strong>${order.item_count || order.total_items || 0}</strong> item(s) • 
                        Total: <strong>PKR ${parseFloat(order.total_amount).toFixed(2)}</strong>
                        ${order.payment_method ? `<br><i class="fas fa-credit-card"></i> <small>Payment: ${order.payment_method}</small>` : ''}
                    </div>
                    <div class="order-actions">
                        ${order.status && order.status.toLowerCase() !== 'cancelled' && order.status.toLowerCase() !== 'completed' && order.status.toLowerCase() !== 'delivered' ?
                    `<button class="btn-action" onclick="cancelOrder(${order.order_id})"><i class="fas fa-times-circle"></i> Cancel</button>` : ''}
                        <button class="btn-action btn-reorder" onclick="reorderOrder(${order.order_id})"><i class="fas fa-sync-alt"></i> Reorder</button>
                        <button class="btn-action" onclick="trackOrder(${order.order_id})"><i class="fas fa-map-marker-alt"></i> Track Order</button>
                        <button class="btn-action" onclick="viewOrderDetails(${order.order_id})"><i class="fas fa-eye"></i> View Details</button>
                    </div>
                </div>
            </div>
        `).join('');

            // Refresh AOS for new elements
            AOS.refresh();
        }

        window.applyFilters = function () {
            currentFilters.status = document.getElementById("statusFilter")?.value || "all";
            currentFilters.search = document.getElementById("searchInput")?.value || "";
            currentFilters.startDate = document.getElementById("startDate")?.value || "";
            currentFilters.endDate = document.getElementById("endDate")?.value || "";
            renderOrders();
        };

        // CHANGE 1: Refresh button functionality
        window.refreshPage = function () {
            // Reset all filter inputs
            document.getElementById("statusFilter").value = "all";
            document.getElementById("searchInput").value = "";
            document.getElementById("startDate").value = "";
            document.getElementById("endDate").value = "";

            // Reset filter variables
            currentFilters = {
                status: "all",
                search: "",
                startDate: "",
                endDate: ""
            };

            // Reload orders from API
            refreshOrders();

            // Show success modal
            showModal('Page Refreshed', 'All filters have been reset and orders reloaded successfully!', 'fa-sync-alt');
        };

        async function refreshOrders() {
            const container = document.getElementById("ordersList");
            if (container) {
                container.innerHTML = '<div class="empty-state"><h3><i class="fas fa-spinner fa-pulse"></i> Loading your orders...</h3></div>';
            }
            await fetchUserOrders();
            renderOrders();
            await fetchOrderCounts();
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
                    html += `<div class="mobile-nav-item"><div class="mobile-nav-header" data-toggle="${item.title}" style="display:flex; justify-content:space-between; padding:0.8rem 0; cursor:pointer; transition:all 0.3s;"><span>${item.title}</span> <i class="fas fa-chevron-down" style="transition:transform 0.3s;"></i></div><div class="mobile-submenu" id="submenu-${item.title}" style="padding-left:1rem; display:none;">`;
                    item.submenu.forEach((sub, idx) => { html += `<a href="${item.links[idx]}" style="display:block; padding:0.5rem 0; transition:all 0.3s;">${sub}</a>`; });
                    html += `</div></div>`;
                } else {
                    html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0; transition:all 0.3s;">${item.title}</a></div>`;
                }
            });
            container.innerHTML = html;
            document.querySelectorAll(".mobile-nav-header").forEach(header => {
                header.addEventListener("click", (e) => {
                    const key = header.getAttribute("data-toggle");
                    const sub = document.getElementById(`submenu-${key}`);
                    const icon = header.querySelector('i');
                    if (sub) {
                        if (sub.style.display === "none") {
                            sub.style.display = "block";
                            icon.style.transform = "rotate(180deg)";
                        } else {
                            sub.style.display = "none";
                            icon.style.transform = "rotate(0deg)";
                        }
                    }
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

        // Back to Top
        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        if (backBtn) {
            backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
        }

        // Cart icon click
        document.querySelector('.cart-icon')?.addEventListener('click', async () => {
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

        // Auth button
        document.getElementById("authButton")?.addEventListener("click", handleAuthClick);

        // Refresh button event listener
        document.getElementById("refreshBtn")?.addEventListener("click", refreshPage);

        // ========== INITIALIZE PAGE ==========
        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();

            if (!isUserLoggedIn) {
                const container = document.getElementById("ordersList");
                if (container) {
                    container.innerHTML = `
                    <div class="empty-state" data-aos="fade-up" data-aos-duration="600">
                        <h3><i class="fas fa-lock"></i> Please Login First</h3>
                        <p>You need to be logged in to view your orders.</p>
                        <a href="LogIn.php"><button class="btn-action" style="margin-top: 1rem;"><i class="fas fa-sign-in-alt"></i> Login Now</button></a>
                    </div>
                `;
                }
                return;
            }

            await refreshOrders();

            const statusFilter = document.getElementById("statusFilter");
            const searchInput = document.getElementById("searchInput");
            const startDate = document.getElementById("startDate");
            const endDate = document.getElementById("endDate");
            const applyBtn = document.getElementById("applyFiltersBtn");

            if (statusFilter) statusFilter.addEventListener("change", applyFilters);
            if (searchInput) searchInput.addEventListener("input", applyFilters);
            if (startDate) startDate.addEventListener("change", applyFilters);
            if (endDate) endDate.addEventListener("change", applyFilters);
            if (applyBtn) applyBtn.addEventListener("click", applyFilters);
        }

        init();
    </script>
</body>

</html>