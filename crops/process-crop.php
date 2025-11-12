<?php
require_once '../includes/db-config.php';
require_once '../includes/functions.php';

// Check if user is logged in
requireLogin();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

// ADD CROP
if ($action === 'add') {
    // Get form data
    $crop_name = sanitizeInput($_POST['crop_name']);
    $crop_type = sanitizeInput($_POST['crop_type']);
    $planting_date = sanitizeInput($_POST['planting_date']);
    $expected_harvest_date = sanitizeInput($_POST['expected_harvest_date']);
    $area_in_acres = floatval($_POST['area_in_acres']);
    $status = sanitizeInput($_POST['status']);
    $notes = sanitizeInput($_POST['notes']);
    
    $errors = [];
    
    // Validate inputs
    if (empty($crop_name) || strlen($crop_name) < 2) {
        $errors[] = "Crop name must be at least 2 characters";
    }
    
    if (empty($crop_type)) {
        $errors[] = "Crop type is required";
    }
    
    if (empty($planting_date)) {
        $errors[] = "Planting date is required";
    }
    
    if (empty($expected_harvest_date)) {
        $errors[] = "Expected harvest date is required";
    }
    
    // Validate dates
    if (!empty($planting_date) && !empty($expected_harvest_date)) {
        if (strtotime($expected_harvest_date) <= strtotime($planting_date)) {
            $errors[] = "Harvest date must be after planting date";
        }
    }
    
    if ($area_in_acres <= 0) {
        $errors[] = "Area must be greater than 0";
    }
    
    if (!in_array($status, ['planted', 'growing', 'harvested'])) {
        $errors[] = "Invalid status";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO crops (user_id, crop_name, crop_type, planting_date, expected_harvest_date, area_in_acres, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssdss", $user_id, $crop_name, $crop_type, $planting_date, $expected_harvest_date, $area_in_acres, $status, $notes);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Crop added successfully!";
            $stmt->close();
            header('Location: index.php');
            exit();
        } else {
            $errors[] = "Failed to add crop. Please try again.";
        }
        $stmt->close();
    }
    
    // If errors, redirect back
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: add.php');
        exit();
    }
}

// EDIT CROP
elseif ($action === 'edit') {
    // Get form data
    $crop_id = intval($_POST['crop_id']);
    $crop_name = sanitizeInput($_POST['crop_name']);
    $crop_type = sanitizeInput($_POST['crop_type']);
    $planting_date = sanitizeInput($_POST['planting_date']);
    $expected_harvest_date = sanitizeInput($_POST['expected_harvest_date']);
    $area_in_acres = floatval($_POST['area_in_acres']);
    $status = sanitizeInput($_POST['status']);
    $notes = sanitizeInput($_POST['notes']);
    
    $errors = [];
    
    // Validate crop ownership
    $stmt = $conn->prepare("SELECT id FROM crops WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $crop_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Crop not found or access denied";
        header('Location: index.php');
        exit();
    }
    $stmt->close();
    
    // Validate inputs
    if (empty($crop_name) || strlen($crop_name) < 2) {
        $errors[] = "Crop name must be at least 2 characters";
    }
    
    if (empty($crop_type)) {
        $errors[] = "Crop type is required";
    }
    
    if (empty($planting_date)) {
        $errors[] = "Planting date is required";
    }
    
    if (empty($expected_harvest_date)) {
        $errors[] = "Expected harvest date is required";
    }
    
    // Validate dates
    if (!empty($planting_date) && !empty($expected_harvest_date)) {
        if (strtotime($expected_harvest_date) <= strtotime($planting_date)) {
            $errors[] = "Harvest date must be after planting date";
        }
    }
    
    if ($area_in_acres <= 0) {
        $errors[] = "Area must be greater than 0";
    }
    
    if (!in_array($status, ['planted', 'growing', 'harvested'])) {
        $errors[] = "Invalid status";
    }
    
    // If no errors, update database
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE crops SET crop_name = ?, crop_type = ?, planting_date = ?, expected_harvest_date = ?, area_in_acres = ?, status = ?, notes = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssssdssii", $crop_name, $crop_type, $planting_date, $expected_harvest_date, $area_in_acres, $status, $notes, $crop_id, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Crop updated successfully!";
            $stmt->close();
            header('Location: index.php');
            exit();
        } else {
            $errors[] = "Failed to update crop. Please try again.";
        }
        $stmt->close();
    }
    
    // If errors, redirect back
    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: edit.php?id=' . $crop_id);
        exit();
    }
}

// Invalid action
else {
    header('Location: index.php');
    exit();
}
?>