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
    <title>Global Hardware Hub | Add New Product</title>
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

        /* Form Container */
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

        /* Form Sections - White Cards */
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

        /* Rich Text Editor */
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

        /* Image Upload */
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
            transition: transform 0.1s ease;
        }

        .preview-item:active {
            cursor: grabbing;
        }

        .preview-item.dragging {
            opacity: 0.5;
        }

        .preview-item.drag-over {
            border: 2px dashed var(--primary);
            transform: scale(1.02);
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
            font-size: 12px;
            transition: all 0.2s;
        }

        .remove-image:hover {
            background: var(--danger);
            transform: scale(1.1);
        }

        /* Specifications */
        .spec-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.8rem;
        }

        .spec-row input {
            flex: 1;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .btn-primary,
        .btn-secondary {
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

        .btn-primary:hover,
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
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
                <li class="nav-item"><a href="VendorReviews.php" class="nav-link"> Vendor Reviews</a></li>
                <li class="nav-item"><a href="VendorProductsManagement.php.php" class="nav-link"> Vendor Products</a></li>
                <li class="nav-item"><a href="VendorSettings.php" class="nav-link"> Vendor Settings</a></li>
                <li class="nav-item"><a href="VendorsStore.php" class="nav-link"> Vendor Store</a></li>
                <li class="nav-item"><a href="VendorOrders.php" class="nav-link"> Vendor Orders</a></li>
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
                Dashboard</a> / <a href="VendorProductsManagement.php">Products Management</a> / <span>Add
                Products</span>
        </div>
        <h1 class="page-title"><i class="fas fa-plus-circle"></i> Add New Product</h1>

        <form id="productForm">
            <div class="form-section">
                <h2><i class="fas fa-info-circle"></i> Basic Information</h2>
                <div class="form-group"><label><i class="fas fa-tag"></i> Product Name *</label><input type="text"
                        id="productName" required></div>
                <div class="row-2">
                    <div class="form-group"><label><i class="fas fa-folder"></i> Category *</label><select
                            id="category">
                            <option value="">Loading categories...</option>
                        </select></div>
                    <div class="form-group"><label><i class="fas fa-building"></i> Brand *</label><select id="brand">
                            <option value="Intel">Intel</option>
                            <option value="AMD">AMD</option>
                            <option value="NVIDIA">NVIDIA</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Corsair">Corsair</option>
                            <option value="ASUS">ASUS</option>
                            <option value="MSI">MSI</option>
                            <option value="Gigabyte">Gigabyte</option>
                        </select></div>
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
                <h2><i class="fas fa-images"></i> Product Images</h2>
                <div id="dropzone" class="dropzone"><i class="fas fa-cloud-upload-alt"></i> Drag & drop images here or
                    click to upload</div>
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
                            <option value="1-2 business days">1-2 business days</option>
                            <option value="3-5 business days">3-5 business days</option>
                        </select></div>
                </div>
            </div>

            <div class="form-section">
                <h2><i class="fas fa-toggle-on"></i> Product Status</h2>
                <div class="row-2">
                    <div class="form-group"><label class="checkbox-label"><input type="radio" name="status"
                                value="active" checked> <i class="fas fa-check-circle"
                                style="color: var(--success);"></i> Publish (Active)</label></div>
                    <div class="form-group"><label class="checkbox-label"><input type="radio" name="status"
                                value="draft"> <i class="fas fa-save"></i> Save as Draft</label></div>
                </div>
                <div class="action-buttons">
                    <button type="button" id="previewBtn" class="btn-secondary"><i class="fas fa-eye"></i>
                        Preview</button>
                    <button type="submit" id="saveBtn" class="btn-primary"><i class="fas fa-save"></i> Save
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
                <a href="Landing.php">Landing</a>
                <a href="CompareProducts.php">Compare Products</a>
                <a href="Blog.php">Tech Blog</a>
                <a href="Profile.php">Profile</a>
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
        // ============== GLOBAL VARIABLES (100% UNCHANGED) ==============
        let uploadedImages = [];
        let specs = [];
        let draggedIndex = null;

        // ============== HELPER FUNCTIONS (100% UNCHANGED) ==============
        function showMessage(message, isError = false) {
            const popup = document.createElement('div');
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${message}`;
            popup.style.cssText = `position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: ${isError ? '#ef4444' : '#10b981'}; color: white; padding: 12px 24px; border-radius: 60px; z-index: 10000; font-size: 14px; animation: fadeInOut 3s ease forwards; font-weight:500;`;
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 3000);
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

        // ============== LOAD CATEGORIES (100% UNCHANGED) ==============
        async function loadCategories() {
            try {
                const response = await fetch('get_product_categories.php');
                const result = await response.json();
                const categorySelect = document.getElementById('category');
                if (result.success && result.data && result.data.length > 0) {
                    categorySelect.innerHTML = '<option value="">Select Category</option>';
                    result.data.forEach(category => { categorySelect.innerHTML += `<option value="${category.category_id}">${escapeHtml(category.name)}</option>`; });
                } else { categorySelect.innerHTML = '<option value="">No categories available</option>'; }
            } catch (error) { console.error('Load categories error:', error); document.getElementById('category').innerHTML = '<option value="">Error loading categories</option>'; }
        }

        // ============== GENERATE SKU (100% UNCHANGED) ==============
        async function generateSKU() {
            try {
                const response = await fetch('generate_sku.php');
                const result = await response.json();
                if (result.success) { document.getElementById('sku').value = result.sku; showMessage('SKU generated successfully!', false); }
                else { showMessage(result.message || 'Failed to generate SKU', true); }
            } catch (error) { console.error('Generate SKU error:', error); showMessage('Failed to generate SKU', true); }
        }

        // ============== IMAGE UPLOAD & REORDERING (100% UNCHANGED) ==============
        const dropzone = document.getElementById('dropzone');
        const previewGrid = document.getElementById('imagePreviewGrid');

        async function uploadImage(file) {
            const formData = new FormData();
            formData.append('product_image', file);
            dropzone.innerHTML = '⏳ Uploading...';
            dropzone.style.opacity = '0.7';
            try {
                const response = await fetch('upload_product_image.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    uploadedImages = [result.image_url];
                    renderImagePreviews();
                    dropzone.innerHTML = '<i class="fas fa-check-circle"></i> Image uploaded! Click to change';
                    dropzone.style.opacity = '1';
                    showMessage('Image uploaded successfully!', false);
                } else {
                    dropzone.innerHTML = '<i class="fas fa-cloud-upload-alt"></i> Drag & drop images here or click to upload';
                    dropzone.style.opacity = '1';
                    showMessage(result.message || 'Upload failed', true);
                }
            } catch (error) {
                console.error('Upload error:', error);
                dropzone.innerHTML = '<i class="fas fa-cloud-upload-alt"></i> Drag & drop images here or click to upload';
                dropzone.style.opacity = '1';
                showMessage('Failed to upload image', true);
            }
        }

        function handleFiles(files) {
            Array.from(files).forEach(async (file) => {
                if (file.type.startsWith('image/')) { await uploadImage(file); }
                else { showMessage('Please upload image files only', true); }
            });
        }

        function handleDragStart(e) {
            const item = e.target.closest('.preview-item');
            if (item) { draggedIndex = parseInt(item.dataset.index); item.classList.add('dragging'); }
        }

        function handleDragOver(e) {
            e.preventDefault();
            const item = e.target.closest('.preview-item');
            if (item && draggedIndex !== null) { item.classList.add('drag-over'); }
        }

        function handleDrop(e) {
            e.preventDefault();
            const targetItem = e.target.closest('.preview-item');
            if (targetItem && draggedIndex !== null) {
                const targetIndex = parseInt(targetItem.dataset.index);
                if (draggedIndex !== targetIndex) {
                    const draggedItem = uploadedImages[draggedIndex];
                    uploadedImages.splice(draggedIndex, 1);
                    uploadedImages.splice(targetIndex, 0, draggedItem);
                    renderImagePreviews();
                }
            }
            if (targetItem) targetItem.classList.remove('drag-over');
        }

        function handleDragEnd(e) {
            const item = e.target.closest('.preview-item');
            if (item) item.classList.remove('dragging');
            document.querySelectorAll('.preview-item').forEach(i => i.classList.remove('drag-over'));
            draggedIndex = null;
        }

        function renderImagePreviews() {
            if (uploadedImages.length === 0) { previewGrid.innerHTML = ''; return; }
            previewGrid.innerHTML = uploadedImages.map((img, index) => `<div class="preview-item" data-index="${index}" draggable="true"><img src="${img}?t=${Date.now()}" alt="Product Image"><button class="remove-image" data-index="${index}" type="button"><i class="fas fa-times"></i></button></div>`).join('');
            document.querySelectorAll('.preview-item').forEach(item => {
                item.addEventListener('dragstart', handleDragStart);
                item.addEventListener('dragover', handleDragOver);
                item.addEventListener('drop', handleDrop);
                item.addEventListener('dragend', handleDragEnd);
            });
            document.querySelectorAll('.remove-image').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const index = parseInt(btn.dataset.index);
                    uploadedImages.splice(index, 1);
                    renderImagePreviews();
                    if (uploadedImages.length === 0) { dropzone.innerHTML = '<i class="fas fa-cloud-upload-alt"></i> Drag & drop images here or click to upload'; }
                    showMessage('Image removed', false);
                });
            });
        }

        dropzone.addEventListener('click', () => { let input = document.createElement('input'); input.type = 'file'; input.accept = 'image/jpeg,image/png,image/webp'; input.multiple = true; input.onchange = (e) => handleFiles(e.target.files); input.click(); });
        dropzone.addEventListener('dragover', (e) => { e.preventDefault(); dropzone.classList.add('drag-over'); });
        dropzone.addEventListener('dragleave', () => { dropzone.classList.remove('drag-over'); });
        dropzone.addEventListener('drop', (e) => { e.preventDefault(); dropzone.classList.remove('drag-over'); handleFiles(e.dataTransfer.files); });

        // ============== SPECIFICATIONS FUNCTIONS (100% UNCHANGED) ==============
        function renderSpecs() {
            const container = document.getElementById('specsContainer');
            if (!container) return;
            container.innerHTML = specs.map((s, i) => `<div class="spec-row" data-index="${i}"><input type="text" placeholder="Key (e.g., Processor)" value="${escapeHtml(s.key)}" class="spec-key"><input type="text" placeholder="Value (e.g., Intel i7)" value="${escapeHtml(s.value)}" class="spec-value"><button type="button" class="btn-secondary remove-spec" data-index="${i}"><i class="fas fa-trash-alt"></i> Remove</button></div>`).join('');
            document.querySelectorAll('.spec-row').forEach((row, idx) => {
                const keyInput = row.querySelector('.spec-key');
                const valueInput = row.querySelector('.spec-value');
                keyInput.addEventListener('input', (e) => { specs[idx].key = e.target.value; });
                valueInput.addEventListener('input', (e) => { specs[idx].value = e.target.value; });
            });
            document.querySelectorAll('.remove-spec').forEach(btn => {
                btn.addEventListener('click', () => { specs.splice(parseInt(btn.dataset.index), 1); renderSpecs(); });
            });
        }

        // ============== RICH TEXT EDITOR (100% UNCHANGED) ==============
        document.querySelectorAll('.toolbar-btn').forEach(btn => {
            btn.addEventListener('click', () => { document.execCommand(btn.dataset.command, false, null); });
        });

        // ============== PREVIEW PRODUCT (100% UNCHANGED) ==============
        async function previewProduct() {
            const productData = {
                name: document.getElementById('productName').value.trim() || 'Sample Product',
                category: document.getElementById('category').options[document.getElementById('category').selectedIndex]?.text || 'Uncategorized',
                description: document.getElementById('descriptionEditor').innerHTML || 'No description',
                regular_price: parseFloat(document.getElementById('regularPrice').value) || 0,
                sale_price: parseFloat(document.getElementById('salePrice').value) || null,
                image_url: uploadedImages[0] || '',
                status: document.querySelector('input[name="status"]:checked').value,
                specifications: specs.filter(s => s.key && s.value)
            };
            try {
                const response = await fetch('preview_vendor_product.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(productData) });
                const result = await response.json();
                if (result.success) {
                    const data = result.data;
                    const modal = document.getElementById('previewModal');
                    const previewContent = document.getElementById('previewContent');
                    let specsHtml = '';
                    if (data.specifications && data.specifications.length > 0) { specsHtml = '<h4><i class="fas fa-list"></i> Specifications:</h4><ul>' + data.specifications.map(s => `<li><strong>${escapeHtml(s.key)}:</strong> ${escapeHtml(s.value)}</li>`).join('') + '</ul>'; }
                    previewContent.innerHTML = `<h3><i class="fas fa-microchip"></i> ${escapeHtml(data.name)}</h3>${data.image_url ? `<img src="${data.image_url}" style="max-width:100%; max-height:200px; object-fit:contain; margin:10px 0; border-radius:12px;">` : ''}<p><strong><i class="fas fa-folder"></i> Category:</strong> ${escapeHtml(data.category)}</p><p><strong><i class="fas fa-dollar-sign"></i> Regular Price:</strong> $${data.regular_price.toFixed(2)}</p>${data.sale_price ? `<p><strong><i class="fas fa-percent"></i> Sale Price:</strong> $${data.sale_price.toFixed(2)}</p>` : ''}<p><strong><i class="fas fa-toggle-on"></i> Status:</strong> ${data.status}</p><div><strong><i class="fas fa-align-left"></i> Description:</strong><br>${data.description}</div>${specsHtml}<button onclick="closePreview()" class="btn-primary" style="margin-top:1rem;"><i class="fas fa-times"></i> Close</button>`;
                    modal.classList.add('show');
                } else { showMessage(result.message || 'Preview failed', true); }
            } catch (error) { console.error('Preview error:', error); showMessage('Failed to generate preview', true); }
        }
        window.closePreview = () => document.getElementById('previewModal').classList.remove('show');

        // ============== COLLECT FORM DATA (100% UNCHANGED) ==============
        function collectFormData() {
            const productName = document.getElementById('productName').value.trim();
            const categoryId = document.getElementById('category').value;
            const brand = document.getElementById('brand').value;
            const description = document.getElementById('descriptionEditor').innerHTML;
            const regularPrice = parseFloat(document.getElementById('regularPrice').value);
            const salePrice = parseFloat(document.getElementById('salePrice').value) || null;
            const saleStart = document.getElementById('saleStart').value || null;
            const saleEnd = document.getElementById('saleEnd').value || null;
            const sku = document.getElementById('sku').value.trim();
            const stock = parseInt(document.getElementById('stockQuantity').value);
            const lowStockThreshold = parseInt(document.getElementById('lowStockThreshold').value) || 5;
            const weight = parseFloat(document.getElementById('weight').value) || null;
            const length = parseFloat(document.getElementById('length').value) || null;
            const width = parseFloat(document.getElementById('width').value) || null;
            const height = parseFloat(document.getElementById('height').value) || null;
            const handlingTime = document.getElementById('handlingTime').value;
            const status = document.querySelector('input[name="status"]:checked').value;
            return {
                product_name: productName,
                category_id: parseInt(categoryId),
                brand: brand,
                description: description,
                regular_price: regularPrice,
                sale_price: salePrice,
                sale_start: saleStart,
                sale_end: saleEnd,
                sku: sku,
                stock_quantity: stock,
                low_stock_threshold: lowStockThreshold,
                weight: weight,
                length: length,
                width: width,
                height: height,
                handling_time: handlingTime,
                status: status,
                image_url: uploadedImages[0] || '',
                specifications: specs.filter(s => s.key && s.value)
            };
        }

        // ============== VALIDATE FORM (100% UNCHANGED) ==============
        function validateForm(data) {
            if (!data.product_name) { showMessage('Product Name is required', true); return false; }
            if (!data.category_id || data.category_id === '') { showMessage('Please select a category', true); return false; }
            if (!data.sku) { showMessage('SKU is required', true); return false; }
            if (data.regular_price <= 0) { showMessage('Valid Regular Price is required', true); return false; }
            if (data.sale_price && data.sale_price >= data.regular_price) { showMessage('Sale Price must be less than Regular Price', true); return false; }
            if (isNaN(data.stock_quantity) || data.stock_quantity < 0) { showMessage('Valid Stock Quantity is required', true); return false; }
            return true;
        }

        // ============== SAVE PRODUCT (100% UNCHANGED) ==============
        async function saveProduct(productData) {
            try {
                console.log('Sending data:', productData);
                const response = await fetch('add_vendor_product.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(productData) });
                const result = await response.json();
                if (result.success) {
                    showMessage(result.message);
                    document.getElementById('productForm').reset();
                    document.getElementById('descriptionEditor').innerHTML = '';
                    uploadedImages = [];
                    renderImagePreviews();
                    specs = [];
                    renderSpecs();
                    generateSKU();
                    setTimeout(() => { window.location.href = 'VendorProductsManagement.php'; }, 2000);
                } else { showMessage(result.message || 'Failed to save product', true); }
            } catch (error) { console.error('Save error:', error); showMessage('Failed to save product. Check console for details.', true); }
        }

        // ============== EVENT LISTENERS (100% UNCHANGED) ==============
        document.getElementById('generateSku').addEventListener('click', generateSKU);
        document.getElementById('previewBtn').addEventListener('click', previewProduct);
        document.getElementById('addSpecRow').addEventListener('click', () => { specs.push({ key: '', value: '' }); renderSpecs(); });
        document.getElementById('productForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = collectFormData();
            if (validateForm(formData)) { await saveProduct(formData); }
        });

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
            await loadCategories();
            await generateSKU();
            renderSpecs();
        }
        init();
    </script>
</body>

</html>