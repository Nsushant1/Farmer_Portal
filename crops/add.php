<?php
// Set page info
$page_title = "Add Crop";
$current_page = "add-crop";
$additional_css = "crop.css";

// Include sidebar (contains HTML head + sidebar)
include '../includes/sidebar.php';
?>

<!-- Main Content -->
<main class="main-content">
    <div class="form-card">
        <div class="form-header">
            <h1>Add New Crop <i class="fas fa-seedling"></i></h1>
            <p>Fill in the details to register a new crop</p>
        </div>
        
        <form method="POST" action="process-crop.php" id="addCropForm">
            <input type="hidden" name="action" value="add">
            
            <div class="form-grid">
                <div>
                    <label class="form-label"><i class="fas fa-leaf"></i> Crop Name <span>*</span></label>
                    <input type="text" name="crop_name" class="form-input" placeholder="e.g., Rice, Wheat, Corn" required>
                </div>
                
                <div>
                    <label class="form-label"><i class="fas fa-list"></i> Crop Type <span>*</span></label>
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
                    <label class="form-label"><i class="fas fa-calendar-alt"></i> Planting Date <span>*</span></label>
                    <input type="date" name="planting_date" class="form-input" required>
                </div>
                
                <div>
                    <label class="form-label"><i class="fas fa-calendar-check"></i> Expected Harvest Date <span>*</span></label>
                    <input type="date" name="expected_harvest_date" class="form-input" required>
                </div>
            </div>
            
            <div class="form-grid">
                <div>
                    <label class="form-label"><i class="fas fa-ruler-combined"></i> Area (in Acres) <span>*</span></label>
                    <input type="number" name="area_in_acres" class="form-input" placeholder="0.00" step="0.01" min="0" required>
                </div>
                
                <div>
                    <label class="form-label"><i class="fas fa-info-circle"></i> Status <span>*</span></label>
                    <select name="status" class="form-input" required>
                        <option value="planted">Planted</option>
                        <option value="growing">Growing</option>
                        <option value="harvested">Harvested</option>
                    </select>
                </div>
            </div>
            
            <div class="form-grid form-grid-full">
                <div>
                    <label class="form-label"><i class="fas fa-sticky-note"></i> Notes (Optional)</label>
                    <textarea name="notes" class="form-input" placeholder="Add any additional notes about this crop..." rows="4"></textarea>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="index.php" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit"><i class="fas fa-plus-circle"></i> Add Crop</button>
            </div>
        </form>
    </div>
</main>

<?php include '../includes/sidebar-close.php'; ?>

<script>
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