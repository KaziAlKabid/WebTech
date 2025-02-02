<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h3 class="text-center">Unassigned Cases</h3>
    <div id='updated-case-feedback'></div>
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cases)): ?>
                <?php foreach ($cases as $case): ?>
                    <tr>
                        <td><?= htmlspecialchars($case['id']) ?></td>
                        <td><?= htmlspecialchars($case['title']) ?></td>
                        <td><?= htmlspecialchars($case['description']) ?></td>
                        <td><?= htmlspecialchars($case['status']) ?></td>
                        <td>
                            <button 
                             class="btn btn-success btn-sm accept-case-btn" 
                         data-id="<?= $case['id'] ?>">Accept</button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No unassigned cases found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script type="module">
    import { handleAcceptCase } from '<?= SITE_URL ?>assets/js/lawyer.js';
    handleAcceptCase(); // Initialize the event listeners
</script>

<?php include 'views/includes/footer.php'; ?>
