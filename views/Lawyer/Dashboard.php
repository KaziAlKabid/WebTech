<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center fw-bold">Lawyer Dashboard</h2>
    <hr>

    <!-- Dashboard Cards -->
    <div class="row justify-content-center text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="bi bi-folder-plus"></i> See Unassigned Cases</h5>
                    <p class="card-text">View all unassigned cases.</p>
                    <a href="router.php?controller=case&action=viewUnassignedCases" class="btn btn-primary w-100">View Unassigned Cases</a>
            </div>
        </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="bi bi-clipboard-check"></i> See Accepted Cases</h5>
                    <p class="card-text">View all cases assigned to you.</p>
                    <a href="router.php?controller=case&action=viewAssignedCases" class="btn btn-success w-100">View Accepted Cases</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="bi bi-star"></i> See Reviews</h5>
                    <p class="card-text">View reviews for completed cases.</p>
                    <a href="router.php?controller=lawyer&action=viewReviews" class="btn btn-warning w-100">View Reviews</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'views/includes/footer.php'; ?>
