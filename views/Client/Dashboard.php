<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Client Dashboard</h2>
    <hr>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Give Case</h5>
                    <p class="card-text">Submit a new case to the system.</p>
                    <a href="router.php?controller=client&action=createCase" class="btn btn-primary">Submit Case</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Case History</h5>
                    <p class="card-text">View all your submitted cases.</p>
                    <a href="router.php?controller=client&action=viewCases" class="btn btn-primary">View Cases</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Show Completed Cases</h5>
                    <p class="card-text">View completed cases.</p>
                    <a href="router.php?controller=client&action=viewCompletedCases" class="btn btn-primary">Show completed Cases</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Review History</h5>
                    <p class="card-text">View all your submitted reviews.</p>
                    <a href="router.php?controller=client&action=viewReviews" class="btn btn-primary">View Reviews</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/includes/footer.php'; ?>
