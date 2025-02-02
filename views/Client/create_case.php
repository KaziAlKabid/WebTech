<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <h2>Create a Case</h2>
    <div id="case-feedback" class="mt-2"></div>
    <form id="create-case-form">
        <div class="mb-3">
            <label for="title" class="form-label">Case Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Case Description</label>
            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Case</button>
    </form>
</div>

<script type="module">
    import { handleCreateCase } from '<?= SITE_URL ?>assets/js/client.js';
    handleCreateCase();
</script>

<?php include 'views/includes/footer.php'; ?>
