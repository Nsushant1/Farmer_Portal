<?php
// Set page info
$page_title = "My Crops";
$current_page = "crops";
$additional_css = "crop.css";

// Include sidebar (contains HTML head + sidebar)
include '../includes/sidebar.php';

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

// Success/Error messages
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!-- Main Content -->
<main class="main-content">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="page-title">
            <h1>My Crops <i class="fas fa-leaf"></i></h1>
            <p>Manage and track all your crops</p>
        </div>
        <div class="header-actions">
            <a href="add.php" class="btn-dashboard">
                <i class="fas fa-plus"></i> Add New Crop
            </a>
        </div>
    </div>
    
    <?php if($success): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if($error): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
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
                            <div class="crop-icon-small"><i class="fas fa-leaf"></i></div>
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
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete(<?php echo $crop['id']; ?>)" class="btn-icon btn-delete" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-table">
            <div class="empty-table-icon"><i class="fas fa-leaf" style="font-size: 4rem;"></i></div>
            <h3>No crops found</h3>
            <p>Start by adding your first crop to track and manage</p>
            <a href="add.php" class="btn-dashboard">Add Your First Crop</a>
        </div>
        <?php endif; ?>
    </div>
</main>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
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

<?php 
$additional_js = null; // No additional JS needed
include '../includes/sidebar-close.php'; 
?>

<script>
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