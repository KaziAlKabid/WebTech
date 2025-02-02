<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h3>Completed Cases</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Case Title</th>
                <th>Lawyer</th>
                <th>Status</th>
                <th>Action</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cases)): ?>
                <?php foreach ($cases as $case): ?>
    <tr>
        <td><?= htmlspecialchars($case['title']) ?></td>
        <td><?= htmlspecialchars($case['description']) ?></td>
        <td><?= htmlspecialchars($case['status']) ?></td>
        <td><?= htmlspecialchars($case['lawyer_name']) ?></td> <!-- Lawyer Name from JOIN -->
        <td>
                            <!-- Button to Write Review -->
                            <a href="router.php?controller=client&action=submitReview&case_id=<?= $case['id'] ?>" class="btn btn-primary btn-sm">
                                Write Review
                            </a>
                        </td>
    </tr>
<?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No completed cases found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'views/includes/footer.php'; ?>
