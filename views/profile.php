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
                        <div id="email-feedback"></div>

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
<script type="module">
    import { handleEditProfile } from '<?= SITE_URL ?>assets/js/profile.js';
    handleEditProfile();
</script>


<?php include 'views/includes/footer.php'; ?>
