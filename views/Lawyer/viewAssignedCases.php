<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h2>Assigned Cases</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Case ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Client</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assignedCases as $case) : ?>
                <tr id="case-row-<?= $case['id'] ?>">
                    <td><?= htmlspecialchars($case['id']) ?></td>
                    <td><?= htmlspecialchars($case['title']) ?></td>
                    <td><?= htmlspecialchars($case['description']) ?></td>
                    <td><?= htmlspecialchars($case['client_email']) ?></td>
                    <td><?= htmlspecialchars($case['status']) ?></td>
                    <td>
                        <?php if ($case['status'] === 'accepted') : ?>
                            <button class="btn btn-success complete-case-btn" data-case-id="<?= $case['id'] ?>">
                                Mark as Completed
                            </button>
                        <?php else : ?>
                            <span class="text-muted">Completed</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Import JavaScript -->
<script type="module">
    import { handleCompleteCase } from '<?= SITE_URL ?>assets/js/lawyer.js';
    handleCompleteCase(); // Initialize event listeners
</script>

<?php include 'views/includes/footer.php'; ?>
