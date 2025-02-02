<?php
// Ensure constants are loaded
if (!defined('SITE_NAME')) {
    include_once 'config/constants.php'; // Include constants for site-wide configuration
}
?>

<!-- Navbar HTML -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <!-- Brand Name -->
        <a class="navbar-brand" href="index.php">
            <?php echo SITE_NAME; ?> <!-- Display the site name dynamically -->
        </a>

        <!-- Hamburger Menu (for small screens) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> <!-- Bootstrap's hamburger icon -->
        </button>

        <!-- Collapsible Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_role'])): ?> <!-- Check if a user is logged in -->
                    
                    <!-- Role-Specific Links -->
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="router.php?controller=admin&action=dashboard">Home</a> <!-- Admin dashboard -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="router.php?controller=admin&action=profile">
                                Welcome, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?> <!-- Display admin's name -->
                            </a>
                        </li>
                    <?php elseif ($_SESSION['user_role'] === 'client'): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="router.php?controller=client&action=dashboard">Home</a> <!-- Client dashboard -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="router.php?controller=client&action=profile">
                                Welcome, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?> <!-- Display client's name -->
                            </a>
                        </li>
                    <?php elseif ($_SESSION['user_role'] === 'lawyer'): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="router.php?controller=lawyer&action=dashboard">Home</a> <!-- Lawyer dashboard -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="router.php?controller=lawyer&action=profile">
                                Welcome, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?> <!-- Display lawyer's name -->
                            </a>
                        </li>
                    <?php endif; ?>
                    

                    <!-- Logout Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="router.php?controller=auth&action=logout">Logout</a> <!-- Logout action -->
                    </li>
                <?php else: ?>
<!-- Links for Guests -->
<li class="nav-item">
    <a href="router.php?controller=auth&action=login" class="btn btn-primary me-2">Login</a> <!-- Proper button styling -->
</li>
<li class="nav-item">
    <a class="btn text-dark fw-bold bg-warning px-3 rounded" href="router.php?controller=auth&action=register">Register</a> <!-- Styled similarly to a button -->
</li>



                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
