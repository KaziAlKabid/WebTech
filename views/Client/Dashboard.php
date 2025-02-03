<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center fw-bold">Client Dashboard</h2>
    <hr>

    <!-- Dashboard Cards -->
    <div class="row justify-content-center text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="bi bi-plus-circle"></i> Submit a Case</h5>
                    <p class="card-text">Submit a new case to the system.</p>
                    <a href="router.php?controller=client&action=createCase" class="btn btn-primary w-100">Submit Case</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="bi bi-folder"></i> Case History</h5>
                    <p class="card-text">View all your submitted cases.</p>
                    <a href="router.php?controller=client&action=viewCases" class="btn btn-success w-100">View Cases</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="bi bi-check-circle"></i> Completed Cases</h5>
                    <p class="card-text">View completed cases.</p>
                    <a href="router.php?controller=client&action=viewCompletedCases" class="btn btn-warning w-100">Show Completed Cases</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="bi bi-star"></i> Review History</h5>
                    <p class="card-text">View all your submitted reviews.</p>
                    <a href="router.php?controller=client&action=viewReviews" class="btn btn-info w-100">View Reviews</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'views/includes/footer.php'; ?>
