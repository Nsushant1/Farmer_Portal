<?php
require_once '../includes/db-config.php';
require_once '../includes/functions.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

$action = $_POST['action'] ?? '';

// REGISTRATION PROCESS
if ($action === 'register') {
    $full_name = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    $errors = [];
    
    // Validate inputs
    if (empty($full_name) || strlen($full_name) < 3) {
        $errors[] = "Full name must be at least 3 characters long";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (!empty($phone) && !preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Phone number must be 10 digits";
    }
    
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if email already exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors[] = "Email already registered";
        }
        $stmt->close();
    }
    
    // If no errors, create account
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, role) VALUES (?, ?, ?, ?, 'farmer')");
        $stmt->bind_param("ssss", $full_name, $email, $phone, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Account created successfully! Please login.";
            $stmt->close();
            header('Location: login.php');
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
        $stmt->close();
    }
    
    // If errors, redirect back with error message
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: register.php');
        exit();
    }
}

// LOGIN PROCESS
elseif ($action === 'login') {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);
    
    $errors = [];
    
    // Validate inputs
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // If no validation errors, check credentials
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, full_name, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
                // Set remember me cookie if checked
                if ($remember) {
                    setcookie('user_email', $email, time() + (86400 * 30), '/'); // 30 days
                }
                
                $stmt->close();
                
                // Redirect to dashboard
                header('Location: ../dashboard/');
                exit();
            } else {
                $errors[] = "Invalid email or password";
            }
        } else {
            $errors[] = "Invalid email or password";
        }
        $stmt->close();
    }
    
    // If errors, redirect back with error message
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: login.php');
        exit();
    }
}

// Invalid action
else {
    header('Location: login.php');
    exit();
}
?>