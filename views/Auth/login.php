<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card border border-primary shadow-lg rounded-3">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Sign In</h3>
                    <form id="login-form" action="router.php?controller=auth&action=authenticate" method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <div id="login-feedback" class="mt-2"></div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
</form>
<script>
document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch('router.php?controller=auth&action=authenticate', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json()) // Parse JSON response
        .then(data => {
            const feedbackDiv = document.getElementById('login-feedback');

            if (data.success) {
                // Reset the login form
                this.reset();

                // Redirect to the specified URL
                window.location.href = data.redirect;
            } else {
                // Display error message
                feedbackDiv.innerText = data.message || 'Login failed. Please try again.';
                feedbackDiv.className = 'text-danger';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const feedbackDiv = document.getElementById('login-feedback');
            feedbackDiv.innerText = 'An unexpected error occurred. Please try again.';
            feedbackDiv.className = 'text-danger';
        });
});
</script>


                    <div class="text-center mt-3">
                        <p>Don't have an account? <a href="router.php?controller=auth&action=register">Register</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'views/includes/footer.php'; ?>
