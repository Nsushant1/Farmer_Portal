<?php
// Sidebar with Full HTML Wrapper for Dashboard Pages
// Make sure to set these variables before including:
// - $page_title (required) - e.g., "Dashboard", "My Crops"
// - $current_page (required) - e.g., "dashboard", "crops", "add-crop", "profile"
// - $additional_css (optional) - e.g., "crop.css"

require_once __DIR__ . '/db-config.php';
require_once __DIR__ . '/functions.php';

// Check if user is logged in
requireLogin();

// Get user info
$user_name = $_SESSION['full_name'] ?? 'User';
$user_id = $_SESSION['user_id'];
$first_letter = strtoupper(substr($user_name, 0, 1));

// Get crop count for badge
$crop_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM crops WHERE user_id = $user_id");
$crop_count = mysqli_fetch_assoc($crop_count_query)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?> - Crop Management System</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <?php if(isset($additional_css)): ?>
        <link rel="stylesheet" href="../assets/css/<?php echo $additional_css; ?>">
    <?php endif; ?>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="<?php echo BASE_URL; ?>" class="sidebar-logo">
                    <div class="sidebar-logo-icon"><i class="fas fa-seedling"></i></div>
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
                        <a href="<?php echo BASE_URL; ?>dashboard/" class="menu-link <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
                            <span class="menu-icon"><i class="fas fa-chart-line"></i></span>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo BASE_URL; ?>crops/" class="menu-link <?php echo ($current_page == 'crops') ? 'active' : ''; ?>">
                            <span class="menu-icon"><i class="fas fa-leaf"></i></span>
                            <span class="menu-text">My Crops</span>
                            <?php if($crop_count > 0): ?>
                                <span class="menu-badge"><?php echo $crop_count; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo BASE_URL; ?>crops/add.php" class="menu-link <?php echo ($current_page == 'add-crop') ? 'active' : ''; ?>">
                            <span class="menu-icon"><i class="fas fa-plus-circle"></i></span>
                            <span class="menu-text">Add Crop</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo BASE_URL; ?>dashboard/profile.php" class="menu-link <?php echo ($current_page == 'profile') ? 'active' : ''; ?>">
                            <span class="menu-icon"><i class="fas fa-user"></i></span>
                            <span class="menu-text">Profile</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo BASE_URL; ?>auth/logout.php" class="menu-link">
                            <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                            <span class="menu-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>