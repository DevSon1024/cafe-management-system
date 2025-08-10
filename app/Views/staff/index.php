<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Staff Management</h2>
<a href="/admin/staff/new" class="btn btn-primary mb-3">Add New Staff</a>
<?php if(session()->get('status')): ?>
    <div class="alert alert-success"><?= session()->get('status') ?></div>
<?php endif; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Shift</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($staff as $member): ?>
        <tr>
            <td><?= $member['id'] ?></td>
            <td><?= esc($member['name']) ?></td>
            <td><?= esc($member['role']) ?></td>
            <td><?= esc($member['shift']) ?></td>
            <td>
                <a href="/admin/staff/<?= $member['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                <form action="/admin/staff/<?= $member['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>