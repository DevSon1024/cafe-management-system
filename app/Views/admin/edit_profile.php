<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">Edit Admin Profile</h1>
    <div class="card">
        <div class="card-body">
            <?php if(session()->get('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                    <?php foreach (session()->get('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="/admin/profile/update" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="<?= esc(old('name', $user['name'])) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= esc(old('email', $user['email'])) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                    <input type="password" class="form-control" name="password">
                </div>
                 <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" name="password_confirm">
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="/admin/profile" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>