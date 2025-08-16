<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Table Management</h2>
<a href="/admin/tables/new" class="btn btn-primary mb-3">Add New Table</a>
<?php if(session()->get('status')): ?>
    <div class="alert alert-success"><?= session()->get('status') ?></div>
<?php endif; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Table Name / Number</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tables as $table): ?>
        <tr>
            <td><?= $table['id'] ?></td>
            <td><?= esc($table['name']) ?></td>
            <td>
                <span class="badge bg-<?= $table['status'] == 'Available' ? 'success' : 'danger' ?>">
                    <?= esc($table['status']) ?>
                </span>
            </td>
            <td>
                <div class="action-buttons">
                    <a href="/admin/tables/<?= $table['id'] ?>/edit" class="btn btn-edit">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="/admin/tables/<?= $table['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this table?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-delete">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>