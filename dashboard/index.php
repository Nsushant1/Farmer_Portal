<?php
// Set page info
$page_title = "Dashboard";
$current_page = "dashboard";

// Include sidebar (contains HTML head + sidebar)
include '../includes/sidebar.php';

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
?>

<!-- Main Content -->
<main class="main-content">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="page-title">
            <h1>Welcome back, <?php echo htmlspecialchars(explode(' ', $user_name)[0]); ?>!</h1>
            <p>Here's what's happening with your farm today</p>
        </div>
        <div class="header-actions">
            <a href="../crops/add.php" class="btn-dashboard">
                <i class="fas fa-plus"></i> Add New Crop
            </a>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon primary">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
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
                    <i class="fas fa-seedling"></i>
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
                    <i class="fas fa-spa"></i>
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
                    <i class="fas fa-check-circle"></i>
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
                <a href="<?php echo BASE_URL; ?>crops/" class="card-action">View All →</a>
            </div>
            
            <?php if(mysqli_num_rows($recent_crops) > 0): ?>
                <div class="crops-list">
                    <?php while($crop = mysqli_fetch_assoc($recent_crops)): ?>
                        <div class="crop-item">
                            <div class="crop-icon"><i class="fas fa-leaf"></i></div>
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
                    <div class="empty-state-icon"><i class="fas fa-leaf" style="font-size: 4rem;"></i></div>
                    <h3>No crops yet</h3>
                    <p>Start by adding your first crop to track</p>
                    <a href="<?php echo BASE_URL; ?>crops/add.php" class="btn-dashboard">Add Your First Crop</a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Quick Actions</h2>
            </div>
            
            <div class="quick-actions">
                <a href="<?php echo BASE_URL; ?>crops/add.php" class="action-btn">
                    <div class="action-icon"><i class="fas fa-plus-circle"></i></div>
                    <div class="action-text">
                        <h4>Add New Crop</h4>
                        <p>Register a new crop</p>
                    </div>
                </a>
                
                <a href="<?php echo BASE_URL; ?>crops/" class="action-btn">
                    <div class="action-icon"><i class="fas fa-list"></i></div>
                    <div class="action-text">
                        <h4>View All Crops</h4>
                        <p>Manage your crops</p>
                    </div>
                </a>
                
                <a href="<?php echo BASE_URL; ?>dashboard/profile.php" class="action-btn">
                    <div class="action-icon"><i class="fas fa-user-circle"></i></div>
                    <div class="action-text">
                        <h4>Edit Profile</h4>
                        <p>Update your information</p>
                    </div>
                </a>
                
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