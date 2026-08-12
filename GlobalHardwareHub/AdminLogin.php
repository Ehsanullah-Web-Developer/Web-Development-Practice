<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Global Hardware Hub | Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0a0f1e 0%, #0f1a2f 50%, #1a2a4a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            z-index: 0;
            animation: float 20s infinite ease-in-out;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #667eea, #764ba2);
            top: -150px;
            right: -100px;
        }

        .shape-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #f093fb, #f5576c);
            bottom: -200px;
            left: -150px;
            animation-delay: -5s;
        }

        .shape-3 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #4facfe, #00f2fe);
            top: 40%;
            right: 20%;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.98); }
        }

        /* Main Container */
        .login-container {
            width: 100%;
            max-width: 1300px;
            margin: 2rem;
            z-index: 10;
            position: relative;
        }

        /* Split Layout */
        .split-wrapper {
            display: flex;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border-radius: 48px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
        }

        /* LEFT SIDE - Login Form */
        .login-form-side {
            flex: 1;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(0px);
        }

        /* RIGHT SIDE - Dashboard Preview */
        .dashboard-preview {
            flex: 1;
            background: linear-gradient(135deg, #0a2b5e 0%, #0f3f7a 100%);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .dashboard-preview::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.05"><path fill="white" d="M20,20 L80,20 L80,80 L20,80 Z M25,25 L75,25 L75,35 L25,35 Z M25,40 L50,40 L50,50 L25,50 Z M55,40 L75,40 L75,50 L55,50 Z M25,55 L35,55 L35,75 L25,75 Z M40,55 L75,55 L75,75 L40,75 Z"/></svg>') repeat;
            opacity: 0.05;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #0a2b5e, #1e4a8a);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 8px 20px rgba(10, 43, 94, 0.3);
        }

        .logo-text {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0a2b5e;
        }

        .logo-text span {
            color: #0066ff;
        }

        /* Heading */
        .form-heading {
            margin-bottom: 2rem;
        }

        .form-heading h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a2634;
            margin-bottom: 0.5rem;
        }

        .form-heading p {
            color: #7c8ea0;
            font-size: 0.9rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            color: #a0aec0;
            font-size: 1rem;
            transition: all 0.3s;
            z-index: 1;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 50px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s;
            background: white;
        }

        .input-wrapper input:focus {
            border-color: #0a2b5e;
            box-shadow: 0 0 0 4px rgba(10, 43, 94, 0.1);
        }

        .input-wrapper input:focus + i {
            color: #0a2b5e;
        }

        /* Password Toggle Button */
        .password-toggle {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            cursor: pointer;
            color: #a0aec0;
            font-size: 1.1rem;
            transition: color 0.3s;
            z-index: 1;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #0a2b5e;
        }

        /* Remember & Forgot Row */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            color: #4a5b7a;
        }

        .checkbox-wrapper input {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #0a2b5e;
        }

        .forgot-link {
            color: #0066ff;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: #0a2b5e;
            text-decoration: underline;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0a2b5e 0%, #1e4a8a 100%);
            border: none;
            border-radius: 40px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(10, 43, 94, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(10, 43, 94, 0.4);
            background: linear-gradient(135deg, #0f3f7a 0%, #2a5aaa 100%);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Back to Website Link */
        .back-link {
            text-align: center;
            margin-top: 1rem;
        }

        .back-link a {
            color: #7c8ea0;
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: #0a2b5e;
        }

        /* RIGHT SIDE - Dashboard Preview Content */
        .preview-header {
            margin-bottom: 2rem;
        }

        .preview-header h2 {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .preview-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* Stats Cards Preview */
        .stats-preview {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-preview-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-preview-card .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }

        .stat-preview-card .stat-label {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 0.3rem;
        }

        /* Mini Chart Preview */
        .chart-preview {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .chart-bars {
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            height: 100px;
            margin-top: 0.8rem;
        }

        .bar {
            width: 40px;
            background: linear-gradient(180deg, #667eea, #764ba2);
            border-radius: 8px 8px 4px 4px;
            transition: height 0.3s;
            animation: barRise 1s ease-out;
        }

        @keyframes barRise {
            from { height: 0; }
            to { height: var(--h); }
        }

        /* Recent Orders Preview */
        .orders-preview {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .orders-preview h4 {
            color: white;
            font-size: 0.8rem;
            margin-bottom: 0.8rem;
        }

        .order-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .order-row:last-child {
            border-bottom: none;
        }

        /* Toast Message */
        .toast-message {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #10b981;
            color: white;
            padding: 12px 20px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 500;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .toast-message.show {
            opacity: 1;
            transform: translateY(0);
        }

        .toast-message.error {
            background: #ef4444;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .split-wrapper {
                flex-direction: column;
            }
            
            .dashboard-preview {
                display: none;
            }
            
            .login-form-side {
                padding: 2rem;
            }
            
            .login-container {
                margin: 1rem;
            }
        }

        @media (max-width: 480px) {
            .login-form-side {
                padding: 1.5rem;
            }
            
            .form-heading h1 {
                font-size: 1.5rem;
            }
            
            .stats-preview {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Animated Background Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="login-container">
        <div class="split-wrapper">
            <!-- LEFT SIDE - Login Form -->
            <div class="login-form-side">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <div class="logo-text">Global<span>Hardware</span> Hub</div>
                </div>

                <div class="form-heading">
                    <h1>Admin Dashboard Login</h1>
                    <p>Login to manage your eCommerce platform</p>
                </div>

                <form id="loginForm">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="emailInput" placeholder="Email Address" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="passwordInput" placeholder="Password">
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-wrapper">
                            <input type="checkbox" id="rememberCheckbox">
                            <span>Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="login-btn" id="loginBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span id="btnText">Login to Dashboard</span>
                    </button>

                    <div class="back-link">
                        <a href="FYPHome.php">
                            <i class="fas fa-arrow-left"></i>
                            Back to Website
                        </a>
                    </div>
                </form>
            </div>

            <!-- RIGHT SIDE - Dashboard Preview Panel -->
            <div class="dashboard-preview">
                <div class="preview-header">
                    <h2>Dashboard Preview</h2>
                    <p>Manage your marketplace at a glance</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-preview">
                    <div class="stat-preview-card">
                        <div class="stat-value">$48.2K</div>
                        <div class="stat-label">Total Revenue</div>
                    </div>
                    <div class="stat-preview-card">
                        <div class="stat-value">1,284</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                    <div class="stat-preview-card">
                        <div class="stat-value">542</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-preview-card">
                        <div class="stat-value">23</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>

                <!-- Mini Chart -->
                <div class="chart-preview">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: rgba(255,255,255,0.7); font-size: 0.75rem;">Weekly Orders</span>
                        <i class="fas fa-chart-line" style="color: rgba(255,255,255,0.5);"></i>
                    </div>
                    <div class="chart-bars">
                        <div class="bar" style="height: 40px; --h: 40px;"></div>
                        <div class="bar" style="height: 65px; --h: 65px;"></div>
                        <div class="bar" style="height: 55px; --h: 55px;"></div>
                        <div class="bar" style="height: 80px; --h: 80px;"></div>
                        <div class="bar" style="height: 70px; --h: 70px;"></div>
                        <div class="bar" style="height: 95px; --h: 95px;"></div>
                        <div class="bar" style="height: 60px; --h: 60px;"></div>
                    </div>
                </div>

                <!-- Recent Orders Preview -->
                <div class="orders-preview">
                    <h4><i class="fas fa-clock"></i> Recent Orders</h4>
                    <div class="order-row">
                        <span>#ORD-1001</span>
                        <span>$349.00</span>
                        <span style="color: #10b981;">Delivered</span>
                    </div>
                    <div class="order-row">
                        <span>#ORD-1002</span>
                        <span>$129.99</span>
                        <span style="color: #3b82f6;">Shipped</span>
                    </div>
                    <div class="order-row">
                        <span>#ORD-1003</span>
                        <span>$789.50</span>
                        <span style="color: #f59e0b;">Pending</span>
                    </div>
                    <div class="order-row">
                        <span>#ORD-1004</span>
                        <span>$245.00</span>
                        <span style="color: #3b82f6;">Shipped</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Message -->
    <div id="toastMsg" class="toast-message"></div>

    <script>
        // DOM Elements
        const emailInput = document.getElementById('emailInput');
        const passwordInput = document.getElementById('passwordInput');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const loginForm = document.getElementById('loginForm');
        const forgotLink = document.getElementById('forgotLink');
        const rememberCheckbox = document.getElementById('rememberCheckbox');
        const loginBtn = document.getElementById('loginBtn');
        const btnText = document.getElementById('btnText');
        const btnIcon = loginBtn.querySelector('i');
        
        // Toast Message Function
        function showToast(message, isError = false) {
            const toastMsg = document.getElementById('toastMsg');
            toastMsg.textContent = message;
            toastMsg.classList.remove('show', 'error');
            if (isError) {
                toastMsg.classList.add('error');
            }
            toastMsg.classList.add('show');
            
            setTimeout(() => {
                toastMsg.classList.remove('show');
            }, 4000);
        }
        
        // Password Show/Hide Toggle (FIXED - working properly)
        togglePasswordBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            if (type === 'text') {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Load saved email from localStorage (remember me)
        if (localStorage.getItem('adminEmail')) {
            emailInput.value = localStorage.getItem('adminEmail');
            rememberCheckbox.checked = true;
        }
        
        // ========== VALIDATION FUNCTION ==========
        function validateInputs(email, password) {
            if (email === '') {
                showToast('Please enter your email address', true);
                emailInput.style.borderColor = '#ef4444';
                emailInput.focus();
                setTimeout(() => {
                    emailInput.style.borderColor = '#e2e8f0';
                }, 2000);
                return false;
            }
            
            if (!email.includes('@') || !email.includes('.')) {
                showToast('Please enter a valid email address', true);
                emailInput.style.borderColor = '#ef4444';
                setTimeout(() => {
                    emailInput.style.borderColor = '#e2e8f0';
                }, 2000);
                return false;
            }
            
            if (password === '') {
                showToast('Please enter your password', true);
                passwordInput.style.borderColor = '#ef4444';
                passwordInput.focus();
                setTimeout(() => {
                    passwordInput.style.borderColor = '#e2e8f0';
                }, 2000);
                return false;
            }
            
            return true;
        }
        
        // ========== SET LOADING STATE ==========
        function setLoading(isLoading) {
            if (isLoading) {
                loginBtn.disabled = true;
                btnText.textContent = 'Logging in...';
                btnIcon.className = 'fas fa-spinner fa-spin';
            } else {
                loginBtn.disabled = false;
                btnText.textContent = 'Login to Dashboard';
                btnIcon.className = 'fas fa-sign-in-alt';
            }
        }
        
        // ========== CALL LOGIN API ==========
        async function callLoginAPI(email, password) {
            const formData = new URLSearchParams();
            formData.append('email', email);
            formData.append('password', password);
            
            try {
                const response = await fetch('admin_login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: formData
                });
                
                const data = await response.json();
                return data;
                
            } catch (error) {
                console.error('API Error:', error);
                return { success: false, message: 'Connection error. Please try again.' };
            }
        }
        
        // ========== MAIN HANDLE LOGIN FUNCTION ==========
        async function handleLogin(event) {
            event.preventDefault();
            
            const email = emailInput.value.trim();
            const password = passwordInput.value;
            
            // Step 1: Validate inputs
            if (!validateInputs(email, password)) {
                return;
            }
            
            // Step 2: Set loading state
            setLoading(true);
            
            // Step 3: Call API
            const result = await callLoginAPI(email, password);
            
            // Step 4: Handle response
            if (result.success === true) {
                // Save email if remember me is checked
                if (rememberCheckbox.checked) {
                    localStorage.setItem('adminEmail', email);
                } else {
                    localStorage.removeItem('adminEmail');
                }
                
                // Show success message
                showToast('Login successful! Redirecting to Dashboard...');
                
                // Redirect to admin dashboard
                setTimeout(() => {
                    window.location.href = result.redirect || 'AdminDashboard.php';
                }, 1000);
            } else {
                // Show error message from API
                const errorMsg = result.message || 'Invalid email or password';
                showToast(errorMsg, true);
                setLoading(false);
                
                // Clear password field on error for security
                passwordInput.value = '';
                
                // Highlight password field on error
                passwordInput.style.borderColor = '#ef4444';
                setTimeout(() => {
                    passwordInput.style.borderColor = '#e2e8f0';
                }, 2000);
            }
        }
        
        // ========== FORGOT PASSWORD HANDLER ==========
        function handleForgotPassword(event) {
            event.preventDefault();
            showToast('Please contact the system administrator to reset your password.', true);
        }
        
        // ========== REMOVE RED BORDER ON FOCUS ==========
        function removeRedBorder(e) {
            this.style.borderColor = '#e2e8f0';
        }
        
        // ========== EVENT LISTENERS ==========
        loginForm.addEventListener('submit', handleLogin);
        forgotLink.addEventListener('click', handleForgotPassword);
        emailInput.addEventListener('focus', removeRedBorder);
        passwordInput.addEventListener('focus', removeRedBorder);
        
        // ========== BAR ANIMATION ON LOAD ==========
        document.querySelectorAll('.bar').forEach(bar => {
            const height = bar.style.height;
            bar.style.height = '0';
            setTimeout(() => {
                bar.style.height = height;
            }, 100);
        });
        
        // ========== SMOOTH INPUT ANIMATIONS ==========
        const inputs = document.querySelectorAll('.input-wrapper input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-1px)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>