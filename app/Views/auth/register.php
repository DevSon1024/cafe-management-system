<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">Register</h4>
            </div>
            <div class="card-body">
                <?php if(session()->get('error')): ?>
                    <div class="alert alert-danger"><?= session()->get('error') ?></div>
                <?php endif; ?>
                <form action="/register" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Register</button>
                </form>
            </div>
             <div class="card-footer text-center">
                <p>Already have an account? <a href="/login">Login here</a></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>