<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border border-primary shadow-lg rounded-3">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Reset Password</h3>
                    <form action="router.php?controller=auth&action=updatePassword" method="POST">
                        <!-- Hidden input to pass the reset token -->
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm new password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'views/includes/footer.php'; ?>