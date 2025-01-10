<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Profile</h3>
                    
                    <!-- Profile Form -->
                    <form id="profile-form">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" readonly>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" readonly><?= htmlspecialchars($user['address']) ?></textarea>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" readonly>
                        </div>

                        <!-- Specialization (Only for Lawyers) -->
                        <?php if ($_SESSION['user_role'] === 'lawyer'): ?>
                            <div class="mb-3">
                                <label for="specialization" class="form-label">Specialization</label>
                                <input type="text" class="form-control" id="specialization" name="specialization" value="<?= htmlspecialchars($user['specialization'] ?? '') ?>" readonly>
                            </div>
                        <?php endif; ?>

                        <!-- Specialization (Only for Client) -->
                        <?php if ($_SESSION['user_role'] === 'client'): ?>
                            <div class="mb-3">
                                <label for="specialization" class="form-label">Specialization</label>
                                <input type="text" class="form-control" id="specialization" name="specialization" value="<?= htmlspecialchars($user['specialization'] ?? '') ?>" readonly>
                            </div>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <button type="button" id="edit-profile-btn" class="btn btn-warning">Edit Profile</button>
                            <button type="submit" id="save-profile-btn" class="btn btn-primary" style="display: none;">Save Changes</button>
                            <button type="button" id="cancel-edit-btn" class="btn btn-secondary" style="display: none;">Cancel</button>
                        </div>

                        <div id="profile-feedback" class="mt-3"></div> <!-- Feedback -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle Editable Mode
document.getElementById('edit-profile-btn').addEventListener('click', function () {
    const inputs = document.querySelectorAll('#profile-form input, #profile-form textarea');
    inputs.forEach(input => input.removeAttribute('readonly'));

    // Show Save and Cancel buttons, hide Edit button
    document.getElementById('save-profile-btn').style.display = 'inline-block';
    document.getElementById('cancel-edit-btn').style.display = 'inline-block';
    this.style.display = 'none';
});

// Cancel Editing
document.getElementById('cancel-edit-btn').addEventListener('click', function () {
    const inputs = document.querySelectorAll('#profile-form input, #profile-form textarea');
    inputs.forEach(input => input.setAttribute('readonly', true));

    // Hide Save and Cancel buttons, show Edit button
    document.getElementById('edit-profile-btn').style.display = 'inline-block';
    document.getElementById('save-profile-btn').style.display = 'none';
    this.style.display = 'none';
});

// Save Changes
document.getElementById('profile-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('router.php?controller=auth&action=updateProfile', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const feedbackDiv = document.getElementById('profile-feedback');

            if (data.success) {
                feedbackDiv.innerText = data.message;
                feedbackDiv.className = 'text-success';

                // Revert fields to readonly mode
                const inputs = document.querySelectorAll('#profile-form input, #profile-form textarea');
                inputs.forEach(input => input.setAttribute('readonly', true));

                // Hide Save and Cancel buttons, show Edit button
                document.getElementById('edit-profile-btn').style.display = 'inline-block';
                document.getElementById('save-profile-btn').style.display = 'none';
                document.getElementById('cancel-edit-btn').style.display = 'none';
            } else {
                feedbackDiv.innerText = data.message;
                feedbackDiv.className = 'text-danger';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const feedbackDiv = document.getElementById('profile-feedback');
            feedbackDiv.innerText = 'An unexpected error occurred.';
            feedbackDiv.className = 'text-danger';
        });
});
</script>

<?php include 'views/includes/footer.php'; ?>
