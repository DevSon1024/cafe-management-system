<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <!-- Welcome Section -->
            <div class="text-center mb-4">
                <h2 class="text-gradient mb-2">Join The Code Cafe! ☕</h2>
                <p class="text-muted">Create your account to start ordering</p>
            </div>
            
            <div class="card hover-lift">
                <div class="card-header text-center">
                    <h4 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>Create Account
                    </h4>
                </div>
                <div class="card-body">
                    <?php if(session()->get('errors')): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                            <?php foreach (session()->get('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/register" method="post" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-1"></i>Full Name
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name"
                                   name="name" 
                                   value="<?= old('name') ?>" 
                                   placeholder="Enter your full name"
                                   required>
                            <div class="invalid-feedback">
                                Please provide your full name.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i>Email Address
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email"
                                   name="email" 
                                   value="<?= old('email') ?>" 
                                   placeholder="Enter your email address"
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
                                       name="password" 
                                       id="password" 
                                       placeholder="Create a strong password"
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePasswordVisibility('password')">
                                    <i class="bi bi-eye-slash" id="password-icon"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Password should be at least 8 characters long
                                </small>
                            </div>
                            <div class="invalid-feedback">
                                Please provide a password.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirm" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i>Confirm Password
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       name="password_confirm" 
                                       id="password_confirm" 
                                       placeholder="Confirm your password"
                                       required>
                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePasswordVisibility('password_confirm')">
                                    <i class="bi bi-eye-slash" id="password_confirm-icon"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                Please confirm your password.
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-person-check me-2"></i>
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-center">
                    <p class="mb-0 text-muted">
                        Already have an account? 
                        <a href="/login" class="text-decoration-none fw-semibold">
                            Sign in here
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Additional Info -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    By creating an account, you agree to our terms of service
                </small>
            </div>
        </div>
    </div>
</div>

<script>
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