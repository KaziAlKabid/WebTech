<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Centered and limited width -->
            <div class="card shadow-lg"> <!-- Adds a modern boxed look with shadow -->
                <div class="card-body">
                    <h3 class="text-center mb-4">Edit Review</h3>
                    <form id="edit-review-form">
                    <input type="hidden" id="review_id" value="<?= isset($review['id']) ? htmlspecialchars($review['id']) : '' ?>">

                        
                        <div class="mb-3">
                            <label for="rating" class="form-label" >Rating (1-5)</label>
                            <input type="number" id="rating" class="form-control" min="1" max="5" value="<?=htmlspecialchars($review['rating'])?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="review_text" class="form-label">Review</label>
                            <textarea id="review_text" class="form-control" rows="4"  required><?=htmlspecialchars($review['review_text'])?></textarea>
                        </div>

                        <div id="review-feedback" class="text-danger mb-3"></div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module">
    import { handleEditReview } from '<?= SITE_URL ?>assets/js/client.js';
    handleEditReview();
</script>
<?php include 'views/includes/footer.php'; ?>