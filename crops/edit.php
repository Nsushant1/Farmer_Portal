<?php
require_once '../includes/db-config.php';
require_once '../includes/functions.php';

// Check if user is logged in
requireLogin();

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['full_name'];
$first_letter = strtoupper(substr($user_name, 0, 1));

// Get crop ID
$crop_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($crop_id <= 0) {
    $_SESSION['error'] = "Invalid crop ID";
    header('Location: index.php');
    exit();
}

// Get crop details
$stmt = $conn->prepare("SELECT * FROM crops WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $crop_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Crop not found or access denied";
    header('Location: index.php');
    exit();
}

$crop = $result->fetch_assoc();
$stmt->close();

// Get crop count
$crop_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM crops WHERE user_id = $user_id");
$crop_count = mysqli_fetch_assoc($crop_count_query)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Crop - Crop Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/crop.css">
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
                        <a href="../dashboard/" class="menu-link">
                            <span class="menu-icon">📊</span>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="index.php" class="menu-link active">
                            <span class="menu-icon">🌾</span>
                            <span class="menu-text">My Crops</span>
                            <?php if($crop_count > 0): ?>
                                <span class="menu-badge"><?php echo $crop_count; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="add.php" class="menu-link">
                            <span class="menu-icon">➕</span>
                            <span class="menu-text">Add Crop</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="../dashboard/profile.php" class="menu-link">
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
            <div class="form-card">
                <div class="form-header">
                    <h1>Edit Crop ✏️</h1>
                    <p>Update crop information</p>
                </div>
                
                <form method="POST" action="process-crop.php" id="editCropForm">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="crop_id" value="<?php echo $crop['id']; ?>">
                    
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Crop Name <span>*</span></label>
                            <input type="text" name="crop_name" class="form-input" value="<?php echo htmlspecialchars($crop['crop_name']); ?>" required>
                        </div>
                        
                        <div>
                            <label class="form-label">Crop Type <span>*</span></label>
                            <select name="crop_type" class="form-input" required>
                                <option value="">Select Type</option>
                                <option value="Cereal" <?php echo $crop['crop_type'] == 'Cereal' ? 'selected' : ''; ?>>Cereal</option>
                                <option value="Vegetable" <?php echo $crop['crop_type'] == 'Vegetable' ? 'selected' : ''; ?>>Vegetable</option>
                                <option value="Fruit" <?php echo $crop['crop_type'] == 'Fruit' ? 'selected' : ''; ?>>Fruit</option>
                                <option value="Pulse" <?php echo $crop['crop_type'] == 'Pulse' ? 'selected' : ''; ?>>Pulse</option>
                                <option value="Oilseed" <?php echo $crop['crop_type'] == 'Oilseed' ? 'selected' : ''; ?>>Oilseed</option>
                                <option value="Cash Crop" <?php echo $crop['crop_type'] == 'Cash Crop' ? 'selected' : ''; ?>>Cash Crop</option>
                                <option value="Other" <?php echo $crop['crop_type'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Planting Date <span>*</span></label>
                            <input type="date" name="planting_date" class="form-input" value="<?php echo $crop['planting_date']; ?>" required>
                        </div>
                        
                        <div>
                            <label class="form-label">Expected Harvest Date <span>*</span></label>
                            <input type="date" name="expected_harvest_date" class="form-input" value="<?php echo $crop['expected_harvest_date']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Area (in Acres) <span>*</span></label>
                            <input type="number" name="area_in_acres" class="form-input" value="<?php echo $crop['area_in_acres']; ?>" step="0.01" min="0" required>
                        </div>
                        
                        <div>
                            <label class="form-label">Status <span>*</span></label>
                            <select name="status" class="form-input" required>
                                <option value="planted" <?php echo $crop['status'] == 'planted' ? 'selected' : ''; ?>>Planted</option>
                                <option value="growing" <?php echo $crop['status'] == 'growing' ? 'selected' : ''; ?>>Growing</option>
                                <option value="harvested" <?php echo $crop['status'] == 'harvested' ? 'selected' : ''; ?>>Harvested</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-grid form-grid-full">
                        <div>
                            <label class="form-label">Notes (Optional)</label>
                            <textarea name="notes" class="form-input" rows="4"><?php echo htmlspecialchars($crop['notes']); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <a href="index.php" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-submit">Update Crop</button>
                    </div>
                </form>
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
        
        // Form validation
        document.getElementById('editCropForm').addEventListener('submit', function(e) {
            const plantingDate = new Date(document.querySelector('input[name="planting_date"]').value);
            const harvestDate = new Date(document.querySelector('input[name="expected_harvest_date"]').value);
            
            if (harvestDate <= plantingDate) {
                e.preventDefault();
                alert('Harvest date must be after planting date!');
                return false;
            }
        });
    </script>
</body>
</html>