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
                   <a href="/menu/<?= $item['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>

                    <form action="/menu/<?= $item['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('This will delete the category AND all associated menu items. Are you sure?');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
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