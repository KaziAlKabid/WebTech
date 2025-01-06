<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/validator@latest/validator.min.js"></script>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card border border-primary shadow-lg rounded-3">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Sign In</h3>
                    <form id="login-form">
                    
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div id="email-feedback" class="mt-2"></div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <div id="login-feedback" class="mt-2"></div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
</form>
                    <div class="text-center mt-3">
                        <p>Don't have an account? <a href="router.php?controller=auth&action=register">Register</a></p>
                    </div>
                    <div class="text-center mt-3">
                        <p>Forgot your password? <a href="router.php?controller=auth&action=forgot_password">Forgot password</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('email').addEventListener('input', function () {
    const email = this.value;
    const feedbackDiv = document.getElementById('email-feedback');

    // Clear feedback if email is empty
    if (!email) {
        feedbackDiv.innerText = '';
        feedbackDiv.className = '';
        return;
    }

    // Validate email format
    if (!validator.isEmail(email)) {
        feedbackDiv.innerText = 'Invalid email format.';
        feedbackDiv.className = 'text-danger mt-2';
        return; // Stop further processing if email format is invalid
    }

    // Call the server to check if the email exists
    fetch(`router.php?controller=auth&action=checkEmail&email=${encodeURIComponent(email)}`)
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                feedbackDiv.innerText = 'Email found. You can proceed to login.';
                feedbackDiv.className = 'text-success mt-2';
            } else {
                feedbackDiv.innerText = 'No account found with this email.';
                feedbackDiv.className = 'text-danger mt-2';
            }
        })
        .catch(error => {
            feedbackDiv.innerText = 'An error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-2';
        });
});
document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch('router.php?controller=auth&action=authenticate', {
        method: 'POST',
        body: formData,
    })
        .then(response => {
            if (!response.headers.get('content-type')?.includes('application/json')) {
                throw new Error('Invalid response from server');
            }
            return response.json();
        })
        .then(data => {
            const feedbackDiv = document.getElementById('login-feedback');

            if (data.success) {
                // Reset the login form
                this.reset();

                // Redirect to the specified URL
                window.location.href = data.redirect;
            } else {
                // Show specific feedback based on server response
                if (data.error === "email_not_found") {
                    feedbackDiv.innerText = 'User not found. Please register.';
                } else if (data.error === "wrong_password") {
                    feedbackDiv.innerText = 'Invalid password. Please try again.';
                } else {
                    feedbackDiv.innerText = 'An unexpected error occurred. Please try again.';
                }
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
<?php include 'views/includes/footer.php'; ?>
