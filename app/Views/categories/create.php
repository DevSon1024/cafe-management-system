<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Add New Category</h2>
<form action="/admin/categories" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?= $this->endSection() ?>