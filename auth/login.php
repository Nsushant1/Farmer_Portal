<?php
require_once '../includes/db-config.php';
require_once '../includes/functions.php';

// Redirect if already logged in
redirectIfLoggedIn();

$error = '';
$success = '';

// Check for success message from registration
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Crop Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <!-- Left Side - Information -->
            <div class="auth-side">
                <div class="auth-side-content">
                    <a href="../index.php" class="auth-back-link">← Back to Home</a>
                    <div class="auth-side-icon">🌾</div>
                    <h2>Welcome Back!</h2>
                    <p>Login to access your crop management dashboard and continue growing smarter.</p>
                    <ul class="auth-features">
                        <li>Track your crops in real-time</li>
                        <li>Manage multiple farms</li>
                        <li>Get harvest predictions</li>
                        <li>Access agricultural insights</li>
                    </ul>
                </div>
            </div>
            
            <!-- Right Side - Login Form -->
            <div class="auth-form-section">
                <div class="auth-form-header">
                    <h1>Login to Your Account</h1>
                    <p>Enter your credentials to access your dashboard</p>
                </div>
                
                <?php if($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="process-auth.php" id="loginForm">
                    <input type="hidden" name="action" value="login">
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="your@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    
                    <div class="form-options">
                        <div class="checkbox-group">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="btn-auth">Login</button>
                    
                    <div class="auth-divider">OR</div>
                    
                    <div class="auth-footer">
                        Don't have an account? <a href="register.php">Create Account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/form-validation.js"></script>
</body>
</html>