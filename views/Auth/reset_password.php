<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border border-primary shadow-lg rounded-3">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Reset Password</h3>
                    <form id="reset-password-form" method="POST">
                        <input type="hidden" id="token" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password" required>
                        </div>
                        <div id="password-feedback" class="mt-2"> </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Enter your new password" required>
                        </div>
                        <div id="confirm-password-feedback" class="mt-2"></div>
                        <div id="reset-password-feedback" class="mt-2"></div>
                        <button id="reset-password-button" type="submit" class="btn btn-primary w-100">Reset Password</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import { handleResetPassword } from '<?= SITE_URL ?>assets/js/auth.js';
    handleResetPassword();
</script>

<?php include 'views/includes/footer.php'; ?>
