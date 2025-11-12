<?php
require_once '../includes/db-config.php';
require_once '../includes/functions.php';

// Check if user is logged in
requireLogin();

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['full_name'];
$first_letter = strtoupper(substr($user_name, 0, 1));

// Handle search and filter
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$filter = isset($_GET['filter']) ? sanitizeInput($_GET['filter']) : 'all';

// Build query
$query = "SELECT * FROM crops WHERE user_id = $user_id";

if (!empty($search)) {
    $query .= " AND (crop_name LIKE '%$search%' OR crop_type LIKE '%$search%')";
}

if ($filter !== 'all') {
    $query .= " AND status = '$filter'";
}

$query .= " ORDER BY created_at DESC";

$crops_result = mysqli_query($conn, $query);
$total_crops = mysqli_num_rows($crops_result);

// Get crop count
$crop_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM crops WHERE user_id = $user_id");
$crop_count = mysqli_fetch_assoc($crop_count_query)['total'];

// Success/Error messages
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Crops - Crop Management System</title>
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
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <div class="page-title">
                    <h1>My Crops 🌾</h1>
                    <p>Manage and track all your crops</p>
                </div>
                <div class="header-actions">
                    <a href="add.php" class="btn-dashboard">
                        <span>➕</span>
                        Add New Crop
                    </a>
                </div>
            </div>
            
            <?php if($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Crops Table -->
            <div class="table-container">
                <div class="table-header">
                    <h2 class="table-title">All Crops (<?php echo $total_crops; ?>)</h2>
                    <div class="table-actions">
                        <div class="search-box">
                            <form method="GET" action="">
                                <input type="text" name="search" placeholder="Search crops..." value="<?php echo htmlspecialchars($search); ?>">
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Filter Tags -->
                <div style="padding: 0 2rem 1rem;">
                    <div class="filter-tags">
                        <a href="?filter=all" class="filter-tag <?php echo $filter === 'all' ? 'active' : ''; ?>">
                            All Crops
                        </a>
                        <a href="?filter=planted" class="filter-tag <?php echo $filter === 'planted' ? 'active' : ''; ?>">
                            Planted
                        </a>
                        <a href="?filter=growing" class="filter-tag <?php echo $filter === 'growing' ? 'active' : ''; ?>">
                            Growing
                        </a>
                        <a href="?filter=harvested" class="filter-tag <?php echo $filter === 'harvested' ? 'active' : ''; ?>">
                            Harvested
                        </a>
                    </div>
                </div>
                
                <?php if($total_crops > 0): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Crop Name</th>
                            <th>Type</th>
                            <th>Area (Acres)</th>
                            <th>Planting Date</th>
                            <th>Harvest Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($crop = mysqli_fetch_assoc($crops_result)): ?>
                        <tr>
                            <td data-label="Crop Name">
                                <div class="crop-name-cell">
                                    <div class="crop-icon-small">🌾</div>
                                    <div class="crop-name-info">
                                        <h4><?php echo htmlspecialchars($crop['crop_name']); ?></h4>
                                        <p><?php echo htmlspecialchars($crop['crop_type']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Type"><?php echo htmlspecialchars($crop['crop_type']); ?></td>
                            <td data-label="Area"><?php echo number_format($crop['area_in_acres'], 2); ?></td>
                            <td data-label="Planting Date"><?php echo date('M d, Y', strtotime($crop['planting_date'])); ?></td>
                            <td data-label="Harvest Date"><?php echo date('M d, Y', strtotime($crop['expected_harvest_date'])); ?></td>
                            <td data-label="Status">
                                <span class="badge <?php echo $crop['status']; ?>">
                                    <?php echo ucfirst($crop['status']); ?>
                                </span>
                            </td>
                            <td data-label="Actions">
                                <div class="action-buttons">
                                    <a href="edit.php?id=<?php echo $crop['id']; ?>" class="btn-icon btn-edit" title="Edit">
                                        ✏️
                                    </a>
                                    <button onclick="confirmDelete(<?php echo $crop['id']; ?>)" class="btn-icon btn-delete" title="Delete">
                                        🗑️
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="empty-table">
                    <div class="empty-table-icon">🌾</div>
                    <h3>No crops found</h3>
                    <p>Start by adding your first crop to track and manage</p>
                    <a href="add.php" class="btn-dashboard">Add Your First Crop</a>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-icon">⚠️</div>
            <h3>Delete Crop?</h3>
            <p>Are you sure you want to delete this crop? This action cannot be undone.</p>
            <div class="modal-actions">
                <button onclick="closeModal()" class="btn-cancel">Cancel</button>
                <form id="deleteForm" method="POST" action="delete.php" style="flex: 1;">
                    <input type="hidden" name="crop_id" id="deleteCropId">
                    <button type="submit" class="btn-submit" style="width: 100%; background: var(--error);">Delete</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">☰</button>
    
    <script src="../assets/js/main.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
        
        function confirmDelete(cropId) {
            document.getElementById('deleteCropId').value = cropId;
            document.getElementById('deleteModal').classList.add('active');
        }
        
        function closeModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }
        
        // Close modal on outside click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>