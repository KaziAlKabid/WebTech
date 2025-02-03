<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-body p-4">
            <h2 class="text-center fw-bold mb-3"><i class="bi bi-file-earmark-plus"></i> Create a Case</h2>
            
            <!-- Feedback Section (For Success/Error Messages) -->
            <div id="case-feedback" class="mt-2"></div>
            
            <form id="create-case-form">
                <!-- Case Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold"><i class="bi bi-tag"></i> Case Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter case title" required>
                </div>

                <!-- Case Description -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold"><i class="bi bi-chat-text"></i> Case Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Describe the case details..." required></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-send"></i> Submit Case
                </button>
            </form>
        </div>
    </div>
</div>


<script type="module">
    import { handleCreateCase } from '<?= SITE_URL ?>assets/js/client.js';
    handleCreateCase();
</script>

<?php include 'views/includes/footer.php'; ?>
