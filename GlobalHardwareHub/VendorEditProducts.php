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
    <title>Global Hardware Hub | Edit Product</title>
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

        .form-container {
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

        .form-section {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 1.8rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.2);
        }

        .form-section h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1.2rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid var(--gray-200);
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
            color: var(--gray-700);
            font-size: 0.85rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 16px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .row-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .rich-editor {
            border: 1.5px solid var(--gray-200);
            border-radius: 20px;
            overflow: hidden;
        }

        .editor-toolbar {
            background: var(--gray-100);
            padding: 0.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .toolbar-btn {
            background: white;
            border: 1px solid var(--gray-200);
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
        }

        .toolbar-btn:hover {
            background: var(--gray-200);
            transform: translateY(-2px);
        }

        .editor-content {
            padding: 0.8rem;
            min-height: 150px;
            outline: none;
        }

        .dropzone {
            border: 2px dashed var(--gray-200);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--gray-100);
        }

        .dropzone.drag-over {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .image-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .preview-item {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            cursor: grab;
        }

        .preview-item.dragging {
            opacity: 0.5;
        }

        .preview-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }

        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
        }

        .spec-table {
            width: 100%;
            margin-bottom: 1rem;
        }

        .spec-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.8rem;
        }

        .spec-row input {
            flex: 1;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .btn-primary,
        .btn-secondary,
        .btn-danger {
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-primary:hover,
        .btn-secondary:hover,
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .btn-danger:hover {
            box-shadow: 0 8px 20px -6px rgba(220, 38, 38, 0.4);
        }

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
            background: white;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            border-radius: 32px;
            padding: 2rem;
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
            .row-2,
            .row-3 {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons button {
                width: 100%;
                justify-content: center;
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
                <li class="nav-item"><a href="VendorReviews.php" class="nav-link">Vendor Reviews</a></li>
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

    <div class="form-container">
        <div class="breadcrumb">
            <a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="VendorDashboard.php">Vendor
                Dashboard</a> / <a href="VendorProductsManagement.php">Products Management</a> / <span>Edit
                Products</span>
        </div>
        <h1 class="page-title"><i class="fas fa-edit"></i> Edit Product</h1>

        <form id="productForm">
            <div class="form-section">
                <h2><i class="fas fa-info-circle"></i> Basic Information</h2>
                <div class="form-group"><label><i class="fas fa-tag"></i> Product Name *</label><input type="text"
                        id="productName" required></div>
                <div class="row-2">
                    <div class="form-group"><label><i class="fas fa-folder"></i> Category *</label><select
                            id="category"></select></div>
                    <div class="form-group"><label><i class="fas fa-building"></i> Brand *</label><select
                            id="brand"></select></div>
                </div>
                <div class="form-group"><label><i class="fas fa-align-left"></i> Description</label>
                    <div class="rich-editor">
                        <div class="editor-toolbar">
                            <button type="button" class="toolbar-btn" data-command="bold"><i
                                    class="fas fa-bold"></i></button>
                            <button type="button" class="toolbar-btn" data-command="italic"><i
                                    class="fas fa-italic"></i></button>
                            <button type="button" class="toolbar-btn" data-command="insertUnorderedList"><i
                                    class="fas fa-list-ul"></i></button>
                        </div>
                        <div id="descriptionEditor" class="editor-content" contenteditable="true"></div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-images"></i> Product Images (Drag to Reorder)</h2>
                <div id="dropzone" class="dropzone"><i class="fas fa-cloud-upload-alt"></i> Drag & drop new images here
                    or click to upload</div>
                <div id="imagePreviewGrid" class="image-preview-grid"></div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-dollar-sign"></i> Pricing</h2>
                <div class="row-2">
                    <div class="form-group"><label><i class="fas fa-tag"></i> Regular Price *</label><input
                            type="number" id="regularPrice" step="0.01"></div>
                    <div class="form-group"><label><i class="fas fa-percent"></i> Sale Price</label><input type="number"
                            id="salePrice" step="0.01"></div>
                </div>
                <div class="row-2">
                    <div class="form-group"><label><i class="fas fa-calendar"></i> Sale Start Date</label><input
                            type="date" id="saleStart"></div>
                    <div class="form-group"><label><i class="fas fa-calendar"></i> Sale End Date</label><input
                            type="date" id="saleEnd"></div>
                </div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-boxes"></i> Inventory</h2>
                <div class="row-2">
                    <div class="form-group"><label><i class="fas fa-barcode"></i> SKU</label><input type="text"
                            id="sku"><button type="button" id="generateSku" class="btn-secondary"
                            style="margin-top:0.3rem; width:100%;"><i class="fas fa-sync-alt"></i> Auto-generate
                            SKU</button></div>
                    <div class="form-group"><label><i class="fas fa-cubes"></i> Stock Quantity *</label><input
                            type="number" id="stockQuantity" min="0"></div>
                </div>
                <div class="form-group"><label><i class="fas fa-exclamation-triangle"></i> Low Stock
                        Threshold</label><input type="number" id="lowStockThreshold" value="5"></div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-cog"></i> Specifications</h2>
                <div id="specsContainer"></div>
                <button type="button" id="addSpecRow" class="btn-secondary"><i class="fas fa-plus"></i> Add
                    Specification</button>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-truck"></i> Shipping Details</h2>
                <div class="row-3">
                    <div class="form-group"><label><i class="fas fa-weight"></i> Weight (kg)</label><input type="number"
                            id="weight" step="0.1"></div>
                    <div class="form-group"><label><i class="fas fa-arrows-alt"></i> Length (cm)</label><input
                            type="number" id="length"></div>
                    <div class="form-group"><label><i class="fas fa-arrows-alt-h"></i> Width (cm)</label><input
                            type="number" id="width"></div>
                    <div class="form-group"><label><i class="fas fa-arrows-alt-v"></i> Height (cm)</label><input
                            type="number" id="height"></div>
                    <div class="form-group"><label><i class="fas fa-hourglass-half"></i> Handling Time</label><select
                            id="handlingTime">
                            <option>1-2 business days</option>
                            <option>3-5 business days</option>
                        </select></div>
                </div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-toggle-on"></i> Product Status</h2>
                <div class="row-2">
                    <div class="form-group"><label class="checkbox-label"><input type="radio" name="status"
                                value="active"> <i class="fas fa-check-circle" style="color: var(--success);"></i>
                            Publish (Active)</label></div>
                    <div class="form-group"><label class="checkbox-label"><input type="radio" name="status"
                                value="draft"> <i class="fas fa-save"></i> Save as Draft</label></div>
                </div>
                <div class="action-buttons">
                    <button type="button" id="deleteBtn" class="btn-danger"><i class="fas fa-trash-alt"></i> Delete
                        Product</button>
                    <button type="button" id="previewBtn" class="btn-secondary"><i class="fas fa-eye"></i>
                        Preview</button>
                    <button type="submit" id="updateBtn" class="btn-primary"><i class="fas fa-save"></i> Update
                        Product</button>
                </div>
            </div>
        </form>
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
                <a href="AddressBook.php">Address Book</a>
                <a href="Products1.php">Products</a>
                <a href="Blog.php">Tech Blog</a>
                <a href="CompareProducts.php">Compare Products</a>
            </div>
            <div class="footer-col">
                <h4>Contact Info</h4>
                <p><i class="fas fa-phone-alt"></i> 03267322096</p>
                <p><i class="fas fa-envelope"></i> ehsanullah7400@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 23 Jinnah Street Gulberg Town Lahore</p>
                <div class="social-icons"><i class="fab fa-facebook-f"></i><i class="fab fa-twitter"></i><i
                        class="fab fa-instagram"></i></div>
            </div>
            <div class="footer-col">
                <h4>Our Motto</h4>
                <p>⚡ Power Your Passion, Build Without Limits.</p>
                <p>© 2026 Global Hardware Hub</p>
            </div>
        </div>
        <div class="copyright">
            <p>Global Hardware Hub | The Ultimate Computer Hardware Marketplace</p>
        </div>
    </footer>
    <button class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i> Top</button>

    <div id="previewModal" class="modal">
        <div class="modal-content" id="previewContent"></div>
    </div>

    <script>
        // ============== GLOBAL VARIABLES ==============
        let currentProduct = null;
        let productId = null;
        let uploadedImages = [];
        let specs = [];
        let categoriesList = [];
        let brandsList = ['Intel', 'AMD', 'NVIDIA', 'Samsung', 'Corsair', 'ASUS', 'MSI', 'Gigabyte', 'WD', 'Kingston'];

        // ============== HELPER FUNCTIONS ==============
        function showPopup(message, isError = false) {
            const popup = document.createElement('div');
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            popup.style.cssText = `position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: ${isError ? '#ef4444' : '#10b981'}; color: white; padding: 12px 24px; border-radius: 60px; z-index: 10000; font-size: 14px; animation: fadeInOut 3s ease forwards; font-weight:500;`;
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 3000);
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/[&<>]/g, function (m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // ============== API CALLS ==============
        async function uploadImageToServer(file) {
            const formData = new FormData();
            formData.append('product_image', file);
            try {
                const response = await fetch('upload_product_image.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) { return result.image_url; }
                else { showPopup(result.message || 'Image upload failed', true); return null; }
            } catch (error) { console.error('Upload error:', error); showPopup('Failed to upload image', true); return null; }
        }

        function getProductIdFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('product_id');
        }

        async function fetchCategories() {
            try {
                const response = await fetch('get_categories.php');
                const categories = await response.json();
                if (!categories.error) { categoriesList = categories; return categoriesList; }
                return [];
            } catch (error) { console.error('Fetch categories error:', error); return []; }
        }

        async function fetchProductDetails() {
            productId = getProductIdFromURL();
            if (!productId) {
                showPopup('Invalid product ID', true);
                setTimeout(() => { window.location.href = 'VendorProductsManagement.php'; }, 2000);
                return false;
            }
            try {
                const response = await fetch(`get_vendor_product_details.php?product_id=${productId}`);
                const result = await response.json();
                if (result.success) {
                    currentProduct = result.data;
                    await prefillForm();
                    return true;
                } else {
                    showPopup(result.message || 'Product not found', true);
                    setTimeout(() => { window.location.href = 'VendorProductsManagement.php'; }, 2000);
                    return false;
                }
            } catch (error) {
                console.error('Fetch error:', error);
                showPopup('Failed to load product details', true);
                return false;
            }
        }

        async function populateDropdowns() {
            const catSelect = document.getElementById('category');
            const brandSelect = document.getElementById('brand');
            const categories = await fetchCategories();
            catSelect.innerHTML = '<option value="">Select Category</option>';
            if (categories.length > 0) {
                categories.forEach(cat => { let opt = document.createElement('option'); opt.value = cat.category_id; opt.textContent = cat.name; catSelect.appendChild(opt); });
            } else {
                const fallbackCats = ['CPU', 'GPU', 'Motherboard', 'Storage', 'RAM', 'PSU', 'Case', 'Cooler', 'Networking'];
                fallbackCats.forEach(c => { let opt = document.createElement('option'); opt.value = c; opt.textContent = c; catSelect.appendChild(opt); });
            }
            brandSelect.innerHTML = '<option value="">Select Brand</option>';
            brandsList.forEach(b => { let opt = document.createElement('option'); opt.value = b; opt.textContent = b; brandSelect.appendChild(opt); });
        }

        async function prefillForm() {
            if (!currentProduct) return;
            document.getElementById('productName').value = currentProduct.product_name || '';
            document.getElementById('sku').value = currentProduct.sku || '';
            document.getElementById('descriptionEditor').innerHTML = currentProduct.description || '';
            document.getElementById('regularPrice').value = currentProduct.regular_price || 0;
            document.getElementById('salePrice').value = currentProduct.sale_price || '';
            // FIX: Use 'stock' not 'stock_quantity'
            document.getElementById('stockQuantity').value = currentProduct.stock || 0;
            const categorySelect = document.getElementById('category');
            if (currentProduct.category_id && currentProduct.category_id > 0) { categorySelect.value = currentProduct.category_id; }
            if (currentProduct.brand) {
                const brandSelect = document.getElementById('brand');
                for (let i = 0; i < brandSelect.options.length; i++) {
                    if (brandSelect.options[i].text === currentProduct.brand) { brandSelect.value = brandSelect.options[i].value; break; }
                }
            }
            const statusValue = currentProduct.status === 'active' ? 'active' : 'draft';
            const statusRadio = document.querySelector(`input[name="status"][value="${statusValue}"]`);
            if (statusRadio) statusRadio.checked = true;
            if (currentProduct.image_url && currentProduct.image_url !== '') { uploadedImages = [currentProduct.image_url]; renderImages(); }
            if (currentProduct.specifications && currentProduct.specifications.length > 0) { specs = currentProduct.specifications; renderSpecs(); }
        }

        // Rich text editor
        document.querySelectorAll('.toolbar-btn').forEach(btn => {
            btn.addEventListener('click', () => { document.execCommand(btn.dataset.command, false, null); });
        });

        // Image management
        let dragSrcIndex = null;
        const dropzone = document.getElementById('dropzone');
        const previewGrid = document.getElementById('imagePreviewGrid');

        if (dropzone) {
            dropzone.addEventListener('click', () => { let input = document.createElement('input'); input.type = 'file'; input.accept = 'image/*'; input.multiple = false; input.onchange = (e) => handleFiles(e.target.files); input.click(); });
            dropzone.addEventListener('dragover', (e) => { e.preventDefault(); dropzone.classList.add('drag-over'); });
            dropzone.addEventListener('dragleave', () => dropzone.classList.remove('drag-over'));
            dropzone.addEventListener('drop', (e) => { e.preventDefault(); dropzone.classList.remove('drag-over'); handleFiles(e.dataTransfer.files); });
        }

        async function handleFiles(files) {
            for (const file of Array.from(files)) {
                if (file.type.startsWith('image/')) {
                    showPopup('Uploading image...', false);
                    const imageUrl = await uploadImageToServer(file);
                    if (imageUrl) { uploadedImages = [imageUrl]; renderImages(); showPopup('Image uploaded successfully!', false); }
                }
            }
        }

        function renderImages() {
            if (!previewGrid) return;
            if (uploadedImages.length === 0) { previewGrid.innerHTML = ''; return; }
            const imageUrl = uploadedImages[0] + '?t=' + Date.now();
            previewGrid.innerHTML = `<div class="preview-item" draggable="true" data-index="0"><img src="${imageUrl}" onerror="this.src='https://placehold.co/100x100/2563eb/white?text=No+Image'"><button class="remove-image" data-index="0"><i class="fas fa-times"></i></button></div>`;
            const item = document.querySelector('.preview-item');
            if (item) {
                item.addEventListener('dragstart', (e) => { dragSrcIndex = parseInt(item.dataset.index); e.dataTransfer.effectAllowed = 'move'; item.classList.add('dragging'); });
                item.addEventListener('dragend', (e) => { item.classList.remove('dragging'); });
                item.addEventListener('dragover', (e) => e.preventDefault());
            }
            const removeBtn = document.querySelector('.remove-image');
            if (removeBtn) { removeBtn.addEventListener('click', () => { uploadedImages = []; renderImages(); showPopup('Image removed', false); }); }
        }

        function renderSpecs() {
            const container = document.getElementById('specsContainer');
            if (!container) return;
            if (specs.length === 0) { container.innerHTML = '<div style="text-align:center; padding:1rem; color:var(--gray-600);"><i class="fas fa-info-circle"></i> No specifications added yet. Click "Add Specification" to add.</div>'; return; }
            container.innerHTML = specs.map((s, i) => `<div class="spec-row"><input type="text" placeholder="Key (e.g., Processor)" value="${escapeHtml(s.key || '')}" class="spec-key-${i}"><input type="text" placeholder="Value (e.g., Intel i7)" value="${escapeHtml(s.value || '')}" class="spec-value-${i}"><button type="button" class="btn-secondary remove-spec" data-index="${i}"><i class="fas fa-trash-alt"></i> Remove</button></div>`).join('');
            specs.forEach((_, idx) => {
                const keyInput = document.querySelector(`.spec-key-${idx}`);
                const valueInput = document.querySelector(`.spec-value-${idx}`);
                if (keyInput && valueInput) {
                    keyInput.addEventListener('input', (e) => { specs[idx].key = e.target.value; });
                    valueInput.addEventListener('input', (e) => { specs[idx].value = e.target.value; });
                }
            });
            document.querySelectorAll('.remove-spec').forEach(btn => { btn.addEventListener('click', () => { specs.splice(parseInt(btn.dataset.index), 1); renderSpecs(); }); });
        }

        document.getElementById('addSpecRow')?.addEventListener('click', () => { specs.push({ key: '', value: '' }); renderSpecs(); });

        async function generateSKU() {
            try {
                const response = await fetch('generate_sku.php');
                const result = await response.json();
                if (result.success) { document.getElementById('sku').value = result.sku; showPopup('SKU generated successfully!', false); }
                else { showPopup(result.message || 'Failed to generate SKU', true); }
            } catch (error) { showPopup('Failed to generate SKU', true); }
        }
        document.getElementById('generateSku')?.addEventListener('click', generateSKU);

        function collectFormData() {
            const status = document.querySelector('input[name="status"]:checked')?.value || 'draft';
            const categoryValue = document.getElementById('category').value;
            const brandValue = document.getElementById('brand').value;
            // FIX: Include stock_quantity in the data being sent
            const stockQty = parseInt(document.getElementById('stockQuantity').value) || 0;
            return {
                product_id: parseInt(productId),
                product_name: document.getElementById('productName').value.trim(),
                sku: document.getElementById('sku').value.trim(),
                category_id: categoryValue ? parseInt(categoryValue) : 0,
                brand: brandValue,
                description: document.getElementById('descriptionEditor').innerHTML,
                regular_price: parseFloat(document.getElementById('regularPrice').value) || 0,
                sale_price: document.getElementById('salePrice').value ? parseFloat(document.getElementById('salePrice').value) : null,
                status: status,
                image_url: uploadedImages[0] || '',
                specifications: specs.filter(s => s.key && s.value),
                stock_quantity: stockQty
            };
        }

        async function updateProduct(productData) {
            console.log('Sending data:', productData);
            try {
                const response = await fetch('update_vendor_product.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(productData)
                });
                if (!response.ok) throw new Error('HTTP error ' + response.status);
                const result = await response.json();
                if (result.success) { showPopup(result.message); setTimeout(() => { window.location.href = 'VendorProductsManagement.php'; }, 1500); }
                else { showPopup(result.message || 'Failed to update product', true); }
            } catch (error) { console.error('Update error:', error); showPopup('Failed to update product: ' + error.message, true); }
        }

        async function deleteProduct() {
            if (!confirm(`Are you sure you want to delete this product permanently?`)) return;
            try {
                const response = await fetch('delete_vendor_product.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ product_id: productId })
                });
                const result = await response.json();
                if (result.success) { showPopup('Product deleted successfully'); setTimeout(() => { window.location.href = 'VendorProductsManagement.php'; }, 1500); }
                else { showPopup(result.message || 'Failed to delete product', true); }
            } catch (error) { showPopup('Failed to delete product', true); }
        }

        function previewProduct() {
            const name = document.getElementById('productName').value.trim() || 'Sample Product';
            const price = document.getElementById('regularPrice').value || '0';
            const desc = document.getElementById('descriptionEditor').innerHTML || 'Product description goes here...';
            const modal = document.getElementById('previewModal');
            document.getElementById('previewContent').innerHTML = `<h3><i class="fas fa-microchip"></i> ${escapeHtml(name)}</h3><p><strong><i class="fas fa-dollar-sign"></i> Price: $${parseFloat(price).toFixed(2)}</strong></p><div>${desc}</div><button onclick="closePreview()" class="btn-primary" style="margin-top:1rem;"><i class="fas fa-times"></i> Close</button>`;
            modal.classList.add('show');
        }
        window.closePreview = () => { document.getElementById('previewModal').classList.remove('show'); };

        document.getElementById('productForm')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const productName = document.getElementById('productName').value.trim();
            const regularPrice = parseFloat(document.getElementById('regularPrice').value);
            if (!productName) { showPopup('Product Name is required', true); return; }
            if (isNaN(regularPrice) || regularPrice <= 0) { showPopup('Valid Regular Price is required', true); return; }
            const formData = collectFormData();
            await updateProduct(formData);
        });
        document.getElementById('deleteBtn')?.addEventListener('click', deleteProduct);
        document.getElementById('previewBtn')?.addEventListener('click', previewProduct);

        // ============== LOGIN / LOGOUT ==============
        function setAuthUI() {
            const authBtn = document.getElementById('authButton');
            if (authBtn) authBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
            renderMobileMenu();
        }
        function handleAuthClick() { window.location.href = 'Logout.php'; }
        document.getElementById('authButton')?.addEventListener('click', handleAuthClick);

        // ============== MOBILE MENU ==============
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
                } else { html += `<div class="mobile-nav-item"><a href="${item.link}" style="display:block; padding:0.8rem 0;">${item.title}</a></div>`; }
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

        async function updateCartCount() {
            try {
                const response = await fetch('get_cart_summary.php');
                const result = await response.json();
                if (result.success && result.data) {
                    const count = result.data.total_items || 0;
                    document.getElementById('cartCountDisplay').innerText = count;
                }
            } catch (error) { console.error('Cart count error:', error); }
        }
        updateCartCount();

        document.querySelector('.cart-icon')?.addEventListener('click', () => { window.location.href = "Cart.php"; });

        const backBtn = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) backBtn.classList.add('show');
            else backBtn.classList.remove('show');
        });
        backBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        async function init() {
            setAuthUI();
            renderMobileMenu();
            await populateDropdowns();
            await fetchProductDetails();
            renderSpecs();
        }
        init();
    </script>
</body>

</html>