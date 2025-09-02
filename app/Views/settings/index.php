<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Cafe Settings</h2>

<?php if(session()->get('status')): ?>
    <div class="alert alert-success"><?= session()->get('status') ?></div>
<?php endif; ?>

<form action="/admin/settings/update" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="cafe_name" class="form-label">Cafe Name</label>
        <input type="text" class="form-control" name="cafe_name" value="<?= esc($settings['cafe_name'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label for="gst_number" class="form-label">GST Number</label>
        <input type="text" class="form-control" name="gst_number" value="<?= esc($settings['gst_number'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea class="form-control" name="address" rows="3"><?= esc($settings['address'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" class="form-control" name="phone" value="<?= esc($settings['phone'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="<?= esc($settings['email'] ?? '') ?>">
    </div>
    <button type="submit" class="btn btn-primary">Save Settings</button>
</form>
<?= $this->endSection() ?>