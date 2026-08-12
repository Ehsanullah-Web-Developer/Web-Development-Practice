<?php
// Start session to check vendor login
session_start();

// Check if vendor is logged in (user_id between 11-18)
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] < 11 || $_SESSION['user_id'] > 18) {
    header('Location: LogIn.php');
    exit;
}

$vendorId = $_SESSION['user_id'];
$vendorName = $_SESSION['user_fullname'] ?? 'Vendor';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Vendor Reviews</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Poppins:wght@600;700&display=swap"
        rel="stylesheet">
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

        /* Modern Color Scheme - Matching Logout.php */
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            --success: #10b981;
            --danger: #dc2626;
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

        /* Header - Dark Navy matching Logout.php */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #0F172A;
            box-shadow: var(--shadow-lg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0.9rem 2rem;
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
            border: 1px solid var(--gray-200);
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
            color: var(--gray-600);
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .dropdown-menu a:hover {
            background: var(--gray-100);
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
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            transition: transform 0.2s ease;
            color: #FFFFFF;
        }

        .cart-icon:hover {
            transform: scale(1.05);
            color: var(--primary);
        }

        .cart-count {
            position: absolute;
            top: -10px;
            right: -16px;
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 2px 7px;
            border-radius: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .hamburger {
            display: none;
            font-size: 1.8rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #FFFFFF;
            transition: 0.2s;
        }

        .hamburger:hover {
            color: var(--secondary);
        }

        .mobile-menu-panel {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 340px;
            height: 100%;
            background: white;
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
            transition: all 0.2s;
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
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.8rem;
            color: #CBD5E1;
        }

        /* Reviews Container */
        .reviews-container {
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

        /* Filter Section - White Card */
        .filter-section {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .filter-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .filter-group {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-label {
            font-weight: 600;
            color: var(--gray-700);
        }

        .rating-filter {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .rating-btn {
            background: var(--gray-100);
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .rating-btn:hover {
            background: var(--gray-200);
            transform: translateY(-2px);
        }

        .rating-btn.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        .sort-select {
            padding: 0.5rem 1rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 60px;
            background: white;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .sort-select:focus {
            outline: none;
            border-color: var(--primary);
        }

        /* Table Container - White Card */
        .table-container {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1rem;
            overflow-x: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .table-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .reviews-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        .reviews-table th,
        .reviews-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
            vertical-align: top;
        }

        .reviews-table th {
            color: var(--gray-600);
            font-weight: 700;
            font-size: 0.85rem;
            background: var(--gray-100);
        }

        .reviews-table tr:hover {
            background: var(--gray-100);
        }

        .stars {
            color: var(--warning);
            letter-spacing: 2px;
            font-size: 0.85rem;
        }

        .reply-btn {
            background: var(--gray-100);
            border: none;
            padding: 0.4rem 1.2rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .reply-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--gray-600);
        }

        /* Popup */
        .popup {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background: var(--success);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 60px;
            z-index: 1001;
            display: none;
            animation: fadeInOut 3s ease forwards;
            font-weight: 500;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
            10% {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
            90% {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
            100% {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
        }

        /* Back to Top - Matching Logout.php */
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
            transition: all 0.2s;
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
            transform: translateY(-3px);
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
            .filter-section {
                flex-direction: column;
                align-items: stretch;
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
                <li class="nav-item"><a href="VendorsStore.php" class="nav-link">Vendor Store</a></li>
                <li class="nav-item"><a href="VendorSettings.php" class="nav-link">Vendor Settings</a></li>
                <li class="nav-item"><a href="VendorAddProducts.php" class="nav-link">Vendor Add Products</a></li>
                <li class="nav-item"><a href="VendorProductsManagement.php" class="nav-link">Vendor Products</a></li>
                <li class="nav-item"><a href="VendorOrders.php" class="nav-link">Vendor Orders</a></li>
                <li class="nav-item"><a href="VendorDashboard.php" class="nav-link active">Vendor Dashboard</a></li>
                <li class="nav-item" id="authNavItem"><button id="authButton" class="auth-btn"><i
                            class="fas fa-key"></i> Logout</button></li>
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

    <div class="reviews-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="VendorDashboard.php">Vendor
                Dashboard</a> / <span>Reviews</span>
        </div>
        <h1 class="page-title"><i class="fas fa-star" style="color: var(--warning);"></i> Vendor Reviews</h1>

        <div class="filter-section">
            <div class="filter-group">
                <span class="filter-label"><i class="fas fa-filter"></i> Filter by Rating:</span>
                <div class="rating-filter" id="ratingFilter">
                    <button class="rating-btn active" data-rating="all">All</button>
                    <button class="rating-btn" data-rating="5">5 ★</button>
                    <button class="rating-btn" data-rating="4">4 ★</button>
                    <button class="rating-btn" data-rating="3">3 ★</button>
                    <button class="rating-btn" data-rating="2">2 ★</button>
                    <button class="rating-btn" data-rating="1">1 ★</button>
                </div>
            </div>
            <div class="filter-group">
                <span class="filter-label"><i class="fas fa-sort"></i> Sort by:</span>
                <select id="sortSelect" class="sort-select">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>
        </div>

        <div class="table-container">
            <table class="reviews-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Customer Name</th>
                        <th>Rating</th>
                        <th>Review Comment</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="reviewsTableBody"></tbody>
            </table>
            <div id="emptyState" class="empty-state" style="display: none;"><i class="fas fa-comment-slash"></i> No
                reviews found matching your criteria.</div>
        </div>
    </div>

    <footer class="footer">
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
                <a href="SupportTicket.php">Support Ticket</a>
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
    <div id="popupMessage" class="popup"></div>

    <script>
        // ============== GLOBAL VARIABLES (100% UNCHANGED) ==============
        let currentRatingFilter = "all";
        let currentSort = "newest";
        let currentReviews = [];

        // ============== HELPER FUNCTIONS (100% UNCHANGED) ==============
        function showPopup(message, isError = false) {
            const popup = document.getElementById("popupMessage");
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            popup.style.background = isError ? "#dc2626" : "#10b981";
            popup.style.display = "block";
            setTimeout(() => {
                popup.style.display = "none";
            }, 3000);
        }

        function renderStars(rating) {
            let stars = '';
            for (let i = 0; i < rating; i++) stars += '<i class="fas fa-star"></i>';
            for (let i = rating; i < 5; i++) stars += '<i class="far fa-star"></i>';
            return stars;
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
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

        function sortReviews(reviews) {
            const sorted = [...reviews];
            if (currentSort === "newest") {
                sorted.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            } else {
                sorted.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
            }
            return sorted;
        }

        // ============== API CALLS (100% UNCHANGED) ==============
        async function loadAllReviews() {
            try {
                const response = await fetch('get_vendor_reviews.php');
                const result = await response.json();
                if (result.success) {
                    currentReviews = result.data;
                    renderReviews(sortReviews(currentReviews));
                } else {
                    console.error('Load reviews error:', result.message);
                    showPopup(result.message || 'Failed to load reviews', true);
                }
            } catch (error) {
                console.error('Fetch error:', error);
                showPopup('Failed to load reviews', true);
            }
        }

        async function filterReviews(rating) {
            if (rating === 'all') {
                await loadAllReviews();
                return;
            }
            try {
                const response = await fetch(`filter_vendor_reviews.php?rating=${rating}`);
                const result = await response.json();
                if (result.success) {
                    currentReviews = result.data;
                    renderReviews(sortReviews(currentReviews));
                } else {
                    console.error('Filter error:', result.message);
                    showPopup(result.message || 'Failed to filter reviews', true);
                }
            } catch (error) {
                console.error('Filter error:', error);
                showPopup('Failed to filter reviews', true);
            }
        }

        async function replyToReview(reviewId, replyText) {
            try {
                const response = await fetch('reply_vendor_review.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        vendor_review_id: reviewId,
                        reply_text: replyText
                    })
                });
                const result = await response.json();
                if (result.success) {
                    showPopup('Reply submitted successfully!');
                    await loadAllReviews();
                    return true;
                } else {
                    showPopup(result.message || 'Failed to submit reply', true);
                    return false;
                }
            } catch (error) {
                console.error('Reply error:', error);
                showPopup('Failed to submit reply', true);
                return false;
            }
        }

        // ============== RENDER FUNCTION (100% UNCHANGED) ==============
        function renderReviews(reviews) {
            const tbody = document.getElementById("reviewsTableBody");
            const emptyState = document.getElementById("emptyState");
            if (!tbody) return;
            if (reviews.length === 0) {
                tbody.innerHTML = "";
                emptyState.style.display = "block";
                return;
            }
            emptyState.style.display = "none";
            tbody.innerHTML = reviews.map(review => `
            <tr data-id="${review.vendor_review_id}">
                <td><strong><i class="fas fa-microchip"></i> ${escapeHtml(review.product_name)}</strong></td>
                <td><i class="fas fa-user-circle"></i> ${escapeHtml(review.customer_name)}</div></td>
                <td><div class="stars">${renderStars(review.rating)}</div></div></td>
                <td><i class="fas fa-quote-left"></i> ${escapeHtml(review.comment)}</div></td>
                <td><i class="fas fa-calendar-alt"></i> ${formatDate(review.created_at)}</div></td>
                <td>
                    <button class="reply-btn" onclick="openReplyModal(${review.vendor_review_id}, '${escapeHtml(review.customer_name)}')"><i class="fas fa-reply"></i> Reply</button>
                 </div></td>
             </tr>
        `).join('');
        }

        // ============== REPLY FUNCTION (100% UNCHANGED) ==============
        function openReplyModal(reviewId, customerName) {
            const replyText = prompt(`Reply to ${customerName}:`, "");
            if (replyText !== null && replyText.trim() !== "") {
                replyToReview(reviewId, replyText.trim());
            } else if (replyText !== null) {
                showPopup("Reply cannot be empty", true);
            }
        }

        // ============== FILTER BUTTONS SETUP (100% UNCHANGED) ==============
        function setupFilters() {
            const ratingBtns = document.querySelectorAll('.rating-btn');
            ratingBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    ratingBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    const rating = btn.getAttribute('data-rating');
                    currentRatingFilter = rating;
                    filterReviews(rating);
                });
            });
            const sortSelect = document.getElementById('sortSelect');
            sortSelect.addEventListener('change', (e) => {
                currentSort = e.target.value;
                renderReviews(sortReviews(currentReviews));
            });
        }

        // ============== LOGIN / LOGOUT (100% UNCHANGED) ==============
        function setAuthUI() {
            const authBtn = document.getElementById('authButton');
            if (authBtn) authBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
            renderMobileMenu();
        }

        function handleAuthClick() { window.location.href = 'Logout.php'; }
        document.getElementById('authButton')?.addEventListener('click', handleAuthClick);

        // ============== MOBILE MENU (100% UNCHANGED) ==============
        function renderMobileMenu() {
            const container = document.getElementById('mobileMenuContent');
            if (!container) return;
            const menuItems = [
                { title: "Home", link: "FYPHome.php" },
                { title: "Products", submenu: ["Categories", "Compare Products", "Product Details", "All Products"], links: ["Categories.php", "CompareProducts.php", "ProductDetails.php", "Products1.php"] },
                { title: "Vendors", submenu: ["Vendors List", "Vendors Store", "Vendors Setting", "Vendors Dashboard", "Vendors Products", "Vendors Add Products", "Vendors Edit Products", "Vendors Reviews", "Vendors Orders", "Vendor Order Details"], links: ["Vendors.php", "VendorsStore.php", "VendorsSetting.php", "VendorsDashboard.php", "VendorsProducts.php", "VendorsAddProducts.php", "VendorsEditProducts.php", "VendorsReviews.php", "VendorsOrders.php", "VendorOrderDetails.php"] },
                { title: "Account", submenu: ["My Account", "Profile", "Orders", "Order Details", "Wishlist", "Address Book", "Payment Methods", "Cart", "Checkout", "Checkout Shipping", "Checkout Payment"], links: ["MyAccount.php", "Profile.php", "UserOrders.php", "UserOrderDetails.php", "Wishlist.php", "AddressBook.php", "PaymentMethods.php", "Cart.php", "Checkout.php", "CheckoutShipping.php", "CheckoutPayment.php"] },
                { title: "Support", submenu: ["Contact", "FAQ", "Shipping Info", "Warranty Info", "Return Policy", "Privacy Policy", "Terms of Service", "About Us", "Cookie Policy"], links: ["ContactUs.php", "FAQ.php", "ShippingInfo.php", "WarrantyInfo.php", "ReturnPolicy.php", "PrivacyPolicy.php", "TermsofService.php", "AboutUs.php", "CookiePolicy.php"] },
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
            if (mobileAuth) mobileAuth.onclick = () => { handleAuthClick(); renderMobileMenu(); };
        }

        const hamburger = document.getElementById('hamburgerBtn');
        const mobilePanel = document.getElementById('mobileMenuPanel');
        const overlay = document.getElementById('mobileOverlay');
        function openMobile() { mobilePanel.classList.add('open'); overlay.classList.add('show'); }
        function closeMobile() { mobilePanel.classList.remove('open'); overlay.classList.remove('show'); }
        hamburger?.addEventListener('click', openMobile);
        document.getElementById('closeMobileBtn')?.addEventListener('click', closeMobile);
        overlay?.addEventListener('click', closeMobile);

        // Update cart count
        async function updateCartCount() {
            try {
                const response = await fetch('get_cart_summary.php');
                const result = await response.json();
                if (result.success && result.data) {
                    const count = result.data.total_items || 0;
                    document.getElementById('cartCountDisplay').innerText = count;
                }
            } catch (error) {
                console.error('Cart count error:', error);
            }
        }
        updateCartCount();

        // Cart click
        document.querySelector('.cart-icon')?.addEventListener('click', () => {
            window.location.href = "Cart.php";
        });

        // Back to Top
        const backBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) backBtn.classList.add('show');
            else backBtn.classList.remove('show');
        });
        backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        window.openReplyModal = openReplyModal;

        async function init() {
            setAuthUI();
            renderMobileMenu();
            setupFilters();
            await loadAllReviews();
        }
        init();
    </script>
</body>

</html>