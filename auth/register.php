<?php
require_once '../includes/db-config.php';
require_once '../includes/functions.php';

// Redirect if already logged in
redirectIfLoggedIn();

$error = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Crop Management System</title>
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
                    <div class="auth-side-icon">🌱</div>
                    <h2>Join CropManage Today</h2>
                    <p>Create your account and start managing your crops like a professional farmer.</p>
                    <ul class="auth-features">
                        <li>Free account setup</li>
                        <li>Unlimited crop tracking</li>
                        <li>Real-time monitoring</li>
                        <li>Expert recommendations</li>
                        <li>Secure data storage</li>
                    </ul>
                </div>
            </div>
            
            <!-- Right Side - Registration Form -->
            <div class="auth-form-section">
                <div class="auth-form-header">
                    <h1>Create Your Account</h1>
                    <p>Fill in your details to get started</p>
                </div>
                
                <?php if($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="process-auth.php" id="registerForm">
                    <input type="hidden" name="action" value="register">
                    
                    <div class="form-group">
                        <label for="full_name">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" placeholder="John Doe" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="your@email.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="9876543210" maxlength="10">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Create a strong password" required>
                        <div class="password-strength">
                            <div class="password-strength-bar"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password *</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Re-enter your password" required>
                    </div>
                    
                    <div class="form-options">
                        <div class="checkbox-group">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">I agree to Terms & Conditions</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-auth">Create Account</button>
                    
                    <div class="auth-divider">OR</div>
                    
                    <div class="auth-footer">
                        Already have an account? <a href="login.php">Login Here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/form-validation.js"></script>
</body>
</html>