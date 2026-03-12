<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <div class="sidebar-header">
        <a href="../index.php" title="Go to Website">
            <img src="../fonts/logo.png" alt="Apollo" class="sidebar-logo">
        </a>
    </div>
    <ul class="sidebar-nav">
        <li><a href="index.php" class="<?php echo $current_page === 'index.php' ? 'active' : ''; ?>"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="video-pool.php" class="<?php echo $current_page === 'video-pool.php' ? 'active' : ''; ?>"><i class="fas fa-database"></i> Video Pool</a></li>
        <li><a href="artists.php" class="<?php echo $current_page === 'artists.php' ? 'active' : ''; ?>"><i class="fas fa-users"></i> Artists</a></li>
        <li><a href="roster.php" class="<?php echo $current_page === 'roster.php' ? 'active' : ''; ?>"><i class="fas fa-list"></i> Roster</a></li>
        <li><a href="landing-page.php" class="<?php echo $current_page === 'landing-page.php' ? 'active' : ''; ?>"><i class="fas fa-film"></i> Landing Page</a></li>
        <li><a href="crm.php" class="<?php echo $current_page === 'crm.php' ? 'active' : ''; ?>"><i class="fas fa-tasks"></i> Project CRM</a></li>
        <li><a href="settings.php" class="<?php echo $current_page === 'settings.php' ? 'active' : ''; ?>"><i class="fas fa-cog"></i> Settings</a></li>
        <li><a href="sync.php" class="<?php echo $current_page === 'sync.php' ? 'active' : ''; ?>"><i class="fas fa-sync"></i> Sync to Website</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>
