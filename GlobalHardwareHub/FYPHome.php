<?php
// FYPHome.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Next‑Gen PC Components</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">
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
        }

        :root {
            --primary: #2563EB;
            --primary-dark: #1d4ed8;
            --primary-gradient: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            --secondary: #06B6D4;
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
        }

        .cart-message-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 10001;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .cart-message-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .cart-message-modal {
            background: #FFFFFF;
            border-radius: 28px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            padding: 2rem 1.8rem;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.4);
        }

        .cart-message-overlay.active .cart-message-modal {
            transform: scale(1);
        }

        .cart-message-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem auto;
            font-size: 2.5rem;
        }

        .cart-message-icon.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .cart-message-icon.error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .cart-message-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            font-family: 'Poppins', sans-serif;
        }

        .cart-message-title.success {
            color: #059669;
        }

        .cart-message-title.error {
            color: #dc2626;
        }

        .cart-message-text {
            color: #4B5563;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .cart-message-product {
            background: #F3F4F6;
            padding: 0.6rem 1rem;
            border-radius: 60px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #1F2937;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        .cart-message-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.7rem 2rem;
            border-radius: 60px;
            font-weight: 600;
            cursor: pointer;
        }

        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #0F172A;
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
            gap: 1rem;
            flex-wrap: wrap;
        }

        .logo img {
            height: 62px;
            width: auto;
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

        .nav-links a {
            text-decoration: none;
        }

        .nav-link-item {
            text-decoration: none;
            font-weight: 500;
            color: #FFFFFF;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 1rem;
            border-radius: 60px;
        }

        .nav-link-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .cart-icon {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.4rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            color: #FFFFFF;
            text-decoration: none;
        }

        .cart-icon:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }

        .cart-count {
            background: var(--secondary);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 30px;
            margin-left: 4px;
        }

        .auth-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 0.45rem 1.2rem;
            border-radius: 60px;
            font-weight: 500;
            cursor: pointer;
            font-size: 0.85rem;
            color: #FFFFFF;
        }

        .auth-btn:hover {
            background: var(--primary);
            transform: translateY(-2px);
        }

        .signup-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.45rem 1.2rem;
            border-radius: 60px;
            font-weight: 500;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .login-link {
            text-decoration: none;
            font-weight: 500;
            color: #FFFFFF;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 1rem;
            border-radius: 60px;
        }

        .login-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .hamburger {
            display: none;
            font-size: 1.8rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #FFFFFF;
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
            transition: left 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            overflow-y: auto;
            padding: 1.5rem;
            box-shadow: 2px 0 30px rgba(0, 0, 0, 0.1);
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
        }

        @media (max-width: 900px) {
            .nav-links {
                display: none;
            }
            .hamburger {
                display: block;
            }
            .nav-container {
                padding: 0.7rem 1.2rem;
            }
        }

        .static-hero {
            max-width: 1400px;
            margin: 2rem auto;
            border-radius: 32px;
            background: #FFFFFF;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .static-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .static-hero p {
            color: #475569;
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .filters-bar-section {
            max-width: 1400px;
            margin: 0 auto 2rem auto;
            padding: 0 2rem;
        }

        .filters-container {
            background: #FFFFFF;
            border-radius: 28px;
            padding: 1.5rem 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .filters-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #E5E7EB;
            padding-bottom: 0.7rem;
        }

        .filters-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: flex-end;
        }

        .filter-field {
            flex: 1;
            min-width: 160px;
        }

        .filter-field label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
        }

        .filter-field select,
        .filter-field input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1.5px solid #E5E7EB;
            border-radius: 16px;
            font-size: 0.85rem;
            background: #FFFFFF;
        }

        .filter-field select:focus,
        .filter-field input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .filter-actions {
            display: flex;
            gap: 0.8rem;
            align-items: center;
        }

        .btn-apply-filters {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.7rem 1.8rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-reset-filters {
            background: #F3F4F6;
            color: #374151;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .active-filters-tag {
            margin-top: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            align-items: center;
        }

        .filter-tag {
            background: #EFF6FF;
            color: var(--primary);
            padding: 0.3rem 0.8rem;
            border-radius: 60px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .categories-section {
            max-width: 1400px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .vendors-section {
            max-width: 1400px;
            margin: 3rem auto;
            padding: 2rem;
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .products-section {
            max-width: 1400px;
            margin: 3rem auto;
            padding: 2rem;
            background: #FFFFFF;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1.8rem;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e293b 0%, #2563eb 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60%;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 3px;
        }

        .sale-timer {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            padding: 0.5rem 1.2rem;
            border-radius: 60px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: #92400e;
            font-size: 0.9rem;
        }

        .timer-digits {
            background: #92400e;
            color: #fffbeb;
            padding: 0.2rem 0.6rem;
            border-radius: 40px;
            font-family: monospace;
            font-size: 1rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.8rem;
        }

        .product-card {
            background: #FFFFFF;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #E5E7EB;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.2);
            border-color: var(--primary);
        }

        .product-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #F3F4F6;
        }

        .product-info {
            padding: 1rem 1rem 1.2rem;
        }

        .product-name {
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            min-height: 2.8rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .product-price span {
            font-size: 0.8rem;
            font-weight: 500;
            color: #6B7280;
        }

        .btn-add-cart {
            width: 100%;
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.7rem 0;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .loading-spinner {
            text-align: center;
            padding: 2rem;
            color: var(--primary);
            font-size: 1rem;
            grid-column: 1 / -1;
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: shimmerPulse 1.5s infinite ease-in-out;
            border-radius: 12px;
        }

        @keyframes shimmerPulse {
            0% { background-position: 200% 0; opacity: 0.6; }
            50% { opacity: 1; }
            100% { background-position: -200% 0; opacity: 0.6; }
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .category-card {
            background: #FFFFFF;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #E5E7EB;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            cursor: pointer;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .category-card:hover {
            transform: translateY(-6px);
            border-color: var(--primary);
        }

        .category-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .category-content {
            padding: 1rem;
            text-align: center;
        }

        .category-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.3rem;
        }

        .category-desc {
            font-size: 0.75rem;
            color: #6B7280;
            margin-bottom: 0.8rem;
        }

        .shop-now-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .vendors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .vendor-card {
            background: #FFFFFF;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid #E5E7EB;
            transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .vendor-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary);
        }

        .vendor-cover {
            height: 110px;
            background-size: cover;
            background-position: center;
            background-color: #EFF6FF;
        }

        .vendor-logo-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
            margin-top: -40px;
            margin-bottom: 12px;
        }

        .vendor-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: var(--shadow-md);
        }

        .vendor-content {
            padding: 0 1.2rem 1.2rem 1.2rem;
            text-align: center;
        }

        .vendor-name {
            font-size: 1.25rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
            font-family: 'Poppins', sans-serif;
        }

        .vendor-rating {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-bottom: 10px;
        }

        .stars {
            color: #fbbf24;
            letter-spacing: 2px;
            font-size: 0.85rem;
        }

        .rating-value {
            font-weight: 600;
            color: #374151;
            background: #F3F4F6;
            padding: 2px 8px;
            border-radius: 60px;
            font-size: 0.75rem;
        }

        .vendor-desc {
            color: #6B7280;
            font-size: 0.85rem;
            line-height: 1.45;
            margin-bottom: 12px;
        }

        .vendor-meta {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 16px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--primary);
            background: #EFF6FF;
            padding: 6px 12px;
            border-radius: 60px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .visit-vendor-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
        }

        .quick-actions-section {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .quick-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid #E5E7EB;
        }

        .quick-card i {
            font-size: 2rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.8rem;
        }

        .quick-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            border-radius: 60px;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
        }

        .info-sections {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 1.2rem 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid #E5E7EB;
        }

        .info-title {
            font-size: 1.3rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            color: #111827;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .read-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            padding: 0.4rem 1.2rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
            margin-top: 0.8rem;
            text-decoration: none;
        }

        .footer {
            background: #0F172A;
            color: #CBD5E1;
            padding: 3rem 2rem 1.5rem;
            margin-top: 3rem;
        }

        .footer-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .footer h4 {
            margin-bottom: 1rem;
            color: #FFFFFF;
            font-size: 1rem;
            font-weight: 600;
        }

        .footer a {
            display: block;
            color: #CBD5E1;
            text-decoration: none;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }

        .footer a:hover {
            color: #60A5FA;
        }

        .social-icons i {
            font-size: 1.3rem;
            margin-right: 0.8rem;
            color: #CBD5E1;
            cursor: pointer;
        }

        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 60px;
            padding: 0.6rem 1.2rem;
            cursor: pointer;
            opacity: 0;
            transition: all 0.2s ease;
            z-index: 99;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
        }

        .back-to-top.show {
            opacity: 1;
        }

        @media (max-width: 700px) {
            .static-hero h1 {
                font-size: 2rem;
            }
            .products-grid,
            .categories-grid,
            .vendors-grid {
                grid-template-columns: 1fr;
            }
            .section-title {
                font-size: 1.4rem;
            }
            .filters-row {
                flex-direction: column;
            }
            .filter-actions {
                width: 100%;
            }
            .btn-apply-filters, .btn-reset-filters {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="nav-container">
            <div class="logo"><img src="Logo.jpg" alt="Global Hardware Hub"></div>
            <ul class="nav-links" id="desktopNav">
                <li><a href="FYPHome.php" class="nav-link-item"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="MyAccount.php" class="nav-link-item"><i class="fas fa-user"></i> Account</a></li>
                <li><a href="Login.php" class="login-link"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <li><a href="Signup.php" class="nav-link-item signup-btn"><i class="fas fa-user-plus"></i> Sign Up</a></li>
                <li><a href="Cart.php" class="cart-icon"><i class="fas fa-shopping-cart"></i> Cart <span id="cartCountDisplay" class="cart-count">0</span></a></li>
                <li><button id="authButton" class="auth-btn"><i class="fas fa-key"></i> Logout</button></li>
            </ul>
            <button class="hamburger" id="hamburgerBtn"><i class="fas fa-bars"></i></button>
        </div>
    </header>

    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-menu-panel" id="mobileMenuPanel">
        <button class="close-mobile" id="closeMobileBtn"><i class="fas fa-times"></i></button>
        <div id="mobileMenuContent"></div>
    </div>

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

    <div id="cartMessageOverlay" class="cart-message-overlay">
        <div class="cart-message-modal">
            <div class="cart-message-icon" id="cartMessageIcon"><i class="fas fa-check-circle"></i></div>
            <h3 class="cart-message-title" id="cartMessageTitle">Success!</h3>
            <p class="cart-message-text" id="cartMessageText">Item added to cart successfully!</p>
            <div id="cartMessageProduct" class="cart-message-product"></div>
            <button class="cart-message-btn" id="cartMessageCloseBtn">Continue Shopping</button>
        </div>
    </div>

    <div class="static-hero" data-aos="fade-up">
        <h1>Global Hardware Hub</h1>
        <p>Premium PC components, cutting-edge technology, and expert support — all in one place. Build your dream rig with the best hardware on the market.</p>
    </div>

    <div class="filters-bar-section" data-aos="fade-up">
        <div class="filters-container">
            <div class="filters-title">
                <i class="fas fa-sliders-h"></i>
                <span>Filter Products</span>
            </div>
            <div class="filters-row">
                <div class="filter-field">
                    <label><i class="fas fa-tag"></i> Category</label>
                    <select id="homeFilterCategory">
                        <option value="">All Categories</option>
                        <option value="CPU">CPU (Processors)</option>
                        <option value="GPU">GPU (Graphics Cards)</option>
                        <option value="Motherboard">Motherboard</option>
                        <option value="storage_devices">Storage Devices (SSD/HDD)</option>
                        <option value="peripheral_devices">Peripheral Devices</option>
                        <option value="networking_devices">Networking Devices</option>
                        <option value="mobile_parts">Mobile Parts</option>
                        <option value="laptop_parts">Laptop Parts</option>
                    </select>
                </div>
                <div class="filter-field">
                    <label><i class="fas fa-building"></i> Brand</label>
                    <select id="homeFilterBrand">
                        <option value="">All Brands</option>
                        <option value="Intel">Intel</option>
                        <option value="AMD">AMD</option>
                        <option value="NVIDIA">NVIDIA</option>
                        <option value="ASUS">ASUS</option>
                        <option value="MSI">MSI</option>
                        <option value="Gigabyte">Gigabyte</option>
                        <option value="Corsair">Corsair</option>
                        <option value="Samsung">Samsung</option>
                        <option value="Kingston">Kingston</option>
                        <option value="Seagate">Seagate</option>
                        <option value="WD">Western Digital</option>
                        <option value="Logitech">Logitech</option>
                        <option value="Razer">Razer</option>
                    </select>
                </div>
                <div class="filter-field">
                    <label><i class="fas fa-dollar-sign"></i> Min Price</label>
                    <input type="number" id="homeFilterMinPrice" placeholder="Min PKR" step="1000" min="0">
                </div>
                <div class="filter-field">
                    <label><i class="fas fa-dollar-sign"></i> Max Price</label>
                    <input type="number" id="homeFilterMaxPrice" placeholder="Max PKR" step="1000" min="0">
                </div>
                <div class="filter-actions">
                    <button id="homeApplyFiltersBtn" class="btn-apply-filters"><i class="fas fa-search"></i> Apply Filters</button>
                    <button id="homeResetFiltersBtn" class="btn-reset-filters"><i class="fas fa-redo-alt"></i> Reset</button>
                </div>
            </div>
            <div id="homeActiveFilters" class="active-filters-tag"></div>
        </div>
    </div>

    <div class="categories-section" data-aos="fade-up">
        <h2 class="section-title"><i class="fas fa-th-large"></i> Shop by Category</h2>
        <div class="categories-grid" id="categoriesGrid">
            <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading categories...</div>
        </div>
    </div>

    <div class="products-section" id="featuredSection" data-aos="fade-up">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-star"></i> Featured Products</h2>
        </div>
        <div class="products-grid" id="featuredGrid">
            <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading featured products...</div>
        </div>
    </div>

    <div class="products-section" id="salesSection" data-aos="fade-up">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-tag"></i> Flash Sale</h2>
            <div class="sale-timer" id="saleTimer"><i class="fas fa-hourglass-half"></i> <span>Ends in:</span> <span class="timer-digits" id="timerDigits">--d --h --m</span></div>
        </div>
        <div class="products-grid" id="salesGrid">
            <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading sale items...</div>
        </div>
    </div>

    <div class="vendors-section" data-aos="fade-up">
        <h2 class="section-title"><i class="fas fa-store"></i> Featured Vendors</h2>
        <div class="vendors-grid" id="vendorsGrid">
            <div class="loading-spinner"><i class="fas fa-spinner fa-pulse"></i> Loading vendors...</div>
        </div>
    </div>

    <div class="quick-actions-section" data-aos="fade-up">
        <div class="quick-card"><i class="fas fa-shipping-fast"></i>
            <h3>Shipping Policy</h3>
            <p>Learn about delivery times, shipping costs, and international shipping options.</p>
            <a href="ShippingInfo.php" class="action-btn">Read Policy</a>
        </div>
        <div class="quick-card"><i class="fas fa-file-certificate"></i>
            <h3>Warranty Policy</h3>
            <p>Check your product coverage and file a claim online.</p>
            <a href="WarrantyInfo.php" class="action-btn">Visit Warranty</a>
        </div>
    </div>

    <div class="info-sections" data-aos="fade-up">
        <div class="info-card">
            <div class="info-title"><i class="fas fa-info-circle"></i> About Us</div>
            <p>Global Hardware Hub was founded to provide PC enthusiasts and professionals with high-quality computer components at competitive prices...</p>
            <a href="AboutUs.php" class="read-more-btn">Read More <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="info-card">
            <div class="info-title"><i class="fas fa-cookie-bite"></i> Cookie Policy</div>
            <p>Global Hardware Hub uses cookies to enhance your browsing experience...</p>
            <a href="CookiePolicy.php" class="read-more-btn">Read More <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="info-card">
            <div class="info-title"><i class="fas fa-question-circle"></i> Frequently Asked Questions</div>
            <p>Have questions about our website, products, shipping, returns, or your account?</p>
            <a href="FAQ.php" class="read-more-btn">Visit FAQ Page <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-grid">
            <div>
                <h4>Quick Links 1</h4>
                <a href="ReturnPolicy.php">Return Policy</a>
                <a href="OrderTracking.php">Track Order</a>
                <a href="FAQ.php">FAQs</a>
                <a href="PrivacyPolicy.php">Privacy Policy</a>
            </div>
            <div>
                <h4>Quick Links 2</h4>
                <a href="UserOrders.php">Orders</a>
                <a href="Wishlist.php">Wishlist</a>
                <a href="WarrantyInfo.php">Warranty Info</a>
                <a href="TermsofService.php">Terms of Service</a>
            </div>
            <div>
                <h4>Connect</h4>
                <div class="social-icons"><i class="fab fa-facebook-f"></i> <i class="fab fa-twitter"></i> <i class="fab fa-instagram"></i> <i class="fab fa-youtube"></i></div>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-phone-alt"></i> +92326 7322096</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
            </div>
            <div>
                <h4>Motto</h4>
                <p>⚡ Power Your Passion, Build Without Limits.</p>
                <p>© 2026 Global Hardware Hub</p>
            </div>
        </div>
    </footer>
    <button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i> Top</button>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 600, once: true, offset: 80 });

        function showModal(title, message, highlightText, iconClass = 'fa-store') {
            const modal = document.getElementById('modalOverlay');
            document.getElementById('modalIcon').innerHTML = `<i class="fas ${iconClass}"></i>`;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('modalHighlight').textContent = highlightText;
            modal.classList.add('active');
        }
        function closeModal() { document.getElementById('modalOverlay').classList.remove('active'); }
        document.getElementById('modalCloseBtn')?.addEventListener('click', closeModal);
        document.getElementById('modalConfirmBtn')?.addEventListener('click', closeModal);
        document.getElementById('modalOverlay')?.addEventListener('click', (e) => { if (e.target === document.getElementById('modalOverlay')) closeModal(); });

        function showCartMessage(isSuccess, productName = '') {
            const overlay = document.getElementById('cartMessageOverlay');
            const iconDiv = document.getElementById('cartMessageIcon');
            const titleEl = document.getElementById('cartMessageTitle');
            const textEl = document.getElementById('cartMessageText');
            const productSpan = document.getElementById('cartMessageProduct');
            if (isSuccess) {
                iconDiv.className = 'cart-message-icon success';
                iconDiv.innerHTML = '<i class="fas fa-check-circle"></i>';
                titleEl.className = 'cart-message-title success';
                titleEl.textContent = 'Added to Cart!';
                textEl.textContent = 'Your item has been successfully added to your shopping cart.';
                productSpan.innerHTML = `<i class="fas fa-box"></i> ${escapeHtml(productName)}`;
                productSpan.style.display = 'inline-block';
            } else {
                iconDiv.className = 'cart-message-icon error';
                iconDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
                titleEl.className = 'cart-message-title error';
                titleEl.textContent = 'Login Required';
                textEl.textContent = 'Please login as a customer to add items to cart.';
                productSpan.style.display = 'none';
            }
            overlay.classList.add('active');
        }
        function closeCartMessageModal() { document.getElementById('cartMessageOverlay').classList.remove('active'); }
        document.getElementById('cartMessageCloseBtn')?.addEventListener('click', closeCartMessageModal);
        document.getElementById('cartMessageOverlay')?.addEventListener('click', (e) => { if (e.target === document.getElementById('cartMessageOverlay')) closeCartMessageModal(); });

        let isUserLoggedIn = false;
        let isCustomerRole = false;

        async function checkUserSession() {
            try {
                const response = await fetch('check_session.php');
                const data = await response.json();
                if (data && data.user_id) {
                    isUserLoggedIn = true;
                    isCustomerRole = (data.user_role === 'customer');
                    return true;
                }
                isUserLoggedIn = false;
                isCustomerRole = false;
                return false;
            } catch (error) { return false; }
        }

        async function loadCartCountFromAPI() {
            const cartSpan = document.getElementById("cartCountDisplay");
            if (!cartSpan) return;
            await checkUserSession();
            if (isUserLoggedIn && isCustomerRole) {
                try {
                    const res = await fetch('get_cart_count.php');
                    const data = await res.json();
                    cartSpan.innerText = data.success ? data.cart_count : 0;
                } catch (e) { cartSpan.innerText = "0"; }
            } else { cartSpan.innerText = "0"; }
        }

        function setAuthUI() {
            const btn = document.getElementById("authButton");
            if (btn) btn.innerHTML = isUserLoggedIn ? '<i class="fas fa-sign-out-alt"></i> Logout' : '<i class="fas fa-sign-in-alt"></i> Login';
        }

        function renderMobileMenu() {
            const container = document.getElementById("mobileMenuContent");
            if (!container) return;
            const logged = isUserLoggedIn;
            let html = `<div style="margin-top:1rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%;">${logged ? "<i class='fas fa-sign-out-alt'></i> Logout" : "<i class='fas fa-sign-in-alt'></i> Login"}</button></div><hr style="margin:1rem 0;">`;
            const items = [
                { title: "Home", link: "FYPHome.php" },
                { title: "Account", link: "MyAccount.php" },
                { title: "Login", link: "Login.php" },
                { title: "Sign Up", link: "Signup.php" },
                { title: "Cart", link: "Cart.php" }
            ];
            items.forEach(item => { html += `<div><a href="${item.link}" style="display:block; padding:0.8rem 0; text-decoration:none; color:#374151;">${item.title}</a></div>`; });
            container.innerHTML = html;
            const mobileAuth = document.getElementById("mobileAuthBtn");
            if (mobileAuth) mobileAuth.onclick = () => { if (isUserLoggedIn) location.href = "Logout.php"; else location.href = "Login.php"; };
        }

        async function addToCart(productId, productName) {
            if (!isUserLoggedIn || !isCustomerRole) {
                showCartMessage(false, productName);
                return;
            }
            try {
                const formData = new URLSearchParams();
                formData.append('product_id', productId);
                formData.append('quantity', 1);
                const response = await fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData.toString()
                });
                const data = await response.json();
                if (data.success) {
                    showCartMessage(true, productName);
                    await loadCartCountFromAPI();
                } else {
                    showCartMessage(false, productName);
                }
            } catch (error) {
                showCartMessage(false, productName);
            }
        }

        // Render products using data from get_all_products.php
        function renderProductCards(products, containerId) {
            const container = document.getElementById(containerId);
            if (!container) return;
            if (!products || products.length === 0) {
                container.innerHTML = '<div class="loading-spinner">No products available</div>';
                return;
            }
            
            const cards = products.slice(0, 8).map(p => {
                let imgUrl = p.image_url && p.image_url.trim() !== "" ? p.image_url : "https://placehold.co/400x400/2563eb/white?text=" + encodeURIComponent(p.product_name);
                const escapedName = (p.product_name || '').replace(/'/g, "\\'");
                return `<div class="product-card" data-aos="fade-up" data-aos-duration="400">
                            <img class="product-img" src="${imgUrl}" alt="${escapeHtml(p.product_name)}" onerror="this.src='https://placehold.co/400x400/2563eb/white?text=${encodeURIComponent(p.product_name)}'">
                            <div class="product-info">
                                <div class="product-name">${escapeHtml(p.product_name)}</div>
                                <div class="product-price"><span>PKR</span> ${parseFloat(p.price).toFixed(2)}</div>
                                <button class="btn-add-cart" onclick="addToCart(${p.product_id}, '${escapedName}')">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </div>
                        </div>`;
            }).join('');
            container.innerHTML = cards;
            if (typeof AOS !== 'undefined') AOS.refresh();
        }

        async function fetchProductsAndDisplay() {
            try {
                console.log("Fetching products from get_all_products.php...");
                const response = await fetch('get_all_products.php');
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const data = await response.json();
                
                let products = [];
                if (data.success === true && Array.isArray(data.products)) {
                    products = data.products;
                } else {
                    throw new Error('Invalid response format');
                }
                
                if (products.length === 0) {
                    document.getElementById("featuredGrid").innerHTML = '<div class="loading-spinner">No products found in database</div>';
                    document.getElementById("salesGrid").innerHTML = '<div class="loading-spinner">No products found in database</div>';
                    return;
                }
                
                console.log("Products loaded:", products.length);
                
                const featured = products.slice(0, 8);
                renderProductCards(featured, "featuredGrid");
                
                let saleItems = products.slice(8, 16);
                if (saleItems.length < 4 && products.length > 8) {
                    saleItems = [...saleItems, ...products.slice(0, 4)];
                } else if (saleItems.length === 0 && products.length > 0) {
                    saleItems = products.slice(0, 8);
                }
                renderProductCards(saleItems, "salesGrid");
                
            } catch (err) {
                console.error('Error fetching products:', err);
                document.getElementById("featuredGrid").innerHTML = '<div class="loading-spinner">Failed to load products: ' + err.message + '</div>';
                document.getElementById("salesGrid").innerHTML = '<div class="loading-spinner">Failed to load sale items</div>';
            }
        }

        let timerInterval = null;
        function initSaleTimer() {
            const days = Math.floor(Math.random() * 2) + 2;
            const endTime = new Date().getTime() + (days * 24 * 60 * 60 * 1000);
            function updateTimer() {
                const now = new Date().getTime();
                const diff = endTime - now;
                const timerEl = document.getElementById("timerDigits");
                if (!timerEl) return;
                if (diff <= 0) {
                    if (timerInterval) clearInterval(timerInterval);
                    timerEl.innerText = "0d 0h 0m";
                    return;
                }
                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (86400000)) / (3600000));
                const m = Math.floor((diff % 3600000) / 60000);
                timerEl.innerText = `${d}d ${h}h ${m}m`;
            }
            updateTimer();
            timerInterval = setInterval(updateTimer, 60000);
        }

        async function fetchCategories() {
            const grid = document.getElementById("categoriesGrid");
            if (!grid) return;
            try {
                const response = await fetch('get_categories.php');
                const categories = await response.json();
                if (!Array.isArray(categories) || categories.length === 0) {
                    grid.innerHTML = '<div class="loading-spinner">No categories available</div>';
                    return;
                }
                const displayNames = {
                    'CPU': 'CPU Processors', 'GPU': 'Graphics Cards', 'Motherboard': 'Motherboards',
                    'storage_devices': 'Storage Devices', 'peripheral_devices': 'Peripheral Devices',
                    'networking_devices': 'Networking Devices', 'mobile_parts': 'Mobile Parts', 'laptop_parts': 'Laptop Parts'
                };
                const catsHTML = categories.map((cat, index) => {
                    const catName = cat.name || cat.category_name || '';
                    return `<div class="category-card" onclick="goToCategoryWithFilter('${escapeHtml(catName)}')">
                                <img class="category-image" src="${cat.image_url || 'https://placehold.co/600x400/2563eb/white?text=Category'}" onerror="this.src='https://placehold.co/600x400/2563eb/white?text=Category'">
                                <div class="category-content">
                                    <div class="category-name">${escapeHtml(displayNames[catName] || catName)}</div>
                                    <div class="category-desc">${escapeHtml(cat.description || 'Shop now')}</div>
                                    <button class="shop-now-btn">Shop Now <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>`;
                }).join('');
                grid.innerHTML = catsHTML;
                if (typeof AOS !== 'undefined') AOS.refresh();
            } catch (e) {
                console.error('Error fetching categories:', e);
                grid.innerHTML = '<div class="loading-spinner">Error loading categories</div>';
            }
        }

        async function fetchVendors() {
            const vendorsGrid = document.getElementById("vendorsGrid");
            if (!vendorsGrid) return;
            try {
                const response = await fetch('get_vendors.php');
                const vendors = await response.json();
                if (!Array.isArray(vendors) || vendors.length === 0) {
                    vendorsGrid.innerHTML = '<div class="loading-spinner">No vendors available</div>';
                    return;
                }
                const starsRenderer = (rating) => {
                    let stars = '';
                    for (let i = 0; i < Math.floor(rating); i++) stars += '<i class="fas fa-star"></i>';
                    if (rating % 1 >= 0.5) stars += '<i class="fas fa-star-half-alt"></i>';
                    for (let i = stars.length / 2; i < 5; i++) stars += '<i class="far fa-star"></i>';
                    return `<span class="stars">${stars}</span>`;
                };
                const vendorsHTML = vendors.map((v, index) => {
                    const vendorNameForJs = escapeHtml(v.store_name || v.name || 'Vendor').replace(/'/g, "\\'");
                    return `<div class="vendor-card">
                        <div class="vendor-cover" style="background-image: url('${v.cover_image_url || 'https://placehold.co/800x200/2563eb/white?text=Store'}');"></div>
                        <div class="vendor-logo-wrapper"><img class="vendor-logo" src="${v.logo_url || 'https://placehold.co/200x200/1e293b/white?text=V'}" onerror="this.src='https://placehold.co/200x200/1e293b/white?text=V'"></div>
                        <div class="vendor-content">
                            <div class="vendor-name">${escapeHtml(v.store_name || v.name || 'Hardware Store')}</div>
                            <div class="vendor-rating">${starsRenderer(v.rating || 0)}<span class="rating-value">${(v.rating || 0).toFixed(1)}</span></div>
                            <div class="vendor-desc">${escapeHtml(v.description || 'Quality hardware components')}</div>
                            <div class="vendor-meta"><span><i class="fas fa-boxes"></i> ${v.total_products || 0} Products</span></div>
                            <button class="visit-vendor-btn" onclick="visitVendorStore(${v.vendor_id || v.id || index}, '${vendorNameForJs}')">Visit Store <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>`;
                }).join('');
                vendorsGrid.innerHTML = vendorsHTML;
                if (typeof AOS !== 'undefined') AOS.refresh();
            } catch (e) {
                console.error('Error fetching vendors:', e);
                vendorsGrid.innerHTML = '<div class="loading-spinner">Error loading vendors</div>';
            }
        }

        function visitVendorStore(vendorId, vendorName) {
            let sanitized = vendorName.replace(/\s+/g, '').toLowerCase();
            showModal('Visit Store', `You are about to visit ${vendorName}'s online store.`, `https://${sanitized}.com`, 'fa-store');
        }

        function applyFiltersAndRedirect() {
            const category = document.getElementById('homeFilterCategory')?.value || '';
            const brand = document.getElementById('homeFilterBrand')?.value || '';
            const minPrice = document.getElementById('homeFilterMinPrice')?.value || '';
            const maxPrice = document.getElementById('homeFilterMaxPrice')?.value || '';
            const params = [];
            if (category) params.push(`category=${encodeURIComponent(category)}`);
            if (brand) params.push(`brand=${encodeURIComponent(brand)}`);
            if (minPrice) params.push(`min_price=${parseFloat(minPrice)}`);
            if (maxPrice) params.push(`max_price=${parseFloat(maxPrice)}`);
            window.location.href = params.length ? 'Products1.php?' + params.join('&') : 'Products1.php';
        }

        function resetHomeFilters() {
            document.getElementById('homeFilterCategory').value = '';
            document.getElementById('homeFilterBrand').value = '';
            document.getElementById('homeFilterMinPrice').value = '';
            document.getElementById('homeFilterMaxPrice').value = '';
            updateActiveFiltersDisplay();
        }

        function updateActiveFiltersDisplay() {
            const category = document.getElementById('homeFilterCategory')?.value || '';
            const brand = document.getElementById('homeFilterBrand')?.value || '';
            const minPrice = document.getElementById('homeFilterMinPrice')?.value || '';
            const maxPrice = document.getElementById('homeFilterMaxPrice')?.value || '';
            const container = document.getElementById('homeActiveFilters');
            if (!container) return;
            const filters = [];
            if (category) filters.push({ type: 'category', value: category });
            if (brand) filters.push({ type: 'brand', value: brand });
            if (minPrice) filters.push({ type: 'price', value: `Min: PKR ${minPrice}` });
            if (maxPrice) filters.push({ type: 'price', value: `Max: PKR ${maxPrice}` });
            if (filters.length === 0) { container.innerHTML = ''; return; }
            let html = '<span style="font-size:0.7rem; color:#6B7280;">Active Filters:</span>';
            filters.forEach(f => {
                html += `<span class="filter-tag"><i class="fas fa-filter"></i> ${f.value} <i class="fas fa-times-circle" onclick="removeFilter('${f.type}', '${f.value}')"></i></span>`;
            });
            container.innerHTML = html;
        }

        function removeFilter(type, value) {
            if (type === 'category') document.getElementById('homeFilterCategory').value = '';
            else if (type === 'brand') document.getElementById('homeFilterBrand').value = '';
            else if (type === 'price') {
                if (value.includes('Min:')) document.getElementById('homeFilterMinPrice').value = '';
                else if (value.includes('Max:')) document.getElementById('homeFilterMaxPrice').value = '';
            }
            updateActiveFiltersDisplay();
        }

        function goToCategoryWithFilter(categoryName) {
            window.location.href = `Products1.php?category=${encodeURIComponent(categoryName)}`;
        }

        function escapeHtml(str) { if (!str) return ''; return String(str).replace(/[&<>]/g, m => m === '&' ? '&amp;' : m === '<' ? '&lt;' : '&gt;'); }

        window.addToCart = addToCart;
        window.goToCategoryWithFilter = goToCategoryWithFilter;
        window.visitVendorStore = visitVendorStore;
        window.applyFiltersAndRedirect = applyFiltersAndRedirect;
        window.removeFilter = removeFilter;

        const backBtn = document.getElementById("backToTop");
        if (backBtn) {
            backBtn.onclick = () => window.scrollTo({ top: 0, behavior: "smooth" });
            window.addEventListener("scroll", () => { backBtn.classList.toggle("show", window.scrollY > 300); });
        }

        const hamburger = document.getElementById("hamburgerBtn");
        const panel = document.getElementById("mobileMenuPanel");
        const mobOverlay = document.getElementById("mobileOverlay");
        const closeMob = document.getElementById("closeMobileBtn");
        if (hamburger) hamburger.onclick = () => { panel?.classList.add("open"); mobOverlay?.classList.add("show"); };
        if (closeMob) closeMob.onclick = () => { panel?.classList.remove("open"); mobOverlay?.classList.remove("show"); };
        if (mobOverlay) mobOverlay.onclick = () => { panel?.classList.remove("open"); mobOverlay.classList.remove("show"); };

        async function init() {
            console.log("Initializing page...");
            await checkUserSession();
            setAuthUI();
            await loadCartCountFromAPI();
            renderMobileMenu();
            document.getElementById("authButton")?.addEventListener("click", () => { if (isUserLoggedIn) location.href = "Logout.php"; else location.href = "Login.php"; });
            document.getElementById("homeApplyFiltersBtn")?.addEventListener("click", applyFiltersAndRedirect);
            document.getElementById("homeResetFiltersBtn")?.addEventListener("click", resetHomeFilters);
            document.getElementById("homeFilterCategory")?.addEventListener("change", updateActiveFiltersDisplay);
            document.getElementById("homeFilterBrand")?.addEventListener("change", updateActiveFiltersDisplay);
            document.getElementById("homeFilterMinPrice")?.addEventListener("input", updateActiveFiltersDisplay);
            document.getElementById("homeFilterMaxPrice")?.addEventListener("input", updateActiveFiltersDisplay);
            
            await fetchCategories();
            await fetchVendors();
            await fetchProductsAndDisplay();
            initSaleTimer();
            updateActiveFiltersDisplay();
        }
        init();
    </script>
</body>

</html>