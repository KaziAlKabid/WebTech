<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/validator@latest/validator.min.js"></script>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border border-primary shadow-lg rounded-3">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Forgot Password</h3>
                    <form id="forgot-password-form">
                        <div class="mb-3">
                            <label for="email" class="form-label">Enter your email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your registered email" required>
                            <div id="email-feedback" class="mt-2"></div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                    </form>
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

    // Validate email format on the client side
    if (!validator.isEmail(email)) {
        feedbackDiv.innerText = 'Invalid email format.';
        feedbackDiv.className = 'text-danger mt-2';
        return;
    }

    // Call the server to check if the email exists
    fetch('router.php?controller=auth&action=checkEmail', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ email: email }), // Send email as form data
    })
        .then(response => response.json()) // Parse JSON response
        .then(data => {
            if (data.exists) {
                feedbackDiv.innerText = 'Account found. You can proceed to reset your password.';
                feedbackDiv.className = 'text-success mt-2';
            } else {
                feedbackDiv.innerText = 'No account found with this email.';
                feedbackDiv.className = 'text-danger mt-2';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            feedbackDiv.innerText = 'An error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-2';
        });
});
document.getElementById('forgot-password-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const email = document.getElementById('email').value;
    const feedbackDiv = document.getElementById('email-feedback');

    // Clear feedback
    feedbackDiv.innerText = '';

    // Validate email format on client-side
    if (!validator.isEmail(email)) {
        feedbackDiv.innerText = 'Invalid email format.';
        feedbackDiv.className = 'text-danger';
        return;
    }

    // Send AJAX request to the server
    fetch('router.php?controller=auth&action=processForgotPassword', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ email: email }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display reset link
                feedbackDiv.innerHTML = `Reset link generated: <a href="${data.resetLink}" target="_blank">${data.resetLink}</a>`;
                feedbackDiv.className = 'text-success mt-2';
            } else {
                feedbackDiv.innerText = data.message || 'An error occurred.';
                feedbackDiv.className = 'text-danger mt-2';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            feedbackDiv.innerText = 'An unexpected error occurred.';
            feedbackDiv.className = 'text-danger mt-2';
        });
});


</script>
<?php include 'views/includes/footer.php'; ?>