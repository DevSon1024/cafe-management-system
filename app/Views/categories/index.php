<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Menu Categories</h2>
<a href="/admin/categories/new" class="btn btn-primary mb-3">Add New Category</a>
<?php if(session()->get('status')): ?>
    <div class="alert alert-success"><?= session()->get('status') ?></div>
<?php endif; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($categories as $category): ?>
        <tr>
            <td><?= $category['id'] ?></td>
            <td><?= esc($category['name']) ?></td>
            <td>
                <div class="action-buttons">
                    <a href="/admin/categories/<?= $category['id'] ?>/edit" class="btn btn-edit">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="/admin/categories/<?= $category['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('This will delete the category AND all associated menu items. Are you sure?');">
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