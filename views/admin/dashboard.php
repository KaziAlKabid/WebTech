<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Admin Dashboard</h1>

    <!-- Summary Cards -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card border border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-6">123</p>
                    <a href="router.php?controller=admin&action=manageUsers" class="btn btn-primary">View Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Lawyers</h5>
                    <p class="card-text display-6">45</p>
                    <a href="router.php?controller=admin&action=manageLawyers" class="btn btn-success">View Lawyers</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border border-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Cases</h5>
                    <p class="card-text display-6">78</p>
                    <a href="router.php?controller=admin&action=manageCases" class="btn btn-warning">View Cases</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row">
        <div class="col-md-4">
            <a href="router.php?controller=admin&action=manageUsers" class="btn btn-primary w-100 mb-3">Manage Users</a>
        </div>
        <div class="col-md-4">
            <a href="router.php?controller=admin&action=manageLawyers" class="btn btn-success w-100 mb-3">Manage Lawyers</a>
        </div>
        <div class="col-md-4">
            <a href="router.php?controller=admin&action=manageCases" class="btn btn-warning w-100 mb-3">Manage Cases</a>
        </div>
    </div>
</div>

<?php include 'views/includes/footer.php'; ?>
