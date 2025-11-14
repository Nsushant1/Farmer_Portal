</div><!-- End dashboard-wrapper -->
    
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
    
    <script src="../assets/js/main.js"></script>
    <?php if(isset($additional_js)): ?>
        <script src="../assets/js/<?php echo $additional_js; ?>"></script>
    <?php endif; ?>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>