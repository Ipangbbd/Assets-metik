<?php
include('assets/frontend/includes/header.php');
?>
<div class="container">
    <div class="card mx-auto">
        <div class="card-header text-center py-3">
            <h3>Log In</h3>
        </div>
        <div class="card-body p-4">
            <form action="assets/backend/api/userdata/login.php" method="post">
                <!-- Email field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                </div>

                <!-- Password field -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                </div>

                <!-- Remember me checkbox -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                    <a href="#" class="float-end">Forgot password?</a>
                </div>

                <!-- Submit button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary py-2">Log In</button>
                </div>
            </form>

            <!-- Register link -->
            <div class="text-center mt-3">
                <p class="mb-0">Don't have an account? <a href="assets/frontend/includes/user-side/register.php">Register</a></p>
            </div>
        </div>
    </div>
</div>

<?php
include('assets/frontend/includes/footer.php')
?>