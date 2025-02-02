<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h2>Your Case History</h2>
    <?php if (!empty($cases)): ?>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cases as $index => $case): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($case['title']) ?></td>
                            <td><?= htmlspecialchars($case['description']) ?></td>
                            <td>
                                <?php if ($case['status'] === 'pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php elseif ($case['status'] === 'accepted'): ?>
                                    <span class="badge bg-success">Accepted</span>
                                <?php elseif ($case['status'] === 'rejected'): ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php elseif($case['status']==='completed'): ?>
                                    <span class="badge bg-success">completed</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">unknown</span>   
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y, H:i', strtotime($case['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted">You have not submitted any cases yet.</p>
    <?php endif; ?>
</div>

<?php include 'views/includes/footer.php'; ?>
