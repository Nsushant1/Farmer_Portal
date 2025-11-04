<footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About CropManage</h3>
                    <p>A comprehensive platform for farmers to manage their crops efficiently and make data-driven decisions for better yields.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>dashboard/">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>crops/">Crop Management</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>Email: support@cropmanage.com</p>
                    <p>Phone: +977 XXX-XXXXXXX</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> CropManage. All rights reserved. | BCA 4th Semester Project</p>
            </div>
        </div>
    </footer>
    
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
    <?php if(isset($additionalJS)): ?>
        <script src="<?php echo BASE_URL . $additionalJS; ?>"></script>
    <?php endif; ?>
</body>
</html>