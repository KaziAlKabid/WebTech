<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<!-- Load external libraries -->
<script src="<?= SITE_URL ?>assets/js/script.js"></script>


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
    <label for="role" class="form-label">Select Role</label>
    <select id="role" name="role" class="form-select" onchange="toggleFields()">
        <option value="client">Client</option>
        <option value="lawyer">Lawyer</option>
    </select>
</div>

<div id="lawyerFields" style="display: none;">
    <div class="mb-3">
        <label for="license" class="form-label">License Number</label>
        <input type="text" id="license" name="license" class="form-control">
    </div>
    <div class="mb-3">
        <label for="experience" class="form-label">Years of Experience</label>
        <input type="number" id="experience" name="experience" class="form-control" min="0">
    </div>
    <div class="mb-3">
        <label for="specialization" class="form-label">Specialization</label>
        <input type="text" id="specialization" name="specialization" class="form-control">
    </div>
</div>

                       
                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </div>
                        <div id="register-feedback" class="mt-3"></div>
                         

                     
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript Logic -->
<script type="module">
    import { handleRegister,} from '<?= SITE_URL ?>assets/js/auth.js';
    handleRegister();
   


  



</script>


<?php include 'views/includes/footer.php'; ?>
    