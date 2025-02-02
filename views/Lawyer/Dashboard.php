<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Lawyer Dashboard</h2>
    <hr>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">See Unassigned Cases</h5>
                    <p class="card-text">View all unassigned cases.</p>
                    <a href="router.php?controller=case&action=viewUnassignedCases" class="btn btn-primary">View Unassigned Cases</a>

                </div>
            </div>
        </div>
        </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">See All accepted Cases</h5>
                    <p class="card-text">View all cases assigned to you.</p>
                    <a href="router.php?controller=case&action=viewAssignedCases" class="btn btn-primary">View Accepted Cases</a>
                </div>
            </div>
        </div>

     

        <div class="col-md-6 mb-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">See Reviews</h5>
                    <p class="card-text">View reviews for completed cases.</p>
                    <a href="router.php?controller=lawyer&action=viewReviews" class="btn btn-primary">View Reviews</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/includes/footer.php'; ?>
