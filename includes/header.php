<?php
require_once __DIR__ . '/db-config.php';
require_once __DIR__ . '/functions.php';

// Determine the base path dynamically
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
$folder = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$base_path = $protocol . "://" . $host . $folder;

// Calculate relative path to root
$depth = substr_count($_SERVER['SCRIPT_NAME'], '/') - substr_count($folder, '/');
$root_path = str_repeat('../', $depth);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Crop Management System</title>
    <link rel="stylesheet" href="<?php echo $root_path; ?>assets/css/style.css">
    <?php if(isset($additionalCSS)): ?>
        <link rel="stylesheet" href="<?php echo $root_path . $additionalCSS; ?>">
    <?php endif; ?>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="<?php echo BASE_URL; ?>" class="logo">
                    <div class="logo-icon">🌾</div>
                    <span>CropManage</span>
                </a>
                <nav>
                    <ul class="nav-menu">
                        <?php if(isLoggedIn()): ?>
                            <li><a href="<?php echo BASE_URL; ?>dashboard/">Dashboard</a></li>
                            <li><a href="<?php echo BASE_URL; ?>crops/">My Crops</a></li>
                            <li><a href="<?php echo BASE_URL; ?>auth/logout.php" class="btn btn-outline">Logout</a></li>
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