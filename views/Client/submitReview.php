<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card border border-primary shadow-lg rounded-3">
<div class="card-body">
<h3 class="card-title text-center mb-4">Submit Review</h3>
   
    <form id="review-form">
        <input type="hidden" id="case_id" value="<?= htmlspecialchars($_GET['case_id'] ?? '') ?>">
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <input type="number" id="rating" class="form-control" min="1" max="5" required>
        </div>
        <div class="mb-3">
            <label for="review_text" class="form-label">Review</label>
            <textarea id="review_text" class="form-control" rows="4" required></textarea>
        </div>
        <div id="review-feedback"></div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
</div>
</div>
</div>
</div>
</div>

<script type="module">
    import { handleSubmitReview } from '<?= SITE_URL ?>assets/js/client.js';
    handleSubmitReview();
</script>

<?php include 'views/includes/footer.php'; ?>
