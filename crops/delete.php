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
$crop_id = isset($_POST['crop_id']) ? intval($_POST['crop_id']) : 0;

if ($crop_id <= 0) {
    $_SESSION['error'] = "Invalid crop ID";
    header('Location: index.php');
    exit();
}

// Verify crop ownership
$stmt = $conn->prepare("SELECT id FROM crops WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $crop_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Crop not found or access denied";
    $stmt->close();
    header('Location: index.php');
    exit();
}
$stmt->close();

// Delete crop
$stmt = $conn->prepare("DELETE FROM crops WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $crop_id, $user_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Crop deleted successfully!";
} else {
    $_SESSION['error'] = "Failed to delete crop. Please try again.";
}

$stmt->close();
header('Location: index.php');
exit();
?>