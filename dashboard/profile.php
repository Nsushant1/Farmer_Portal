<?php
// Set page info
$page_title = "Profile";
$current_page = "profile";

// Include sidebar (contains HTML head + sidebar)
include '../includes/sidebar.php';

// Get user details from database
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!-- Main Content -->
<main class="main-content">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="page-title">
            <h1>My Profile</h1>
            <p>Manage your account information</p>
        </div>
    </div>
    
    <!-- Profile Content -->
    <div class="content-grid">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Profile Information</h2>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="text-align: center; padding: 2rem;">
                    <div class="user-avatar" style="width: 120px; height: 120px; font-size: 3rem; margin: 0 auto 1rem;">
                        <?php echo $first_letter; ?>
                    </div>
                    <h2 style="color: var(--primary-dark); margin-bottom: 0.5rem;">
                        <?php echo htmlspecialchars($user['full_name']); ?>
                    </h2>
                    <p style="color: var(--text-light); text-transform: capitalize;">
                        <?php echo htmlspecialchars($user['role']); ?>
                    </p>
                </div>
                
                <div style="display: grid; gap: 1rem; padding: 0 2rem 2rem;">
                    <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                        <p style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 0.25rem;">
                            <i class="fas fa-envelope"></i> Email
                        </p>
                        <p style="font-weight: 600; color: var(--text-dark);">
                            <?php echo htmlspecialchars($user['email']); ?>
                        </p>
                    </div>
                    
                    <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                        <p style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 0.25rem;">
                            <i class="fas fa-phone"></i> Phone
                        </p>
                        <p style="font-weight: 600; color: var(--text-dark);">
                            <?php echo $user['phone'] ? htmlspecialchars($user['phone']) : 'Not provided'; ?>
                        </p>
                    </div>
                    
                    <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                        <p style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 0.25rem;">
                            <i class="fas fa-calendar-alt"></i> Member Since
                        </p>
                        <p style="font-weight: 600; color: var(--text-dark);">
                            <?php echo date('F d, Y', strtotime($user['created_at'])); ?>
                        </p>
                    </div>
                    
                    <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                        <p style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 0.25rem;">
                            <i class="fas fa-leaf"></i> Total Crops
                        </p>
                        <p style="font-weight: 600; color: var(--text-dark);">
                            <?php echo $crop_count; ?> crop<?php echo $crop_count != 1 ? 's' : ''; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Account Settings</h2>
            </div>
            
            <div class="quick-actions">
                <button class="action-btn" onclick="alert('Feature coming soon!')">
                    <div class="action-icon"><i class="fas fa-edit"></i></div>
                    <div class="action-text">
                        <h4>Edit Profile</h4>
                        <p>Update your information</p>
                    </div>
                </button>
                
                <button class="action-btn" onclick="alert('Feature coming soon!')">
                    <div class="action-icon"><i class="fas fa-lock"></i></div>
                    <div class="action-text">
                        <h4>Change Password</h4>
                        <p>Update your password</p>
                    </div>
                </button>
                
                <button class="action-btn" onclick="alert('Feature coming soon!')">
                    <div class="action-icon"><i class="fas fa-bell"></i></div>
                    <div class="action-text">
                        <h4>Notifications</h4>
                        <p>Manage notifications</p>
                    </div>
                </button>
                
                <a href="<?php echo BASE_URL; ?>auth/logout.php" class="action-btn">
                    <div class="action-icon"><i class="fas fa-sign-out-alt"></i></div>
                    <div class="action-text">
                        <h4>Logout</h4>
                        <p>Sign out securely</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/sidebar-close.php'; ?>