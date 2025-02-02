<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Your Reviews</h2>
    
    <?php if (empty($reviews)): ?>
        <p class="text-center text-muted">You have not given any reviews yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Case ID</th>
                        <th>Case Title</th>
                        <th>Lawyer</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Date</th>
                        <th>Action</th>    
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td><?= htmlspecialchars($review['case_id']) ?></td>
                            <td><?= htmlspecialchars($review['case_title']) ?></td>
                            <td><?= htmlspecialchars($review['lawyer_name']) ?></td>
                            <td><?= htmlspecialchars($review['rating']) ?> / 5</td>
                            <td><?= htmlspecialchars($review['review_text']) ?></td>
                            <td><?= htmlspecialchars($review['created_at']) ?></td>
                            <td>
                                <a href="router.php?controller=client&action=editReview&review_id=<?= $review['id'] ?>" class="btn btn-primary btn-sm me-2">Edit</a>
                            
                                <a href="#" class="btn btn-danger btn-sm delete-review" data-id="<?= $review['id'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<script type="module">
    import { handleDeleteReview } from '<?= SITE_URL ?>assets/js/client.js';
    handleDeleteReview(); // Initialize event listeners
</script>
<?php include 'views/includes/footer.php'; ?>
