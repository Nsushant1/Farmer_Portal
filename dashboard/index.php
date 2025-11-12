<?php
require_once '../includes/db-config.php';
require_once '../includes/functions.php';

// Check if user is logged in
requireLogin();

// Get user info
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['full_name'];

// Get statistics
$stats = [];

// Total crops
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM crops WHERE user_id = $user_id");
$stats['total_crops'] = mysqli_fetch_assoc($result)['total'];

// Planted crops
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM crops WHERE user_id = $user_id AND status = 'planted'");
$stats['planted'] = mysqli_fetch_assoc($result)['total'];

// Growing crops
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM crops WHERE user_id = $user_id AND status = 'growing'");
$stats['growing'] = mysqli_fetch_assoc($result)['total'];

// Harvested crops
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM crops WHERE user_id = $user_id AND status = 'harvested'");
$stats['harvested'] = mysqli_fetch_assoc($result)['total'];

// Get recent crops (last 5)
$recent_crops_query = "SELECT * FROM crops WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 5";
$recent_crops = mysqli_query($conn, $recent_crops_query);

// Get first letter for avatar
$first_letter = strtoupper(substr($user_name, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Crop Management System</title>
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
                        <a href="index.php" class="menu-link active">
                            <span class="menu-icon">📊</span>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="../crops/index.php" class="menu-link">
                            <span class="menu-icon">🌾</span>
                            <span class="menu-text">My Crops</span>
                            <?php if($stats['total_crops'] > 0): ?>
                                <span class="menu-badge"><?php echo $stats['total_crops']; ?></span>
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
                        <a href="profile.php" class="menu-link">
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
                    <h1>Welcome back, <?php echo htmlspecialchars(explode(' ', $user_name)[0]); ?>! 👋</h1>
                    <p>Here's what's happening with your farm today</p>
                </div>
                <div class="header-actions">
                    <a href="../crops/add.php" class="btn-dashboard">
                        <span>➕</span>
                        Add New Crop
                    </a>
                </div>
            </div>
            
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            🌾
                        </div>
                        <div class="stat-trend up">
                            <span>↑</span>
                            <span>100%</span>
                        </div>
                    </div>
                    <div class="stat-body">
                        <h3><?php echo $stats['total_crops']; ?></h3>
                        <p class="stat-label">Total Crops</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon info">
                            🌱
                        </div>
                    </div>
                    <div class="stat-body">
                        <h3><?php echo $stats['planted']; ?></h3>
                        <p class="stat-label">Planted</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon warning">
                            🌿
                        </div>
                    </div>
                    <div class="stat-body">
                        <h3><?php echo $stats['growing']; ?></h3>
                        <p class="stat-label">Growing</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            ✅
                        </div>
                    </div>
                    <div class="stat-body">
                        <h3><?php echo $stats['harvested']; ?></h3>
                        <p class="stat-label">Harvested</p>
                    </div>
                </div>
            </div>
            
            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Recent Crops -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Recent Crops</h2>
                        <a href="../crops/index.php" class="card-action">View All →</a>
                    </div>
                    
                    <?php if(mysqli_num_rows($recent_crops) > 0): ?>
                        <div class="crops-list">
                            <?php while($crop = mysqli_fetch_assoc($recent_crops)): ?>
                                <div class="crop-item">
                                    <div class="crop-icon">🌾</div>
                                    <div class="crop-details">
                                        <div class="crop-name"><?php echo htmlspecialchars($crop['crop_name']); ?></div>
                                        <div class="crop-meta">
                                            <?php echo htmlspecialchars($crop['crop_type']); ?> • 
                                            <?php echo $crop['area_in_acres']; ?> acres • 
                                            Planted on <?php echo date('M d, Y', strtotime($crop['planting_date'])); ?>
                                        </div>
                                    </div>
                                    <span class="crop-status <?php echo $crop['status']; ?>">
                                        <?php echo ucfirst($crop['status']); ?>
                                    </span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">🌾</div>
                            <h3>No crops yet</h3>
                            <p>Start by adding your first crop to track</p>
                            <a href="../crops/add.php" class="btn-dashboard">Add Your First Crop</a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Quick Actions</h2>
                    </div>
                    
                    <div class="quick-actions">
                        <a href="../crops/add.php" class="action-btn">
                            <div class="action-icon">➕</div>
                            <div class="action-text">
                                <h4>Add New Crop</h4>
                                <p>Register a new crop</p>
                            </div>
                        </a>
                        
                        <a href="../crops/index.php" class="action-btn">
                            <div class="action-icon">📋</div>
                            <div class="action-text">
                                <h4>View All Crops</h4>
                                <p>Manage your crops</p>
                            </div>
                        </a>
                        
                        <a href="profile.php" class="action-btn">
                            <div class="action-icon">👤</div>
                            <div class="action-text">
                                <h4>Edit Profile</h4>
                                <p>Update your information</p>
                            </div>
                        </a>
                        
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