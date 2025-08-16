<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-lg-5 col-md-6 col-sm-8">
            <!-- Welcome Section -->
            <div class="text-center mb-4">
                <h2 class="text-gradient mb-2">Welcome Back! ☕</h2>
                <p class="text-muted">Sign in to your account to continue</p>
            </div>
            
            <div class="card hover-lift">
                <div class="card-header text-center">
                    <h4 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>Login
                    </h4>
                </div>
                <div class="card-body">
                    <?php if(session()->get('error')): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?= session()->get('error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if(session()->get('success')): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= session()->get('success') ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="/login" method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i>Email Address
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Enter your email"
                                   required>
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock me-1"></i>Password
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password"
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePasswordVisibility('password')">
                                    <i class="bi bi-eye-slash" id="password-icon"></i>
                                </button>
                                <div class="invalid-feedback">
                                    Please provide your password.
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-center">
                    <p class="mb-0 text-muted">
                        Don't have an account? 
                        <a href="/register" class="text-decoration-none fw-semibold">
                            Create one here
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Additional Info -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Your data is secure and protected
                </small>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    }
}
</script>

<?= $this->endSection() ?>