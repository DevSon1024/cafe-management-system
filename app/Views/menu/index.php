<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Menu Management</h2>
<a href="/admin/menu/new" class="btn btn-primary mb-3">Add New Item</a>
<?php if(session()->get('status')): ?>
    <div class="alert alert-success"><?= session()->get('status') ?></div>
<?php endif; ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($items)): ?>
            <?php foreach($items as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><img src="/uploads/<?= esc($item['image']) ?>" width="80" style="object-fit: cover; height: 60px;"></td>
                <td><?= esc($item['name']) ?></td>
                <td><?= esc($item['category_name']) ?></td>
                <td>₹<?= number_format($item['price'], 2) ?></td>
                <td>
                   <div class="action-buttons">
                        <a href="/admin/menu/<?= $item['id'] ?>/edit" class="btn btn-edit">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="/admin/menu/<?= $item['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this menu item?');">
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
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">No menu items found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?= $this->endSection() ?>