<?php
// ==============================================
// COMPLETE WORKING Logout.php
// ==============================================

session_start();
require_once 'db_connect.php';

// Handle immediate logout (if confirmed)
$immediate_logout = isset($_GET['confirm']) && $_GET['confirm'] == 'yes';

if ($immediate_logout) {
    // Clear remember me token from database
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $check_column = $conn->query("SHOW COLUMNS FROM users LIKE 'remember_token'");
        if ($check_column && $check_column->num_rows > 0) {
            $update_stmt = $conn->prepare("UPDATE users SET remember_token = NULL, token_expiry = NULL WHERE user_id = ?");
            $update_stmt->bind_param("i", $user_id);
            $update_stmt->execute();
            $update_stmt->close();
        }
    }
    
    // Clear remember me cookie
    if (isset($_COOKIE['remember_token'])) {
        setcookie('remember_token', '', time() - 3600, '/');
    }
    
    // Clear all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    
    // Destroy the session
    session_destroy();
    
    // Redirect to login page
    header("Location: Login.php?logout=success");
    exit();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['logged_in']);
$userName = $_SESSION['user_name'] ?? $_SESSION['full_name'] ?? $_SESSION['user_email'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Logout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            /* G. Page Fade-In Animation */
            animation: pageFadeIn 0.5s ease-out;
        }

        @keyframes pageFadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .logout-container {
            max-width: 500px;
            width: 100%;
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

        /* A. Logout Card Hover Animation */
        .logout-card {
            background: white;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            text-align: center;
            padding: 2.5rem;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            animation: fadeInUp 0.5s ease-out;
        }

        .logout-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
        }

        .logout-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: transform 0.3s ease;
        }

        .logout-card:hover .logout-icon {
            transform: scale(1.05);
        }

        .logout-icon i {
            font-size: 3rem;
            color: #dc2626;
        }

        .logout-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .logout-message {
            color: #64748b;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .user-name {
            font-weight: 600;
            color: #2563eb;
            background: #eff6ff;
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            margin-top: 0.5rem;
            transition: all 0.2s ease;
        }

        .user-name:hover {
            transform: scale(1.02);
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }

        /* B. Button Hover Animation */
        .btn-logout {
            background: #dc2626;
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: #b91c1c;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(220, 38, 38, 0.4);
        }

        /* B. Button Hover Animation */
        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
            transform: translateY(-2px) scale(1.02);
        }

        /* B. Button Hover Animation */
        .btn-login {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            border: none;
            padding: 0.875rem 2.5rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-login:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
        }

        .info-text {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.85rem;
            color: #94a3b8;
            transition: all 0.2s ease;
        }

        .info-text:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 600px) {
            .logout-card {
                padding: 1.5rem;
            }
            
            .logout-title {
                font-size: 1.5rem;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .btn-logout, .btn-cancel, .btn-login {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <!-- H. Scroll Reveal - Logout Card -->
        <div class="logout-card" data-aos="zoom-in" data-aos-duration="600" data-aos-offset="50">
            <?php if ($isLoggedIn): ?>
                <!-- User is logged in - Show logout confirmation -->
                <div class="logout-icon" data-aos="fade-up" data-aos-duration="400" data-aos-delay="50">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <h1 class="logout-title" data-aos="fade-up" data-aos-duration="400" data-aos-delay="100">Logout Confirmation</h1>
                <div class="logout-message" data-aos="fade-up" data-aos-duration="400" data-aos-delay="150">
                    Hello, <span class="user-name"><?php echo htmlspecialchars($userName); ?></span>
                    <br>
                    Are you sure you want to logout from your account?
                </div>
                <div class="button-group" data-aos="fade-up" data-aos-duration="400" data-aos-delay="200">
                    <a href="?confirm=yes" class="btn-logout">
                        <i class="fas fa-check-circle"></i> Yes, Logout
                    </a>
                    <a href="javascript:history.back()" class="btn-cancel">
                        <i class="fas fa-times-circle"></i> Cancel
                    </a>
                </div>
                
            <?php else: ?>
                <!-- User is not logged in -->
                <div class="logout-icon" data-aos="fade-up" data-aos-duration="400" data-aos-delay="50">
                    <i class="fas fa-lock"></i>
                </div>
                <h1 class="logout-title" data-aos="fade-up" data-aos-duration="400" data-aos-delay="100">Already Logged Out</h1>
                <div class="logout-message" data-aos="fade-up" data-aos-duration="400" data-aos-delay="150">
                    You are not currently logged in to any account.
                </div>
                <div class="button-group" data-aos="fade-up" data-aos-duration="400" data-aos-delay="200">
                    <a href="Login.php" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Go to Login
                    </a>
                    <a href="FYPHome.php" class="btn-cancel">
                        <i class="fas fa-home"></i> Home Page
                    </a>
                </div>
            <?php endif; ?>
            
            <div class="info-text" data-aos="fade-up" data-aos-duration="300" data-aos-delay="250">
                <i class="fas fa-shield-alt"></i> Secure logout ensures your account stays protected
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

        // Also clear localStorage items for consistency
        if (<?php echo $isLoggedIn ? 'true' : 'false'; ?>) {
            // Clear localStorage items that might be used by frontend
            const itemsToRemove = [
                'loggedIn', 'user', 'userEmail', 'userName', 'userFullName', 
                'accountType', 'userRole', 'isLoggedIn', 'userPhone', 
                'newsletterSubscribed', 'rememberUser', 'rememberedEmail', 'cart'
            ];
            itemsToRemove.forEach(item => {
                localStorage.removeItem(item);
            });
            sessionStorage.clear();
        }
    </script>
</body>
</html>