<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Admin Profile</h1>
        <a href="/admin/profile/edit" class="btn btn-primary">Edit Profile</a>
    </div>

    <?php if(session()->get('success')): ?>
        <div class="alert alert-success"><?= session()->get('success') ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Your Information</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Name:</strong> <?= esc($user['name']) ?></li>
                <li class="list-group-item"><strong>Email:</strong> <?= esc($user['email']) ?></li>
                <li class="list-group-item"><strong>Role:</strong> <?= ucfirst(esc($user['role'])) ?></li>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>All Registered Users</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($all_users as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= esc($u['name']) ?></td>
                        <td><?= esc($u['email']) ?></td>
                        <td><?= ucfirst(esc($u['role'])) ?></td>
                        <td><?= date('F j, Y', strtotime($u['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>