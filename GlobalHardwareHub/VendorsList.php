<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Vendors Marketplace</title>
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
            0%, 100% {
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
            from { opacity: 0; }
            to { opacity: 1; }
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

        /* Vendors Container */
        .vendors-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Section Title Animation */
        .section {
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 1.6rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFFFFF 0%, #c7d2fe 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            animation: slideInRight 0.6s ease-out;
            position: relative;
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

        .section-title i {
            transition: transform 0.3s ease;
        }

        .section-title:hover i {
            transform: rotate(15deg) scale(1.1);
        }

        /* New Vendors Slider */
        .slider-container {
            position: relative;
            overflow: hidden;
        }

        .slider-track {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 0.5rem 0.2rem;
            scrollbar-width: thin;
        }

        .slider-track::-webkit-scrollbar {
            height: 6px;
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            z-index: 10;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-50%) scale(1.1);
            box-shadow: var(--shadow-md);
        }

        .slider-btn:active {
            transform: translateY(-50%) scale(0.95);
        }

        .slider-left {
            left: -20px;
        }

        .slider-right {
            right: -20px;
        }

        /* Vendor Cards Animation */
        .vendor-card {
            background: #FFFFFF;
            border-radius: 28px;
            padding: 1.2rem;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-width: 250px;
            flex-shrink: 0;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            animation: cardFloat 0.6s ease-out backwards;
            position: relative;
            overflow: hidden;
        }

        .vendor-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .vendor-card:hover::before {
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

        .vendor-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }

        .vendor-logo {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            object-fit: cover;
            margin-bottom: 0.8rem;
            background: #F3F4F6;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .vendor-card:hover .vendor-logo {
            transform: rotate(5deg) scale(1.05);
            border-radius: 25px;
        }

        .vendor-name {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.3rem;
            color: #111827;
            transition: color 0.3s ease;
        }

        .vendor-card:hover .vendor-name {
            color: var(--primary);
        }

        .stars {
            color: #fbbf24;
            font-size: 0.8rem;
            margin: 0.3rem 0;
            transition: transform 0.3s ease;
        }

        .vendor-card:hover .stars {
            transform: scale(1.05);
        }

        .vendor-meta {
            font-size: 0.7rem;
            color: #6B7280;
            margin: 0.3rem 0;
        }

        .featured-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #FEF3C7;
            color: #D97706;
            font-size: 0.6rem;
            padding: 0.2rem 0.6rem;
            border-radius: 60px;
            margin-left: 0.5rem;
            animation: badgeGlow 2s ease-in-out infinite;
        }

        @keyframes badgeGlow {
            0%, 100% {
                box-shadow: 0 0 0px rgba(217, 119, 6, 0);
            }
            50% {
                box-shadow: 0 0 8px rgba(217, 119, 6, 0.4);
            }
        }

        .btn-visit {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            width: 100%;
            margin-top: 0.8rem;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
        }

        .btn-visit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-visit:hover::before {
            left: 100%;
        }

        .btn-visit:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.5);
        }

        .btn-visit:active {
            transform: translateY(0);
        }

        /* Grid Layouts */
        .vendor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.8rem;
        }

        /* Stagger animation for grid cards */
        .vendor-grid .vendor-card:nth-child(1) { animation-delay: 0.05s; }
        .vendor-grid .vendor-card:nth-child(2) { animation-delay: 0.1s; }
        .vendor-grid .vendor-card:nth-child(3) { animation-delay: 0.15s; }
        .vendor-grid .vendor-card:nth-child(4) { animation-delay: 0.2s; }
        .vendor-grid .vendor-card:nth-child(5) { animation-delay: 0.25s; }
        .vendor-grid .vendor-card:nth-child(6) { animation-delay: 0.3s; }
        .vendor-grid .vendor-card:nth-child(7) { animation-delay: 0.35s; }
        .vendor-grid .vendor-card:nth-child(8) { animation-delay: 0.4s; }

        .vendor-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .vendor-list .vendor-card {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            min-width: auto;
        }

        .vendor-list .vendor-logo {
            margin-bottom: 0;
        }

        .vendor-list .vendor-actions {
            margin-left: auto;
            width: auto;
        }

        .vendor-list .btn-visit {
            width: auto;
            margin-top: 0;
        }

        /* Filter Section Animation */
        .filter-section {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            animation: fadeInUp 0.7s ease-out;
        }

        .filter-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
            align-items: center;
        }

        .search-box {
            flex: 2;
            min-width: 200px;
        }

        .search-box input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 60px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.3s ease;
            background: #FFFFFF;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            transform: scale(1.02);
        }

        .filter-select {
            flex: 1;
            min-width: 140px;
            padding: 0.8rem 1rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 60px;
            background: #FFFFFF;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            transform: scale(1.02);
        }

        .filter-select:hover {
            border-color: var(--primary);
        }

        .action-buttons-group {
            display: flex;
            gap: 0.8rem;
            align-items: center;
        }

        .btn-refresh {
            background: #4B5563;
            color: white;
            border: none;
            padding: 0.7rem 1.2rem;
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

        .btn-refresh:hover {
            background: var(--primary-gradient);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-refresh::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-refresh:hover::before {
            left: 100%;
        }

        .view-toggle {
            display: flex;
            gap: 0.5rem;
        }

        .view-btn {
            background: #F3F4F6;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .view-btn.active {
            background: var(--primary-gradient);
            color: white;
            transform: scale(1.05);
        }

        .view-btn:hover:not(.active) {
            background: #E5E7EB;
            transform: translateY(-2px) scale(1.02);
        }

        .rating-filter {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
        }

        .rating-filter span {
            font-weight: 600;
            color: #374151;
        }

        .rating-btn {
            background: #F3F4F6;
            border: none;
            padding: 0.3rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
        }

        .rating-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .rating-btn:active::before {
            width: 100%;
            height: 100%;
        }

        .rating-btn.active {
            background: var(--primary-gradient);
            color: white;
            transform: scale(1.05);
        }

        .rating-btn:hover:not(.active) {
            background: #E5E7EB;
            transform: translateY(-2px) scale(1.02);
        }

        /* Empty State Animation */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6B7280;
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
            to { transform: rotate(360deg); }
        }

        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        /* Slider Track card stagger */
        .slider-track .vendor-card:nth-child(1) { animation-delay: 0.05s; }
        .slider-track .vendor-card:nth-child(2) { animation-delay: 0.1s; }
        .slider-track .vendor-card:nth-child(3) { animation-delay: 0.15s; }
        .slider-track .vendor-card:nth-child(4) { animation-delay: 0.2s; }
        .slider-track .vendor-card:nth-child(5) { animation-delay: 0.25s; }
        .slider-track .vendor-card:nth-child(6) { animation-delay: 0.3s; }
        .slider-track .vendor-card:nth-child(7) { animation-delay: 0.35s; }
        .slider-track .vendor-card:nth-child(8) { animation-delay: 0.4s; }

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
            .slider-left,
            .slider-right {
                display: none;
            }

            .vendor-list .vendor-card {
                flex-direction: column;
                text-align: center;
            }

            .vendor-list .vendor-actions {
                margin-left: 0;
            }

            .section-title {
                font-size: 1.3rem;
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
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a></li>
                <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
            </ul>

            <button class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <button class="close-mobile" id="closeMobileBtn"
            style="background:none; border:none; font-size:1.8rem; float:right; cursor:pointer; transition:transform 0.3s;"><i class="fas fa-times"></i></button>
        <div id="mobileMenuContent"></div>
    </div>

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

    <div class="vendors-container">
        <!-- New Vendors Section -->
        <div class="section" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
            <h2 class="section-title"><i class="fas fa-sparkle"></i> New Vendors</h2>
            <div class="slider-container">
                <button class="slider-btn slider-left" onclick="slideNew('left')"><i
                        class="fas fa-chevron-left"></i></button>
                <div class="slider-track" id="newSlider"></div>
                <button class="slider-btn slider-right" onclick="slideNew('right')"><i
                        class="fas fa-chevron-right"></i></button>
            </div>
        </div>

        <!-- Top Rated Vendors Section -->
        <div class="section" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
            <h2 class="section-title"><i class="fas fa-trophy"></i> Top Rated Vendors</h2>
            <div id="topRatedGrid" class="vendor-grid"></div>
        </div>

        <!-- All Vendors Section -->
        <div class="section" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
            <h2 class="section-title"><i class="fas fa-search"></i> All Vendors</h2>

            <div class="filter-section">
                <div class="filter-row">
                    <div class="search-box">
                        <input type="text" id="searchInput" placeholder="🔍 Search vendors by name...">
                    </div>
                    <select id="sortFilter" class="filter-select">
                        <option value="rating">Sort by: Rating</option>
                        <option value="products">Sort by: Products Count</option>
                        <option value="newest">Sort by: Newest</option>
                    </select>
                    <div class="action-buttons-group">
                        <button id="refreshBtn" class="btn-refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                    <div class="view-toggle">
                        <button class="view-btn active" data-view="grid"><i class="fas fa-th"></i> Grid</button>
                        <button class="view-btn" data-view="list"><i class="fas fa-list"></i> List</button>
                    </div>
                </div>
                <div class="filter-row">
                    <div class="rating-filter">
                        <span><i class="fas fa-star" style="color: #fbbf24;"></i> Rating: </span>
                        <button class="rating-btn active" data-rating="all">All</button>
                        <button class="rating-btn" data-rating="5">5★</button>
                        <button class="rating-btn" data-rating="4">4★ & up</button>
                        <button class="rating-btn" data-rating="3">3★ & up</button>
                    </div>
                </div>
            </div>

            <div id="allVendorsContainer"></div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col" data-aos="fade-up" data-aos-delay="100">
                <h4>Quick Links 1</h4>
                <a href="AboutUs.php">About Us</a>
                <a href="ContactUs.php">Contact Support</a>
                <a href="OrderTracking.php">Track Order</a>
                <a href="TermsofService.php">Terms of Service</a>
            </div>
            <div class="footer-col" data-aos="fade-up" data-aos-delay="200">
                <h4>Quick Links 2</h4>
                <a href="Wishlist.php">Wishlist</a>
                <a href="PaymentMethods.php">Payment Methods</a>
                <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="ReturnPolicy.php">Return Policy</a>
            </div>
            <div class="footer-col" data-aos="fade-up" data-aos-delay="300">
                <h4>Contact</h4>
                <p><i class="fas fa-phone-alt"></i> 03267322096</p>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
                <div class="social-icons"><i class="fab fa-facebook-f"></i><i class="fab fa-twitter"></i><i
                        class="fab fa-instagram"></i></div>
            </div>
            <div class="footer-col" data-aos="fade-up" data-aos-delay="400">
                <h4>Motto</h4>
                <p>⚡ Power Your Passion, Build Without Limits.</p>
                <p>© 2026 Global Hardware Hub</p>
            </div>
        </div>
        <div class="copyright">Global Hardware Hub | The Ultimate Computer Hardware Marketplace</div>
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

        // ============== GLOBAL VARIABLES ==============
        let allVendors = [];
        let currentView = "grid";
        let filters = {
            search: "",
            rating: "all",
            sort: "rating"
        };

        // ============== HELPER FUNCTIONS ==============
        function showMessage(containerId, message) {
            const container = document.getElementById(containerId);
            if (container) {
                container.innerHTML = `<div class="empty-state"><i class="fas fa-info-circle"></i> ${message}</div>`;
            }
        }

        function renderStars(rating) {
            if (!rating || rating === 0) return "☆☆☆☆☆";
            const fullStars = Math.floor(rating);
            const halfStar = rating % 1 >= 0.5;
            let stars = "";
            for (let i = 0; i < fullStars; i++) stars += "★";
            if (halfStar) stars += "½";
            for (let i = stars.length; i < 5; i++) stars += "☆";
            return stars;
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

        function createVendorCard(vendor, showFeaturedBadge = true, index = 0) {
            const rating = vendor.rating || 0;
            const productsCount = vendor.productsCount || vendor.products_count || 0;
            const joinDate = vendor.joinDate || vendor.created_at;
            const location = vendor.location || 'Global';
            const vendorName = vendor.store_name || vendor.vendor_name || 'Vendor';

            return `
            <div class="vendor-card" data-aos="fade-up" data-aos-delay="${index * 50}" data-aos-duration="600">
                <img class="vendor-logo" src="${vendor.logo_url || vendor.logo || 'https://placehold.co/70x70/2563eb/white?text=Vendor'}" alt="${escapeHtml(vendorName)}" onerror="this.src='https://placehold.co/70x70/2563eb/white?text=Vendor'">
                <div class="vendor-name">${escapeHtml(vendorName)} ${showFeaturedBadge && vendor.featured ? '<span class="featured-badge"><i class="fas fa-star"></i> Featured</span>' : ''}</div>
                <div class="stars">${renderStars(rating)} (${rating})</div>
                <div class="vendor-meta"><i class="fas fa-box"></i> ${productsCount} products</div>
                ${joinDate ? `<div class="vendor-meta"><i class="fas fa-calendar-alt"></i> Joined ${new Date(joinDate).toLocaleDateString()}</div>` : ''}
                <div class="vendor-meta"><i class="fas fa-map-marker-alt"></i> ${escapeHtml(location)}</div>
                <button class="btn-visit" onclick="visitStore(${vendor.vendor_id || vendor.id}, '${escapeHtml(vendorName).replace(/'/g, "\\'")}')"><i class="fas fa-store"></i> Visit Store →</button>
            </div>`;
        }

        function createVendorCardList(vendor, index = 0) {
            const rating = vendor.rating || 0;
            const productsCount = vendor.productsCount || vendor.products_count || 0;
            const location = vendor.location || 'Global';
            const vendorName = vendor.store_name || vendor.vendor_name || 'Vendor';

            return `
            <div class="vendor-card" data-aos="fade-left" data-aos-delay="${index * 50}" data-aos-duration="600">
                <img class="vendor-logo" src="${vendor.logo_url || vendor.logo || 'https://placehold.co/70x70/2563eb/white?text=Vendor'}" alt="${escapeHtml(vendorName)}" onerror="this.src='https://placehold.co/70x70/2563eb/white?text=Vendor'">
                <div>
                    <div class="vendor-name">${escapeHtml(vendorName)} ${vendor.featured ? '<span class="featured-badge"><i class="fas fa-star"></i> Featured</span>' : ''}</div>
                    <div class="stars">${renderStars(rating)} (${rating})</div>
                    <div class="vendor-meta"><i class="fas fa-box"></i> ${productsCount} products | <i class="fas fa-map-marker-alt"></i> ${escapeHtml(location)}</div>
                </div>
                <div class="vendor-actions">
                    <button class="btn-visit" onclick="visitStore(${vendor.vendor_id || vendor.id}, '${escapeHtml(vendorName).replace(/'/g, "\\'")}')"><i class="fas fa-store"></i> Visit Store →</button>
                </div>
            </div>`;
        }

        // ============== FETCH VENDORS ==============
        async function fetchVendors() {
            const newSlider = document.getElementById("newSlider");
            if (newSlider) newSlider.innerHTML = '<div class="empty-state"><i class="fas fa-spinner fa-pulse"></i> Loading vendors...</div>';
            
            try {
                const response = await fetch('get_vendors.php');
                const data = await response.json();
                console.log('API Response:', data);
                if (data && Array.isArray(data)) {
                    allVendors = data;
                } else if (data.success && data.vendors) {
                    allVendors = data.vendors;
                } else {
                    console.error('Invalid API response:', data);
                    allVendors = [];
                }
                renderAllSections();
            } catch (error) {
                console.error('Fetch error:', error);
                allVendors = [];
                renderAllSections();
                showMessage('newSlider', 'Failed to load vendors');
            }
        }

        // ============== RENDER FUNCTIONS ==============
        function renderNewSlider() {
            const newVendors = [...allVendors].sort((a, b) => {
                const dateA = new Date(a.joinDate || a.created_at || 0);
                const dateB = new Date(b.joinDate || b.created_at || 0);
                return dateB - dateA;
            }).slice(0, 8);
            const slider = document.getElementById("newSlider");
            if (!slider) return;
            if (newVendors.length === 0) {
                slider.innerHTML = '<div class="empty-state"><i class="fas fa-info-circle"></i> No new vendors available</div>';
            } else {
                slider.innerHTML = newVendors.map((v, idx) => createVendorCard(v, false, idx)).join('');
            }
        }

        function renderTopRated() {
            const topRated = [...allVendors].sort((a, b) => (b.rating || 0) - (a.rating || 0)).slice(0, 4);
            const grid = document.getElementById("topRatedGrid");
            if (!grid) return;
            if (topRated.length === 0) {
                grid.innerHTML = '<div class="empty-state"><i class="fas fa-info-circle"></i> No top rated vendors available</div>';
            } else {
                grid.innerHTML = topRated.map((v, idx) => createVendorCard(v, true, idx)).join('');
            }
            AOS.refresh();
        }

        function filterAllVendorsList() {
            let filtered = [...allVendors];
            if (filters.search) {
                filtered = filtered.filter(v => (v.store_name || v.vendor_name || '').toLowerCase().includes(filters.search.toLowerCase()));
            }
            if (filters.rating !== "all") {
                const minRating = parseInt(filters.rating);
                filtered = filtered.filter(v => (v.rating || 0) >= minRating);
            }
            if (filters.sort === "rating") {
                filtered.sort((a, b) => (b.rating || 0) - (a.rating || 0));
            } else if (filters.sort === "products") {
                filtered.sort((a, b) => (b.productsCount || b.products_count || 0) - (a.productsCount || a.products_count || 0));
            } else if (filters.sort === "newest") {
                filtered.sort((a, b) => {
                    const dateA = new Date(a.joinDate || a.created_at || 0);
                    const dateB = new Date(b.joinDate || b.created_at || 0);
                    return dateB - dateA;
                });
            }
            return filtered;
        }

        function renderAllVendorsList() {
            const filtered = filterAllVendorsList();
            const container = document.getElementById("allVendorsContainer");
            if (!container) return;
            if (filtered.length === 0) {
                container.innerHTML = '<div class="empty-state"><i class="fas fa-search"></i> No vendors found matching your filters</div>';
                return;
            }
            if (currentView === "grid") {
                container.className = "vendor-grid";
                container.innerHTML = filtered.map((v, idx) => createVendorCard(v, true, idx)).join('');
            } else {
                container.className = "vendor-list";
                container.innerHTML = filtered.map((v, idx) => createVendorCardList(v, idx)).join('');
            }
            AOS.refresh();
        }

        function renderAllSections() {
            renderNewSlider();
            renderTopRated();
            renderAllVendorsList();
            AOS.refresh();
        }

        // ============== SLIDER FUNCTIONS ==============
        function slideNew(direction) {
            const slider = document.getElementById("newSlider");
            if (!slider) return;
            const scrollAmount = 280;
            if (direction === 'left') slider.scrollLeft -= scrollAmount;
            else slider.scrollLeft += scrollAmount;
        }

        // ============== VISIT STORE WITH MODAL ==============
        function visitStore(vendorId, vendorName) {
            let sanitizedVendorName = vendorName.replace(/\s+/g, '').toLowerCase();
            let vendorWebsite = `https://${sanitizedVendorName}.com`;
            showModal('Visit Store', `You are about to visit ${vendorName}'s online store.`, vendorWebsite, 'fa-store');
        }

        // ============== RESET ALL FILTERS ==============
        function resetFilters() {
            // Reset input values
            document.getElementById("searchInput").value = "";
            document.getElementById("sortFilter").value = "rating";
            
            // Reset rating buttons
            document.querySelectorAll(".rating-btn").forEach(btn => {
                btn.classList.remove("active");
                if (btn.dataset.rating === "all") {
                    btn.classList.add("active");
                }
            });
            
            // Reset view
            document.querySelectorAll(".view-btn").forEach(btn => {
                btn.classList.remove("active");
                if (btn.dataset.view === "grid") {
                    btn.classList.add("active");
                }
            });
            
            // Reset filter variables
            filters = {
                search: "",
                rating: "all",
                sort: "rating"
            };
            currentView = "grid";
            
            // Reload and render
            renderAllVendorsList();
            
            // Show success modal
            showModal('Page Refreshed', 'All filters have been reset and vendors reloaded successfully!', 'Vendors updated', 'fa-sync-alt');
        }

        // ============== EVENT LISTENERS ==============
        function setupEventListeners() {
            document.getElementById("searchInput")?.addEventListener("input", (e) => {
                filters.search = e.target.value;
                renderAllVendorsList();
            });
            document.getElementById("sortFilter")?.addEventListener("change", (e) => {
                filters.sort = e.target.value;
                renderAllVendorsList();
            });
            document.querySelectorAll(".rating-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    document.querySelectorAll(".rating-btn").forEach(b => b.classList.remove("active"));
                    btn.classList.add("active");
                    filters.rating = btn.dataset.rating;
                    renderAllVendorsList();
                });
            });
            document.querySelectorAll(".view-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    document.querySelectorAll(".view-btn").forEach(b => b.classList.remove("active"));
                    btn.classList.add("active");
                    currentView = btn.dataset.view;
                    renderAllVendorsList();
                });
            });
            
            // Refresh button
            const refreshBtn = document.getElementById("refreshBtn");
            if (refreshBtn) {
                refreshBtn.addEventListener("click", resetFilters);
            }
        }

        // ============== LOGIN / LOGOUT ==============
        function isLoggedIn() {
            return localStorage.getItem("loggedIn") === "true";
        }

        function setAuthUI() {
            const authBtn = document.getElementById("authButton");
            if (!authBtn) return;
            if (isLoggedIn()) {
                authBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
            } else {
                authBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login';
            }
            renderMobileMenu();
        }

        function handleAuthClick() {
            if (isLoggedIn()) {
                localStorage.setItem("loggedIn", "false");
                window.location.href = "Logout.php";
            } else {
                window.location.href = "LogIn.php";
            }
        }

        // ============== MOBILE MENU ==============
        function renderMobileMenu() {
            const container = document.getElementById("mobileMenuContent");
            if (!container) return;
            const logged = isLoggedIn();
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

        async function updateCartCount() {
            try {
                const response = await fetch('get_cart_summary.php');
                const result = await response.json();
                if (result.success && result.data) {
                    const count = result.data.total_items || 0;
                    const cartCountSpan = document.getElementById("cartCountDisplay");
                    if (cartCountSpan) cartCountSpan.innerText = count;
                }
            } catch (error) {
                console.error('Cart count error:', error);
            }
        }

        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) backBtn.classList.add("show");
            else backBtn.classList.remove("show");
        });
        if (backBtn) {
            backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
        }

        // Make functions globally available
        window.visitStore = visitStore;
        window.slideNew = slideNew;

        async function init() {
            setAuthUI();
            renderMobileMenu();
            updateCartCount();
            setupEventListeners();
            await fetchVendors();
        }

        init();
    </script>
</body>

</html>