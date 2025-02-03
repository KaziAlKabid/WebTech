<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center fw-bold">Admin Dashboard</h1>
    <hr>
  <!-- Dashboard Overview Cards -->
    <div class="row justify-content-center text-center mb-4">
        <div class="col-md-4">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-people"></i> Total Users</h5>
                    <p class="display-6"><?=$userCount?></p>
                    <small>Clients: <?=$clientCount?> | Lawyers: <?=$lawyerCount?> | Admins: <?=$adminCount?></small>
                    <a href="router.php?controller=admin&action=manageUsers" class="btn btn-primary w-100 mt-2">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-folder"></i> Total Cases</h5>
                    <p class="display-6"><?=$caseCount?></p>
                    <small>Pending: <?=$pendingCasesCount?> | Ongoing: <?=$ongoingCasesCount?> | Completed: <?=$completedCasesCount?></small>
                    <a href="router.php?controller=admin&action=manageCases" class="btn btn-success w-100 mt-2">Manage Cases</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-star"></i> Total Reviews</h5>
                    <p class="display-6"><?=$reviewCount?></p>
                    <a href="router.php?controller=admin&action=manageReviews" class="btn btn-warning w-100 mt-2">Manage Reviews</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <h5 class="mb-3"><i class="bi bi-person-check"></i> Recent Users</h5>
            <table class="table table-sm table-bordered table-hover">
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
                            <td><span class="badge bg-info"><?=ucfirst($user['role'])?></span></td>
                            <td><?=$user['creation_date']?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h5 class="mb-3"><i class="bi bi-clipboard-check"></i> Recent Cases</h5>
            <table class="table table-sm table-bordered table-hover">
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
                            <td>
                                <?php if ($case['status'] == 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif ($case['status'] == 'ongoing'): ?>
                                    <span class="badge bg-primary">Ongoing</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4 justify-content-center">
        <div class="col-md-3">
            <a href="router.php?controller=admin&action=manageUsers" class="btn btn-primary w-100">
                <i class="bi bi-people"></i> Manage Users
            </a>
        </div>
        <div class="col-md-3">
            <a href="router.php?controller=admin&action=manageCases" class="btn btn-success w-100">
                <i class="bi bi-folder"></i> Manage Cases
            </a>
        </div>
        <div class="col-md-3">
            <a href="router.php?controller=admin&action=manageReviews" class="btn btn-warning w-100">
                <i class="bi bi-star"></i> Manage Reviews
            </a>
        </div>
        <div class="col-md-3">
            <a href="router.php?controller=admin&action=managePayments" class="btn btn-info w-100">
                <i class="bi bi-credit-card"></i> View Transactions
            </a>
        </div>
    </div>
</div>


<?php include 'views/includes/footer.php'; ?>
