<?php
// ==============================================
// NO OUTPUT BEFORE session_start()
// ==============================================
session_start();
require_once 'db_connect.php';

$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    header('Content-Type: application/json');

    if (!$isLoggedIn) {
        echo json_encode(['success' => false, 'message' => 'Please login first']);
        exit;
    }

    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add_address':
            $label = trim($_POST['label'] ?? 'Home');
            $addressLine1 = trim($_POST['address_line1'] ?? '');
            $addressLine2 = trim($_POST['address_line2'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $state = trim($_POST['state'] ?? '');
            $postalCode = trim($_POST['postal_code'] ?? '');
            $country = trim($_POST['country'] ?? '');
            $isDefault = isset($_POST['is_default']) ? (int) $_POST['is_default'] : 0;

            if (empty($addressLine1) || empty($city) || empty($state) || empty($postalCode)) {
                echo json_encode(['success' => false, 'message' => 'Please fill all required fields']);
                exit;
            }

            if ($isDefault == 1) {
                $updateStmt = $conn->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?");
                $updateStmt->bind_param("i", $userId);
                $updateStmt->execute();
                $updateStmt->close();
            }

            $stmt = $conn->prepare("INSERT INTO user_addresses (user_id, label, address_line1, address_line2, city, state, postal_code, country, is_default) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssssi", $userId, $label, $addressLine1, $addressLine2, $city, $state, $postalCode, $country, $isDefault);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Address added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add address']);
            }
            $stmt->close();
            break;

        case 'update_address':
            $addressId = (int) $_POST['address_id'];
            $label = trim($_POST['label'] ?? 'Home');
            $addressLine1 = trim($_POST['address_line1'] ?? '');
            $addressLine2 = trim($_POST['address_line2'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $state = trim($_POST['state'] ?? '');
            $postalCode = trim($_POST['postal_code'] ?? '');
            $country = trim($_POST['country'] ?? '');
            $isDefault = isset($_POST['is_default']) ? (int) $_POST['is_default'] : 0;

            $checkStmt = $conn->prepare("SELECT address_id FROM user_addresses WHERE address_id = ? AND user_id = ?");
            $checkStmt->bind_param("ii", $addressId, $userId);
            $checkStmt->execute();
            if ($checkStmt->get_result()->num_rows === 0) {
                echo json_encode(['success' => false, 'message' => 'Address not found']);
                $checkStmt->close();
                exit;
            }
            $checkStmt->close();

            if ($isDefault == 1) {
                $updateStmt = $conn->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ? AND address_id != ?");
                $updateStmt->bind_param("ii", $userId, $addressId);
                $updateStmt->execute();
                $updateStmt->close();
            }

            $stmt = $conn->prepare("UPDATE user_addresses SET label = ?, address_line1 = ?, address_line2 = ?, city = ?, state = ?, postal_code = ?, country = ?, is_default = ? WHERE address_id = ? AND user_id = ?");
            $stmt->bind_param("sssssssiii", $label, $addressLine1, $addressLine2, $city, $state, $postalCode, $country, $isDefault, $addressId, $userId);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Address updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update address']);
            }
            $stmt->close();
            break;

        case 'delete_address':
            $addressId = (int) $_POST['address_id'];

            $checkStmt = $conn->prepare("SELECT is_default FROM user_addresses WHERE address_id = ? AND user_id = ?");
            $checkStmt->bind_param("ii", $addressId, $userId);
            $checkStmt->execute();
            $address = $checkStmt->get_result()->fetch_assoc();

            if (!$address) {
                echo json_encode(['success' => false, 'message' => 'Address not found']);
                $checkStmt->close();
                exit;
            }
            $checkStmt->close();

            $stmt = $conn->prepare("DELETE FROM user_addresses WHERE address_id = ? AND user_id = ?");
            $stmt->bind_param("ii", $addressId, $userId);

            if ($stmt->execute()) {
                if ($address['is_default'] == 1) {
                    $newDefaultStmt = $conn->prepare("UPDATE user_addresses SET is_default = 1 WHERE user_id = ? LIMIT 1");
                    $newDefaultStmt->bind_param("i", $userId);
                    $newDefaultStmt->execute();
                    $newDefaultStmt->close();
                }
                echo json_encode(['success' => true, 'message' => 'Address deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete address']);
            }
            $stmt->close();
            break;

        case 'set_default':
            $addressId = (int) $_POST['address_id'];

            $checkStmt = $conn->prepare("SELECT address_id FROM user_addresses WHERE address_id = ? AND user_id = ?");
            $checkStmt->bind_param("ii", $addressId, $userId);
            $checkStmt->execute();
            if ($checkStmt->get_result()->num_rows === 0) {
                echo json_encode(['success' => false, 'message' => 'Address not found']);
                $checkStmt->close();
                exit;
            }
            $checkStmt->close();

            $updateStmt = $conn->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?");
            $updateStmt->bind_param("i", $userId);
            $updateStmt->execute();
            $updateStmt->close();

            $stmt = $conn->prepare("UPDATE user_addresses SET is_default = 1 WHERE address_id = ? AND user_id = ?");
            $stmt->bind_param("ii", $addressId, $userId);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Default address updated']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update default address']);
            }
            $stmt->close();
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    exit;
}

// Fetch addresses directly from database (NO external API call needed)
$addresses = [];
if ($isLoggedIn) {
    $sql = "SELECT address_id, label, address_line1, address_line2, city, state, postal_code, country, is_default 
            FROM user_addresses 
            WHERE user_id = ? 
            ORDER BY is_default DESC, address_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $addresses[] = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Address Book</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
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
            /* THEME CHANGE: Logout.php gradient background */
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            scroll-behavior: smooth;
            animation: pageFadeIn 0.5s ease-out;
        }

        @keyframes pageFadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* ========== THEME: Logout.php Color Scheme ========== */
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            --secondary: #667eea;
            --success: #10b981;
            --danger: #dc2626;
            --warning: #f59e0b;
            --card-bg: #ffffff;
            --card-bg-light: #f8fafc;
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Header - White Theme */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-lg);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
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
            height: 52px;
            transition: transform 0.2s;
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

        .nav-links a {
            text-decoration: none;
        }

        .nav-link {
            text-decoration: none;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.2s ease;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 1rem;
            border-radius: 40px;
            position: relative;
        }

        .nav-link i {
            font-size: 1rem;
            color: var(--text-muted);
        }

        .nav-link:hover {
            background: #eff6ff;
            color: var(--primary);
        }

        .nav-link:hover i {
            color: var(--primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
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
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            min-width: 220px;
            padding: 0.6rem 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-12px);
            transition: all 0.25s;
            z-index: 1050;
            border: 1px solid var(--border-color);
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
            color: var(--text-muted);
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .dropdown-menu a:hover {
            background: #f1f5f9;
            color: var(--primary);
            padding-left: 1.6rem;
        }

        .auth-btn {
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            padding: 0.45rem 1.2rem;
            border-radius: 60px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            color: var(--text-dark);
        }

        .auth-btn:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
            border-color: transparent;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 0.95rem;
            transition: all 0.2s;
            color: var(--text-dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f1f5f9;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            font-weight: 600;
            border: 1px solid var(--border-color);
        }

        .cart-icon i {
            font-size: 1.1rem;
        }

        .cart-icon:hover {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
        }

        .cart-icon:hover i {
            color: white;
        }

        .cart-count {
            background: var(--danger);
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
            color: var(--text-dark);
            transition: transform 0.2s ease;
        }

        .hamburger:hover {
            color: var(--primary);
            transform: scale(1.05);
        }

        .mobile-menu-panel {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 340px;
            height: 100%;
            background: var(--card-bg);
            z-index: 2000;
            box-shadow: 2px 0 30px rgba(0, 0, 0, 0.2);
            transition: left 0.3s;
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
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
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
            color: var(--text-dark);
            transition: transform 0.2s ease;
        }

        .close-mobile:hover {
            transform: scale(1.1);
        }

        /* Footer - White Theme */
        .footer {
            background: var(--card-bg);
            color: var(--text-muted);
            padding: 3rem 2rem 1.5rem;
            margin-top: 4rem;
            border-top: 1px solid var(--border-color);
            border-radius: 32px 32px 0 0;
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
            color: var(--text-dark);
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
            color: var(--text-muted);
            text-decoration: none;
            margin-bottom: 0.6rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .footer-col a:hover {
            color: var(--primary);
            transform: translateX(4px);
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icons i {
            font-size: 1.4rem;
            color: var(--text-muted);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .social-icons i:hover {
            color: var(--primary);
            transform: translateY(-3px) scale(1.05);
        }

        .copyright {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .address-container {
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
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb span {
            color: rgba(255, 255, 255, 0.9);
        }

        .page-title {
            font-size: 2.4rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: white;
            margin-bottom: 2rem;
        }

        .page-title i {
            margin-right: 10px;
        }

        .address-layout {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .addresses-section {
            flex: 2;
            min-width: 280px;
        }

        .form-section {
            flex: 1.2;
            min-width: 320px;
        }

        .addresses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.2rem;
        }

        /* Address Cards - White Theme */
        .address-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 1.4rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: var(--shadow-md);
        }

        .address-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .address-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.8rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .address-label {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .badge-group {
            display: flex;
            gap: 0.5rem;
        }

        .type-badge {
            background: #f1f5f9;
            color: var(--text-muted);
            font-size: 0.7rem;
            padding: 0.2rem 0.7rem;
            border-radius: 40px;
        }

        .default-badge {
            background: var(--success);
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.7rem;
            border-radius: 40px;
        }

        .address-details {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .address-actions {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .btn-icon {
            background: #f1f5f9;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.25s ease;
            color: var(--text-muted);
        }

        .btn-icon:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Form Card - White Theme */
        .form-card {
            background: var(--card-bg);
            border-radius: 32px;
            padding: 1.8rem;
            border: 1px solid var(--border-color);
            position: sticky;
            top: 100px;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .form-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .form-card h2 {
            font-size: 1.3rem;
            color: var(--text-dark);
            margin-bottom: 1.2rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 0.8rem;
            margin-bottom: 0.3rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s ease;
            font-family: inherit;
            background: var(--card-bg-light);
            color: var(--text-dark);
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-group input::placeholder {
            color: var(--text-light);
        }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .address-type-group {
            display: flex;
            gap: 1.2rem;
            margin-top: 0.3rem;
        }

        .address-type-group label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: normal;
            cursor: pointer;
            color: var(--text-dark);
        }

        .address-type-group input[type="radio"] {
            width: auto;
            accent-color: var(--primary);
        }

        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
            accent-color: var(--primary);
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.85rem;
            border-radius: 60px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.25s ease;
            width: 100%;
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
            filter: brightness(1.05);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: var(--text-muted);
            border: none;
            padding: 0.6rem;
            border-radius: 60px;
            cursor: pointer;
            font-size: 0.85rem;
            width: 100%;
            margin-top: 0.5rem;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 2.5rem;
            color: var(--text-muted);
            background: var(--card-bg);
            border-radius: 28px;
            border: 1px solid var(--border-color);
        }

        .empty-state a {
            color: var(--primary);
            text-decoration: none;
        }

        .empty-state a:hover {
            text-decoration: underline;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.2);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.6);
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
            transition: all 0.25s ease;
            z-index: 99;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: var(--shadow-md);
            font-weight: 600;
        }

        .back-to-top.show {
            opacity: 1;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            filter: brightness(1.05);
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
        }

        @media (max-width: 768px) {
            .address-layout {
                flex-direction: column;
            }
            .form-card {
                position: relative;
                top: 0;
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
            <div class="logo"><img src="Logo.jpg" alt="Global Hardware Hub"></div>
            <ul class="nav-links">
                <li class="nav-item"><a href="FYPHome.php" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
                <li class="nav-item"><a href="AboutUs.php" class="nav-link"><i class="fas fa-info-circle"></i> About Us</a>
                </li>
                <li class="nav-item"><a href="ContactUs.php" class="nav-link"><i class="fas fa-envelope"></i> Contact Us</a>
                </li>
                <li class="nav-item"><a href="FAQ.php" class="nav-link"><i class="fas fa-question-circle"></i> FAQ</a></li>
                <li class="cart-icon" id="cartIcon"><i class="fas fa-shopping-cart"></i> Cart <span
                        id="cartCountDisplay" class="cart-count">0</span></li>
                <li class="nav-item"><button id="authButton" class="auth-btn"><i class="fas fa-key"></i>
                        <?php echo $isLoggedIn ? 'Logout' : 'Login'; ?></button></li>
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

    <div class="address-container">
        <div class="breadcrumb"><a href="FYPHome.php"><i class="fas fa-home"></i> Home</a> / <a href="MyAccount.php">My
                Account</a> / <span>Address Book</span></div>
        <h1 class="page-title" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50"><i class="fas fa-address-book"></i> Address Book</h1>
        <div class="address-layout">
            <div class="addresses-section">
                <div id="addressesContainer" class="addresses-grid" data-aos="fade-up" data-aos-duration="600" data-aos-offset="50" data-aos-delay="50">
                    <?php if (!$isLoggedIn): ?>
                        <div class="empty-state"><i class="fas fa-lock"></i> Please <a href="LogIn.php">login</a> to view your addresses.</div>
                    <?php elseif (empty($addresses)): ?>
                        <div class="empty-state"><i class="fas fa-inbox"></i> No saved addresses. Add your first address
                            using the form.</div>
                    <?php else: ?>
                        <?php foreach ($addresses as $index => $addr): ?>
                            <div class="address-card" data-id="<?php echo $addr['address_id']; ?>" data-aos="fade-up" data-aos-duration="400" data-aos-delay="<?php echo 50 + ($index * 30); ?>">
                                <div class="address-header">
                                    <span class="address-label"><i class="fas fa-map-pin"></i>
                                        <?php echo htmlspecialchars($addr['label']); ?></span>
                                    <div class="badge-group">
                                        <span
                                            class="type-badge"><?php echo $addr['label'] === 'Home' ? '🏠 Home' : ($addr['label'] === 'Work' ? '💼 Work' : '📍 ' . htmlspecialchars($addr['label'])); ?></span>
                                        <?php if ($addr['is_default'] == 1): ?><span class="default-badge"><i
                                                    class="fas fa-star"></i> Default</span><?php endif; ?>
                                    </div>
                                </div>
                                <div class="address-details">
                                    <?php echo htmlspecialchars($addr['address_line1']); ?>
                                    <?php echo $addr['address_line2'] ? ', ' . htmlspecialchars($addr['address_line2']) : ''; ?><br>
                                    <?php echo htmlspecialchars($addr['city']); ?>,
                                    <?php echo htmlspecialchars($addr['state']); ?>
                                    <?php echo htmlspecialchars($addr['postal_code']); ?><br>
                                    <?php echo htmlspecialchars($addr['country']); ?>
                                </div>
                                <div class="address-actions">
                                    <button class="btn-icon" onclick="editAddress(<?php echo $addr['address_id']; ?>)"><i
                                            class="fas fa-edit"></i> Edit</button>
                                    <button class="btn-icon" onclick="deleteAddress(<?php echo $addr['address_id']; ?>)"><i
                                            class="fas fa-trash-alt"></i> Delete</button>
                                    <?php if ($addr['is_default'] != 1): ?>
                                        <button class="btn-icon" onclick="setDefaultAddress(<?php echo $addr['address_id']; ?>)"><i
                                                class="fas fa-star"></i> Set Default</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-section" data-aos="fade-left" data-aos-duration="600" data-aos-offset="50" data-aos-delay="100">
                <div class="form-card">
                    <h2 id="formTitle"><i class="fas fa-plus-circle"></i> Add New Address</h2>
                    <form id="addressForm">
                        <div class="form-group"><label>Address Line 1 *</label><input type="text" id="addressLine1"
                                placeholder="Street address"></div>
                        <div class="form-group"><label>Address Line 2</label><input type="text" id="addressLine2"
                                placeholder="Apartment, suite, etc."></div>
                        <div class="row-2">
                            <div class="form-group"><label>City *</label><input type="text" id="city"
                                    placeholder="City"></div>
                            <div class="form-group"><label>State *</label><input type="text" id="state"
                                    placeholder="State"></div>
                        </div>
                        <div class="row-2">
                            <div class="form-group"><label>Postal Code *</label><input type="text" id="postalCode"
                                    placeholder="Postal code"></div>
                            <div class="form-group"><label>Country *</label><select id="country">
                                    <option value="United States">United States</option>
                                    <option value="Canada">Canada</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Pakistan" selected>Pakistan</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="India">India</option>
                                </select></div>
                        </div>
                        <div class="form-group"><label>Address Type</label>
                            <div class="address-type-group"><label><input type="radio" name="addressType" value="Home"
                                        checked> 🏠 Home</label><label><input type="radio" name="addressType"
                                        value="Work"> 💼 Work</label><label><input type="radio" name="addressType"
                                        value="Other"> 📍 Other</label></div>
                        </div>
                        <div class="form-group"><label><input type="checkbox" id="setDefault"> Set as default
                                address</label></div>
                        <input type="hidden" id="editingId" value="">
                        <button type="submit" class="btn-primary" id="submitBtn"><i class="fas fa-save"></i> Save
                            Address</button>
                        <button type="button" id="cancelEditBtn" class="btn-secondary" style="display: none;"><i
                                class="fas fa-times"></i> Cancel Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer" data-aos="fade-up" data-aos-duration="500" data-aos-offset="50">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Quick Links</h4>
                <a href="AboutUs.php">About Us</a>
                <a href="ContactUs.php">Contact</a>
                <a href="FAQ.php">FAQs</a>
                <a href="ReturnPolicy.php">Return Policy</a>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <a href="PrivacyPolicy.php">Privacy Policy</a>
                <a href="TermsofService.php">Terms of Service</a>
                <a href="Landing.php">Landing</a>
                <a href="PrivacyPolicy.php">Privacy Policy</a>
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
                </div>
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

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 600,
            once: true,
            offset: 80,
            disable: 'mobile'
        });

        // ========== CART COUNT FROM API ==========

        // Global session variables
        let isUserLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
        let isCustomerRole = false;
        let currentUserId = <?php echo json_encode($userId); ?>;

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

        function setAuthUI() {
            const authBtn = document.getElementById("authButton");
            if (authBtn) {
                if (isUserLoggedIn) {
                    authBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i> Logout';
                } else {
                    authBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login';
                }
            }
        }

        function handleAuthClick() {
            if (isUserLoggedIn) {
                window.location.href = "Logout.php";
            } else {
                window.location.href = "LogIn.php";
            }
        }

        document.getElementById("authButton")?.addEventListener("click", handleAuthClick);

        document.querySelector('.cart-icon')?.addEventListener('click', async () => {
            await checkUserSession();
            if (!isUserLoggedIn) {
                alert('Please login to manage your cart');
                window.location.href = "LogIn.php";
            } else {
                window.location.href = "Cart.php";
            }
        });

        function renderMobileMenu() {
            const container = document.getElementById("mobileMenuContent");
            if (!container) return;
            const logged = isUserLoggedIn;
            container.innerHTML = `<div style="margin-top:1rem;"><button id="mobileAuthBtn" class="auth-btn" style="width:100%; background:linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color:white; border:none;">${logged ? "<i class='fas fa-sign-out-alt'></i> Logout" : "<i class='fas fa-sign-in-alt'></i> Login"}</button></div><hr style="margin:1rem 0; border-color:#e2e8f0;"><a href="FYPHome.php" style="display:block;padding:0.8rem 0; text-decoration:none; color:var(--text-dark);">Home</a><a href="Products1.php" style="display:block;padding:0.8rem 0; text-decoration:none; color:var(--text-dark);">Products</a><a href="MyAccount.php" style="display:block;padding:0.8rem 0; text-decoration:none; color:var(--text-dark);">Account</a><a href="ContactUs.php" style="display:block;padding:0.8rem 0; text-decoration:none; color:var(--text-dark);">Support</a>`;
            document.getElementById("mobileAuthBtn")?.addEventListener("click", () => { handleAuthClick(); renderMobileMenu(); });
        }

        const hamburger = document.getElementById("hamburgerBtn"), mobilePanel = document.getElementById("mobileMenuPanel"), overlay = document.getElementById("mobileOverlay");
        if (hamburger) hamburger.onclick = () => { mobilePanel.classList.add("open"); overlay.classList.add("show"); };
        document.getElementById("closeMobileBtn")?.addEventListener("click", () => { mobilePanel.classList.remove("open"); overlay.classList.remove("show"); });
        if (overlay) overlay.onclick = () => { mobilePanel.classList.remove("open"); overlay.classList.remove("show"); };

        function showPopup(msg, isError = false) {
            const popup = document.createElement('div');
            popup.innerHTML = `<i class="fas ${isError ? 'fa-exclamation-circle' : 'fa-check-circle'}"></i> ${msg}`;
            popup.style.cssText = `position:fixed; bottom:80px; left:50%; transform:translateX(-50%); background:${isError ? '#dc2626' : '#10b981'}; color:white; padding:12px 24px; border-radius:60px; z-index:10001; font-size:14px; animation:fadeInOut 3s ease; font-weight:500; box-shadow:0 4px 12px rgba(0,0,0,0.2);`;
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 3000);
        }

        async function saveAddress(e) {
            e.preventDefault();
            if (!isUserLoggedIn) { showPopup('Please login first', true); window.location.href = "LogIn.php"; return; }

            const addressLine1 = document.getElementById("addressLine1").value.trim();
            const city = document.getElementById("city").value.trim();
            const state = document.getElementById("state").value.trim();
            const postalCode = document.getElementById("postalCode").value.trim();

            if (!addressLine1 || !city || !state || !postalCode) {
                showPopup("Please fill all required fields", true);
                return;
            }

            const formData = new FormData();
            formData.append('action', editingId ? 'update_address' : 'add_address');
            formData.append('label', document.querySelector('input[name="addressType"]:checked').value);
            formData.append('address_line1', addressLine1);
            formData.append('address_line2', document.getElementById("addressLine2").value.trim());
            formData.append('city', city);
            formData.append('state', state);
            formData.append('postal_code', postalCode);
            formData.append('country', document.getElementById("country").value);
            formData.append('is_default', document.getElementById("setDefault").checked ? 1 : 0);
            if (editingId) formData.append('address_id', editingId);

            try {
                const response = await fetch(window.location.href, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const result = await response.json();
                if (result.success) { showPopup(result.message); window.location.reload(); }
                else showPopup(result.message, true);
            } catch (e) { showPopup('Connection error', true); }
        }

        let editingId = null;

        window.editAddress = function (id) {
            const card = document.querySelector(`.address-card[data-id="${id}"]`);
            if (!card) return;
            const details = card.querySelector('.address-details').innerHTML.split('<br>');
            editingId = id;
            document.getElementById("addressLine1").value = details[0].split(',')[0];
            document.getElementById("addressLine2").value = '';
            const cityState = details[1].trim().split(',');
            document.getElementById("city").value = cityState[0] || '';
            document.getElementById("state").value = (cityState[1] || '').split(' ')[1] || '';
            document.getElementById("postalCode").value = (cityState[1] || '').split(' ')[2] || '';
            document.getElementById("formTitle").innerHTML = '<i class="fas fa-edit"></i> Edit Address';
            document.getElementById("submitBtn").innerHTML = '<i class="fas fa-save"></i> Update Address';
            document.getElementById("cancelEditBtn").style.display = "inline-block";
            window.scrollTo({ top: document.querySelector('.form-card').offsetTop - 100, behavior: 'smooth' });
        };

        window.deleteAddress = async function (id) {
            if (!confirm("Delete this address?")) return;
            const formData = new FormData();
            formData.append('action', 'delete_address');
            formData.append('address_id', id);
            try {
                const response = await fetch(window.location.href, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const result = await response.json();
                if (result.success) { showPopup(result.message); window.location.reload(); }
                else showPopup(result.message, true);
            } catch (e) { showPopup('Error', true); }
        };

        window.setDefaultAddress = async function (id) {
            const formData = new FormData();
            formData.append('action', 'set_default');
            formData.append('address_id', id);
            try {
                const response = await fetch(window.location.href, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: formData });
                const result = await response.json();
                if (result.success) { showPopup(result.message); window.location.reload(); }
                else showPopup(result.message, true);
            } catch (e) { showPopup('Error', true); }
        };

        function cancelEdit() {
            editingId = null;
            document.getElementById("addressForm").reset();
            document.querySelector('input[name="addressType"][value="Home"]').checked = true;
            document.getElementById("formTitle").innerHTML = '<i class="fas fa-plus-circle"></i> Add New Address';
            document.getElementById("submitBtn").innerHTML = '<i class="fas fa-save"></i> Save Address';
            document.getElementById("cancelEditBtn").style.display = "none";
        }

        document.getElementById("addressForm").addEventListener("submit", saveAddress);
        document.getElementById("cancelEditBtn").addEventListener("click", cancelEdit);

        const backBtn = document.getElementById("backToTop");
        window.addEventListener("scroll", () => backBtn.classList.toggle("show", window.scrollY > 300));
        backBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

        async function init() {
            await checkUserSession();
            setAuthUI();
            renderMobileMenu();
            await updateCartCount();
            AOS.refresh();
        }

        init();
    </script>
</body>

</html>