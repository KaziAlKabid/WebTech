<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
 <div class="row justify-content-center">
  <div class="col-md-6 col-lg-4">
   <div class="text-center mb-4">
    <h1 class="h3">Login</h1>
    <p class="text-muted">Enter your email and password to login.</p>
    <p>Don't have an account?
    <a href="router.php?controller=auth&action=register" class="text-primary text-decoration-none">Register here</a>.
    </p>
   </div>
   <div class="card shadow-lg">
    <div class="card-body">
        <form id="login-form">
        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                            <div id="email-feedback" class="mt-2"></div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>

                        <!-- Login Feedback -->
                        <div id="login-feedback" class="mt-2 text-center"></div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <div class="text-center mt-3">
                        <a href="router.php?controller=auth&action=forgot_password" class="text-primary text-decoration-none">Forgot password?</a>
                    </div>
                   
        </form>
    </div>
   </div>
  </div>
 </div>
</div>

<script type="module">
    import { handleLogin,} from '<?= SITE_URL ?>assets/js/auth.js';
    handleLogin();
    
</script>
<?php include 'views/includes/footer.php'; ?>
