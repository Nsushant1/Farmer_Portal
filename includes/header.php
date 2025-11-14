<?php
// Header for Public/Landing Pages
require_once __DIR__ . '/db-config.php';
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Crop Management System</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="<?php echo BASE_URL; ?>" class="logo">
                    <div class="logo-icon"><i class="fas fa-leaf"></i></div>
                    <span>CropManage</span>
                </a>
                <nav>
                    <ul class="nav-menu">
                        <?php if(isLoggedIn()): ?>
                            <li><a href="<?php echo BASE_URL; ?>dashboard/"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                            <li><a href="<?php echo BASE_URL; ?>crops/"><i class="fas fa-leaf"></i> My Crops</a></li>
                            <li><a href="<?php echo BASE_URL; ?>auth/logout.php" class="btn btn-outline"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                            <li><a href="<?php echo BASE_URL; ?>auth/login.php">Login</a></li>
                            <li><a href="<?php echo BASE_URL; ?>auth/register.php" class="btn btn-primary">Get Started</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>