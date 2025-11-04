<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Clear remember me cookie
if (isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600, '/');
}

// Redirect to home page
header('Location: ../index.php');
exit();
?>