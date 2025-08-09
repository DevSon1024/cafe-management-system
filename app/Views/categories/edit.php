<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Edit Category</h2>
<form action="/admin/categories/<?= $category['id'] ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control" name="name" value="<?= esc($category['name']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
<?= $this->endSection() ?>