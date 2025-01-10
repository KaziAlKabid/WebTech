<?php
if (!defined('SITE_NAME')) {
    include_once 'config/constants.php';
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
    <?php echo SITE_NAME; ?>
</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['user_role'])): ?>
    <li class="nav-item">
        <a class="nav-link active" href="router.php?controller=admin&action=dashboard">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="router.php?controller=admin&action=profile">
            Welcome, <?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="router.php?controller=auth&action=logout">Logout</a>
    </li>
<?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="router.php?controller=auth&action=login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="router.php?controller=auth&action=register">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
