<?php
require_once '../includes/db-config.php';
require_once '../includes/functions.php';

// Check if user is logged in
requireLogin();

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['full_name'];
$first_letter = strtoupper(substr($user_name, 0, 1));

// Get crop count
$crop_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM crops WHERE user_id = $user_id");
$crop_count = mysqli_fetch_assoc($crop_count_query)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Crop - Crop Management System</title>
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
                        <a href="index.php" class="menu-link">
                            <span class="menu-icon">🌾</span>
                            <span class="menu-text">My Crops</span>
                            <?php if($crop_count > 0): ?>
                                <span class="menu-badge"><?php echo $crop_count; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="add.php" class="menu-link active">
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
                    <h1>Add New Crop 🌱</h1>
                    <p>Fill in the details to register a new crop</p>
                </div>
                
                <form method="POST" action="process-crop.php" id="addCropForm">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Crop Name <span>*</span></label>
                            <input type="text" name="crop_name" class="form-input" placeholder="e.g., Rice, Wheat, Corn" required>
                        </div>
                        
                        <div>
                            <label class="form-label">Crop Type <span>*</span></label>
                            <select name="crop_type" class="form-input" required>
                                <option value="">Select Type</option>
                                <option value="Cereal">Cereal</option>
                                <option value="Vegetable">Vegetable</option>
                                <option value="Fruit">Fruit</option>
                                <option value="Pulse">Pulse</option>
                                <option value="Oilseed">Oilseed</option>
                                <option value="Cash Crop">Cash Crop</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Planting Date <span>*</span></label>
                            <input type="date" name="planting_date" class="form-input" required>
                        </div>
                        
                        <div>
                            <label class="form-label">Expected Harvest Date <span>*</span></label>
                            <input type="date" name="expected_harvest_date" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Area (in Acres) <span>*</span></label>
                            <input type="number" name="area_in_acres" class="form-input" placeholder="0.00" step="0.01" min="0" required>
                        </div>
                        
                        <div>
                            <label class="form-label">Status <span>*</span></label>
                            <select name="status" class="form-input" required>
                                <option value="planted">Planted</option>
                                <option value="growing">Growing</option>
                                <option value="harvested">Harvested</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-grid form-grid-full">
                        <div>
                            <label class="form-label">Notes (Optional)</label>
                            <textarea name="notes" class="form-input" placeholder="Add any additional notes about this crop..." rows="4"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <a href="index.php" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-submit">Add Crop</button>
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
        
        // Set today as default planting date
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="planting_date"]').value = today;
            
            // Set harvest date 3 months from now as default
            const harvestDate = new Date();
            harvestDate.setMonth(harvestDate.getMonth() + 3);
            document.querySelector('input[name="expected_harvest_date"]').value = harvestDate.toISOString().split('T')[0];
        });
        
        // Form validation
        document.getElementById('addCropForm').addEventListener('submit', function(e) {
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