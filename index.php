<?php 
$page_title = "Home";
include 'includes/header.php'; 
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Smart Crop Management for Modern Farmers</h1>
                <p>Manage your crops efficiently, track growth cycles, and make data-driven decisions to maximize your harvest yields.</p>
                <div class="hero-buttons">
                    <a href="auth/register.php" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Get Started Free
                    </a>
                    <a href="auth/login.php" class="btn btn-outline">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div class="hero-image-placeholder">
                    <i class="fas fa-leaf" style="font-size: 8rem; color: rgba(255,255,255,0.3);"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2 class="section-title">Why Choose CropManage?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Crop Tracking</h3>
                <p>Monitor your crops from planting to harvest with detailed records and insights.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                <h3>Growth Analytics</h3>
                <p>Track crop growth patterns and make informed decisions based on historical data.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-spa"></i></div>
                <h3>Multiple Crops</h3>
                <p>Manage different crop types simultaneously with ease and efficiency.</p>
            </div>
            <!-- <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3>Easy Access</h3>
                <p>Access your farm data anytime, anywhere with our responsive platform.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-clock"></i></div>
                <h3>Harvest Planning</h3>
                <p>Plan your harvest schedule and get timely reminders for important dates.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Data Security</h3>
                <p>Your farm data is securely stored and protected with industry-standard security.</p>
            </div> -->
        </div>
    </div>
</section>

<section class="features" style="background: var(--bg-light);">
    <div class="container">
        <h2 class="section-title">How It Works</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-user-plus"></i></div>
                <h3>Create Account</h3>
                <p>Sign up in seconds and set up your farmer profile.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-plus-circle"></i></div>
                <h3>Add Your Crops</h3>
                <p>Enter details about your planted crops and growing areas.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-tasks"></i></div>
                <h3>Track Progress</h3>
                <p>Monitor and update crop status throughout the growing season.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>