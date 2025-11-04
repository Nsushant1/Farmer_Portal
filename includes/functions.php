<?php
// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . 'auth/login.php');
        exit();
    }
}

// Redirect if already logged in
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header('Location: ' . BASE_URL . 'dashboard/');
        exit();
    }
}

// Sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Format date
function formatDate($date) {
    return date('F d, Y', strtotime($date));
}

// Get user name
function getUserName() {
    return isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'User';
}

// Display success message
function showSuccess($message) {
    return '<div class="alert alert-success">' . htmlspecialchars($message) . '</div>';
}

// Display error message
function showError($message) {
    return '<div class="alert alert-error">' . htmlspecialchars($message) . '</div>';
}

// Get crop status badge class
function getStatusBadge($status) {
    switch($status) {
        case 'planted':
            return 'badge-primary';
        case 'growing':
            return 'badge-warning';
        case 'harvested':
            return 'badge-success';
        default:
            return 'badge-secondary';
    }
}
?>