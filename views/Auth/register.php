<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<!-- Load external libraries -->
<script src="https://cdn.jsdelivr.net/npm/validator@latest/validator.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/libphonenumber-js@1.9.51/bundle/libphonenumber-js.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/zxcvbn/dist/zxcvbn.js"></script>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border border-primary shadow-lg rounded-3">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Register</h3>
                       <!-- Feedback -->
                      
                    <form id="register-form" action="router.php?controller=auth&action=store" method="POST">
                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                            <div id="email-feedback" class="mt-2"></div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            <div id="password-feedback" class="mt-2"></div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                            <div id="confirm-password-feedback" class="mt-2"></div>
                        </div>

                        <!-- Address Field -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your address" required></textarea>
                            <div class="form-text">Please provide your full address.</div>
                        </div>

                        <!-- Phone Field -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                            <div id="phone-feedback" class="mt-2"></div>
                        </div>

                        <!-- Role Dropdown -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="" disabled selected>Select your role</option>
                                <option value="client">Client</option>
                                <option value="lawyer">Lawyer</option>
                            </select>
                        </div>
                        <div id="register-feedback" class="mt-3"></div>
                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </div>
                         

                     
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript Logic -->
<script>
    // Initialize validation flags
    let isEmailValid = false;
    let isPhoneValid = false;
    let isPasswordValid = false;
    let isConfirmPasswordValid = false;

    // Email Validation
    document.getElementById('email').addEventListener('input', function () {
        const email = this.value;
        const feedbackDiv = document.getElementById('email-feedback');
        isEmailValid = false;

        if (!email) {
            feedbackDiv.innerText = '';
            return;
        }

        if (!validator.isEmail(email)) {
            feedbackDiv.innerText = 'Invalid email format.';
            feedbackDiv.className = 'text-danger mt-2';
            return;
        }

        feedbackDiv.innerText = 'Valid email format. Checking availability...';
        feedbackDiv.className = 'text-success mt-2';

        fetch(`router.php?controller=auth&action=checkEmail&email=${encodeURIComponent(email)}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    feedbackDiv.innerText = 'Email is already taken.';
                    feedbackDiv.className = 'text-danger mt-2';
                } else {
                    feedbackDiv.innerText = 'Email is valid and available.';
                    feedbackDiv.className = 'text-success mt-2';
                    isEmailValid = true;
                }
            })
            .catch(() => {
                feedbackDiv.innerText = 'An error occurred. Please try again.';
                feedbackDiv.className = 'text-danger mt-2';
            });
    });

    // Password Validation
    const passwordInput = document.getElementById('password');
    const passwordFeedbackDiv = document.getElementById('password-feedback');
    passwordInput.addEventListener('input', function () {
        const password = passwordInput.value;
        isPasswordValid = false;

        if (!validator.isLength(password, { min: 8 })) {
            passwordFeedbackDiv.innerText = 'Password must be at least 8 characters long.';
            passwordFeedbackDiv.className = 'text-danger mt-2';
        } else if (!/[A-Z]/.test(password)) {
            passwordFeedbackDiv.innerText = 'Password must include at least one uppercase letter.';
            passwordFeedbackDiv.className = 'text-danger mt-2';
        } else if (!/[a-z]/.test(password)) {
            passwordFeedbackDiv.innerText = 'Password must include at least one lowercase letter.';
            passwordFeedbackDiv.className = 'text-danger mt-2';
        } else if (!/[0-9]/.test(password)) {
            passwordFeedbackDiv.innerText = 'Password must include at least one number.';
            passwordFeedbackDiv.className = 'text-danger mt-2';
        } else if (!/[!@#$%^&*]/.test(password)) {
            passwordFeedbackDiv.innerText = 'Password must include at least one special character (!@#$%^&*).';
            passwordFeedbackDiv.className = 'text-danger mt-2';
        } else {
            passwordFeedbackDiv.innerText = 'Strong password!';
            passwordFeedbackDiv.className = 'text-success mt-2';
            isPasswordValid = true;
        }
    });

    // Confirm Password Validation
    const confirmPasswordInput = document.getElementById('confirm-password');
    const confirmPasswordFeedbackDiv = document.getElementById('confirm-password-feedback');
    confirmPasswordInput.addEventListener('input', function () {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        isConfirmPasswordValid = false;

        if (!isPasswordValid) {
            confirmPasswordFeedbackDiv.innerText = 'Please enter a valid password first.';
            confirmPasswordFeedbackDiv.className = 'text-danger mt-2';
        } else if (!password) {
            confirmPasswordFeedbackDiv.innerText = 'Please enter a password first.';
            confirmPasswordFeedbackDiv.className = 'text-danger mt-2';
        } else if (confirmPassword !== password) {
            confirmPasswordFeedbackDiv.innerText = 'Passwords do not match.';
            confirmPasswordFeedbackDiv.className = 'text-danger mt-2';
        } else {
            confirmPasswordFeedbackDiv.innerText = 'Passwords match.';
            confirmPasswordFeedbackDiv.className = 'text-success mt-2';
            isConfirmPasswordValid = true;
        }
    });

    // Phone Validation
    const phoneInput = document.getElementById('phone');
const phoneFeedbackDiv = document.getElementById('phone-feedback');
let phoneCheckTimeout; // Timeout variable for debounce

phoneInput.addEventListener('input', () => {
    const phoneValue = phoneInput.value.trim();
    clearTimeout(phoneCheckTimeout); // Clear debounce timer

    // Reset feedback messages
    phoneFeedbackDiv.innerText = '';
    phoneFeedbackDiv.className = '';
    if (!phoneValue) {
        phoneFeedbackDiv.innerText = 'Field is empty';
        phoneFeedbackDiv.className = 'text-danger mt-2';
        return; // Stop further processing if the phone number is empty
    }

    // Validate phone format first
    try {
        const phoneNumber = libphonenumber.parsePhoneNumber(phoneValue, 'BD'); // Adjust region as needed
        if (phoneNumber.isValid()) {
            phoneFeedbackDiv.innerText = 'Valid phone number. Checking availability...';
            phoneFeedbackDiv.className = 'text-info mt-2';

            // Check availability only if the number is valid
            phoneCheckTimeout = setTimeout(() => {
                fetch(`router.php?controller=auth&action=checkPhone&phone=${encodeURIComponent(phoneValue)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            phoneFeedbackDiv.innerText = 'Phone number is already registered.';
                            phoneFeedbackDiv.className = 'text-danger mt-2';
                            
                        } else {
                            phoneFeedbackDiv.innerText = 'Phone number is valid and available.';
                            phoneFeedbackDiv.className = 'text-success mt-2';
                            isPhoneValid = true;
                        }
                    })
                    .catch(() => {
                        phoneFeedbackDiv.innerText = 'An error occurred while checking availability.';
                        phoneFeedbackDiv.className = 'text-danger mt-2';
                    });
            }, 500); // Debounce delay for availability check
        } else {
            phoneFeedbackDiv.innerText = 'Invalid phone number.';
            phoneFeedbackDiv.className = 'text-danger mt-2';
        }
    } catch {
        phoneFeedbackDiv.innerText = 'Invalid phone number format.';
        phoneFeedbackDiv.className = 'text-danger mt-2';
    }
});


    // Form Validation
    function validateForm() {
        if (!isEmailValid) {
            alert('Please enter a valid email.');
            return false;
        }
        if (!isPhoneValid) {
            alert('Please enter a valid phone number.');
            return false;
        }
        if (!isPasswordValid) {
            alert('Please enter a valid password.');
            return false;
        }
        if (!isConfirmPasswordValid) {
            alert('Passwords do not match.');
            return false;
        }
        return true;
    }

    // Form Submission

    document.getElementById('register-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission behavior

    if (!validateForm()) {
        return; // Exit if form validation fails
    }

    const formData = new FormData(this); // Collect form data

    fetch('router.php?controller=auth&action=store', {
        method: 'POST',
        body: formData, // Send the form data in the body
    })
        .then(response => {
            console.log('Response:', response); // Log the raw response for debugging
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`); // Handle HTTP errors
            }
            return response.json(); // Parse the response as JSON
        })
        .then(data => {
            console.log('Data:', data); // Log the parsed response data for debugging
            const feedbackDiv = document.getElementById('register-feedback');

            if (data.success) {
                // Show success message
                feedbackDiv.innerText = 'Registration successful! Redirecting to login page...';
                feedbackDiv.className = 'text-success mt-3';

                // Redirect after a delay (optional)
                setTimeout(() => {
                    window.location.href = 'router.php?controller=auth&action=login';
                }, 2000); // 2-second delay before redirect
            } else {
                // Show error message from the server response
                feedbackDiv.innerText = data.message || 'Registration failed. Please try again.';
                feedbackDiv.className = 'text-danger mt-3';
            }
        })
        .catch(error => {
            console.error('Error:', error); // Log the error for debugging
            const feedbackDiv = document.getElementById('register-feedback');
            feedbackDiv.innerText = 'An unexpected error occurred. Please try again.';
            feedbackDiv.className = 'text-danger mt-3';
        });
});




</script>


<?php include 'views/includes/footer.php'; ?>
    