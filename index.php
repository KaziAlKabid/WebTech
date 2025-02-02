<?php
require_once 'config/constants.php';
?>


<?php
session_start();
?>




<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="text-center">
        <h1>Welcome to <?= SITE_NAME ?></h1>
        <p>Your one-stop solution for managing lawyers, clients, and cases effectively.</p>
        <a href="router.php?controller=auth&action=login" class="btn btn-primary">Get Started</a>
    </div>
</div>

<?php include 'views/includes/footer.php'; ?>
