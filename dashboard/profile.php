<?php
require_once '../includes/db-config.php';
require_once '../includes/functions.php';

// Check if user is logged in
requireLogin();

// Get user info
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['full_name'];

// Get user details from database
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Get first letter for avatar
$first_letter = strtoupper(substr($user_name, 0, 1));

// Get crop count
$crop_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM crops WHERE user_id = $user_id");
$crop_count = mysqli_fetch_assoc($crop_count_query)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Crop Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="../index.php" class="sidebar-logo">
                    <div class="sidebar-logo-icon">🌾</div>
                    <div class="sidebar-logo-text">
                        <h2>CropManage</h2>
                        <p>Farm Management System</p>
                    </div>
                </a>
            </div>
            
            <div class="user-profile">
                <div class="user-avatar"><?php echo $first_letter; ?></div>
                <div class="user-info">
                    <h3><?php echo htmlspecialchars($user_name); ?></h3>
                    <p>Farmer</p>
                </div>
            </div>
            
            <nav>
                <ul class="sidebar-menu">
                    <li class="menu-item">
                        <a href="index.php" class="menu-link">
                            <span class="menu-icon">📊</span>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="../crops/index.php" class="menu-link">
                            <span class="menu-icon">🌾</span>
                            <span class="menu-text">My Crops</span>
                            <?php if($crop_count > 0): ?>
                                <span class="menu-badge"><?php echo $crop_count; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="../crops/add.php" class="menu-link">
                            <span class="menu-icon">➕</span>
                            <span class="menu-text">Add Crop</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="profile.php" class="menu-link active">
                            <span class="menu-icon">👤</span>
                            <span class="menu-text">Profile</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="../auth/logout.php" class="menu-link">
                            <span class="menu-icon">🚪</span>
                            <span class="menu-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
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
                                <p style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 0.25rem;">Email</p>
                                <p style="font-weight: 600; color: var(--text-dark);">
                                    <?php echo htmlspecialchars($user['email']); ?>
                                </p>
                            </div>
                            
                            <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                                <p style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 0.25rem;">Phone</p>
                                <p style="font-weight: 600; color: var(--text-dark);">
                                    <?php echo $user['phone'] ? htmlspecialchars($user['phone']) : 'Not provided'; ?>
                                </p>
                            </div>
                            
                            <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                                <p style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 0.25rem;">Member Since</p>
                                <p style="font-weight: 600; color: var(--text-dark);">
                                    <?php echo date('F d, Y', strtotime($user['created_at'])); ?>
                                </p>
                            </div>
                            
                            <div style="padding: 1rem; background: var(--bg-light); border-radius: 8px;">
                                <p style="color: var(--text-light); font-size: 0.85rem; margin-bottom: 0.25rem;">Total Crops</p>
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
                            <div class="action-icon">✏️</div>
                            <div class="action-text">
                                <h4>Edit Profile</h4>
                                <p>Update your information</p>
                            </div>
                        </button>
                        
                        <button class="action-btn" onclick="alert('Feature coming soon!')">
                            <div class="action-icon">🔒</div>
                            <div class="action-text">
                                <h4>Change Password</h4>
                                <p>Update your password</p>
                            </div>
                        </button>
                        
                        <button class="action-btn" onclick="alert('Feature coming soon!')">
                            <div class="action-icon">🔔</div>
                            <div class="action-text">
                                <h4>Notifications</h4>
                                <p>Manage notifications</p>
                            </div>
                        </button>
                        
                        <a href="../auth/logout.php" class="action-btn">
                            <div class="action-icon">🚪</div>
                            <div class="action-text">
                                <h4>Logout</h4>
                                <p>Sign out securely</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>
    
    <script src="../assets/js/main.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>