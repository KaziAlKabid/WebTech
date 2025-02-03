<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Admin Dashboard</h1>

    <div class="container">
    <!-- Dashboard Overview Cards -->
    <div class="row justify-content-center text-center mb-3">
    <div class="col-md-3">
        <div class="card border-primary shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="display-6"><?=$userCount?></p>
                <small>Clients: <?=$clientCount?> | Lawyers: <?=$lawyerCount?> | Admins: <?=$adminCount?></small>
                <a href="router.php?controller=admin&action=manageUsers" class="btn btn-primary mt-2">Manage Users</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Cases</h5>
                <p class="display-6"><?=$caseCount?></p>
                <small>Pending: <?=$pendingCasesCount?> | Ongoing: <?=$ongoingCasesCount?> | Completed: <?=$completedCasesCount?></small>
                <a href="router.php?controller=admin&action=manageCases" class="btn btn-success mt-2">Manage Cases</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-warning shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Reviews</h5>
                <p class="display-6"><?=$reviewCount?></p>
                <a href="router.php?controller=admin&action=manageReviews" class="btn btn-warning mt-2">Manage Reviews</a>
            </div>
        </div>
    </div>
</div>


    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <h5 class="mb-3">Recent Users</h5>
            <table class="table table-sm table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Registered On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentUsers as $user): ?>
                        <tr>
                            <td><?=htmlspecialchars($user['name'])?></td>
                            <td><?=ucfirst($user['role'])?></td>
                            <td><?=$user['creation_date']?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h5 class="mb-3">Recent Cases</h5>
            <table class="table table-sm table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Case ID</th>
                        <th>Client</th>
                        <th>Lawyer</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentCases as $case): ?>
                        <tr>
                            <td><?=$case['id']?></td>
                            <td><?=htmlspecialchars($case['client_email'])?></td>
                            <td><?=htmlspecialchars($case['lawyer_email'])?></td>
                            <td><?=$case['status']?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-md-3">
            <a href="router.php?controller=admin&action=manageUsers" class="btn btn-primary w-100">Manage Users</a>
        </div>
        <div class="col-md-3">
            <a href="router.php?controller=admin&action=manageCases" class="btn btn-success w-100">Manage Cases</a>
        </div>
        <div class="col-md-3">
            <a href="router.php?controller=admin&action=manageReviews" class="btn btn-warning w-100">Manage Reviews</a>
        </div>
        <div class="col-md-3">
            <a href="router.php?controller=admin&action=managePayments" class="btn btn-info w-100">View Transactions</a>
        </div>
    </div>
</div>

<?php include 'views/includes/footer.php'; ?>
