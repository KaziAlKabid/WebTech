<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border border-primary shadow-lg rounded-3">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Forgot Password</h3>
                    <form id="forgot-password-form" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            <div id="email-feedback" class="mt-2"></div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                        <div id="forgot-password-feedback" class="mt-2"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import { handleForgotPassword } from '<?= SITE_URL ?>assets/js/auth.js';
    handleForgotPassword();
  
</script>
<?php include 'views/includes/footer.php'; ?>
