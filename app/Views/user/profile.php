<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Profile</h1>
        <a href="/user/profile/edit" class="btn btn-primary">Edit Profile</a>
    </div>

    <?php if(session()->get('success')): ?>
        <div class="alert alert-success"><?= session()->get('success') ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Profile Information</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Name:</strong> <?= esc($user['name']) ?></li>
                <li class="list-group-item"><strong>Email:</strong> <?= esc($user['email']) ?></li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>My Order History</h5>
        </div>
        <div class="card-body">
            </div>
    </div>
</div>
<?= $this->endSection() ?>